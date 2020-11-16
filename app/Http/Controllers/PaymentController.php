<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Payment;
use Redirect;
use Session;
use Response;
use Cart;
use App\Models\Category;
use App\Models\Setting;
use Mail;

class PaymentController extends Controller
{
    public $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }

    public function index()
    {
        return view('fronted.pages.payment');
    }

    public function charge(Request $request)
    {
        //$data['email']= $request->email;
        //$data['uniqueId']= 'dsfdfdf';
        //return view('fronted.emails.email', $data);
        //exit; 
        if ($request->input('submit')) {
            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $request->input('amount'),
                    'currency' => env('PAYPAL_CURRENCY'),
                    'returnUrl' => url('paymentsuccess'),
                    'cancelUrl' => url('paymenterror'),
                ))->send();
                // Order Script start
                $checkemail = DB::table('tbl_customer')
                    ->where('email', $request->email)
                    ->first();
                if ($request->create_account == "yes") {
                    if (empty($checkemail)) {
                        $uniqueId = uniqid();
                        $data = array(
                            'customer_name'   => $request->f_name . ' ' . $request->l_name,
                            'mobile'          => $request->phone,
                            'email'           => $request->email,
                            'country'         => $request->country,
                            'address'         => $request->address,
                            'customer_username' => $request->customer_username,
                            'customer_password' =>  md5($request->customer_password),
                            'create_account'    => $request->create_account,
                            'regis_date'        => date("Y-m-d"),
                            'status'            => 1
                        );
                        $customerId = DB::table('tbl_customer')->insertGetId($data);
                        //Send user registration email;
                        $data['uniqueId'] = $uniqueId;
                        $data['email'] = $request->email; //$req->email;
                        Mail::send('fronted.emails.email', $data, function ($message) use ($data) {
                            $message->from('registration@xpesos.com', 'xpesos.com customer credentials');
                            $message->to($data['email'])->cc(['mdbijon@gmail.com']);
                            $message->subject("xpesos.com customer credentials.");
                        });
                    } else {
                        $customerId = $checkemail->customer_id;
                    }
                } else {
                    $customerId = $checkemail->customer_id;
                }

                $dadd = array(
                    'customer_id'      => $customerId,
                    'address1'         => 'address1',
                    'address2'         => 'address2',
                    'shippingOption'   => $request->shippingOption,
                    'ship_diff_address' => $request->ship_diff_address
                );
                DB::table('tbl_shipping')->insertGetId($dadd);

                $data = array();
                $orderdata = array();
                $maxId = DB::table('tbl_order')->max('order_id');
                if (!empty($maxId)) {
                    $orderdata['OrderId'] = sprintf('%06d', $maxId + 1);
                } else {
                    $orderdata['OrderId'] = '000001';
                }

                $orderdata = array(
                    'customer_id'        => $customerId,
                    'OrderId'            => $orderdata['OrderId'],
                    'order_date'         => date("Y-m-d"),
                    'status'             => '1',
                    'total_amt' => $request->input('amount')
                );
                $orderId = DB::table('tbl_order')->insertGetId($orderdata);


                $cartData = Cart::getContent();
                $orderdata = array();
                $data = array();
                foreach ($cartData as $value) {
                    $orderdata['order_id'] = $orderId;
                    $orderdata['product_id'] = $value->id;
                    $orderdata['quantity'] = $value->quantity;
                    $orderdata['price'] = $value->price;
                    $orderdata['order_create_sts'] = 2;
                    $orderdata['cus_price'] = $value->price;
                    //Customer display price
                    if (!empty($value->attributes->has('size'))) {
                        $size = json_encode($value->attributes->size);
                        if (!empty($size)) {
                            $orderdata['size'] = str_replace('"', "", "$size");
                        }
                    } else {
                        $orderdata['size'] = "";
                    }
                    DB::table('tbl_order_details')->insert($orderdata);
                }
                Cart::clear();
                //End Order  

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    return $response->getMessage();
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function payment_success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();

                // Insert transaction data into the database
                $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();

                if (!$isPaymentExist) {
                    $payment = new Payment;
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = env('PAYPAL_CURRENCY');
                    $payment->payment_status = $arr_body['state'];
                    DB::table('payments')->insertGetId($payment);
                }
                Cart::clear();
                $data['success'] = "Payment is successful. Your transaction id is: " . $arr_body['id'];
                $data['category'] = Category::all();
                $data['setting'] = Setting::first();
                return view('fronted.pages.successpage', $data);
            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }
    }

    public function payment_error()
    {
        return 'User is canceled the payment.';
    }
}

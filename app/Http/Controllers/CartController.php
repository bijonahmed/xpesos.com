<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function add_to_cart(Request $request)
    {

        $qty = $request->qty;
        if ($request->toppart) {
            $size = $request->toppart;
        } elseif ($request->bottompart) {
            $size = $request->bottompart;
        } elseif ($request->shoe_size) {
            $size = $request->shoe_size;
        } else {
            $size = "";
        }

        $productInfo = DB::table('tbl_product')->where('product_id', $request->product_id)->first();
        $data = array();
        $data['id'] = $productInfo->product_id;
        $data['name'] = $productInfo->product_name;
        $data['price'] = $productInfo->special_price;
        $data['quantity'] = $qty;
        $data['brand'] = $productInfo->pro_brand_name;
        $data['attributes'] = array(
            'size' => $size,
        );
        Cart::add($data);
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['category'] = DB::table('tbl_category')->where('status', 1)->get();
        return view('fronted.pages.cart.cart', $data);
    }

    public function viewCart(Request $request)
    {
        $data['title'] = "View Cart";
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['category'] = DB::table('tbl_category')->where('status', 1)->get();
        return view('fronted.pages.cart.cart', $data);
    }

    public function vendorUpdateCart(Request $request)
    {
        $quantity = $request->quantity;
        $rowid = $request->id;
        Cart::update($rowid, array(
            'quantity' => array(
                'relative' => false,
                'value' => $quantity,
            ),
        ));
        return redirect('/store-show-cart');
    }
    public function UpdateCart(Request $request)
    {
        $quantity = $request->quantity;
        $rowid = $request->id;
        Cart::update($rowid, array(
            'quantity' => array(
                'relative' => false,
                'value' => $quantity,
            ),
        ));
        return redirect('/view-cart');
    }

    public function deleteProduct($id)
    {
        Cart::remove($id, 0);
        return redirect('/view-cart');
    }

    public function ItemdeleteProduct($id)
    {
        Cart::remove($id, 0);
        return redirect('/store-show-cart');
    }

    public function showCart()
    {
        $data = array();
        $data['category'] = DB::table('tbl_category')->where('status', 1)->get();
        return view('fronted.pages.cart.addtocart', $data);
    }

    public function StoreShowCart()
    {
        $data = array();
        $data['category'] = DB::table('tbl_category')->where('status', 1)->get();
        return view('vendor.addtocart', $data);
    }
}

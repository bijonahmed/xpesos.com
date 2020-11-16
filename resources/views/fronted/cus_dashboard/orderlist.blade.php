@extends('fronted.master')
@section('title','Order List')
@section('maincontent')

<div class="container">

    <div class="row" style="margin: 30px 0px;">
        <div class="col-md-3">
            <ul class="list-group">
                @include('fronted.cus_dashboard.sidebar')
            </ul>
        </div>
        <div class="col-md-9">

            <div class="table-responsive active">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-center">SL#</td>
                            <td class="text-center">Order ID</td>
                            <td class="text-center">Status</td>
                            <td class="text-center">Order Date</td>
                            <td class="text-right">Total</td>
                            <td>Details</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $x = 1;
                        $sum = 0;


                        foreach ($order as $item) {
                            $orders = DB::table('tbl_order_details')->where('order_id', $item->order_id)->get();
                            foreach ($orders as $od) {
                                $totals = $od->price;
                                $quantity = $od->quantity ?  $od->quantity : $od->quantity * 1;
                                $subtotal = $totals * $quantity;
                                $sum += $subtotal;
                            }
                        ?>

                            <tr>
                                <td class="text-center"><?php
                                                        echo $x;
                                                        $x++;
                                                        ?></td>
                                <td class="text-center">{{$item->OrderId}}</td>
                                <td class="text-center"><?php
                                                        $status = $item->status;
                                                        if ($status == 1) {
                                                            echo "Recived Order";
                                                        } elseif ($status == 2) {
                                                            echo "Confirm Order";
                                                        } elseif ($status == 3) {
                                                            echo "Shipped Order";
                                                        } elseif ($status == 4) {
                                                            echo "Complete Order";
                                                        } elseif ($status == 5) {
                                                            echo "Cancel Order";
                                                        } elseif ($status == 6) {
                                                            echo "Hold Order";
                                                        }
                                                        ?></td>
                                <td class="text-right">
                                    <?php echo date("d-m-Y", strtotime($item->order_date)); ?></td>
                                <td class="text-right">

                                    <?php
                                    if (isset($sum)) {
                                        echo number_format($sum);
                                    }
                                    ?>
                                </td>

                                <td class="text-center"><a class="btn btn-info" title="" data-toggle="tooltip" href="{{url('/customer-order-details/'.$item->OrderId)}}" data-original-title="View"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
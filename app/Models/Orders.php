<?php

namespace App\Models;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'tbl_order';
    public $timestamps = false;

    protected static function totalOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function recivedOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 1)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function confirmOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 2)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function shippedOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 3)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function completeOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 4)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function cancelOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 5)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function holdOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 6)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }

    protected static function returnOrders($today, $role_id, $user_id)
    {
        if ($role_id == 1) {
            return DB::table((new static)->getTable())->where('order_date', $today)->count();
        } else {
            return DB::table((new static)->getTable())->where('status', 7)->where('order_date', $today)->where('tbl_order.seller_id', $user_id)->count();
        }
    }
}

<?php

namespace App\Models;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Product extends Model
{
	protected $table = 'tbl_product';
	public $timestamps = false;

	protected static function topSelling()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 1)->orderBy('product_id', 'asc')->get();
		return $query;
	}

	protected static function todayDeal()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 2)->orderBy('product_id', 'asc')->get();
		return $query;
	}

	protected static function selectedItem()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 3)->orderBy('product_id', 'asc')->get();
		return $query;
	}

	protected static function globalFestival()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 4)->orderBy('product_id', 'asc')->get();
		return $query;
	}

	protected static function womenFashion()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 5)->orderBy('product_id', 'asc')->get();
		return $query;
	}


	protected static function homeOffice()
	{
		$query = Product::select('tbl_product.special_price', 'tbl_product.slug', 'tbl_product.regular_price', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_product.product_name', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
			->where('tbl_product.status', 1)->where('tbl_product_special.special_cat_id', 6)->orderBy('product_id', 'asc')->get();
		return $query;
	}

	protected static function countingProduct()
	{

		$user_id = Session::get('user_id');
		$role_id = Session::get('role_id');

		if ($role_id == 1) {
			$t_product = DB::table('tbl_product')->count();
		} else {
			$t_product = DB::table('tbl_product')->where('tbl_product.user_id', $user_id)->count();
		}

		return $t_product;
	}

	public static function getSellerProduct($user_id)
	{
		return $data = DB::table('tbl_product')
			->select('tbl_user.company', 'tbl_product.batch', 'tbl_product.api_id', 'tbl_product.regular_price', 'tbl_product.stock_quantity', 'tbl_product.percentage', 'tbl_product.photo1', 'tbl_product.product_code', 'tbl_sub_in_sub_cat_name.sub_in_sub_cat_name', 'tbl_category.category_name', 'tbl_subcategory.sub_cat_name', 'tbl_product.product_name', 'tbl_product.entry_date', 'tbl_product.product_id', 'tbl_product.status')
			->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
			->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
			->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
			->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
			->where('tbl_product.user_id', $user_id)
			->orderBy('tbl_product.product_id', 'desc')
			->get();
	}
}

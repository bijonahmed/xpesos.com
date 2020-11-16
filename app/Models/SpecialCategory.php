<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialCategory extends Model
{
     protected $table = 'tbl_special_category';
     public $timestamps = false;

     public static function getTopSelling()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 1)->first();
          return $query;
     }

     public static function getTodayDeal()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 2)->first();
          return $query;
     }

     public static function getSelectedItems()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 3)->first();
          return $query;
     }

     public static function getGlobalFestival()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 4)->first();
          return $query;
     }

     public static function getWomenFasion()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 5)->first();
          return $query;
     }


     public static function getHomeOffice()
     {
          $query = SpecialCategory::select('tbl_special_category.special_cat_id', 'tbl_special_category.slug', 'tbl_special_category.sp_category_name')
               ->where('tbl_special_category.status', 1)->where('tbl_special_category.special_cat_id', 6)->first();
          return $query;
     }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
     protected $table = 'tbl_category';
     public $timestamps = false;

     public static function getFeaturesCategory()
     {
          return DB::table('tbl_post')->where('menu_id', 5)->where('status', 1)->orderBy('tbl_post.post_id', 'asc')->get();
     }

     public static function getSubCategory()
     {
          return DB::table('tbl_subcategory')->where('status', 1)->orderBy('tbl_subcategory.sub_cat_id', 'desc')->get();
     }

     public static function insubCategory()
     {
          return DB::table('tbl_sub_in_sub_cat_name')->where('status', 1)->orderBy('tbl_sub_in_sub_cat_name.sub_in_sub_id', 'desc')->get();
     }

     public static function categoryList($text)
     {

          $sql = "SELECT * FROM tbl_category WHERE 1";
          if (!empty($text != '')) {
               $sql .= " AND `category_name` LIKE '%$text%'";
          }
          $sql .= " ORDER BY category_id DESC LIMIT 100";
          $results = DB::select($sql);
          return $results;
     }

     public static function insubcategoryList($text)
     {

          $sql = "SELECT category_name,sub_cat_name,sub_in_sub_cat_name,tbl_sub_in_sub_cat_name.status,sub_in_sub_id FROM tbl_sub_in_sub_cat_name
                  LEFT JOIN tbl_category ON tbl_category.category_id=tbl_sub_in_sub_cat_name.category_id
                  LEFT JOIN tbl_subcategory ON tbl_subcategory.sub_cat_id=tbl_sub_in_sub_cat_name.sub_cat_id
           WHERE 1";

          if (!empty($text != '')) {
               $sql .= " AND `sub_in_sub_cat_name` LIKE '%$text%'";
               $sql .= " OR `category_name` LIKE '%$text%'";
               $sql .= " OR `sub_cat_name` LIKE '%$text%'";
          }

          $sql .= " ORDER BY sub_in_sub_id DESC LIMIT 100";
          $results = DB::select($sql);
          return $results;
     }
}

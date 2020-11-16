<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use Response;
use Cart;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\SpecialCategory;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $data = array(
            'slider' => Slider::all(),
            'setting' => Setting::first(),
            'brand'=> Brand::where('status', 1)->get(),
            'top_selling' => Product::topSelling(),
            'today_deal' => Product::todayDeal(),
            'selected_Items' => Product::selectedItem(),
            'global_festival' =>  Product::globalFestival(),
            'women_fashion' => Product::womenFashion(),
            'home_office' => Product::homeOffice(),
            'topselling_row' => SpecialCategory::getTopSelling(),
            'todaydeal_row' => SpecialCategory::getTodayDeal(),
            'selectedItems_row' => SpecialCategory::getSelectedItems(),
            'global_festival_row' => SpecialCategory::getGlobalFestival(),
            'women_fashion_row' => SpecialCategory::getWomenFasion(),
            'home_office_row' => SpecialCategory::getHomeOffice(),
            'category' => Category::all(),
            'fcategory' => Category::getFeaturesCategory(),
            'bannersetting' => Setting::first()
         );
        return view('fronted.child', $data);
    }

    public function sellOnXpesos()
    {
        $data = array();
        $data['title'] = "Sell on Xpesos";
        $data['category'] = Category::all();
        $data['slider'] = Slider::all();
        $data['setting'] =  Setting::first();
        return view('fronted.pages.sellonxpesos', $data);
    }

    public function trackyourorder()
    {
        $data = array();
        $data['title'] = "Track your order";
        $data['category'] = Category::all();
        $data['slider'] = Slider::all();
        $data['setting'] =  Setting::first();
        return view('fronted.pages.trackyourorder', $data);
    }

    public function addtocart()
    {
        $data = array();
        $data['title'] = "Add to cart";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        return view('fronted.pages.cart.cart', $data);
    }

    public function checkout()
    {
        $data = array();
        $data['title'] = "Checkout";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        return view('fronted.pages.checkout', $data);
    }

    public function storelist()
    {
        $data = array();
        $data['title'] = "Store List";
        $data['storelist'] = DB::table('tbl_user')->where('role_id', 2)->where('status', 1)->orderBy('user_id', 'desc')->get();
        $data['allstorelist'] = DB::table('tbl_user')->where('role_id', 2)->where('status', 1)->orderBy('user_id', 'desc')->get();
        return view('vendor.storelist', $data);
    }

    public function faqlist()
    {

        $data = array();
        $data['title'] = "FAQ";
        $data['data'] = DB::table('tbl_post')->where('menu_id', 5)->where('status', 1)->first();
        return view('fronted.pages.commonpage', $data);
    }

    public function storedetails($slug)
    {

        $data = array();
        $data['storerow'] = DB::table('tbl_user')->where('company_slug', $slug)->where('role_id', 2)->where('status', 1)->first();
        $data['category'] =  Category::all();
        $data['title'] = $data['storerow']->company;
        $userId = $data['storerow']->user_id;
        $data['companySlug'] = $data['storerow']->company_slug;
        Session::put('user_id', $userId);
        Session::put('companySlug', $data['storerow']->company_slug);
        $data['product'] = DB::table('tbl_product')
            ->select(DB::raw('tbl_product.pro_long_description,tbl_product.percentage,tbl_product.special_price,tbl_product.regular_price,tbl_product.slug,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_product.photo1'))
            ->where('user_id', $userId)->where('status', 1)->orderBy('tbl_product.product_id', 'desc')->get();

        $data['productCat'] = DB::table('tbl_product')
            ->select(DB::raw('tbl_category.category_name,tbl_category.slug'))
            ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
            ->where('tbl_product.user_id', $userId)
            ->where('tbl_product.status', 1)
            ->orderBy('tbl_product.product_id', 'desc')
            ->groupBy('tbl_product.category_id')
            ->get();
        return view('fronted.store_child', $data);
    }

    public function ProductBrandAutocmoplete(Request $request)
    {
        $search = $request->get('term');
        $result = DB::table('tbl_brand')
            ->where('brand_name', 'LIKE', "%{$search}%")
            ->where('tbl_brand.status', 1)
            ->groupBy('brand_name')->get();

        $output = array();
        foreach ($result as $row) {
            if (!empty($row->photo)) {
                $temp_array = array();
                $temp_array['value'] = '<h2>' . $row->brand_id . '</h2>';
                $url = $row->slug;
                $temp_array['label'] = '<a href="' . $url . '">' . '<img src="' . url('admin/' . $row->photo) . '" width="70" class="img-thumbnail" style="margin:2px;" />&nbsp;' . $row->brand_name  . '</a>';
                $output[] = $temp_array;
            }
        }

        return response()->json($output);
    }

    public function ProductAutocmoplete(Request $request)
    {
        $search = $request->get('term');
        //$companySlug = Session::get('companySlug');
        $userId = Session::get('user_id');
        $result = DB::table('tbl_product')
            ->select(DB::raw('tbl_product.slug,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_product.photo1'))
            ->where('product_name', 'LIKE', "%{$search}%")
            //  ->where('tbl_product.user_id', $userId)
            ->where('tbl_product.status', 1)
            ->groupBy('product_name')
            ->limit(10)
            ->get();

        $output = array();
        foreach ($result as $row) {
            if (!empty($row->photo1)) {
                $temp_array = array();
                $temp_array['value'] = $row->product_name;
                $url = url('/product-details/') . '/' . $row->slug;
                $temp_array['label'] = '<a href="' . $url . '">' .
                    '<img src="' . $row->photo1 . '" width="70" class="img-thumbnail" style="margin:2px;" />' . $row->product_name . ' [' . $row->product_code . ']' . '</a>';
                $output[] = $temp_array;
            }
        }

        return response()->json($output);
    }



    public function findStore(Request $request)
    {

        $data['allstorelist'] = DB::table('tbl_user')->where('role_id', 2)->where('status', 1)->orderBy('user_id', 'desc')->get();
        if (!empty($request->user_id)) {
            $data['title'] = "Store [$request->user_id]";
            $data['storelist'] = DB::table('tbl_user')->where('user_id', $request->user_id)->where('role_id', 2)->where('status', 1)->orderBy('user_id', 'desc')->get();
        } else {
            $data['title'] = "All Store";
            $data['storelist'] = DB::table('tbl_user')->where('role_id', 2)->where('status', 1)->orderBy('user_id', 'desc')->get();
        }

        return view('vendor.storelist', $data);
        //return view('vendor.store_child',$data);
    }

    public function VendorProductAutocmoplete(Request $request)
    {
        $search = $request->get('term');
        //$companySlug = Session::get('companySlug');
        $userId = Session::get('user_id');
        $result = DB::table('tbl_product')
            ->select(DB::raw('tbl_product.slug,tbl_product.product_id,tbl_product.product_name,tbl_product.product_code,tbl_product.photo1'))
            ->where('product_name', 'LIKE', "%{$search}%")
            ->where('tbl_product.user_id', $userId)
            ->where('tbl_product.status', 1)
            ->groupBy('product_name')->get();

        $output = array();
        foreach ($result as $row) {
            if (!empty($row->photo1)) {
                $temp_array = array();
                $temp_array['value'] = '<h2>' . $row->product_id . '</h2>';
                $url = '/product-details/' . $row->slug;
                $temp_array['label'] = '<a href="' . $url . '">' . '<img src="/admin/' . $row->photo1 . '" width="70" class="img-thumbnail" style="margin:2px;" />&nbsp;' . $row->product_name . ' [' . $row->product_code . ']' . '</a>';
                $output[] = $temp_array;
            }
        }

        return response()->json($output);
    }
    public function showproduct($slug)
    {
        $product_code = $slug;
        $data = array();
        $data['product'] = DB::table('tbl_product')->where('product_code', $product_code)->where('status', 1)->orderBy('product_id', 'asc')->first();
        $data['setting'] =  Setting::all();
        $data['title'] = $data['product']->product_name;
        $data['review'] = DB::table('tbl_review')->where('product_id', $data['product']->product_id)->get();
        return view('fronted.pages.singleproduct', $data);
    }
    public function Aboutus()
    {
        $data = array();
        $data['title'] = "About us";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['data'] = DB::table('tbl_post')->where('menu_id', 1)->where('status', 1)->first();
        return view('fronted.pages.commonpage', $data);
    }
    public function replacementPolicy()
    {
        $data = array();
        $data['title'] = "Replacement and Policy";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['data'] = DB::table('tbl_post')->where('menu_id', 3)->where('status', 1)->first();
        return view('fronted.pages.commonpage', $data);
    }
    public function privacyandPolicy()
    {
        $data = array();
        $data['title'] = "Privacy and Policy";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['data'] = DB::table('tbl_post')->where('menu_id', 2)->where('status', 1)->first();
        return view('fronted.pages.commonpage', $data);
    }
    public function tramsandCondition()
    {
        $data = array();
        $data['title'] = "Trams and Condition";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['data'] = DB::table('tbl_post')->where('menu_id', 4)->where('status', 1)->first();
        return view('fronted.pages.commonpage', $data);
    }
    public function ContactUs()
    {
        $data = array();
        $data['title'] = "Contact us";
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['data'] = DB::table('tbl_setting')->where('status', 1)->first();
        return view('fronted.pages.contactus', $data);
    }
    public function searchproduct(Request $request)
    {
        $pname = substr($request->product_name, 0, -11);
        $data = array();
        $data['product'] = DB::table('tbl_product')->where('product_name', 'like', '%' . $pname . '%')->where('tbl_product.status', 1)->first();
        $productName = $data['product'];
        $data['setting'] = DB::table('tbl_setting')->where('status', 1)->first();
        if (!empty($productName->product_name)) {
            $data['title'] = $productName->product_name;
        } else {
            return view('fronted.pages.productNotfound', $data);
        }
        return view('fronted.pages.singleproduct', $data);
    }

    public function productDetails($slug)
    {

        $data = array();
        $data['product'] = DB::table('tbl_product')
            ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
            ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
            ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
            ->where('tbl_product.slug', $slug)->where('tbl_product.status', 1)->orderBy('product_id', 'asc')->first();

        $product = $data['product']->api_id ? $data['product']->api_id : '';
       // print_r($product);
	   // exit;
		
        //   $arr =  DB::connection('mysql2')->table("0jqrN6X_postmeta")
        //       ->select('0jqrN6X_postmeta.meta_value')
        //       ->where('0jqrN6X_postmeta.post_id', $product)
        //       ->where('0jqrN6X_postmeta.meta_key', '_product_image_gallery')
        //       ->first();

        //   if(!empty($arr->meta_value)){
        //    $meta_val = $arr->meta_value;
        //    $comma_separated = explode(",", $meta_val);
        //    $data['showimg'] = DB::connection('mysql2')->table("0jqrN6X_posts")
		// 			          ->select('0jqrN6X_posts.guid','0jqrN6X_posts.ID')
		// 	                  ->whereIn('0jqrN6X_posts.ID',
        //                       $comma_separated)->get();
			  
        // $relatedImg = $data['showimg']; 
        // $fdata = array();
        //     foreach($relatedImg as $i)
        //     {
                
        // $url = $i->guid;
        // $uploadPath = 'admin/product/';
        // $filename =  'gallery_thumbnail_' . uniqid() . '.jpg';
        // $tempfile = $uploadPath . $filename;
        // copy($url, $tempfile);
                
        //         if(!empty($i))
        //         {
        //         $fdata[] =[
        //             'gallery_img' => 'product/'.$filename, 
        //             'api_id' => $product,
        //             'user_id' => 1,
        //             ];                 

        //     }}
        //     DB::table('tbl_related_img')->insert($fdata);
		
        // only testing
        $data['showimg'] = $data['product'];
        //ending 
        $data['title'] = $data['product']->product_name;
        $data['setting'] = DB::table('tbl_setting')->first();
        $data['category'] = DB::table('tbl_category')->where('status', 1)->get();

        return view('fronted.pages.productDetails', $data);
    }

    public function singpleProduct($slug)
    {

        $data = array();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['product'] = DB::table('tbl_product')->where('slug', $slug)->where('status', 1)->orderBy('product_id', 'asc')->first();
        $data['title'] = $data['product']->product_name;
        return view('fronted.pages.singleproduct', $data);
    }

    public function productCategory($slug)
    {

        $data = array();
        $data['category'] = Category::all();
        $data['cat'] = DB::table('tbl_category')->where('slug', $slug)->where('status', 1)->first();
        $data['title'] = !empty($data['cat']->category_name);
        $cat_id = !empty($data['cat']->category_id);
        $data['brand'] = Brand::all();
        $data['product'] = DB::table('tbl_product')->where('category_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        return view('fronted.pages.shoplist', $data);
    }

    public function shoplist($slug)
    {
        $data = array();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['cat'] = DB::table('tbl_special_category')->where('slug', $slug)->where('status', 1)->first();
        $data['title'] = $data['cat']->sp_category_name;
        $cat_id = $data['cat']->special_cat_id;
        $data['product'] = DB::table('tbl_product')->where('special_cat_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        $data['brand'] = Brand::all();
        return view('fronted.pages.shoplist', $data);
    }

    public function shopMutilpleCategory($subslug, $insubslug)
    {

        $data = array();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['featuresCategory'] = DB::table('tbl_category')->where('category_id', 11)->where('status', 1)->orderBy('category_id', 'desc')->get();

        $data['cat'] = DB::table('tbl_sub_in_sub_cat_name')->where('slug', $insubslug)->where('status', 1)->first();
        $data['title'] = $data['cat']->sub_in_sub_cat_name;
        $cat_id = $data['cat']->sub_cat_id;
        $sub_in_sub_id = $data['cat']->sub_in_sub_id;
        $data['product'] = DB::table('tbl_product')->where('sub_in_sub_id', $sub_in_sub_id)->where('sub_cat_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        return view('fronted.pages.shoplist', $data);
    }

    public function searchBrandProducts($slug)
    {

        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['brand'] = Brand::all();
        $data['brands'] = DB::table('tbl_brand')->where('slug', $slug)->where('status', 1)->first();
        $data['title'] = $data['brands']->brand_name;
        $brandId = $data['brands']->brand_id;
        $data['featuresCategory'] = DB::table('tbl_category')->where('category_id',  11)->where('status', 1)->orderBy('category_id', 'desc')->get();
        $data['product'] = DB::table('tbl_product')->where('tbl_product.brand_id', $brandId)
            ->leftJoin('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('tbl_product.status', 1)->orderBy('tbl_product.brand_id', 'asc')->get();
        return view('fronted.pages.shoplist', $data);
    }

    public function shopCategorylist($slug)
    {

        $data = array();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['brand'] = Brand::all();
        $data['cat'] = DB::table('tbl_category')->where('slug', $slug)->where('status', 1)->first();
        $data['featuresCategory'] = DB::table('tbl_category')->where('category_id',  11)->where('status', 1)->orderBy('category_id', 'desc')->get();
        if (!empty($data['cat']->category_name)) {
            $data['title'] = $data['cat']->category_name;
            $cat_id = $data['cat']->category_id;
            $data['product'] = DB::table('tbl_product')
                ->where('category_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        } else {
            $data['cat'] = DB::table('tbl_subcategory')
                ->where('slug', $slug)->where('status', 1)->first();

            $data['title'] = $data['cat']->sub_cat_name;
            $cat_id = $data['cat']->sub_cat_id;
            $category_id = $data['cat']->category_id;
            $data['product'] = DB::table('tbl_product')->where('category_id', $category_id)
                ->where('sub_cat_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        }

        return view('fronted.pages.shoplist', $data);
    }

    public function productStoreCategory($slug, $companySlug)
    {
        $data = array();
        $data['companySlug'] = $companySlug;
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['brand'] = Brand::all();
        $data['cat'] = DB::table('tbl_category')->where('slug', $slug)->where('status', 1)->first();
        $data['title'] = $data['cat']->category_name;
        $cat_id = $data['cat']->category_id;
        $userid = DB::table('tbl_user')->where('company_slug', $companySlug)->where('status', 1)->first();
        $data['product'] = DB::table('tbl_product')
            ->where('tbl_product.category_id', $cat_id)
            ->where('tbl_product.user_id', $userid->user_id)
            ->where('status', 1)
            ->orderBy('tbl_product.product_id', 'desc')->get();
        return view('vendor.productcategory', $data);
    }

    public function subCategoryProduct($slug)
    {
        $data = array();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['title'] = $data['category']->sub_cat_name;
        $cat_id = $data['category']->sub_cat_id;
        $data['product'] = DB::table('tbl_product')->where('sub_cat_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();
        return view('fronted.pages.productcategory', $data);
    }

    public function StoresingpleProduct($slug, $companySlug)
    {
      
        $data = array();
        $data['companySlug'] = $companySlug;
        $data['product'] = DB::table('tbl_product')->where('slug', $slug)->where('status', 1)->orderBy('product_id', 'asc')->first();
        $data['category'] = Category::all();
        $data['setting'] =  Setting::first();
        $data['title'] = $data['product']->product_name;
        return view('fronted.pages.singleproduct', $data);
    }

    public function StoresubCategoryProduct($slug, $companlySlug)
    {

        $user_id = Session::get('user_id');
        $data = array();
        $data['companySlug'] = $companlySlug;
        $data['category'] = DB::table('tbl_subcategory')->where('slug', $slug)->where('status', 1)->first();
        $data['title'] = $data['category']->sub_cat_name;
        $cat_id = $data['category']->sub_cat_id;
        $data['product'] = DB::table('tbl_product')
            ->where('sub_cat_id', $cat_id)
            ->where('tbl_product.user_id', $user_id)
            ->where('status', 1)
            ->orderBy('product_id', 'asc')
            ->get();

        return view('vendor.productcategory', $data);
    }

    public function subInCategoryProduct($subgslug, $insubslug)
    {
        $data = array();
        $data['subslug'] = $subgslug;
        $data['category'] = DB::table('tbl_sub_in_sub_cat_name')->where('slug', $insubslug)->where('status', 1)->first();
        $data['title'] = $data['category']->sub_in_sub_cat_name;
        $cat_id = $data['category']->sub_in_sub_id;
        $data['product'] = DB::table('tbl_product')->where('sub_in_sub_id', $cat_id)->where('status', 1)->orderBy('product_id', 'asc')->get();

        return view('fronted.pages.productcategory', $data);
    }

    public function StoresubInCategoryProduct($subgslug, $insubslug, $companlySlug)
    {
        $userid = Session::get('user_id');
        $data = array();
        $data['subslug'] = $subgslug;
        $data['category'] = DB::table('tbl_sub_in_sub_cat_name')->where('slug', $insubslug)->where('status', 1)->first();
        $data['title'] = $data['category']->sub_in_sub_cat_name;
        $cat_id = $data['category']->sub_in_sub_id;
        $data['companySlug'] = $companlySlug;
        $data['product'] = DB::table('tbl_product')
            ->where('sub_in_sub_id', $cat_id)
            ->where('tbl_product.category_id', $cat_id)
            ->where('tbl_product.user_id', $userid)
            ->where('status', 1)
            ->orderBy('tbl_product.product_id', 'desc')->get();
        return view('vendor.productcategory', $data);
    }

    public function contactusInfo()
    {
        $data = array();
        $data['title'] = "Contact us";
        return view('fronted.pages.contactus', $data);
    }

    public function catwiseProductList(Request $request)
    {

        if ($request->ajax()) {

            if ($request->id > 0) {
                $category = DB::table('tbl_category')->where('sort', '<', $request->id)
                    ->where('status', 1)
                    ->orderBy('tbl_category.sort', 'desc')
                    ->limit(3)
                    ->get();
            } else {
                $category = DB::table('tbl_category')
                    ->where('status', 1)
                    ->orderBy('tbl_category.sort', 'desc')
                    ->limit(2)->get();
            }

            $last_id = '';
            $output = '';
            if (!$category->isEmpty()) {

                $output .= "<div class='ps-container'>";
                foreach ($category as $v) {
                    $catUrl = url('/category/' . $v->slug);
                    $output .= "<h3 style='text-align:left;'><a href='$catUrl'>$v->category_name</a></h3>";

                    $product = DB::table('tbl_product')
                        ->select(DB::raw('tbl_product.pro_vailability,tbl_product.product_id,tbl_product.status,tbl_product.category_id,tbl_product.regular_price,tbl_product.special_price,tbl_product.product_name,tbl_product.product_code,tbl_product.percentage,tbl_product.slug,tbl_product.photo1'))
                        ->where('category_id', $v->category_id)->where('status', 1)->orderBy('product_id', 'desc')->limit(18)->get();

                    $output .= ' 
<div class="container-flud">
            <div class="row">';

                    foreach ($product as $p) {
                        $productSlug = url('/product/' . $p->slug);

                        $productPhoto = $p->photo1 ? url('admin/' . $p->photo1) : "";
                        $regular_price = 'TK.' . $p->regular_price;
                        $special_price = 'TK.' . $p->special_price;

                        $output .= '

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 ">
                    <div class="card"><a href="' . $productSlug . '" title="View Product">';
                        if (!empty($p->percentage)) {
                            $output .= "<div class='ps-product__badge' style='position: absolute;
                                                 top: 0%;
                                                 right: 0%;
                                                 font-size: 18px;
                                                 color: white;
                                                 text-algin : center;
                                                 background-color:red;
                                                 border: 1px solid red;
                                                 border-radius: 5px;
                                                 opacity: 0.7;
                                                 font-weight: bold;'>$p->percentage %</div>";
                        }

                        $output .= '<img class="card-img-top ps-product__thumbnail" src="' . $productPhoto . '" alt="Card image cap"
                        style="border:1px solid #021a40; height: 200px; width: 100%;">
                        <div class="card-body">
                            <h4 class="card-title"><a href="' . $productSlug . '" title="View Product"><small><center>' . substr($p->product_name, 0, 18) . '..</center></small></a></h4>
                            <div class="row">';

                        $output .= '<div class="col">';
                        if ($p->percentage !== NULL && $p->special_price !== '0' && $p->regular_price !== '0') {
                            $output .= "<p style='font-size: 15px;'>$special_price</p>";
                        }
                        $output .= '</div>';

                        $output .= '<div class="col">';
                        if ($p->percentage == NULL && $p->special_price == '0' && $p->regular_price !== '0') {

                            $output .= "<p><del style='font-size: 15px; color: red'><del>$regular_price</del></p>";
                        }
                        if ($p->special_price == '0' && $p->regular_price !== '0') {

                            if ($p->percentage !== NULL) {
                                $output .= "<p style='font-size: 15px; color: red'> <del>$regular_price</del></p>";
                            }
                        } else {
                            $output .= "<p style='font-size: 15px; color: red'><del>$regular_price</del></p>";
                        }
                        $output .= '</div>';

                        $output .= ' 
                                    <a href="' . $productSlug . '" class="btn btn-block" style="font-size: 18px; background-color: #fcb800; color:black;">Add to cart</a>
                                 
                            </div>
                        </div>
                    </div>
                </div>';
                    }

                    $output .= '
    </a></div></div>';
                    $last_id = $v->sort;
                }
                $output .= '<br>
       <div id="load_more">
        <button type="button" style="background-color: #f7f5dd; color: black;" name="load_more_button" class="btn btn-block btn-success form-control" data-id="' . $last_id . '" id="load_more_button">Load More</button>
       </div>';
            } else {
                $output .= '
       <div class="container">
       <div id="load_more">
        <center>No Data Found</center>
       </div>
        </div>
       ';
            }
        }

        $output .= '
    </div>';

        $data = array(
            'data' => $output,
        );
        echo json_encode($data);
    }

    public function searchProductcode($product_code)
    {
        $check = DB::table('tbl_product')
            ->where('tbl_product.product_code', $product_code)
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function searchbyPhone($phone)
    {
        $check = DB::table('tbl_doctor_profile')
            ->where('tbl_doctor_profile.phone', $phone)
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function searchbyEmail($email)
    {
        $check = DB::table('tbl_user')
            ->where('tbl_user.email', $email)
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }

    public function searchbyCusEmail($email)
    {
        $check = DB::table('tbl_customer')
            ->where('tbl_customer.email', $email) //check Email
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function searchbyCusMobile($mobile)
    {
        $check = DB::table('tbl_customer')
            ->where('tbl_customer.mobile', $mobile) //check mobile
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function searchbyCusUname($username)
    {
        $check = DB::table('tbl_customer')
            ->where('tbl_customer.customer_username', $username) //check username
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function searchbyUsername($username)
    {
        $check = DB::table('tbl_user')
            ->where('tbl_user.phoneNumber', $username) //check username
            ->first();
        if (!empty($check)) {
            $message = '1';
        } else {
            $message = '0';
        }
        echo json_encode($message);
    }
    public function fetchAutocomplete(Request $request)
    {
        $search = $request->get('term');
        $result = DB::table('tbl_disease_sub_category')->where('english_sub_name', 'LIKE', "%{$search}%")->offset(10)->limit(15)->get();
        return response()->json($result);
    }
    public function writeReview(Request $request)
    {
        $data['name'] = $request->name;
        $data['product_id'] = $request->product_id;
        $data['review_description'] = $request->review_description;
        $data['review_date'] = date("Y-m-d");
        DB::table('tbl_review')->insert($data);
        $message = "Review Complete";
        echo json_encode($message);
    }


    public function buysuccessfullycomplete()
    {
        $data = array();
        $data['title'] = "Successfully Buy";
        return view('vendor.success', $data);
    }

    public function successfullycomplete()
    {
        $data = array();
        $data['title'] = "Success";
        return view('fronted.pages.success', $data);
    }
    public function saveContactUs(Request $request)
    {
        $data = array();
        $data['contact_name'] = $request->contact_name;
        $data['email'] = $request->email;
        $data['title'] = $request->title;
        $data['msg'] = $request->msg;
        $data['sneding_date'] = date("Y-m-d");
        DB::table('tbl_contact')->insert($data);
        Session::put('contactmsg', 'Thank for sending Messeages.');
        return redirect("/contact-us");
    }

    public function saveNewssLetter(Request $request)
    {
        $data = array();
        $data['email_id'] = $request->email_id;
        $data['dates'] = date("Y-m-d");
        DB::table('tbl_newsletters')->insert($data);
        Session::put('newsletters', 'Thank for sending Messeages.');
        return redirect("/");
    }
}

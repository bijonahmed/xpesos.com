<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class ProductController extends Controller
{

    public function productlists()
    {
        $this->AuthCheck();
        $role_id = Session::get('role_id');
        $user_id = Session::get('user_id');
        $data = array(
            'category' => Category::where('status', 1)->get(),
            'subcategory' => Category::getSubCategory(),
            'insubcategory' => Category::insubCategory(),
            'brand' => Brand::where('status', 1)->get(),
            'sellerProduct' => Product::getSellerProduct($user_id)
        );
        $data['vendor'] = DB::table('tbl_user')->where('status', 1)->where('role_id', 2)->orderBy('user_id', 'asc')->get();
        if ($role_id == 1) {
            return view('admin.pages.product.productlist', $data);
        } elseif ($role_id == 2) {
            return view('admin.pages.product.sellerproductlist', $data);
        }
    }

    public function productRemoveId(Request $request)
    {
        $imgId = $request->imgId;
        $product_id = $request->product_id;
        $data = array();
        if ($imgId == '2') {
            $data['photo2'] = "";
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        } elseif ($imgId == '3') {
            $data['photo3'] = "";
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        } elseif ($imgId == '4') {
            $data['photo4'] = "";
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        } elseif ($imgId == '5') {
            $data['photo5'] = "";
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        }
        return redirect('/admin/editproduct/' . $product_id);
    }

    public function insertSpecialCate(Request $request)
    {
        $check = DB::table('tbl_product_special')->where('api_id', $request->api_id)->first();
        if (empty($check->api_id)) {
            $data['user_id'] = Session::get('user_id');
            $data['api_id'] = $request->api_id;
            $data['special_cat_id'] = $request->special_cat_id;
            $data['status'] = $request->status;
            DB::table('tbl_product_special')->insertGetId($data);
        } else {
            DB::table('tbl_product_special')->where('api_id', $request->api_id)->delete();
            $data['user_id'] = Session::get('user_id');
            $data['api_id'] = $request->api_id;
            $data['special_cat_id'] = $request->special_cat_id;
            $data['status'] = $request->status;
            DB::table('tbl_product_special')->insertGetId($data);
        }
        return json_encode(array(
            "statusCode" => 200
        ));
    }

    public function bulkstatusUpdateForProduct(Request $request)
    {

        $product =  $request->product_id;
        if (!empty($product)) {
            foreach ($product as $i) {
                $data = array();
                $data['product_id'] = $i;
                $data['status'] = 1;
                DB::table('tbl_product')
                    ->where('product_id', $i)
                    ->update($data);
            }
        }
        return redirect("admin/success");
    }

    public function saveProduct(Request $request)
    {
        $this->AuthCheck();
        $role_id = Session::get('role_id');
        $user_id = Session::get('user_id');
        if ($role_id == 1) {
            $status = $request->status;
        } else {
            $status = 0;
        }

        $photo1 = $request->file('photo1');
        $photo2 = $request->file('photo2');
        $photo3 = $request->file('photo3');

        $data = array(
            'user_id' => Session::get('user_id'),
            'entryBy' => Session::get('user_id'),
            'product_name' => $request->product_name,
            'slug' => $request->slug,
            'product_code' => $request->product_code,
            'category_id' => $request->category_id,
            'sub_cat_id' => $request->sub_cat_id,
            'sub_in_sub_id' => $request->sub_in_sub_id,
            'percentage' => $request->percentage,
            'qty' => $request->qty,
            'brand_id' => $request->brand_id,
            'pro_long_description' => $request->pro_long_description,
            'pro_option' => $request->pro_option,
            'pro_type' => $request->pro_type,
            'entry_type' => $request->entry_type,
            'status' => $status,
            'special_price' => $request->special_price,
            'regular_price' => $request->regular_price,
            'remarks' =>  $request->remarks
        );
        if (!empty($request->product_id)) {

            if (!empty($photo1)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo1->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo1->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo1 = $imageUrl;
                    $data['photo1'] = substr($photo1, 6);
                }
            }
            if (!empty($photo2)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo2->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo2->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo2 = $imageUrl;
                    $data['photo2'] = substr($photo2, 6);
                }
            }


            if (!empty($photo3)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo3->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo3->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo3 = $imageUrl;
                    if (!empty($photo3)) {
                        $data['photo3'] = substr($photo3, 6);
                    }
                }
            }
            Session::put('product_entry', 'Successfully Update');
            DB::table('tbl_product')
                ->where('product_id', $request->product_id)
                ->where('tbl_product.user_id', $user_id)
                ->update($data);
            return redirect('/admin/productlist');
        } else {
            if (!empty($photo1)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo1->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo1->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo1 = $imageUrl;
                    $data['photo1'] = substr($photo1, 6);
                }
            }
            if (!empty($photo2)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo2->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo2->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo2 = $imageUrl;
                    $data['photo2'] = substr($photo2, 6);
                }
            }
            if (!empty($photo3)) {
                $iamgeName = str_random(20);
                $ext = strtolower($photo3->getClientOriginalExtension());
                $iamgeFullname = $iamgeName . '.' . $ext;
                $uploadPath = 'admin/pic/';
                $imageUrl = $uploadPath . $iamgeFullname;
                $success = $photo3->move($uploadPath, $iamgeFullname);
                if ($success) {
                    $photo3 = $imageUrl;
                    if (!empty($photo3)) {
                        $data['photo3'] = substr($photo3, 6);
                    }
                }
            }
            Session::put('product_entry', 'Successfully Add');
            DB::table('tbl_product')->insertGetId($data);
            return redirect('/admin/productlist');
        }
    }

    public function searchByProductId($product_id)
    {
        $data = array();
        $data['vendor'] = DB::table('tbl_user')->where('status', 1)->where('role_id', 2)->orderBy('user_id', 'asc')->get();
        $data['category'] = DB::table('tbl_category')->orderBy('category_id', 'asc')->get();
        $data['subcategory'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        $data['subincategory'] = DB::table('tbl_sub_in_sub_cat_name')->orderBy('sub_in_sub_id', 'asc')->get();
        $data['data'] = DB::table('tbl_product')->where('product_id', $product_id)->orderBy('product_id', 'asc')->first();
        return view('admin.pages.product.editproduct', $data);
    }

    public function thamnailImgmultiple($id)
    {

        $query = DB::table('tbl_related_img')->select('api_id', 'gallery_img')->where('api_id', $id)->get();

        foreach ($query as $i) {
            echo '<img class="img thumbnail" src="' . $i->gallery_img . '" style="height: 90px; width: 90px; border-radius: 8px;border: 2px solid #555; text-aling: center;" />';
        }
    }

    public function thamnailImg($id)
    {
        $findImg = DB::table('tbl_product')->select('photo1')->where('api_id', $id)->first();
        echo json_encode($findImg);
    }

    public function apiSearchProductRow($id)
    {
        $array = DB::table('tbl_product')->where('tbl_product.api_id', $id)->first();

        echo json_encode($array);
    }

    public function apiSearchByProductlist(Request $request)
    {

        $this->AuthCheck();
        if ($request->ajax()) {

            $page = $request->get('selectBatch'); // 4
            $limit = $request->get('maxlimit'); //200;

            $data = DB::connection('mysql2')->table("0jqrN6X_posts")
                ->select(
                    'guid',
                    'product_id',
                    'post_title as productName',
                    'post_excerpt as productSize',
                    'post_name as productSlug',
                    'sku',
                    'post_excerpt',
                    'post_content',
                    'min_price',
                    'max_price as price',
                    'rating_count',
                    'stock_quantity',
                    'stock_status'
                )
                ->leftJoin('0jqrN6X_wc_product_meta_lookup', '0jqrN6X_wc_product_meta_lookup.product_id', '=', '0jqrN6X_posts.ID')
                ->where('0jqrN6X_posts.post_status', 'publish')
                ->where('0jqrN6X_posts.post_type', 'product')
                ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();

            $sl = 1;
            $insertdata = [];
            foreach ($data as $row) {

                $findImag = DB::connection('mysql2')->table("0jqrN6X_postmeta")
                    ->where('0jqrN6X_postmeta.post_id', $row->product_id)
                    ->where('0jqrN6X_postmeta.meta_key', '_thumbnail_id')
                    ->first();

                if (!empty($findImag->meta_value)) {
                    $showImg = DB::connection('mysql2')->table("0jqrN6X_posts")->where('0jqrN6X_posts.ID', $findImag->meta_value)->first();
                    if (!empty($showImg->guid)) {
                        $proFirstImg = '<img class="img thumbnail" src="' . $showImg->guid . '" style="height: 50px; width: 50px; border-radius: 8px;border: 5px solid #555; text-aling: center;" />';
                    }
                }
                $link = '<a onclick="createproduct(' . $row->product_id . ')" href="#"><i class="fa fa-edit"></i></a>';

                $product_id = DB::table('tbl_product')->where('api_id', $row->product_id)->first();
                $query = DB::connection('mysql2')->table("0jqrN6X_term_relationships")
                    ->select(
                        'object_id',
                        'name',
                        'slug'
                    )
                    ->leftJoin('0jqrN6X_term_taxonomy', '0jqrN6X_term_taxonomy.term_taxonomy_id', '=', '0jqrN6X_term_relationships.term_taxonomy_id')
                    ->leftJoin('0jqrN6X_terms', '0jqrN6X_terms.term_id', '=', '0jqrN6X_term_taxonomy.term_id')
                    ->where('0jqrN6X_term_relationships.object_id', $row->product_id)
                    ->where('0jqrN6X_term_taxonomy.taxonomy', 'product_cat')
                    ->get();

                if (empty($product_id->api_id)) {
                    if ($row->stock_status == "instock") {
                        $pro_vailability = 1;
                    } else {
                        $pro_vailability = 0;
                    }
                    $url = $showImg->guid;
                    $uploadPath = 'admin/product/';
                    $filename =  'thumbnail_' . uniqid() . '.jpg';
                    $tempfile = $uploadPath . $filename;
                    copy($url, $tempfile);
                    $data = [
                        'api_id' => $row->product_id,
                        'product_name'   => $row->productName,
                        'slug'   => $row->productSlug,
                        'product_code'   => $row->sku,
                        'stock_quantity'   => $row->stock_quantity,
                        'user_id'   => Session::get('user_id'),
                        'batch'   => $page,
                        'pro_long_description'   => trim(strip_tags($row->post_content)),
                        'regular_price'   =>  $row->price,
                        'special_price'   => $row->price,
                        'entryBy'   => Session::get('user_id'),
                        'pro_vailability'   => $pro_vailability,
                        'photo1'   => 'product/' . $filename, //$showImg->guid,
                        'status'   => 0
                    ];
                    $insertdata[] = $data;
                } else {
                    $insert_data = array();
                    $insert_data['stock_quantity'] = $row->stock_quantity;
                    $insert_data['regular_price'] = $row->price;
                    $insert_data['special_price'] = $row->price;

                    DB::table('tbl_product')
                        ->where('api_id', $row->product_id)
                        ->update($insert_data);
                }
            }

            DB::table('tbl_product')->insert($insertdata);
            $data = array(
                'totalCount' => count($data)

            );

            echo json_encode($data);
            //  }
        }
    }

    public function getInsertCategory(Request $request)
    {
        $page = $request->get('selectBatch'); // 4
        $limit = $request->get('maxlimit'); //100;

        $query = DB::connection('mysql2')->table("0jqrN6X_term_relationships")
            ->select(
                'object_id',
                'name',
                'slug'
            )
            ->leftJoin('0jqrN6X_term_taxonomy', '0jqrN6X_term_taxonomy.term_taxonomy_id', '=',       '0jqrN6X_term_relationships.term_taxonomy_id')
            ->leftJoin('0jqrN6X_terms', '0jqrN6X_terms.term_id', '=', '0jqrN6X_term_taxonomy.term_id')
            ->where('0jqrN6X_term_taxonomy.taxonomy', 'product_cat')
            ->whereNotIn('0jqrN6X_terms.slug', ['uncategorized'])
            ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();
        $mainCategory = DB::table('tbl_category')->where('status', 1)->get();
        foreach ($mainCategory as $i) {
            foreach ($query as $item) {
                if ($i->slug == $item->slug) {
                    $data = array();
                    $data['category_id'] = $i->category_id;
                    DB::table('tbl_product')
                        ->where('api_id', $item->object_id)
                        ->update($data);
                }
            }
        }
        echo json_encode("updated");
    }

    public function getInsertSubCategory(Request $request)
    {
        $page = $request->get('selectBatch'); // 4
        $limit = $request->get('maxlimit'); //100;

        $query = DB::connection('mysql2')->table("0jqrN6X_term_relationships")
            ->select(
                'object_id',
                'name',
                'slug'
            )
            ->leftJoin('0jqrN6X_term_taxonomy', '0jqrN6X_term_taxonomy.term_taxonomy_id', '=',       '0jqrN6X_term_relationships.term_taxonomy_id')
            ->leftJoin('0jqrN6X_terms', '0jqrN6X_terms.term_id', '=', '0jqrN6X_term_taxonomy.term_id')
            ->where('0jqrN6X_term_taxonomy.taxonomy', 'product_cat')
            ->whereNotIn('0jqrN6X_terms.slug', ['uncategorized'])
            ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();
        $subCategory = DB::table('tbl_subcategory')->where('status', 1)->get();
        foreach ($subCategory as $i) {
            foreach ($query as $item) {
                if ($i->slug == $item->slug) {
                    $data = array();
                    $data['sub_cat_id'] = $i->sub_cat_id;
                    DB::table('tbl_product')
                        ->where('api_id', $item->object_id)
                        ->update($data);
                }
            }
        }
        echo json_encode("updated");
    }
    public function getInsertInSubCategory(Request $request)
    {
        $page = $request->get('selectBatch'); // 4
        $limit = $request->get('maxlimit'); //100;
        $query = DB::connection('mysql2')->table("0jqrN6X_term_relationships")
            ->select(
                'object_id',
                'name',
                'slug'
            )
            ->leftJoin('0jqrN6X_term_taxonomy', '0jqrN6X_term_taxonomy.term_taxonomy_id', '=',       '0jqrN6X_term_relationships.term_taxonomy_id')
            ->leftJoin('0jqrN6X_terms', '0jqrN6X_terms.term_id', '=', '0jqrN6X_term_taxonomy.term_id')
            ->where('0jqrN6X_term_taxonomy.taxonomy', 'product_cat')
            ->whereNotIn('0jqrN6X_terms.slug', ['uncategorized'])
            ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();
        $subCategory = DB::table('tbl_sub_in_sub_cat_name')->where('status', 1)->get();
        foreach ($subCategory as $i) {
            foreach ($query as $item) {
                if ($i->slug == $item->slug) {
                    $data = array();
                    $data['sub_in_sub_id'] = $i->sub_in_sub_id;
                    DB::table('tbl_product')
                        ->where('api_id', $item->object_id)
                        ->update($data);
                }
            }
        }
        echo json_encode("updated");
    }

    public function getInsertProductGalleryImg(Request $request)
    {

        // $limit = $request->get('maxlimit'); //200;
        $page = $request->get('selectBatch'); // 4
        $limit = $request->get('maxlimit'); //200;

        $productQuery = DB::table('tbl_product')
            ->select(
                'api_id',
                'product_id'
            )
            ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();
        foreach ($productQuery as $pquery) {

            $check = DB::table('tbl_related_img')->where('api_id', $pquery->api_id)->first();

            $arr =  DB::connection('mysql2')->table("0jqrN6X_postmeta")
                ->select('0jqrN6X_postmeta.meta_value')
                ->where('0jqrN6X_postmeta.post_id', $pquery->api_id)
                ->where('0jqrN6X_postmeta.meta_key', '_product_image_gallery')
                ->first();

            if (!empty($arr->meta_value)) {
                $meta_val = $arr->meta_value;
                $comma_separated = explode(",", $meta_val);
                $relatedImg = DB::connection('mysql2')->table("0jqrN6X_posts")
                    ->select('0jqrN6X_posts.guid', '0jqrN6X_posts.ID')
                    ->whereIn('0jqrN6X_posts.ID', $comma_separated)->get();

                $fdata = array();
                foreach ($relatedImg as $i) {
                    $url = $i->guid;
                    $uploadPath = 'admin/product/';
                    $filename =  'gallery_thumbnail_' . uniqid() . '.jpg';
                    $tempfile = $uploadPath . $filename;
                    copy($url, $tempfile);

                    if (empty($check->api_id)) {

                        $fdata[] = [
                            'gallery_img' => 'product/' . $filename,
                            'api_id' => $pquery->api_id,
                            'batech_no' => $page,
                            'user_id' => 1,
                        ];
                    }
                }
                DB::table('tbl_related_img')->insert($fdata);
            }
        }


        echo json_encode("optimized image done");
    }
    /*
    public function getInsertInSubCategory(Request $request)
    {
        $page = $request->get('selectBatch'); // 4
        $limit = $request->get('maxlimit'); //100;
        $query = DB::connection('mysql2')->table("0jqrN6X_term_relationships")
            ->select(
                'object_id',
                'name',
                'slug'
            )
            ->leftJoin('0jqrN6X_term_taxonomy', '0jqrN6X_term_taxonomy.term_taxonomy_id', '=',          '0jqrN6X_term_relationships.term_taxonomy_id')
            ->leftJoin('0jqrN6X_terms', '0jqrN6X_terms.term_id', '=', '0jqrN6X_term_taxonomy.term_id')
            ->where('0jqrN6X_term_taxonomy.taxonomy', 'product_cat')
            ->whereNotIn('0jqrN6X_terms.slug', ['uncategorized'])
            ->limit($limit)->offset(($page - 1) * $limit)->get()->toArray();

        foreach ($query as $item) {
            $insubcat = DB::table('tbl_sub_in_sub_cat_name')->where('slug', $item->slug)->first();
            // dd($insubcat);

            if (!empty($insubcat)) {
                $sub_in_sub_id = $insubcat->sub_in_sub_id;
            } else {
                $sub_in_sub_id = "";
            }
            //if($i->slug == $item->slug){
            $data = array();
            $data['sub_in_sub_id'] = $sub_in_sub_id;
            DB::table('tbl_product')
                ->where('api_id', $item->object_id)
                ->update($data);
        }

        echo json_encode("updated");
    }
    */


    function success()
    {

        $data['title'] = "Successfully Update";
        return view('admin.pages.product.success', $data);
    }

    public function productStatusUpdate(Request $request)
    {

        $product =  $request->product_id;
        if (!empty($product)) {
            foreach ($product as $i) {
                $data = array();
                $data['product_id'] = $i;
                $data['status'] = 1;
                DB::table('tbl_product')
                    ->where('product_id', $i)
                    ->update($data);
            }
        }
        return redirect("admin/success");
    }

    public function filterproductList(Request $request)
    {
        $this->AuthCheck();
        $filterBatch = $request->filterBatch;
        $limit = 200; //$request->maxLimit;

        $data['category'] = DB::table('tbl_category')->where('status', 1)->orderBy('category_id', 'asc')->get();
        $data['subcategory'] = DB::table('tbl_subcategory')->orderBy('sub_cat_id', 'asc')->get();
        $data['insubcategory'] = DB::table('tbl_sub_in_sub_cat_name')->orderBy('sub_in_sub_id', 'asc')->get();
        $data['brand'] = DB::table('tbl_brand')->orderBy('brand_id', 'asc')->get();
        $data['vendor'] = DB::table('tbl_user')->where('status', 1)->where('role_id', 2)->orderBy('user_id', 'asc')->get();
        $data['sp_category'] = DB::table('tbl_special_category')->orderBy('special_cat_id', 'asc')->get();

        if (!empty($filterBatch)) {
            $data['title'] = "Filter Batech [$filterBatch]";
            $data['product'] = DB::table('tbl_product')
                ->select('tbl_special_category.sp_category_name', 'tbl_user.company', 'tbl_product.batch', 'tbl_product.api_id', 'tbl_product.regular_price', 'tbl_product.stock_quantity', 'tbl_product.percentage', 'tbl_product.photo1', 'tbl_product.status', 'tbl_product.product_code', 'tbl_sub_in_sub_cat_name.sub_in_sub_cat_name', 'tbl_category.category_name', 'tbl_subcategory.sub_cat_name', 'tbl_product.product_name', 'tbl_product.entry_date', 'tbl_product.product_id', 'tbl_product.status')
                ->leftJoin('tbl_category', 'tbl_category.category_id', '=', 'tbl_product.category_id')
                ->leftJoin('tbl_special_category', 'tbl_special_category.special_cat_id', '=', 'tbl_product.special_cat_id')
                ->leftJoin('tbl_user', 'tbl_user.user_id', '=', 'tbl_product.user_id')
                ->leftJoin('tbl_subcategory', 'tbl_subcategory.sub_cat_id', '=', 'tbl_product.sub_cat_id')
                ->leftJoin('tbl_sub_in_sub_cat_name', 'tbl_sub_in_sub_cat_name.sub_in_sub_id', '=', 'tbl_product.sub_in_sub_id')
                ->where('tbl_product.batch', $filterBatch)
                ->orderBy('tbl_product.product_id', 'desc')
                ->limit($limit)
                ->get();
            //->paginate(20);
        } else {
            $data['title'] = "Filter Batech N/A";
            $data['product'] = "";
        }
        $data['filterBatch'] = $filterBatch;
        return view('admin.pages.product.productdetailslist', $data);
    }

    public function specialProCategory(Request $request)
    {
        $this->AuthCheck();
        $filterBatch = $request->filterBatch;
        $limit = $request->maxLimit;

        if (!empty($filterBatch)) {
            $data['title'] = "Filter Batech [$filterBatch]";
            $data['sp_category'] = DB::table('tbl_special_category')->orderBy('special_cat_id', 'asc')->get();
            $data['product'] = DB::table('tbl_product')
                ->select(
                    'tbl_special_category.sp_category_name',
                    'tbl_product.batch',
                    'tbl_product.api_id',
                    'tbl_product.regular_price',
                    'tbl_product.stock_quantity',
                    'tbl_product.percentage',
                    'tbl_product.status',
                    'tbl_product.product_code',
                    'tbl_product.product_name',
                    'tbl_product.product_id',
                    'tbl_product.status'
                )
                ->leftJoin('tbl_product_special', 'tbl_product_special.api_id', '=', 'tbl_product.api_id')
                ->leftJoin('tbl_special_category', 'tbl_special_category.special_cat_id', '=', 'tbl_product_special.special_cat_id')
                ->where('tbl_product.batch', $filterBatch)
                ->orderBy('tbl_product.product_id', 'desc')
                ->limit($limit)
                ->get();
        } else {
            $data['title'] = "Filter Batech N/A";
            $data['product'] = "0";
        }
        $data['filterBatch'] = $filterBatch;
        return view('admin.pages.category.specialcategorylist', $data);
    }

    public function makeNewGraphRpt()
    {
        $this->AuthCheck();

        $results = DB::select(DB::raw("SELECT tbl_category.category_name, SUM(tbl_order_details.price) AS productPrice
             FROM tbl_product LEFT JOIN tbl_category ON tbl_category.category_id = tbl_product.category_id 
             LEFT JOIN tbl_order_details ON tbl_order_details.product_id = tbl_product.product_id 
             LEFT JOIN tbl_order ON tbl_order.order_id = tbl_order_details.order_id 
             WHERE tbl_category.status = 1 AND tbl_category.category_type = 1 
             AND tbl_order.status=4 GROUP BY tbl_product.category_id "));
        $data = array();
        foreach ($results as $i) {
            $x = $i->category_name;
            $y = $i->productPrice;
            $data[] = array($x, $y);
        }

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function searchProductRow($product_id)
    {
        $this->AuthCheck();
        $row = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->first();
        echo json_encode($row);
    }

    public function findBySubCategory()
    {
        $category_id = $_GET['category_id'];
        $output = DB::table('tbl_subcategory')
            ->where('category_id', $category_id)
            ->get();
        return json_encode($output);
    }

    public function findByInSubCategory()
    {

        $sub_cat_id = $_GET['sub_cat_id'];
        $output = DB::table('tbl_sub_in_sub_cat_name')
            ->where('sub_cat_id', $sub_cat_id)
            ->get();
        return json_encode($output);
    }

    public function AuthCheck()
    {
        $user_id = Session::get('user_id');
        if (empty($user_id)) {
            return redirect('/auth')->send();
        }
    }
}

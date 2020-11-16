<?php
/*
      |--------------------------------------------------------------------------
      | Web Routes
      |--------------------------------------------------------------------------
      |
      | Here is where you can register web routes for your application. These
      | routes are loaded by the RouteServiceProvider within a group which
      | contains the "web" middleware group. Now create something great!
      |
     */
header("Cache-Control: no-cache, must-revalidate");
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
//Auth 
Route::get('/auth', 'AuthLogin@index');
Route::post('/logincheck', 'AuthLogin@checkLogin');
Route::get('/logout', 'AuthLogin@logoutOut');
Route::get('/logoutCustomer', 'AuthLogin@logoutOutCustomer');
Route::get('/customer-login-registration', 'Registration@index');
Route::get('/seller-registration', 'Registration@sellerRegistration');
Route::post('/check-auth-login-vendor', 'AuthLogin@CheckLoginVendor');

//paypal
Route::get('payment', 'PaymentController@index');
Route::post('charge', 'PaymentController@charge');
Route::get('paymentsuccess', 'PaymentController@payment_success');
Route::get('paymenterror', 'PaymentController@payment_error');
//end
Route::get('/checkout', 'HomeController@checkout');
Route::group(['middleware' => ['web']], function () {
    // ======================================================= Admin Panel =======================================
    Route::prefix('admin')->group(function () {
        Route::get('/menu-list', 'Menu@menulist');
        Route::post('/save-menu', 'Menu@saveMenu');
        Route::get('/menu/searchbymenu/{menu_id}', 'Menu@searchByMenuRow');
        Route::get('/listByMainMenu/search', 'Menu@searchByMenuList')->name('listByMainMenu.search');
        //Sub menu
        Route::get('/submenu-list', 'Menu@subMenulist');
        Route::get('/listBySubMenu/search', 'Menu@searchBySubMenuList')->name('listBySubMenu.search');
        Route::post('/save-sub-menu', 'Menu@saveSubMenu');
        Route::get('/menu/searchbysubmenu/{sub_menu_id}', 'Menu@searchBySubMenuRow');
        // Sub menu in
        Route::get('/submenu-in-list', 'Menu@subMenuinlist');
        Route::get('/listBySubinMenu/search', 'Menu@searchBySubMenuInList')->name('listBySubinMenu.search');
        Route::post('/save-sub-menu-in-sub', 'Menu@saveSubMenuin');
        Route::get('/menu/searchbysubmenuin/{sub_in_sub_id}', 'Menu@searchBySubMenuinRow');
        //slider
        Route::get('/slider-list', 'Slider@index');
        Route::post('/save', 'Slider@savesliders');
        Route::get('/listByslider/search', 'Slider@searchBysliderlist')->name('listByslider.search');
        Route::get('/slider/searchbyslider/{slider_id}', 'Slider@searchSliderRow');
        //review
        Route::get('/review-list', 'Slider@readReview');
        Route::get('/remove-review/{review_id}', 'Slider@removeId');
        //gallery
        Route::get('/gallery-list', 'Gallery@index');
        Route::post('/saveGallery', 'Gallery@saveGallery');
        Route::get('/gallery/searchbygallery/{gallery_id}', 'Gallery@searchGalleryRow');
        Route::get('/listBygallery/search', 'Gallery@searchBygallerylist')->name('listBygallery.search');
        //service
        Route::get('/services-list', 'Services@index');
        Route::post('/saveservices', 'Services@saveServices');
        Route::get('/servicesPagination/servicesFetch_data', 'Services@servicesFetch_data');
        Route::get('/services/searhServicesId/{services_id}', 'Services@searchServicesRow');
        Route::get('/editfeaturesServices/{services_id}', 'Services@searchServicesId');
        Route::get('/company-setting', 'Services@companylist');
        Route::post('/save-setting', 'Services@updateSetting');
        Route::post('/update-pro', 'Services@updaepro');
        Route::post('/savessetting', 'Services@saveSetting');
        //profile 
        Route::get('/update-profile', 'AdminController@UpdateProfile');
        Route::post('/change-password', 'Services@changepassword');
        // Product List

        Route::post('/filterProducts', 'ProductController@filterproductList');
        Route::get('/success', 'ProductController@success');
        Route::get('/productlist', 'ProductController@productlists');
        Route::get('/get-sub-category', 'ProductController@findBySubCategory');
        Route::get('/get-in-sub-category', 'ProductController@findByInSubCategory');
        Route::get('/product/searhProductId/{product_id}', 'ProductController@searchProductRow');
        Route::get('/product/findproductSearch/{id}', 'ProductController@apiSearchProductRow');
        Route::post('/SaveProduct', 'ProductController@saveProduct');
        Route::post('/updateProducts', 'ProductController@insertSpecialCate');
        Route::post('/updatestatusProducts', 'ProductController@bulkstatusUpdateForProduct');
        Route::get('/apilistByProduct/search', 'ProductController@apiSearchByProductlist')->name('apilistByProduct.search');
        Route::get('/downloadCategory/search', 'ProductController@getInsertCategory')->name('downloadCategory.search');
        Route::get('/downloadsubCategory/search', 'ProductController@getInsertSubCategory')->name('downloadsubCategory.search');
        Route::get('/getInsertInSubCategorys/search', 'ProductController@getInsertInSubCategory')->name('getInsertInSubCategorys.search');
        Route::get('/getInsertProductImageGallery/search', 'ProductController@getInsertProductGalleryImg')->name('getInsertProductImageGallery.search');
        Route::get('/product/thamnailPreviewImg/{product_id}', 'ProductController@thamnailImg');
        Route::get('/product/multiplethamnailPreviewImg/{product_id}', 'ProductController@thamnailImgmultiple');
        //Route::get('/editpost/{post_id}', 'Post@searchPostId');
        Route::get('/product/searhProductCode/{product_code}', 'HomeController@searchProductcode');
        Route::get('/editproduct/{product_id}', 'ProductController@searchByProductId');
        Route::post('/removeProduct', 'ProductController@productRemoveId');
        Route::get('/graph-report-new', 'ProductController@makeNewGraphRpt');
        //user
        Route::post('/save-user', 'User@saveUser');
        Route::post('/change-password', 'User@changePassword');

        Route::get('/user-list', 'User@addUser');
        Route::get('/user-rolelist', 'User@rolelist');
        Route::get('/user/searchuser_id/{user_id}', 'User@searchUserRow');
        Route::get('/userPagination/userfetch_data', 'User@userFetch_data');
        Route::get('/save-special-category', 'ProductController@UpdateProduct');
        //location
        Route::get('/division-list', 'Location@divisionList');
        Route::get('/divisionPagination/divisionFetch_data', 'Location@divisionFetch_data');
        Route::post('/save-division', 'Location@saveDivision');
        Route::post('/save-district', 'Location@saveDistrict');
        Route::get('/location/searchDivisionId/{division_id}', 'Location@searchDivisionRow');
        Route::get('/location/searhDistrictId/{district_id}', 'Location@searchDistrictRow');
        Route::get('/district-list', 'Location@districtList');
        Route::get('/districtPagination/districtFetch_data', 'Location@districtFetch_data');
        Route::get('/division-wise-district', 'Location@divisionWiseDistrictSelect');
        //Category
        Route::get('/contact-list', 'AdminController@contactdetails');
        Route::get('/newsletter-list', 'AdminController@newsletterDetails');
        Route::post('/save-category', 'Category@saveCategory');
        Route::post('/save-subcategory', 'Category@saveSubCategory');
        Route::post('/save-in-subsubcategory', 'Category@saveSubinSubCategory');
        Route::get('/category-list', 'Category@addCategory');
        Route::get('/sub-category-list', 'Category@addsubCategory');
        Route::get('/sub-in-sub-category-list', 'Category@addsubinSubCategory');
        Route::get('/special-category-list', 'Category@specialCategory');
        Route::get('/listByCategory/search', 'Category@searchByCatList')->name('listByCategory.search');
        Route::post('/special-category-product', 'ProductController@specialProCategory');

        //brand
        Route::get('/brand-list', 'Brand@addBrand');
        Route::post('/save-brand', 'Brand@brandCategory');
        Route::get('/brand/searchbrandid/{brand_id}', 'Brand@searchCategoryRow');
        Route::get('/listByBrand/search', 'Brand@searchByBrandist')->name('listByBrand.search');
        //SubCategory category
        Route::get('/categorypagination/categoryfetch_data', 'Category@categoryfetch_data');
        Route::get('/subcategoryPagination/subcategoryFetch_data', 'Category@subCategoryfetch_data');
        Route::get('/category/searchCategoryid/{categoryId}', 'Category@searchCategoryRow');
        Route::get('/category/searchSubCategoryid/{sub_cat_id}', 'Category@searchSubCategoryRow');
        Route::get('/category/searchInSubCategoryid/{sub_in_sub_id}', 'Category@searchInSubCategoryRow');
        Route::get('/listBySubCategory/search', 'Category@searchBySubCatList')->name('listBySubCategory.search');
        Route::get('/listByInSubCategory/search', 'Category@searchByinSubCatList')->name('listByInSubCategory.search');
        Route::get('/sub-in-sub-category', 'Category@getInSubCategory');
        //order-list
        Route::get('/order-list', 'Order@index');
        Route::get('/confirm-order-list', 'Order@ConfirmOrder');
        Route::get('/shipped-order-list', 'Order@ShippedOrder');
        Route::get('/complete-order-list', 'Order@CompletedOrder');
        Route::get('/hold-order-list', 'Order@HoldOrder');
        Route::get('/cancel-order-list', 'Order@CancelOrder');
        Route::get('/return-order-list', 'Order@ReturnOrder');
        Route::get('/recived-order-list/', 'Order@RecivedOrder');
        Route::get('/listByOrder/search', 'Order@searchbySingleOrder')->name('listByOrder.search');
        Route::get('/listByConfirmOrder/search', 'Order@searchbyConfirmOrder')->name('listByConfirmOrder.search');
        Route::get('/listByShippedOrder/search', 'Order@searchbyShippedOrder')->name('listByShippedOrder.search');
        Route::get('/listByCompleteOrder/search', 'Order@searchbyCompleteOrder')->name('listByCompleteOrder.search');
        Route::get('/listByHoldOrder/search', 'Order@searchbyHoldOrder')->name('listByHoldOrder.search');
        Route::get('/listByCancelOrder/search', 'Order@searchbyCancelOrder')->name('listByCancelOrder.search');
        Route::get('/listByReturnOrder/search/', 'Order@searchbyReturnOrder')->name('listByReturnOrder.search');
        Route::get('/listByOrderStatus/search', 'Order@searchbyOrderStatus')->name('listByOrderStatus.search');
        Route::get('/listByOrderMultiple/search', 'Order@searchbyMultipleOrder')->name('listByOrderMultiple.search');
        Route::get('/order/searchOrder/{order_id}', 'OrderAdmin@searchOrderRow');
        Route::get('/orders/order-detail-information/{order_id}', 'OrderAdmin@searchOrder');
        Route::post('update/update-order', 'OrderAdmin@UpdateOrderInfo');
        //Customer List
        Route::get('/customer-list', 'Customer@customerlists');
        Route::get('/customerlist/search', 'Customer@customerlist')->name('customerlist.search');
        Route::get('/admin-check-customer/{username}', 'HomeController@searchbyCusUname');
        Route::get('/admin-check-customer-mobile/{mobile}', 'HomeController@searchbyCusMobile');
        Route::get('/admin-check-customer-email/{mobile}', 'HomeController@searchbyCusEmail');
        Route::post('/customer/save-customer-data', 'Customer@SaveCustomer')->name('save-customer-data.customer');
        Route::get('/customer/searhCustomerId/{customer_id}', 'Customer@searchCustomer');
        // Customer Ledger List
        Route::get('/customer-ledger', 'Customer@customerledger');
        Route::get('/customerOrder', 'Customer@Customerorder');
        // supplier-list
        Route::get('/vendor-list', 'Supplier@supplierlists');
        Route::post('/save-supplier', 'Supplier@SaveSupplier');
        Route::get('/supplier-mobile-check/{mobile}', 'Supplier@searchbySupplierMobile');
        Route::get('/supplierlist/search', 'Supplier@supplierlist')->name('supplierlist.search');
        Route::get('/supplier/searhSupplierId/{supplier_id}', 'Supplier@searchSupplier');
        Route::get('/supplier/searchSupplierInvoice/{supplier_invoice_id}', 'Supplier@PrintSupplierInvoice');
        Route::get('/supplier/editSupplierInvoice/{supplier_invoice_id}', 'Supplier@getInvoiceEdit');
        Route::get('/vendor-ledger', 'Supplier@vendorledger');

        Route::get('/supplier/search-ItemId/{item_id}', 'Supplier@searchItemId');

        Route::get('/vendor-invoice-list', 'Supplier@supplierInvoicelist');
        //supplierlistinvlicelist.search
        Route::get('/supplierlistinvlicelist.search/search', 'Supplier@SuppInvoiceList')->name('supplierlistinvlicelist.search');
        Route::get('/supplier/supplier-invoice/{supplier_id}', 'Supplier@searchInvoice');
        Route::post('/save-supllier-invoice', 'Supplier@SaveSupplierInvoice');
        Route::post('/update-invoice-item', 'Supplier@UpdateSupplierInvoice');
        Route::get('/itemlistinvoice.search/search', 'Supplier@IteminfobyInvoice')->name('itemlistinvoice.search');
        Route::get('/invoiceItemTemove', 'Supplier@removeItemIdInvoice');
        Route::post('/SaveSupplierInvoice', 'Supplier@SaveInvoice');
        Route::post('/UpdateSupplierInvoiceParticular', 'Supplier@UpdateInvoiceParticular');
        Route::get('/SupplierInvoices', 'Supplier@VendorPurchaseInvoice');
        //edit Invoice 
        Route::get('/editItemlistinvoice.search/search', 'Supplier@EditIteminfobyInvoice')->name('editItemlistinvoice.search');
        Route::get('/supplier/item-remove/', 'Supplier@removeItem');
        // =============================================================== Employee ======================================================
        // Department 
        Route::get('/department-list', 'Employee@departmentlist');
        Route::post('/save-depatment', 'Employee@SaveDepartment');
        Route::get('/admin-check-dptname/{dptname}', 'Employee@searchbydptname');
        Route::get('/departmentlist/search', 'Employee@departmentslist')->name('departmentlist.search');
        Route::get('/department/searhDptId/{dpt_id}', 'Employee@searchDptId');
        Route::get('/designation/searhDesignationId/{designation_id}', 'Employee@searchDesigantionId');
        // Desigantion 
        Route::get('/designation-list', 'Employee@designationlist');
        Route::post('/save-designation', 'Employee@SaveDesignation');
        Route::get('/admin-check-desname/{designationname}', 'Employee@searchbydesignationname');
        Route::get('/designationlist.search/search', 'Employee@desigantionlist')->name('designationlist.search');
        Route::get('/department/searhDptId/{dpt_id}', 'Employee@searchDptId');
        // Employee
        Route::get('/employee-list', 'Employee@employeelist');
        Route::post('/save-employee', 'Employee@SaveEmployee');
        Route::get('/admin-check-employee-mobile/{mobile}', 'Employee@searchbyMobile');
        Route::get('/employeelist.search/search', 'Employee@employeelistInfo')->name('employeelist.search');
        Route::get('/employee/searhEmployeeId/{employeeid}', 'Employee@searchemployeeId');
        // Salary
        Route::get('/salary-list', 'Employee@salarylist');
        Route::post('/CreateSalary', 'Employee@createSlarySheet');
        Route::get('/salarylist.search/search', 'Employee@SlarySheetInfo')->name('salarylist.search');
        // =============================================================== Item ==========================================================
        // Item
        Route::get('/item-list', 'Item@itemlist');
        Route::get('/item-report', 'Item@itemreport');

        Route::post('/save-item', 'Item@SaveItem');
        Route::post('/save-item-processing', 'Item@SaveItemProcessing');
        Route::get('/admin-check-itemname/{mobile}', 'Item@searchbyitemName');
        Route::get('/itemlist.search/search', 'Item@SearchbyIteminfo')->name('itemlist.search');
        Route::get('/findCateWiseItem', 'Item@CatWiseItem');
        Route::get('/findInSubCateWiseItem', 'Item@InSubCatWiseItem');
        Route::get('/item/searchItemId/{itemId}', 'Item@searchItemid');
        Route::get('/item/item-report/{product_id}', 'Item@reportbyItem');
        //item report
        Route::get('/findSubCateWiseItem', 'Item@SubCatWiseItem');
        Route::get('/findCateWiseItemMultiple', 'ItemReport@CatWiseItemrpt');
        Route::get('/defaultitemreport', 'ItemReport@itemreportdefault');
        Route::get('/findSubCateWiseItemrpt', 'ItemReport@SubCatWiseItemrpt');
        Route::get('/findInSubCateWiseItemrpt', 'ItemReport@InSubCatWiseItemrpt');
        Route::get('/customOrderReport', 'Report@orderReport');

        //Post List
        Route::get('/post-list', 'Post@index');
        Route::get('/post-list', 'Post@postlist');
        Route::get('/listByPost/search', 'Post@searchByPostlist')->name('listByPost.search');
        Route::get('/get-sub-menu', 'Post@getSubMenu');
        Route::post('/SavePost', 'Post@SavePost');
        Route::get('/post/searhPostId/{post_id}', 'Post@searchPostRow');
        Route::get('/editpost/{post_id}', 'Post@searchPostId');
        // Order Report 
        Route::get('/order-report', 'Report@index');
        Route::post('/ordersreport', 'Report@orderReport');
        // Order Invoice 
        Route::get('/invoice-list', 'Invoice@index');
        Route::get('/create-a-new-invoice', 'Invoice@createInvoice');
        Route::get('/listByInvoice/search', 'Invoice@searchbyInvoice')->name('listByInvoice.search');
        Route::get('/invoice/search-product/{product_id}', 'Invoice@searchProductId');
        Route::post('/save-order-invoice', 'Invoice@SaveOrderInvoice');
        Route::get('/prolist.search/search', 'Invoice@IteminfobyInvoice')->name('prolist.search');
        Route::get('/product-remove/{product_id}', 'Invoice@removeProductId');
        Route::post('/SaveOrderInvoice', 'Invoice@SaveInvoice');
        Route::post('/check-product-qty', 'Invoice@checkProductQty');
        Route::get('/invoice/print_invoice/{order_id}', 'Invoice@printInvoice');
        Route::get('/invoice/edit_invoice/{order_id}', 'Invoice@editInvoice');
        Route::post('/editprolistbyInvoice', 'Invoice@editInvoiceProductList')->name('editprolistbyInvoice');
        Route::post('/UpdateOrderInvoice', 'Invoice@UpdateInvoice');
        Route::post('/addEdit-order-invoice', 'Invoice@UpdateOrderInvoice');
        Route::post('/product-remove-order-wise', 'Invoice@removeProductIdOrderwise');
        // Accounts
        Route::post('/save-expense', 'Accounts@SaveExpense');
        Route::get('/moneyTraSummaryReport', 'Report@mone_transaction_summary_report');
        Route::post('/save-opeining-balance', 'Accounts@SaveOpeningBalance');
        Route::get('/sub-expense/{sub_category_id}', 'Accounts@subExpenserow');
        Route::get('/find-expense-row/{expense_id}', 'Accounts@expenseRow');
        Route::get('/find-opening-balance-row/{op_balanceid}', 'Accounts@openinigBalanceRow');
        Route::get('/find-salary-row/{salary_id}', 'Accounts@SalaryRow');
        Route::get('/employee-salary-row/{employeeid}', 'Accounts@EmpSalaryRow');
        Route::get('/edit-party-paymentt/{party_payment_id}', 'Accounts@editPartyPayment');
        Route::get('/getReportProfitLoss', 'Accounts@profitLossCalculation');
        Route::get('/expense', 'Accounts@expense');
        Route::get('/profit-loss-report', 'Accounts@profitLoss');
        Route::get('/getDetailsReport', 'Accounts@MakeDetailsReport');
        Route::get('/details-report', 'Accounts@detailseReport');
        Route::get('/salary-sheet', 'Accounts@salarySheet');
        Route::get('/party-payment', 'Accounts@partyPayment');
        Route::get('/money-transaction', 'Accounts@moneyTransection');
        Route::post('/SaveExpenseCat', 'Accounts@SaveExpenseCat');
        Route::post('/SaveExpenseCategory', 'Accounts@saveopneningbanalce');
        Route::post('/save-Salary', 'Accounts@SaveSalary');
        Route::post('/UpdateSetting', 'Accounts@updateOpeningBalance');
        Route::post('/save-party-payment', 'Accounts@SavePartyPayment');
        Route::get('/listByPartyPayment/search', 'Accounts@searchbyPartyPayment')->name('listByPartyPayment.search');
        Route::get('/listByexpense/search', 'Accounts@searchbyExpenes')->name('listByexpense.search');
        Route::get('/listOpeningBalance/search', 'Accounts@searchbyOpeningBalance')->name('listOpeningBalance.search');
        Route::get('/listBysalary/search', 'Accounts@searchbySalary')->name('listBysalary.search');
    });
    Route::get('/dashboard', 'AdminController@index');
});
Route::get('/', 'HomeController@index');
Route::get('/product/{slug}', 'HomeController@singpleProduct');
Route::get('/product-details/{slug}', 'HomeController@productDetails');
Route::get('/shop-list/{slug}', 'HomeController@shoplist');
Route::get('/shop-list-category/{slug}', 'HomeController@shopCategorylist');
Route::get('/shop-list-multiple-category/{subslug}/{insubslug}', 'HomeController@shopMutilpleCategory');

Route::get('/view-cart', 'CartController@viewCart');
Route::get('/whish-list/{slug}', 'CartController@whishlist');
Route::post('/processtoPayment/', 'PaymentController@processtoPayments');


Route::get('/productcatWise/search', 'HomeController@catwiseProductList')->name('productcatWise.search');
//Vendor Signle Product 
Route::get('/store-product-details/{slug}/{companySlug}', 'HomeController@StoresingpleProduct');
Route::get('/about-us', 'HomeController@Aboutus');
Route::get('/contact-us', 'HomeController@ContactUs');
Route::get('/store-list', 'HomeController@storelist');
Route::get('/store-details/{slug}', 'HomeController@storedetails');
Route::get('/find-brand/{slug}', 'HomeController@searchBrandProducts');


Route::get('/user/checkuserName/{username}', 'Registration@checkuserName');
Route::get('/vendor/vendor-checkuserName/{username}', 'Registration@checkVendoruserName');
Route::get('/vendor/checkvendoremailId/{email}', 'Registration@checkVendorEmail');
Route::get('/vendor/checkVendorMobileNumber/{mobile}', 'Registration@checkVendorMobile');

//Seller Check 
Route::get('/user/checkSelleremailId/{email}', 'Registration@checkSellerEmail');
Route::get('/user/checkSelleruserName/{username}', 'Registration@checSellerkuserName');
Route::get('/user/checkSellerMobileNumber/{mobile}', 'Registration@checkSellerMobile');
//End 

Route::get('/user/checkemailId/{email}', 'Registration@checkEmail');
Route::get('/user/checkMobileNumber/{mobile}', 'Registration@checkMobile');
Route::get('/products/{slug}', 'HomeController@subCategoryProduct');
Route::get('/store-products/{slug}/{companySlug}', 'HomeController@StoresubCategoryProduct');
Route::get('/products-list/{subgslug}/{insubslug}', 'HomeController@subInCategoryProduct');
Route::get('/store-products-list/{subgslug}/{insubslug}/{companlySlug}', 'HomeController@StoresubInCategoryProduct');
Route::get('/category/{slug}', 'HomeController@productCategory');
Route::get('/store-category/{slug}/{companySlug}', 'HomeController@productStoreCategory');
Route::get('/search-product/{slug}', 'HomeController@showproduct');
Route::get('/phone/searchPhoneNumber/{phone}', 'HomeController@searchbyPhone');
Route::get('/email/searchEmailId/{email}', 'HomeController@searchbyEmail');
Route::get('/bmdc/searchbmdc/{bmdc_no}', 'HomeController@searchbyBmdc');
Route::get('/user/username/{username}', 'HomeController@searchbyUsername');
Route::get('autocomplete', 'HomeController@fetchAutocomplete');
//user/username
Route::post('/send-newsletter', 'HomeController@saveNewssLetter');
Route::post('/find-speacality-lists', 'HomeController@specalitydistSpeWises');
Route::get('/contact', 'HomeController@contactus');
Route::post('/sendContactusdata', 'HomeController@saveContactUs');
Route::get('/login', 'HomeController@userLogin');
Route::get('/auth', 'AuthLogin@index');
Route::post('/save-registration-data', 'LoginController@userRegistration');
Route::post('/savecontactmessages', 'HomeController@saveContactMessages');
Route::post('/search-product', 'HomeController@searchproduct');

Route::post('/save-orders-ajax', 'HomeController@saveOrderAjax');
Route::post('/save-orders-details', 'HomeController@saveOrderDetails');
Route::post('/write-to-review', 'HomeController@writeReview');
Route::post('/add-to-cart', 'CartController@add_to_cart');
Route::get('/show-cart', 'CartController@showCart');
Route::get('/store-show-cart', 'CartController@StoreShowCart');
Route::get('/delete-product/{slug}', 'CartController@deleteProduct');
Route::get('/item-delete-product/{slug}', 'CartController@ItemdeleteProduct');
Route::post('/update-product', 'CartController@UpdateCart');
Route::post('/vendor-update-product', 'CartController@vendorUpdateCart');
Route::post('/customerUserNamePassword', 'Registration@checkCustomerCredential');

Route::get('/autocomplete/AutocompleteProductfetch', 'HomeController@ProductAutocmoplete')->name('autocomplete.AutocompleteProductfetch');
Route::get('/autocomplete/AutocompleteBrandProductfetch', 'HomeController@ProductBrandAutocmoplete')->name('autocomplete.AutocompleteBrandProductfetch');
Route::get('/vendorAutocomplete/vendorAutocompleteProductfetch', 'HomeController@VendorProductAutocmoplete')->name('vendorAutocomplete.vendorAutocompleteProductfetch');
// vendor
Route::post('/save-seller-registration', 'Registration@saveSellerRegistration');
Route::post('/find-store', 'HomeController@findStore');
//Route::post('/sell-on-xpesos', 'HomeController@sellonxpesos');

// Customer 
Route::post('/save-cus-registration', 'Registration@saveCustomerRegistration');
Route::post('/check-login-customer', 'Registration@CheckLoginCustomer');
//Route::post('/check-login-customer-by-Mobile', 'Registration@CheckLoginCustomerByMobile');
Route::get('/customer-login', 'Registration@custoerLogin');
//Route::get('/login-customer', 'Registration@Logincustoer');
Route::get('/sell-on-xpesos', 'HomeController@sellOnXpesos');
Route::get('/track-your-order', 'HomeController@trackyourorder');
Route::get('/customer-panel', 'CustomerPanel@index');
Route::post('/update-customer-information', 'CustomerPanel@UpdateCustomerRegistration');
Route::get('/single-order-details/{orderId}', 'CustomerPanel@getSingleOrder');
Route::get('/customer-order-details/{orderId}', 'CustomerPanel@getCustomerOrder');
Route::get('/edit-customer-account/', 'CustomerPanel@editCustomerAccount');
Route::get('/customer-order-list/', 'CustomerPanel@getCustomerList');
Route::post('/send-sms-orders', 'HomeController@SendsmsApi');

Route::post('/update-customer-pass', 'CustomerPanel@Updatepass');
Route::get('/success', 'HomeController@successfullycomplete');
Route::get('/buy-success', 'HomeController@buysuccessfullycomplete');
Route::get('/policy', 'HomeController@replacementPolicy');
Route::get('/privacy-and-policy', 'HomeController@privacyandPolicy');
Route::get('/trams-and-condition', 'HomeController@tramsandCondition');
Route::get('/faq', 'HomeController@faqlist');

Route::group(['prefix' => 'wishlist'], function () {
Route::get('/', 'WishListController@index')->name('wishlist.index');
Route::get('/wishlist', 'WishListController@add')->name('wishlist');
Route::get('/details', 'WishListController@details')->name('wishlist.details');
Route::delete('/{id}', 'WishListController@delete')->name('wishlist.delete');


});

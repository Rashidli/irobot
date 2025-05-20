<?php

use App\Http\Controllers\Admin\AccessoryCategoryController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\AccessorySerieController;
use App\Http\Controllers\Admin\AccessoryTypeController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\AppContentController;
use App\Http\Controllers\Admin\AppFaqController;
use App\Http\Controllers\Admin\AppMainController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BasketController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChoiceController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactItemController;
use App\Http\Controllers\Admin\CreditController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeliveryPriceController;
use App\Http\Controllers\Admin\FavoriteController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\InstructionController;
use App\Http\Controllers\Admin\MagicalWordController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PercentageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDetailController;
use App\Http\Controllers\Admin\ProductFaqController;
use App\Http\Controllers\Admin\ProductFeatureController;
use App\Http\Controllers\Admin\ProductSerieController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionMainController;
use App\Http\Controllers\Admin\ReasonController;
use App\Http\Controllers\Admin\RobotIoMainController;
use App\Http\Controllers\Admin\RobotMainController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\SingleController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\SpecialController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WordController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('storage_link', function (){
//    return \Illuminate\Support\Facades\Artisan::call('storage:link');
//});
//
//Route::get('migrate', function (){
//    return \Illuminate\Support\Facades\Artisan::call('migrate');
//});
//
//Route::get('optimize', function (){
//    return \Illuminate\Support\Facades\Artisan::call('optimize:clear');
//});

Route::get('/', [PageController::class,'login'])->name('login');
//Route::get('/register', [PageController::class,'register'])->name('register');
Route::post('/login_submit',[AuthController::class,'login_submit'])->name('login_submit');
//Route::post('/register_submit',[AuthController::class,'register_submit'])->name('register_submit');

Route::group(['middleware' =>'auth'], function (){

    Route::get('/home', [PageController::class,'home'])->name('home');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::resource('users',UserController::class);
    Route::resource('roles',RoleController::class);
    Route::resource('permissions',PermissionController::class);

    Route::resource('blogs',BlogController::class);
    Route::resource('rules',RuleController::class);
    Route::resource('shops',ShopController::class);
    Route::resource('types',TypeController::class);
    Route::resource('products',ProductController::class);
    Route::resource('socials',SocialController::class);
    Route::resource('contact_items',ContactItemController::class);
    Route::resource('singles',SingleController::class);
    Route::resource('words',WordController::class);
    Route::resource('images',ImageController::class);
    Route::resource('categories',CategoryController::class);
    Route::resource('subscriptions',SubscriptionController::class);
    Route::resource('contacts',ContactController::class);
    Route::resource('tags',TagController::class);
    Route::resource('mains',MainController::class);
    Route::resource('specials',SpecialController::class);
    Route::resource('credits',CreditController::class);
    Route::get('toggle_status/{id}',[CreditController::class,'toggleStatus'])->name('toggle_status');
    Route::resource('reasons',ReasonController::class);
    Route::resource('questions',QuestionController::class);
    Route::resource('supports',SupportController::class);
    Route::resource('advantages',AdvantageController::class);
    Route::resource('choices',ChoiceController::class);
    Route::resource('maps',MapController::class);
    Route::resource('app_faqs',AppFaqController::class);
    Route::resource('robot_mains',RobotMainController::class);
    Route::resource('robot_io_mains',RobotIoMainController::class);
    Route::resource('app_mains',AppMainController::class);
    Route::resource('question_mains',QuestionMainController::class);
    Route::resource('app_contents',AppContentController::class);
    Route::resource('magical_words',MagicalWordController::class);
    Route::resource('instructions',InstructionController::class);
    Route::resource('products.product_faqs',ProductFaqController::class);
    Route::resource('products.product_details',ProductDetailController::class);
    Route::resource('products.product_features',ProductFeatureController::class);
    Route::resource('products.product_colors',ProductColorController::class);
    Route::resource('delivery_prices',DeliveryPriceController::class);
    Route::resource('customers',CustomerController::class);
    Route::resource('percentages',PercentageController::class);
    Route::resource('comments',CommentController::class);
    Route::resource('sections',SectionController::class);
    Route::resource('product_series',ProductSerieController::class);

    Route::resource('accessories',AccessoryController::class);
    Route::resource('accessory_categories',AccessoryCategoryController::class);
    Route::resource('accessory_types',AccessoryTypeController::class);
    Route::resource('accessory_series',AccessorySerieController::class);

    Route::get('/delete-slider-image/{id}', [QuestionController::class, 'deleteImage'])
        ->name('delete-slider-image');

    Route::get('baskets/{id}',[BasketController::class,'index'])->name('customer_basket');
    Route::get('favorites/{id}',[FavoriteController::class, 'index'])->name('favorites.index');

    Route::resource('orders', OrderController::class);
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');

    Route::get('create_credit', [CreditController::class, 'create'])->name('create_credit');

});

//Route::group(['prefix' => LaravelLocalization::setLocale()], function (){
//    Route::get('sigorta_qanunu', [HomeController::class,'sigorta_qanunu'])->name('sigorta_qanunu');
//    Route::get('dovlet_qulluqculari', [HomeController::class,'dovlet_qulluqculari'])->name('dovlet_qulluqculari');
//    Route::get('icbari_sigorta_qanun', [HomeController::class,'icbari_sigorta_qanun'])->name('icbari_sigorta_qanun');
//    Route::get('inzibati_xetalar_mecellesi', [HomeController::class,'inzibati_xetalar_mecellesi'])->name('inzibati_xetalar_mecellesi');
//    Route::get('tibbi_sigorta_qanun', [HomeController::class,'tibbi_sigorta_qanun'])->name('tibbi_sigorta_qanun');
//    Route::get('kasko_qanun', [HomeController::class,'kasko_qanun'])->name('kasko_qanun');
//
//    Route::get('/sitemap.xml', [SitemapController::class, 'sitemap']);
//    Route::get('/', [HomeController::class,'welcome'])->name('welcome');
//    Route::get('success',[HomeController::class,'success'])->name('success');
//    Route::get('{slug}', [HomeController::class,'dynamicPage'])->name('dynamic.page');
//    Route::post('submit', [HomeController::class,'submit'])->name('forms.submit');
//    Route::post('/contact_post',[HomeController::class,'contact_post'])->name('contact_post');
//});

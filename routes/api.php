<?php

use App\Http\Controllers\Api\AccessoryController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AdvantageController;
use App\Http\Controllers\Api\AppFaqController;
use App\Http\Controllers\Api\BasketItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChoiceController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactItemController;
use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\InstructionController;
use App\Http\Controllers\Api\LogoController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PercentageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\RobotController;
use App\Http\Controllers\Api\RobotHomeAppController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Api\SerieController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\SpecialController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\TranslateController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\WhyRobotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [CustomerController::class,'register']);
Route::post('/login', [CustomerController::class,'login']);

Route::group(['middleware' => 'setLocale'], function () {

    Route::post('/password-reset/request', [CustomerController::class, 'requestPasswordReset']);
    Route::post('/password-reset/reset', [CustomerController::class, 'resetPassword']);
    Route::get('getProducts',[ProductController::class,'getProducts']);
    Route::get('getDifferentProducts',[ProductController::class,'getDifferentProducts']);
    Route::get('shops', [ShopController::class,'index']);
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post('/update', [CustomerController::class, 'update']);
        Route::post('/logout', [CustomerController::class, 'logout']);

        Route::post('/change-email/request', [CustomerController::class, 'requestEmailChange']);
        Route::post('/change-email/verify', [CustomerController::class, 'verifyEmailChange']);

        // basket
        Route::apiResource('basket_items', BasketItemController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::post('multipleUpdate',[BasketItemController::class,'multipleUpdate']);

        //favorites
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites/toggleFavorite', [FavoriteController::class, 'toggleFavorite']);

        //address
        Route::get('getAddress', [AddressController::class,'index']);
        Route::post('storeOrUpdate', [AddressController::class, 'storeOrUpdate']);

        //order
        Route::post('storeOrder', [OrderController::class,'storeOrder']);
        Route::get('getOrders', [OrderController::class,'getOrders']);
        Route::get('getOrderItem/{id}', [OrderController::class,'getOrderItem']);
        Route::post('cancelOrder', [OrderController::class, 'cancelOrder']);
        Route::post('changeOrderAddress', [OrderController::class,'changeOrderAddress']);

        //comment
        Route::post('comment', [CommentController::class, 'store']);
        Route::get('credits', [CreditController::class,'index']);
        Route::get('credit-detail/{id}',[CreditController::class,'creditDetail']);

    });
    Route::post('subscribe',[SubscriptionController::class,'store']);
    Route::get('productCategories',[CategoryController::class,'productCategories']);
    Route::get('accessoryCategories',[CategoryController::class,'accessoryCategories']);

    Route::get('productTypes',[TypeController::class,'productTypes']);
    Route::get('accessoryTypes',[TypeController::class,'accessoryTypes']);

    Route::get('productSeries', [SerieController::class,'productSeries']);
    Route::get('accessorySeries', [SerieController::class,'accessorySeries']);

    Route::get('accessories',[AccessoryController::class,'index']);
    Route::get('accessorySingle/{slug}',[AccessoryController::class,'accessorySingle']);

    Route::get('questions', [QuestionController::class, 'index']);
    Route::get('/irobot_home_app', [RobotHomeAppController::class, 'index']);
    Route::get('/why_irobot', [WhyRobotController::class, 'index']);
    Route::get('/hero', [MainController::class, 'hero']);
    Route::get('/robots', [RobotController::class, 'index']);
    Route::get('/robot-advantages', [RobotController::class, 'robotAdvantages']);

    Route::get('socials', [SocialController::class,'index']);
    Route::get('contact_items', [ContactItemController::class,'index']);
    Route::post('contact', [ContactController::class,'store']);
    Route::get('supports', [SupportController::class,'index']);
    Route::get('advantages', [AdvantageController::class,'index']);
    Route::get('choices', [ChoiceController::class,'index']);
    Route::get('map', [MapController::class,'index']);
    Route::get('instructions', [InstructionController::class,'index']);
    Route::get('app_faqs', [AppFaqController::class,'index']);

    Route::get('app_hero', [MainController::class,'app_main']);
    Route::get('irobot_hero', [MainController::class,'robot_main']);
    Route::get('robot_os_hero', [MainController::class,'robot_os_main']);
    Route::get('question_main', [MainController::class,'question_main']);
    Route::get('app_content', [MainController::class,'app_content']);
    Route::get('magical_word', [MainController::class,'magical_word']);
    Route::get('special', [SpecialController::class,'index']);
    Route::get('rule', [RuleController::class,'index']);

    //products
    Route::get('products',[ProductController::class,'index']);
    Route::get('productSingle/{slug}',[ProductController::class,'productSingle']);

    //translates
    Route::get('/translates',[TranslateController::class,'translates']);

    //percentages for products
    Route::get('percentages' , [PercentageController::class,'index']);
    Route::post('getPercentagePrice', [PercentageController::class,'getPercentagePrice']);

    Route::get('chooseProducts',[ProductController::class,'chooseProducts']);

    Route::get('section', [SectionController::class, 'index']);
    Route::get('reasons', [ReasonController::class, 'index']);

    Route::get('favicon', [LogoController::class,'favicon']);
    Route::get('logo', [LogoController::class,'logo']);

    Route::get('seo_pages', [SeoController::class,'index']);

});

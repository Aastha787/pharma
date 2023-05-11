<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//Route::get('/', function () {
   // return view('welcome');
//});


Auth::routes();

Route::get('/',  [App\Http\Controllers\Frontend\FrontendController::class,'index']);
Route::get('/collections', [App\Http\Controllers\Frontend\FrontendController::class,'categories']);
Route::get('/collections/{category_slug}', [App\Http\Controllers\Frontend\FrontendController::class,'products']);
Route::get('/collections/{category_slug}/{product_slug}', [App\Http\Controllers\Frontend\FrontendController::class,'productView']);

Route::middleware(['auth'])->group(function (){
  Route::get('cart',[App\Http\Controllers\Frontend\CartController::class,'index']);
  Route::get('checkout',[App\Http\Controllers\Frontend\CheckoutController::class,'index']);

  Route::get('orders',[App\Http\Controllers\Frontend\OrderController::class,'index']);
  Route::get('orders/{orderId}',[App\Http\Controllers\Frontend\OrderController::class,'show']);
});

Route::get('Thankyou',[App\Http\Controllers\Frontend\FrontendController::class,'thankyou']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function (){
   Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index']);

   ///sliders
   Route::controller(App\Http\Controllers\Admin\SliderController::class)->group(function () {
   Route::get('/sliders', 'index');
   Route::get('/sliders/create', 'create');
   Route::post('/sliders', 'store');


   });


   //category
   Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
    Route::get('/category','index');
    Route::get('/category/create','create');
    Route::post('/category','store');
    Route::get('/category/{category}/edit','edit');
    Route::put('/category/{category}','update');
   });

   //product
   Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
    Route::get('/products','index');
    Route::get('/products/create','create');
    Route::post('/products','store');
    Route::get('/products/{product}/edit','edit');
    Route::put('/products/{product}','update');
    Route::get('/products/{product_id}/delete','destroy');
    Route::get('/productImage/{product_image_id}/delete)','destroyImage');

   });

//admin/orders
    Route::controller(App\Http\Controllers\Admin\OrderController::class)->group(function () {
        Route::get('/orders','index');
        Route::get('/orders/{orderId}','show');


    });


});

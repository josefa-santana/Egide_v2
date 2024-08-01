

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockController;
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


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:user'])->name('dashboard');

Route::get('/email', [App\Http\Controllers\EmailController::class, 'create']);
Route::post('/email', [App\Http\Controllers\EmailController::class, 'sendEmail'])->name('send.email');

Route::middleware(['auth', 'role:admin'])->group(function(){

    
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/dashboard', 'Index')->name('admindashboard');
    
    });

    Route::controller(ProductController::class)->group(function(){
        Route::get('/admin/index-products', 'Index')->name('indexproducts');
        Route::get('/admin/create-product', 'CreateProduct')->name('createproduct');
        Route::post('/admin/store-product', 'StoreProduct')->name('storeproduct');

        Route::get('/admin/edit-product/{id}', 'EditProduct')->name('editproduct');
        Route::post('/admin/update-product/{id}', 'UpdateProduct')->name('updateproduct');

        Route::get('/admin/delete-product/{id}', 'DeleteProduct')->name('deleteproduct');
        Route::get('/admin/all-products', 'ShowProducts')->name('allproducts');
        Route::get('/admin/search-products', 'SearchProducts')->name('allproducts');

        Route::get('/admin/images-product/{id}', 'images')->name('imagesproduct');
        Route::get('/admin/delete-image/{id}', 'DeleteImage')->name('deleteimage');
        Route::post('/admin/add-images/{id}', 'AddImages')->name('addimages');

    });

    Route::controller(SaleController::class)->group(function(){
        Route::get('/admin/display-products', 'Index')->name('displayproducts');
        Route::get('/admin/sale-checkout', 'Checkout')->name('salecheckout');
        Route::get('/admin/view-product/{id}', 'ViewProduct')->name('viewproduct');
        

    });

    Route::controller(CartController::class)->group(function(){
        Route::get('/admin/cart', 'Index')->name('cart');
        Route::post('/admin/add-to-cart', 'AddToCart')->name('addtocart');
        Route::post('/admin/delete-cart', 'DeleteCart')->name('deletecart');
        Route::post('/admin/update-cart', 'UpdateCart')->name('updatecart');
        Route::get('/admin/clear-cart', 'ClearCart')->name('clearcart');
    });

    Route::controller(ReportController::class)->group(function(){
        Route::get('/admin/report', 'Index')->name('report');

    });

    Route::controller(StockController::class)->group(function(){
        Route::get('/admin/stock-products', 'StockProducts')->name('stockproducts');
        Route::get('/admin/configurations', 'ConfigurationsProfile')->name('configurations');
        Route::post('/admin/updatequantity/{id}', 'UpdateQuantity')->name('updatequantity');
        Route::get('/admin/readnotification', 'markAsReadNotification')->name('readnotification');
        Route::post('/admin/notificationMinimumStock/{id}', 'notificationMinimumStock')->name('notificationMinimumStock');

    });


});

require __DIR__.'/auth.php';


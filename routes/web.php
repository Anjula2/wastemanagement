<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WasteOrderController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('users.landing');
})->name('landing'); 

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/landing', function () {
        return view('users.landing');
    })->name('users.landing');
});

Route::get('/products', [ProductController::class, 'index'])->name('users.products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'index'])->name('users.products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('users.products.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('users.reviews.edit');
    Route::put('/reviews/{id}/update', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});




Route::get('/cart', [CartController::class, 'index'])->name('users.cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('users.cart.add');
Route::patch('/cart-items/{cartItem}', [CartController::class, 'update'])->name('users.cart.update');
Route::post('/cart/order', [CartController::class, 'placeOrder'])->name('users.cart.order');
Route::get('/checkout', [CartController::class, 'checkout'])->name('users.cart.checkout');
Route::post('/checkout', [CartController::class, 'checkout'])->name('users.cart.checkout');
Route::get('/showorders', [CartController::class, 'showorders']);
Route::delete('/cart-items/{id}', [CartController::class, 'destroy']);
Route::delete('/cart-items', [CartController::class, 'clear']);
Route::post('/checkout/confirm', [CartController::class, 'confirmOrder'])->name('users.cart.confirmOrder');

Route::get('/recycling-tips', [HomeController::class, 'recyclingtips'])->name('users.recyclingtips.recycling-tips');

Route::get('/schedule', [ScheduleController::class, 'schedule'])->name('users.schedule.schedule');

Route::get('/zonelist', [ScheduleController::class, 'zonelist'])->name('users.schedule.zonelist');

Route::get('/wasteorders', [HomeController::class, 'wasteorders'])->name('company.wasteorders');

Route::get('/companycart', [HomeController::class, 'companycart'])->name('company.companycart');

Route::post('/placeorder', [WasteOrderController::class, 'placeOrder'])->name('placeorder');

Route::delete('/wasteorders/{order}/cancel', [WasteOrderController::class, 'cancel'])->name('wasteorders.cancel');

Route::middleware('auth')->group(function () {
    Route::resource('complaints', ComplaintController::class);
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('users.complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('users.complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{id}/edit', [ProductController::class, 'edit'])->name('users.complaints.edit');
});



<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'home'])->name('index');
Route::get('/shop', [UserController::class, 'home'])->name('shop');
Route::post('/contact', [UserController::class, 'submitContact'])->name('contact.submit');

Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('user.productdetails');
Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // Order routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');

    // Review routes
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

Route::middleware(['auth', 'admin'])->group(function () {
    
    Route::get('/add_category', [AdminController::class, 'addCategory'])->name('admin.addcategory');
    Route::post('/add_category', [AdminController::class, 'postAddCategory'])->name('admin.postaddcategory');
    Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('admin.viewcategory');
    Route::delete('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categorydelete');
    Route::get('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('admin.categoryupdate');
    Route::post('/update_category/{id}', [AdminController::class, 'postUpdateCategory'])->name('admin.postupdatecategory');

    Route::get('/add_product', [AdminController::class, 'addProduct'])->name('admin.addproduct');
    Route::post('/add_product', [AdminController::class, 'postAddProduct'])->name('admin.postaddproduct');
    Route::get('/view_product', [AdminController::class, 'viewProduct'])->name('admin.viewproduct');
    Route::delete('/deleteproduct/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteproduct');
    Route::get('/updateproduct/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateproduct');
    Route::post('/updateproduct/{id}', [AdminController::class, 'postUpdateProduct'])->name('admin.postupdateproduct');
    
    Route::get('/view_order', [AdminController::class, 'viewOrder'])->name('admin.vieworder');
    Route::get('/print_invoice/{id}', [AdminController::class, 'printInvoice'])->name('admin.printinvoice');
    Route::post('/update_order_status/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.updateorderstatus');
    
    Route::get('/messages', [AdminController::class, 'viewMessages'])->name('admin.messages');

    Route::get('/product-search', [AdminController::class, 'productSearch'])->name('admin.productsearch');
});

require __DIR__.'/auth.php';
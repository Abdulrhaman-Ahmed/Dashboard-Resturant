<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home page - show all meals
Route::get('/', [HomeController::class, 'index'])->name('home');

// Filter meals by category
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category.filter');

// Cart Routes (Public - for guests and users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{meal}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Order Routes (Public)
Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/success/{order}', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// My Orders (Requires Auth)
Route::middleware('auth')->group(function() {
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource routes for Categories
    Route::resource('categories', CategoryController::class);

    // Resource routes for Meals
    Route::resource('meals', MealController::class);

    // Admin Orders Management
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('orders.admin');
    Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Order Management
    Route::delete('/orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
});

require __DIR__.'/auth.php';

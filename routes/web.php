<?php

use Illuminate\Support\Facades\Route;
// Controller untuk Halaman Publik
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;
// Controller untuk Pengguna Terotentikasi
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
// Controller Khusus Admin
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//=================================================
// RUTE PUBLIK (Dapat diakses siapa saja tanpa login)
//=================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{product:slug}', [ProductDetailController::class, 'show'])->name('product.detail');

Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'add')->name('add');
    Route::post('/update', 'update')->name('update');
    Route::post('/remove', 'remove')->name('remove');
});


//=================================================
// RUTE YANG MEMBUTUHKAN LOGIN (TEROTENTIKASI)
//=================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute "Gerbang" utama setelah login. Controller ini akan mengarahkan
    // pengguna berdasarkan perannya (admin atau user biasa).
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Rute untuk Semua Pengguna yang Login ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('orders.my-index');


    //=================================================
    // RUTE KHUSUS ADMIN
    //=================================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        
        // ## BARIS INI YANG DIPERBAIKI / DITAMBAHKAN ##
        // Rute ini khusus untuk URL /admin/dashboard dan diberi nama 'admin.dashboard'
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('users', UserController::class)->except(['create', 'store']);
        Route::resource('orders', OrderController::class)->only(['index', 'show']);
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Mengarahkan dari /admin saja ke /admin/dashboard
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
    });

});

// Memuat rute-rute otentikasi bawaan
require __DIR__.'/auth.php';
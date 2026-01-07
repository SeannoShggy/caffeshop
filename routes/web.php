<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| LANDING & CUSTOMER
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('landing.index'))->name('landing');

Route::get('/menu', function () {
    $products = Product::orderBy('name')->get();
    return view('landing.menu', compact('products'));
})->name('menu');

Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('checkout.review');
Route::post('/checkout/submit-proof', [CheckoutController::class, 'submitProof'])->name('checkout.submit_proof');
Route::get('/checkout/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.process');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (AUTH)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        // ================= DASHBOARD =================
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ================= PROFILE =================
        Route::get('profile/password', [UserController::class, 'editPassword'])
            ->name('profile.password.edit');
        Route::put('profile/password', [UserController::class, 'updatePassword'])
            ->name('profile.password.update');

        // ================= ORDERS =================
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.status');

        // ================= TRANSACTIONS =================
        Route::get('/transactions', [TransactionController::class, 'index'])
            ->name('transactions.index');

        // 🔥 EXPORT PDF BULANAN
        Route::get(
            '/transactions/export/pdf-monthly',
            [TransactionController::class, 'exportPdfMonthly']
        )->name('transactions.export.pdf.monthly');

        // 🔥 EXPORT EXCEL BULANAN
        Route::get(
            '/transactions/export/excel-monthly',
            [TransactionController::class, 'exportExcelMonthly']
        )->name('transactions.export.excel.monthly');

        // ================= PAYMENT METHODS =================
        Route::resource('payment_methods', PaymentMethodController::class);

        // ================= ADMIN ONLY =================
        Route::middleware('admin')->group(function () {

            Route::resource('categories', CategoryController::class);
            Route::resource('products', ProductController::class);
            Route::resource('users', UserController::class)->except(['show']);

            Route::get('stock', [StockController::class, 'index'])
                ->name('stock.index');
            Route::put('stock/{product}', [StockController::class, 'update'])
                ->name('stock.update');
        });
    });

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\MidtransWebhookController;

// User Area Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{event}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{event}', [EventController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment/{order_id}', [EventController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/{order_id}/force-success', [EventController::class, 'forceSuccess'])->name('checkout.forceSuccess');
Route::get('/payment/{order_id}/force-success', [EventController::class, 'forceSuccess'])->name('checkout.forceSuccess.get');
Route::get('/success/{order_id}', [EventController::class, 'success'])->name('checkout.success');
Route::get('/my-ticket/{transaction?}', [EventController::class, 'ticket'])->name('ticket');
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

// Admin Area Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::resource('events', AdminEventController::class);
        Route::resource('partners', PartnerController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});


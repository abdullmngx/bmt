<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

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
    return redirect('/users/login');
});

Route::prefix('users')->group(function () {
    Route::get('/login', [UserController::class, 'showLogin'])->name('user.login');
    Route::get('/tc', function () {
       return view('users.terms'); 
    })->name('user.terms');
    Route::get('/forgot', [UserController::class, 'showForgot'])->name('user.forgot');
    Route::post('forgot', [UserController::class, 'sendReset'])->middleware('guest')->name('password.email');
    Route::get('/reset/{token}', [UserController::class, 'showReset'])->middleware('guest')->name('password.reset');
    Route::post('/reset', [UserController::class, 'reset'])->middleware('guest')->name('password.update');
    Route::get('/register/{ref_id?}', [UserController::class, 'showRegister'])->name('user.register');

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register/{ref_id?}', [UserController::class, 'register']);

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::post('/set-bank', [UserController::class, 'setPayment']);
        Route::get('/generate-invoice/{plan_id}', [InvoiceController::class, 'generate']);
        Route::get('/invoice/{invoice_id}', [InvoiceController::class, 'showInvoice']);
        Route::post('/charge', [InvoiceController::class, 'createCharge']);
        Route::get('/payment', [InvoiceController::class, 'showPayment']);
        Route::get('/payment/verify/{code}', [InvoiceController::class, 'verify']);
        Route::get('/payment/success', [InvoiceController::class, 'success']);
        Route::get('/payment/failed/{code}', [InvoiceController::class, 'failed']);
        Route::get('/withdraw', [UserController::class, 'withdraw']);
        Route::post('/withdraw', [WithdrawalController::class, 'withdraw'])->name('user.withdraw');
        Route::get('/deposits', [UserController::class, 'deposits'])->name('user.deposits');
        Route::get('/earnings', [UserController::class, 'earnings'])->name('user.earnings');
        Route::get('/referrals', [UserController::class, 'referrals'])->name('user.referrals');
        Route::get('/withdrawals', [UserController::class, 'withdrawals'])->name('user.withdrawals');
        Route::get('/invoices', [UserController::class, 'transactions'])->name('user.transactions');
        Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
        Route::get('/payments/pay/accept', [InvoiceController::class, 'process']);
    });
});

Route::prefix('/admin')->group(function () {
    //open routes
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'processLogin']);
    Route::get('/forgot', [AdminController::class, 'showForgot'])->name('admin.forgot');

    Route::group(['middleware' => 'admin.auth:admin'], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/manage-plans', [PlanController::class, 'managePlans'])->name('admin.plans');
        Route::post('/plans/add', [PlanController::class, 'create']);
        Route::get('/plans/delete/{id}', [PlanController::class, 'destroy']);
        Route::get('/plans/activate/{id}', [PlanController::class, 'activate']);
        Route::get('/plans/block/{id}', [PlanController::class, 'block']);
        Route::get('/plans/reserve/{id}', [PlanController::class, 'reserve']);
        Route::post('/plans/activate', [AdminController::class, 'depositUser']);
        Route::get('/manage-users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{id}', [AdminController::class, 'singleUser'])->name('admin.single_user');
        Route::get('/manage-team', [AdminController::class, 'team'])->name('admin.team');
        Route::get('/deposits', [AdminController::class, 'deposits'])->name('admin.deposits');
        Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('admin.withdrawals');
        Route::get('/withdrawals/{id}', [AdminController::class, 'viewWithdrawal']);
        Route::get('/settings', [AdminController::class, 'showSettings'])->name('admin.settings');
        Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
        Route::post('/promotions', [AdminController::class, 'sendPromotional']);
        Route::post('/settings', [AdminController::class, 'saveSettings']);
        Route::post('/approve/{id}', [AdminController::class, 'approveWithdrawal']);
        Route::post('/decline/{id}', [AdminController::class, 'declineWithdrawal']);
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});



<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\StockTransactionController;
use App\Http\Controllers\Admin\RequestApprovalController;
use App\Http\Controllers\Admin\PurchaseOrderController as AdminPurchaseOrderController;
use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Leader\RequestController as LeaderRequestController;

use App\Http\Controllers\Finance\PurchaseOrderController as FinancePurchaseOrderController;

use App\Http\Controllers\Reports\StockReportController;
use App\Http\Controllers\Reports\MovementReportController;
use App\Http\Controllers\Reports\RequestReportController;
use App\Http\Controllers\Reports\POReportController;
use App\Http\Controllers\Reports\DashboardController;

use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
       Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('dashboard');

        // USER & ITEM MANAGEMENT
        Route::resource('users', UserController::class);
        Route::resource('items', ItemController::class);

        // STOCK TRANSACTIONS
        Route::get('stock-transactions', [StockTransactionController::class, 'index'])->name('stock_transactions.index');
        Route::get('stock-transactions/create-manual', [StockTransactionController::class, 'createManual'])->name('stock_transactions.create_manual');
        Route::post('stock-transactions/store-manual', [StockTransactionController::class, 'storeManual'])->name('stock_transactions.store_manual');

        /*
        |--------------------------------------------------------------------------
        | PURCHASE ORDER ADMIN (PERBAIKAN TERPENTING)
        |--------------------------------------------------------------------------
        */
        Route::resource('purchase-orders', AdminPurchaseOrderController::class);
        Route::post('purchase-orders/{purchaseOrder}/receive', [AdminPurchaseOrderController::class, 'receive'])
            ->name('purchase-orders.receive');

        /*
        |--------------------------------------------------------------------------
        | ADMIN APPROVAL REQUESTS
        |--------------------------------------------------------------------------
        */
        Route::get('/requests', [RequestApprovalController::class, 'index'])->name('requests.index');
        Route::get('/requests/{req}', [RequestApprovalController::class, 'edit'])->name('requests.edit');
        Route::post('/requests/{req}/approve', [RequestApprovalController::class, 'approve'])->name('requests.approve');
        Route::post('/requests/{req}/reject', [RequestApprovalController::class, 'reject'])->name('requests.reject');
        Route::post('/requests/{req}/forward', [RequestApprovalController::class, 'forward'])->name('requests.forward');

        /*
        |--------------------------------------------------------------------------
        | REPORT ROUTES
        |--------------------------------------------------------------------------
        */
        Route::prefix('reports')->name('reports.')->group(function () {

            Route::get('/stock', [StockReportController::class, 'index'])->name('stock');
            Route::get('/stock/pdf', [StockReportController::class, 'exportPdf'])->name('stock.pdf');
            Route::get('/stock/excel', [StockReportController::class, 'exportExcel'])->name('stock.excel');

            Route::get('/movement', [MovementReportController::class, 'index'])->name('movement');
            Route::get('/movement/pdf', [MovementReportController::class, 'exportPdf'])->name('movement.pdf');
            Route::get('/movement/excel', [MovementReportController::class, 'exportExcel'])->name('movement.excel');

            Route::get('/requests', [RequestReportController::class, 'index'])->name('request');
            Route::get('/requests/pdf', [RequestReportController::class, 'exportPdf'])->name('request.pdf');
            Route::get('/requests/excel', [RequestReportController::class, 'exportExcel'])->name('request.excel');

            Route::get('/po', [POReportController::class, 'index'])->name('po');
            Route::get('/po/pdf', [POReportController::class, 'exportPdf'])->name('po.pdf');
            Route::get('/po/excel', [POReportController::class, 'exportExcel'])->name('po.excel');

            // Dashboard Statistik
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        });

    });


/*
|--------------------------------------------------------------------------
| LEADER & FINANCE READ-ONLY ITEMS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:leader,finance'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.public.index');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.public.show');

    Route::get('/leader/dashboard', fn() => view('leader.dashboard'))->name('leader.dashboard');
    Route::get('/finance/dashboard', fn() => view('finance.dashboard'))->name('finance.dashboard');
});


/*
|--------------------------------------------------------------------------
| LEADER REQUEST MATERIAL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:leader'])
    ->prefix('leader')
    ->name('leader.')
    ->group(function () {

        Route::get('/requests', [LeaderRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/create', [LeaderRequestController::class, 'create'])->name('requests.create');
        Route::post('/requests', [LeaderRequestController::class, 'store'])->name('requests.store');
        Route::get('/requests/{req}', [LeaderRequestController::class, 'show'])->name('requests.show');
    });


/*
|--------------------------------------------------------------------------
| FINANCE - PURCHASE ORDER (KHUSUS FINANCE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:finance'])
    ->prefix('finance')
    ->name('finance.')
    ->group(function () {

        Route::get('/po', [FinancePurchaseOrderController::class, 'index'])->name('po.index');
        Route::get('/po/create', [FinancePurchaseOrderController::class, 'create'])->name('po.create');
        Route::post('/po', [FinancePurchaseOrderController::class, 'store'])->name('po.store');
        Route::get('/po/{po}', [FinancePurchaseOrderController::class, 'show'])->name('po.show');
        Route::post('/po/{po}/receive', [FinancePurchaseOrderController::class, 'receive'])->name('po.receive');
    });


/*
|--------------------------------------------------------------------------
| DEFAULT REDIRECT BASED ON ROLE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (!auth()->check()) return redirect('/login');

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'leader' => redirect()->route('leader.dashboard'),
        'finance' => redirect()->route('finance.dashboard'),
        default => abort(403)
    };

});


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS (ALL ROLES)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class,'index'])->name('notifications.index');

    Route::post('/notifications/mark-read/{id?}', 
        [NotificationController::class,'markAsRead']
    )->name('notifications.read');
});

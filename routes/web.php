<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\MasterTiketController;


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\Web\AuthController as WebAuthController;
use App\Http\Controllers\Settings\RolesController as RolesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('guest')->group(function () {
    Route::get('/signin', [WebAuthController::class, 'showForm'])->name('signin');
    Route::post('/signin', [WebAuthController::class, 'signin']); // Web signin
    Route::get('/signup', [WebAuthController::class, 'showForm'])->name('signup');

});

Route::post('/register', [WebAuthController::class, 'store']);

Route::middleware(['web', 'auth'])->group(function () {




    Route::prefix('tiket')->group(function () {
        Route::get('/', [TiketController::class, 'index'])->name('tiket');
        Route::post('/close/{id}', [TiketController::class, 'close_tiket'])->name('tiket.close');
        Route::post('/process/{id}', [TiketController::class, 'process_tiket'])->name('tiket.process');

        Route::post('/done/{id}', [TiketController::class, 'done_tiket'])->name('tiket.markAsDone');
        Route::post('/pending/{id}', [TiketController::class, 'pending_tiket'])->name('tiket.pending');


        Route::get('/waiting', [TiketController::class, 'getWaitingTickets'])->name('tiket.waiting.data');
        Route::get('/process', [TiketController::class, 'getProcessTickets'])->name('tiket.process.data');
        Route::get('/pending', [TiketController::class, 'getPendingTickets'])->name('tiket.pending.data');
        Route::get('/done', [TiketController::class, 'getDoneTickets'])->name('tiket.done.data');

        Route::get('/waiting/all', [TiketController::class, 'getWaitingTicketsAll'])->name('tiket.waiting.data.all');
        Route::get('/process/all', [TiketController::class, 'getProcessTicketsAll'])->name('tiket.process.data.all');
        Route::get('/pending/all', [TiketController::class, 'getPendingTicketsAll'])->name('tiket.pending.data.all');
        Route::get('/done/all', [TiketController::class, 'getDoneTicketsAll'])->name('tiket.done.data.all');
        Route::get('/{id}/detail_tiket', [TiketController::class, 'getDetails'])->name('tiket.details');

        Route::get('/suport', [TiketController::class, 'index_suport'])->name('tiket.suport');
        Route::get('/units', [TiketController::class, 'getUnits'])->name('tiket.units');
        Route::get('/units/{id_unit}/ruangans', [TiketController::class, 'getRuangansByUnit'])->name('tiket.units.ruangans');
        Route::get('/ruangans/{id_ruangan}/asets', [TiketController::class, 'getAsetsByRuangan'])->name('tiket.ruangans.asets');
        Route::post('/store', [TiketController::class, 'store'])->name('tickets.store');

        Route::get('/master_unit', [MasterTiketController::class, 'index'])->name('tiket.master.unit');

        // CRUD Unit
        Route::post('/units', [MasterTiketController::class, 'store'])->name('tiket.units.store');
        Route::put('/units/{id}', [MasterTiketController::class, 'update'])->name('tiket.units.update');
        Route::delete('/units/{id}', [MasterTiketController::class, 'destroy'])->name('units.destroy');

        // CRUD Ruangan nested dalam Unit
        Route::post('/units/{id_unit}/ruangans', [MasterTiketController::class, 'storeRuangan'])->name('tiket.ruangans.store');
        Route::delete('/units/{id_unit}/ruangans/{id_ruangan}', [MasterTiketController::class, 'destroyRuangan'])->name('tiket.ruangans.destroy');
        Route::get('/units/ruangans', [MasterTiketController::class, 'getRuangan'])->name('tiket.ruangan');


        //aset
        Route::get('/aset', [MasterTiketController::class, 'index_aset'])->name('tiket.master.aset');
        Route::get('/data_aset', [MasterTiketController::class, 'data_aset'])->name('tiket.data.aset');
        Route::post('/aset', [MasterTiketController::class, 'store_aset'])->name('tiket.aset.store');
        Route::get('/aset/{id}', [MasterTiketController::class, 'show_aset'])->name('tiket.aset.show');
        Route::put('/aset/{id}', [MasterTiketController::class, 'update_aset'])->name('tiket.aset.update');
        Route::delete('/aset/{id}', [MasterTiketController::class, 'destroy_aset'])->name('tiket.aset.destroy');


        // routes/web.php atau api.php
        Route::prefix('aset-detail')->group(function () {
            Route::get('/{id_aset}', [MasterTiketController::class, 'index_aset_detail'])->name('aset.detail.index');
            Route::post('/', [MasterTiketController::class, 'store_aset_detail'])->name('aset.detail.store');
            Route::get('/show/{id_detail}', [MasterTiketController::class, 'show_aset_detail'])->name('aset.detail.show');
            Route::put('/{id_detail}', [MasterTiketController::class, 'update_aset_detail'])->name('aset.detail.update');
            Route::delete('/{id_detail}', [MasterTiketController::class, 'destroy_aset_detail'])->name('aset.detail.destroy');
        });


        Route::prefix('laporan')->group(function () {
            Route::get('/', [MasterTiketController::class, 'index_aset_detail'])->name('tiket.laporan');
        });


        // Mutasi Aset
        Route::post('/aset/{id}/mutasi', [MasterTiketController::class, 'store_mutasi'])->name('tiket.aset.mutasi.store');
        Route::delete('/aset/mutasi/{id}', [MasterTiketController::class, 'destroy_mutasi'])->name('tiket.aset.mutasi.destroy');


        Route::get('/units/{id_unit}/detail', [TiketController::class, 'getUnitWithRelations']);
       
    });

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/signout', [WebAuthController::class, 'signout'])->name('signout');
    Route::get('/settings/roles', [RolesController::class, 'index'])->name('roles');
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');
    Route::get('/ecommerce/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/ecommerce/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/ecommerce/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/ecommerce/shop', function () {
        return view('pages/ecommerce/shop');
    })->name('shop');
    Route::get('/ecommerce/shop-2', function () {
        return view('pages/ecommerce/shop-2');
    })->name('shop-2');
    Route::get('/ecommerce/product', function () {
        return view('pages/ecommerce/product');
    })->name('product');
    Route::get('/ecommerce/cart', function () {
        return view('pages/ecommerce/cart');
    })->name('cart');
    Route::get('/ecommerce/cart-2', function () {
        return view('pages/ecommerce/cart-2');
    })->name('cart-2');
    Route::get('/ecommerce/cart-3', function () {
        return view('pages/ecommerce/cart-3');
    })->name('cart-3');
    Route::get('/ecommerce/pay', function () {
        return view('pages/ecommerce/pay');
    })->name('pay');
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
    Route::get('/community/users-tabs', [MemberController::class, 'indexTabs'])->name('users-tabs');
    Route::get('/community/users-tiles', [MemberController::class, 'indexTiles'])->name('users-tiles');
    Route::get('/community/profile', function () {
        return view('pages/community/profile');
    })->name('profile');
    Route::get('/community/feed', function () {
        return view('pages/community/feed');
    })->name('feed');
    Route::get('/community/forum', function () {
        return view('pages/community/forum');
    })->name('forum');
    Route::get('/community/forum-post', function () {
        return view('pages/community/forum-post');
    })->name('forum-post');
    Route::get('/community/meetups', function () {
        return view('pages/community/meetups');
    })->name('meetups');
    Route::get('/community/meetups-post', function () {
        return view('pages/community/meetups-post');
    })->name('meetups-post');
    Route::get('/finance/cards', function () {
        return view('pages/finance/credit-cards');
    })->name('credit-cards');
    Route::get('/finance/transactions', [TransactionController::class, 'index01'])->name('transactions');
    Route::get('/finance/transaction-details', [TransactionController::class, 'index02'])->name('transaction-details');
    Route::get('/job/job-listing', [JobController::class, 'index'])->name('job-listing');
    Route::get('/job/job-post', function () {
        return view('pages/job/job-post');
    })->name('job-post');
    Route::get('/job/company-profile', function () {
        return view('pages/job/company-profile');
    })->name('company-profile');
    Route::get('/messages', function () {
        return view('pages/messages');
    })->name('messages');
    Route::get('/tasks/kanban', function () {
        return view('pages/tasks/tasks-kanban');
    })->name('tasks-kanban');
    Route::get('/tasks/list', function () {
        return view('pages/tasks/tasks-list');
    })->name('tasks-list');
    Route::get('/inbox', function () {
        return view('pages/inbox');
    })->name('inbox');
    Route::get('/calendar', function () {
        return view('pages/calendar');
    })->name('calendar');
    Route::get('/settings/account', function () {
        return view('pages/settings/account');
    })->name('account');
    Route::get('/settings/notifications', function () {
        return view('pages/settings/notifications');
    })->name('notifications');
    Route::get('/settings/apps', function () {
        return view('pages/settings/apps');
    })->name('apps');
    Route::get('/settings/plans', function () {
        return view('pages/settings/plans');
    })->name('plans');
    Route::get('/settings/billing', function () {
        return view('pages/settings/billing');
    })->name('billing');
    Route::get('/settings/feedback', function () {
        return view('pages/settings/feedback');
    })->name('feedback');
    Route::get('/utility/changelog', function () {
        return view('pages/utility/changelog');
    })->name('changelog');
    Route::get('/utility/roadmap', function () {
        return view('pages/utility/roadmap');
    })->name('roadmap');
    Route::get('/utility/faqs', function () {
        return view('pages/utility/faqs');
    })->name('faqs');
    Route::get('/utility/empty-state', function () {
        return view('pages/utility/empty-state');
    })->name('empty-state');
    Route::get('/utility/404', function () {
        return view('pages/utility/404');
    })->name('404');
    Route::get('/utility/knowledge-base', function () {
        return view('pages/utility/knowledge-base');
    })->name('knowledge-base');
    Route::get('/onboarding-01', function () {
        return view('pages/onboarding-01');
    })->name('onboarding-01');
    Route::get('/onboarding-02', function () {
        return view('pages/onboarding-02');
    })->name('onboarding-02');
    Route::get('/onboarding-03', function () {
        return view('pages/onboarding-03');
    })->name('onboarding-03');
    Route::get('/onboarding-04', function () {
        return view('pages/onboarding-04');
    })->name('onboarding-04');
    Route::get('/component/button', function () {
        return view('pages/component/button-page');
    })->name('button-page');
    Route::get('/component/form', function () {
        return view('pages/component/form-page');
    })->name('form-page');
    Route::get('/component/dropdown', function () {
        return view('pages/component/dropdown-page');
    })->name('dropdown-page');
    Route::get('/component/alert', function () {
        return view('pages/component/alert-page');
    })->name('alert-page');
    Route::get('/component/modal', function () {
        return view('pages/component/modal-page');
    })->name('modal-page');
    Route::get('/component/pagination', function () {
        return view('pages/component/pagination-page');
    })->name('pagination-page');
    Route::get('/component/tabs', function () {
        return view('pages/component/tabs-page');
    })->name('tabs-page');
    Route::get('/component/breadcrumb', function () {
        return view('pages/component/breadcrumb-page');
    })->name('breadcrumb-page');
    Route::get('/component/badge', function () {
        return view('pages/component/badge-page');
    })->name('badge-page');
    Route::get('/component/avatar', function () {
        return view('pages/component/avatar-page');
    })->name('avatar-page');
    Route::get('/component/tooltip', function () {
        return view('pages/component/tooltip-page');
    })->name('tooltip-page');
    Route::get('/component/accordion', function () {
        return view('pages/component/accordion-page');
    })->name('accordion-page');
    Route::get('/component/icons', function () {
        return view('pages/component/icons-page');
    })->name('icons-page');
    Route::fallback(function() {
        return view('pages/utility/404');
    });
});

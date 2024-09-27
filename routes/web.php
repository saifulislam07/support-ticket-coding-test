<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerTicketController;

Route::get('/', function () {
    return view('auth.login');
});


// customer routes
Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['customer'], 'prefix' => 'customer'], function () {
        Route::get('/dashboard', function () {
            return view('customer.dashboard');
        })->name('customer.dashboard');

        Route::get('/create', [CustomerTicketController::class, 'create'])->name('ticket.create');
        Route::get('/index', [CustomerTicketController::class, 'index'])->name('ticket.index');
        Route::get('{ticekt_id}/show', [CustomerTicketController::class, 'show'])->name('ticket.show');
        Route::post('/store', [CustomerTicketController::class, 'store'])->name('ticket.store');
        Route::post('/reply/{ticekt_id}', [CustomerTicketController::class, 'replyStore'])->name('ticket.reply.store');
    });


    // admin routes
    Route::group(['middleware' => ['admin'], 'prefix' => 'admin'], function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('/list', [ProfileController::class, 'index'])->name('admin.user.index');
        Route::get('/index', [TicketController::class, 'index'])->name('admin.ticket.index');
        Route::get('{ticekt_id}/show', [TicketController::class, 'show'])->name('admin.ticket.show');
        Route::post('/reply/{ticekt_id}', [TicketController::class, 'replyStore'])->name('admin.ticket.reply.store');
        Route::post('/ticket/update-status', [TicketController::class, 'updateStatus'])->name('admin.ticket.updateStatus');
    });


    // common routes
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

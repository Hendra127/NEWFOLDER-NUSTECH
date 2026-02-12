<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenTicketController;
use App\Http\Controllers\CloseTicketController;
use App\Http\Controllers\DetailTicketDashboardController;
use App\Http\Controllers\SummaryTicketController;

// OPEN
Route::get('/open-ticket', [OpenTicketController::class, 'index'])->name('open.ticket');
Route::post('/open-ticket/store', [OpenTicketController::class, 'store'])->name('open.ticket.store');
Route::get('/open-ticket/export', [OpenTicketController::class, 'export'])->name('open.ticket.export');
Route::post('/open-ticket/import', [OpenTicketController::class, 'import'])->name('open.ticket.import');

// CLOSE
Route::get('/close-ticket', [CloseTicketController::class, 'index'])->name('close.ticket');
Route::post('/close-ticket/store', [CloseTicketController::class, 'store'])->name('close.ticket.store');
Route::get('/close-ticket/export', [CloseTicketController::class, 'export'])->name('close.ticket.export');
Route::post('/close-ticket/import', [CloseTicketController::class, 'import'])->name('close.ticket.import');

// DETAIL TICKET
Route::get('/detail-ticket', [DetailTicketDashboardController::class, 'index'])
    ->name('detail.ticket.dashboard');

// SUMMARY
Route::get('/summary-ticket', [SummaryTicketController::class, 'index'])
    ->name('summary.ticket');

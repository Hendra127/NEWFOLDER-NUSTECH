<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenTicketController;

Route::get('/open-ticket', [OpenTicketController::class, 'index'])->name('open');
Route::post('/open-ticket/store', [OpenTicketController::class, 'store'])->name('ticket.store');
Route::post('/open-ticket/import', [OpenTicketController::class, 'import'])->name('ticket.import');
Route::get('/open-ticket/export', [OpenTicketController::class, 'export'])->name('ticket.export');
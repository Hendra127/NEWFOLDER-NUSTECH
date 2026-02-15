<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenTicketController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DatapasController;
use App\Http\Controllers\LaporanpmController;
use App\Http\Controllers\PMLibertaController;
use App\Http\Controllers\CloseTicketController;
use App\Http\Controllers\DetailTicketDashboardController;
use App\Http\Controllers\SummaryTicketController;
use App\Http\Controllers\PergantianController;
use App\Http\Controllers\LogpergantianController;
use App\Http\Controllers\SparetrackerController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TodolistController;

// Open Ticket Routes
Route::get('/open-ticket', [OpenTicketController::class, 'index'])->name('open');
Route::post('/open-ticket/store', [OpenTicketController::class, 'store'])->name('ticket.store');
Route::post('/open-ticket/import', [OpenTicketController::class, 'import'])->name('ticket.import');
Route::get('/open-ticket/export', [OpenTicketController::class, 'export'])->name('ticket.export');

// Data Site Routes
Route::get('/sites', [SiteController::class, 'index'])->name('datasite');

// Data Pas Routes
Route::get('/datapass', [DatapasController::class, 'index'])->name('datapas');
Route::post('/datapas/store', [DatapasController::class, 'store'])->name('datapas.store');

// Laporan PM Routes
Route::get('/laporanpm', [LaporanpmController::class, 'index'])->name('laporanpm');

// PM Liberta Routes
Route::get('/PMLiberta', [PMLibertaController::class, 'index'])->name('pmliberta');

// My Dashboard Routes
Route::get('/mydashboard', [App\Http\Controllers\MyDashboardController::class, 'index'])->name('mydashboard');

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


// Pergantian Perangkat Routes
Route::get('/pergantianperangkat', [App\Http\Controllers\PergantianController::class, 'index'])->name('pergantianperangkat');

// Log Pergantian Routes
Route::get('/logpergantian', [App\Http\Controllers\LogpergantianController::class, 'index'])->name('logpergantian');

// Spare Tracker Routes
Route::get('/sparetracker', [SparetrackerController::class, 'index'])->name('sparetracker.index');
Route::post('/sparetracker/import', [SparetrackerController::class, 'import'])->name('sparetracker.import');
Route::get('/sparetracker/export', [SparetrackerController::class, 'export'])->name('sparetracker.export');
Route::post('/sparetracker/store', [SparetrackerController::class, 'store'])->name('sparetracker.store');
Route::post('/sparetracker/update', [SparetrackerController::class, 'update'])->name('sparetracker.update');
Route::delete('/sparetracker/delete/{id}', [SparetrackerController::class, 'destroy'])->name('sparetracker.destroy');

// Summary Routes
Route::get('/summary', [App\Http\Controllers\SummaryController::class, 'index'])->name('summaryperangkat');

// To Do List Routes
Route::get('/todolist', [App\Http\Controllers\TodolistController::class, 'index'])->name('todolist');
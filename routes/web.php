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
use App\Http\Controllers\MyDashboardController;

// --- SITES / DATASITE ROUTES ---
Route::get('/sites/export', [SiteController::class, 'export'])->name('sites.export');
Route::post('/sites/import', [SiteController::class, 'import'])->name('sites.import');

Route::resource('sites', SiteController::class)->names([
    'index' => 'datasite'
])->except(['show', 'create', 'edit']);

// --- OPEN TICKET ROUTES ---
Route::get('/open-ticket', [OpenTicketController::class, 'index'])->name('open.ticket');
Route::post('/open-ticket/store', [OpenTicketController::class, 'store'])->name('open.ticket.store');
Route::get('/open-ticket/export', [OpenTicketController::class, 'export'])->name('open.ticket.export');
Route::post('/open-ticket/import', [OpenTicketController::class, 'import'])->name('open.ticket.import');
Route::put('/open-ticket/{id}', [OpenTicketController::class, 'update'])->name('open.ticket.update');
Route::delete('/open-ticket/{id}', [OpenTicketController::class, 'destroy'])->name('open.ticket.destroy');

// --- CLOSE TICKET ROUTES ---
Route::get('/close-ticket', [CloseTicketController::class, 'index'])->name('close.ticket');
Route::post('/close-ticket/store', [CloseTicketController::class, 'store'])->name('close.ticket.store');
Route::get('/close-ticket/export', [CloseTicketController::class, 'export'])->name('close.ticket.export');
Route::post('/close-ticket/import', [CloseTicketController::class, 'import'])->name('close.ticket.import');
Route::put('/open-ticket/close/{id}', [OpenTicketController::class, 'closeTicket'])->name('open.ticket.close');

// --- DATA PAS ROUTES ---
Route::get('/datapass', [DatapasController::class, 'index'])->name('datapas');
Route::post('/datapas/store', [DatapasController::class, 'store'])->name('datapas.store');
Route::get('/datapas/export', [DatapasController::class, 'export'])->name('datapas.export');
Route::post('/datapas/import', [DatapasController::class, 'import'])->name('datapas.import');
Route::put('/datapass/{id}', [DatapasController::class, 'update'])->name('datapas.update');
Route::delete('/datapass/{id}', [DatapasController::class, 'destroy'])->name('datapas.destroy');

// --- MODUL LAINNYA ---
Route::get('/mydashboard', [MyDashboardController::class, 'index'])->name('mydashboard');
Route::get('/laporanpm', [LaporanpmController::class, 'index'])->name('laporanpm');
Route::get('/PMLiberta', [PMLibertaController::class, 'index'])->name('pmliberta');
Route::get('/detail-ticket', [DetailTicketDashboardController::class, 'index'])->name('detail.ticket.dashboard');
Route::get('/summary-ticket', [SummaryTicketController::class, 'index'])->name('summary.ticket');
Route::get('/pergantianperangkat', [PergantianController::class, 'index'])->name('pergantianperangkat');
Route::get('/logpergantian', [LogpergantianController::class, 'index'])->name('logpergantian');
Route::get('/sparetracker', [SparetrackerController::class, 'index'])->name('sparetracker');
Route::get('/summary', [SummaryController::class, 'index'])->name('summaryperangkat');
Route::get('/todolist', [TodolistController::class, 'index'])->name('todolist');
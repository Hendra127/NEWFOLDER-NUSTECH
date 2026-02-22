<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DetailticketController extends Controller
{
    public function index()
    {
        // LIST OPEN TICKET (kiri)
        $openTickets = Ticket::where('status', 'open')
            ->latest()
            ->take(20)
            ->get();

        // CHART LINE: CLOSE PER BULAN
        // Format: 2026-01, 2026-02, dst
        $closePerMonthRaw = Ticket::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->where('status', 'close')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $closeLabels = $closePerMonthRaw->pluck('ym')->toArray();
        $closeTotals = $closePerMonthRaw->pluck('total')->toArray();

        // BAR: OPEN PER KABUPATEN
        $openByKabRaw = Ticket::selectRaw("kabupaten, COUNT(*) as total")
            ->where('status', 'open')
            ->groupBy('kabupaten')
            ->orderByDesc('total')
            ->limit(12)
            ->get();

        $kabLabels = $openByKabRaw->pluck('kabupaten')->toArray();
        $kabTotals = $openByKabRaw->pluck('total')->toArray();

        return view('detailticket', compact(
            'openTickets',
            'closeLabels',
            'closeTotals',
            'kabLabels',
            'kabTotals'
        ));
    }
}

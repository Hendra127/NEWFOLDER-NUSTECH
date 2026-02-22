<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class SummaryTicketController extends Controller
{
    public function index(Request $request)
    {
        // 1. Filter bulan (format: YYYY-MM) dari request dropdown
        $month = $request->month;

        // 2. Ambil list bulan untuk dropdown (hanya bulan yang ada datanya)
        $months = Ticket::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('ym');

        // 3. CHART 1: OPEN TICKET PER BULAN (Bar Chart)
        // Menampilkan total tiket berstatus 'open' per bulan (0-12)
        $openPerMonthRaw = Ticket::selectRaw("MONTH(created_at) as m, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('m')
            ->orderBy('m')
            ->get();

        $openLabels = range(0, 12);
        $openTotals = array_fill(0, 13, 0);
        foreach ($openPerMonthRaw as $row) {
            $idx = (int)$row->m;
            if ($idx >= 0 && $idx <= 12) {
                $openTotals[$idx] = (int)$row->total;
            }
        }

        $durasiRaw = Ticket::selectRaw("FLOOR(COALESCE(durasi,0)/10) as grp, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('grp')
            ->orderBy('grp')
            ->limit(7)
            ->get();

        $durasiLabels = ['0','1','2','3','4','5','6'];
        $durasiTotals = array_fill(0, 7, 0);
        foreach ($durasiRaw as $row) {
            $idx = (int)$row->grp;
            if ($idx >= 0 && $idx <= 6) {
                $durasiTotals[$idx] = (int)$row->total;
            }
        }

  
        $kategoriSummary = Ticket::selectRaw("
                kategori,
                SUM(CASE WHEN status='close' THEN 1 ELSE 0 END) as close_total,
                SUM(CASE WHEN status='open' THEN 1 ELSE 0 END) as open_total
            ")
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->get();

        $grandClose = (int) $kategoriSummary->sum('close_total');
        $grandOpen  = (int) $kategoriSummary->sum('open_total');

        $openByKategori = Ticket::selectRaw("kategori, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $openGrand = (int) $openByKategori->sum('total');

        $closeByKategori = Ticket::selectRaw("kategori, COUNT(*) as total")
            ->where('status', 'close')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $closeGrand = (int) $closeByKategori->sum('total');

        $kabupatenTable = Ticket::selectRaw("
                kabupaten,
                COUNT(*) as status_total,
                SUM(COALESCE(durasi,0)) as durasi_total
            ")
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kabupaten')
            ->orderByDesc('status_total')
            ->limit(13)
            ->get();

        return view('summaryticket', compact(
            'month',
            'months',
            'openLabels',
            'openTotals',
            'durasiLabels',
            'durasiTotals',
            'kategoriSummary',
            'grandClose',
            'grandOpen',
            'openByKategori',
            'openGrand',
            'closeByKategori',
            'closeGrand',
            'kabupatenTable'
        ));
    }
}
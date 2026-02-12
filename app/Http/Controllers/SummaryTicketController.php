<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class SummaryTicketController extends Controller
{
    public function index(Request $request)
    {
        // filter bulan (format: YYYY-MM)
        $month = $request->month;

        // =========================
        // FILTER QUERY BASE
        // =========================
        $base = Ticket::query();

        if ($month) {
            $base->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
        }

        // =========================
        // DROPDOWN MONTHS
        // =========================
        $months = Ticket::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('ym');

        // =========================
        // CHART 1: OPEN TICKET PER BULAN (bar)
        // =========================
        $openPerMonthRaw = Ticket::selectRaw("MONTH(created_at) as m, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('m')
            ->orderBy('m')
            ->get();

        // bikin label 0-12 seperti gambar
        $openLabels = range(0, 12);
        $openTotals = array_fill(0, 13, 0);

        foreach ($openPerMonthRaw as $row) {
            $idx = (int)$row->m;
            if ($idx >= 0 && $idx <= 12) {
                $openTotals[$idx] = (int)$row->total;
            }
        }

        // =========================
        // CHART 2: DURASI OPEN TICKET (bar)
        // =========================
        $durasiRaw = Ticket::selectRaw("FLOOR(COALESCE(durasi,0)/10) as grp, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('grp')
            ->orderBy('grp')
            ->limit(7)
            ->get();

        $durasiLabels = [];
        $durasiTotals = [];

        foreach ($durasiRaw as $row) {
            $durasiLabels[] = (string)$row->grp;
            $durasiTotals[] = (int)$row->total;
        }

        if (count($durasiLabels) === 0) {
            $durasiLabels = ['0','1','2','3','4','5','6'];
            $durasiTotals = [0,0,0,0,0,0,0];
        }

        // =========================
        // TABLE: OPEN & CLOSE PER BULAN (KATEGORI)
        // =========================
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

        // =========================
        // TABLE: OPEN TICKET / HARI
        // =========================
        $openByKategori = Ticket::selectRaw("kategori, COUNT(*) as total")
            ->where('status', 'open')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $openGrand = (int) $openByKategori->sum('total');

        // =========================
        // TABLE: CLOSE TICKET / HARI
        // =========================
        $closeByKategori = Ticket::selectRaw("kategori, COUNT(*) as total")
            ->where('status', 'close')
            ->when($month, function($q) use ($month){
                $q->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month]);
            })
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $closeGrand = (int) $closeByKategori->sum('total');

        // =========================
        // TABLE BAWAH: KABUPATEN
        // =========================
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

        return view('summary', compact(
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

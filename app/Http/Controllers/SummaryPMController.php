<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SitePM; // Pastikan model Anda sesuai
use Illuminate\Support\Facades\DB;
use App\Models\PMLiberta; // Pastikan model Anda sesuai
class SummaryPMController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Counter Box (BMN, SL, Total)
        $bmnCount = PMLiberta::where('kategori', 'BMN')->where('status', 'DONE')->count();
        $slCount = PMLiberta::where('kategori', 'SL')->where('status', 'DONE')->count();
        $totalCount = $bmnCount + $slCount;

        // 2. Data untuk Chart (Total Done per Tanggal di bulan berjalan)
        // Mengambil data jumlah 'DONE' per hari
        $chartData = PMLiberta::select(DB::raw('DATE(date) as date'), DB::raw('count(*) as total'))
            ->where('status', 'DONE')
            ->whereMonth('date', now()->month)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 3. Data untuk Tabel Summary per Bulan
        $monthlySummary = PMLiberta::select(
                'month',
                DB::raw("SUM(CASE WHEN kategori = 'BMN' THEN 1 ELSE 0 END) as bmn_total"),
                DB::raw("SUM(CASE WHEN kategori = 'SL' THEN 1 ELSE 0 END) as sl_total")
            )
            ->where('status', 'DONE')
            ->groupBy('month')
            ->get();

        // 4. Data untuk List Site PM (dengan Fitur Search & Pagination)
        $query = PMLiberta::query();

        if ($request->has('search')) {
            $query->where('nama_site', 'like', '%' . $request->search . '%')
                  ->orWhere('site_id', 'like', '%' . $request->search . '%');
        }

        $sites = $query->paginate(10); // Menggunakan pagination agar ringan

        return view('summarypm', compact(
            'bmnCount',     
            'slCount', 
            'totalCount', 
            'chartData', 
            'monthlySummary', 
            'sites'
        ));
    }
}
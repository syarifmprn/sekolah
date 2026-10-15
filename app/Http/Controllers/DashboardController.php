<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\Pengumuman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerita = Berita::count();
        $totalGuru = Guru::count();
        $totalPrestasi = Prestasi::count();
        $totalPengumuman = Pengumuman::count();
        
        // Bar Chart Data (Berita per Month)
        $monthExpr = \Illuminate\Support\Facades\DB::connection()->getDriverName() === 'sqlite'
            ? "cast(strftime('%m', tanggal) as integer) as month"
            : 'MONTH(tanggal) as month';

        $beritaPerMonth = Berita::selectRaw("{$monthExpr}, count(*) as total")
                            ->whereYear('tanggal', date('Y'))
                            ->groupBy('month')
                            ->pluck('total', 'month')
                            ->toArray();
        $chartBerita = array_fill(1, 12, 0);
        foreach($beritaPerMonth as $month => $total) {
            $chartBerita[$month] = $total;
        }

        // Pie Chart Data (Prestasi by Type)
        $prestasiByTipe = Prestasi::selectRaw('tipe, count(*) as total')
                            ->groupBy('tipe')
                            ->pluck('total', 'tipe')
                            ->toArray();

        return view('dashboard', compact(
            'totalBerita', 
            'totalGuru', 
            'totalPrestasi', 
            'totalPengumuman', 
            'chartBerita', 
            'prestasiByTipe'
        ));
    }
}

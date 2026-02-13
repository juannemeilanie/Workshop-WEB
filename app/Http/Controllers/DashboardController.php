<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index () {
        $buku = DB::table('buku')
                ->join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
                ->select('buku.*', 'kategori.nama_kategori')
                ->orderBy('buku.idbuku', 'asc')
                ->get();
        $kategori = DB::table('kategori')->get();
        $totalBuku = $buku->count();
        $totalKategori = $kategori->count();
        return view ('dashboard', compact('buku', 'totalBuku', 'kategori', 'totalKategori'));
    }
}

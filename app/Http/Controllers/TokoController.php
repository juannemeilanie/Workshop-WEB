<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return view('toko.index', compact('tokos'));
    }

    public function create()
    {
        return view('toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy'  => 'required|numeric',
        ]);

        $barcode = 'TKO-' . strtoupper(substr(uniqid(), -4));
        Toko::create([
            'barcode'   => $barcode,
            'nama_toko' => $request->nama_toko,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy'  => $request->accuracy,
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan');
    }

    public function kunjungan()
    {
        return view('toko.kunjungan');
    }

    public function cetakBarcode(Toko $toko)
    {
        return view('toko.barcode', compact('toko'));
    }

    public function findByBarcode(Request $request)
    {
        $toko = Toko::where('barcode', $request->barcode)->first();

        if (!$toko) {
            return response()->json(['error' => 'Toko tidak ditemukan'], 404);
        }

        return response()->json($toko);
    }

    public function cekKunjungan(Request $request)
    {
        $toko = Toko::where('barcode', $request->barcode)->first();

        if (!$toko) {
            return response()->json(['error' => 'Toko tidak ditemukan'], 404);
        }

        $jarakAktual      = $this->haversine(
            $toko->latitude,
            $toko->longitude,
            $request->sales_latitude,
            $request->sales_longitude
        );

        $threshold        = 300;
        $thresholdEfektif = $threshold + $toko->accuracy + $request->sales_accuracy;
        $status           = $jarakAktual <= $thresholdEfektif ? 'diterima' : 'ditolak';

        return response()->json([
            'status'            => $status,
            'jarak_aktual'      => round($jarakAktual),
            'threshold_efektif' => round($thresholdEfektif),
            'toko'              => $toko->nama_toko,
            'sales_latitude'    => $request->sales_latitude,
            'sales_longitude'   => $request->sales_longitude,
            'sales_accuracy'    => $request->sales_accuracy,
        ]);
    }

    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $R    = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
                + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        $c    = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

}

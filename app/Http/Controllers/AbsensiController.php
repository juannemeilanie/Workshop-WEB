<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function scan(){
        return view('nfc.scan');
    }

    public function proses(Request $request){
        $request->validate([
            'nfc_serial'  => 'required|string',
            'matakuliah' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::where('nfc_serial', $request->nfc_serial)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu NFC tidak terdaftar',
            ], 404);
        }

        $sudahAbsen = Absensi::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
            ->where('matakuliah', $request->matakuliah)
            ->whereDate('waktu_absen', today())
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'success' => false,
                'message' => $mahasiswa->nama . ' sudah absen hari ini',
            ]);
        }

        Absensi::create([
            'mahasiswa_id' => $mahasiswa->mahasiswa_id,
            'matakuliah'  => $request->matakuliah,
            'status'       => 'hadir',
            'waktu_absen'  => now(),
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Absensi berhasil dicatat',
            'mahasiswa'  => [
                'nim'         => $mahasiswa->nim,
                'nama'        => $mahasiswa->nama,
                'waktu_absen' => now()->format('H:i:s'),
            ],
        ]);
    }

    public function index()
    {
        $absensis = Absensi::with('mahasiswa')->orderByDesc('waktu_absen')->get();
        return view('nfc.absensi', compact('absensis'));
    }
}

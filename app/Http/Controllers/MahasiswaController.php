<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(){
        $mahasiswas = Mahasiswa::all();
        return view('nfc.index', compact('mahasiswas'));
    }

    public function create(){
        return view('nfc.mahasiswa');
    }

    public function store(Request $request){
        $request->validate([
            'nim'  => 'required|string|unique:mahasiswa,nim',
            'nama' => 'required|string',
            'jurusan' => 'required|string',
        ]);

        Mahasiswa::create([
            'nim'  => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function daftarNfc($id){
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('nfc.daftar', compact('mahasiswa'));
    }

    public function simpanNfc(Request $request, $id){
        $request->validate([
            'nfc_serial' => 'required|string|unique:mahasiswa,nfc_serial',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update(['nfc_serial' => $request->nfc_serial]);

        return redirect()->route('mahasiswa.index')->with('success', 'Kartu NFC berhasil didaftarkan');
    }
}

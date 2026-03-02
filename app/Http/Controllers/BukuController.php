<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index(){
        $buku = DB::table('buku')
                ->join('kategori', 'buku.idkategori', '=', 'kategori.idkategori')
                ->select('buku.*', 'kategori.nama_kategori')
                ->orderBy('buku.idbuku', 'asc')
                ->get();
        return view('buku.index', compact('buku'));
    }

    public function create(){
        $buku = DB::table('buku')->get();
        $kategori = DB::table('kategori')->get();
        return view('buku.tambah', compact('buku', 'kategori'));
    }

    public function store(Request $request){
        $validatedData = $this->validateBuku($request);

        $this->createBuku($validatedData);

        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil ditambahkan.');

    }

    public function edit($id){
        $buku = DB::table('buku')->where('idbuku', $id)->first();
        $kategori = DB::table('kategori')->get();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id){
        $validatedData = $this->validateBuku($request, $id);

        DB::table('buku')->where('idbuku', $id)->update([
            'kode' => $validatedData['kode'],
            'judul' => $validatedData['judul'],
            'pengarang' => $validatedData['pengarang'],
            'idkategori' => $validatedData['idkategori'],
        ]);

        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil diperbarui.');
    }

    protected function validateBuku(Request $request, $id = null){
        $uniqueRule = $id
            ? 'unique:buku,kode,' . $id . ',idbuku'
            : 'unique:buku,kode';

        return $request->validate([
            'kode' => 'required|string|max:5|' . $uniqueRule,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,idkategori',
        ], [
            'kode.required' => 'Kode wajib diisi.',
            'kode.string' => 'Kode harus berupa teks.',
            'kode.max' => 'Kode maksimal 5 karakter.',
            'kode.unique' => 'Kode buku sudah digunakan.',

            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 255 karakter.',

            'pengarang.required' => 'Pengarang wajib diisi.',
            'pengarang.string' => 'Pengarang harus berupa teks.',
            'pengarang.max' => 'Pengarang maksimal 255 karakter.',

            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori.exists' => 'Kategori yang dipilih tidak valid.',
        ]);
    }

    protected function createBuku(array $data){
        return DB::table('buku')->insert([
            'kode' => $data['kode'],
            'judul' => $data['judul'],
            'pengarang' => $data['pengarang'],
            'idkategori' => $data['idkategori'],
        ]);
    }

    public function destroy($id){
        DB::table('buku')->where('idbuku', $id)->delete();
        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil dihapus.');
    }
}

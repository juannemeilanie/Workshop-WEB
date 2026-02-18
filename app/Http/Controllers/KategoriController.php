<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(){
        $kategori = DB::table('kategori')
                ->orderBy('idkategori', 'asc')
                ->get();
        return view('kategori.index', compact('kategori'));
    }

    public function create(){
        $kategori = DB::table('kategori')->get();
        return view('kategori.tambah', compact('kategori'));
    }

    public function store(Request $request){
        $validatedData = $this->validateKategori($request);

        $this->createKategori($validatedData);

        return redirect()->route('kategori.index')
                        ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id){
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        return view('kategori.edit', compact('kategori'));
    }

    protected function validateKategori(Request $request, $id = null){
        $uniqueRule = $id ? 
        'unique:kategori,' . $id . ',idkategori': 
        'unique:kategori';

        return $request->validate([
            'nama_kategori' => 'required|string|max:255|' . $uniqueRule,
        ], [
            'nama_kategori.required' => 'Nama Kategori wajib diisi.',
            'nama_kategori.string' => 'Nama Kategori harus berupa teks.',
            'nama_kategori.max' => 'Nama Kategori maksimal 255 karakter.',
        ]);
    }

    protected function createKategori(array $data){
        return DB::table('kategori')->insert([
            'nama_kategori' => $data['nama_kategori'],
        ]);
    }

    public function destroy($id){
        DB::table('kategori')->where('idkategori', $id)->delete();
        return redirect()->route('kategori.index')
                        ->with('success', 'Kategori berhasil dihapus.');
    }
}

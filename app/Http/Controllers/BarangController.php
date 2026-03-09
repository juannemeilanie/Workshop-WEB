<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function create(){
        return view('barang.tambah');
    }

    public function store(Request $request){
        $this->validateBarang($request);

        Barang::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id){
        $barang = Barang::where('id_barang', $id)->first();
        return view('barang.edit', compact('barang'));
    }

       protected function validateBarang(Request $request, $id = null){
        $uniqueRule = $id
            ? 'unique:barang,nama,' . $id . ',id_barang'
            : 'unique:barang,nama';

        return $request->validate([
            'nama' => 'required|string|max:50|' . $uniqueRule,
            'harga' => 'required|integer',
        ], [
            'nama.required' => 'Nama Barang wajib diisi',
            'nama.string' => 'Nama Barang harus berupa teks',
            'nama.max' => 'Nama Barang maksimal 50 karakter',
            'nama.unique' => 'Nama Barang sudah ada',
            'harga.required' => 'Harga Barang wajib diisi',
            'harga.integer' => 'Harga Barang harus berupa angka',
        ]);

    }

    public function update(Request $request, $id){
        $validatedData = $this->validateBarang($request, $id);

        Barang::where('id_barang', $id)->update([
            'nama' => $validatedData['nama'],
            'harga' => $validatedData['harga'],
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy($id){
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    public function cetak(Request $request){
    $request->validate([
        'id_barang' => 'required|array|min:1',
        'x' => 'required|integer|min:1|max:5',
        'y' => 'required|integer|min:1|max:8',
    ]);

    $barangDipilih = Barang::whereIn('id_barang', $request->id_barang)->get();


    $x = (int) $request->x;
    $y = (int) $request->y;
    $startIndex = (($y - 1) * 5) + $x;
    $labels = array_fill(1, 40, null);

    $index = $startIndex;
    foreach ($barangDipilih as $barang) {
        if ($index <= 40) {
            $labels[$index] = $barang;
            $index++;
        }
    }

    $mm = 2.83465; 
    $pdf = Pdf::loadView('barang.cetak', compact('labels'))
        ->setPaper([0, 0, 210 * $mm, 165 * $mm], 'potrait');
    return $pdf->stream('tag-harga.pdf');
    }
}

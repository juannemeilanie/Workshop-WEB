<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index1()
    {
        return view('pos.index_jquery');
    }

    public function index2()
    {
        return view('pos.index_axios');
    }

    public function getBarang($id)
    {
        $barang = DB::table('barang')
                    ->where('id_barang', $id)
                    ->first();
 
        if (!$barang) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Barang tidak ditemukan'
            ]);
        }
 
        return response()->json([
            'status' => 'success',
            'data'   => $barang
        ]);
    }
 
    public function simpan(Request $request)
    {
        $items = $request->items;
        $total = 0;
 
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
 
        $id_penjualan = DB::table('penjualan')->insertGetId([
            'timestamp' => now(),
            'total'     => $total
        ], 'id_penjualan');
 
        foreach ($items as $item) {
            DB::table('penjualan_detail')->insert([
                'id_penjualan' => $id_penjualan,
                'id_barang'    => $item['id_barang'],
                'jumlah'       => $item['jumlah'],
                'subtotal'     => $item['subtotal']
            ]);
        }
 
        return response()->json([
            'status'  => 'success',
            'message' => 'Transaksi berhasil disimpan'
        ]);
    }
 
    public function simpanAxios(Request $request)
    {
        $items = $request->input('items');
        $total = $request->input('total');
 
        if (!$total) {
            $total = array_sum(array_column($items, 'subtotal'));
        }
 
        DB::beginTransaction();
        try {
            $id_penjualan = DB::table('penjualan')->insertGetId([
                'timestamp' => now(),
                'total'     => (int) $total
            ], 'id_penjualan');
 
            foreach ($items as $item) {
                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $id_penjualan,
                    'id_barang'    => $item['id_barang'],
                    'jumlah'       => (int) $item['jumlah'],
                    'subtotal'     => (int) $item['subtotal']
                ]);
            }
 
            DB::commit();
 
            return response()->json([
                'status'  => 'success',
                'message' => 'Transaksi berhasil disimpan'
            ]);
 
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('simpanAxios error: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}



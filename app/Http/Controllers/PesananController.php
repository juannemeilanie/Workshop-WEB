<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('menu')->get();
        return view('customer.order', compact('vendors'));
    }

    public function store(Request $request)
    {
        if (!$request->menu) {
            return back()->with('error','Keranjang kosong!');
        }

        $count = Pesanan::count();
        $guest = 'Guest_' . str_pad($count+1,6,'0',STR_PAD_LEFT);

        $total = 0;
        foreach ($request->menu ?? [] as $m) {
            if ($m['qty'] > 0) {
                $total += $m['harga'] * $m['qty'];
            }
        }

        $pesanan = Pesanan::create([
            'nama' => $guest,
            'total' => $total,
            'metode_bayar' => 1,
            'status_bayar' => 0
        ]);

        foreach ($request->menu ?? [] as $m) {
            if ($m['qty'] > 0) {
                DetailPesanan::create([
                    'idpesanan' => $pesanan->idpesanan,
                    'idmenu' => $m['id'],
                    'jumlah' => $m['qty'],
                    'harga' => $m['harga'],
                    'subtotal' => $m['harga'] * $m['qty'],
                    'catatan' => $m['catatan'] ?? '-'
                ]);
            }
        }

        return redirect('/bayar/'.$pesanan->idpesanan);
    }
}




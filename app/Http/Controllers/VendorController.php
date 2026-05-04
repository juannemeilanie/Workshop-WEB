<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    private function getVendorId()
    {
        if (!session('vendor_id')) {
            abort(403);
        }

        return session('vendor_id');
    }

    public function index()
    {
       $vendors = DB::table('vendor')
            ->join('users', 'vendor.user_id', '=', 'users.id')
            ->select('vendor.*', 'users.name as nama_user')
            ->get();
        return view('vendor.admin.daftar', compact('vendors'));
    }

    public function dashboard()
    {
        $vendorId = $this->getVendorId();
        $vendor = Vendor::find($vendorId);

        $pesananVendor = DB::table('pesanan')
            ->join('detail_pesanan', 'pesanan.idpesanan', '=', 'detail_pesanan.idpesanan')
            ->join('menu', 'detail_pesanan.idmenu', '=', 'menu.idmenu')
            ->where('menu.idvendor', $vendorId)
            ->where('pesanan.status_bayar', 1)
            ->select(
                'pesanan.idpesanan',
                'pesanan.nama',
                'pesanan.total',
                'pesanan.created_at',
                'pesanan.status_bayar',
                DB::raw("STRING_AGG(menu.nama_menu || ' x' || detail_pesanan.jumlah, ', ') as items")
            )
            ->groupBy('pesanan.idpesanan', 'pesanan.nama', 'pesanan.total', 'pesanan.created_at', 'pesanan.status_bayar')
            ->orderBy('pesanan.created_at', 'desc')
            ->get();

        $totalPesanan = $pesananVendor->count();
        $totalPendapatan = $pesananVendor->sum('total');
        $totalMenu = Menu::where('idvendor', $vendorId)->count();

        return view('vendor.dashboard', compact('vendor', 'totalMenu', 'totalPesanan', 'totalPendapatan', 'pesananVendor'));
    }

    public function menu()
    {
        $menus = Menu::where('idvendor', $this->getVendorId())->get();
        return view('vendor.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('vendor.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required|image'
        ]);

        $path = $request->file('gambar')->store('menu', 'public');

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'path_gambar' => $path,
            'idvendor' => $this->getVendorId()
        ]);

        return redirect()->route('vendor.menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('vendor.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image'
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('menu','public');
            $menu->path_gambar = $path;
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga
        ]);

        return redirect()->route('vendor.menu.index')->with('success','Menu berhasil diupdate');
    }


    public function pesanan()
    {
        $vendorId = $this->getVendorId();

        $pesanan = DB::table('pesanan')
            ->join('detail_pesanan', 'pesanan.idpesanan', '=', 'detail_pesanan.idpesanan')
            ->join('menu', 'detail_pesanan.idmenu', '=', 'menu.idmenu')
            ->where('menu.idvendor', $vendorId)
            ->where('pesanan.status_bayar', 1)
            ->select(
                'pesanan.idpesanan',
                'pesanan.nama',
                'pesanan.total',
                'pesanan.created_at',
                'pesanan.status_bayar',
                DB::raw("STRING_AGG(menu.nama_menu || ' x' || detail_pesanan.jumlah, ', ') as items")
            )
            ->groupBy('pesanan.idpesanan', 'pesanan.nama', 'pesanan.total', 'pesanan.created_at', 'pesanan.status_bayar')
            ->orderBy('pesanan.created_at', 'desc')
            ->get();

        return view('vendor.pesanan.index', compact('pesanan'));
    }

    public function detailPesanan($id)
    {
        $vendorId = $this->getVendorId();

        $pesanan = DB::table('pesanan')
            ->where('idpesanan', $id)
            ->first();

        $items = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.idmenu', '=', 'menu.idmenu')
            ->where('detail_pesanan.idpesanan', $id)
            ->where('menu.idvendor', $vendorId)
            ->select(
                'menu.nama_menu',
                'detail_pesanan.jumlah',
                'detail_pesanan.harga',
                'detail_pesanan.subtotal'
            )
            ->get();

        if ($items->isEmpty()) {
            abort(403);
        }

        return view('vendor.pesanan.detail', compact('pesanan', 'items'));
    }


    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success','Menu berhasil dihapus');
    }

    public function scanPage()
    {
        return view('vendor.pesanan.scan');
    }

    public function readQrCode(Request $request)
    {
        $vendorId = session('vendor_id');
        $idpesanan = $request->idpesanan;

        $pesanan = DB::table('pesanan')
            ->where('idpesanan', $idpesanan)
            ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan!'
            ]);
        }

        $query = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.idmenu', '=', 'menu.idmenu')
            ->where('detail_pesanan.idpesanan', $idpesanan)
            ->select(
                'menu.nama_menu',
                'detail_pesanan.jumlah',
                'detail_pesanan.harga',
                'detail_pesanan.subtotal'
            );

        if ($vendorId) {
            $query->where('menu.idvendor', $vendorId);
        }

        $items = $query->get();

        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada menu untuk pesanan ini!'
            ]);
        }

        $statusBayar = match((int) $pesanan->status_bayar) {
            1       => 'Lunas',
            0       => 'Belum Bayar',
            2       => 'Gagal/Dibatalkan',
            default => 'Tidak Diketahui'
        };

        return response()->json([
            'success' => true,
            'data'    => [
                'idpesanan'    => $pesanan->idpesanan,
                'nama'         => $pesanan->nama,
                'status_bayar' => $statusBayar,
                'is_lunas'     => (int) $pesanan->status_bayar === 1,
                'items'        => $items,
                'total'        => $items->sum('subtotal'),
            ]
        ]);
    }
}


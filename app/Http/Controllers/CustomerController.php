<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.data.index', compact('customers'));
    }

    public function create1()
    {
        return view('customer.data.create1');
    }

    public function store1(Request $request)
    {
        $img = $request->foto;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto' => DB::raw("decode('$img', 'base64')"),
            'foto_path' => null 
        ]);

        return redirect()->route('customer.index');
    }

    public function create2()
    {
        return view('customer.data.create2');
    }

    public function store2(Request $request)
    {
        $img = $request->foto;

        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $img = base64_decode($img);

        $folderPath = public_path('images');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $fileName = 'customer_' . time() . '.png';
        file_put_contents($folderPath . '/' . $fileName, $img);

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto' => null,   
            'foto_path' => 'images/' . $fileName 
        ]);

        return redirect()->route('customer.index');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->foto_path) {
            $filePath = public_path($customer->foto_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $customer->delete();

        return redirect()->route('customer.index');
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    

    public function show($id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);
        return view('customer.payment', compact('pesanan'));
    }

    public function token(Request $request)
    {
        try {
            $pesanan = Pesanan::findOrFail($request->id);
            $orderId = 'ORDER-' . $pesanan->idpesanan;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $pesanan->total,
                ],
                'customer_details' => [
                    'first_name' => $pesanan->nama,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'token' => $snapToken
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        $order_id = $request->order_id;
        $status = $request->transaction_status;

        $id = str_replace('ORDER-', '', $order_id);

        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($status == 'settlement' || $status == 'capture') {
            $pesanan->status_bayar = 1; 
        } elseif ($status == 'pending') {
            $pesanan->status_bayar = 0; 
        } else {
            $pesanan->status_bayar = 2; 
        }

        $pesanan->save();

        return response()->json(['message' => 'Success']);
    }


    public function success($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $qr = new QrCode(
            data: $pesanan->idpesanan,
            size: 200,
            margin: 10
        );


        $writer = new PngWriter();
        $result = $writer->write($qr);

        $qrCode = base64_encode($result->getString());

        return view('customer.succes', compact('pesanan', 'qrCode'));
    }
}


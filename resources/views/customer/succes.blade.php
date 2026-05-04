@extends('layout.main')
@section('title','Pembayaran Berhasil')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title">
                        Pembayaran Berhasil 
                        <i class="fa fa-check-circle text-success fs-4 mt-2"></i>
                    </h4>
                    <h5>QR Code:</h5>

                    <img src="data:image/png;base64,{{ $qrCode }}">
                    <p><strong>ID Pesanan:</strong> {{ $pesanan->idpesanan }}</p>

                    <a href="{{ route('customer.qrcode', $pesanan->idpesanan) }}" 
                       class="btn btn-rounded btn-gradient-success mb-2" target="_blank">
                        Buka QRCode Saya
                    </a>

                    <br>

                    <a href="{{ route('pesanan.index') }}" class="btn btn-rounded btn-gradient-primary">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
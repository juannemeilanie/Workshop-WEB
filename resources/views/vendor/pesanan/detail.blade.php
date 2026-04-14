@extends('layout.main')

@section('title', 'Detail Pesanan')

@section('content')
<div class="page-header">
    <h3 class="page-title">Detail Pesanan #{{ $pesanan->idpesanan }}</h3>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Informasi Pesanan</h5>
        <p><b>Nama Customer:</b> {{ $pesanan->nama }}</p>
        <p><b>Metode Bayar:</b> {{ $pesanan->metode_bayar }}</p>
        <p><b>Total:</b> Rp {{ number_format($pesanan->total, 0, ',', '.') }}</p>
        <p><b>Waktu:</b> {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y, H:i') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Detail Menu</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nama_menu }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="/vendor/pesanan" class="btn btn-rounded btn-gradient-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
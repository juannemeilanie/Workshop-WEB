@extends('layout.main')
@section('title','Pembayaran')

@section('content')

<h3>Pembayaran</h3>

<div class="card">
    <div class="card-body">

    <p><strong>Nama:</strong> {{ $pesanan->nama }}</p>

    <hr>

    @foreach($pesanan->detailPesanan as $d)
        <p>
        {{ $d->menu->nama_menu }} (x{{ $d->jumlah }})
        - Rp {{ number_format($d->subtotal,0,',','.') }}
        </p>
    @endforeach

    <hr>

    <h4>Total: Rp {{ number_format($pesanan->total,0,',','.') }}</h4>

    <a href="{{ route('pesanan.index') }}" class="btn btn-rounded btn-gradient-secondary">Kembali</a>
    <button type="button" id="bayar" class="btn btn-rounded btn-gradient-success">
        Bayar Sekarang
    </button>

    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('bayar').onclick = function(){

    fetch("{{ url('/payment/token') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            id: {{ $pesanan->idpesanan }}
        })
    })
    .then(res => res.json())
    .then(data => {

        if (data.token) {

            snap.pay(data.token, {

                onSuccess: function(result){
                    alert("Pembayaran berhasil!");
                    window.location.href = "/payment/success/{{ $pesanan->idpesanan }}";
                },

                onPending: function(result){
                    alert("Menunggu pembayaran!");
                },

                onError: function(result){
                    alert("Pembayaran gagal!");
                }

            });

        } else {
            alert("Gagal mendapatkan token pembayaran!");
        }

    })
    .catch(err => {
        console.log(err);
        alert("Terjadi error!");
    });
}
</script>

@endsection
@extends('layout.main')
@section('title', 'Barcode Toko')
@section('content')
<head>
    <meta charset="UTF-8">
    <title>Barcode - {{ $toko->nama_toko }}</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

</head>
<body>
<div class="card">
    <div class="card-body text-center">
        <h2>{{ $toko->nama_toko }}</h2>
        <svg id="barcode"></svg>
        <br>
   
        <button type="button"
                onclick="window.location='{{ route('toko.index') }}'"
                class="btn btn-rounded btn-gradient-secondary mt-2">
            Kembali
        </button>   
    </div>
</div>

    <script>
        JsBarcode('#barcode', '{{ $toko->barcode }}', {
            format: 'CODE128',
            displayValue: true,
            width: 2,
            height: 80,
            margin: 10
        });
    </script>
</body>
@endsection
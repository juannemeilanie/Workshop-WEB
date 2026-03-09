@extends('layout.main')

@section('title', 'Edit Barang')

@section('content')

<div class="page-header">
    <h3 class="page-title">Daftar Barang</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h2>Edit Barang</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formEditBarang" action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Barang:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required >
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $barang->harga) }}" required >
            </div>
            <a href="{{ route('barang.index') }}" class="btn btn-rounded btn-gradient-secondary">
                Kembali
            </a>
            <button type="button" class="btn btn-rounded btn-gradient-primary btn-spinner" data-form="formEditBarang" >Update </button>
        </form>
    </div>
</div>

@endsection

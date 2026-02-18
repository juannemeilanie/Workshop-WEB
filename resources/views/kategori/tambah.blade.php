@extends('layout.main')

@section('title', 'Kategori')@extends('layout.main')

@section('title', 'Tambah Kategori')

@section('content')

<div class="page-header">
    <h3 class="page-title"> Kategori </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
      </nav>
</div>

<div class="card">
    <div class="card-body ">
        <h2>Tambah Kategori</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori:</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
            </div>
            <a href="{{ route('kategori.index') }}" class="btn btn-rounded btn-gradient-secondary">Kembali</a>
            <button type="submit" class="btn btn-rounded btn-gradient-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
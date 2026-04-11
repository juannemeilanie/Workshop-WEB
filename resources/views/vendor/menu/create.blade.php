@extends('layout.main')

@section('title', 'Tambah Menu')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Menu</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kelola Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Menu</li>
            </ol>
      </nav>
</div>

<div class="card">
    <div class="card-body ">
        <h4>Tambah Menu</h4>

        @if ($errors->any())
            <div style="background:#f8d7da; padding:10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formTambahMenu"  action="{{ route('vendor.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>

            <a href="{{ route('vendor.menu.index') }}" class="btn btn-rounded btn-gradient-secondary">Kembali</a>
            <button type="button" class="btn btn-rounded btn-gradient-primary btn-spinner" data-form="formTambahMenu">Simpan</button>
        </form>
    </div>
</div>

@endsection
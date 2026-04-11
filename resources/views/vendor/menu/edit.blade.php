@extends('layout.main')
@section('title', 'Edit Menu')

@section('content')

<div class="page-header">
    <h3 class="page-title"> Kelola Menu </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('vendor.menu.index') }}">Kelola Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h2>Edit Menu</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.menu.update',$menu->idmenu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}">
            </div>

            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <a href="{{ route('vendor.menu.index') }}" class="btn btn-rounded btn-gradient-secondary">Kembali</a>
            <button class="btn btn-rounded btn-gradient-primary">Update</button>

        </form>
    </div>
</div>

@endsection
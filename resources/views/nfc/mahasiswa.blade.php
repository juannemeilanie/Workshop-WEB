@extends('layout.main')
@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="page-header">
    <h3 class="page-title">Tambah Mahasiswa</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">NFC</a></li>
            <li class="breadcrumb-item active">Tambah Mahasiswa</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" class="form-control" required>
                @error('nim') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-rounded btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-rounded btn-gradient-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
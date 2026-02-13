@extends('layout.main')

@section('title', 'Tambah Buku')

@section('content')
<div class="card">
    <div class="card-body ">
        <h2>Tambah Buku</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kode">Kode:</label>
                <input type="text" class="form-control" id="kode" name="kode" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="form-group">
                <label for="pengarang">Pengarang:</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select class="form-control" id="kategori" name="idkategori" required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->idkategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('buku.index') }}" class="btn btn-rounded btn-gradient-secondary">Kembali</a>
            <button type="submit" class="btn btn-rounded btn-gradient-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
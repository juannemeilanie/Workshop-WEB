@extends('layout.main')

@section('title', 'Edit Buku')

@section('content')

<div class="page-header">
    <h3 class="page-title">Daftar Buku</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <h2>Edit Buku</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('buku.update', $buku->idbuku) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kode">Kode:</label>
                <input
                    type="text"
                    class="form-control"
                    id="kode"
                    name="kode"
                    value="{{ old('kode', $buku->kode) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="judul">Judul:</label>
                <input
                    type="text"
                    class="form-control"
                    id="judul"
                    name="judul"
                    value="{{ old('judul', $buku->judul) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="pengarang">Pengarang:</label>
                <input
                    type="text"
                    class="form-control"
                    id="pengarang"
                    name="pengarang"
                    value="{{ old('pengarang', $buku->pengarang) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select class="form-control" id="kategori" name="idkategori" required>
                    @foreach($kategori as $k)
                        <option
                            value="{{ $k->idkategori }}"
                            {{ old('idkategori', $buku->idkategori) == $k->idkategori ? 'selected' : '' }}
                        >
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('buku.index') }}" class="btn btn-rounded btn-gradient-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-rounded btn-gradient-primary">
                Update
            </button>
        </form>
    </div>
</div>

@endsection

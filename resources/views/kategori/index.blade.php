@extends('layout.main')

@section('title', 'Kategori')

@section('content')
<body>
<div class="page-header">
    <h3 class="page-title"> Kategori </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
            </ol>
      </nav>
</div>
          
    <div class="card">
    <div class="card-body">

        <h2>Kategori</h2>

        @if(session('success'))
            <div class="alert alert-success" role="alert" style="background:#d4edda; color:#155724; padding:10px; border-radius:6px;">
                {{ session('success') }}
            </div>
        @endif


            <form action="{{ route('kategori.create') }}" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-rounded btn-gradient-primary">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </button>
            </form>
            <br><br>

        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $k)
            <tr>
                <td>{{ $k->idkategori }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>
                    <form action="{{ route('kategori.edit', $k->idkategori) }}" method="GET" style="display: inline;">
                        <button type="submit" class="btn btn-sm btn-rounded btn-gradient-warning">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                    </form>
                    <form action="{{ route('kategori.destroy', $k->idkategori) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-rounded btn-gradient-danger">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    </div>

@endsection
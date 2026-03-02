@extends('layout.main')

@section('title', 'Barang')

@section('content')
<body>

<div class="page-header">
    <h3 class="page-title">Daftar Barang </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Barang</a></li>
            </ol>
      </nav>
</div>
    <div class="card">
    <div class="card-body ">
        <h2>Daftar Barang</h2>
    
        @if(session('success'))
            <div class="alert alert-success" role="alert" style="background:#d4edda; color:#155724; padding:10px; border-radius:6px;">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('barang.create') }}" method="GET" style="display: inline;">
            <button type="submit" class="btn btn-rounded btn-gradient-primary">
                <i class="fa fa-plus"></i> Tambah Barang
            </button>
        </form>
        <br><br>
        <form action="{{ route('barang.cetak') }}" method="get" style="display: inline;" Target="_blank">

            <div class="alert alert-info border-0 shadow-sm">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <b>Petunjuk Cetak:</b><br>
                        <p class="text-info">Kertas TnJ No 108 (5 kolom x 8 baris).<br>
                        Tentukan posisi awal (X,Y) lalu centang barang di tabel.</p>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold">Kolom (X)</label>
                        <input type="number" name="x" class="form-control" min="1" max="5" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="small fw-bold">Baris (Y)</label>
                        <input type="number" name="y" class="form-control" min="1" max="8" value="1" required>
                    </div>
                    <div class="col-md-3">
                        
                        <button type="submit" class="btn btn-rounded btn-gradient-primary">
                            <i class="fa fa-print"></i> Cetak Barang
                        </button>
                    </div>
                </div>
            </div>
    
            <br><br>
            <div class="table-responsive">
                <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>Pilih</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($barang as $b)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="id_barang[]" value="{{ $b->id_barang }}">
                            </td>
                            <td>{{ $b->id_barang }}</td>
                            <td>{{ $b->nama }}</td>
                            <td>{{ $b->harga }}</td>
                            <td>
                                <a href="{{ route('barang.edit', $b->id_barang) }}" class="btn btn-sm btn-rounded btn-gradient-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('barang.destroy', $b->id_barang) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-rounded btn-gradient-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>   
                </table>
            </div>
        </form>
    </div>
</div>
</body>

@endsection
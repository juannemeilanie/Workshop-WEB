@extends('layout.main')

@section('title', 'Buku')

@section('content')
<body>
    <div class="card">
    <div class="card-body ">
        <h2>Daftar Buku</h2>
    
        @if(session('success'))
            <div class="alert alert-success" role="alert" style="background:#d4edda; color:#155724; padding:10px; border-radius:6px;">
                {{ session('success') }}
            </div>
        @endif
            
            <form action="{{ route('buku.create') }}" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-rounded btn-gradient-primary">
                    <i class="fa fa-plus"></i> Tambah Buku
                </button>
            </form>
            <br><br>
        
    
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $b)
            <tr>
                <td>{{ $b->idbuku }}</td>
                <td>{{ $b->kode }}</td>
                <td>{{ $b->judul }}</td>
                <td>{{ $b->pengarang }}</td>
                <td>{{ $b->nama_kategori }}</td>
                <td>
                    <form action="{{ route('buku.edit', $b->idbuku) }}" method="GET" style="display: inline;">
                        <button type="submit" class="btn btn-sm btn-rounded btn-gradient-warning">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                    </form>
                    <form action="{{ route('buku.destroy', $b->idbuku) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
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
</body>

@endsection
@extends('layout.main')

@section('title', 'Menu Vendor')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Menu</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kelola Menu</a></li>
            </ol>
      </nav>
</div>
          
<div class="card">
<div class="card-body">

    <div class="d-flex justify-content-between mb-3">
        <h4>Daftar Menu</h4>
      
        <form action="{{ route('vendor.menu.create') }}" method="GET" style="display: inline;">
            <button type="submit" class="btn btn-rounded btn-gradient-primary">
                <i class="fa fa-plus"></i> Tambah Menu
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

    @forelse($menus as $m)
    <div class="col-md-3 mb-4">

        <div class="card shadow-sm h-100">
            <img src="{{ asset('storage/'.$m->path_gambar) }}" 
                style="height:180px; object-fit:cover; border-radius:10px 10px 0 0;">

            <div class="card-body">
                <h5 class="fw-bold">{{ $m->nama_menu }}</h5>

                <p class="text-success fw-bold">
                    Rp {{ number_format($m->harga,0,',','.') }}
                </p>

                <div class="d-flex gap-2 ">
                    <a href="{{ route('vendor.menu.edit',$m->idmenu) }}" 
                    class="btn btn-sm btn-rounded btn-gradient-warning w-100">
                        <i class="fa fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('vendor.menu.delete',$m->idmenu) }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-rounded btn-gradient-danger "
                            onclick="return confirm('Hapus menu ini?')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
        <p class="text-center">Belum ada menu</p>
    @endforelse
</div>

@endsection
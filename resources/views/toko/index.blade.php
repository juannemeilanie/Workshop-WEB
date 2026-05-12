@extends('layout.main')

@section('title', 'Kunjungan Toko')

@section('content')
<div class="page-header">
    <h3 class="page-title">Kunjungan Toko</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Kunjungan Toko</a></li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('toko.create') }}" class="btn btn-rounded btn-gradient-primary mb-2">+ Tambah Toko</a>
        <a href="{{ route('toko.kunjungan') }}" class="btn btn-rounded btn-gradient-success mb-2">Scan Barcode Toko</a>

        <br><br>
        <div class="table-responsive">
            <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Nama Toko</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Accuracy</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokos as $toko)
                    <tr>
                        <td>{{ $toko->barcode }}</td>
                        <td>{{ $toko->nama_toko }}</td>
                        <td>{{ $toko->latitude }}</td>
                        <td>{{ $toko->longitude }}</td>
                        <td>{{ $toko->accuracy }} m</td>
                        <td>
                            <a href="{{ route('toko.cetak', $toko->id) }}" target="_blank"
                            class="btn btn-rounded btn-gradient-secondary btn-sm">
                                🖨️ Cetak Barcode
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data toko</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
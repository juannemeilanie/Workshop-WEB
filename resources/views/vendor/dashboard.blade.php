@extends('layout.main')
@section('title', 'Dashboard Vendor')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard Vendor {{ $vendor->nama_vendor }}
    </h3>
    <h6>Selamat datang, {{ Auth::user()->name }}</h6>
</div>
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                <h5>Total Menu</h5>
                <h2>{{ $totalMenu }}</h2>
                <a href="/vendor/menu" class="text-white">Kelola Menu →</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                <h5>Pesanan Lunas</h5>
                <h2>{{ $totalPesanan }}</h2>
                <a href="/vendor/pesanan" class="text-white">Lihat Pesanan →</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-primary card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/> 
                <h5>Total Pendapatan</h5>
                <h2>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="mb-3">Pesanan Lunas Terbaru</h4>

            @if($pesananVendor->isEmpty())
                <div class="text-center py-4">
                    <p class="text-muted">Belum ada pesanan lunas.</p>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Detail Menu</th>
                            <th>Total</th>
                            <th>Waktu Pesan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesananVendor as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->nama }}</td>
                            <td class="text-muted small">{{ $p->items }}</td>
                            <td class="fw-bold text-primary">
                                Rp {{ number_format($p->total, 0, ',', '.') }}
                            </td>
                            <td class="text-muted small">
                                {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">
                                    <i class="mdi mdi-check me-1"></i> Lunas
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

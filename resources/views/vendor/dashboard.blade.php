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
</div>
@endsection

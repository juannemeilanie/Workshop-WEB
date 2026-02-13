@extends('layout.main')

@section('title', 'Dashboard')

@push('style')
<style>
/* STYLE PAGE */
.page-title {
    color: purple;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <h3 class="page-title">Dashboard</h3>
    <h6>Selamat datang, {{ Auth::user()->name }}</h6>
</div>
<br>

<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                <h4 class="font-weight-normal mb-3">Total Buku
                    <i class="mdi mdi-book-open-page-variant mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                <h4 class="font-weight-normal mb-3">Total Kategori
                    <i class="fa fa-list mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">{{ $totalKategori }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body ">
        <h4>Daftar Buku</h4>
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Kategori</th>
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
            </tr>
        @endforeach
        </tbody>   
        </table>
    </div>
</div>
<br><br>
<div class="card">
    <div class="card-body">
        <h4>Daftar Kategori</h4>

        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $k)
            <tr>
                <td>{{ $k->idkategori }}</td>
                <td>{{ $k->nama_kategori }}</td>
            </tr>
        @endforeach
        </tbody>
        </table>
</div>
</div>


@endsection

@push('script')
<script>
// JAVASCRIPT PAGE
console.log("Dashboard loaded");
</script>
@endpush

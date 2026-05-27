@extends('layout.main')
@section('title', 'Data Mahasiswa')

@section('content')
<div class="page-header">
    <h3 class="page-title">Daftar Mahasiswa</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">NFC</li>
            <li class="breadcrumb-item active">Daftar Mahasiswa</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('mahasiswa.create') }}" class="btn btn-rounded btn-gradient-primary mb-3">
            + Tambah Mahasiswa
        </a>

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Status Kartu NFC</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $mhs)
                <tr>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->jurusan }}</td>
                    <td>
                        @if($mhs->nfc_serial)
                            <span class="badge badge-success">Terdaftar</span>
                            <br><br>
                            {{ $mhs->nfc_serial }}
                        @else
                            <span class="badge badge-danger">Belum Terdaftar</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.daftar', $mhs->mahasiswa_id) }}"
                           class="btn btn-rounded btn-sm btn-rounded btn-gradient-warning">
                            Daftarkan NFC
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data mahasiswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
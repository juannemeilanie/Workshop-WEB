@extends('layout.main')
@section('title', 'Riwayat Absensi')

@section('content')
<div class="page-header">
    <h3 class="page-title">Riwayat Absensi</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">NFC</a></li>
            <li class="breadcrumb-item active">Riwayat Absensi</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">

        <a href="{{ route('absensi.scan') }}" class="btn btn-rounded btn-gradient-primary mb-3">
            Scan Absensi
        </a>

        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Mata Kuliah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $absensi)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($absensi->waktu_absen)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $absensi->mahasiswa->nim }}</td>
                    <td>{{ $absensi->mahasiswa->nama }}</td>
                    <td>{{ $absensi->matakuliah }}</td>
                    <td>
                        <span class="badge badge-success">{{ $absensi->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
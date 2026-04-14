@extends('layout.main')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Pesanan Lunas</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pesanan Lunas</a></li>
            </ol>
      </nav>
</div>
          
<div class="card">
<div class="card-body">
    <div class="d-flex justify-content-between mb-3">
        <h4>Daftar Pesanan Lunas</h4>

        <span class="badge bg-gradient-success fs-6">
            {{ $pesanan->count() }} Pesanan
        </span>
    </div>

    @if($pesanan->isEmpty())
        <div class="text-center py-5">
            <i class="mdi mdi-clipboard-text-off" style="font-size: 56px; color: #ccc;"></i>
            <p class="text-muted mt-3">Belum ada pesanan yang lunas.</p>
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Detail Menu</th>
                    <th>Total</th>
                    <th>Waktu Pesan</th>
                    <th class="text-center">Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->items }}</td>
                        <td class="fw-bold text-primary">
                            Rp {{ number_format($p->total, 0, ',', '.') }}
                        </td>
                        <td class="text-muted small">
                            {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y, H:i') }}
                        </td>
                        <td class="text-center">
                            <span class="badge 
                                {{ $p->status_bayar == 1 ? 'bg-gradient-success' : ($p->status_bayar == 0 ? 'bg-gradient-warning' : 'bg-gradient-danger') }}">
                                
                                {{ $p->status_bayar == 1 ? 'Lunas' : ($p->status_bayar == 0 ? 'Pending' : 'Gagal') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('vendor.pesanan.detail', $p->idpesanan) }}" 
                            class="btn btn-sm btn-rounded btn-gradient-info">
                                <i class="mdi mdi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
</div>
@endsection
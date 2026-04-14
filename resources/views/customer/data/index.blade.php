@extends('layout.main')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Data Customer </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data Customer</a></li>
            </ol>
      </nav>
</div>

<div class="card">
    <div class="card-body">
    <h3>Data Customer</h3>
        @if(session('success'))
            <div class="alert alert-success" role="alert" style="background:#d4edda; color:#155724; padding:10px; border-radius:6px;">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('customer.create1') }}" class="btn btn-rounded btn-gradient-primary mb-3">
            Tambah Customer 1
        </a>
        <a href="{{ route('customer.create2') }}" class="btn btn-rounded btn-gradient-primary mb-3">
            Tambah Customer 2
        </a>

        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Kecamatan</th>
                    <th>Kodepos</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->nama }}</td>
                    <td>{{ $c->alamat }}</td>
                    <td>{{ $c->provinsi }}</td>
                    <td>{{ $c->kota }}</td>
                    <td>{{ $c->kecamatan }}</td>
                    <td>{{ $c->kodepos }}</td>
                    <td>
                        @if($c->foto_path)
                            <img src="{{ asset($c->foto_path) }}" width="100">

                        @elseif($c->foto)
                            @php
                                $foto = '';

                                if (is_resource($c->foto)) {
                                    rewind($c->foto);
                                    $foto = base64_encode(stream_get_contents($c->foto));
                                } 
                            @endphp
                            <img src="data:image/png;base64,{{ $foto }}" width="100">
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('customer.destroy', $c->idcust) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-rounded btn-gradient-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
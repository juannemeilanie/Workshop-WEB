@extends('layout.main')

@section('title', 'Data Vendor')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Data Vendor</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data Vendor</a></li>
            </ol>
      </nav>
</div>
          
<div class="card">
<div class="card-body">

    <div class="d-flex justify-content-between mb-3">
        <h4>Data Vendor</h4>
    </div>
        <div class="table-responsive">
            <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Vendor</th>
                        <th>Nama Vendor</th>
                        <th>Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->idvendor }}</td>
                        <td>{{ $vendor->nama_vendor }}</td>
                        <td>{{ $vendor->nama_user }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
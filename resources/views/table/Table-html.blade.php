@extends('layout.main')
@section('title', 'Tabel Barang')

@section('content')

<div class="page-header">
    <h3 class="page-title"> Tambah Barang</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tabel</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabel Barang</li>
        </ol>
    </nav>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white fw-bold">Tambah Barang</div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" id="nama" class="form-control" placeholder="Nama Barang *">
                <div class="invalid-feedback">Nama barang wajib diisi</div>
            </div>
            <div class="col-md-4">
                <input type="number" id="harga" class="form-control" placeholder="Harga *">
                <div class="invalid-feedback">Harga wajib diisi</div>
            </div>
            <div class="col-md-3">
                <button id="btnTambahBarang" onclick="tampilkan()" class="btn btn-gradient-primary btn-spinner w-100">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold">Daftar Barang </div>
    <div class="card-body">
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0" id="tabelBarang">
            <thead >
                <tr>
                    <th>ID Barang</th>
                    <th>Nama</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody id="hasil">
                
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
let counter = 1;
let selectedRow = null;

function tampilkan()
{
    let btn = $('#btnTambahBarang');
    btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...')
       .prop('disabled', true);

    const nama = document.getElementById('nama').value;
    const harga = document.getElementById('harga').value;

    let valid = true;

    if (!nama) {
        $('#nama').addClass('is-invalid');
        valid = false;
    } else {
        $('#nama').removeClass('is-invalid');
    }

    if (!harga) {
        $('#harga').addClass('is-invalid');
        valid = false;
    } else {
        $('#harga').removeClass('is-invalid');
    }

    if (!valid) {
        resetBtn(); 
        return;
    }

    const id = 'BRG-' + String(counter).padStart(3,'0');
    const hasil = document.getElementById('hasil');
    const baris = `
        <tr onclick="pilihRow(this)">
            <td>${id}</td>
            <td>${nama}</td>
            <td>Rp ${parseInt(harga).toLocaleString('id-ID')}</td>
        </tr>
    `;
    hasil.innerHTML += baris;
    counter++;

    document.getElementById('nama').value = '';
    document.getElementById('harga').value = '';

    setTimeout(function(){
        resetBtn();
    }, 300);
}

function resetBtn()
{
    $('#btnTambahBarang')
        .html('Tambah')
        .prop('disabled', false);
}

function pilihRow(row)
{
    selectedRow = row;

    const nama = row.cells[1].innerText;
    const harga = row.cells[2].innerText.replace('Rp','').replace(/\./g,'');

    document.getElementById('nama').value = nama;
    document.getElementById('harga').value = harga;
}

</script>
@endpush
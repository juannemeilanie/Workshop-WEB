@extends('layout.main')
@section('title', 'Datatables')

@section('content')

<style>
#hasil tr{
    cursor:pointer;
}
#hasil tr:hover{
    background-color:#eef4ff;
}
</style>
<body>
<div class="page-header">
    <h3 class="page-title"> Tambah Barang</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tabel</a></li>
            <li class="breadcrumb-item active" aria-current="page">Datatables Barang</li>
        </ol>
    </nav>
</div>

<div class="card mb-4">
<div class="card-header bg-primary text-white fw-bold">Tambah Barang</div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-5">
                <input type="text" id="nama" class="form-control" placeholder="Nama Barang *">
            <div class="invalid-feedback">Nama barang wajib diisi.</div>
        </div>
        <div class="col-md-4">
            <input type="number" id="harga" class="form-control" placeholder="Harga *">
        <div class="invalid-feedback">Harga wajib diisi.</div>
    </div>

    <div class="col-md-3">
        <button id="btnTambahBarang" onclick="tampilkan()" class="btn btn-gradient-primary btn-spinner w-100">Tambah</button>
    </div>
    </div>
</div>
</div>

<div class="card">
<div class="card-header fw-bold">Daftar Barang</div>
    <div class="card-body">
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
            <thead>
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

<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit / Hapus Barang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>ID Barang</label>
                    <input type="text" id="modalId" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" id="modalNama" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" id="modalHarga" class="form-control">
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="hapusData()" class="btn btn-gradient-danger">Hapus</button>
                <button onclick="ubahData()" class="btn btn-gradient-primary"> Ubah</button>
            </div>
        </div>
    </div>
</div>

<script>

let counter = 1
let selectedRow = null

function tampilkan(){
    let btn = $('#btnTambahBarang');
    btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...')
       .prop('disabled', true);

    let nama = document.getElementById("nama").value
    let harga = document.getElementById("harga").value

    let valid = true

    if(!nama){
        $("#nama").addClass("is-invalid")
        valid = false
    }else{
        $("#nama").removeClass("is-invalid")
    }

    if(!harga){
        $("#harga").addClass("is-invalid")
        valid = false
    }else{
        $("#harga").removeClass("is-invalid")
    }

    if(!valid) {
        resetBtn();
        return;
    }

    let id = "BRG-" + String(counter).padStart(3,"0")
    let hasil = document.getElementById("hasil")
    let baris =`
                <tr onclick="pilihRow(this)">
                <td>${id}</td>
                <td>${nama}</td>
                <td>Rp ${parseInt(harga).toLocaleString('id-ID')}</td>
                </tr>
                `
    hasil.innerHTML += baris
    counter++

    document.getElementById("nama").value=""
    document.getElementById("harga").value=""

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

function pilihRow(row){
    selectedRow = row

    let id = row.cells[0].innerText
    let nama = row.cells[1].innerText
    let harga = row.cells[2].innerText.replace(/[^0-9]/g,'')

    document.getElementById("modalId").value = id
    document.getElementById("modalNama").value = nama
    document.getElementById("modalHarga").value = harga

    new bootstrap.Modal(document.getElementById('modalEdit')).show()
}

function ubahData(){
    let nama = document.getElementById("modalNama").value
    let harga = document.getElementById("modalHarga").value
    if(!nama || !harga){
        alert("Nama dan Harga wajib diisi")
        return
    }
    selectedRow.cells[1].innerText = nama
    selectedRow.cells[2].innerText = "Rp " + parseInt(harga).toLocaleString('id-ID')
    bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide()
}

function hapusData(){
    if(confirm("Yakin ingin menghapus data ini?")){
        selectedRow.remove()
        bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide()
    }
}
</script>

@endsection
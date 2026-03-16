@extends('layout.main')
@section('title','POS JQuery')
@section('content')

<div class="page-header">
    <h3 class="page-title">Point Of Sales - JQuery</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">POS</a></li>
            <li class="breadcrumb-item active" aria-current="page">JQuery</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label>Kode</label>
                <input type="text" id="kode_barang" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Nama Barang</label>
                <input type="text" id="nama_barang" class="form-control" readonly>
            </div>

            <div class="col-md-12 mb-3">
                <label>Harga</label>
                <input type="text" id="harga" class="form-control" readonly>
            </div>

            <div class="col-md-12 mb-3">
                <label>Jumlah</label>
                <input type="number" id="jumlah" class="form-control" value="1">
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-gradient-primary btn-tambah">Tambahkan</button>
            </div>
        </div>
    </div>

    <div class="card">
        <table class="table table-striped text-center" id="tablePOS">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <div class="card-body d-flex flex-column align-items-end">
        <h4>Total : Rp <span id="total">0</span></h4>
        <button class="btn btn-gradient-success btn-bayar">Bayar</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let items = [];

$('#kode_barang').keypress(function(e){
    if(e.which == 13){
        let kode = $('#kode_barang').val();
        if(!kode){
            alert('Kode barang harus diisi');
            return;
        }

        $.ajax({
            method:'GET',
            url:'/pos/barang/'+kode,
            success:function(response){
                if(response.status == 'success'){
                    $('#nama_barang').val(response.data.nama);
                    $('#harga').val(response.data.harga);
                    $('#jumlah').val(1);
                }else{
                    alert('Barang tidak ditemukan');
                }
            },
            error:function(){
                alert('Terjadi kesalahan');
            }
        });
    }
});

$('.btn-tambah').click(function(){
    let tombol = $(this);

    tombol
    .html('<span class="spinner-border spinner-border-sm me-1"></span> Menambahkan...')
    .prop('disabled',true);

    tambahBarang();

    setTimeout(function(){
        tombol.html('Tambahkan');
        tombol.prop('disabled',false);
    },300);
});

function tambahBarang(){
    let kode   = $('#kode_barang').val();
    let nama   = $('#nama_barang').val();
    let harga  = parseInt($('#harga').val());
    let jumlah = parseInt($('#jumlah').val());

    if(!kode){
        alert('Kode barang harus diisi');
        return;
    }

    if(!nama){
        alert('Barang belum ditemukan');
        return;
    }

    if(jumlah <= 0){
        alert('Jumlah harus lebih dari 0');
        return;
    }
    let ditemukan = false;

    for(let i=0;i<items.length;i++){
        if(items[i].id_barang == kode){
            items[i].jumlah += jumlah;
            items[i].subtotal = items[i].harga * items[i].jumlah;
            ditemukan = true;
            break;
        }
    }

    if(!ditemukan){
        items.push({
            id_barang:kode,
            nama:nama,
            harga:harga,
            jumlah:jumlah,
            subtotal:harga * jumlah
        });
    }
    tampilTabel();
    resetForm();
}

function tampilTabel(){
    $('#tablePOS tbody').html('');
    let total = 0;
    for(let i=0;i<items.length;i++){
        let item = items[i];
        $('#tablePOS tbody').append(
            '<tr>'+
            '<td>'+(i+1)+'</td>'+
            '<td>'+item.id_barang+'</td>'+
            '<td>'+item.nama+'</td>'+
            '<td>'+item.harga+'</td>'+
            '<td>'+item.jumlah+'</td>'+
            '<td>'+item.subtotal+'</td>'+
            '<td><button onclick="hapus('+i+')" class="btn btn-gradient-danger btn-sm">Hapus</button></td>'+
            '</tr>'
        );
        total += item.subtotal;
    }
    $('#total').text(total);
}

function hapus(index){
    items.splice(index,1);
    tampilTabel();
}

function resetForm(){
    $('#kode_barang').val('');
    $('#nama_barang').val('');
    $('#harga').val('');
    $('#jumlah').val(1);
}

$('.btn-bayar').click(function(){
    let tombol = $(this);
    if(items.length == 0){
        alert('Belum ada barang');
        return;
    }

    tombol
    .html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...')
    .prop('disabled',true);

    bayar(tombol);
});

function bayar(tombol){
    $.ajax({
        method:'POST',
        url:'/simpan-transaksi',
        data:{
            _token:'{{csrf_token()}}',
            items:items
        },
        success:function(response){
            alert(response.message);

            items = [];
            tampilTabel();
            resetForm();

            tombol.html('Bayar');
            tombol.prop('disabled',false);
        },
        error:function(){
            alert('Terjadi kesalahan');

            tombol.html('Bayar');
            tombol.prop('disabled',false);
        }
    });
}
</script>
@endsection
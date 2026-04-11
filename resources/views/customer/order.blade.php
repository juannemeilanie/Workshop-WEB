@extends('layout.main')
@section('title','Order Pesanan')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Order Pesanan</h3>
</div>
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <h4>Pilih Vendor</h4>
        </div>

        <select id="vendor" class="form-control mb-3">
            <option value="" disabled selected>Pilih Vendor</option>
            @foreach($vendors as $v)
                <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
            @endforeach
        </select>

        <form action="{{ route('pesanan.store') }}" method="POST">
        @csrf

            <div class="row" id="menuList"></div>
            <button type="submit" class="btn btn-rounded btn-gradient-success mt-3">Pesan</button>

        </form>
    </div>
</div>
<script>
let vendors = @json($vendors);

function loadMenu(id){
    let v = vendors.find(x => x.idvendor == id);
    let html = '';

v.menu.forEach((m,i) => {
    html += `
    <div class="col-md-3 mb-3">
        <div class="card">
            <img src="/storage/${m.path_gambar}" style="height:180px; object-fit:cover;">
            <div class="card-body text-center">
                <h6>${m.nama_menu}</h6>
                <p>Rp ${m.harga}</p>

                <button type="button"  class="btn btn-sm btn-rounded btn-gradient-success" onclick="kurang(${i})">-</button>
                
                <input  
                    id="qty${i}" 
                    name="menu[${i}][qty]" 
                    value="0" 
                    readonly 
                    style="width:50px; text-align:center; border:none;">

                <button type="button" class="btn btn-sm btn-rounded btn-gradient-success" onclick="tambah(${i})">+</button>

                <input type="hidden" name="menu[${i}][id]" value="${m.idmenu}">
                <input type="hidden" name="menu[${i}][harga]" value="${m.harga}">
            </div>
        </div>
    </div>
    `;
});

    document.getElementById('menuList').innerHTML = html;
}

function tambah(i){
    let input = document.getElementById('qty'+i);
    input.value = parseInt(input.value) + 1;
}

function kurang(i){
    let input = document.getElementById('qty'+i);
    let val = parseInt(input.value);

    if(val > 0){
        input.value = val - 1;
    }
}

document.getElementById('vendor').addEventListener('change', function(){
    loadMenu(this.value);
});

loadMenu(document.getElementById('vendor').value);

document.querySelector('form').addEventListener('submit', function(e){
    let qtyInputs = document.querySelectorAll('input[name*="[qty]"]');
    let valid = false;

    qtyInputs.forEach(i => {
        if (parseInt(i.value) > 0) valid = true;
    });

    if (!valid) {
        e.preventDefault();
        alert("Pilih minimal 1 menu!");
    }
});
</script>

@endsection
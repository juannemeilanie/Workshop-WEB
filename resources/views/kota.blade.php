@extends('layout.main')
@section('title', 'Soal 4 - Select & Select2')

@section('content')

<div class="page-header">
    <h3 class="page-title"> Kota</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tabel</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kota</li>
        </ol>
    </nav>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white fw-bold">Select</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Tambah Kota</label>
                    <div class="input-group">
                        <input type="text" id="inputKota1" class="form-control" placeholder="Ketik nama kota...">
                        <button type="button" id="btnTambahKota1" class="btn btn-gradient-primary btn-spinner">Tambah</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Kota</label>
                    <select id="selectKota1" class="form-select">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="p-3 bg-light rounded">
                    Kota Terpilih: <strong id="kotaTerpilih1">-</strong>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white fw-bold">Select 2</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Tambah Kota</label>
                    <div class="input-group">
                        <input type="text" id="inputKota2" class="form-control" placeholder="Ketik nama kota...">
                        <button type="button" id="btnTambahKota2" class="btn btn-gradient-primary">Tambah</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Kota</label>
                    <select id="selectKota2" class="form-select" >
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <div class="p-3 bg-light rounded">
                    Kota Terpilih: <strong id="kotaTerpilih2">-</strong>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal !important;
        padding-left: 10px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
    }
</style>
<script>
$(document).ready(function(){

    $('#selectKota2').select2({
        placeholder:'-- Pilih Kota --',
        width:'100%'
    });


    $('#btnTambahKota1').click(function(){
        let kota = $('#inputKota1').val().trim();
        if(kota == '') return;
        let option = "<option value='"+kota+"'>"+kota+"</option>";

        $('#selectKota1').append(option);
        $('#inputKota1').val('');
    });

    $('#selectKota1').change(function(){
        let kota = $(this).val();
        $('#kotaTerpilih1').text(kota || '-');
    });

    $('#btnTambahKota2').click(function(){
        let kota = $('#inputKota2').val().trim();
        if(kota == '') return;
        let option = new Option(kota, kota);

        $('#selectKota2').append(option).trigger('change');
        $('#inputKota2').val('');
    });

    $('#selectKota2').change(function(){
        let kota = $(this).val();
        $('#kotaTerpilih2').text(kota || '-');
    });

});
</script>
@endpush
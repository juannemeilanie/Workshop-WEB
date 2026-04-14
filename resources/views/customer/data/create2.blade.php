@extends('layout.main')
@section('title', 'Tambah Customer 2')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Data Customer </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Data Customer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Customer 2</li>
            </ol>
      </nav>
</div>

<div class="card">
    <div class="card-body ">
        <h2>Tambah Customer 2</h2>

        @if ($errors->any())
            <div style="background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.store2') }}" method="POST">
            @csrf

            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
            <input type="text" name="alamat" class="form-control mb-2" placeholder="Alamat" required>
            <input type="text" name="provinsi" class="form-control mb-2" placeholder="Provinsi" required>
            <input type="text" name="kota" class="form-control mb-2" placeholder="Kota" required>
            <input type="text" name="kecamatan" class="form-control mb-2" placeholder="Kecamatan" required>
            <input type="text" name="kodepos" class="form-control mb-3" placeholder="Kodepos" required>

            <div class="mb-3 ">
                <div id="photo-frame" style="width: 200px; height: 200px; border: 1px solid #92bd94; display: flex; align-items: center; justify-content: center; background-color: #fff;">
                <img id="preview" width="150">
                </div> 
            </div>

            <input type="hidden" name="foto" id="foto">

            <button type="button" class="btn btn-rounded btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#kameraModal">
                Ambil Foto
            </button>

            <button type="submit" class="btn btn-rounded btn-gradient-success">
                Simpan Data
            </button>
        </form>
    </div>

    <div class="modal fade" id="kameraModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Ambil Foto</h5>
                </div>

                <div class="modal-body text-center">
                    <div class="row">

                        <div class="col-md-6">
                            <video id="video" width="100%" autoplay></video>
                            <button class="btn btn-rounded btn-gradient-primary mt-2" onclick="startCamera()">Aktifkan Kamera</button>
                        </div>

                        <div class="col-md-6">
                            <canvas id="canvas" width="300" height="200"></canvas>
                            <button class="btn btn-rounded btn-gradient-success mt-2" onclick="capture()">Ambil Foto</button>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-rounded btn-gradient-success" onclick="savePhoto()">Simpan Foto</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let stream;

function startCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(s => {
        stream = s;
        document.getElementById('video').srcObject = stream;
    });
}

function capture() {
    let canvas = document.getElementById('canvas');
    let video = document.getElementById('video');

    canvas.getContext('2d').drawImage(video, 0, 0, 300, 200);
}

function savePhoto() {
    let canvas = document.getElementById('canvas');
    let image = canvas.toDataURL("image/png");

    document.getElementById('foto').value = image;
    document.getElementById('preview').src = image;

    let modal = bootstrap.Modal.getInstance(document.getElementById('kameraModal'));
    modal.hide();
}
</script>

@endsection
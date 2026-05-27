@extends('layout.main')
@section('title', 'Daftarkan Kartu NFC')

@section('content')
<div class="page-header">
    <h3 class="page-title">Daftarkan Kartu NFC</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">NFC</a></li>
            <li class="breadcrumb-item active">Daftarkan Kartu NFC</li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0"> Daftarkan Kartu NFC</h5>
            </div>
            <div class="card-body">

                <p><b>Mahasiswa:</b> {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</p>
                @if($mahasiswa->nfc_serial)
                    <div class="alert alert-info">
                        Kartu saat ini: <b>{{ $mahasiswa->nfc_serial }}</b>
                    </div>
                @endif

                <button class="btn btn-rounded btn-gradient-info w-100 mb-3" onclick="startScan()">
                     Tempelkan Kartu NFC
                </button>

                <div id="status-box" class="alert alert-secondary text-center" style="display:none">
                    <span id="status-msg"></span>
                </div>

                <form action="{{ route('mahasiswa.simpan', $mahasiswa->mahasiswa_id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Serial Number NFC</label>
                        <input type="text" name="nfc_serial" id="nfc-serial"
                               class="form-control" placeholder="Akan terisi otomatis saat scan" required>
                        @error('nfc_serial')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn  btn-rounded btn-gradient-primary w-100"> Simpan</button>
                    <a href="{{ route('mahasiswa.index') }}" class="btn  btn-rounded btn-secondary w-100 mt-2">Kembali</a>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    async function startScan() {
        if (!('NDEFReader' in window)) {
            alert('Browser tidak mendukung Web NFC. Gunakan Android Chrome.');
            return;
        }

        const statusBox = document.getElementById('status-box');
        const statusMsg = document.getElementById('status-msg');
        statusBox.style.display = 'block';
        statusMsg.textContent   = 'NFC aktif. Dekatkan kartu ke HP...';

        try {
            const ndef = new NDEFReader();
            await ndef.scan();

            ndef.addEventListener('reading', ({ serialNumber }) => {
                document.getElementById('nfc-serial').value = serialNumber;
                statusBox.className = 'alert alert-success text-center';
                statusMsg.textContent = 'Kartu terbaca: ' + serialNumber;
            });
        } catch (err) {
            statusBox.className = 'alert alert-danger text-center';
            statusMsg.textContent = 'Error: ' + err.message;
        }
    }
</script>
@endsection
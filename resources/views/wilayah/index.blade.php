@extends('layout.main')
@section('title', 'Wilayah')

@section('content')

<div class="page-header">
    <h3 class="page-title">Wilayah</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end">
            <li class="breadcrumb-item"><a href="#">Wilayah</a></li>
            <li class="breadcrumb-item active">Wilayah </li>
        </ol>
    </nav>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-3">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-white fw-semibold" style="background:#9b59b6">
                    jQuery AJAX
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Provinsi</label>
                        <select id="provinsi_jquery" class="form-select">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kota / Kabupaten</label>
                        <select id="kota_jquery" class="form-select" disabled>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kecamatan</label>
                        <select id="kecamatan_jquery" class="form-select" disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kelurahan / Desa</label>
                        <select id="kelurahan_jquery" class="form-select" disabled>
                            <option value="">-- Pilih Kelurahan/Desa --</option>
                        </select>
                    </div>

                    <div class="p-3 bg-light border rounded" id="result_jquery">
                        <small class="text-muted">Alamat terpilih: -</small>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-white fw-semibold" style="background:#9b59b6">
                    Axios
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Provinsi</label>
                        <select id="provinsi_axios" class="form-select">
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kota / Kabupaten</label>
                        <select id="kota_axios" class="form-select" disabled>
                            <option value="">-- Pilih Kota/Kabupaten --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kecamatan</label>
                        <select id="kecamatan_axios" class="form-select" disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kelurahan / Desa</label>
                        <select id="kelurahan_axios" class="form-select" disabled>
                            <option value="">-- Pilih Kelurahan/Desa --</option>
                        </select>
                    </div>

                    <div class="p-3 bg-light border rounded" id="result_axios">
                        <small class="text-muted">Alamat terpilih: -</small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const ROUTES = {
    provinsi  : "{{ route('wilayah.provinsi') }}",
    kota      : "{{ route('wilayah.kota') }}",
    kecamatan : "{{ route('wilayah.kecamatan') }}",
    kelurahan : "{{ route('wilayah.kelurahan') }}",
};
const CSRF = "{{ csrf_token() }}";


function showError(msg) {
    Swal.fire({ icon: 'error', title: 'Error', text: msg });
}

function resetSelect(id, placeholder) {
    $(`#${id}`)
        .html(`<option value="">${placeholder}</option>`)
        .prop('disabled', true);
}

function populateSelect(id, data, placeholder) {
    let html = `<option value="">${placeholder}</option>`;
    data.forEach(item => {
        html += `<option value="${item.kode}">${item.nama}</option>`;
    });
    $(`#${id}`).html(html).prop('disabled', false);
}

function updateResult(prefix) {
    const prov = $(`#provinsi_${prefix} option:selected`).text();
    const kota = $(`#kota_${prefix} option:selected`).text();
    const kec = $(`#kecamatan_${prefix} option:selected`).text();
    const kel = $(`#kelurahan_${prefix} option:selected`);

    if (kel.val()) {
        $(`#result_${prefix}`).html(
            `<small class="text-dark fw-semibold">${kel.text()}, ${kec}, ${kota}, ${prov}</small>`
        );
    } else {
        $(`#result_${prefix}`).html(`<small class="text-muted">Alamat terpilih: -</small>`);
    }
}

function loadProvinsiJQuery() {
    $.ajax({
        method : 'GET',
        url : ROUTES.provinsi,
        success: function(res) {
            if (res.status === 'success') {
                populateSelect('provinsi_jquery', res.data, '-- Pilih Provinsi --');
            } else {
                showError(res.message);
            }
        },
        error: function(xhr) {
            console.log(xhr);
            showError(xhr.responseJSON?.message || 'Gagal memuat provinsi');
        }
    });
}

$('#provinsi_jquery').on('change', function() {
    const kode = $(this).val();
    resetSelect('kota_jquery', '-- Pilih Kota --');
    resetSelect('kecamatan_jquery', '-- Pilih Kota terlebih dahulu --');
    resetSelect('kelurahan_jquery', '-- Pilih Kecamatan terlebih dahulu --');
    updateResult('jquery');
    if (!kode) return;

    $.ajax({
        method : 'POST',
        url    : ROUTES.kota,
        data   : { _token: CSRF, kode_provinsi: kode },
        success: function(res) {
            console.log(res);
            if (res.status === 'success') {
                populateSelect('kota_jquery', res.data, '-- Pilih Kota --');
            } else {
                showError(res.message);
            }
        },
        error: function(xhr) {
            console.log(xhr);
            showError(xhr.responseJSON?.message || 'Gagal memuat kota');
        }
    });
});

$('#kota_jquery').on('change', function() {
    const kode = $(this).val();
    resetSelect('kecamatan_jquery', '-- Pilih Kecamatan --');
    resetSelect('kelurahan_jquery', '-- Pilih Kecamatan terlebih dahulu --');
    updateResult('jquery');
    if (!kode) return;

    $.ajax({
        method : 'POST',
        url    : ROUTES.kecamatan,
        data   : { _token: CSRF, kode_kabupaten: kode },
        success: function(res) {
            console.log(res);
            if (res.status === 'success') {
                populateSelect('kecamatan_jquery', res.data, '-- Pilih Kecamatan --');
            } else {
                showError(res.message);
            }
        },
        error: function(xhr) {
            console.log(xhr);
            showError(xhr.responseJSON?.message || 'Gagal memuat kecamatan');
        }
    });
});

$('#kecamatan_jquery').on('change', function() {
    const kode = $(this).val();
    resetSelect('kelurahan_jquery', '-- Pilih Kelurahan --');
    updateResult('jquery');
    if (!kode) return;

    $.ajax({
        method : 'POST',
        url    : ROUTES.kelurahan,
        data   : { _token: CSRF, kode_kecamatan: kode },
        success: function(res) {
            console.log(res);
            if (res.status === 'success') {
                populateSelect('kelurahan_jquery', res.data, '-- Pilih Kelurahan --');
            } else {
                showError(res.message);
            }
        },
        error: function(xhr) {
            console.log(xhr);
            showError(xhr.responseJSON?.message || 'Gagal memuat kelurahan');
        }
    });
});

$('#kelurahan_jquery').on('change', function() {
    updateResult('jquery');
});


function loadProvinsiAxios() {
    axios.get(ROUTES.provinsi)
    .then(function(res) {
        console.log(res.data);
        if (res.data.status === 'success') {
            populateSelect('provinsi_axios', res.data.data, '-- Pilih Provinsi --');
        } else {
            showError(res.data.message);
        }
    })
    .catch(function(err) {
        console.log(err);
        showError(err.response?.data?.message || 'Gagal memuat provinsi');
    });
}

$('#provinsi_axios').on('change', function() {
    const kode = $(this).val();
    resetSelect('kota_axios', '-- Pilih Kota --');
    resetSelect('kecamatan_axios', '-- Pilih Kota terlebih dahulu --');
    resetSelect('kelurahan_axios', '-- Pilih Kecamatan terlebih dahulu --');
    updateResult('axios');
    if (!kode) return;

    const params = new URLSearchParams({ _token: CSRF, kode_provinsi: kode });
    axios.post(ROUTES.kota, params)
    .then(function(res) {
        console.log(res.data);
        if (res.data.status === 'success') {
            populateSelect('kota_axios', res.data.data, '-- Pilih Kota --');
        } else {
            showError(res.data.message);
        }
    })
    .catch(function(err) {
        console.log(err);
        showError(err.response?.data?.message || 'Gagal memuat kota');
    });
});

$('#kota_axios').on('change', function() {
    const kode = $(this).val();
    resetSelect('kecamatan_axios', '-- Pilih Kecamatan --');
    resetSelect('kelurahan_axios', '-- Pilih Kecamatan terlebih dahulu --');
    updateResult('axios');
    if (!kode) return;

    const params = new URLSearchParams({ _token: CSRF, kode_kabupaten: kode });
    axios.post(ROUTES.kecamatan, params)
    .then(function(res) {
        console.log(res.data);
        if (res.data.status === 'success') {
            populateSelect('kecamatan_axios', res.data.data, '-- Pilih Kecamatan --');
        } else {
            showError(res.data.message);
        }
    })
    .catch(function(err) {
        console.log(err);
        showError(err.response?.data?.message || 'Gagal memuat kecamatan');
    });
});

$('#kecamatan_axios').on('change', function() {
    const kode = $(this).val();
    resetSelect('kelurahan_axios', '-- Pilih Kelurahan --');
    updateResult('axios');
    if (!kode) return;

    const params = new URLSearchParams({ _token: CSRF, kode_kecamatan: kode });
    axios.post(ROUTES.kelurahan, params)
    .then(function(res) {
        console.log(res.data);
        if (res.data.status === 'success') {
            populateSelect('kelurahan_axios', res.data.data, '-- Pilih Kelurahan --');
        } else {
            showError(res.data.message);
        }
    })
    .catch(function(err) {
        console.log(err);
        showError(err.response?.data?.message || 'Gagal memuat kelurahan');
    });
});

$('#kelurahan_axios').on('change', function() {
    updateResult('axios');
});

$(document).ready(function() {
    loadProvinsiJQuery();
    loadProvinsiAxios();
});
</script>

@endsection
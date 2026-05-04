<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QRCode Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #bdcbf8, #f8fafc);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 380px;
            border: none;
            border-radius: 18px;
            transition: 0.3s ease;
        }
        .card-body {
            padding: 30px 25px;
        }
        .card-title {
            font-weight: 600;
            color: #4f46e5;
        }
        .card-title i {
            margin-right: 6px;
        }
        .qr-img {
            background: #fff;
            border: 2px dashed #c7d2fe;
            padding: 12px;
            border-radius: 14px;
            max-width: 220px;
            margin: 0 auto;
        }
        .card p strong {
            color: #111827;
        }
        .btn-gradient-primary {
            background: linear-gradient(45deg, #bb8ce2, #9f3bf6);
            color: #fff;
            border: none;
        }


    </style>
</head>

<body>
    <div class="center-wrapper">
        <div class="card text-center shadow">
            <div class="card-body">
                <h4 class="card-title mb-1">
                    <i class="fa fa-qrcode"></i> QRCode Pesanan
                </h4>

                <p class="text-muted mb-3">
                    Tunjukkan QRCode ini ke vendor saat mengambil pesanan
                </p>

                <img src="data:image/png;base64,{{ $qrCode }}" 
                    class="img-fluid qr-img">

                <p class="mt-3">
                    <strong>ID Pesanan:</strong> {{ $pesanan->idpesanan }}
                </p>

                <a href="{{ route('payment.success', $pesanan->idpesanan) }}" 
                    class="btn btn-rounded btn-gradient-primary ">
                    Kembali 
                </a>
            </div>
        </div>
    </div>
</body>
</html>
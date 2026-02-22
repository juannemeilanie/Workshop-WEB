<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
</head>
<body>
    <h1>Masukkan OTP Anda</h1>

    @if($errors->any())
        <div style="color:red">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="text" name="otp" placeholder="Kode OTP" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
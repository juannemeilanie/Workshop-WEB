<h3>Masukkan Kode OTP</h3>

<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <input type="text" name="otp" maxlength="6" placeholder="Masukkan 6 karakter OTP">
    <button type="submit">Verifikasi</button>
</form>

@if($errors->any())
    <div style="color:red;">
        {{ $errors->first() }}
    </div>
@endif

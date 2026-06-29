<form method="POST" action="{{ route('wali.login.send') }}">
    @csrf
    <input type="text" name="phone" placeholder="08xxxxxxxxxx">
    <button type="submit">Kirim OTP</button>
</form>
@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

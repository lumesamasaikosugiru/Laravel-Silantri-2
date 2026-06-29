<form method="POST" action="{{ route('wali.verify.submit') }}">
    @csrf
    <input type="text" name="code" placeholder="123456">
    <button type="submit">Verifikasi</button>
</form>
@if (session('error'))
    <p>{{ session('error') }}</p>
@endif

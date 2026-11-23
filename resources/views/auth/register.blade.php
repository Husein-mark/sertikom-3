@extends('layouts.auth')

@section('title', 'Registrasi Pengguna')

@section('content')
<div class="auth-header">
    <h2>Daftar Akun Baru</h2>
    <p>Buat akun untuk memesan tiket dan memantau status pembayaran.</p>
</div>

@if($errors->any())
    <div style="background-color: #450a0a; border: 1px solid #dc2626; color: #fca5a5; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.8rem;">
        <ul style="padding-left: 1.25rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Nama sesuai identitas" value="{{ old('name') }}" required />
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required />
    </div>

    <div class="form-group">
        <label class="form-label" for="phone">Nomor Telepon / WhatsApp</label>
        <input type="tel" id="phone" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required />
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Kata Sandi</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required />
    </div>

    <div class="form-group" style="margin-bottom: 1.5rem;">
        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required />
    </div>

    <button type="submit" class="btn btn-primary btn-block">Daftar Akun</button>
</form>

<div class="auth-footer-links">
    Sudah memiliki akun? <a href="{{ route('login') }}">Masuk Disini</a>
</div>
@endsection

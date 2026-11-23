@extends('layouts.auth')

@section('title', 'Login Pengguna')

@section('content')
<div class="auth-header">
    <h2>Masuk Akun</h2>
    <p>Gunakan kredensial Anda untuk mengakses tiket dan pesanan.</p>
</div>

@if(session('success'))
    <div style="background-color: #064e3b; border: 1px solid #059669; color: #a7f3d0; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background-color: #450a0a; border: 1px solid #dc2626; color: #fca5a5; padding: 0.65rem 1rem; border-radius: 4px; margin-bottom: 1rem; font-size: 0.85rem;">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus />
        @error('email')
            <div style="color: var(--color-danger); font-size: 0.78rem; margin-top: 0.25rem;">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
            <label class="form-label" for="password" style="margin-bottom: 0;">Kata Sandi</label>
        </div>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required />
        @error('password')
            <div style="color: var(--color-danger); font-size: 0.78rem; margin-top: 0.25rem;">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
        <input type="checkbox" id="remember" name="remember" style="accent-color: var(--color-primary);" />
        <label for="remember" style="font-size: 0.82rem; color: var(--text-muted); cursor: pointer;">Ingat sesi login ini</label>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Masuk</button>
</form>

<div style="margin-top: 1.5rem; padding: 0.75rem; background-color: #0c0f17; border: 1px solid var(--border-color); border-radius: 4px; font-size: 0.75rem; color: var(--text-sub);">
    <strong>Akun Pengujian Demo (Seeder):</strong><br />
    • Admin: <code>admin@nicepark.id</code> / <code>password123</code><br />
    • Pelanggan: <code>alwi@example.com</code> / <code>password123</code>
</div>

<div class="auth-footer-links">
    Belum memiliki akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
</div>
@endsection

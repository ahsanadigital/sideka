@extends('layouts.auth')

@section('content')
    <h2 class="mb-3 fs-7 fw-bolder">Selamat Datang di SIDEKA</h2>
    <p class=" mb-9">Silahkan masuk terlebih dahulu sebelum mengelola data.</p>

    <form method="POST" action="{{ route('login') }}" class="form-ajax" data-success-message="Anda telah terautentikasi! Sistem akan mengarahkan anda ke dalam panel dasbor dalam waktu 5 detik." data-redirect-on-success="{{ route('home') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Surel</label>
            <input id="email" placeholder="Masukkan surel anda" type="email"
                class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                required autocomplete="email" autofocus />
            <div class="error-wrapper"></div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Kata Sandi</label>
            <input id="password" placeholder="Masukkan kata sandi anda" type="password"
                class="form-control @error('password') is-invalid @enderror" name="password" required
                autocomplete="current-password" />
            <div class="error-wrapper"></div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input primary" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }} />
                <label class="form-check-label text-dark" for="remember">
                    Ingatkan saya
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-primary fw-medium" href="{{ route('password.request') }}">
                    Lupa kata sandimu?
                </a>
            @endif
        </div>
        <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Masuk</button>
    </form>
@endsection

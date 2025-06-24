<x-guest-layout>
    <h1 class="auth-title">Lupa Password</h1>
    <p class="auth-subtitle mb-5">Masukkan email Anda untuk menerima link reset password.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" name="email" id="email" class="form-control form-control-xl" placeholder="Email" value="{{ old('email') }}" required autofocus>
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim Link Reset Password</button>
    </form>
    
    <div class="text-center mt-5 text-lg fs-4">
        <p><a class="font-bold" href="{{ route('login') }}">Kembali ke Login</a></p>
    </div>
</x-guest-layout>

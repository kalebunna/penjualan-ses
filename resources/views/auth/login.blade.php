<x-guest-layout>
    <h1 class="auth-title">Log in.</h1>
    <p class="auth-subtitle mb-5">Masuk dengan data yang Anda masukkan saat pendaftaran.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" name="email" id="email" class="form-control form-control-xl" placeholder="Email" value="{{ old('email') }}" required autofocus>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="password" id="password" class="form-control form-control-xl" placeholder="Password" required autocomplete="current-password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <div class="form-control-icon-right" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                <i class="bi bi-eye" id="togglePassword" onclick="togglePasswordVisibility()"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label text-gray-600" for="remember_me">
                Ingat saya
            </label>
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        @if (Route::has('password.request'))
            <p><a class="font-bold" href="{{ route('password.request') }}">Lupa password?</a></p>
        @endif
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePassword');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</x-guest-layout>

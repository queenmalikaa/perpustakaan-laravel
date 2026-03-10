<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        
        .login-wrapper {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 440px;
            width: 100%;
            padding: 2rem 2.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        }
        
        .brand-section {
            text-align: center;
            margin-bottom: 1.75rem;
        }
        
        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
        }
        
        .brand-title {
            font-size: 1.625rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 0.375rem;
            letter-spacing: -0.025em;
        }
        
        .brand-subtitle {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .form-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .form-field {
            position: relative;
        }
        
        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.375rem;
            letter-spacing: -0.01em;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #94a3b8;
            transition: color 0.2s ease;
            pointer-events: none;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .form-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #4F46E5;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        }
        
        .form-field:focus-within .input-icon {
            color: #4F46E5;
        }
        
        .form-field:focus-within .form-label {
            color: #4F46E5;
        }
        
        .remember-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.5rem;
        }
        
        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .remember-checkbox input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .remember-checkbox input[type="checkbox"]:checked {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-color: #4F46E5;
        }
        
        .remember-checkbox label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #64748b;
            cursor: pointer;
        }
        
        .forgot-link {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #4F46E5;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .forgot-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #7C3AED;
        }
        
        .forgot-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .submit-button {
            width: 100%;
            padding: 0.875rem 1rem;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9375rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.3);
            letter-spacing: -0.01em;
            margin-top: 0.5rem;
        }
        
        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
        }
        
        .submit-button:active {
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.25rem 0 1rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .divider span {
            padding: 0 1rem;
            color: #94a3b8;
            font-size: 0.8125rem;
            font-weight: 500;
        }
        
        .register-section {
            text-align: center;
        }
        
        .register-text {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .register-link {
            color: #4F46E5;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .register-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .register-link:hover {
            color: #7C3AED;
        }
        
        .register-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-card {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.8125rem;
            font-weight: 500;
            margin-top: 0.375rem;
        }
    </style>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Brand Section -->
            <div class="brand-section">
                <div class="brand-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                </div>
                <h1 class="brand-title">Selamat Datang</h1>
                <p class="brand-subtitle">Masuk ke akun Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="form-section">
                @csrf

                <!-- Email Address -->
                <div class="form-field">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input 
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input"
                            placeholder="john@example.com"
                            required
                            autofocus
                            autocomplete="username"
                        />
                    </div>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-field">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input 
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                        />
                    </div>
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-section">
                    <div class="remember-checkbox">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Ingat saya</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">
                    Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>atau</span>
            </div>

            <!-- Register Link -->
            <div class="register-section">
                <p class="register-text">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="register-link">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
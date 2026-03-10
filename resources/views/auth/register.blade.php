<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        
        .register-wrapper {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 2.5rem 3rem;
            position: relative;
            overflow: hidden;
        }
        
        .register-card::before {
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
            margin-bottom: 2rem;
        }
        
        .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
        }
        
        .brand-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 0.25rem;
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

        .form-row {
            display: flex;
            gap: 1rem;
        }

        .form-row .form-field {
            flex: 1;
        }

        @media (max-width: 640px) {
            .form-row {
                flex-direction: column;
            }
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
            left: 1rem;
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
            border-radius: 12px;
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
        
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            resize: none;
            min-height: 80px;
        }
        
        .form-textarea::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #4F46E5;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        }
        
        .textarea-icon {
            position: absolute;
            left: 1rem;
            top: 0.875rem;
            width: 18px;
            height: 18px;
            color: #94a3b8;
            transition: color 0.2s ease;
            pointer-events: none;
        }
        
        .submit-button {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9375rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.3);
            letter-spacing: -0.01em;
            margin-top: 0.25rem;
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
            margin: 1.25rem 0;
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
        
        .login-section {
            text-align: center;
        }
        
        .login-text {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .login-link {
            color: #4F46E5;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .login-link:hover {
            color: #7C3AED;
        }
        
        .login-link::after {
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
        
        .login-link:hover::after {
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
        
        .register-card {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.25rem;
        }
    </style>

    <div class="register-wrapper">
        <div class="register-card">
            <!-- Brand Section -->
            <div class="brand-section">
                <div class="brand-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h1 class="brand-title">Buat Akun</h1>
                <p class="brand-subtitle">Mulai perjalanan membaca Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="form-section">
                @csrf

                <div class="form-row">
                    <!-- Nama Lengkap -->
                    <div class="form-field">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input 
                                id="nama_lengkap"
                                type="text"
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                class="form-input"
                                placeholder="John Doe"
                                required
                                autofocus
                                autocomplete="name"
                            />
                        </div>
                        @error('nama_lengkap')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-field">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            <input 
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                class="form-input"
                                placeholder="johndoe"
                                required
                                autocomplete="username"
                            />
                        </div>
                        @error('username')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
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
                            autocomplete="email"
                        />
                    </div>
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-row">
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
                                autocomplete="new-password"
                            />
                        </div>
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-field">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <input 
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="••••••••"
                                required
                                autocomplete="new-password"
                            />
                        </div>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="form-field">
                    <label for="alamat" class="form-label">Alamat</label>
                    <div class="input-wrapper">
                        <svg class="textarea-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <textarea 
                            id="alamat"
                            name="alamat"
                            class="form-textarea"
                            placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                            required
                        >{{ old('alamat') }}</textarea>
                    </div>
                    @error('alamat')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">
                <span>atau</span>
            </div>

            <!-- Login Link -->
            <div class="login-section">
                <p class="login-text">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="login-link">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
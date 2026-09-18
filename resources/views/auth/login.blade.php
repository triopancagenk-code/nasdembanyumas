@extends('layouts.app')

@section('title', 'Sign In – Admin Portal DPD Partai NasDem Banyumas')

@push('styles')
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .auth-page-wrapper {
            background-color: #001233;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.035) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
            background-size: 38px 38px;
            color: #ffffff;
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px 70px;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .auth-card {
            max-width: 960px;
            width: 100%;
            background: transparent;
            border-radius: 22px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ----------------------------------------------------
           LEFT PANEL (DARK BLUE GRADIENT)
           ---------------------------------------------------- */
        .panel-left {
            background: linear-gradient(145deg, #0d2255 0%, #061638 100%);
            padding: 48px 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
        }

        .panel-left-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel-left-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #001844;
            border: 1.5px solid rgba(245, 158, 11, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
        }

        .panel-left-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .panel-left-hero {
            margin-top: 36px;
            margin-bottom: 24px;
        }

        .panel-left-hero h1 {
            font-size: 33px;
            font-weight: 900;
            line-height: 1.15;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .panel-left-hero h1 span {
            color: #f59e0b;
            display: block;
            margin-top: 4px;
        }

        .panel-left-hero p {
            font-size: 14px;
            line-height: 1.65;
            color: #94a3b8;
            margin-top: 16px;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            color: #e2e8f0;
            font-weight: 600;
        }

        .feature-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #f59e0b;
            box-shadow: 0 0 10px rgba(245, 158, 11, 0.8);
            flex-shrink: 0;
        }

        /* ----------------------------------------------------
           RIGHT PANEL (CRISP WHITE CARD)
           ---------------------------------------------------- */
        .panel-right {
            background: #ffffff;
            padding: 48px 44px;
            color: #0f172a;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .panel-right-head h2 {
            font-size: 27px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .panel-right-head p {
            font-size: 13.5px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon-right {
            position: absolute;
            right: 14px;
            color: #94a3b8;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            padding: 0;
        }

        .input-icon-right:hover {
            color: #0f172a;
        }

        .auth-input {
            width: 100%;
            padding: 13px 14px 13px 44px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-size: 14px;
            color: #0f172a;
            font-family: inherit;
            outline: none;
            transition: all 0.15s ease;
        }

        .auth-input.has-right-icon {
            padding-right: 44px;
        }

        .auth-input:focus {
            border-color: #f59e0b;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .form-row-remember {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            margin-top: 4px;
            margin-bottom: 22px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }

        .remember-checkbox {
            accent-color: #f59e0b;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: #f59e0b;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: #d97706;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 13.5px 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.35);
            transition: all 0.15s ease;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 22px rgba(245, 158, 11, 0.45);
        }


        .panel-right-footer {
            margin-top: 24px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
            font-size: 11.5px;
            color: #94a3b8;
            font-weight: 500;
        }

        /* ----------------------------------------------------
           RESPONSIVE MOBILE
           ---------------------------------------------------- */
        @media (max-width: 820px) {
            .auth-card {
                grid-template-columns: 1fr;
            }

            .panel-left {
                padding: 36px 24px;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .panel-right {
                padding: 36px 24px;
            }

            .panel-left-hero h1 {
                font-size: 26px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="auth-page-wrapper">
        <div class="auth-card">

            <!-- LEFT PANEL: WELCOME TO ADMIN PORTAL -->
            <div class="panel-left">
                <div>
                    <div class="panel-left-top">
                        <div class="panel-left-badge">
                            <img src="{{ asset('images/nasdem_trace.svg') }}" alt="NasDem Icon">
                        </div>
                        <div>
                            <div style="font-size: 19px; font-weight: 900; color: #ffffff; line-height: 1.1;">NasDem</div>
                            <div style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">Banyumas Dashboard</div>
                        </div>
                    </div>

                    <div class="panel-left-hero">
                        <h1>
                            Welcome to
                            <span>Admin Portal</span>
                        </h1>
                        <p>
                            Secure access to manage content, members, and analytics for DPD Partai NasDem Banyumas.
                        </p>

                        <ul class="feature-list">
                            <li class="feature-item">
                                <span class="feature-dot"></span>
                                <span>Real-time Analytics Dashboard</span>
                            </li>
                            <li class="feature-item">
                                <span class="feature-dot"></span>
                                <span>Multi-role Access Control</span>
                            </li>
                            <li class="feature-item">
                                <span class="feature-dot"></span>
                                <span>Content Management System</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div style="font-size: 11.5px; color: #64748b; font-weight: 600;">
                    DPD Partai NasDem Kabupaten Banyumas
                </div>
            </div>

            <!-- RIGHT PANEL: SIGN IN FORM -->
            <div class="panel-right">
                <div class="panel-right-head">
                    <h2>Sign In</h2>
                    <p>Enter your credentials to access the dashboard</p>

                    @if(session('error'))
                        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; margin-bottom: 16px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 10px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 600; margin-bottom: 16px;">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('login') }}" id="adminLoginForm">
                    @csrf

                    <!-- Username or Email Address -->
                    <div class="form-group">
                        <label class="form-label" for="emailInput">Username / Email</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                id="emailInput" 
                                name="email" 
                                class="auth-input" 
                                placeholder="Masukkan username atau email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                autocomplete="username"
                            >
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label" for="passwordInput">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                id="passwordInput" 
                                name="password" 
                                class="auth-input has-right-icon" 
                                placeholder="Masukkan password" 
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="input-icon-right" onclick="togglePasswordVisibility()" title="Lihat Password">
                                <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-row-remember">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" class="remember-checkbox" checked>
                            <span>Remember me</span>
                        </label>
                        <a href="#" onclick="alert('Untuk keperluan reset akun admin, silakan hubungi tim IT/Superadmin DPD Partai NasDem Banyumas.'); return false;" class="forgot-link">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit" id="btnSignIn">
                        <span>Sign In to Dashboard</span>
                        <span>→</span>
                    </button>
                </form>

                <div class="panel-right-footer">
                    Protected by enterprise-grade security • &copy; {{ date('Y') }} DPD NasDem Banyumas
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('passwordInput');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwd.type = 'password';
                eye.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
@endpush

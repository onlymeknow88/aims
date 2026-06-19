<div class="inner-content login"
    style="min-height: 100vh; background: #f8fafc; font-family: 'Inter', system-ui, -apple-system, sans-serif;">
    <style>
        /* Force text colors to overcome aggressive styles.css overrides */
        .content-login .content-center h1.text-white {
            color: #ffffff !important;
            font-size: 5.5rem !important;
            font-weight: 900 !important;
            letter-spacing: -3px !important;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3) !important;
            opacity: 1 !important;
            margin-bottom: 1rem !important;
        }

        .content-login .content-center h3.text-white-50 {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            letter-spacing: 2px !important;
            text-transform: uppercase !important;
            opacity: 1 !important;
        }

        /* Style improvements for input fields */
        .form-control:focus {
            border-color: #063D56 !important;
            box-shadow: 0 0 0 4px rgba(4, 64, 143, 0.15) !important;
        }

        /* Modern button gradient styling */
        .btn-success {
            background: linear-gradient(135deg, #063D56 0%, #063D56 100%) !important;
            border: none !important;
            transition: all 0.25s ease !important;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(3, 40, 121, 0.3) !important;
            filter: brightness(1.05);
        }

        .btn-success:active {
            transform: translateY(0);
        }

        /* Microsoft SSO Button modern styling */
        .btn-outline-secondary {
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
        }

        .btn-outline-secondary:hover {
            background-color: #f8fafc !important;
            border-color: #94a3b8 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
        }

        /* Arrow left hover */
        .btn-outline-light {
            transition: all 0.2s ease !important;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            transform: scale(1.05);
        }
    </style>
    <div class="container-fluid g-0">
        <div class="row g-0">
            <!-- Left Banner Section -->
            <div class="col d-none d-lg-block">
                <div class="vh-100 p-5"
                    style="background: linear-gradient(135deg, #0b4958 0%, #083c4b 40%, #03232e 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">

                    <!-- Back Button placed relative to the main banner -->
                    <div class="nav-top"
                        style="position: absolute; top: 30px; left: 30px; z-index: 10; opacity: 1 !important; margin-bottom: 0 !important;">
                        <a href="{{ url('/') }}"
                            class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 45px; height: 45px; border-color: rgba(255,255,255,0.25); background: rgba(255,255,255,0.05); backdrop-filter: blur(8px); color: #ffffff !important;">
                            <i class="fa-solid fa-arrow-left text-white fs-5" style="color: #ffffff !important;"></i>
                        </a>
                    </div>

                    <div class="content-login p-5 text-center"
                        style="position: relative; z-index: 2; max-width: 600px;">
                        <div class="content-center">
                            <h1 class="text-white mb-3"
                                style="font-size: 5.5rem; font-weight: 900; letter-spacing: -3px; text-shadow: 0 4px 20px rgba(0,0,0,0.3); font-family: 'Outfit', sans-serif;">
                                AIMS</h1>
                            <h3 class="text-white-50 fs-5 mb-4"
                                style="font-weight: 500; letter-spacing: 2px; text-transform: uppercase; font-size: 0.95rem;">
                                Alamtri Integrated Management System</h3>
                            <div
                                style="width: 100px; height: 4px; background: linear-gradient(90deg, #10b981, #3b82f6); margin: 0 auto; border-radius: 2px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Section -->
            <div class="col-12 col-lg-4 col-xxl-3">
                <div class="bg-white vh-100 p-5 d-flex flex-column justify-content-center shadow-lg"
                    style="border-left: 1px solid rgba(0,0,0,0.06); overflow-y: auto;">
                    <div class="login-header d-flex flex-column align-items-center mb-4">
                        <div
                            style="border-radius: 0.75rem; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <img src="{{ asset('images/alamtri.png') }}" alt="Adaro Minerals Logo"
                                style="height: 100px; object-fit: contain;">
                        </div>
                        <h3 class="fw-bold mb-1" style="color: #0f172a; font-family: 'Outfit', sans-serif;">Login ke
                            Akun</h3>
                        <p class="text-muted text-center" style="font-size: 0.875rem;">Akses terpusat ke semua aplikasi
                            modul AIMS</p>
                    </div>

                    <div class="form-wrapper">
                        @if (session()->has('error'))
                            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2"
                                style="background-color: #fef2f2; color: #991b1b; border-radius: 0.5rem; font-size: 0.875rem;">
                                <i class="fa-solid fa-circle-exclamation fs-5"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2"
                                    style="background-color: #fef2f2; color: #991b1b; border-radius: 0.5rem; font-size: 0.875rem; mb-2;">
                                    <i class="fa-solid fa-circle-exclamation fs-5"></i>
                                    <div>{{ $error }}</div>
                                </div>
                            @endforeach
                        @endif

                        <form method="POST" wire:submit.prevent="login">
                            <div class="mb-3 form-floating">
                                <input type="email" wire:model.defer='email'
                                    class="form-control @error('email') is-invalid @enderror"
                                    style="border-radius: 0.5rem; border-color: #cbd5e1; font-size: 0.95rem;" id="email"
                                    placeholder="nama@email.com">
                                <label for="email" style="color: #64748b;">Alamat Email</label>
                            </div>

                            <div class="mb-3 position-relative" x-data="{ show: true }">
                                <div class="form-floating">
                                    <input :type="show ? 'password' : 'text'" wire:model.defer='password'
                                        class="form-control @error('password') is-invalid @enderror"
                                        style="border-radius: 0.5rem; border-color: #cbd5e1; font-size: 0.95rem; padding-right: 45px;"
                                        placeholder="Password" id="password" />
                                    <label for="password" style="color: #64748b;">Password</label>
                                </div>
                                <span @click.prevent="show = !show"
                                    style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center;">
                                    <img x-show='show' src="{{ asset('./images/icons/view.png') }}" alt="show password"
                                        style="width: 20px; opacity: 0.6; transition: opacity 0.15s ease;">
                                    <img x-cloak x-show='!show' src="{{ asset('./images/icons/hide.png') }}"
                                        alt="hide password"
                                        style="width: 20px; opacity: 0.6; transition: opacity 0.15s ease;">
                                </span>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" wire:model.defer='remember' type="checkbox" value="1"
                                    id="remember" style="border-radius: 0.25rem;">
                                <label class="form-check-label text-secondary" for="remember"
                                    style="font-size: 0.875rem;">
                                    Ingat Saya
                                </label>
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit"
                                    class="btn btn-success btn-lg d-flex align-items-center justify-content-center gap-2"
                                    style="background-color: #059669; border: none; border-radius: 0.5rem; font-size: 1rem; font-weight: 600; padding: 0.75rem 1rem;">
                                    <i class="fa-solid fa-right-to-bracket"></i> Login
                                </button>
                            </div>
                        </form>

                        <div class="text-center my-3 text-muted position-relative">
                            <hr style="border-color: #cbd5e1;">
                            <span class="px-2"
                                style="background: #fff; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); font-size: 0.75rem; letter-spacing: 1px; font-weight: 600; color: #94a3b8;">ATAU</span>
                        </div>

                        <div class="mb-3 d-grid">
                            <a href="{{ route('auth.microsoft.redirect.central') }}"
                                class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center gap-2"
                                style="border-color: #cbd5e1; color: #334155; background-color: #fff; border-radius: 0.5rem; font-size: 0.95rem; font-weight: 600; padding: 0.75rem 1rem; transition: all 0.2s;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 23 23"
                                    style="vertical-align: middle;">
                                    <path fill="#f35325" d="M0 0h11v11H0z" />
                                    <path fill="#81bc06" d="M12 0h11v11H12z" />
                                    <path fill="#05a6f0" d="M0 12h11v11H0z" />
                                    <path fill="#ffba08" d="M12 12h11v11H12z" />
                                </svg>
                                Akun Microsoft
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

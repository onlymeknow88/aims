@section('title')
    Otentikasi Dua Faktor (2FA)
@endsection

@push('styles')
<style>
    /* Fix background image spilling when content is empty */
    .dashboard-wrapper {
        background-image: none !important;
        background-color: #F2F3F8 !important;
    }

    .setup-card {
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        background: #ffffff;
    }
    .secret-key-badge {
        font-family: monospace;
        letter-spacing: 2px;
        background-color: #f1f5f9;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 1.1rem;
    }
</style>
@endpush

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            @if ($message)
                <div class="alert alert-{{ $messageType === 'success' ? 'success' : 'info' }} alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
                    <i class="fa-solid fa-circle-info me-2"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card setup-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <div>
                        <h4 class="fw-bold text-dark m-0"><i class="fa-solid fa-shield-halved text-success me-2"></i> Pengaturan Keamanan 2FA</h4>
                        <p class="text-muted small m-0 mt-1">Lindungi akun Anda dengan otentikasi dua faktor berbasis TOTP.</p>
                    </div>
                </div>

                @if (Auth::guard('dashboard')->user()->google2fa_enabled)
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-circle-check text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold">2FA Aktif</h5>
                        <p class="text-muted px-4">Akun Anda dilindungi dengan Otentikasi Dua Faktor. Setiap kali masuk, Anda harus memasukkan kode 6 digit dari aplikasi authenticator Anda.</p>
                        
                        <div class="mt-4">
                            <button wire:click="disable2FA" class="btn btn-danger btn-lg px-4" style="border-radius: 10px; font-size: 0.95rem; font-weight: 600;">
                                <i class="fa-solid fa-trash-can me-2"></i> Nonaktifkan 2FA
                            </button>
                        </div>
                    </div>
                @else
                    <div class="setup-instructions">
                        <h6 class="fw-bold text-dark mb-3">Langkah-langkah Aktivasi:</h6>
                        
                        <ol class="small text-secondary ps-3 mb-4">
                            <li class="mb-2">Unduh aplikasi authenticator (Google Authenticator, Microsoft Authenticator, atau Authy) di ponsel Anda.</li>
                            <li class="mb-2">Pindai kode QR di bawah ini menggunakan kamera aplikasi authenticator Anda.</li>
                            <li class="mb-2">Jika tidak dapat memindai, masukkan Kunci Rahasia di bawah secara manual ke dalam aplikasi.</li>
                        </ol>

                        <div class="text-center mb-4">
                            <img src="{{ $qrCodeImage }}" alt="QR Code 2FA" class="img-thumbnail p-3 shadow-sm mb-3" style="border-radius: 12px; max-width: 220px;">
                            
                            <div class="mt-2">
                                <span class="text-muted small d-block mb-1">Kunci Rahasia (Manual Key):</span>
                                <span class="secret-key-badge text-dark fw-bold">{{ $secretKey }}</span>
                            </div>
                        </div>

                        <form wire:submit.prevent="enable2FA" class="border-top pt-4">
                            <div class="mb-3">
                                <label for="totpCode" class="form-label fw-semibold small text-dark">Masukkan Kode Verifikasi 6-Digit:</label>
                                <input type="text" wire:model.defer="totpCode" 
                                    class="form-control form-control-lg text-center fw-bold @error('totpCode') is-invalid @enderror" 
                                    style="border-radius: 10px; font-size: 1.5rem; letter-spacing: 0.25rem;" 
                                    maxlength="6" placeholder="000000" autocomplete="off">
                                @error('totpCode')
                                    <div class="invalid-feedback text-center mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success btn-lg" style="background-color: #059669; border: none; border-radius: 10px; font-weight: 600;">
                                    <i class="fa-solid fa-circle-check me-2"></i> Aktifkan 2FA
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-secondary text-decoration-none small">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</div>

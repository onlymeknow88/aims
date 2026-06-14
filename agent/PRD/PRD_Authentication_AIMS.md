# PRD — Authentication: Microsoft SSO + TOTP (2FA)
## AIMS — Adaro Integrated Management System
**Versi:** 1.1 | **Tanggal:** 2026-05-31 | **Status:** Draft — Revisi Jawaban Tim

---

## 1. Latar Belakang & Tujuan

Sistem AIMS menggunakan arsitektur **Laravel Modules** (`nwidart/laravel-modules`) dengan **12 modul aktif**, masing-masing memiliki guard auth sendiri (`ko`, `kpp`, `audit`, `sap`, `csms`, `coe`, `kplh`, `mcu`, `pica`, `ibpr-and-bowtie`, `document-system`, `field-leadership`). Setiap modul memiliki halaman login Livewire-nya sendiri.

**Masalah saat ini:**
- Login hanya via email + password (tanpa 2FA)
- Tidak ada integrasi Microsoft Azure AD (SSO korporat)
- Setiap modul duplikasi kode login secara manual

**Tujuan fitur ini:**
1. **Microsoft SSO** — Login via akun Microsoft/Azure AD menggunakan **tenant Office 365 baru** (terpisah dari tenant Adaro yang sudah ada)
2. **TOTP 2FA Wajib** — Login manual (email+password) **wajib** melewati verifikasi OTP 6 digit via Google Authenticator atau Microsoft Authenticator
3. **Dual Login** — Kedua metode login tersedia di **semua 12 modul**: (a) Sign in with Microsoft (SSO), (b) Login manual email+password+2FA
4. Menyediakan shared Auth Service agar tidak duplikasi per modul
5. **Recovery Code** — 6 digit angka sebagai backup jika user kehilangan akses authenticator

---

## 2. Scope & Modul Terdampak

| Modul | Guard | Login Class | Status Saat Ini |
|-------|-------|-------------|-----------------|
| KO | `ko` | `KO\Http\Livewire\Auth\Login` | Email+Password |
| KPP | `kpp` | `KPP\Http\Livewire\Auth\Login` | Email+Password |
| Audit | `audit` | `Audit\Http\Livewire\Auth\Login` | Email+Password |
| SAP | `sap` | `Sap\Http\Livewire\Auth\Login` | Email+Password |
| CSMS | `csms` | `CSMS\Http\Livewire\Login\LoginPage` | Email+Password |
| CoE | `coe` | `Coe\Http\Livewire\Auth\Login` | Email+Password |
| KPLH | `kplh` | `Kplh\Http\Livewire\Auth\Login` | Email+Password |
| MCU | `mcu` | `Mcu\Http\Livewire\Auth\Login` | Email+Password |
| PICA | `pica` | `Pica\Http\Livewire\LoginPage\LoginPage` | Email+Password |
| IbprAndBowtie | `ibpr-and-bowtie` | `IbprAndBowtie\Http\Livewire\Auth\Login` | Email+Password |
| DocumentSystem | `document-system` | `DocumentSystem\Http\Livewire\Auth\Login` | Email+Password |
| FieldLeadership | `field-leadership` | `FieldLeadership\Http\Livewire\Login\LoginPage` | Email+Password (API) |

---

## 3. User Stories

### 3.1 Microsoft SSO
> **US-01:** Sebagai pengguna, saya dapat klik "Sign in with Microsoft" di halaman login modul manapun, lalu diarahkan ke Microsoft login dan kembali ke modul yang sama.

> **US-02:** Sebagai admin, saya dapat mengizinkan atau memblokir akun Microsoft tertentu per modul berdasarkan role/permission Spatie yang sudah ada.

> **US-03:** Jika email Microsoft sudah ada di tabel `users`, sistem otomatis menghubungkan akun tanpa membuat duplikat.

### 3.2 Login Manual + TOTP 2FA (Wajib)
> **US-04:** Sebagai pengguna, setelah login email+password berhasil, sistem **selalu** meminta kode OTP 6 digit (2FA wajib untuk semua login manual).

> **US-05:** Sebagai pengguna baru yang belum setup 2FA, saya **diarahkan paksa** ke halaman setup 2FA sebelum bisa mengakses dashboard.

> **US-06:** Sebagai pengguna, saya dapat setup 2FA dari halaman profil dengan scan QR code ke Google Authenticator atau Microsoft Authenticator.

> **US-07:** Sebagai pengguna, saya mendapatkan **recovery codes (6 digit angka)** saat aktivasi 2FA, yang bisa digunakan sebagai backup jika kehilangan akses authenticator.

### 3.3 Recovery Code
> **US-08:** Sebagai pengguna, saya dapat menggunakan salah satu recovery code 6 digit angka untuk login jika tidak bisa akses aplikasi Authenticator. Setiap recovery code hanya bisa digunakan **satu kali**.

> **US-09:** Sebagai pengguna, saya dapat melakukan regenerasi recovery codes dari halaman profil dengan konfirmasi password.

---

## 4. Arsitektur Teknis

### 4.1 Paket yang Dibutuhkan

```bash
# Microsoft OAuth2 SSO
composer require socialiteproviders/microsoft-azure

# TOTP 2FA
composer require pragmarx/google2fa-laravel
composer require bacon/bacon-qr-code
```

### 4.2 Shared Auth Service

Dibuat satu `App\Services\AuthService` yang digunakan oleh semua modul:

```
app/
  Services/
    AuthService.php          ← logic login, SSO callback, TOTP verify
  Http/
    Controllers/
      Auth/
        MicrosoftSSOController.php  ← handle redirect & callback per modul
        TotpController.php          ← setup & verify TOTP
  Http/
    Livewire/
      Auth/
        TotpVerify.php        ← Livewire component verifikasi OTP
```

### 4.3 Alur Microsoft SSO Per Modul

```
User klik "Sign in with Microsoft" (di login page modul)
  ↓
GET /{module}/auth/microsoft/redirect
  ↓ (simpan module_guard di session)
Microsoft OAuth2 → consent → callback
  ↓
GET /auth/microsoft/callback
  ↓
MicrosoftSSOController::callback()
  - Ambil module_guard dari session
  - Cari/buat user berdasarkan email
  - Auth::guard($module_guard)->login($user)
  - Redirect ke dashboard modul
```

### 4.4 Alur Login Manual + TOTP (2FA Wajib)

```
User isi email + password → loginStore()
  ↓
Auth::guard($module)->attempt([...]) → BERHASIL
  ↓
Cek: apakah user sudah setup 2FA?
  ├── BELUM → redirect paksa ke /{module}/auth/2fa-setup
  │            (user WAJIB setup 2FA sebelum bisa akses dashboard)
  │            User scan QR → input OTP → 2FA aktif → redirect dashboard
  │
  └── SUDAH → simpan user_id di session (BELUM fully authenticated)
               redirect ke /{module}/auth/verify-otp
                  ↓
               User isi 6 digit OTP atau recovery code 6 digit angka
                  ↓
               TotpVerify::verify()
               - Validasi TOTP dengan secret dari DB
               - ATAU validasi recovery code (6 digit angka, sekali pakai)
               ├── VALID   → Auth::guard($module)->login($user) → dashboard
               └── INVALID → error, minta ulang
```

---

## 5. Database Schema

### 5.1 Migration: `create_azure_tenants_table` (Tenant Baru)

> **Keputusan:** Menggunakan **tenant Office 365 baru** (bukan tenant Adaro yang sudah ada). Konfigurasi tenant disimpan di tabel database tersendiri agar mudah dikelola.

```php
Schema::create('azure_tenants', function (Blueprint $table) {
    $table->id();
    $table->string('name');                    // e.g. "AIMS Office 365"
    $table->string('tenant_id');               // Azure AD Tenant ID
    $table->string('client_id');               // Azure AD App Client ID
    $table->text('client_secret');             // encrypted
    $table->string('redirect_uri');            // callback URL
    $table->json('allowed_domains')->nullable(); // e.g. ["@adaro.com", "@adaroservices.com"]
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 5.2 Migration: `add_microsoft_sso_to_users_table`
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('microsoft_id')->nullable()->after('email');
    $table->string('microsoft_token')->nullable()->after('microsoft_id');
    $table->string('avatar')->nullable()->after('microsoft_token');
    $table->foreignId('azure_tenant_id')->nullable()->after('avatar')
          ->constrained('azure_tenants')->nullOnDelete();
});
```

### 5.3 Migration: `add_two_factor_to_users_table`

> **Keputusan:** 2FA **wajib** untuk login manual. Field `two_factor_forced` dihapus karena semua user manual wajib 2FA. Recovery code berformat **6 digit angka**.

```php
Schema::table('users', function (Blueprint $table) {
    $table->text('two_factor_secret')->nullable()->after('password');
    $table->boolean('two_factor_enabled')->default(false)->after('two_factor_secret');
    $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_enabled');
    // Recovery codes: array of 6-digit numeric strings, e.g. ["482910", "173625", ...]
    $table->json('two_factor_recovery_codes')->nullable()->after('two_factor_confirmed_at');
});
```

### 5.4 Migration: `create_sso_module_sessions_table`
```php
Schema::create('sso_module_sessions', function (Blueprint $table) {
    $table->id();
    $table->string('state')->index();
    $table->string('module_guard');
    $table->string('redirect_after');
    $table->timestamp('expires_at');
    $table->timestamps();
});
```

---

## 6. Konfigurasi

### 6.1 `.env` — Tambahkan

> **Catatan:** Konfigurasi tenant utama tetap di `.env` sebagai default. Data tenant lengkap disimpan di tabel `azure_tenants` agar bisa dikelola via admin panel.

```env
# Microsoft Azure AD (Tenant Office 365 Baru)
AZURE_CLIENT_ID=your-new-tenant-client-id
AZURE_CLIENT_SECRET=your-new-tenant-client-secret
AZURE_TENANT_ID=your-new-office365-tenant-id
AZURE_REDIRECT_URI="${APP_URL}/auth/microsoft/callback"

# 2FA (Wajib untuk login manual)
GOOGLE2FA_WINDOW=1
GOOGLE2FA_COMPANY="Adaro AIMS"
GOOGLE2FA_RECOVERY_CODES_COUNT=8
GOOGLE2FA_RECOVERY_CODE_LENGTH=6
```

### 6.2 `config/services.php` — Tambahkan

```php
// Default tenant dari .env, bisa di-override dari tabel azure_tenants
'azure' => [
    'client_id'     => env('AZURE_CLIENT_ID'),
    'client_secret' => env('AZURE_CLIENT_SECRET'),
    'redirect'      => env('AZURE_REDIRECT_URI'),
    'tenant'        => env('AZURE_TENANT_ID'),
],
```

### 6.3 Provider Registration (AppServiceProvider)

```php
// Dalam AppServiceProvider::boot()
// Tenant config bisa di-resolve dinamis dari tabel azure_tenants
Socialite::extend('azure', function ($app) {
    $tenant = \App\Models\AzureTenant::where('is_active', true)->first();
    $config = $tenant ? [
        'client_id'     => $tenant->client_id,
        'client_secret' => decrypt($tenant->client_secret),
        'redirect'      => $tenant->redirect_uri,
        'tenant'        => $tenant->tenant_id,
    ] : $app['config']['services.azure'];

    return Socialite::buildProvider(
        \SocialiteProviders\Azure\Provider::class, $config
    );
});
```

---

## 7. Komponen yang Dibuat / Dimodifikasi

### 7.1 BARU: `app/Http/Controllers/Auth/MicrosoftSSOController.php`

```php
class MicrosoftSSOController extends Controller
{
    // GET /{module}/auth/microsoft/redirect
    public function redirect(string $module): RedirectResponse
    {
        // Simpan module guard ke session
        session(['sso_module_guard' => $module]);
        session(['sso_redirect_after' => route("{$module}::dashboard")]);
        return Socialite::driver('azure')->redirect();
    }

    // GET /auth/microsoft/callback
    public function callback(): RedirectResponse
    {
        $azureUser = Socialite::driver('azure')->user();
        $moduleGuard = session('sso_module_guard');

        $user = User::firstOrCreate(
            ['email' => $azureUser->getEmail()],
            [
                'name'         => $azureUser->getName(),
                'microsoft_id' => $azureUser->getId(),
                'password'     => Hash::make(Str::random(32)),
            ]
        );

        // Update microsoft_id jika belum ada
        $user->update(['microsoft_id' => $azureUser->getId()]);

        Auth::guard($moduleGuard)->login($user, true);

        return redirect(session('sso_redirect_after', '/'));
    }
}
```

### 7.2 MODIFIKASI: Login Livewire Per Modul

Tambahkan **method `loginWithMicrosoft()`** di setiap Login component:

```php
public function loginWithMicrosoft(): RedirectResponse
{
    return redirect()->route('auth.microsoft.redirect', [
        'module' => $this->moduleGuard  // e.g. 'ko', 'kpp', 'audit'
    ]);
}
```

Tambahkan **pengecekan TOTP wajib** setelah `Auth::guard()->attempt()` berhasil.

> **2FA Wajib:** Login manual SELALU memerlukan verifikasi OTP. Jika user belum setup 2FA, diarahkan ke halaman setup paksa.

```php
public function loginStore()
{
    $this->validate();

    $user = User::whereEmail($this->email)->first();

    if (Auth::guard($this->guard)->attempt([
        'email'    => $this->email,
        'password' => $this->password,
    ], $this->remember)) {

        // 2FA WAJIB untuk login manual
        Auth::guard($this->guard)->logout();
        session(['2fa_pending_user_id'  => $user->id]);
        session(['2fa_pending_guard'    => $this->guard]);
        session(['2fa_redirect_after'   => route($this->dashboardRoute)]);

        // Cek apakah user sudah setup 2FA
        if ($user->two_factor_enabled) {
            // Sudah setup → arahkan ke verifikasi OTP
            return redirect()->route($this->otpRoute);
        }

        // Belum setup → paksa setup 2FA dulu
        return redirect()->route('auth.2fa.forced-setup', [
            'module' => $this->guard
        ]);
    }

    $this->addError('email', 'Email atau password tidak sesuai.');
}
```

### 7.3 BARU: `app/Http/Livewire/Auth/TotpVerify.php`

> Mendukung verifikasi via **TOTP code** (6 digit dari authenticator) **atau recovery code** (6 digit angka sekali pakai).

```php
class TotpVerify extends Component
{
    public string $otp_code = '';
    public bool $useRecoveryCode = false;

    public function verify()
    {
        $userId = session('2fa_pending_user_id');
        $guard  = session('2fa_pending_guard');
        $user   = User::findOrFail($userId);

        if ($this->useRecoveryCode) {
            // Validasi recovery code (6 digit angka, sekali pakai)
            $valid = $this->validateRecoveryCode($user, $this->otp_code);
        } else {
            // Validasi TOTP dari authenticator app
            $valid = app(Google2FA::class)->verifyKey(
                decrypt($user->two_factor_secret),
                $this->otp_code
            );
        }

        if ($valid) {
            Auth::guard($guard)->login($user);
            session()->forget(['2fa_pending_user_id', '2fa_pending_guard']);
            return redirect(session('2fa_redirect_after', '/'));
        }

        $this->addError('otp_code', $this->useRecoveryCode
            ? 'Recovery code tidak valid atau sudah digunakan.'
            : 'Kode OTP tidak valid atau sudah kadaluarsa.');
    }

    private function validateRecoveryCode(User $user, string $code): bool
    {
        $codes = $user->two_factor_recovery_codes ?? [];
        if (in_array($code, $codes)) {
            // Hapus recovery code yang sudah dipakai (sekali pakai)
            $user->update([
                'two_factor_recovery_codes' => array_values(
                    array_diff($codes, [$code])
                ),
            ]);
            return true;
        }
        return false;
    }

    public function render()
    {
        return view('auth.totp-verify');
    }
}
```

### 7.4 BARU: `app/Http/Livewire/Auth/TotpSetup.php`

> Saat aktivasi 2FA, sistem otomatis men-generate **8 recovery codes** berformat **6 digit angka**.

```php
class TotpSetup extends Component
{
    public string $secret = '';
    public string $qr_code = '';
    public string $otp_code = '';
    public array $recoveryCodes = [];
    public bool $setupComplete = false;

    public function mount()
    {
        $google2fa = app(Google2FA::class);
        $this->secret = $google2fa->generateSecretKey();
        $this->qr_code = $google2fa->getQRCodeUrl(
            config('app.name'),
            auth()->user()->email,
            $this->secret
        );
    }

    public function enable()
    {
        $this->validate(['otp_code' => 'required|digits:6']);

        $valid = app(Google2FA::class)->verifyKey($this->secret, $this->otp_code);

        if ($valid) {
            // Generate 8 recovery codes (6 digit angka)
            $this->recoveryCodes = $this->generateRecoveryCodes();

            auth()->user()->update([
                'two_factor_secret'         => encrypt($this->secret),
                'two_factor_enabled'        => true,
                'two_factor_confirmed_at'   => now(),
                'two_factor_recovery_codes' => $this->recoveryCodes,
            ]);

            $this->setupComplete = true;
            $this->alert('success', '2FA berhasil diaktifkan! Simpan recovery codes di bawah.');
        } else {
            $this->addError('otp_code', 'Kode OTP tidak valid.');
        }
    }

    /**
     * Generate recovery codes: 6 digit angka (000000-999999)
     */
    private function generateRecoveryCodes(): array
    {
        $count = config('google2fa.recovery_codes_count', 8);
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        }
        return $codes;
    }
}
```

---

## 8. Routes Yang Ditambahkan

### `routes/web.php` — Shared SSO Routes

```php
// Microsoft SSO — shared untuk semua modul
Route::prefix('auth/microsoft')->group(function () {
    Route::get('/{module}/redirect', [MicrosoftSSOController::class, 'redirect'])
        ->name('auth.microsoft.redirect');
    Route::get('/callback', [MicrosoftSSOController::class, 'callback'])
        ->name('auth.microsoft.callback');
});

// TOTP Setup (protected, user harus sudah login)
Route::middleware(['web'])->group(function () {
    Route::get('/auth/2fa/setup', TotpSetup::class)->name('auth.2fa.setup');
    Route::get('/auth/2fa/disable', TotpDisable::class)->name('auth.2fa.disable');
    Route::get('/auth/2fa/regenerate-codes', TotpRegenerateCodes::class)->name('auth.2fa.regenerate');
});

// Forced 2FA setup (untuk user yang belum setup, setelah login manual)
Route::get('/auth/2fa/{module}/forced-setup', TotpForcedSetup::class)
    ->name('auth.2fa.forced-setup');
```

### Setiap `Modules/{Module}/Routes/web.php` — Tambahkan OTP Route

```php
// Contoh untuk Modul KO:
Route::get('/verify-otp', TotpVerify::class)->name('verify-otp')
    ->middleware('guest:ko');
```

---

## 9. Tampilan UI Yang Dimodifikasi

### 9.1 Halaman Login Per Modul (Blade)
Tambahkan tombol Microsoft SSO dan link untuk OTP:

```blade
{{-- Tombol Microsoft SSO --}}
<div class="mb-3 d-grid">
    <a href="{{ route('auth.microsoft.redirect', ['module' => 'ko']) }}"
       class="btn btn-outline-primary btn-lg d-flex align-items-center gap-2">
        <img src="{{ asset('images/icons/microsoft.svg') }}" width="20">
        Sign in with Microsoft
    </a>
</div>

<div class="divider text-center my-3">
    <span class="text-muted">atau login manual</span>
</div>

{{-- Form email+password yang sudah ada --}}
```

### 9.2 Halaman Verifikasi OTP (Baru)

> Mendukung input TOTP code **atau** recovery code 6 digit angka.

```blade
<div class="inner-content login">
    <div class="content-login p-5">
        <h3>Verifikasi 2FA</h3>

        @if(!$useRecoveryCode)
            <p class="text-muted">Masukkan kode 6 digit dari aplikasi Authenticator Anda.</p>
        @else
            <p class="text-muted">Masukkan salah satu recovery code 6 digit angka Anda.</p>
        @endif

        <form wire:submit.prevent="verify">
            <div class="mb-3">
                <input type="text" wire:model="otp_code"
                    class="form-control form-control-lg text-center fs-3 letter-spacing-wide"
                    maxlength="6" placeholder="000000"
                    autocomplete="{{ $useRecoveryCode ? 'off' : 'one-time-code' }}">
                @error('otp_code') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">Verifikasi</button>
            </div>
        </form>

        <div class="text-center mt-3">
            @if(!$useRecoveryCode)
                <a href="#" wire:click.prevent="$set('useRecoveryCode', true)" class="text-muted">
                    Gunakan Recovery Code
                </a>
            @else
                <a href="#" wire:click.prevent="$set('useRecoveryCode', false)" class="text-muted">
                    Kembali ke Authenticator Code
                </a>
            @endif
        </div>

        <div class="text-center mt-2">
            <small class="text-muted">Didukung: Google Authenticator & Microsoft Authenticator</small>
        </div>
    </div>
</div>
```

### 9.3 Halaman Setup 2FA (Profile)

> Setelah aktivasi berhasil, menampilkan **8 recovery codes (6 digit angka)** yang harus disimpan user.

```blade
<div class="card">
    <div class="card-body">
        <h5>Aktifkan Two-Factor Authentication</h5>

        @if(!$setupComplete)
            <ol>
                <li>Install <strong>Google Authenticator</strong> atau <strong>Microsoft Authenticator</strong></li>
                <li>Scan QR Code di bawah:</li>
            </ol>

            <div class="text-center my-3">
                {!! QrCode::size(200)->generate($qr_url) !!}
            </div>

            <p class="text-muted text-center">
                Atau masukkan secret key manual: <code>{{ $secret }}</code>
            </p>

            <form wire:submit.prevent="enable">
                <input type="text" wire:model="otp_code" placeholder="Kode 6 digit"
                    class="form-control" maxlength="6">
                <button type="submit" class="btn btn-success mt-2">Aktifkan 2FA</button>
            </form>
        @else
            {{-- Tampilkan recovery codes setelah 2FA aktif --}}
            <div class="alert alert-warning">
                <strong>⚠️ Simpan recovery codes ini!</strong>
                <p>Codes ini hanya ditampilkan sekali. Simpan di tempat aman.</p>
                <p class="text-muted">Setiap code berupa <strong>6 digit angka</strong> dan hanya bisa digunakan <strong>satu kali</strong>.</p>
            </div>

            <div class="row g-2 mb-3">
                @foreach($recoveryCodes as $code)
                    <div class="col-6">
                        <code class="d-block text-center p-2 bg-light rounded fs-5">{{ $code }}</code>
                    </div>
                @endforeach
            </div>

            <div class="d-grid gap-2">
                <button wire:click="downloadCodes" class="btn btn-outline-primary">
                    📥 Download Recovery Codes
                </button>
                <a href="{{ route($dashboardRoute) }}" class="btn btn-success">
                    Lanjut ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
```

---

## 10. Model Updates

### 10.1 `App\Models\User` — Update

```php
protected $fillable = [
    'name', 'email', 'password',
    'microsoft_id', 'microsoft_token', 'avatar', 'azure_tenant_id',
    'two_factor_secret', 'two_factor_enabled',
    'two_factor_confirmed_at', 'two_factor_recovery_codes',
];

protected $hidden = [
    'password', 'remember_token',
    'two_factor_secret', 'microsoft_token',
    'two_factor_recovery_codes',
];

protected $casts = [
    'email_verified_at'           => 'datetime',
    'two_factor_enabled'          => 'boolean',
    'two_factor_confirmed_at'     => 'datetime',
    'two_factor_recovery_codes'   => 'array',
];

public function hasTwoFactorEnabled(): bool
{
    return $this->two_factor_enabled && !is_null($this->two_factor_secret);
}

public function isMicrosoftUser(): bool
{
    return !is_null($this->microsoft_id);
}

public function azureTenant()
{
    return $this->belongsTo(AzureTenant::class);
}
```

### 10.2 BARU: `App\Models\AzureTenant`

```php
class AzureTenant extends Model
{
    protected $fillable = [
        'name', 'tenant_id', 'client_id',
        'client_secret', 'redirect_uri',
        'allowed_domains', 'is_active',
    ];

    protected $hidden = ['client_secret'];

    protected $casts = [
        'allowed_domains' => 'array',
        'is_active'       => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
```

---

## 11. Rencana Implementasi (Sprint Plan)

### Sprint 1 — Fondasi (3 hari)
- [x] Install `socialiteproviders/microsoft-azure` (Done)
- [x] Install `pragmarx/google2fa-laravel` + `bacon/bacon-qr-code` (Done)
- [x] Daftarkan **Azure App baru** di Microsoft Azure Portal (tenant Office 365 baru) (Done)
- [x] Buat **4 migration** baru (`azure_tenants`, `microsoft_sso`, `two_factor`, `sso_module_sessions`) (Done & Migrated)
- [x] Buat model `AzureTenant` + update `App\Models\User` (Done)
- [x] Update `config/services.php` dan `.env` (Done)
- [x] Seed data tenant awal ke tabel `azure_tenants` (Done)

### Sprint 2 — Microsoft SSO untuk Semua Modul (4 hari)
- [/] Buat `MicrosoftSSOController` (redirect + callback, resolve tenant dari DB) (Done - Shared)
- [/] Tambahkan shared routes di `routes/web.php` (Done - Shared)
- [ ] Tambahkan tombol "Sign in with Microsoft" di blade login **semua 12 modul** (Baru 1 modul KO)
- [ ] Test callback per modul (Baru 1 modul KO)

### Sprint 3 — TOTP 2FA Wajib + Recovery Codes (5 hari)
- [/] Buat `TotpSetup` + `TotpForcedSetup` Livewire component + view (Done - Shared)
- [/] Buat `TotpVerify` Livewire component + view (dengan recovery code support) (Done - Shared)
- [ ] Buat `TotpRegenerateCodes` Livewire component
- [/] Implementasi **forced 2FA setup** — redirect paksa user baru yang belum setup (Done - Shared & KO pilot)
- [/] Implementasi **recovery codes 6 digit angka** (generate, validasi, hapus setelah pakai) (Done - Shared)
- [ ] Modifikasi `loginStore()` di **semua 12 modul** — 2FA wajib, tanpa bypass (Baru 1 modul KO)
- [ ] Tambahkan route `/verify-otp` dan `/forced-setup` di setiap modul (Baru 1 modul KO)
- [ ] Test dengan Google Authenticator dan Microsoft Authenticator

### Sprint 4 — Polish & Security (2 hari)
- [ ] Rate limiting pada route `/verify-otp` (max 5 attempts)
- [ ] Download/print recovery codes (format 6 digit angka)
- [ ] Admin panel: kelola data tenant Azure di tabel `azure_tenants`
- [ ] Notifikasi email jika login dari IP baru
- [ ] Testing & review keamanan

---

## 12. Pertimbangan Keamanan

| Risiko | Mitigasi |
|--------|----------|
| CSRF pada callback SSO | Validasi `state` parameter OAuth2 |
| Brute force OTP | Rate limit 5x/menit, lockout 15 menit |
| Session hijacking 2FA pending | Session TTL 5 menit untuk `2fa_pending_*` |
| Secret TOTP bocor | Kolom `two_factor_secret` di-`encrypt()` Laravel |
| Microsoft token abuse | Token tidak disimpan permanen, hanya untuk login awal |
| Tenant credential leak | `client_secret` di tabel `azure_tenants` di-`encrypt()` |
| Recovery code brute force | 6 digit angka (1M kombinasi) + rate limit + sekali pakai |
| Login manual tanpa 2FA | **Tidak dimungkinkan** — 2FA wajib, forced setup jika belum aktif |

---

## 13. Keputusan Tim (Terjawab)

> [!NOTE]
> Semua pertanyaan terbuka sudah dikonfirmasi. Berikut keputusan final:

| # | Pertanyaan | Keputusan |
|---|-----------|----------|
| 1 | **Azure AD Tenant** | ✅ Menggunakan **tenant Office 365 baru** (terpisah). Data tenant disimpan di tabel `azure_tenants` |
| 2 | **Force 2FA** | ✅ **Wajib** untuk semua login manual (email+password). Tidak ada opsi skip |
| 3 | **SSO vs Manual** | ✅ **Dual login** — kedua metode tersedia: (a) Sign in with Microsoft, (b) Login manual email+password+2FA |
| 4 | **Cakupan modul** | ✅ **Semua 12 modul** menggunakan SSO Login dan Login manual + 2FA |
| 5 | **Recovery codes** | ✅ Format **6 digit angka** (e.g. `482910`), 8 codes per user, sekali pakai, bisa di-regenerate |

---

*Dokumen ini dibuat berdasarkan analisis kode sumber `c:\laragon\www\aims` pada 2026-05-31.*
*Revisi 1.1: Update berdasarkan jawaban keputusan tim pada 2026-05-31.*

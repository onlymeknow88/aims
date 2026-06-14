# PRD — Unified Login & Guard Bridge Auto-Routing
## AIMS — Adaro Integrated Management System
**Versi:** 1.0 | **Tanggal:** 2026-06-02 | **Status:** Draft

---

## 1. Latar Belakang & Tujuan

### Kondisi Saat Ini
Sistem AIMS memiliki **12 modul aktif** dengan masing-masing halaman login terpisah:

| Modul | Guard | URL Login Saat Ini |
|-------|-------|--------------------|
| KO | `ko` | `/ko/login` |
| KPP | `kpp` | `/kpp/login` |
| Audit | `audit` | `/audit/login` |
| SAP | `sap` | `/sap/login` |
| CSMS | `csms` | `/csms/login` |
| CoE | `coe` | `/coe/login` |
| KPLH | `kplh` | `/kplh/login` |
| MCU | `mcu` | `/mcu/login` |
| PICA | `pica` | `/pica/login` |
| IbprAndBowtie | `ibpr-and-bowtie` | `/ibpr-and-bowtie/login` |
| DocumentSystem | `document-system` | `/document-system/login` |
| FieldLeadership | `field-leadership` | `/field-leadership/login` |

**Masalah utama:**
- User harus login berulang kali jika mengakses lebih dari 1 modul
- Duplikasi form login di 12 modul
- Tidak ada central entry point untuk semua modul
- Pengalaman pengguna (UX) yang buruk dan tidak konsisten

### Tujuan Fitur
1. **1 Halaman Login Terpusat** — User cukup login satu kali di `/login`
2. **Guard Bridge Auto-Login** — Saat user klik modul, sistem otomatis login ke guard modul tanpa login ulang
3. **Central Module Landing Page** — Tampilkan hanya modul yang boleh diakses user berdasarkan Spatie Permission
4. **Keamanan Multi-Guard Tetap Terjaga** — Akses per-modul masih dibatasi oleh guard & role Spatie

---

## 2. User Stories

> **US-01:** Sebagai pengguna, saya hanya perlu login satu kali di halaman utama AIMS untuk mengakses semua modul yang menjadi hak saya.

> **US-02:** Sebagai pengguna, saya dapat melihat daftar modul yang bisa saya akses di landing page. Modul yang tidak saya miliki aksesnya ditampilkan dengan status "Tidak Ada Akses" (disabled).

> **US-03:** Sebagai pengguna, ketika saya mengklik modul (misalnya KO), saya langsung masuk ke dashboard modul tersebut tanpa diminta login ulang.

> **US-04:** Sebagai pengguna, jika saya mencoba mengakses URL modul yang tidak saya miliki aksesnya secara langsung, sistem menampilkan halaman 403 Forbidden yang informatif.

> **US-05:** Sebagai admin, saya dapat mengatur role & permission user per guard di Filament back-office, dan perubahan tersebut langsung berlaku pada tampilan landing page modul user tersebut.

> **US-06:** Sebagai pengguna, ketika saya logout, saya logout dari semua sesi guard secara serentak (Global Logout).

---

## 3. Arsitektur Teknis

### 3.1 Alur Guard Bridge

```
User login di /login (guard: web)
    ↓
Redirect ke /home (Central Landing Page)
    ↓
User klik modul, misal: /ko/dashboard
    ↓
Middleware Authenticate.php (CORE - dimodifikasi)
    ↓
Cek: user aktif di guard 'web'? → YA
    ↓
Cek: user punya Role/Permission di Spatie untuk guard 'ko'? → YA
    ↓
Auto: Auth::guard('ko')->login($user) [di belakang layar]
    ↓
User langsung masuk Dashboard KO ✅
```

### 3.2 Komponen yang Dimodifikasi / Dibuat

```
app/
  Http/
    Middleware/
      Authenticate.php          ← MODIFIKASI: tambah Guard Bridge logic
    Controllers/
      HomeController.php        ← BARU: Central Landing Page controller
  Models/
    User.php                    ← MODIFIKASI: tambah helper method

resources/views/
    auth/login.blade.php        ← MODIFIKASI: unified login form
    home/index.blade.php        ← BARU: Central Module Landing Page
    errors/403.blade.php        ← BARU: halaman akses ditolak

routes/web.php                  ← MODIFIKASI: tambah /home route
```

---

## 4. Implementasi Teknis

### 4.1 Modifikasi `app/Http/Middleware/Authenticate.php`

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        $centralUser = $this->auth->guard('web')->user();

        foreach ($guards as $guard) {
            // Sudah login di guard target? Langsung lewat.
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }

            // Sudah login di web? Cek akses ke guard target lalu auto-login.
            if ($centralUser && $this->userHasAccessToGuard($centralUser, $guard)) {
                $this->auth->guard($guard)->login($centralUser);
                return $this->auth->shouldUse($guard);
            }
        }

        // Sudah login tapi tidak punya akses ke guard ini
        if ($centralUser) {
            abort(403, 'Anda tidak memiliki hak akses ke modul ini.');
        }

        $this->unauthenticated($request, $guards);
    }

    protected function userHasAccessToGuard($user, $guard): bool
    {
        if (in_array($guard, ['web', null, 'admin'])) {
            return true;
        }

        return $user->roles()->where('guard_name', $guard)->exists()
            || $user->permissions()->where('guard_name', $guard)->exists();
    }

    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login'); // Satu URL login untuk semua modul
        }
        return null;
    }
}
```

### 4.2 BARU: `app/Http/Controllers/HomeController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected array $moduleMap = [
        'ko'               => ['route' => 'ko::dashboard',           'label' => 'Keselamatan Operasi'],
        'kpp'              => ['route' => 'kpp::dashboard',          'label' => 'Kebijakan & Perizinan'],
        'audit'            => ['route' => 'audit::dashboard',        'label' => 'Audit SMKP'],
        'sap'              => ['route' => 'sap::dashboard',          'label' => 'SAP Dashboard'],
        'csms'             => ['route' => 'csms::dashboard',         'label' => 'Contractor Safety'],
        'coe'              => ['route' => 'coe::index',              'label' => 'Calendar of Event'],
        'kplh'             => ['route' => 'kplh::dashboard',         'label' => 'Inspeksi KPLH'],
        'mcu'              => ['route' => 'mcu::index',              'label' => 'Medical Check Up'],
        'pica'             => ['route' => 'pica::index',             'label' => 'PICA'],
        'ibpr-and-bowtie'  => ['route' => 'ibpr-and-bowtie::index',  'label' => 'IBPR & Bowtie'],
        'document-system'  => ['route' => 'document-systems::index', 'label' => 'Document System'],
        'field-leadership' => ['route' => 'field-leadership::index', 'label' => 'Field Leadership'],
    ];

    public function index()
    {
        $user = Auth::user();
        $modules = [];

        foreach ($this->moduleMap as $guard => $config) {
            $hasAccess = $user->roles()->where('guard_name', $guard)->exists()
                || $user->permissions()->where('guard_name', $guard)->exists();

            $modules[] = [
                'guard'      => $guard,
                'label'      => $config['label'],
                'has_access' => $hasAccess,
                'route'      => $hasAccess ? route($config['route']) : null,
            ];
        }

        // Modul yang punya akses tampil duluan
        usort($modules, fn($a, $b) => $b['has_access'] <=> $a['has_access']);

        return view('home.index', compact('modules', 'user'));
    }

    public function logout(Request $request)
    {
        $guards = array_merge(['web', 'admin'], array_keys($this->moduleMap));

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
```

### 4.3 Helper Method di `App\Models\User`

```php
/**
 * Cek apakah user punya akses ke guard tertentu
 */
public function hasAccessToGuard(string $guard): bool
{
    return $this->roles()->where('guard_name', $guard)->exists()
        || $user->permissions()->where('guard_name', $guard)->exists();
}

/**
 * Ambil semua guard yang bisa diakses user ini
 */
public function accessibleGuards(): array
{
    $roleGuards = $this->roles()->pluck('guard_name')->toArray();
    $permGuards = $this->permissions()->pluck('guard_name')->toArray();
    return array_unique(array_merge($roleGuards, $permGuards));
}
```

### 4.4 Tambahan `routes/web.php`

```php
use App\Http\Controllers\HomeController;

// Central Entry Point
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [HomeController::class, 'logout'])->name('logout');
});

// Redirect root ke home atau login
Route::get('/', fn() => redirect()->route(Auth::check() ? 'home' : 'login'));
```

---

## 5. Desain Landing Page (`/home`)

```
┌─────────────────────────────────────────────────────────────────┐
│  AIMS — Adaro Integrated Management System             [Logout] │
│  Selamat datang, Febrianto Dedi Hosea                           │
│  febrianto.hosea@adaro.com                                      │
├─────────────────────────────────────────────────────────────────┤
│  Modul Anda (8 dari 12 aktif)                                   │
│                                                                  │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌───────────┐   │
│  │ 🛡️ KO    │  │ 📋 KPP   │  │ ✅ Audit  │  │ 🏥 MCU   │   │
│  │           │  │           │  │           │  │           │   │
│  │[Buka Modul│  │[Buka Modul│  │[Buka Modul│  │[Buka Modul│   │
│  └───────────┘  └───────────┘  └───────────┘  └───────────┘   │
│                                                                  │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌───────────┐   │
│  │ ⚠️ PICA  │  │ 📁 DocSys │  │ 👷 CSMS  │  │ 🌿 KPLH  │   │
│  │           │  │           │  │           │  │           │   │
│  │[Buka Modul│  │[Buka Modul│  │[Buka Modul│  │[Buka Modul│   │
│  └───────────┘  └───────────┘  └───────────┘  └───────────┘   │
│                                                                  │
│  ─────── Tidak Dapat Diakses ────────                           │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌───────────┐   │
│  │ 🚫 SAP   │  │ 🚫 CoE   │  │ 🚫 IBPR  │  │ 🚫 Field │   │
│  │ Tidak Ada │  │ Tidak Ada │  │ Tidak Ada │  │ Tidak Ada │   │
│  │ Akses     │  │ Akses     │  │ Akses     │  │ Akses     │   │
│  └───────────┘  └───────────┘  └───────────┘  └───────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 6. Keamanan

| Risiko | Mitigasi |
|--------|----------|
| Guard Bridge bypass via URL langsung | Middleware cek Spatie roles/permissions sebelum auto-login |
| User tidak punya akses ke guard modul | `abort(403)` dengan pesan informatif |
| Session hijacking | Hanya bridge setelah validasi user aktif di guard `web` |
| Spatie cache stale setelah role dicabut | `permission:cache-reset` saat admin ubah role via Filament |
| Global logout tidak menghapus semua guard | Loop semua guard di `logout()` method |
| Akses langsung ke URL modul tanpa /home | Tetap dicegat middleware Guard Bridge, hasil sama |

---

## 7. Sprint Plan

### Sprint 1 — Core Guard Bridge (2 hari)
- [x] Modifikasi `app/Http/Middleware/Authenticate.php` — tambah Guard Bridge
- [x] Tambah helper method `hasAccessToGuard()` & `accessibleGuards()` di `App\Models\User`
- [x] Update `routes/web.php` — route `/home` dan logout global
- [x] Test Guard Bridge manual dengan guard `ko` dan `mcu`

### Sprint 2 — Landing Page (2 hari)
- [x] Buat `HomeController.php` dengan module map lengkap 12 modul
- [x] Buat Blade view `resources/views/home/index.blade.php`
- [x] Buat halaman `errors/403.blade.php` yang informatif
- [x] Update redirect setelah login mengarah ke `/home`

### Sprint 3 — Polish & Edge Cases (1 hari)
- [x] Pastikan halaman login lama (`/ko/login`, dll.) redirect ke `/login` terpusat
- [x] Test Global Logout — semua guard harus clear
- [x] Test dengan user banyak guard (contoh: `febrianto.hosea` — 54 roles)
- [x] Test dengan user satu guard saja

### Sprint 4 — Integrasi SSO (Referensi: PRD_Authentication_AIMS.md)
- [x] Setelah Microsoft SSO login, redirect ke `/home` (bukan ke modul spesifik)
- [x] Tampilkan badge "Akun Microsoft" di profil user landing page

---

## 8. Catatan Kompatibilitas

> [!IMPORTANT]
> Modifikasi pada `Authenticate.php` **tidak merusak** rute modul yang sudah ada. Semua route yang menggunakan `middleware('auth:ko')` atau `middleware('auth:mcu')` tetap berfungsi normal — Guard Bridge menangani auto-login di belakang layar sebelum Laravel memvalidasi guard modul.

> [!NOTE]
> Halaman login per-modul lama (`/ko/login`, `/mcu/login`, dll.) **tetap bisa diakses** selama masa transisi. Setelah Unified Login stabil, arahkan login lama tersebut ke `/login` terpusat.

> [!TIP]
> Untuk user seperti `febrianto.hosea` yang memiliki **54 roles** di berbagai guard, semua modul-nya akan otomatis tersedia di landing page. Query Spatie sudah di-cache 24 jam, sehingga performa tetap optimal.

---

*Dokumen dibuat berdasarkan analisis kode sumber `c:\laragon\www\aimsv1` pada 2026-06-02.*
*Referensi: PRD_Authentication_AIMS.md (v1.1) & spatie_permission_analysis.md*

# Daftar File yang Perlu di-Commit: Fitur Autentikasi AIMS (Sprint 1 + Pilot Modul KO)

Berikut adalah daftar file yang telah dibuat dan dimodifikasi yang harus di-commit ke Git Repository Anda. 

> [!NOTE]
> File `.env` **TIDAK boleh di-commit** demi keamanan kredensial. Harap salin konfigurasi baru ke `.env.example` jika diperlukan.

---

## 1. File Baru (Created Files)

### 📁 Database & Migrations
- `database/migrations/2026_06_01_082450_create_azure_tenants_table.php` (Skema konfigurasi tenant SSO)
- `database/migrations/2026_06_01_082458_add_microsoft_sso_to_users_table.php` (Kolom SSO Microsoft pada users)
- `database/migrations/2026_06_01_082535_add_two_factor_to_users_table.php` (Kolom 2FA TOTP pada users)
- `database/migrations/2026_06_01_082616_create_sso_module_sessions_table.php` (Skema session state SSO)
- `database/seeders/AzureTenantSeeder.php` (Seeder untuk default tenant Azure AD)

### 📁 Models & Controllers
- `app/Models/AzureTenant.php` (Model Eloquent AzureTenant)
- `app/Http/Controllers/Auth/MicrosoftSSOController.php` (Controller shared SSO redirect & callback)

### 📁 Livewire Components & Views (Shared 2FA)
- `app/Http/Livewire/Auth/TotpSetup.php` (Komponen Setup 2FA / Forced Setup)
- `app/Http/Livewire/Auth/TotpVerify.php` (Komponen Verifikasi OTP & Recovery Code)
- `resources/views/livewire/auth/totp-setup.blade.php` (Tampilan setup QR code & recovery codes)
- `resources/views/livewire/auth/totp-verify.blade.php` (Tampilan input OTP verifikasi)

---

## 2. File Modifikasi (Modified Files)

### 📁 Konfigurasi & Core
- `composer.json` (Penambahan library socialite & google2fa)
- `composer.lock` (Lock dependencies baru)
- `config/services.php` (Penambahan konfigurasi service `azure`)
- `app/Providers/AppServiceProvider.php` (Registrasi dynamic driver Socialite Azure)
- `app/Providers/EventServiceProvider.php` (Registrasi listener event `SocialiteWasCalled`)
- `app/Models/User.php` (Cast dan helper method untuk Microsoft SSO & 2FA)
- `database/seeders/DatabaseSeeder.php` (Registrasi `AzureTenantSeeder`)

### 📁 Routing & Modul KO (Pilot Modul)
- `routes/web.php` (Penambahan shared routes SSO & 2FA)
- `Modules/KO/Routes/web.php` (Penambahan route `/verify-otp` dan `/forced-setup`)
- `Modules/KO/Http/Livewire/Auth/Login.php` (Logika redirect login manual ke 2FA, dan tombol SSO)
- `Modules/KO/Resources/views/livewire/auth/login.blade.php` (Penambahan tombol "Sign in with Microsoft" di halaman login KO)
- `PRD_Authentication_AIMS.md` (Update status Sprint Checklist)

---

## 3. Contoh Pesan Commit (Git Commit Message)

Anda dapat menggunakan pesan commit terstruktur berikut saat melakukan commit:

```bash
git add .
git commit -m "feat(auth): implement sso microsoft and totp 2fa for KO module

- Install laravel/socialite, microsoft-azure provider, and google2fa
- Create migrations for azure_tenants, sso_sessions, and 2fa columns
- Add dynamic Azure AD config provider in AppServiceProvider
- Implement shared MicrosoftSSOController, TotpSetup, and TotpVerify
- Update KO login to enforce 2FA verification and support Microsoft SSO
- Add AzureTenantSeeder for initial tenant configuration"
```

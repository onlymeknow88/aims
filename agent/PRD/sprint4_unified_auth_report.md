# Unified Authentication & Consolidated Session Management Report (Sprint 4)

Laporan ini merinci seluruh perubahan arsitektur autentikasi terpusat (Single Sign-On / SSO) dan konsolidasi sesi keluar (Single Logout) yang diimplementasikan pada AIMS platform.

---

## 🛠️ 1. Backend & Logic Changes (Controllers, Middlewares, Models, Routes)

### 📂 Controllers
*   **`app/Http/Controllers/Auth/MicrosoftSSOController.php`**
    *   *Peran*: Menangani alur masuk (login) terpusat menggunakan akun Microsoft Azure AD (SSO).
    *   *Detail Perubahan*: Menyediakan callback redirect SSO global, mendeteksi email pengguna, membuat sesi masuk utama di guard `web`, dan mengotomatisasi inisialisasi session guard modul jika pengguna memiliki akses ke modul tersebut.
*   **`app/Http/Controllers/Auth/AuthController.php`**
    *   *Peran*: Controller autentikasi lokal terpusat dan penanganan keluar (logout) global.
    *   *Detail Perubahan*:
        *   Menambahkan/mengupdate fungsi `logout()` melakukan **Single Logout** dengan cara melakukan iterasi keluar (`logout()`) pada seluruh guard (`web`, `admin`, `dashboard`, serta seluruh guard modul seperti `coe`, `mcu`, `ko`, `kpp`, dll.), lalu membersihkan data session Laravel secara total.
        *   Menghapus controller `app/Http/Controllers/HomeController.php` dan folder `resources/views/home` karena sudah tidak terpakai (halaman `/home` tidak lagi digunakan, meluncur langsung ke halaman `/` utama).

### 📂 Middlewares
*   **`app/Http/Middleware/Authenticate.php`**
    *   *Peran*: Otentikasi & Guard Bridging otomatis.
    *   *Detail Perubahan*: Memodifikasi fungsi `authenticate` agar ketika pengguna yang sudah login di central (`web` atau `dashboard`) mencoba mengakses halaman modul yang dilindungi middleware `auth:guard_name`, sistem akan otomatis melakukan login (`$this->auth->guard($guard)->login($centralUser)`) tanpa memaksa user login ulang.
*   **`app/Http/Middleware/RedirectIfAuthenticated.php`**
    *   *Peran*: Pengalihan halaman login jika pengguna sudah terautentikasi.
    *   *Detail Perubahan*: Mengalihkan pengguna ke halaman dashboard sentral (`/home` atau `/`) apabila mereka mencoba mengakses route login sementara mereka sudah memiliki sesi aktif.

### 📂 Models
*   **`app/Models/User.php`**
    *   *Peran*: Entitas pengguna dengan pembagian role/permission Spatie.
    *   *Detail Perubahan*: Menambahkan fungsi helper `hasAccessToGuard(string $guard)` dan `accessibleGuards()` untuk melakukan pencocokan dinamik guard name berdasarkan role/permission yang terdaftar di database.

### 📂 Livewire Components
*   **`app/Http/Livewire/MainDashboard/Auth/Login.php`**
    *   *Peran*: Controller/Logic Form login terpusat.
    *   *Detail Perubahan*: Mengatur alur login pengguna menggunakan email & password lokal, mengautentikasi ke guard `dashboard`, yang nantinya secara otomatis di-bridge ke guard modul tujuan ketika diakses.
*   **`resources/views/livewire/main-dashboard/auth/login.blade.php`**
    *   *Peran*: Halaman interface (View) login tunggal.
    *   *Detail Perubahan*: Menyediakan tampilan form login terpadu dengan desain premium (Inter & Outfit fonts, glowing elements) dan tombol login alternatif menggunakan Akun Microsoft (Single Sign-On).

### 📂 Routes
*   **`routes/web.php`**
    *   *Peran*: Konfigurasi routing utama.
    *   *Detail Perubahan*: Mendaftarkan route login terpusat, route Microsoft SSO callback, serta route logout global yang memanggil `AuthController@logout`.

---

## 🎨 2. Frontend & Views Changes (Sidebars & Headers)

### 📂 Sidebars (Pembersihan Tombol Logout & Filtering Akses)
*   **Pembersihan Tombol Logout**: Menghapus formulir dan tombol logout individu agar pengguna tidak dapat keluar secara parsial dari sub-modul:
    *   `resources/views/layouts/sidebar/sidebar-dashboard.blade.php`
    *   `resources/views/layouts/sidebar/document-sidebar.blade.php`
    *   `resources/views/layouts/sidebar/mcu-sidebar.blade.php`
    *   `resources/views/layouts/sidebar/admin-sidebar.blade.php`
    *   `resources/views/layouts/main-dashboard/admin/sidebar/admin-sidebar.blade.php`
*   **Filtering Akses Guard Dinamis**: Memodifikasi sidebar navigasi utama (`dashboard-sidebar.blade.php`, `sidebar-left.blade.php`, dan `dashboard-slidebar.blade.php`) sehingga hanya menampilkan modul/guard yang diberikan akses untuk pengguna yang sedang login (menggunakan `$user->hasAccessToGuard($guard)`). Modul yang tidak memiliki akses akan langsung disembunyikan sepenuhnya dari navigasi (tidak lagi dirender dengan ikon gembok/locked atau link mati).

### 📂 Headers (Navigasi ke Home & Tampilan Profil Statis)
*   Mengubah link logo AIMS di header agar mengarah kembali ke portal utama.
*   Menghapus menu dropdown "Logout/Pengaturan" pada profil di pojok kanan atas, sehingga hanya menampilkan nama lengkap dan inisial avatar pengguna secara statis untuk menghindari kebingungan.
*   **File yang dimodifikasi**:
    *   `Modules/DocumentSystem/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/Sap/Resources/views/layouts/header/admin-header.blade.php`
    *   `Modules/Mcu/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/Pica/Resources/views/layouts/header/header.blade.php`
    *   `Modules/KO/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/Kplh/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/KPP/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/IbprAndBowtie/Resources/views/layouts/header/ibpr-and-bowtie.blade.php`
    *   `Modules/IbprAndBowtie/Resources/views/layouts/header/admin-header.blade.php`
    *   `Modules/Coe/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/CSMS/Resources/views/layouts/header/header.blade.php`
    *   `Modules/FieldLeadership/Resources/views/layouts/partials/header.blade.php`
    *   `Modules/Audit/Resources/views/livewire/layouts/header.blade.php`
    *   `resources/views/layouts/main-dashboard/admin/header/admin-header.blade.php`
    *   `resources/views/layouts/header/admin-header.blade.php`
    *   `resources/views/layouts/main-dashboard/dashboard-header.blade.php`

### 📂 Landing Page & Modul COE
*   `resources/views/livewire/main-dashboard/public/index.blade.php`
    *   *Peran*: Tampilan halaman utama `http://aimsv1.test`.
    *   *Detail*: Menggunakan pengecekan ganda (`Auth::guard('web')->check() || Auth::guard('dashboard')->check()`) untuk mengganti tombol "Login" menjadi "Logout" jika user sudah masuk.
*   `resources/views/livewire/main-dashboard/public/sidebar/sidebar-left.blade.php`
    *   *Detail*: Membersihkan item-item link login/dashboard yang sudah tidak relevan dari sidebar kiri publik.
*   `Modules/Coe/Resources/views/livewire/home.blade.php` & `Modules/Coe/Routes/web.php`
    *   *Detail*: Mengalihkan alur login/logout lokal COE agar menggunakan alur login terpusat, serta menampilkan shortcut dashboard dan nama/avatar pengguna jika sudah terautentikasi.

---

## 🐛 3. Bug Fix — Permission Document System Tidak Berfungsi (`@can` Guard Mismatch)

**Tanggal Perbaikan:** 2026-06-12

### Root Cause

Spatie Permission memeriksa `@can('...')` / `Gate::check()` menggunakan **guard default** (`web`), bukan guard modul yang sedang aktif. Sementara itu, seluruh permission DocumentSystem di-seed dengan `guard_name = 'document-system'`.

| Aspek | Nilai |
|---|---|
| Guard permission di-seed | `document-system` |
| Guard yang dicek `@can()` | `web` (default) |
| Akibat | Semua `@can('Document System - ...')` selalu **false** → menu sidebar, tombol create/delete, dll tidak muncul |

### File yang Diperbaiki

#### `app/Providers/AuthServiceProvider.php`
*   **Perubahan**: Menambahkan `Gate::before()` yang mengintercepting setiap pengecekan `@can` / `Gate::check()`.
*   **Logika Fix**: Sebelum Gate menjalankan pengecekan normal (via guard `web`), callback `Gate::before()` melakukan iterasi pada seluruh guard modul yang terdaftar. Jika user aktif di salah satu guard tersebut **dan** memiliki permission yang dimaksud, langsung return `true`.
*   **Guard yang di-cover**: `document-system`, `kpp`, `audit`, `ko`, `mcu`, `coe`, `csms`, `kplh`, `field-leadership`, `pica`, `ibpr-and-bowtie`, `sap`.

```php
// app/Providers/AuthServiceProvider.php
Gate::before(function ($user, string $ability) {
    foreach ($this->multiGuards as $guard) {
        $guardUser = Auth::guard($guard)->user();
        if ($guardUser && method_exists($guardUser, 'hasPermissionTo')) {
            try {
                if ($guardUser->hasPermissionTo($ability, $guard)) {
                    return true; // ✅ permission ditemukan → akses diberikan
                }
            } catch (\Throwable) {
                // Permission tidak terdaftar untuk guard ini – lewati
            }
        }
    }
    return null; // lanjut ke pengecekan Gate normal
});
```

### Dampak Perbaikan

*   `@can('Document System - View Active Document')` → ✅ bekerja
*   `@can('Document System - Master Data')` → ✅ bekerja
*   Seluruh direktif `@can` di sidebar, tabel, dan tombol aksi DocumentSystem kini berfungsi sesuai permission yang telah di-assign ke user.
*   Fix ini juga sekaligus meng-cover modul lain (`kpp`, `audit`, dll.) yang berpotensi mengalami masalah yang sama.

### Permission yang Terdampak (dari `DocumentPermissionSeederTableSeeder.php`)

| Permission Name | Guard |
|---|---|
| Document System - View Active Document | document-system |
| Document System - View OnGoing Document | document-system |
| Document System - View Obsolate Document | document-system |
| Document System - View Draft Document | document-system |
| Document System - Export Document | document-system |
| Document System - Create Document | document-system |
| Document System - Edit Document | document-system |
| Document System - Delete Document | document-system |
| Document System - View Active JSA | document-system |
| Document System - View Obsolate JSA | document-system |
| Document System - View Draft JSA | document-system |
| Document System - Create JSA / Edit JSA / Delete JSA | document-system |
| Document System - View Active PTW | document-system |
| Document System - Create PTW / Delete PTW | document-system |
| Document System - Master Data | document-system |
| Document System - Approve Document Level 1 & 2 | document-system |

---

## 🐛 4. Bug Fix — Pemisahan (Isolasi) Sesi & Logout (Main-Dashboard vs Filament Back-Office)

**Tanggal Perbaikan:** 2026-06-12

### Root Cause

Sebelumnya, sistem memperlakukan seluruh sesi secara global terikat (Single Logout total). Akibatnya:
1. Ketika pengguna logout dari **Main-Dashboard**, sesi **Filament Back-Office** (`admin` guard) ikut terputus.
2. Ketika admin logout dari **Filament Back-Office**, sesi **Main-Dashboard** (`dashboard` & module guards) ikut terputus.

Hal ini terjadi karena kedua aksi logout tersebut memanggil `$request->session()->invalidate()`, yang menghancurkan seluruh data sesi PHP di server, serta melakukan logout secara membabi buta pada seluruh guard secara bersamaan.

### Langkah Perbaikan

Untuk memisahkan (mengisolasi) sesi logout agar masing-masing guard mandiri:

#### 1. Modifikasi `AuthController@logout` (Dashboard Logout)
*   **File yang diperbaiki**: `app/Http/Controllers/Auth/AuthController.php`
*   **Perubahan**: 
    *   Mengeluarkan guard `'admin'` dari daftar guard yang diproses logout.
    *   Menghapus pemanggilan `$request->session()->invalidate()`.
    *   Hanya memanggil `Auth::guard($guard)->logout()` untuk guard dashboard dan modul frontend, diikuti dengan regenerasi token CSRF (`$request->session()->regenerateToken()`).
    *   Dengan demikian, sesi `admin` (Filament) yang tersimpan di dalam cookie/session PHP yang sama tetap dibiarkan aktif.

#### 2. Override Route Logout Filament
*   **File yang diperbaiki**: `routes/web.php`
*   **Perubahan**: Menambahkan route override khusus untuk `filament.auth.logout` yang menimpa route bawaan vendor Filament:
```php
Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->name('filament.')
    ->group(function () {
        Route::prefix(config('filament.core_path'))->group(function () {
            Route::post('/logout', function (\Illuminate\Http\Request $request) {
                // Hanya log out guard admin
                Auth::guard('admin')->logout();
                $request->session()->regenerateToken();
                return app(\Filament\Http\Responses\Auth\Contracts\LogoutResponse::class);
            })->name('auth.logout');
        });
    });
```
*   **Hasil**: Proses logout dari Filament sekarang hanya memutus guard `admin` dan meregenerasi token CSRF tanpa menghancurkan sesi global (`session()->invalidate()`), sehingga sesi `dashboard` tetap aman dan aktif.

#### 3. Penghapusan Custom `LogoutResponse`
*   **Perubahan**: Menghapus file `app/Http/Responses/LogoutResponse.php` dan menghapus binding-nya dari `app/Providers/AppServiceProvider.php`.
*   **Hasil**: Mengembalikan penanganan respon logout Filament ke default bawaan vendor yang mengalihkan admin kembali ke halaman login Filament (`/back-office/login`) secara bersih.

### Dampak Perbaikan
*   ✅ **Sesi Mandiri**: Pengguna yang logout dari Main-Dashboard tetap masuk (logged-in) di Filament Back-Office.
*   ✅ **Filament Terisolasi**: Admin yang logout dari Filament Back-Office tetap masuk (logged-in) di Main-Dashboard.
*   ✅ **Pembersihan CSRF**: Kedua proses logout tetap meregenerasi token CSRF demi keamanan tanpa menghancurkan data sesi guard lain yang sedang aktif.

---

## 🔒 5. Bug Fix: Filtering Akses Sidebar dengan Multi-Guard Session & Safeguard

### Masalah
1. **Bypass Sesi Admin**: Ketika administrator (`admin@admin.com`) login di Filament (`admin` guard) dan pengguna biasa login di Main Dashboard, sidebar utama di Main Dashboard ikut menampilkan semua modul. Hal ini terjadi karena pendeteksian `$user` memeriksa seluruh guard (termasuk `admin`) sehingga sesi administrator mendominasi dan mengabaikan pembatasan hak akses user portal biasa.
2. **Error Method Call pada Admin Model**: Model `App\Models\Admin` tidak memiliki method `hasAccessToGuard()`. Sehingga, jika administrator membuka halaman yang memuat sidebar tersebut, sistem mengalami crash dengan error `Call to undefined method App\Models\Admin::hasAccessToGuard()`.
3. **Sidebar Kosong untuk Guest**: Jika user tidak dalam keadaan login (guest), sidebar menjadi kosong melompong (hanya berisi "Home" dan "Filter") yang membingungkan pengunjung umum.

### Langkah Perbaikan
1. **Isolasi Guard Portal**: Mengubah pendeteksian `$user` pada sidebar dashboard utama (`sidebar-left.blade.php` & `dashboard-slidebar.blade.php`) agar hanya mendeteksi guard portal utama (`web` dan `dashboard`):
   ```php
   $user = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();
   ```
   Hal ini memisahkan deteksi user portal dari sesi administrator Filament.
2. **Metode Safeguard (`method_exists`)**: Menambahkan pengecekan keberadaan method sebelum memanggil `hasAccessToGuard()` pada semua template sidebar (`sidebar-left.blade.php`, `dashboard-slidebar.blade.php`, dan `dashboard-sidebar.blade.php`):
   ```php
   $hasAccess = ($user && method_exists($user, 'hasAccessToGuard')) ? $user->hasAccessToGuard($guard) : ($user instanceof \App\Models\Admin);
   ```
   Jika model user tidak memiliki method (seperti `Admin` model), maka hak akses akan langsung bernilai `true`. Jika user adalah tamu/guest (belum login), `$hasAccess` bernilai `false`.
3. **Perilaku Tampilan untuk Tamu (Guest)**: Untuk tamu (belum masuk sistem), semua menu modul disembunyikan dan hanya disisakan menu **Home** saja. Begitu masuk ke sistem, daftar menu akan terfilter secara dinamis sesuai perannya masing-masing.

---

## 👤 6. Kustomisasi Dropdown Profil (Pengganti Tombol Login & Logout)

### Lokasi File & Kode Utama
*   **File**: `resources/views/livewire/main-dashboard/public/index.blade.php`
*   **Detail Penempatan**: Baris 14–74 (pada bagian kanan `dashboard-nav` / header utama).

### Deskripsi Perubahan
1.  **Inisial Dinamis**: Menghitung inisial dari nama pengguna (misal: "Fadjri Wivindi" menjadi "FW") dengan gradien warna Emerald.
2.  **Dropdown Menu Premium**: Menampilkan detail nama & email pengguna, shortcut tautan **Profile**, serta tombol **Logout** berwarna merah.
3.  **Vanilla JS Toggle**: Menggunakan toggle JavaScript murni (`toggleDropdownMenu` & `click-away` listener) untuk menghindari konflik framework (seperti Alpine.js atau Bootstrap versi lama) sehingga dipastikan 100% responsif dan berfungsi di semua peramban (browser).

---

## 🎨 7. Perubahan CSS Global (Penyelarasan Avatar & Penghapusan Caret)

### Lokasi File
*   **File**: `public/assets/css/styles.css` dan `public/assets/css/styles-audit.css`

### Deskripsi Perubahan
1.  **Penyelarasan Padding Avatar**: Mengubah padding pada `.profile-image` dari `4px 16px 4px 8px` menjadi `4px 8px` agar lingkaran inisial terpusat secara presisi dan simetris (karena icon panah/caret dihilangkan).
2.  **Penghapusan Caret Arrow**: Menghilangkan tanda panah ke bawah (downward caret) secara global pada seluruh sub-modul yang menggunakan header profil dengan menonaktifkan pseudo-element `::after`:
    ```css
    .profile-menu .profile-image::after {
        content: none !important;
        display: none !important;
    }
    ```

---

## 🐛 8. Bug Fix — Document System: File Upload Tidak Berfungsi (Windows Filesystem + Route Mismatch)

**Tanggal Ditemukan:** 2026-06-12  
**Status:** ✅ Fixed

### Deskripsi Gejala

Ketika user mencoba mengupload lampiran (attachment) pada halaman **Edit Document** (`/document-systems/maker/edit-maker/{id}`), tidak terjadi apa-apa — tidak ada file yang muncul dalam daftar lampiran, tidak ada pesan error, dan form tetap kosong seolah upload tidak pernah terjadi.

---

### Root Cause — 3 Bug Utama

#### Bug #1 — Karakter `:` (Colon) Ilegal pada Nama File Sementara di Windows

**File:** `Modules/DocumentSystem/Services/DocumentSystemService.php` (serta `PtwService.php` dan `JsaService.php`)

Format penamaan file sementara sebelumnya menggunakan `:` (titik dua) untuk jam:menit (`Y-m-d-H:i`). Karakter ini adalah karakter ilegal untuk nama file pada sistem operasi Windows (NTFS), sehingga file upload gagal disimpan saat dijalankan secara lokal (Laragon). 

Sebagai solusi, format penamaan file disesuaikan secara kondisional: format Linux di-comment untuk dokumentasi production, dan format Windows aktif tanpa karakter titik dua (`Y-m-d-Hi`):

```php
// save file to tmp
// $name = date('Y-m-d-H:i') . '-' . $file->getClientOriginalName(); // Linux/CentOS format (contains illegal ':' for Windows)
$name = date('Y-m-d-Hi') . '-' . $file->getClientOriginalName(); // Windows compatible format
```

---


#### Bug #2 — Route `edit-maker` Mengarah ke Komponen Lama (`AddnewMaker`) yang Tidak Memiliki Handler Upload


**File:** `Modules/DocumentSystem/Routes/web.php`

| | Sebelum | Sesudah |
|---|---|---|
| Route `GET edit-maker/{id}` | → `AddnewMaker::class` (komponen lama) | → `AddNewDocument::class` (komponen aktif) |
| Route `POST /files` | → `[AddnewMaker::class, 'saveFile']` | → `[AddNewDocument::class, 'saveFile']` |

`AddnewMaker` adalah komponen versi lama yang tidak memiliki method `saveFile()` dan `createdFiles()`. Akibatnya, AJAX call ke endpoint `maker.files` untuk menyimpan file sementara tidak pernah berhasil dipanggil sama sekali.

```php
// SEBELUM (BERMASALAH)
Route::post('/files', [AddnewMaker::class, 'saveFile'])->name('maker.files');
Route::get('edit-maker/{id}', AddnewMaker::class)->name('edit-maker');

// SESUDAH (FIXED)
Route::post('/files', [AddNewDocument::class, 'saveFile'])->name('maker.files');
Route::get('edit-maker/{id}', AddNewDocument::class)->name('edit-maker');
```

---

#### Bug #3 — `mount()` Tidak Menerima Parameter `$id`, Form Edit Tidak Pre-Fill

**File:** `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php`

Method `mount()` tidak menerima parameter `$id` dari route sehingga saat membuka halaman edit, seluruh field form kosong (tidak ada data dokumen yang dimuat). User tidak dapat melihat data lama, lampiran yang sudah ada, maupun status dokumen saat ini.

```php
// SEBELUM (BERMASALAH)
public function mount()
{
    // Tidak ada parameter $id → mode edit tidak pernah berjalan
}

// SESUDAH (FIXED)
public function mount($id = null)
{
    // ... inisialisasi dropdown (companies, modules, documentTypes) ...

    // Mode Edit: pre-fill form dari database
    if ($id) {
        $this->id_maker = $id;
        $doc = Document::with(['attachments', 'department'])->find($id);
        if ($doc) {
            $this->company_id    = $doc->department->company_id;
            $this->department_id = $doc->department_code_id;
            $this->pic           = $doc->user_id;
            $this->module_id     = $doc->mapping?->category?->module_id;
            $this->category_id   = $doc->mapping?->category_id;
            $this->mapping_id    = $doc->mapping_id;
            $this->upload_type   = $doc->upload_type;
            $this->document_type = (int) $doc->document_level;
            $this->title         = $doc->title;
            $this->description   = $doc->description;
            $this->doc_created   = $doc->doc_created;
            // Load existing attachments into $tmp for display
            foreach ($doc->attachments as $att) {
                $this->tmp[] = [ 'id' => $att->id, 'name' => $att->file_name, ... ];
            }
        }
    }
}
```

---

### Ringkasan File yang Dimodifikasi

| File | Perubahan |
|---|---|
| `Modules/DocumentSystem/Services/DocumentSystemService.php` | Ganti format tanggal `H:i` → `H-i-s` pada nama file sementara |
| `Modules/DocumentSystem/Routes/web.php` | Arahkan route `edit-maker` & `POST /files` ke `AddNewDocument` |
| `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php` | Tambahkan parameter `$id = null` pada `mount()` dan logika pre-fill form edit |

### Dampak Perbaikan

*   ✅ Upload lampiran pada halaman **Edit Document** kini berfungsi normal di environment Windows (Laragon).
*   ✅ Form edit sekarang otomatis menampilkan semua data dokumen lama beserta daftar lampiran yang sudah pernah diupload.
*   ✅ Fitur upload juga berlaku untuk mode **Add New Document** (`/add-maker`) karena keduanya kini menggunakan komponen dan route yang sama.


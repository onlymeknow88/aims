# 📋 AIMS — Rekap Seluruh Bug Fixes

Dokumen ini merangkum semua bug yang telah diidentifikasi dan diperbaiki di seluruh modul AIMS, berdasarkan file-file di direktori `agent/BUG/`.

---

## 🗂️ Modul Document System ([bug_fixes.md](file:///c:/laragon/www/aims/agent/BUG/bug_fixes.md))

### Bug 1 — Relasi Departemen User (`User->department` Mismatch)
- **Status**: ✅ Fixed
- **File**: `app/Models/User.php`
- **Masalah**: Method `department()` mengembalikan `BelongsToMany` tapi dipanggil seolah `BelongsTo` (single object).
- **Fix**: Tambah penanganan khusus/relasi terpisah untuk ambil satu departemen utama.

---

### Bug 2 — Dummy Data Tidak Muncul pada Dashboard (Draft & OnGoing)
- **Status**: ✅ Fixed
- **File**: Seeder `DocumentSystemDummySeederTableSeeder.php`, `DocumentSystemStatusDummySeeder.php`
- **Masalah**: Setelah seeder dijalankan, dashboard Draft dan OnGoing tetap kosong.
- **Root Cause**: Query filter `where('created_by', auth()->user()->id)` — data dummy punya `created_by = null`.
- **Fix**: Update seeder agar kolom `created_by` diisi dengan ID user aktif.

---

### Bug 3 — Permission `@can` Tidak Berfungsi (Guard Mismatch)
- **Status**: ✅ Fixed
- **File**: `app/Providers/AuthServiceProvider.php`
- **Masalah**: Sidebar, tombol buat/hapus dokumen hilang meski user punya hak akses.
- **Root Cause**: Permission di-seed dengan `guard_name = 'document-system'`, tapi Gate periksa guard `web`.
- **Fix**: Tambah interceptor `Gate::before()` di `AuthServiceProvider.php` untuk multi-guard check.

---

### Bug 4 — Gagal Upload Lampiran di Windows (Karakter `:` Ilegal)
- **Status**: ✅ Fixed
- **File**: `DocumentSystemService.php`, `PtwService.php`, `JsaService.php`
- **Masalah**: Upload lampiran tidak berfungsi — file gagal disimpan di `storage/tmp/`.
- **Root Cause**: Nama file menggunakan `date('Y-m-d-H:i')` — karakter `:` ilegal di Windows NTFS.
- **Fix**: Ganti format menjadi `date('Y-m-d-Hi')` (tanpa titik dua).

---

### Bug 5 — Route `edit-maker` Mengarah ke Komponen Lama
- **Status**: ✅ Fixed
- **File**: `Modules/DocumentSystem/Routes/web.php`
- **Masalah**: Upload file di form Edit tidak merespon (handler tidak ada di kelas lama).
- **Root Cause**: Route masih mengarah ke `AddnewMaker::class` (kelas lama tanpa handler upload).
- **Fix**: Arahkan ke `AddNewDocument::class`.

---

### Bug 6 — Dropdown Form Edit Kosong (Pre-Fill Select2 Dropdowns)
- **Status**: ✅ Fixed
- **File**: `AddNewDocument.php`
- **Masalah**: Form edit — dropdown PJ, Category, Mapping kosong.
- **Root Cause**: `mount($id)` hanya mapping value ID, tidak memuat daftar opsi (`$categories`, `$mapping`, `$pics`).
- **Fix**: Tambah logika pre-fill dinamis di `mount($id)`.

---

### Bug 7 — Karakter Titik (`.`) di Depan Nama Category & Mapping
- **Status**: ✅ Fixed
- **File**: `AddNewDocument.php`
- **Masalah**: Tampil `. SOP K3` dan `. SOP Working at Heights` di dropdown.
- **Root Cause**: Eager loading tidak menyeleksi kolom `index`, sehingga nilainya `null`.
- **Fix**: Tambah kolom `index` ke eager loading `categories:id,index,name,module_id`.

---

### Bug 8 — File Lampiran Tidak Muncul di Dashboard List Views
- **Status**: ✅ Fixed
- **File**: Berbagai blade listing (`table-on-going.blade.php`, `index.blade.php`, dll.) & Livewire controllers.
- **Masalah**: Lampiran tidak muncul di tabel daftar dokumen.
- **Root Cause**: Filter `@if ($name == 'Final')` memblokir file yang belum diproses. Plus N+1 queries.
- **Fix**: Hapus filter `Final`. Tambah eager loading `with(['attachments' => ...])`.

---

### Bug 9 — Navigasi Detail & Dropdown Approval Dokumen Berstatus `PREPARE_ROOTING_REVIEW`
- **Status**: ✅ Fixed
- **File**: `detail-maker.blade.php`, `AddNewDocument.php`
- **Masalah**:
  1. Approver Level 2 melihat tombol "Edit Document" alih-alih "Document Action".
  2. "Save as Draft" pada status `PREPARE_ROOTING_REVIEW` malah ubah status ke `ROOTING_REVIEW`.
- **Root Cause**: Kondisi pengecekan tidak memverifikasi apakah user adalah maker asli. Transisi status tidak cek parameter `$status`.
- **Fix**: Tambah cek `auth()->user()->id == $detail->created_by`. Update logika transisi berdasarkan nilai `$status`.

---

### Bug 10 — Gagal Approve PDF 1.5+ (Limitasi Kompresi FPDI)
- **Status**: ✅ Fixed
- **File**: `DocumentSystemService.php`, `ReviewDetail.php`
- **Masalah**: Error fatal saat approve dokumen PDF 1.5+ dengan kompresi modern.
- **Root Cause**: Parser FPDI gratis tidak support PDF 1.5+ dengan *object streams*.
- **Fix**: Bungkus dalam `try-catch`. Jika gagal, salin file asli tanpa watermark sebagai graceful fallback.

---

### Bug 11 — Keterlambatan Input & Kehilangan Pilihan Dropdown Select2
- **Status**: ✅ Fixed
- **File**: `add-new-document.blade.php` & beberapa form JSA/PTW.
- **Masalah**: Input teks lag parah, dropdown `listEmployee` sering ter-reset.
- **Root Cause**: `wire:model` langsung memicu AJAX per ketukan. Re-init Select2 gunakan `.empty()` yang hapus semua opsi.
- **Fix**: Ganti ke `wire:model.defer`. Optimalkan handler `employeeDataUpdated` untuk preserve pilihan.

---

### Bug 12 — Exception `Undefined Variable $disabled` pada Komponen Select2
- **Status**: ✅ Fixed
- **File**: `components/inputs/select2.blade.php`
- **Masalah**: Error fatal `ErrorException: Undefined variable $disabled`.
- **Fix**: Kembalikan deklarasi `@props` di bagian atas file komponen.

---

### Bug 13 — Exception `Undefined Array Key 0` Saat Menghapus Pilihan Company
- **Status**: ✅ Fixed
- **File**: `AddNewDocument.php` & form JSA/PTW controllers.
- **Masalah**: Klik ikon X di dropdown Company → error fatal `Undefined array key 0`.
- **Root Cause**: Method `updated()` tidak cek `empty($value)` sebelum akses indeks koleksi ke-0.
- **Fix**: Tambah validasi `if (empty($value))` dengan early return dan reset state terkait.

---

### Bug 14 — Dropdown Department Tertutup Otomatis & "No Results Found"
- **Status**: ✅ Fixed
- **File**: `components/inputs/select2.blade.php`
- **Masalah**: Dropdown Select2 tiba-tiba tertutup saat ada request Livewire lain.
- **Root Cause**: Event `hydrate` emit `select2` → re-inisialisasi memanggil `.select2('destroy')` yang hancurkan dropdown aktif.
- **Fix**: Implementasi `wire:ignore` + `wire:key` dinamis berbasis MD5 slot. Inisialisasi bersyarat (cek `.select2-hidden-accessible`). Cascading Client-side Lock via `data-child`.

---

### Bug 15 — `Attempt to read property "koBrand" on null` (Modul KO)
- **Status**: ✅ Fixed
- **File**: `CreateProposal.php`, `EditProposal.php` (Modul KO)
- **Masalah**: Error saat ubah/kosongkan pilihan Unit.
- **Root Cause**: `KoUnit::find()` tanpa null-check, lalu akses `$unit->koBrand` langsung.
- **Fix**: Gunakan null-safe `?->` dan null coalescing `??` dengan nilai default.

---

### Bug 16 — Lag Saat Mengubah Dropdown Kondisi Komisioning (Modul KO)
- **Status**: ✅ Fixed
- **File**: `create-commissioning.blade.php`, `edit-commissioning.blade.php`
- **Masalah**: Mengubah dropdown kondisi terasa lambat dan memicu freeze.
- **Root Cause**: `wire:model` langsung trigger AJAX. `@if` Blade untuk textarea "Gagal" memaksa server re-render seluruh tabel.
- **Fix**: Ganti ke `wire:model.defer`. Ganti `@if` dengan Alpine.js `x-show`. Hapus class `select2` yang tidak terpakai.

---

## 🗂️ Modul CSMS ([csms_bug_fixes.md](file:///c:/laragon/www/aims/agent/BUG/csms_bug_fixes.md))

### Bug 1 — Select2, Input, Textarea & Datepicker Freeze (Livewire DOM Clash)
- **Status**: ✅ Fixed
- **File**: `components/inputs/select2.blade.php`, form views Bidding/Post-Bidding/PJO.
- **Masalah**: Freeze/lag parah saat interaksi dengan Select2, input, textarea, dan datepicker.
- **Fix**: Implementasi `wire:ignore` + `wire:key`. Cek kesamaan nilai (`isSame` check) sebelum `@this.set`. Deteksi `.defer` secara dinamis.

---

### Bug 2 — Upload ke Azure Blob Storage
- **Status**: ✅ Fixed
- **File**: Livewire Form Controllers (`Create.php`, `Edit.php`), migration blob columns.
- **Masalah**: File masih diunggah ke penyimpanan lokal, tidak ke Azure Blob Storage.
- **Fix**: Gunakan helper `uploadToBlobStorage()`. Simpan `blob_url` & `blob_response` ke database.

---

### Bug 3 — Preview File Blob Storage (Sistem `previewBlobFile`)
- **Status**: ✅ Fixed
- **File**: `CSMSController.php`, `master.blade.php`, `preview-modal.blade.php`
- **Masalah**: Preview file tidak berfungsi — file Azure Blob butuh SAS Token temporer.
- **Fix**: Buat endpoint SAS URI. Tampilkan via modal sesuai tipe file (PDF/Image/Office Viewer).

---

## 🗂️ Modul Field Leadership ([fieldleadership_bug_fixes.md](file:///c:/laragon/www/aims/agent/BUG/fieldleadership_bug_fixes.md))

### Bug 1 — Error Null Reference pada Limit Parameter
- **Status**: ✅ Fixed
- **File**: Halaman detail PJA, Active, Approval.
- **Masalah**: Crash `ErrorException: Attempt to read property "max_item_member" on null`.
- **Root Cause**: `$limit_param` bisa `null` jika admin belum isi data di Master Library.
- **Fix**: Gunakan `?->` dan `??`. Tampilkan warning banner jika data belum di-set.

---

### Bug 2 — Upload File ke Azure Blob Storage
- **Status**: ✅ Fixed
- **File**: `EditPjaPage.php`, `DetailPjaPage.php`, `DetailActiveFieldLeadershipPage.php`, dll.
- **Masalah**: Upload masih ke penyimpanan lokal.
- **Fix**: Gunakan `uploadToBlobStorage()`. Update kolom `blob_url` dan `blob_response`.

---

### Bug 3 — Preview File dengan SAS Token Secure URL
- **Status**: ✅ Fixed
- **File**: `GeneralController.php`, `base.blade.php`, `preview-modal.blade.php`
- **Masalah**: Preview file gagal/tidak merespons karena file private di Azure memerlukan SAS Token.
- **Fix**: Buat method `getFileSasUri()`. Sertakan modal preview dan script di base layout.

---

### Bug 4 — Lag Parah pada Form Input & Select2
- **Status**: ✅ Fixed
- **File**: Form creation & edit blade views.
- **Masalah**: Setiap ketukan/perubahan dropdown trigger AJAX — freeze/lag.
- **Fix**: Ganti `wire:model` → `wire:model.defer` pada semua input statis.

---

### Bug 5 — Delay Checkbox/Radio Button Row Selection pada Tabel Master Library
- **Status**: ✅ Fixed
- **File**: `table-maker.blade.php` (Limit Parameter, Type KTA/TTA, Potency, Category).
- **Masalah**: Centang row → tombol Export/Delete muncul lambat 2-3 detik.
- **Root Cause**: Klik baris trigger AJAX ke server. Event bubbling dari kolom edit menyebabkan double request.
- **Fix**: Pindahkan logika seleksi ke Alpine.js. Sinkronisasi Livewire pakai `.defer`.

---

### Bug 6 — Duplikasi Query Database pada Render Cycle TableMaker
- **Status**: ✅ Fixed
- **File**: `TableMaker.php` (Limit Parameter, Type KTA/TTA, Potency, Category)
- **Masalah**: Query `FieldLeadershipParameter::all()` berjalan 3-4 kali per request.
- **Fix**: Tambah cache internal `$cachedParameters` di computed property.

---

### Bug 7 — Loading Lambat Saat Refresh Halaman Listing (Active & Draft)
- **Status**: ✅ Fixed
- **File**: `TableMaker.php` (Active & Draft).
- **Masalah**: Membuka/refresh halaman listing sangat lambat.
- **Root Cause**: `FieldLeadership::get()` tarik seluruh data ke memori. N+1 queries di `@foreach`. Computed property dievaluasi berulang.
- **Fix**: Ganti ke query spesifik DB. Tambah eager loading. Cache computed property.

---

### Bug 8 — N+1 Query & Caching pada Halaman Create/Edit
- **Status**: ✅ Fixed
- **File**: `CreateActiveFieldLeadershipPage.php`, `EditActiveFieldLeadershipPage.php`
- **Masalah**: Setiap roundtrip Livewire → query berulang untuk dropdown. N+1 di relasi `user`.
- **Fix**: Cache semua computed getters. Batasi kolom select. Eager Load `with('user:id,name')`.

---

### Bug 9 — Loop Request Redundan pada Event Change Select2
- **Status**: ✅ Fixed
- **File**: `select2-field-leadership.blade.php`, `select2-avatar.blade.php`
- **Masalah**: Select2 trigger request loop → freeze 4-5 detik.
- **Root Cause**: Setelah server respond, re-render trigger event `change` lagi → loop tak berujung.
- **Fix**: Tambah `isSame` check sebelum panggil `@this.set`. Skip jika nilai sama.

---

### Bug 10 — Preview File Blob Storage Lambat/Gagal Render Inline
- **Status**: ✅ Fixed
- **File**: `GeneralController.php`
- **Masalah**: Preview file download instead of render inline. Delay sangat lama.
- **Root Cause**: `get_headers()` + `fpassthru()` buffer seluruh file ke RAM. `Content-Type` dari Azure sering salah (`application/octet-stream`).
- **Fix**: Gunakan GuzzleHttp chunked streaming 8KB. Force `Content-Type` berdasarkan ekstensi. Fallback via `Storage::disk('public')->mimeType()`.

---

### Bug 11 — Checkbox Row Listing Freeze — Tombol Export/Edit/Delete Delay
- **Status**: ✅ Fixed
- **File**: `table-maker.blade.php` (Active & Draft listing)
- **Masalah**: Klik baris → freeze 1-3 detik. Tombol baru muncul setelah freeze.
- **Root Cause**: `wire:click="onSelectedItem()"` → AJAX roundtrip ke server per klik. `x-show` FOUC issue.
- **Fix**: Pindahkan seleksi ke Alpine.js. Sync ke Livewire `$wire.set()` hanya saat Export/Delete. Gunakan `<template x-if>` untuk mencegah FOUC.

---

## 🗂️ Modul PICA ([pica_bug_fixes.md](file:///c:/laragon/www/aims/agent/BUG/pica_bug_fixes.md))

### Bug 1 — Tombol Aksi Hilang di Halaman Detail Dokumen Aktif (PJA)
- **Status**: ✅ Fixed
- **File**: `detail-active-document-page.blade.php`
- **Masalah**: PJA tidak bisa kirim bukti perbaikan — tombol tidak tampil.
- **Root Cause**: Blade view tidak menyertakan struktur tombol pemicu modal.
- **Fix**: Tambah blok tombol kondisional berdasarkan status dokumen dan hak akses.

---

### Bug 2 — Logika Pembaruan Status PICA Tidak Berjalan
- **Status**: ✅ Fixed
- **File**: `DetailActiveDocumentPage.php`
- **Masalah**: Submit bukti perbaikan → status dokumen tidak berubah.
- **Root Cause**: Blok update status di-comment. Referensi variabel salah (`$this->field` → seharusnya `$this->pica`).
- **Fix**: Aktifkan kembali baris update status. Perbaiki referensi variabel.

---

### Bug 3 — Tombol "Approval Action" Muncul pada Akun PJA
- **Status**: ✅ Fixed
- **File**: `PermissionSeederTableSeeder.php`
- **Masalah**: Role PJA bisa lihat tombol Approval Action (seharusnya hanya CRS/Super Admin).
- **Root Cause**: Permission `Pica - Field Leadership Approve Document` terasosiasi ke role PJA di database.
- **Fix**: Rekonfigurasi role-permission di seeder. Jalankan ulang seeder.

---

### Bug 4 — Hilangnya Menu Sidebar PICA untuk Role Maker & PJA
- **Status**: ✅ Fixed
- **File**: `PermissionSeederTableSeeder.php`, `sidebar.blade.php`
- **Masalah**: Setelah perbaikan permission, Maker & PJA kehilangan seluruh menu sidebar.
- **Root Cause**: Menu Review CRS menggunakan filter yang sama dengan menu umum. Role Maker/PJA tidak punya `View Document` permission.
- **Fix**: Tambah `Pica - Field Leadership View Document` ke role Maker/PJA. Pisahkan filter sidebar CRS ke permission `Pica - CRS View Request Review`.

---

### Bug 5 — Freeze/Crash Saat Checkbox Row Selection
- **Status**: ✅ Fixed
- **File**: `ActiveDocumentPage.php`, `DraftPage.php`, `ReturnDocumentPage.php`, `CrsPage.php` + blade views.
- **Masalah**: Pilih baris tabel → halaman freeze atau crash.
- **Root Cause**:
  1. Tag `<td class="td-check">` ditutup prematur → DOM mismatch → hydration failure Livewire.
  2. `unset()` tanpa `array_values()` → array non-sequential → JSON Object bukan Array → Alpine.js/Livewire error.
- **Fix**: Rapikan struktur HTML `td-check`. Tambah `array_values()` setelah `unset()` di `onSelectedItem()`.

---

### Bug 7 — Eliminasi HTTP/Fetch Requests & Delay Pemilihan Baris
- **Status**: ✅ Fixed
- **File**: Blade views Active, Draft, Return Document, CRS.
- **Masalah**: Setiap pilih baris → HTTP fetch ke server → delay >1 detik.
- **Root Cause**: `@entangle('itemSelected')` langsung (bukan `.defer`) + `$wire.call('toggleSelectAll')` per klik.
- **Fix**: Ganti `@entangle(...)` → `@entangle(...).defer`. Hapus `$wire.call('toggleSelectAll')`. Ganti tombol reset dari `wire:click` ke Alpine `@click.prevent`.

---

### Bug 8 — Deferred Entanglement pada Modul DocumentSystem
- **Status**: ✅ Fixed
- **File**: `table-approval.blade.php`, `table-on-going.blade.php`, `table-maker.blade.php`, dll.
- **Masalah**: Pemilihan baris di semua listing DocumentSystem memicu AJAX instan per klik.
- **Fix**: Ganti ke `@entangle(...).defer`. Tambah helper Alpine `toggleItem(id)`. Gunakan `@click.stop` untuk cegah event bubbling.

---

## 📊 Ringkasan Statistik

| Modul | Jumlah Bug |
|---|:---:|
| Document System | 16 |
| CSMS | 4 |
| Field Leadership | 11 |
| PICA | 7 |
| **Total** | **38** |

> Semua bug berstatus ✅ **Fixed**.

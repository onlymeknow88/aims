# Pemisahan Kolom KTT dan PJO pada Field Leadership

**Dokumen:** RFC / Technical Decision  
**Modul:** Field Leadership  
**Status:** Draft — Menunggu Keputusan  
**Tanggal:** 2025

---

## 1. Latar Belakang

Saat ini pada form Field Leadership, field KTT dan PJO digabung menjadi satu dropdown dengan label `KTT/PJO`, yang nilainya diambil otomatis dari `companies.user_id` (satu user per company). Ini menyebabkan tidak bisa membedakan siapa yang berperan sebagai **KTT** dan siapa yang berperan sebagai **PJO** secara terpisah.

```blade
{{-- Kondisi saat ini di create-active-field-leadership-page.blade.php --}}
<label>KTT/PJO</label>
<select wire:model="pjo_id">
    <option value="{{ $company_type->user_id }}">
        {{ $company_type->user->name }}
    </option>
</select>
```

---

## 2. Perbedaan Fundamental: KTT vs PJO

Berdasarkan klarifikasi stakeholder dan konfirmasi data aktual di UI:

| Aspek | KTT | PJO |
|---|---|---|
| Terikat ke | **Company entitas** (contoh: PT Maruwai Coal) | **Company masing-masing** (per entitas operasional) |
| Sifat | 1 orang per company, **sangat jarang berubah** — dipilih oleh entitas | Tiap company punya PJO-nya sendiri |
| Sumber data aktual | `companies.user_id` — **sudah berperan sebagai KTT** | `companies.pjo_id` *(kolom baru yang perlu ditambah)* |
| Contoh | PT Maruwai Coal → KTT: Rahmad Taufik Siregar | PT Maruwai Coal punya PJO-nya sendiri, PT Lahai Coal punya PJO-nya sendiri |
| Perubahan | Sangat jarang — hanya saat pergantian jabatan resmi | Statis per company, tapi berbeda antar company |

> **Temuan Kunci dari Data Aktual:**
> Kolom `companies.user_id` selama ini **sudah berperan sebagai KTT** — terlihat dari UI yang menampilkan label "KTT/PJO" dengan nilai user per company entitas (Rahmad Taufik Siregar untuk PT Maruwai Coal, Sahrul untuk PT Lahai Coal).
>
> **Implikasi langsung:**
> - KTT → `companies.user_id` ✅ **tidak perlu kolom baru**
> - PJO → perlu kolom baru **`companies.pjo_id`**
> - Di `field_leaderships`, kolom `pjo_id` yang ada tetap dipakai — hanya sumber data dropdown yang diubah dari `companies.user_id` menjadi `companies.pjo_id`

---

## 3. Kondisi Database Saat Ini

### Tabel `field_leaderships`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | UUID | Primary key |
| `number` | AZ | Nomor record |
| `date` | Date | Tanggal observasi |
| `ccow_id` | FK → companies | Perusahaan internal CCOW |
| `company_id` | FK → companies | Perusahaan yang diobservasi |
| `detail_company` | AZ | Detail company |
| `department_id` | FK → departments | Departemen |
| `section_id` | FK → sections | Seksi |
| `area_location_id` | FK → area_locations | Area lokasi |
| `detail_location` | AZ | Detail lokasi |
| `pja_id` | FK → users | Penanggung jawab approval |
| `pjo_id` | FK → users | **Saat ini menampung KTT sekaligus PJO** |
| `type` | AZ | Tipe observasi |
| `personil_on_review` | AZ | Personil yang direview |
| `personil_on_review_name` | AZ | Nama personil |
| `non_compliance_root` | AZ | Akar ketidakpatuhan |
| `job` | AZ | Pekerjaan |
| `visit_time` | INT | Waktu kunjungan |
| `status` | AZ | Status record |
| `requested` | AZ | Status requested |
| `published` | AZ | Status published |
| `created_by` | FK → users | Dibuat oleh |
| `created_at` | Timestamp | — |
| `updated_at` | Timestamp | — |

### Tabel `companies`

| Kolom | Keterangan | Status |
|---|---|---|
| `id` | UUID — Primary key | ✅ Ada |
| `user_id` | FK → users — **berperan sebagai KTT per entitas company** | ✅ Ada |
| `company_name` | Nama perusahaan | ✅ Ada |
| `document_code` | Kode dokumen | ✅ Ada |
| `address` | Alamat | ✅ Ada |
| `email` | Email | ✅ Ada |
| `phone_number` | Nomor telepon | ✅ Ada |
| `type` | Tipe company (INTERNAL / EXTERNAL) | ✅ Ada |
| `parent_company_id` | FK → companies (hierarki company) | ✅ Ada |
| `pjo_id` | FK → users — PJO per entitas company | ❌ **Belum ada — perlu ditambah** |
| `created_at` | Timestamp | ✅ Ada |
| `updated_at` | Timestamp | ✅ Ada |
| `deleted_at` | Soft delete | ✅ Ada |

> **Kesimpulan kondisi saat ini:** `companies.user_id` = KTT (sudah benar secara data). Yang belum ada adalah kolom `pjo_id` di tabel `companies` untuk memisahkan PJO sebagai entitas tersendiri per company.

---

## 4. Analisis: Mengapa Pendekatan Berubah

Sebelum melihat data aktual, asumsi awal adalah menambah `ktt_id` di `companies`. Namun setelah konfirmasi UI dan struktur DB:

| Asumsi Awal | Fakta Aktual |
|---|---|
| `user_id` = PJO default, perlu tambah `ktt_id` | `user_id` = **KTT**, bukan PJO |
| Tambah kolom `ktt_id` di `companies` | Tambah kolom **`pjo_id`** di `companies` |
| `field_leaderships.pjo_id` source dari `user_id` | `field_leaderships.pjo_id` source diubah ke `companies.pjo_id` |

Perubahan kolom yang dibutuhkan **tetap hanya 1 kolom baru** — hanya berbeda kolom mana yang ditambah.

---

## 5. Rekomendasi Final: Tambah `pjo_id` di Tabel `companies`

### Migration

```php
Schema::table('companies', function (Blueprint $table) {
    $table->foreignUuid('pjo_id')
        ->nullable()
        ->references('id')
        ->on('users')
        ->nullOnDelete()
        ->after('user_id');
});
```

### Pemetaan Kolom Setelah Implementasi

```
companies
├── user_id    → KTT per entitas company (existing, tidak berubah)
└── pjo_id     → PJO per entitas company (kolom baru)

field_leaderships
├── pjo_id     → diisi dari companies.pjo_id (source dropdown diubah)
├── pja_id     → penanggung jawab approval (tidak berubah)
└── company_id → FK ke companies (tidak berubah)
```

> **Tidak perlu tambah kolom di `field_leaderships`** karena KTT tidak perlu di-snapshot per observasi — perubahannya sangat jarang dan terikat entitas company.

### Logika Form Livewire

```php
public function updatedCompanyId($value): void
{
    $company = Company::find($value);

    // KTT: auto-populated dari companies.user_id, ditampilkan read-only
    $this->ktt_user_id = $company?->user_id;

    // PJO: auto-populated dari companies.pjo_id, bisa diubah jika perlu
    $this->pjo_id = $company?->pjo_id;
}
```

### Tampilan Form

```blade
{{-- KTT: read-only, auto-filled dari companies.user_id --}}
<label>KTT</label>
<x-field-leadership-select2 wire:model="ktt_user_id" id="ktt_user_id" disabled>
    {{-- populated otomatis dari companies.user_id berdasarkan company_id yang dipilih --}}
</x-field-leadership-select2>

{{-- PJO: auto-filled dari companies.pjo_id, bisa di-override --}}
<label>PJO</label>
<x-field-leadership-select2 wire:model="pjo_id" id="pjo_id">
    {{-- default dari companies.pjo_id, source: users yang terhubung ke company --}}
</x-field-leadership-select2>
```

### Keuntungan Pendekatan Ini

| | |
|---|---|
| ✅ | `companies.user_id` tidak diubah — aman untuk semua modul yang sudah pakai |
| ✅ | Hanya 1 kolom baru (`pjo_id`) di `companies` |
| ✅ | Tidak ada perubahan di tabel `field_leaderships` |
| ✅ | Single source of truth untuk PJO per company |
| ✅ | KTT sudah benar via `user_id` — tinggal dipisah tampilannya di form |
| ⚠️ | Perlu update UI manajemen company untuk bisa set `pjo_id` per entitas |
| ⚠️ | Data `pjo_id` awal perlu diisi manual atau via seeder untuk company yang sudah ada |

---

## 6. Yang Masih Perlu Dikonfirmasi

Satu pertanyaan kritis sebelum implementasi:

> **Apakah `companies.user_id` (KTT) perlu ikut disimpan di `field_leaderships` sebagai snapshot?**

Jawabannya menentukan apakah perlu tambah kolom `ktt_id` di `field_leaderships` atau tidak:

| Skenario | Keputusan |
|---|---|
| KTT **tidak pernah** berubah selama operasional berjalan | ❌ Tidak perlu snapshot — cukup join ke `companies.user_id` saat query |
| KTT **bisa berganti** dan data historis harus tetap akurat | ✅ Perlu tambah `ktt_id` di `field_leaderships` sebagai snapshot |

Berdasarkan klarifikasi bahwa KTT "lama perubahannya", **snapshot tidak diperlukan** — namun keputusan final tetap ada di stakeholder.

---

## 7. Langkah Selanjutnya

- [ ] Konfirmasi: apakah snapshot KTT per record observasi diperlukan?
- [ ] Buat migration `add_pjo_id_to_companies_table`
- [ ] Update `Company` model — tambah fillable `pjo_id` dan relasi `pjo()`
- [ ] Update form manajemen company — tambah dropdown untuk set PJO
- [ ] Update form Field Leadership — pisah dropdown KTT (read-only) dan PJO
- [ ] Update logic `updatedCompanyId` di Livewire component
- [ ] Seeder / script untuk mengisi `pjo_id` pada company yang sudah ada
- [ ] Testing regresi modul lain yang menggunakan tabel `companies`

---

> **Catatan:** Untuk pemisahan approval (alur PJA), tidak diperlukan perubahan skema database karena kolom `pja_id` sudah tersedia di `field_leaderships`. Perubahan skema hanya untuk pemisahan KTT/PJO yaitu penambahan kolom `pjo_id` di tabel `companies`.

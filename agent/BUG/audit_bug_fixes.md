# AIMS Audit Module — Bug Fixes Log & Relation Simulation Results

Dokumen ini mencatat temuan bug (kutu), detail perbaikan skrip input Select2, dan hasil simulasi hubungan database (*entity relations*) pada modul **Audit** di platform AIMS.

---

## 📋 1. Detail Temuan & Perbaikan Bug

### Bug 1 — Select2, Select2 Avatar, & Select2 Multiple Freeze/Infinite Loop
* **Status**: ✅ Fixed
* **File Terkait**:
  * [`select2.blade.php`](file:///c:/laragon/www/aims/resources/views/components/inputs/select2.blade.php)
  * [`select2-avatar.blade.php`](file:///c:/laragon/www/aims/resources/views/components/inputs/select2-avatar.blade.php)
  * [`select2_multiple.blade.php`](file:///c:/laragon/www/aims/resources/views/components/inputs/select2_multiple.blade.php)

#### Masalah & Root Cause:
Ketika pengguna memilih salah satu opsi dropdown Select2, ia memicu event `change` jQuery/Select2 yang mengirimkan request server melalui Livewire (`@this.set`). Namun, setelah Livewire memperbarui state dan me-render ulang DOM, input Select2 dipicu lagi secara programmatik oleh event sync value dari Javascript. Hal ini memicu loop request paralel tak berujung (*infinite loop*), mengakibatkan halaman browser membeku (*freeze*) atau lag parah.

#### Solusi Perbaikan:
Menambahkan pemetaan `wire:model` dinamis untuk mendeteksi binding `.defer` dan menyematkan validasi pencocokan nilai (`isSame` atau komparasi JSON stringify untuk multi-select) sebelum memicu pembaruan state Livewire.

##### Contoh Implementasi Perbaikan Event Listener (`select2-avatar.blade.php`):
```javascript
$el.off('change.select2-hook');
$el.on('change.select2-hook', function(e) {
    const currentVal = @this.get('{{ $modelName }}');
    
    // Cek isSame untuk menghindari re-trigger state ke server jika nilainya sama
    const isSame = (currentVal == e.target.value) || 
                   ((currentVal === null || currentVal === undefined || currentVal === '') && 
                    (e.target.value === null || e.target.value === undefined || e.target.value === ''));
    
    if (!isSame) {
        @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
    }
});
```

##### Contoh Implementasi Perbaikan Event Listener (`select2_multiple.blade.php`):
```javascript
$el.off('change.select2-hook');
$el.on('change.select2-hook', function (e) {
    var data = $(this).select2("val");
    const currentVal = @this.get('{{ $modelName }}');
    
    // Komparasi array data multi-select menggunakan JSON stringify
    const isSame = JSON.stringify(currentVal || []) === JSON.stringify(data || []);
    
    if (!isSame) {
        @this.set('{{ $modelName }}', data, {{ $isDeferred ? 'true' : 'false' }});
    }
});
```

---

### Bug 2 — Fatal PHP Error `Call to a member function toArray() on null` pada Halaman Detail Audit
* **Status**: ✅ Fixed
* **File Terkait**:
  * [`Detail.php`](file:///c:/laragon/www/aims/Modules/Audit/Http/Livewire/Smkp/Bundle/Detail.php)

#### Masalah & Root Cause:
Halaman detail memuat data paket audit menggunakan query `find($id)`. Apabila ID audit di URL tidak ditemukan di database (misalnya pasca reset atau seeding ulang database), variabel `$this->audit` akan mengembalikan nilai `null`. Akses objek `$this->audit->toArray()` pada baris berikutnya memicu fatal PHP Exception yang merusak tampilan.

#### Solusi Perbaikan:
Mengganti pemanggilan metode `find($id)` dengan `findOrFail($id)`. Dengan ini, Laravel secara otomatis melempar `ModelNotFoundException` dan menampilkan halaman 404 yang rapi dan aman kepada pengguna.

```diff
- $this->audit = Audit::with('company', 'auditors', 'evaluators')->find($id);
+ $this->audit = Audit::with('company', 'auditors', 'evaluators')->findOrFail($id);
```

---

## ⚙️ 2. Hasil Simulasi Hubungan Database (Simulate Audit Flows)

Pengujian skrip verifikasi otomatis [`simulate_audit_flows.php`](file:///c:/laragon/www/aims/scratch/simulate_audit_flows.php) dijalankan pada database lokal guna menguji fungsionalitas relasi data di 10 skenario status audit.

### Ringkasan Status Seed & Relasi Objek:
Semua relasi entitas berikut terbukti terhubung dengan sukses (bebas dari error *integrity constraint*):

1. **Company Relationship**: Seluruh audit dummy dikaitkan secara valid ke instansi perusahaan yang terdaftar.
2. **Tim Audit (Auditors)**: Pendaftaran tim auditor dan pengawas (Lead Auditor & Auditor) sukses terasosiasi.
3. **Audit Plan & Details**: Menyimpan detail lingkup kerja, distribusi laporan, dan alamat site.
4. **Metode & Sampel Audit**: 100% dari 100 sub-kriteria SMKP terisi dengan data sampel dokumen dummy.
5. **Kesesuaian Lokasi (Location & Criteria Locations)**: 3 lokasi utama (`Workshop Utama`, `Gudang Bahan Kimia`, `Pit East Operation`) berhasil dibuat untuk setiap paket audit berstatus aktif, dengan **300 s/d 345 baris penilaian lokasi** yang terdistribusi secara acak.
6. **Laporan Implementasi (Implementation Report)**: Sukses mengaitkan modular perfomance keselamatan, adjustment factors, dan eligibilities secara dinamis.
7. **Isi Temuan Audit (Findings)**:
   * **Draft / On Progress**: Penilaian masih berlangsung.
   * **Need Review / In Review / Approved / Rejected**: Terisi dengan **~80% Conformance** (rekomendasi perbaikan terlampir) dan **~20% Non-Conformance** (auto-generate nomor NCR, investigasi akar masalah, bukti pendukung, dan batas waktu perbaikan terlampir).

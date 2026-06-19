# AIMS PICA Module — Bug Fixes Log & Technical Scripts

Dokumen ini mencatat detail perbaikan bug (kutu) dan penjelasan baris kode/skrip yang diterapkan pada modul **PICA (Corrective Action)** di platform AIMS.

---

## 📋 Ringkasan Perbaikan & Skrip Implementasi

### 1. Tombol Aksi Hilang/Tidak Ada pada Halaman Detail Dokumen Aktif (PJA)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Resources/views/livewire/listing/active-document/detail-active-document-page.blade.php`
* **Masalah**: PJA (Penanggung Jawab) tidak dapat mengirimkan tanggapan bukti perbaikan (*evidence*) karena tombol **Checking Action** / **Corrective Action** tidak tersedia/tidak ditampilkan di halaman detail dokumen aktif (`/listing/active-document/detail/{id}`).
* **Root Cause**: Desain file view Blade tidak menyertakan struktur tombol pemicu (*trigger buttons*) untuk memicu modal `#CorrectiveAction` dan `#ReturnWithComment` yang sebenarnya sudah didefinisikan di bagian bawah file.
* **Perbaikan**: Menambahkan blok kode tombol aksi kondisional berdasarkan status dokumen dan hak akses/kepemilikan PJA:

```html
<!-- Penambahan tombol di detail-active-document-page.blade.php sebelum penutup /.section-content -->
@if (in_array($pica->status, [\App\Enums\Pica\PicaStatus::OnReviewPja, \App\Enums\Pica\PicaStatus::Open, \App\Enums\Pica\PicaStatus::Overdue]))
    @if (auth()->user()->id == ($pica->pja->user_id ?? null) || auth()->user()->can('Pica - Field Leadership Approve Document'))
        <div class="footer-action mb-2">
            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                <div class="button-document">
                    <button
                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Checking Action
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#CorrectiveAction"
                                class="dropdown-item" href="#">
                                Corrective Action
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endif

@if ($pica->status == \App\Enums\Pica\PicaStatus::OnReviewCrs)
    @if (auth()->user()->can('Pica - Field Leadership Approve Document'))
        <div class="footer-action mb-2">
            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                <div class="button-document">
                    <button
                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Approval Action
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button type="button" wire:click="action" class="dropdown-item" href="#">
                                Case Close
                            </button>
                        </li>
                        <li>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#ReturnWithComment"
                                class="dropdown-item" href="#">
                                Return with comment
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endif
```

---

### 2. Logika Pembaruan Status PICA Tidak Berjalan (Commented Code & Undefined Variable)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Http/Livewire/Listing/ActiveDocument/DetailActiveDocumentPage.php`
* **Masalah**: Setelah PJA mengisi deskripsi bukti perbaikan dan mengklik Submit, status dokumen tidak berubah sehingga dokumen tetap berada di daftar antrean PJA dan tidak berlanjut ke Review CRS.
* **Root Cause**: Blok kode yang memperbarui status dokumen di dalam method `saved()` di-comment dan merujuk ke variabel `$this->field` yang tidak pernah didefinisikan pada kelas komponen tersebut (variabel yang benar adalah `$this->pica`).
* **Perbaikan**: Mengaktifkan kembali baris kode pembaruan status dengan referensi variabel model yang tepat (`$this->pica`) dan memetakan status baru ke `OnReviewCrs` / `RequestedCrs` agar alur dokumen berlanjut secara otomatis:

```php
// Modifikasi method saved($status) di DetailActiveDocumentPage.php
public function saved($status)
{
    $this->validate();

    DB::beginTransaction();

    $activity = PicaActivity::create([
        'pica_id' => $this->pica->id,
        'description' => $this->description,
        'user_id' => auth()->user()->id ?? '-',
    ]);

    // ... loop penyimpanan file bukti perbaikan ...

    // UNCOMMENT & FIX STATUS UPDATE LOGIC
    $this->pica->update([
        'status' => $status == 'return' ? PicaStatus::Open : PicaStatus::OnReviewCrs,
        'requested' => $status == 'return' ? PicaStatus::ReturnDocument : PicaStatus::RequestedCrs,
    ]);

    DB::commit();

    // ... return redirect ...
}
```

---

### 3. Masalah Tombol "Approval Action" Muncul pada Akun PJA
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Database/Seeders/PermissionSeederTableSeeder.php`
* **Masalah**: Pengguna dengan role PJA (Penanggung Jawab Aksi) secara tidak sengaja dapat melihat tombol **Approval Action** ketika dokumen berada pada status `On Review CRS` (seharusnya tombol ini hanya diperuntukkan bagi CRS Reviewer/Super Admin).
* **Root Cause**: Sinkronisasi data permission di database lokal tidak selaras, sehingga permission `Pica - Field Leadership Approve Document` terasosiasi pada role `PICA - Approval PJA` di tabel `role_has_permissions`.
* **Perbaikan**: Mengonfigurasi ulang mapping role dan permission yang benar di file seeder, lalu menjalankan perintah seeder untuk menyinkronkan data secara bersih:
  ```bash
  php artisan db:seed --class=Modules\Pica\Database\Seeders\PicaDatabaseSeeder
  ```

#### Skrip Penjelasan Solusi (PermissionSeederTableSeeder.php):
Berikut adalah pembagian hak akses (role & permissions) yang benar dalam seeder untuk modul PICA:

```php
// Pemetaan Role & Sinkronisasi Permission di PermissionSeederTableSeeder.php
// 1. Definisikan/buat roles dengan guard pica
$pjaRole = Role::firstOrCreate(['name' => 'PICA - Approval PJA', 'guard_name' => 'pica']);
$crsRole = Role::firstOrCreate(['name' => 'PICA - Approval CRS', 'guard_name' => 'pica']);
$superAdminRole = Role::firstOrCreate(['name' => 'PICA - Super Admin', 'guard_name' => 'pica']);

// 2. Batasi PJA agar HANYA bisa melihat Request Review & Draft (tidak boleh melakukan Approval Action)
$pjaRole->syncPermissions([
    $permissionModels['Pica - PJA View Request Review'],
    $permissionModels['Pica - PJA View Draft'],
]);

// 3. CRS diberikan izin penuh untuk melihat dokumen dan melakukan persetujuan (Approve Document)
$crsRole->syncPermissions([
    $permissionModels['Pica - CRS View Request Review'],
    $permissionModels['Pica - Field Leadership View Document'],
    $permissionModels['Pica - Field Leadership Approve Document'], // Hak akses untuk tombol Approval Action
]);

// 4. Super Admin mendapatkan seluruh permissions modul PICA
$superAdminRole->syncPermissions(Permission::where('guard_name', 'pica')->get());
```

Dengan menjalankan seeder di atas, relasi di database dibersihkan (`syncPermissions` menghapus asosiasi lama dan mendaftarkan ulang yang baru) sehingga pengguna dengan role `PICA - Approval PJA` dipastikan kehilangan hak akses `Pica - Field Leadership Approve Document` dan tidak dapat melihat tombol **Approval Action** di halaman detail.

---

### 4. Hilangnya Menu Sidebar PICA untuk Role Maker & PJA setelah Pembersihan Permission
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Database/Seeders/PermissionSeederTableSeeder.php`
  * `Modules/Pica/Resources/views/layouts/sidebar/sidebar.blade.php`
* **Masalah**: Setelah seeder permission diperbaiki (dimana permission `Approve` ditarik dari PJA), pengguna dengan role `PICA - Maker` dan `PICA - Approval PJA` kehilangan seluruh menu sidebar (seperti *Active Document*, *Draft*, dan *Return Document*) sehingga halaman navigasi menjadi kosong.
* **Root Cause**: 
  1. Seluruh menu sidebar PICA dibatasi menggunakan kondisi `@if (auth()->user()->can('Pica - Field Leadership View Document') || auth()->user()->can('Pica - Field Leadership Approve Document'))`.
  2. Role `PICA - Maker` dan `PICA - Approval PJA` sebelumnya tidak memiliki permission `Pica - Field Leadership View Document` di seeder, sehingga ketika menu *Review* ditarik, mereka kehilangan semua akses menu sidebar.
  3. Menu khusus CRS (*Review CRS*) menggunakan filter penyeleksian yang sama dengan menu umum lainnya, sehingga berpotensi bocor jika hak akses diperluas.
* **Perbaikan**:
  1. Menambahkan permission `Pica - Field Leadership View Document` kepada role `PICA - Maker` dan `PICA - Approval PJA` di `PermissionSeederTableSeeder.php` agar mereka dapat melihat daftar dokumen aktif.
  2. Menyesuaikan logika filtering di [sidebar.blade.php](file:///c:/laragon/www/aims/Modules/Pica/Resources/views/layouts/sidebar/sidebar.blade.php) khusus untuk menu *Review CRS* agar hanya dapat diakses oleh pengguna yang memiliki permission `Pica - CRS View Request Review` (bukan menggunakan view document general):
  ```html
  <!-- Sebelum (sidebar.blade.php) -->
  @if (auth()->user()->can('Pica - Field Leadership View Document') || auth()->user()->can('Pica - Field Leadership Approve Document'))
      <li class="item-sidebar">
          <a href="{{ route('pica::listing.review-crs.index') }}">Review CRS</a>
      </li>
  @endif

  <!-- Sesudah (sidebar.blade.php) -->
  @if (auth()->user()->can('Pica - CRS View Request Review'))
      <li class="item-sidebar">
          <a href="{{ route('pica::listing.review-crs.index') }}">Review CRS</a>
      </li>
  @endif
  ```

---

### 5. Bug Freeze / Crash Saat Menggunakan Checkbox Row Selection (Toggle Selected)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Http/Livewire/Listing/ActiveDocument/ActiveDocumentPage.php`
  * `Modules/Pica/Http/Livewire/Listing/Draft/DraftPage.php`
  * `Modules/Pica/Http/Livewire/Listing/ReturnDocument/ReturnDocumentPage.php`
  * `Modules/Pica/Http/Livewire/Listing/Crs/CrsPage.php`
  * `Modules/Pica/Resources/views/livewire/listing/active-document/active-document-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/draft/draft-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/return-document/return-document-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/crs/crs-page.blade.php`
* **Masalah**: Ketika menekan checkbox baris (*row checkbox selection*) atau memilih baris tabel, halaman web tiba-tiba freeze (membeku) atau crash.
* **Root Cause**:
  1. **Kesalahan Struktur HTML (DOM Mismatch)**: Tag `<td class="td-check">` pada perulangan baris tabel ditutup secara prematur, lalu di bawahnya terdapat blok `@if` yang merender tag `<span>` di luar tag `<td>` disusul dengan penutup `</td>` liar. Struktur DOM yang tidak valid ini menyebabkan kegagalan proses hidrasi (hydration mismatch) pada Livewire.
  2. **Array Non-Sequential (Associative Key)**: Di dalam method `onSelectedItem($id)` pada Livewire controller, penghapusan item terpilih menggunakan `unset($this->itemSelected[$key])`. Fungsi `unset` membuat indeks array menjadi tidak berurutan (misal `[0 => 'id1', 2 => 'id3']`). Saat diubah menjadi representasi JSON ke frontend oleh Livewire, array PHP ini dianggap sebagai JSON Object, bukan JSON Array. Hal ini memicu error JavaScript di Alpine.js/Livewire saat binding `@entangle('itemSelected')` sehingga merusak siklus render halaman.
* **Perbaikan**:
  1. Merapikan struktur HTML tag `td-check` di semua berkas view listing agar valid:
     ```html
     <td class="td-check">
         @if (in_array($items->id, $itemSelected))
             <span class="icon-checked selected"></span>
         @else
             <span class="icon-checked"></span>
         @endif
     </td>
     ```
  2. Menambahkan fungsi `array_values` setelah `unset` pada method `onSelectedItem` di seluruh Livewire controller terkait untuk memaksa array tetap bertipe numerik sekuensial (re-index):
     ```php
     public function onSelectedItem($id)
     {
         if (in_array($id, $this->itemSelected)) {
             $key = array_search($id, $this->itemSelected);
             unset($this->itemSelected[$key]);
             $this->itemSelected = array_values($this->itemSelected); // Re-index kunci array agar tetap sequential
             $this->countSelected--;
         } else {
             $this->itemSelected[] = $id;
             $this->countSelected++;
         }
     }
     ```

---

### 6. Delay/Lag Munculnya Tombol Aksi (Export, Edit, Delete) Setelah Checkbox Dipilih
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/Pica/Resources/views/livewire/listing/active-document/active-document-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/draft/draft-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/return-document/return-document-page.blade.php`
  * `Modules/Pica/Resources/views/livewire/listing/crs/crs-page.blade.php`
* **Masalah**: Ketika menekan checkbox baris (*row checkbox selection*), tombol **Export**, **Edit**, **Delete**, dan teks jumlah baris terpilih mengalami delay/lag (sekitar 100-500ms) sebelum akhirnya muncul di layar.
* **Root Cause**: Visibilitas tombol aksi dikontrol secara server-side menggunakan kondisional Blade `@if ($countSelected > 0)`. Hal ini memaksa halaman web menunggu siklus request/response (hydration) dari Livewire selesai sebelum DOM diperbarui.
* **Perbaikan**: Mengalihkan penanganan visibilitas tombol sepenuhnya ke client-side menggunakan Alpine.js melalui binding `x-show="itemSelected.length > 0"` dan `x-text` untuk visualisasi jumlah pilihan yang instan (0ms delay):
  * **Export/Delete**: Diganti dari `@if ($countSelected > 0)` menjadi `<a href="#" x-show="itemSelected.length > 0" ...>`
  * **Edit**: Diganti dari `@if ($countSelected == 1)` menjadi `<a x-bind:href="'{{ route(...) }}'.replace('ID_PLACEHOLDER', itemSelected[0])" x-show="itemSelected.length == 1" ...>`
  * **Row Selected**: Diganti dari `{{ $countSelected }} Row Selected` menjadi `<span class="text-button" x-text="itemSelected.length + ' Row Selected'"></span>`





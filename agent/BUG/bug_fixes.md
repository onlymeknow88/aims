# AIMS Document System — Bug Fixes Log

Dokumen ini mencatat seluruh perbaikan kutu (bug fixes) yang diidentifikasi dan diselesaikan pada modul **Document System** di platform AIMS selama proses pengembangan dan pengujian lokal (Windows Laragon).

---

## 📋 Ringkasan Kumpulan Perbaikan Kutu

### 1. Perbaikan Relasi Departemen User (`User->department` Mismatch)
* **Status**: ✅ Fixed
* **File Terkait**: `app/Models/User.php`
* **Masalah**: Method `department()` pada model `User` mengembalikan relasi `BelongsToMany` (karena user bisa terafiliasi ke beberapa departemen via tabel pivot). Namun, beberapa bagian sistem (terutama sub-modul DocumentSystem dan panel Filament) memanggilnya seolah-olah mengembalikan single object `BelongsTo`, menyebabkan runtime type error.
* **Perbaikan**: Menambahkan penanganan khusus atau relasi terpisah untuk mengambil satu departemen utama tanpa merusak data pivot `department_user`.

---

### 2. Dummy Data Tidak Muncul pada Dashboard (Draft & OnGoing)
* **Status**: ✅ Fixed
* **File Terkait**: 
  * `Modules/DocumentSystem/Database/Seeders/DocumentSystemDummySeederTableSeeder.php`
  * `Modules/DocumentSystem/Database/Seeders/DocumentSystemStatusDummySeeder.php`
* **Masalah**: Setelah seeder dijalankan, dashboard `Draft` dan `OnGoing` tetap kosong.
* **Root Cause**: Query filtering pada komponen tabel Livewire (`TableOnGoing.php` dan `Draft/Index.php`) menggunakan clause `where('created_by', auth()->user()->id)`. Data dummy yang di-seed sebelumnya memiliki nilai `created_by = null`, sehingga tidak ada satu pun dokumen dummy yang lolos filter visibility untuk user yang login.
* **Perbaikan**: Memperbarui seeder untuk mengisi kolom `created_by` dengan ID user aktif/admin secara dinamis, menghapus record yatim piatu (orphaned records), dan men-seed ulang data secara bersih.

---

### 3. Masalah Permission `@can` Tidak Berfungsi (Guard Mismatch)
* **Status**: ✅ Fixed
* **File Terkait**: `app/Providers/AuthServiceProvider.php`
* **Masalah**: Sidebar navigasi, tombol buat/hapus dokumen, dan menu aksi Document System hilang meskipun user memiliki hak akses.
* **Root Cause**: Spatie Permission memeriksa directive `@can('...')` menggunakan default guard Laravel (`web`). Sementara itu, semua permission Document System di-seed dengan `guard_name = 'document-system'`. Karena perbedaan guard name ini, Gate selalu mengembalikan nilai `false`.
* **Perbaikan**: Menambahkan interceptor global `Gate::before()` di `AuthServiceProvider.php` untuk mendeteksi user aktif dari seluruh multi-guards modul. Jika user memiliki permission di guard modul bersangkutan, gate langsung mengembalikan `true`.

---

### 4. Gagal Upload Lampiran di Windows (Karakter `:` Ilegal)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Services/DocumentSystemService.php`
  * `Modules/DocumentSystem/Services/PtwService.php`
  * `Modules/DocumentSystem/Services/JsaService.php`
* **Masalah**: Mengunggah lampiran tidak memicu aksi apa pun di UI dan file gagal disimpan di folder `storage/tmp/`.
* **Root Cause**: Penamaan file temporer menggunakan format `date('Y-m-d-H:i')` (menggunakan titik dua `:`). Karakter titik dua adalah karakter ilegal (terlarang) untuk nama file di filesystem Windows (NTFS), sehingga `Storage::disk('public')->putFileAs()` gagal menyimpan file secara diam-diam (silent failure) tanpa melempar exception PHP.
* **Perbaikan**: Mengubah format tanggal penamaan file secara dinamis agar kompatibel dengan lingkungan Windows dan Linux:
  ```php
  // $name = date('Y-m-d-H:i') . '-' . $file->getClientOriginalName(); // Linux/CentOS format
  $name = date('Y-m-d-Hi') . '-' . $file->getClientOriginalName(); // Windows compatible format
  ```

---

### 5. Route `edit-maker` Mengarah ke Komponen Lama
* **Status**: ✅ Fixed
* **File Terkait**: `Modules/DocumentSystem/Routes/web.php`
* **Masalah**: Pengunggahan file di form Edit Document tidak merespon AJAX upload.
* **Root Cause**: Route `edit-maker/{id}` dan endpoint `POST /files` masih mengarah ke kelas Livewire lama `AddnewMaker::class`. Kelas lama ini tidak memiliki method handler `saveFile()` dan `createdFiles()` untuk menangani penyimpanan file temporer.
* **Perbaikan**: Mengalihkan route edit dan callback file upload ke kelas Livewire aktif yang baru (`AddNewDocument::class`):
  ```php
  Route::post('/files', [AddNewDocument::class, 'saveFile'])->name('maker.files');
  Route::get('edit-maker/{id}', AddNewDocument::class)->name('edit-maker');
  ```

---

### 6. Dropdown Form Edit Kosong (Pre-Fill Select2 Dropdowns)
* **Status**: ✅ Fixed
* **File Terkait**: `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php`
* **Masalah**: Ketika membuka form edit dokumen, dropdown *Penanggung Jawab (PJ)*, *Category*, dan *Mapping* tampil kosong atau kembali ke default placeholder (unselected).
* **Root Cause**: Method `mount($id)` hanya memetakan value ID (`mapping_id`, `category_id`, `pic`, dll) ke variabel internal, namun tidak memuat daftar opsi dropdown terkait (`$categories`, `$mapping`, `$pics`). Karena daftar opsi (array) kosong, DOM HTML tidak merender elemen `<option>`, sehingga plugin Select2 tidak dapat menampilkan opsi terpilih.
* **Perbaikan**: Menambahkan logika pre-fill dinamis di dalam `mount($id)` untuk:
  * Memuat kategori berdasarkan `module_id`.
  * Memuat mapping berdasarkan `category_id`.
  * Memuat daftar PIC (`$pics`) dari `DepartmentCode` dan data departemen terkait.
  * Memanggil `$this->showEmployee()` untuk memicu pemuatan list karyawan.

---

### 7. Karakter Titik (`.`) di Depan Nama Category dan Mapping pada Dropdown Form
* **Status**: ✅ Fixed
* **File Terkait**: `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php`
* **Masalah**: Terdapat karakter titik tanpa angka (seperti `. SOP K3` dan `. SOP Working at Heights`) pada opsi pilihan dropdown Category dan Mapping.
* **Root Cause**: Query eager loading untuk `categories` dan `mappings` di dalam method `mount()` tidak menyeleksi kolom `index` (`categories:id,name,module_id`), sehingga nilainya bernilai `null`. Saat dirender di view blade, pemanggilan `{{ $category['index'] }}.` mencetak karakter titik kosong karena `index` bernilai `null`.
* **Perbaikan**: Menambahkan kolom `index` ke dalam list select eager loading `categories` dan `mappings` di `mount()`:
  ```php
  $this->modules = Module::select('id', 'index', 'name', 'has_document_number')
      ->with(['categories:id,index,name,module_id', 'categories.mappings:id,index,name,category_id'])
      ->get();
  ```

---

### 8. File Lampiran/Attachment Tidak Muncul di Dashboard List Views
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Resources/views/livewire/on-going/table-on-going.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/draft/index.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/obsolate/index.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/maker/table-maker.blade.php`
  * `Modules/DocumentSystem/Http/Livewire/OnGoing/TableOnGoing.php`
  * `Modules/DocumentSystem/Http/Livewire/Maker/TableMaker.php`
  * `Modules/DocumentSystem/Http/Livewire/Draft/Index.php`
  * `Modules/DocumentSystem/Http/Livewire/Obsolate/Index.php`
* **Masalah**: File lampiran/attachment tidak muncul di tabel daftar dokumen (Draft, On Review/On-Going, Active, maupun Obsolete).
* **Root Cause**: 
  1. Blade templates membatasi penampilan file dengan filter `@if ($name == 'Final')`. Karena file lampiran yang diunggah belum diproses (diberi tanda air/watermark) di tahap Draft atau Review, nama file tidak diawali dengan prefix `Final-`. Akibatnya, file-file tersebut tidak pernah ditampilkan.
  2. Komponen Livewire tidak melakukan eager loading terhadap relasi `attachments`, yang menyebabkan masalah performa (N+1 queries) dan menghalangi pemuatan data relasi secara optimal.
* **Perbaikan**:
  1. Menghapus filter `@if ($name == 'Final')` dari semua file Blade listing tersebut agar semua file lampiran aktif (`status = 1`) yang terkait dengan dokumen dapat ditampilkan secara langsung.
  2. Menambahkan eager loading `with(['attachments' => fn($q) => $q->where('status', 1), 'department.company', 'user', 'mapping.category.module'])` pada query `getListingsProperty()` di masing-masing komponen Livewire untuk memuat lampiran dan data relasi lainnya secara efisien.

---

### 9. Navigasi Detail & Dropdown Approval Dokumen Berstatus Preparing (PREPARE_ROOTING_REVIEW)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Resources/views/livewire/maker/detail-maker.blade.php`
  * `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php`
* **Masalah**: 
  1. Pengguna berstatus Approver (Level 2) melihat tombol "Edit Document" alih-alih dropdown "Document Action" berisi aksi Approve/Return saat melihat dokumen berstatus `Preparing` (`PREPARE_ROOTING_REVIEW` = 6) dari daftar On-Going.
  2. Ketika pembuat dokumen (maker) mengklik "Save as Draft" pada dokumen berstatus `PREPARE_ROOTING_REVIEW`, status dokumen tersebut secara tidak sengaja ter-update menjadi `ROOTING_REVIEW` (3) seolah-olah telah disubmit untuk review.
* **Root Cause**:
  1. Kondisi pengecekan tombol "Edit Document" di file Blade mendeteksi status `PREPARE_ROOTING_REVIEW` dan langsung merendernya untuk semua pengguna yang memiliki hak akses edit, tanpa mengecek apakah pengguna yang sedang login adalah pembuat dokumen asli (maker/creator). Selain itu, kondisi rendering untuk dropdown "Document Action" hanya membatasi akses Level 2 Approver untuk status `ROOTING_REVIEW`.
  2. Di dalam method `saveData` komponen `AddNewDocument`, status dokumen berstatus `PREPARE_ROOTING_REVIEW` diubah secara mutlak ke `ROOTING_REVIEW` tanpa mengecek parameter `$status` yang dikirim dari input (1 untuk submit review, 2 untuk save draft).
* **Perbaikan**:
  1. Mengubah kondisi pengecekan tombol "Edit Document" di `detail-maker.blade.php` agar hanya dirender jika dokumen berstatus `PREPARE_ROOTING_REVIEW` dilihat oleh pembuat dokumen asli (`auth()->user()->id == $detail->created_by || auth()->user()->id == $detail->user_id`).
  2. Memperbarui kondisi rendering dropdown action dan tipe aksi (`$type = 'final'`) agar muncul untuk Level 2 Approver saat dokumen berstatus `PREPARE_ROOTING_REVIEW` atau `ROOTING_REVIEW`.
  3. Memperbarui logika transisi status di `AddNewDocument.php` agar status dokumen `PREPARE_ROOTING_REVIEW` hanya beralih ke `ROOTING_REVIEW` jika parameter `$status` bernilai `1` (Submit for Review), dan tetap berstatus `PREPARE_ROOTING_REVIEW` jika bernilai `2` (Save as Draft).

---

### 10. Gagal Meng-approve PDF 1.5+ Karena Limitasi Kompresi FPDI
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Services/DocumentSystemService.php`
  * `Modules/DocumentSystem/Http/Livewire/Review/ReviewDetail.php`
* **Masalah**: Kegagalan ketika meng-approve dokumen dengan pesan error: `This PDF document probably uses a compression technique which is not supported by the free parser shipped with FPDI. (See https://www.setasign.com/fpdi-pdf-parser for more details) 257Failed to update document`.
* **Root Cause**: Versi gratis library parser FPDI tidak mendukung dokumen PDF versi 1.5 ke atas yang menggunakan metode kompresi modern (seperti *object streams* dan *compressed cross-reference streams*). Saat parser mencoba membaca/watermark dokumen tersebut, aplikasi melempar exception fatal dan merollback seluruh transaksi database persetujuan dokumen.
* **Perbaikan**:
  1. Membungkus seluruh proses pembacaan dan pembubuhan watermark PDF (`Fpdi`) ke dalam blok `try-catch` di `DocumentSystemService.php` dan `ReviewDetail.php`.
  2. Menambahkan *graceful fallback*: jika parser mendeteksi error kompresi, file PDF asli disalin secara langsung ke folder tujuan tanpa watermark, lalu dicatat sebagai warning di log. Ini mencegah terhambatnya alur persetujuan dokumen akibat limitasi parser.

---

### 11. Masalah Keterlambatan Input & Kehilangan Pilihan Dropdown Select2 (Livewire Lifecycle & Defer Optimization)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Resources/views/livewire/maker/add-new-document.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/jsa/create-new-document.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/jsa/create.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/ptw/create-new-document.blade.php`
  * `Modules/DocumentSystem/Resources/views/livewire/ptw/create.blade.php`
* **Masalah**: Input teks pada form memiliki delay/keterlambatan respons yang sangat parah ketika mengetik, dan pilihan dropdown karyawan (`listEmployee`) serta dropdown Select2 lainnya sering ter-reset (hilang pilihan) saat form diperbarui.
* **Root Cause**:
  1. Penggunaan `wire:model` langsung pada kolom teks non-reaktif memicu request AJAX ke server pada setiap ketukan keyboard, mengakibatkan antrean request yang sangat lambat (latency/network lag).
  2. Lifecycle re-initialization Select2 pada event `employeeDataUpdated` menggunakan perintah manual `.empty()` dan `.val(null)`, sehingga menghapus seluruh opsi dan pilihan aktif dari dropdown sebelum data baru dirender ulang.
* **Perbaikan**:
  1. Mengganti semua `wire:model` menjadi `wire:model.defer` pada input non-reaktif untuk menunda pengiriman data hingga tombol submit diklik.
  2. Mengoptimalkan komponen Select2 agar secara dinamis mendeteksi binding `.defer` dan memanggil `@this.set(name, value, true)` guna mencegah pengiriman request AJAX instan saat dropdown berubah.
  3. Memperbarui handler event `employeeDataUpdated` untuk mempertahankan pilihan karyawan yang sudah ada dari state Livewire (`@this.get('invitedPeople')`), menyaring daftar karyawan baru, dan mengatur ulang opsi dengan status terpilih (`isSelected`) yang tetap terjaga.

---

### 12. Exception Undefined Variable `$disabled` pada Komponen Select2
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Resources/views/components/inputs/select2.blade.php`
  * `resources/views/components/inputs/select2.blade.php`
* **Masalah**: Muncul pesan error fatal `ErrorException: Undefined variable $disabled` di halaman yang menggunakan komponen input select2 custom.
* **Perbaikan**: Mengembalikan deklarasi `@props` di bagian atas kedua file komponen select2 untuk memastikan properti tersebut terdaftar kembali secara benar dalam engine Laravel Blade.

---

### 13. Exception Undefined Array Key 0 Saat Menghapus Pilihan Select2 Company
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Http/Livewire/Maker/AddNewDocument.php`
  * `Modules/DocumentSystem/Http/Livewire/Jsa/CreateNewDocument.php`
  * `Modules/DocumentSystem/Http/Livewire/Jsa/Create.php`
  * `Modules/DocumentSystem/Http/Livewire/Ptw/CreateNewDocument.php`
  * `Modules/DocumentSystem/Http/Livewire/Ptw/Create.php`
* **Masalah**: Ketika user menghapus pilihan (mengklik ikon X) pada dropdown Select2 Company, aplikasi mengalami error fatal `ErrorException: Undefined array key 0` di server side.
* **Root Cause**: Method `updated($name, $value)` pada komponen Livewire memproses pembaruan data secara langsung tanpa memeriksa apakah `$value` kosong. Saat nilai kosong dikirimkan untuk `company_id`, kode tetap mencoba memfilter koleksi dan mengakses indeks ke-0 (`values()[0]`), yang memicu error karena koleksi hasil filter kosong.
* **Perbaikan**: Menambahkan validasi `if (empty($value))` di awal method `updated` untuk melakukan early return dan me-reset state variabel terkait (seperti `departments`, `pics`, `company_code`, dll.) secara aman jika input dihapus atau dikosongkan.

---

### 14. Dropdown Department Tertutup Otomatis & Menampilkan "No Results Found" Saat Memilih Company
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/DocumentSystem/Resources/views/components/inputs/select2.blade.php`
  * `resources/views/components/inputs/select2.blade.php`
* **Masalah**: Jika user sedang membuka dropdown Select2, dropdown tersebut tiba-tiba tertutup otomatis saat terjadi re-render / hydrate dari Livewire (seperti ketika ada request AJAX lain, background validation, atau pengubahan field non-reaktif).
* **Root Cause**: Setiap kali Livewire selesai memproses request (hydrate), komponen akan memancarkan event `select2` global yang men-trigger re-inisialisasi seluruh input Select2 di halaman. Proses ini memanggil `.select2('destroy')` dan kemudian menginisialisasi ulang widget, sehingga menghancurkan dropdown Select2 yang sedang terbuka.
* **Perbaikan**: Mengimplementasikan kombinasi `wire:ignore` dan `wire:key` dinamis berbasis hash MD5 dari konten opsi (`$slot`), ditambah mekanisme **Cascading Client-side Lock** dan sinkronisasi atribut `:disabled` di tingkat form.
  1. **DOM Preservation**: Kontainer `<select>` dibungkus menggunakan `<div wire:ignore wire:key="{{ $wireKey }}">` di mana `$wireKey` dihitung dari `md5((string) $slot)`. Ini memastikan Livewire tidak memanipulasi widget Select2 kecuali list opsinya benar-benar berubah dari server.
  2. **Inisialisasi Bersyarat**: Script JavaScript hanya akan menginisialisasi Select2 jika elemen belum memiliki kelas `.select2-hidden-accessible`. Nilai dari server disinkronkan hanya ketika ada perbedaan nilai, menghindari reset paksa.
  3. **Cascading Client-side Lock**: Menggunakan atribut `data-child` yang mendukung format comma-separated untuk multiple children (misal: `data-child="department_id,listEmployee"`). Ketika parent berubah di client:
     * Nilai seluruh select anak (child) langsung dikosongkan (`$child.val(null)`).
     * Select anak langsung di-nonaktifkan secara visual & interaksi (`prop('disabled', true)` dan penambahan kelas `.select2-container--disabled` dengan `pointer-events: none`).
     * Event `change` di-cascade turun sampai ke cucu (grandchildren) untuk mengunci seluruh rantai input.
     * Ini mencegah pengguna membuka dropdown kosong ("No results found") sebelum request Livewire selesai diproses di server.
  4. **Form-level Disabled Sync**:
     * Menambahkan atribut `:disabled="empty($parent_id)"` di level file Blade form (`add-new-document.blade.php`, `addnew.blade.php`, `create.blade.php`, `create-new-document.blade.php` untuk JSA/PTW).
     * Menerapkan pattern cascading ini untuk:
       * **Owner Chain**: `company_id` $\rightarrow$ `department_id` $\rightarrow$ `pic`.
       * **Mapping Chain**: `module_id` $\rightarrow$ `category_id` $\rightarrow$ `mapping_id`.
       * **Invited People**: `company_id` $\rightarrow$ `listEmployee` (di-reset dan dikunci jika Company kosong, kemudian dibuka kembali secara visual dan dipolusi isinya di event handler JS `employeeDataUpdated` ketika data terisi).

---

### 15. Attempt to read property "koBrand" on null di updatedUnitId() (Modul KO)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/KO/Http/Livewire/Ko/CreateProposal.php`
  * `Modules/KO/Http/Livewire/Ko/Draft/EditProposal.php`
  * `Modules/KO/Http/Livewire/Ko/Returned/EditProposal.php`
* **Masalah**: Ketika pengguna mengubah atau mengosongkan pilihan Unit (`unit_id`), aplikasi melempar error `Attempt to read property "koBrand" on null`.
* **Root Cause**: Method `updatedUnitId()` memanggil `KoUnit::find($this->unit_id)` tanpa memeriksa apakah hasilnya `null`. Jika `$unit_id` kosong, `$unit` bernilai `null` dan memicu error saat mengakses relasi `$unit->koBrand`. Selain itu, variabel penampung di `CreateProposal.php` dideklarasikan dengan tipe data strict `string` (misal: `public string $brand`), sehingga jika relasi atau nilai properti bernilai `null`, Laravel/PHP akan melempar `TypeError`.
* **Perbaikan**: Menggunakan null-safe operator (`?->`) dan operator null coalescing (`??`) untuk memberikan nilai default berupa string kosong (`''`) atau strip (`'-'`) jika unit atau relasi `koBrand` bernilai `null`.

---

### 16. Keterlambatan Respons / Lag Saat Mengubah Dropdown Kondisi Komisioning (Modul KO)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/KO/Resources/views/livewire/commissioning/create-commissioning.blade.php`
  * `Modules/KO/Resources/views/livewire/commissioning/edit-commissioning.blade.php`
* **Masalah**: Mengubah dropdown pilihan kondisi komisioning ("Baik", "Gagal", "N/A") terasa lambat (lag/delay) dan memicu kedipan/freeze pada halaman.
* **Root Cause**:
  1. Penggunaan `wire:model` langsung pada elemen select memicu request AJAX ke server setiap kali user mengubah pilihan kondisi untuk melakukan sinkronisasi instan.
  2. Adanya conditional rendering menggunakan `@if` Blade untuk menampilkan textarea keterangan/note dan input file attachment saat kondisi bernilai "Gagal" memaksa server merender ulang seluruh baris tabel yang sangat banyak di setiap AJAX request.
  3. Keberadaan class `select2` yang tidak terinisialisasi secara fungsional di dropdown kondisi menyebabkan overhead parsing pada DOM.
* **Perbaikan**:
  1. Mengubah binding select box kondisi dari `wire:model` menjadi `wire:model.defer` untuk menunda sinkronisasi ke server hingga tombol submit ditekan.
  2. Menghapus class `select2` agar dropdown dirender sebagai HTML select bawaan yang super cepat.
  3. Mengimplementasikan komponen **Alpine.js** (`x-data`, `x-show`, `x-cloak`) pada tingkat baris (`<tr>`) untuk menyembunyikan/menampilkan textarea note dan input file attachment secara instan di sisi klien (0ms delay).
  4. Menggunakan sintaks double-colon `::required="condition == 'Gagal'"` agar browser hanya memvalidasi input note/file jika kondisi bernilai "Gagal" (visible).

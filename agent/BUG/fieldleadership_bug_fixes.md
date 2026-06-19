# AIMS Field Leadership — Bug Fixes Log

Dokumen ini mencatat seluruh perbaikan kutu (bug fixes) yang diidentifikasi dan diselesaikan pada modul **Field Leadership** di platform AIMS selama proses pengembangan dan pengujian lokal.

---

## 📋 Ringkasan Kumpulan Perbaikan Kutu

### 1. Error Null Reference pada Limit Parameter Modul Field Leadership
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Resources/views/livewire/listing/pja/detail-pja-page.blade.php`
  * `Modules/FieldLeadership/Resources/views/livewire/listing/document/active/detail-field-leadership-page.blade.php`
  * `Modules/FieldLeadership/Resources/views/livewire/listing/approval/detail-review-page.blade.php`
* **Penjelasan Bug**:
  Ketika halaman detail dibuka, sistem memuat parameter batas (limit parameter) modul Field Leadership untuk validasi jumlah maksimum item. Namun, apabila admin belum mendefinisikan/memasukkan data Limit Parameter di menu Master Library, variabel `$limit_param` bernilai `null`. Hal ini memicu crash runtime fatal berupa `ErrorException: Attempt to read property "max_item_member" on null`.
* **Perbaikan & Potongan Kode**:
  Menggunakan operator null-safe (`?->`) dan null coalescing (`??`) untuk mencegah crash dan menampilkan visual warning banner jika data limit belum di-set di master data.

  *Sebelum (Crash jika null)*:
  ```html
  <span class="text-danger">{{ $limit_param->max_item_member }}</span>
  ```

  *Sesudah (Aman & Null-Safe)*:
  ```html
  @if (!$limit_param)
      <div class="alert alert-warning py-2 px-3 mb-3 d-flex align-items-center gap-2" role="alert" style="border-left: 4px solid #ffc107; background-color: #fff3cd; color: #664d03;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          <div>
              <strong>Perhatian!</strong> Limit Parameter belum dibuat di Master Data. Silakan buat Limit Parameter terlebih dahulu di menu Master Library agar sistem dapat berfungsi dengan normal.
          </div>
      </div>
  @endif
  ...
  <span class="text-danger">{{ $limit_param?->max_item_member ?? 0 }}</span>
  ```

---

### 2. Migrasi Metode Pengunggahan File ke Azure Blob Storage
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Http/Livewire/Listing/Pja/EditPjaPage.php`
  * `Modules/FieldLeadership/Http/Livewire/Listing/Pja/DetailPjaPage.php`
  * `Modules/FieldLeadership/Http/Livewire/Listing/Document/Active/DetailActiveFieldLeadershipPage.php`
  * `Modules/FieldLeadership/Http/Livewire/Listing/Approval/DetailRequestApprovalPage.php`
* **Penjelasan Bug**:
  Sebelumnya, sistem masih mengunggah file ke direktori penyimpanan lokal server (`Storage::disk('public')->putFileAs()`). Hal ini tidak selaras dengan infrastruktur produksi AIMS yang menggunakan Azure Blob Storage sebagai media penyimpanan utama yang terpusat.
* **Perbaikan & Potongan Kode**:
  Mengalihkan proses penyimpanan file lampiran baru untuk menggunakan `uploadToBlobStorage` dari helper `app/Helpers/general.php` agar tersimpan secara aman di Azure Blob Storage, dan mengupdate kolom database yang bersesuaian dengan URL blob.

  *Sebelum (Penyimpanan Lokal)*:
  ```php
  $path = Storage::disk('public')->putFileAs('field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id, $file['file'], $file['file']->getClientOriginalName());
  ```

  *Sesudah (Penyimpanan Azure Blob Storage)*:
  ```php
  $filename = $file['file']->getClientOriginalName();
  $filePathTemp = $file['file']->getRealPath();
  $directPath = 'field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id;

  $blobResult = uploadToBlobStorage($filename, $filePathTemp, $directPath);

  $path = $blobResult['fileBlobPathName'] ?? ('field-leadership/' . $this->fieldLeadership->id . '/risk-condition/' . $riskCondition->id . '/' . $filename);
  $blobUrl = $blobResult['fileBlobUrl'] ?? null;
  $blobResponse = $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null;
  ```

---

### 3. Integrasi Preview File Modal dengan SAS Token Secure URL
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Http/Controllers/General/GeneralController.php`
  * `Modules/FieldLeadership/Resources/views/layouts/base.blade.php`
  * `Modules/FieldLeadership/Resources/views/layouts/master.blade.php`
  * `Modules/FieldLeadership/Resources/views/layouts/partials/preview-modal.blade.php`
* **Penjelasan Bug**:
  Ketika pengguna ingin melihat pratinjau (preview) file lampiran di modul Field Leadership, aplikasi tidak merespons atau gagal memuat file karena file disimpan secara private di Azure Blob Storage dan memerlukan SAS Token temporer agar dapat dibaca oleh browser. Modul juga belum memiliki modal pratinjau bawaan dan controller belum mendeteksi file aktivitas (`FieldLeadershipActivityFile`).
* **Perbaikan & Potongan Kode**:
  1. Membuat method `getFileSasUri` di controller untuk menjembatani pembuatan token SAS aman untuk `FieldLeadershipRiskFile` dan `FieldLeadershipActivityFile`.
  2. Menyertakan partial layout modal preview dan script Javascript pemanggil di base layout modul.

  *Controller Endpoint (`GeneralController.php`)*:
  ```php
  public function getFileSasUri($id, Request $request)
  {
      try {
          $type = $request->query('type', 'risk');
          if ($type === 'activity') {
              $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipActivityFile::find($id);
          } else {
              $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipRiskFile::find($id);
          }

          if (!$attachment) {
              return response()->json(['error' => 'Attachment not found'], 404);
          }

          $url = $attachment->blob_url ?? $attachment->file ?? '';
          ...
      }
  }
  ```

---

### 4. Keterlambatan Respons / Lag Parah pada Form Input & Select2 (Modul Field Leadership)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Resources/views/livewire/...` (Form creation & edit blade views)
* **Masalah**:
  Setiap kali pengguna mengetik teks di input/textarea atau mengubah dropdown Select2, terjadi jeda respon browser yang sangat mengganggu (freezing/lag). Ini disebabkan oleh penggunaan standar `wire:model` yang memicu server roundtrip via AJAX untuk setiap ketukan karakter.
* **Perbaikan & Potongan Kode**:
  Mengubah semua binding reaktif real-time menjadi `.defer` pada elemen input statis.

  *Sebelum (Memicu AJAX per huruf)*:
  ```html
  <input type="text" wire:model="max_member" class="form-control" />
  ```

  *Sesudah (Ditunda hingga Submit)*:
  ```html
  <input type="text" wire:model.defer="max_member" class="form-control" />
  ```

---

### 5. Delay Checkbox / Radio Button Row Selection pada Tabel Master Library
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Resources/views/livewire/master-library/limit-parameter/partials/table-maker.blade.php`
  * (Serta file `table-maker.blade.php` untuk Type KTA/TTA, Potency Consequence, dan Category)
* **Masalah**:
  Ketika pengguna mencentang radio button atau menyeleksi baris tabel, visual tanda centang dan tombol Export/Delete memerlukan waktu hingga 2-3 detik untuk muncul.
* **Root Cause**:
  1. Livewire melakukan komunikasi bolak-balik ke server via AJAX hanya untuk mengubah satu variabel array seleksi (`itemSelected`) dan memperbarui class baris `selected`.
  2. Terjadi penjalaran event (*event bubbling*): Klik pada kolom teks edit juga memicu event klik baris (`onSelectedItem()`), sehingga browser mengirim dua request AJAX sekaligus dan membebani server secara ganda.
* **Perbaikan & Potongan Kode**:
  Mengalihkan penanganan visual seleksi dan toolbar secara instan menggunakan **AlpineJS** di sisi klien dan menunda sinkronisasi Livewire menggunakan `.defer`.

  *Sebelum (Lambat karena AJAX)*:
  ```html
  <tr wire:click="onSelectedItem('{{ $items->id }}')" class="@if (in_array($items->id, $itemSelected)) selected @else tr @endif">
      <td class="td-check"><span class="icon-checked"></span></td>
      <td wire:click="edit('{{ $items->id }}')">{{ $items->max_item_member }}</td>
  </tr>
  ```

  *Sesudah (Instan 0ms dengan AlpineJS + Defer)*:
  ```html
  <tr @click="toggleItem('{{ $items->id }}')" :class="itemSelected.includes(String('{{ $items->id }}')) ? 'selected' : 'tr'">
      <td class="td-check"><span class="icon-checked"></span></td>
      <td wire:click.stop="edit('{{ $items->id }}')">{{ $items->max_item_member }}</td>
  </tr>
  ```

---

### 6. Duplikasi Query Database Berulang pada Render Cycle TableMaker
* **Status**: ✅ Fixed
* **File Terkait**:
  - `Modules/FieldLeadership/Http/Livewire/MasterLibrary/LimitParameter/Partials/TableMaker.php`
  - (Dan file TableMaker component untuk Type KTA/TTA, Potency Consequence, dan Category)
* **Penjelasan Bug**:
  Livewire mengevaluasi computed properties (misal: `$this->parameters`) setiap kali properti tersebut dipanggil di dalam file Blade view. Karena diakses beberapa kali (untuk memeriksa total data, mengambil daftar ID, mencocokkan jumlah centang, dan perulangan loop `@foreach`), query database `FieldLeadershipParameter::all()` berjalan berulang kali (3-4 kali) dalam satu HTTP request yang sama. Hal ini membebani server secara tidak perlu.
* **Perbaikan & Potongan Kode**:
  Menyimpan hasil query ke dalam variabel internal cache sehingga evaluasi berikutnya dalam satu request yang sama hanya mengembalikan data cache.

  *Sesudah (Hanya 1x Query - Ter-cached)*:
  ```php
  private $cachedParameters = null;

  public function getParametersProperty()
  {
      if ($this->cachedParameters === null) {
          $this->cachedParameters = FieldLeadershipParameter::all();
      }
      return $this->cachedParameters;
  }
  ```

---

### 7. Latency / Loading Sangat Lambat Saat Refresh Halaman Listing (Active & Draft)
* **Status**: ✅ Fixed
* **File Terkait**:
  - `Modules/FieldLeadership/Http/Livewire/Listing/Document/Active/Partials/TableMaker.php`
  - `Modules/FieldLeadership/Http/Livewire/Listing/Document/Draft/Partials/TableMaker.php`
* **Penjelasan Bug**:
  Membuka atau menyegarkan (refresh) halaman listing Active dan Draft dokumen memerlukan waktu lama (delay/freeze visual).
* **Root Cause**:
  1. Di dalam method `mount()`, sistem memanggil `FieldLeadership::get()` secara mentah sebanyak 7-8 kali. Hal ini menarik **seluruh baris data tabel** dari database ke dalam memori PHP, baru kemudian memfilter dan mengelompokkan data menggunakan koleksi PHP. Proses ini sangat lambat dan memakan memori (RAM) besar seiring bertambahnya data.
  2. Terjadi masalah N+1 Query pada tabel `@foreach` di Blade karena data relasi (seperti `company`, `ccow`, `department`, `section`, `areaLocation`, `risks.category`, `risks.type`, `risks.potency`, `members.employee`, `positives`) dimuat secara dinamis per baris tanpa di-eager-load.
  3. Computed property `$this->activeListings` dipanggil beberapa kali dalam satu siklus render, menyebabkan query paginasi dievaluasi berulang kali.
* **Perbaikan & Potongan Kode**:
  1. Mengubah filter pemuatan dropdown di `mount()` menjadi query tingkat database (menggunakan SQL `select`, `whereIn`, `groupBy`).
  2. Menambahkan eager loading `with([...])` pada query listing.
  3. Menambahkan caching pada computed property `$this->activeListings`.

  *Sebelum (Mengambil Seluruh Tabel ke Memori)*:
  ```php
  $this->fieldCompany = FieldLeadership::get()
      ->where('created_by', auth()->user()->employee?->id)
      ->groupBy('company_id')
      ->map(function ($item) {
          return $item->first()->company;
      });
  ```

  *Sesudah (Query Spesifik Tingkat DB - Cepat & Ringan)*:
  ```php
  $this->fieldCompany = Company::whereIn('id', function ($query) use ($employeeId) {
      $query->select('company_id')
          ->from('field_leaderships')
          ->where('created_by', $employeeId)
          ->whereNotNull('company_id');
  })->get();
  ```

  *Eager Loading & Caching*:
  ```php
  private $cachedActiveListings = null;

  public function getActiveListingsProperty(): LengthAwarePaginator
  {
      if ($this->cachedActiveListings === null) {
          $this->cachedActiveListings = FieldLeadership::with(['company', 'ccow', 'department', 'section', 'areaLocation', 'risks.category', 'risks.type', 'risks.potency', 'members.employee', 'positives'])
              ...
              ->paginate($this->limit);
      }
      return $this->cachedActiveListings;
  }
  ```

---

### 8. N+1 Query & Caching pada Halaman Pembuatan/Edit Dokumen (Create & Edit Page)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Http/Livewire/Listing/Document/Active/CreateActiveFieldLeadershipPage.php`
  * `Modules/FieldLeadership/Http/Livewire/Listing/Document/Active/EditActiveFieldLeadershipPage.php`
* **Penjelasan Bug**:
  Setiap kali terjadi Livewire roundtrip, properti computed untuk dropdown dipanggil berulang kali di file Blade. Terlebih lagi, data dropdown PJA (`AreaManager`) memanggil relasi `user` di loop Blade secara dinamis per baris (N+1 Query) sehingga memicu puluhan query tambahan yang memperlambat respon server.
* **Perbaikan & Potongan Kode**:
  1. Menambahkan properti internal cache untuk seluruh computed getters.
  2. Membatasi select data hanya ke kolom database yang dibutuhkan (`id` dan `name` / `company_name`).
  3. Menggunakan Eager Loading (`with('user:id,name')`) pada model `AreaManager`.

  *Sebelum (N+1 Query & No Cache)*:
  ```php
  public function getAreaManagersProperty()
  {
      return AreaManager::where('section_id', $this->section_id)->get();
  }
  ```

  *Sesudah (Cached & Eager Loaded)*:
  ```php
  private $cachedAreaManagers = null;

  public function getAreaManagersProperty()
  {
      if ($this->cachedAreaManagers === null) {
          $this->cachedAreaManagers = AreaManager::with('user:id,name')->where('section_id', $this->section_id)->get();
      }
      return $this->cachedAreaManagers;
  }
  ```

---

### 9. Loop Request Redundan / Concurrent Latency pada Event Change Select2
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Resources/views/components/inputs/select2-field-leadership.blade.php`
  * `Modules/FieldLeadership/Resources/views/components/inputs/select2-avatar.blade.php`
* **Penjelasan Bug**:
  Pilihan dropdown Select2 memicu event `change` yang mengirimkan request server via Livewire (`@this.set`). Namun, saat server mengembalikan respon, input Select2 re-render dan men-trigger event `change` programmatik kembali. Hal ini memicu loop request paralel redundan. Pada web server single-thread seperti bawaan PHP / Laragon, request yang menumpuk ini saling memblokir (*blocking*), mengakibatkan freeze / delay halaman hingga 4-5 detik.
* **Perbaikan & Potongan Kode**:
  Menambahkan pengecekan kesamaan nilai (`isSame` check) sebelum memanggil `@this.set` ke Livewire. Jika nilai input baru sama dengan nilai di Livewire server, request tidak akan dikirim.

  *Sebelum (Memicu AJAX Tanpa Cek Nilai)*:
  ```javascript
  $el.on('change.select2-hook', function(e) {
      @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
  });
  ```

  *Sesudah (Cek Nilai - Bebas Loop/Freeze)*:
  ```javascript
  $el.on('change.select2-hook', function(e) {
      const currentVal = @this.get('{{ $modelName }}');
      const isSame = (currentVal == e.target.value) || 
                     ((currentVal === null || currentVal === undefined || currentVal === '') && 
                      (e.target.value === null || e.target.value === undefined || e.target.value === ''));
      if (!isSame) {
          @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
      }
  });
  ```

---

### 10. Preview File Blob Storage Lambat / Gagal Render Inline (PDF & Gambar)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Http/Controllers/General/GeneralController.php`
* **Penjelasan Bug**:
  Ketika pengguna mengklik tombol preview file lampiran, browser mengunduh (download) file alih-alih menampilkannya secara inline. Selain itu terjadi delay sangat lama sebelum konten muncul. Hal ini disebabkan oleh 3 masalah sekaligus:
  1. **`get_headers($url, 1)`** — Membuat HTTP HEAD request tambahan ke Azure sebelum streaming dimulai, menambah latensi ~1–3 detik per preview.
  2. **`fopen() + fpassthru()`** — Membuffer seluruh konten file ke memori PHP sebelum dikirim ke browser, berpotensi OOM (Out of Memory) untuk file besar.
  3. **Content-Type salah** — `get_headers()` terkadang mengembalikan `application/octet-stream` untuk blob URL, sehingga browser memaksa download alih-alih render inline.
  4. **Local fallback tidak tepat** — Menggunakan `public_path()` langsung tanpa deteksi MIME yang benar via Laravel Storage.

* **Perbaikan & Potongan Kode**:
  Mengadopsi pola streaming DocumentSystem — menggunakan **GuzzleHttp** chunked streaming dan memaksa `Content-Type` berdasarkan ekstensi file (bukan dari `get_headers`), serta lokal fallback menggunakan `Storage::disk('public')` untuk deteksi MIME yang tepat.

  *Sebelum (Lambat & Buffer Penuh)*:
  ```php
  // Membuat extra HTTP request (lambat ~1-3 detik)
  $headers = get_headers($url, 1);
  if (isset($headers['Content-Type'])) {
      $contentType = is_array($headers['Content-Type'])
          ? end($headers['Content-Type'])
          : $headers['Content-Type'];
  }

  // Buffer seluruh file ke memori PHP (berisiko OOM)
  return response()->stream(function () use ($url) {
      $stream = fopen($url, 'r');
      if ($stream) {
          fpassthru($stream); // Baca semua dulu baru kirim
          fclose($stream);
      }
  }, 200, [
      'Content-Type' => $contentType,   // Sering salah: application/octet-stream
      'Content-Disposition' => 'inline; filename="' . $fileName . '"',
  ]);

  // Fallback lokal tanpa MIME detection
  $path = public_path('storage/' . $attachment->file);
  if (!file_exists($path)) {
      abort(404, 'File not found locally');
  }
  return response()->file($path); // Tanpa Content-Type header
  ```

  *Sesudah (Cepat, Chunked, Inline — adopsi pola DocumentSystem)*:
  ```php
  use GuzzleHttp\Client;
  use Illuminate\Support\Facades\Storage;

  // Stream chunked via GuzzleHttp — tidak buffer seluruh file ke RAM
  $fileName = basename($attachment->file);
  $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  $client = new Client;
  $response = $client->request('GET', $url, ['stream' => true]);
  $body = $response->getBody();
  $contentType = $response->getHeaderLine('Content-Type');

  // Force Content-Type berdasarkan ekstensi agar browser render inline
  if ($ext === 'pdf') {
      $contentType = 'application/pdf';
  } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
      $contentType = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);
  }

  return response()->stream(function () use ($body) {
      while (!$body->eof()) {
          echo $body->read(1024 * 8); // Kirim chunk 8KB sekaligus, hemat RAM
          flush();
      }
  }, 200, [
      'Content-Type'        => $contentType, // Selalu tepat per ekstensi
      'Content-Disposition' => 'inline; filename="' . $fileName . '"',
      'Cache-Control'       => 'no-cache, no-store, must-revalidate',
  ]);

  // Fallback lokal dengan MIME detection via Laravel Storage
  $clean_path = $attachment->file;
  if (Storage::disk('public')->exists($clean_path)) {
      $mime = Storage::disk('public')->mimeType($clean_path);
      return response()->file(Storage::disk('public')->path($clean_path), [
          'Content-Type'        => $mime,
          'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
      ]);
  }
  abort(404, 'File not found locally');
  ```

* **Ringkasan Perubahan**:

  | Aspek | Sebelum | Sesudah |
  |---|---|---|
  | Extra HTTP request | `get_headers()` (+1–3 detik) | Dihapus |
  | Streaming method | `fpassthru()` (full buffer RAM) | GuzzleHttp chunked 8KB |
  | Content-Type | Dari header Azure (sering salah) | Dipaksa per ekstensi file |
  | Local fallback | `public_path()` tanpa MIME | `Storage::disk('public')->mimeType()` |

---

### 11. Checkbox Row Listing Freeze — Tombol Export/Edit/Delete Delay Muncul (Active & Draft)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/FieldLeadership/Resources/views/livewire/listing/document/active/partials/table-maker.blade.php`
  * `Modules/FieldLeadership/Resources/views/livewire/listing/document/draft/partials/table-maker.blade.php`
* **Penjelasan Bug**:
  Ketika pengguna mengklik baris tabel (checkbox seleksi) di halaman listing dokumen Active & Draft Field Leadership, antarmuka membeku (freeze) selama 1–3 detik. Tombol **Export**, **Delete**, dan **Edit** baru muncul setelah freeze selesai. Selain itu, penggunaan `x-show` dengan `x-cloak` terkadang menyebabkan flash of unstyled content (tombol berkelebat muncul lalu hilang) saat Alpine belum sepenuhnya terinisialisasi.
* **Root Cause**:
  1. Setiap klik baris memanggil `wire:click="onSelectedItem('id')"` yang mengirim **AJAX round-trip ke server Livewire**. Server memproses request, memperbarui `$itemSelected[]` dan `$countSelected`, lalu me-render ulang seluruh komponen tabel.
  2. Element toolbar yang menggunakan `x-show` render secara sinkronus di HTML, sehingga jika Alpine.js terhambat inisialisasi, tombol-tombol tersebut akan muncul terus secara default sebelum Alpine menyembunyikannya.
* **Perbaikan & Potongan Kode**:
  Seluruh logika seleksi baris dipindah ke **Alpine.js** (client-side, 0ms). Sinkronisasi ke Livewire (`$wire.set()`) **hanya terjadi saat klik Export atau Delete** — bukan saat checkbox diklik.
  Untuk mengatasi masalah tombol yang muncul terus saat load halaman (FOUC), digunakan struktur `<template x-if="...">` berbasis state Alpine (mengikuti pola proven dari `master-library/limit-parameter`). Dengan `<template x-if="...">`, elemen tombol **tidak akan pernah dirender ke dalam DOM** oleh browser sampai kondisi terpenuhi (jumlah selected > 0), sehingga mencegah glitch visual/flash tanpa butuh `x-cloak` lagi.

  *Sebelum (Freeze karena AJAX per klik & Tombol Muncul Terus saat Load)*:
  ```html
  <!-- @entangle sync ke server tiap perubahan -->
  <div x-data="{ itemSelected: @entangle('itemSelected') }">

      <!-- Toolbar: render ulang PHP saat countSelected berubah -->
      @if ($countSelected > 0)
          <a wire:click="exportExcel()">Export</a>
          <a wire:click="$emit('remove-item')">Delete</a>
      @endif

      @if ($countSelected == 1)
          <a href="{{ route('...edit', $itemSelected) }}">Edit</a>
      @endif

      <!-- Setiap klik baris = AJAX roundtrip ke server = FREEZE -->
      <tr wire:click="onSelectedItem('{{ $items->id }}')"
          @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
  ```

  *Sesudah (Instant 0ms dengan Alpine.js + `<template x-if>` untuk Keamanan DOM)*:
  ```html
  <!-- Alpine state murni — tidak sync ke Livewire secara realtime -->
  <div x-data="{
      selectedIds: [],
      get countSelected() { return this.selectedIds.length; },
      get editUrl() {
          return this.selectedIds.length === 1
              ? '{{ url('field-leadership/listing/active/edit') }}/' + this.selectedIds[0]
              : '#';
      },
      toggleRow(id) {
          const idx = this.selectedIds.indexOf(id);
          if (idx === -1) this.selectedIds.push(id);
          else this.selectedIds.splice(idx, 1);
      },
      isSelected(id) { return this.selectedIds.includes(id); },
      syncToWire() {
          // Sync ke Livewire HANYA saat Export/Delete — bukan saat klik row
          $wire.set('itemSelected', this.selectedIds);
          $wire.set('countSelected', this.selectedIds.length);
      },
      clearSelection() {
          this.selectedIds = [];
          $wire.call('removeSeleced');
      }
  }">
      <!-- Toolbar: Menggunakan template x-if agar tombol tidak muncul default saat load -->
      <template x-if="selectedIds.length > 0">
          <div class="d-flex gap-2 align-items-center">
              <a href="#" type="button"
                 @click.prevent="syncToWire(); $nextTick(() => $wire.call('exportExcel'))">
                  Export
              </a>
              <a href="#" type="button"
                 @click.prevent="syncToWire(); $nextTick(() => $wire.$emit('remove-item'))">
                  Delete
              </a>
          </div>
      </template>

      <!-- Edit URL dihitung Alpine, aman untuk multi-select -->
      <template x-if="selectedIds.length === 1">
          <a :href="editUrl">Edit</a>
      </template>

      <!-- Counter text via Alpine template x-if -->
      <template x-if="selectedIds.length > 0">
          <span x-text="selectedIds.length + ' Row Selected'"
                @click.prevent="clearSelection()">
          </span>
      </template>

      <!-- Klik baris = Alpine toggleRow(), 0ms, TIDAK mengirim ke server -->
      <tr @click="toggleRow('{{ $items->id }}')"
          :class="isSelected('{{ $items->id }}') ? 'selected' : 'tr'"
          style="cursor: pointer;">
  ```

* **Ringkasan Perubahan**:

  | Aspek | Sebelum | Sesudah |
  |---|---|---|
  | Row click handler | `wire:click="onSelectedItem()"` → AJAX | `@click="toggleRow()"` → Alpine 0ms |
  | Row class binding | `@if (in_array($id, $itemSelected))` → PHP | `:class="isSelected(id)"` → Alpine |
  | Toolbar visibility | `@if ($countSelected > 0)` → PHP / `x-show` | `<template x-if="selectedIds.length > 0">` |
  | Edit URL | `route(..., $itemSelected)` → error multi | `:href="editUrl"` → Alpine computed |
  | Counter row selected | `{{ $countSelected }}` → PHP | `<template x-if>` + `x-text` |
  | Sync ke Livewire | Setiap klik baris | Hanya saat tombol Export/Delete diklik |

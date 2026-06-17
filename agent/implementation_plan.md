# Implementation Plan - File Preview Modal (PDF, DOCX, XLSX, PNG, JPG)

Implementasi modal preview interaktif untuk berkas lampiran sistem dokumen dengan memanfaatkan Azure Blob Storage SAS URI melalui fungsi `GetBlobSasUri` dan penayangan secara inline menggunakan streaming server-side untuk PDF/Gambar guna menghindari download otomatis.

## User Review Required

> [!NOTE]
> Kita menambahkan dua endpoint controller baru di `GeneralController` untuk me-resolve SAS URL asinkron (AJAX/Fetch) untuk dokumen MS Office dan melakukan server-side streaming untuk berkas PDF/Gambar agar bisa dipreview inline secara aman tanpa memicu browser auto-download.

> [!IMPORTANT]
> Untuk file `.docx` dan `.xlsx`, preview tetap menggunakan **Office Online Viewer Embed** (`https://view.officeapps.live.com/op/embed.aspx?src=...`) dengan melampirkan SAS URI yang telah di-encode. Hal ini membutuhkan akses internet dari sisi klien untuk render.

## Proposed Changes

### Backend Route & Controller

#### [MODIFY] [web.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Routes/web.php)
* Tambahkan route baru untuk fetch SAS URL secara dinamis berdasarkan attachment ID dan tipe attachment.
* Tambahkan route preview stream baru untuk penayangan inline PDF/Gambar.
```php
Route::get('attachments/{id}/sas', [GeneralController::class, 'getAttachmentSasUri'])->name('attachments.sas-uri');
Route::get('attachments/{id}/preview', [GeneralController::class, 'previewAttachment'])->name('attachments.preview');
```

#### [MODIFY] [GeneralController.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Http/Controllers/GeneralController.php)
* Tambahkan function `getAttachmentSasUri($id)` untuk mengembalikan metadata berkas dan SAS URL aslinya.
* Tambahkan function `previewAttachment($id)` untuk membaca file (dari Azure / lokal) dan men-stream datanya secara langsung ke klien dengan header `Content-Disposition: inline` dan `Content-Type` yang tepat (misalnya `application/pdf` atau `image/jpeg`).

---

### Frontend Components

#### [NEW] [preview-modal.blade.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Resources/views/layouts/partials/preview-modal.blade.php)
* Buat file partial modal bootstrap baru yang cantik untuk menampilkan preview.
* Modal ini mendeteksi ekstensi file:
  - `.pdf`: Ditampilkan dengan `<iframe>`
  - `.png`, `.jpg`, `.jpeg`: Ditampilkan dengan `<img>` tag
  - `.docx`, `.xlsx`: Ditampilkan dengan `<iframe>` melalui Office Online Viewer.

#### [MODIFY] [master.blade.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Resources/views/layouts/master.blade.php)
* Include file modal preview di bagian bawah layout master agar bisa dipanggil dari halaman manapun.
* Tambahkan JavaScript helper global `previewBlobFile(id, fileName, type)` untuk membuka modal preview:
  - Mengambil tipe ekstensi berkas dari endpoint `/sas`.
  - Jika tipe PDF atau Gambar, langsung arahkan sumber render (`iframe.src` atau `img.src`) ke route streaming `/preview?type=...`.
  - Jika MS Office, gunakan Office Online Viewer yang mengonsumsi SAS URL mentah.
* Menambahkan listener event `hidden.bs.modal` untuk membersihkan `.src` dari iframe/image dan melepas object references guna mencegah kebocoran memori.

#### [MODIFY] [table-maker.blade.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Resources/views/livewire/maker/table-maker.blade.php)
* Ubah link tag `<a>` attachment menjadi pemanggilan function javascript preview, misalnya:
  ```html
  <a href="javascript:void(0)" onclick="previewBlobFile('{{ $attachment->id }}', '{{ $attachment->file_name }}', 'document')" class="d-block">
      {{ $attachment->file_name }}
  </a>
  ```

* Lakukan perubahan serupa untuk view tabel lain jika dibutuhkan (`ptw/active.blade.php`, `jsa/active.blade.php`, dll).

## Verification Plan

### Manual Verification
1. Unggah dokumen berformat PDF, DOCX, XLSX, PNG, JPG.
2. Klik nama lampiran pada tabel daftar dokumen.
3. Pastikan modal preview muncul dengan konten yang ter-load secara penuh (tanpa memicu auto-download browser).
4. Tutup modal dan pastikan resource dibersihkan dengan benar.

---

## Integrasi Upload File Revision/Comment dengan Azure Blob Storage (Subtask)

Berikut adalah daftar file yang diubah dan fungsi yang ditambahkan/diperbarui untuk memindahkan upload file komentar revisi (*Return with Comment*) ke Azure Blob Storage:

### 1. Database & Model
* **[NEW]** [2026_06_15_100000_add_blob_columns_to_activity_attachments_table.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Database/Migrations/2026_06_15_100000_add_blob_columns_to_activity_attachments_table.php)
  - Membuat kolom `blob_url` (nullable string) dan `blob_response` (nullable text) pada tabel `document_system_activities_attachments`.
  ```php
  Schema::table('document_system_activities_attachments', function (Blueprint $table) {
      $table->string('blob_url')->nullable()->after('name');
      $table->text('blob_response')->nullable()->after('blob_url');
  });
  ```
* **[MODIFY]** [ActivityAttachment.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Entities/ActivityAttachment.php)
  - Menambahkan kolom `blob_url` dan `blob_response` ke dalam properti `$fillable`.
  ```php
  protected $fillable = [
      'activity_id',
      'path',
      'file_size',
      'file_type',
      'name',
      'blob_url',
      'blob_response',
  ];
  ```

### 2. Services (Upload Logic)
* **[MODIFY]** [DocumentSystemService.php (Module)](file:///c:/laragon/www/aims/Modules/DocumentSystem/Services/DocumentSystemService.php) & [DocumentSystemService.php (App)](file:///c:/laragon/www/aims/app/Services/DocumentSystemService.php)
  - **Fungsi Diubah**: `return($data)`
  - Mengubah alur penyimpanan lampiran komentar revisi agar diunggah ke Azure Blob Storage menggunakan `uploadToBlobStorage()`, lalu menghapus berkas temporer lokal.
  ```php
  // Upload ke Blob Storage
  $blobResponse = uploadToBlobStorage($value, 'document-systems/' . $data['id'] . '/revision');

  $activityAttachment = new ActivityAttachment([
      'activity_id' => $activity->id,
      'path' => $blobResponse['blobUrl'] ?? '',
      'file_size' => round($value->getSize() / 1024, 2),
      'file_type' => $value->getClientOriginalExtension(),
      'name' => $fileName,
      'blob_url' => $blobResponse['blobUrl'] ?? null,
      'blob_response' => isset($blobResponse['response']) ? json_encode($blobResponse['response']) : null,
  ]);
  $activityAttachment->save();

  // Hapus berkas temporer lokal
  if (\Illuminate\Support\Facades\File::exists($tempPath)) {
      \Illuminate\Support\Facades\File::delete($tempPath);
  }
  ```

### 3. Preview & Controller Support
* **[MODIFY]** [GeneralController.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Http/Controllers/GeneralController.php)
  - **Fungsi Diubah**: `getAttachmentSasUri($id, Request $request)` dan `previewAttachment($id, Request $request)`
  - Menambahkan penanganan parameter query `type = 'activity'` untuk mengambil data dari model `ActivityAttachment`, men-generate SAS URI, atau melakukan server-side streaming secara inline.
  ```php
  // getAttachmentSasUri & previewAttachment
  if ($type === 'activity') {
      $attachment = ActivityAttachment::with(['activity:id,document_id', 'activity.document:id'])->find($id);
  }
  ```
* **[MODIFY]** [DetailMaker.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Http/Livewire/Maker/DetailMaker.php), [Detail.php (JSA)](file:///c:/laragon/www/aims/Modules/DocumentSystem/Http/Livewire/Jsa/Detail.php), & [Detail.php (PTW)](file:///c:/laragon/www/aims/Modules/DocumentSystem/Http/Livewire/Ptw/Detail.php)
  - **Fungsi Diubah**: `detailItem($id)`
  - Mengubah penentuan `$path` preview untuk berkas yang memiliki `blob_url` agar mengarah ke route `attachments.preview` dengan tipe `activity` dan parameter query `filename` (untuk deteksi ekstensi).
  ```php
  if ($data->blob_url) {
      $path = route('document-systems::attachments.preview', ['id' => $id, 'type' => 'activity', 'filename' => $data->name]);
  } else {
      $path = asset('storage/document_systems/' . $data->activity->document->id . '/revision/' . $data->name);
  }
  ```

### 4. Frontend View
* **[MODIFY]** [detail-maker.blade.php](file:///c:/laragon/www/aims/Modules/DocumentSystem/Resources/views/livewire/maker/detail-maker.blade.php)
  - **Script Diubah**: Event Listener `detail-media`
  - Memperbarui parser javascript agar dapat mengekstrak nama file dan ekstensi dari query parameter `filename` apabila URL rute preview tidak memiliki ekstensi berkas langsung.
  ```javascript
  window.addEventListener('detail-media', (path) => {
      const url = path.detail;
      let fileName = url.substring(url.lastIndexOf('/') + 1);
      let cleanUrl = url.split('?')[0];
      let ext = cleanUrl.substring(cleanUrl.lastIndexOf('.') + 1).toLowerCase();

      // Extract real filename and extension from query string if available
      if (url.includes('?')) {
          const urlParams = new URLSearchParams(url.split('?')[1]);
          if (urlParams.has('filename')) {
              fileName = urlParams.get('filename');
              ext = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
          }
      }
      // ...
  });
  ```


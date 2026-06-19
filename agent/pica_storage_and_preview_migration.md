# Dokumentasi Perubahan Modul Pica: Migrasi Azure Blob Storage & Preview Modal

Dokumentasi ini mencantumkan semua perubahan file yang dilakukan untuk perbaikan bug (Select2 & Datepicker), migrasi upload file ke Azure Blob Storage, dan integrasi fitur interaktif preview file menggunakan SAS URI (seperti di modul KO, DocumentSystem, dan FieldLeadership).

---

## 1. Perbaikan Bug (Select2 & Datepicker)

* **Bug Detail**: Dropdown Select2 membeku/tidak memicu perubahan livewire, dan Datepicker otomatis tertutup sendiri saat diklik karena re-rendering Livewire.
* **Perbaikan**: Mengisolasi inisialisasi JS via `wire:ignore`, menggunakan MD5 hash unik untuk slot/key select2, serta menambahkan handler destroy sebelum re-init agar instances tidak bertumpuk di DOM.

### A. Kode Komponen Select2 ([select2.blade.php](file:///c:/laragon/www/aims/Modules/Pica/Resources/views/components/inputs/select2.blade.php)):

```html
@props([
    'placeholder' => 'Select Options',
    'id',
    'parent' => 'none',
    'error' => false,
    'disableChange' => true,
    'disabled' => false
])

@php
    // Deteksi wire:model, defer, atau lazy model dari atribut komponen
    $modelName = null;
    $isDeferred = false;
    if ($attributes->has('wire:model')) {
        $modelName = $attributes->get('wire:model');
    } elseif ($attributes->has('wire:model.defer')) {
        $modelName = $attributes->get('wire:model.defer');
        $isDeferred = true;
    } elseif ($attributes->has('wire:model.lazy')) {
        $modelName = $attributes->get('wire:model.lazy');
    } else {
        foreach ($attributes->getAttributes() as $key => $value) {
            if (str_starts_with($key, 'wire:model')) {
                $modelName = $value;
                if (str_contains($key, '.defer')) {
                    $isDeferred = true;
                }
                break;
            }
        }
    }
    $modelName = $modelName ?? $id;
@endphp

@php
    // 1. MEMBUAT MD5 HASH UNIK dari slot option
    // Ini memaksa Livewire mengganti elemen DOM wrapper (wire:key baru) 
    // jika pilihan dropdown bergeser akibat filter dinamis / relasi child parent,
    // mencegah dropdown macet / freeze di level render browser.
    $slotStr = (string) $slot;
    $optionsHash = md5($slotStr);
    $wireKey = "select2-wrapper-{$id}-{$optionsHash}";
@endphp

<div>
    <!-- 2. wire:ignore disematkan agar DOM select tidak dihancurkan Livewire -->
    <div wire:ignore wire:key="{{ $wireKey }}">
        <select {{ $attributes }} data-placeholder="{{ $placeholder }}" @if ($disabled) disabled @endif
            id="{{ $id }}" class="form-select w-100 select2 form-control @error($error) is-invalid @enderror">
            <option></option>
            {!! $slotStr !!}
        </select>
    </div>
    @error($error)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
@endonce

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function() {
            const initSelect2_{{ str_replace('-', '_', $id) }} = () => {
                const $el = $('#{{ $id }}');
                if (!$el.length) return;

                let option = {
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: '{{ $placeholder }}',
                    allowClear: true
                };
                if ('{{ $parent }}' !== 'none') {
                    option.dropdownParent = $('#{{ $parent }}');
                }

                // 3. Hanya inisialisasi jika elemen select2 belum aktif (mencegah duplikasi layout)
                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2(option);
                }

                // Set nilai awal dari Livewire model jika data tersedia
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && $el.val() !== val) {
                    $el.val(val).trigger('change.select2');
                }

                // 4. Bersihkan hooks event listener change lama agar tidak memicu pemanggilan ganda
                $el.off('change.select2-hook');
                $el.on('change.select2-hook', function(e) {
                    @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
                    
                    // Menonaktifkan select2 child secara instan saat value parent berganti
                    let childStr = $(this).data('child');
                    if (childStr) {
                        let children = childStr.split(',');
                        children.forEach(function(childId) {
                            const $child = $('#' + childId.trim());
                            if ($child.length) {
                                $child.val(null).prop('disabled', true).trigger('change');
                                const $container = $child.next('.select2-container');
                                if ($container.length) {
                                    $container.addClass('select2-container--disabled');
                                    $container.css({
                                        'pointer-events': 'none',
                                        'opacity': '0.6'
                                    });
                                }
                            }
                        });
                    }
                });
            };

            initSelect2_{{ str_replace('-', '_', $id) }}();

            // Re-inisialisasi ketika Livewire mengirimkan event select2
            window.livewire.on('select2', () => {
                initSelect2_{{ str_replace('-', '_', $id) }}();
            });
        });
    </script>
@endpush
```

### B. Kode Komponen Datepicker ([datepicker.blade.php](file:///c:/laragon/www/aims/resources/views/components/inputs/datepicker.blade.php)):

```html
@props(['id', 'error' => null])

<div>
    <!-- 1. Menembakkan inputevent secara eksplisit ke Livewire ketika tanggal dipilih -->
    <input {{ $attributes }} type="text" class="form-control datetimepicker-input @error($error) is-invalid @enderror"
           id="{{ $id }}" data-toggle="datetimepicker" data-target="#{{ $id }}"
           onchange="this.dispatchEvent(new InputEvent('input'))" autocomplete="off"/>
    @error($error)
    <div class="invalid-feedback d-block">
        {{ $message }}
    </div>
    @enderror
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    @endpush
@endonce

@once
    @push('scripts')
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script type="text/javascript">
        $(function() {
            const $el = $('#{{ $id }}');
            if (!$el.length) return;

            // 2. Mencegah inisialisasi ulang jika instance datepicker sudah terdaftar di DOM
            // Hal ini memecahkan bug datepicker menutup otomatis ketika salah satu tombol navigasi diklik
            const initPicker = () => {
                if (!$el.data('datepicker')) {
                    $el.datepicker({
                        format: 'MM dd, yyyy',
                        autoclose: true,
                        todayHighlight: true,
                    });
                }
            };

            initPicker();

            // Re-initialize hanya saat livewire mengirimkan sinyal perubahan input
            window.livewire.on('datetimepicker-input', () => {
                initPicker();
            });
        });
    </script>
@endpush
```

---

## 2. Database Migrations (Azure Blob Storage Columns)

* **Tujuan**: Menambahkan kolom `blob_url` dan `blob_response` untuk menyimpan metadata penyimpanan cloud Azure.
* **File Baru**:
  * [2026_06_19_082000_add_blob_columns_to_pica_files_table.php](file:///c:/laragon/www/aims/Modules/Pica/Database/Migrations/2026_06_19_082000_add_blob_columns_to_pica_files_table.php)
  * [2026_06_19_082100_add_blob_columns_to_pica_activity_files_table.php](file:///c:/laragon/www/aims/Modules/Pica/Database/Migrations/2026_06_19_082100_add_blob_columns_to_pica_activity_files_table.php)

---

## 3. Eloquent Models

* **Tujuan**: Memperbolehkan mass-assignment untuk kolom-kolom baru.
* **File yang Dimodifikasi**:
  * [PicaFile.php](file:///c:/laragon/www/aims/Modules/Pica/Entities/PicaFile.php) (Menambahkan `blob_url` dan `blob_response` ke `$fillable`).
  * [PicaActivityFile.php](file:///c:/laragon/www/aims/Modules/Pica/Entities/PicaActivityFile.php) (Menambahkan `blob_url` dan `blob_response` ke `$fillable`).

---

## 4. Livewire Logic (Upload File ke Blob Storage)

* **Tujuan**: Mengubah logika upload local disk agar diupload langsung ke Azure Blob Storage menggunakan helper function `uploadToBlobStorage()`.
* **File yang Dimodifikasi**:
  * [CreateActiveDocumentPage.php](file:///c:/laragon/www/aims/Modules/Pica/Http/Livewire/Listing/ActiveDocument/CreateActiveDocumentPage.php) (Logika upload file saat pembuatan dokumen).
  * [EditActiveDocumentPage.php](file:///c:/laragon/www/aims/Modules/Pica/Http/Livewire/Listing/ActiveDocument/EditActiveDocumentPage.php) (Logika upload file saat edit dokumen, mendukung file lama & baru).
  * [DetailActiveDocumentPage.php](file:///c:/laragon/www/aims/Modules/Pica/Http/Livewire/Listing/ActiveDocument/DetailActiveDocumentPage.php) (Upload file attachment dalam form activity).
  * [CrsDetailPage.php](file:///c:/laragon/www/aims/Modules/Pica/Http/Livewire/Listing/Crs/CrsDetailPage.php) (Upload file attachment dalam form CRS activity).

---

## 5. Routing & Controllers (SAS URI & Streaming Preview)

* **Tujuan**: Membuat endpoint aman untuk menghasilkan URL SAS (berlaku 15 menit) dan menyajikan stream server-side (agar file browser PDF/gambar dirender inline).
* **File yang Dimodifikasi**:
  * [web.php](file:///c:/laragon/www/aims/Modules/Pica/Routes/web.php) (Menambahkan route `files/{id}/preview` dan `files/{id}/sas` di bawah middleware `auth:pica`).

### Kode Implementasi Controller ([PicaController.php](file:///c:/laragon/www/aims/Modules/Pica/Http/Controllers/PicaController.php)):

```php
    /**
     * Menyajikan stream file secara aman dengan fallback local storage dan override Content-Type.
     */
    public function previewFile($id, Request $request)
    {
        try {
            $type = $request->query('type', 'pica_file');
            $attachment = null;

            // 1. Pencarian pertama menggunakan database ID
            if ($id && $id != 0) {
                if ($type === 'activity') {
                    $attachment = PicaActivityFile::find($id);
                } else {
                    $attachment = PicaFile::find($id);
                }
            }

            // 2. Pencarian kedua (FALLBACK) menggunakan parameter path jika ID tidak dikirim/tidak ada (nilai 0/null)
            if (!$attachment) {
                $pathParam = $request->query('path');
                if ($pathParam) {
                    // Bersihkan prefix domain storage jika ada
                    $storageUrl = asset('storage/');
                    if (strpos($pathParam, $storageUrl) === 0) {
                        $pathParam = substr($pathParam, strlen($storageUrl));
                    }
                    $pathParam = ltrim($pathParam, '/');
                    $decodedPath = urldecode($pathParam);

                    // Cari record berdasarkan string path file atau blob_url
                    if ($type === 'activity') {
                        $attachment = PicaActivityFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } else {
                        $attachment = PicaFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    }
                }
            }

            if (!$attachment) {
                abort(404, 'Attachment not found');
            }

            $url = $attachment->blob_url ?? $attachment->file ?? '';

            // Jika file berada di Azure Blob Storage (ditandai dengan format URL valid)
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        // Generate SAS Token sementara (15 menit)
                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }

                // Stream file dari URL privat Azure menggunakan GuzzleHttp client secara chunked
                $fileName = basename($attachment->file);
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $client = new \GuzzleHttp\Client;
                $response = $client->request('GET', $url, ['stream' => true]);
                $body = $response->getBody();
                $contentType = $response->getHeaderLine('Content-Type');

                // Override Content-Type agar browser bisa merender pdf/gambar secara inline tanpa mendownload otomatis
                if ($ext === 'pdf') {
                    $contentType = 'application/pdf';
                } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                    $contentType = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);
                }

                return response()->stream(function () use ($body) {
                    while (!$body->eof()) {
                        echo $body->read(1024 * 8);
                        flush();
                    }
                }, 200, [
                    'Content-Type'        => $contentType,
                    'Content-Disposition' => 'inline; filename="' . $fileName . '"',
                    'Cache-Control'       => 'no-cache, no-store, must-revalidate',
                ]);
            }

            // Fallback menyajikan file local disk public jika URL bukan cloud Azure
            $clean_path = $attachment->file;
            if (Storage::disk('public')->exists($clean_path)) {
                $mime = Storage::disk('public')->mimeType($clean_path);
                return response()->file(Storage::disk('public')->path($clean_path), [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
                ]);
            }

            abort(404, 'File not found locally');

        } catch (\Exception $e) {
            Log::error('previewFile error: ' . $e->getMessage());
            abort(500, 'Failed to preview file');
        }
    }
```

---

## 6. Frontend Layout & Modals (Interaktif Preview)

* **Tujuan**: Menghadirkan modal interaktif untuk preview berkas tanpa memicu tab baru (`target="_blank"`), meniru integrasi modul `DocumentSystem`.

### Kode Javascript untuk Event & Modal Controller ([master.blade.php](file:///c:/laragon/www/aims/Modules/Pica/Resources/views/layouts/master.blade.php)):

```javascript
        /**
         * Mengontrol pembukaan modal, request data SAS URI dari backend,
         * dan penentuan kontainer preview (PDF, Gambar, Office Live, atau Download Fallback).
         */
        function previewBlobFile(id, fileName, type = 'pica_file', field = null, path = null) {
            const modal = new bootstrap.Modal(document.getElementById('previewAttachmentModal'));
            const spinner = document.getElementById('preview-loading-spinner');
            const pdfContainer = document.getElementById('preview-pdf-container');
            const pdfIframe = document.getElementById('preview-pdf-iframe');
            const imgContainer = document.getElementById('preview-image-container');
            const imgElement = document.getElementById('preview-image-element');
            const officeContainer = document.getElementById('preview-office-container');
            const officeIframe = document.getElementById('preview-office-iframe');
            const fallbackContainer = document.getElementById('preview-fallback-container');
            const downloadBtn = document.getElementById('preview-download-btn');
            const titleSpan = document.getElementById('preview-file-name');

            titleSpan.innerText = fileName;
            spinner.classList.remove('d-none');
            pdfContainer.classList.add('d-none');
            imgContainer.classList.add('d-none');
            officeContainer.classList.add('d-none');
            fallbackContainer.classList.add('d-none');

            modal.show();

            // Bangun endpoint request SAS URI
            let routeUrl = "{{ route('pica::files.sas-uri', ['id' => ':id']) }}".replace(':id', id || 0) + '?type=' + type;
            if (field) {
                routeUrl += '&field=' + field;
            }
            if (path) {
                routeUrl += '&path=' + encodeURIComponent(path);
            }

            fetch(routeUrl)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.error) throw new Error(data.error);

                    const url = data.url;
                    const ext = data.extension;

                    // Arahkan ke kontainer preview yang sesuai
                    if (ext === 'pdf') {
                        let previewUrl = "{{ route('pica::files.preview', ['id' => ':id']) }}".replace(':id', id || 0) + '?type=' + type;
                        if (field) previewUrl += '&field=' + field;
                        if (path) previewUrl += '&path=' + encodeURIComponent(path);
                        pdfIframe.src = previewUrl;
                        pdfContainer.classList.remove('d-none');
                    } else if (['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(ext)) {
                        let previewUrl = "{{ route('pica::files.preview', ['id' => ':id']) }}".replace(':id', id || 0) + '?type=' + type;
                        if (field) previewUrl += '&field=' + field;
                        if (path) previewUrl += '&path=' + encodeURIComponent(path);
                        imgElement.src = previewUrl;
                        imgContainer.classList.remove('d-none');
                    } else if (['docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt'].includes(ext)) {
                        // Buka dokumen office online menggunakan microsoft viewer
                        officeIframe.src = 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url);
                        officeContainer.classList.remove('d-none');
                    } else {
                        // Download langsung untuk format file tidak didukung
                        downloadBtn.href = url;
                        fallbackContainer.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Failed to preview file:', err);
                    downloadBtn.href = '#';
                    fallbackContainer.classList.remove('d-none');
                })
                .finally(() => {
                    spinner.classList.add('d-none');
                });
        }

        /**
         * Menginisialisasi event listeners. Menggunakan pengecekan document.readyState
         * agar script tetap terdaftar meskipun DOM dimuat secara asinkron atau parsial oleh Livewire.
         */
        function initPreviewScript() {
            const modalEl = document.getElementById('previewAttachmentModal');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    const pdfIframe = document.getElementById('preview-pdf-iframe');
                    const officeIframe = document.getElementById('preview-office-iframe');
                    const imgElement = document.getElementById('preview-image-element');

                    if (pdfIframe) pdfIframe.src = '';
                    if (officeIframe) officeIframe.src = '';
                    if (imgElement) imgElement.src = '';
                });
            }

            // Global click interception untuk event delegation
            document.addEventListener('click', function(e) {
                const anchor = e.target.closest('a');
                if (!anchor) return;
                
                const href = anchor.getAttribute('href');
                if (!href) return;
                
                const urlLower = href.toLowerCase();
                const previewableExtensions = ['.pdf', '.png', '.jpg', '.jpeg', '.gif', '.webp', '.docx', '.doc', '.xlsx', '.xls', '.pptx', '.ppt'];
                const isPreviewable = previewableExtensions.some(ext => urlLower.includes(ext));
                
                if (!isPreviewable) return;
                
                const isAzureBlob = href.includes('blob.core.windows.net');
                const isStorageFile = href.includes('/storage/') || href.includes('storage/');
                const hasPicaAttributes = anchor.hasAttribute('data-id') || anchor.classList.contains('previewable') || anchor.hasAttribute('data-preview');
                
                // Jika URL mengarah ke storage local / cloud blob dan didukung preview, jalankan modal interaktif
                if (isAzureBlob || isStorageFile || hasPicaAttributes) {
                    e.preventDefault();
                    
                    let fileName = 'Document';
                    try {
                        const urlObj = new URL(href, window.location.origin);
                        const pathParts = urlObj.pathname.split('/');
                        fileName = decodeURIComponent(pathParts[pathParts.length - 1]);
                    } catch (err) {
                        const parts = href.split('/');
                        fileName = decodeURIComponent(parts[parts.length - 1]);
                    }
                    
                    const fileId = anchor.getAttribute('data-id') || null;
                    const fileType = anchor.getAttribute('data-type') || 'pica_file';
                    
                    previewBlobFile(fileId, fileName, fileType, null, href);
                }
            });
        }

        // Jalankan inisialisasi script secara langsung atau saat DOM siap
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPreviewScript);
        } else {
            initPreviewScript();
        }
```

---

## 7. Render Link pada Blade Detail Views

* **Perbaikan**: Mengubah tautan asli (`href="URL" target="_blank"`) menjadi `href="javascript:void(0)"` dan menambahkan handler `onclick="previewBlobFile(...)"` secara langsung di template, meniru implementasi `DocumentSystem` untuk menjamin interaksi modal yang andal.

### Contoh Perubahan pada Blade ([detail-active-document-page.blade.php](file:///c:/laragon/www/aims/Modules/Pica/Resources/views/livewire/listing/active-document/detail-active-document-page.blade.php)):

```html
<!-- Sebelum Perbaikan (Native target blank): -->
<a href="{{ $itemFile->blob_url ?? asset('storage/' . $itemFile->file) }}" target="_blank">

<!-- Setelah Perbaikan (Pica & DocumentSystem Standard): -->
<a href="javascript:void(0)" onclick="previewBlobFile('{{ $itemFile->id }}', '{{ $file }}', 'pica_file')" data-id="{{ $itemFile->id }}" data-type="pica_file">
```

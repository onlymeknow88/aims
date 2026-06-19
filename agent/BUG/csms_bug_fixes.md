# AIMS CSMS Module — Bug Fixes Log & Technical Scripts

Dokumen ini mencatat detail perbaikan bug (kutu) dan penjelasan baris kode/skrip yang diterapkan pada modul **CSMS (Contractor Safety Management System)** di platform AIMS.

---

## 📋 Ringkasan Perbaikan & Skrip Implementasi

### 1. Select2, Input, Textarea, & Datepicker Bug Freeze (Livewire DOM Clash)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/CSMS/Resources/views/components/inputs/select2.blade.php`
  * `Modules/CSMS/Resources/views/components/inputs/select2-avatar.blade.php`
  * `Modules/CSMS/Resources/views/components/inputs/datepicker.blade.php`
  * Modul form views (`create.blade.php`, `edit.blade.php`) di Bidding, Post-Bidding, dan PJO.

#### Skrip Penjelasan Solusi (Select2 Wrapper Component):
Untuk mengatasi clash siklus render Livewire dengan jQuery Select2, inisialisasi dilakukan menggunakan event hooking dengan mengecek properti `.defer` secara dinamis dan membandingkan isi value sebelum di-set agar tidak memicu re-render tak berujung (freeze):

```html
@props(['placeholder' => 'Select Options', 'id', 'parent' => 'none', 'error' => false, 'disabled' => false])

@php
    $modelName = null;
    $isDeferred = false;
    if ($attributes->has('wire:model')) {
        $modelName = $attributes->get('wire:model');
    } elseif ($attributes->has('wire:model.defer')) {
        $modelName = $attributes->get('wire:model.defer');
        $isDeferred = true;
    }
    // ... logic parsing wire:model lainnya
@endphp

<div>
    <div wire:ignore wire:key="select2-wrapper-{{ $id }}">
        <select {{ $attributes }} id="{{ $id }}" class="form-select w-100 select2">
            <option></option>
            {!! $slot !!}
        </select>
    </div>
</div>

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

                if (!$el.hasClass("select2-hidden-accessible")) {
                    $el.select2(option);
                }

                // Sinkronisasi Value dari Livewire ke Select2 (Hanya jika nilainya berbeda)
                const val = @this.get('{{ $modelName }}');
                if (val !== undefined && val !== null && $el.val() !== val) {
                    $el.val(val).trigger('change.select2');
                }

                $el.off('change.select2-hook');
                $el.on('change.select2-hook', function(e) {
                    const currentVal = @this.get('{{ $modelName }}');
                    
                    // Cek isSame untuk menghindari re-trigger state
                    const isSame = (currentVal == e.target.value) || 
                                   ((currentVal === null || currentVal === undefined || currentVal === '') && 
                                    (e.target.value === null || e.target.value === undefined || e.target.value === ''));
                    
                    if (!isSame) {
                        // Set data kembali ke Livewire dengan flag defer dinamis
                        @this.set('{{ $modelName }}', e.target.value, {{ $isDeferred ? 'true' : 'false' }});
                    }
                });
            };

            initSelect2_{{ str_replace('-', '_', $id) }}();

            window.livewire.on('select2', () => {
                initSelect2_{{ str_replace('-', '_', $id) }}();
            });
        });
    </script>
@endpush
```

---

### 2. Livewire Controller Upload to Azure Blob Storage
* **Status**: ✅ Fixed
* **File Terkait**:
  * Livewire Form Controllers (`Create.php`, `Edit.php`)
  * Database Migration: `Modules/CSMS/Database/Migrations/2026_06_19_085500_add_blob_columns_to_csms_files_tables.php`

#### Skrip Contoh Implementasi (Bidding/Create.php & Edit.php):
File temporer Livewire (`TemporaryUploadedFile`) langsung diproses menggunakan helper global `uploadToBlobStorage` dan URL Azure Blob yang dikembalikan disimpan di tabel terkait:

```php
use App\Helpers\General; // Memuat helper uploadToBlobStorage

// ... di dalam method save() atau saveAttachment()
if ($this->checklist_files[$checklistId]) {
    foreach ($this->checklist_files[$checklistId] as $file) {
        // 1. Upload ke Azure Blob Storage
        $blobData = uploadToBlobStorage($file, 'csms/checklists');
        
        if ($blobData && isset($blobData['blob_url'])) {
            // 2. Simpan URL Blob & respon meta data ke Database
            $checklist->files()->create([
                'file' => $blobData['file_path'] ?? $file->getClientOriginalName(),
                'name' => $file->getClientOriginalName(),
                'size' => round($file->getSize() / 1024, 2),
                'extension' => $file->getClientOriginalExtension(),
                'blob_url' => $blobData['blob_url'],
                'blob_response' => json_encode($blobData['blob_response'] ?? [])
            ]);
        }
    }
}
```

---

### 3. Sistem Pratinjau Dokumen Interaktif (previewBlobFile)
* **Status**: ✅ Fixed
* **File Terkait**:
  * `Modules/CSMS/Http/Controllers/CSMSController.php`
  * `Modules/CSMS/Resources/views/layouts/master.blade.php`
  * `Modules/CSMS/Resources/views/layouts/partials/preview-modal.blade.php`

#### Skrip Definisi Global Javascript `previewBlobFile` (di dalam `master.blade.php`):
Mengambil tautan SAS URI dengan otentikasi dinamis 15 menit dari controller kemudian menampilkan file di dalam frame pratinjau yang sesuai (PDF / Gambar / Microsoft Office Viewer):

```javascript
function previewBlobFile(id, fileName, type = 'checklist', field = null, path = null) {
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

    // Bangun URL request SAS URI
    let routeUrl = "{{ route('csms::files.sas-uri', ['id' => ':id']) }}".replace(':id', id || 0) + '?type=' + type;
    if (field) routeUrl += '&field=' + field;
    if (path) routeUrl += '&path=' + encodeURIComponent(path);

    fetch(routeUrl)
        .then(response => {
            if (!response.ok) throw new Error('Failed to fetch SAS URI');
            return response.json();
        })
        .then(data => {
            spinner.classList.add('d-none');
            const fileUrl = data.url;
            const ext = data.extension.toLowerCase();
            downloadBtn.setAttribute('href', fileUrl);

            if (ext === 'pdf') {
                pdfIframe.setAttribute('src', fileUrl);
                pdfContainer.classList.remove('d-none');
            } else if (['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(ext)) {
                imgElement.setAttribute('src', fileUrl);
                imgContainer.classList.remove('d-none');
            } else if (['docx', 'doc', 'xlsx', 'xls', 'pptx', 'ppt'].includes(ext)) {
                // Gunakan Office Online Viewer untuk file dokumen office
                officeIframe.setAttribute('src', 'https://view.officeapps.live.com/op/view.aspx?src=' + encodeURIComponent(fileUrl));
                officeContainer.classList.remove('d-none');
            } else {
                fallbackContainer.classList.remove('d-none');
            }
        })
        .catch(err => {
            console.error(err);
            spinner.classList.add('d-none');
            fallbackContainer.classList.remove('d-none');
        });
}
```

#### Skrip Global Click Interceptor (Untuk mengamankan tag `a` lama secara otomatis):
```javascript
function initPreviewScript() {
    document.addEventListener('click', function(e) {
        const anchor = e.target.closest('a');
        if (!anchor) return;
        
        const href = anchor.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;
        
        const urlLower = href.toLowerCase();
        const previewableExtensions = ['.pdf', '.png', '.jpg', '.jpeg', '.gif', '.webp', '.docx', '.doc', '.xlsx', '.xls', '.pptx', '.ppt'];
        const isPreviewable = previewableExtensions.some(ext => urlLower.includes(ext));
        
        if (!isPreviewable) return;
        
        const isAzureBlob = href.includes('blob.core.windows.net');
        const isStorageFile = href.includes('/storage/') || href.includes('storage/');
        
        if (isAzureBlob || isStorageFile) {
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
            const fileType = anchor.getAttribute('data-type') || 'checklist';
            
            // Panggil modal preview
            previewBlobFile(fileId, fileName, fileType, null, href);
        }
    });
}
```

---

### 4. Contoh Konversi Tautan Download Tradisional di Blade View
* **Status**: ✅ Fixed

#### Halaman Bidding Detail View (Sebelum vs Sesudah):
Sebelum:
```html
<a class="text-primary"
    href="{{ route('csms::bidding.download-file', [$file->id]) }}"
    target="_blank"><i class="fa fa-download"></i>
    Attachment
</a>
```

Sesudah:
```html
<a class="text-primary"
    href="javascript:void(0)"
    onclick="previewBlobFile('{{ $file->id }}', '{{ $file->name }}', 'checklist')"
    data-id="{{ $file->id }}"
    data-type="checklist">
    <i class="fa fa-eye"></i> Preview Attachment
</a>
```

#### Halaman PJO Detail View (Sebelum vs Sesudah):
Sebelum:
```html
@foreach ($files['competency_file'] as $keyFile => $itemFile)
    <a href="{{ asset($itemFile['file']) }}">
        <!-- ... layout card file ... -->
    </a>
@endforeach
```

Sesudah:
```html
@foreach ($files['competency_file'] as $keyFile => $itemFile)
    <a href="javascript:void(0)" onclick="previewBlobFile('{{ $itemFile['id'] }}', '{{ $itemFile['name'] }}', 'pjo')" data-id="{{ $itemFile['id'] }}" data-type="pjo">
        <!-- ... layout card file ... -->
    </a>
@endforeach
```

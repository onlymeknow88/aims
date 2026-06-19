# Alur `saved()` — Draft & Submit for Review

## Overview

Method `saved($publish)` dipanggil dari blade dengan dua kemungkinan parameter:

| Tombol | Parameter | Keterangan |
|---|---|---|
| Submit as draft | `'Draft'` | Simpan tanpa publish |
| Submit for review | `'Publish'` | Kirim ke PJA untuk review |
| Close Action *(HR only)* | `'HR'` | Hazard Report, langsung close |

---

## 1. Trigger dari Blade

```blade
{{-- Submit as draft --}}
<button type="button" wire:click="saved('Draft')" class="dropdown-item">
    Submit as draft
</button>

{{-- Submit for review --}}
<button type="button" wire:click="saved('Publish')" class="dropdown-item">
    Submit for review
</button>
```

---

## 2. Masuk ke Method `saved($publish)`

```php
public function saved($publish)
{
    try {
        dd($this->temporaryFile); // ⚠️ INI MASIH ADA — harus dihapus!
        $this->validate();
        DB::beginTransaction();
        // ...
    }
}
```

> ⚠️ **BUG:** Ada `dd($this->temporaryFile)` di baris pertama. Form tidak akan pernah bisa submit sampai ini dihapus.

---

## 3. Perbedaan `Draft` vs `Publish`

### Saat create `FieldLeadership`:

```php
$fieldLeadership = FieldLeadership::create([
    // ...
    'published' => $publish == 'HR' ? 'Publish' : $publish,
    // ↑ Draft  → published = 'Draft'
    // ↑ Publish → published = 'Publish'

    'status'    => $publish != 'HR' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
    // ↑ Draft  → status = Open
    // ↑ Publish → status = Open
    // ↑ HR     → status = Close

    'requested' => $publish != 'HR' ? FieldLeadershipType::RequestedPja : FieldLeadershipType::Rejected,
    // ↑ Draft  → requested = RequestedPja
    // ↑ Publish → requested = RequestedPja
    // ↑ HR     → requested = Rejected
]);
```

**Ringkasan perbedaan nilai kolom:**

| Kolom | Draft | Publish |
|---|---|---|
| `published` | `'Draft'` | `'Publish'` |
| `status` | `Open` | `Open` |
| `requested` | `RequestedPja` | `RequestedPja` |

> Catatan: `Draft` dan `Publish` menghasilkan `status` dan `requested` yang **sama**. Perbedaannya hanya di kolom `published`.

---

## 4. Blok yang Sama untuk Keduanya (Draft & Publish)

### a. Pertanyaan (jika type = Planned Task Observation)

```php
if ($this->type == 'Planned Task Observation') {
    $fieldLeadership->questions()->create([
        'question'    => $this->question1,
        'answer'      => $this->answer1,
        'description' => $this->description1,
    ]);
    // ... question2 s/d question6
}
```

### b. Validasi jumlah member

```php
if (count($this->member) > 3) {
    $this->dispatchBrowserEvent('swal', [
        'title' => 'Error',
        'icon'  => 'error',
        'text'  => "Anggota tim tidak boleh lebih dari 3 orang",
    ]);
    return false;
}
```

### c. Simpan member

```php
foreach ($this->member as $key => $value) {
    if ($value['employee_id'] != null && $value['type'] != null) {
        $fieldLeadership->members()->create([
            'type'        => $value['type'],
            'employee_id' => $value['employee_id'],
        ]);
    }
}
```

### d. Simpan positive condition (skip jika Hazard Report)

```php
if ($this->type != 'Hazard Report') {
    foreach ($this->positive_condition as $key => $value) {
        if ($value['description'] != null) {
            $fieldLeadership->positives()->create([
                'description' => $value['description'],
            ]);
        }
    }
}
```

### e. Simpan risk condition + file upload

```php
foreach ($this->risk_condition as $key => $value) {

    // Validasi description wajib diisi
    if ($value['description'] == null) { return false; }

    // Validasi action wajib jika repaired = true
    if ($value['repaired'] == true && $value['action'] == null) { return false; }

    // Validasi due_date wajib
    if ($value['due_date'] == null) { return false; }

    // Simpan risk condition
    $riskCondition = $fieldLeadership->risks()->create([
        'risk_condition' => $value['description'],
        'category_id'    => $value['category'],
        'type_id'        => $value['type'],
        'potency_id'     => $value['level'],
        'repair_action'  => $value['repaired'] == true ? $value['action'] : null,
        'due_date'       => Carbon::parse($value['due_date'])->format('Y-m-d'),
        'type_action'    => $value['repaired'] == true ? $value['type_action'] : null,
        'supervisor'     => $value['repaired'] == true ? $value['supervisor'] : null,
        'status'         => $publish != 'HR' ? FieldLeadershipType::Open : FieldLeadershipType::Close,
    ]);

    // Upload file temuan KTA/TTA — versi lama (local storage)
    foreach ($value['files'] as $key => $file) {
        $path      = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
        $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

        $riskCondition->files()->create([
            'file' => $full_path,
            'size' => $file['size'],
            'type' => FieldLeadershipType::RiskFinding,
        ]);
    }

    // Upload file corrective action — versi lama (local storage)
    if ($value['repaired'] == true) {
        foreach ($value['files_ca'] as $key => $file) {
            $path      = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

            $riskCondition->files()->create([
                'file' => $full_path,
                'size' => $file['size'],
                'type' => FieldLeadershipType::CorrectiveAction,
            ]);
        }
    }
}
```

---

## 4f. Migrasi Upload ke Azure Blob Storage

### Kenapa upload dilakukan di `saved()`, bukan di `addFile()`?

`directPath` baru bisa terbentuk setelah `$fieldLeadership->id` dan `$riskCondition->id` tersedia — keduanya baru ada setelah insert DB. Jadi upload Blob tetap dilakukan di `saved()`, bukan saat user memilih file.

### Alur `addFile()` — tidak berubah

`addFile()` tetap hanya staging object Livewire ke array `risk_condition[index]['files']`. File fisiknya masih bisa diakses via `getRealPath()` selama dalam satu request.

```php
public function addFile($index)
{
    $this->risk_condition[$index]['files'][] = [
        'file'      => $this->temporaryFile[$index][0], // Livewire UploadedFile object
        'name'      => $this->temporaryFile[$index][0]->getClientOriginalName(),
        'size'      => $this->changeByte($this->temporaryFile[$index][0]->getSize()),
        'extension' => $this->temporaryFile[$index][0]->getClientOriginalExtension(),
    ];
}
```

### Perubahan di `saved()` — ganti local storage ke Blob

**File temuan KTA/TTA (`files`):**

```php
// ❌ Sebelum (local storage):
foreach ($value['files'] as $key => $file) {
    $path      = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
    $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

    $riskCondition->files()->create([
        'file' => $full_path,
        'size' => $file['size'],
        'type' => FieldLeadershipType::RiskFinding,
    ]);
}

// ✅ Sesudah (Azure Blob Storage):
foreach ($value['files'] as $key => $file) {
    $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
    $tempPath   = $file['file']->getRealPath(); // path fisik dari Livewire temp file

    $blobResult = uploadToBlobStorage($file['name'], $tempPath, $directPath);

    $riskCondition->files()->create([
        'file' => $blobResult['fileBlobUrl'],  // URL Blob yang dikembalikan API
        'size' => $file['size'],
        'type' => FieldLeadershipType::RiskFinding,
    ]);
}
```

**File corrective action (`files_ca`):**

```php
// ❌ Sebelum (local storage):
if ($value['repaired'] == true) {
    foreach ($value['files_ca'] as $key => $file) {
        $path      = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
        $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

        $riskCondition->files()->create([
            'file' => $full_path,
            'size' => $file['size'],
            'type' => FieldLeadershipType::CorrectiveAction,
        ]);
    }
}

// ✅ Sesudah (Azure Blob Storage):
if ($value['repaired'] == true) {
    foreach ($value['files_ca'] as $key => $file) {
        $directPath = 'field-leadership/' . $fieldLeadership->id . '/risk-condition/' . $riskCondition->id;
        $tempPath   = $file['file']->getRealPath();

        $blobResult = uploadToBlobStorage($file['name'], $tempPath, $directPath);

        $riskCondition->files()->create([
            'file' => $blobResult['fileBlobUrl'],
            'size' => $file['size'],
            'type' => FieldLeadershipType::CorrectiveAction,
        ]);
    }
}
```

### Apa yang dikembalikan `uploadToBlobStorage()`?

```php
// Return value sukses:
[
    'fileBlobUrl'      => 'https://aims-cntr.blob.core.windows.net/...', // ← simpan ini ke DB
    'fileBlobPathName' => 'field-leadership/123/risk-condition/45/nama-file.pdf',
    'blobResponse'     => [...], // raw response dari API
]

// Return value gagal:
[
    'fileBlobUrl'      => null,
    'fileBlobPathName' => null,
    'blobResponse'     => null,
]
```

> Pastikan handle jika `fileBlobUrl` null (upload gagal) agar tidak menyimpan `null` ke DB tanpa notifikasi.

---

## 5. Blok Khusus `HR` (tidak berlaku untuk Draft & Publish)

```php
// Hanya jalan jika $publish == 'HR'
if ($publish == 'HR') {
    $picaDocument = $riskCondition->pica()->create([...]);
    $picaDocument->pica()->create([...]);
    // + file temuan & file CA juga disalin ke picaFiles
}
```

Draft dan Publish **tidak masuk** ke blok ini.

---

## 6. Activity Log & Commit

```php
FieldLeadershipActivity::create([
    'fl_id'       => $fieldLeadership->id,
    'description' => 'Create Field Leadership',
    'user_id'     => Auth::user()->id,
]);

DB::commit();
```

Sama untuk Draft maupun Publish.

---

## 7. Flash & Redirect

```php
$this->flash('success', 'Data berhasil di simpan!', [
    'position' => 'top-end',
    'timer'    => 3000,
    'toast'    => true,
]);

return redirect()->route('field-leadership::listing.active.index');
```

Keduanya redirect ke halaman index setelah berhasil.

---

## Ringkasan Alur Visual

```
User klik tombol
        │
        ├── "Submit as draft"  → saved('Draft')
        └── "Submit for review" → saved('Publish')
                │
                ▼
        dd($this->temporaryFile)  ← ⚠️ BUG, harus dihapus
                │
                ▼
        $this->validate()
                │
                ▼
        DB::beginTransaction()
                │
                ▼
        FieldLeadership::create()
          published = 'Draft' / 'Publish'
          status    = Open
          requested = RequestedPja
                │
                ├── type == PTO? → simpan 6 questions
                ├── simpan members
                ├── type != HR?  → simpan positive_condition
                └── foreach risk_condition
                        ├── validasi description, action, due_date
                        ├── risks()->create()
                        ├── upload files (RiskFinding)
                        └── repaired? → upload files_ca (CorrectiveAction)
                │
                ▼
        FieldLeadershipActivity::create()
                │
                ▼
        DB::commit()
                │
                ▼
        flash success + redirect ke index
```

---

## Bugs yang Perlu Difix

1. **`dd($this->temporaryFile)`** di awal `saved()` — block semua eksekusi, harus dihapus
2. `DB::rollBack()` tidak ada di `catch` block — jika terjadi error di tengah proses, data bisa partial tersimpan
3. Sebaiknya tambahkan `DB::rollBack()` di catch:

```php
} catch (\Throwable $err) {
    DB::rollBack(); // ← tambahkan ini

    $this->dispatchBrowserEvent('swal', [
        'title' => 'Error',
        'icon'  => 'error',
        'text'  => "Error | " . $err,
    ]);
}
```

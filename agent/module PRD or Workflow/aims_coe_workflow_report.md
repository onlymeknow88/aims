# 📅 Calendar of Events (CoE) — Workflow & ERD Report
> **Sistem:** AIMS (Aplikasi Integrated Management System)  
> **Modul:** `Modules\Coe`  
> **Tanggal:** Juni 2026  
> **Framework:** Laravel + Livewire

---

## 1. Gambaran Umum Modul

Modul **Calendar of Events (CoE)** adalah sistem manajemen kalender event terpusat yang memungkinkan pengguna untuk membuat, mengelola, dan memantau kegiatan/event organisasi. Modul ini mendukung fitur **pengulangan event (recurring events)**, **notifikasi email ke undangan**, **filter per perusahaan/departemen**, serta **laporan dashboard** berbasis data historis.

---

## 2. ERD Database (Entity Relationship Diagram)

```mermaid
erDiagram
    users {
        uuid id PK
        string name
        string email
        string password
    }

    sections {
        uuid id PK
        string name
        uuid department_id FK
    }

    departments {
        uuid id PK
        string name
        uuid company_id FK
    }

    companies {
        uuid id PK
        string name
        string type
    }

    coe_categories {
        uuid id PK
        string name
        timestamp created_at
        timestamp updated_at
    }

    coe_events {
        uuid id PK
        uuid user_id FK "nullable → users"
        uuid category_id FK "nullable → coe_categories"
        uuid section_id FK "nullable → sections"
        uuid related_event_id FK "nullable → coe_events (self-ref)"
        string title
        string status "PENDING | DONE | CANCELED"
        longtext description "nullable"
        string frequency "once | weekly | monthly | yearly"
        text invited_emails "nullable (JSON array)"
        string attachment "nullable (file path)"
        date start_date
        date end_date "nullable"
        boolean notification_sent "default: false"
        boolean repeat "default: true"
        boolean must_send_email "default: true"
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at "SoftDelete"
    }

    users ||--o{ coe_events : "membuat (user_id)"
    coe_categories ||--o{ coe_events : "dikategorikan (category_id)"
    sections ||--o{ coe_events : "dimiliki oleh (section_id)"
    departments ||--o{ sections : "memiliki"
    companies ||--o{ departments : "memiliki"
    coe_events ||--o{ coe_events : "parent ke child (related_event_id)"
```

### 2.1 Penjelasan Relasi Tabel

| Relasi | Tipe | Keterangan |
|--------|------|------------|
| `coe_events.user_id` → `users.id` | BelongsTo (nullable) | Pembuat event |
| `coe_events.category_id` → `coe_categories.id` | BelongsTo (nullable) | Kategori prioritas event |
| `coe_events.section_id` → `sections.id` | BelongsTo (nullable) | Seksi/unit organisasi |
| `coe_events.related_event_id` → `coe_events.id` | Self-referencing BelongsTo (nullable) | Event induk untuk recurring |
| `coe_categories` → `coe_events` | HasMany | Satu kategori punya banyak event |

### 2.2 Enum Status Event (`COEStatus`)

| Nilai | Keterangan | Warna Kalender |
|-------|-----------|----------------|
| `PENDING` | Menunggu / Belum terlaksana | 🟠 Orange |
| `DONE` | Selesai / Terlaksana | 🟢 Green |
| `CANCELED` | Dibatalkan | 🔴 Red |

---

## 3. Struktur Modul

```
Modules/Coe/
├── Database/
│   ├── Migrations/
│   │   ├── 2023_01_30_154335_create_coe_categories_table.php
│   │   ├── 2023_01_30_154649_create_coe_events_table.php
│   │   ├── 2023_07_05_185541_update_coe_events.php
│   │   └── 2023_07_06_073149_update_coe_events_attachment.php
├── Entities/
│   ├── Category.php         ← Model coe_categories
│   └── Event.php            ← Model coe_events
├── Http/
│   ├── Controllers/
│   │   └── CoeController.php    ← API Controller
│   └── Livewire/
│       ├── Add.php              ← Form tambah event
│       ├── Edit.php             ← Form edit event
│       ├── Lists.php            ← Daftar event (tabel)
│       ├── CallendarView.php    ← Tampilan kalender
│       ├── Dashboard.php        ← Dashboard statistik
│       ├── Category.php         ← Manajemen kategori
│       └── InvitedEx.php        ← Kalender untuk undangan eksternal
└── Routes/
    ├── web.php              ← Route web (Livewire)
    └── api.php              ← Route API (mobile/JSON)
```

---

## 4. Alur Bisnis (Business Flow)

### 4.1 Alur Utama: Buat Event Baru

```mermaid
flowchart TD
    A([User Login]) --> B[Akses Halaman Add Event\n/add-event]
    B --> C{Cek Permission\nCOE - Add Event}
    C -- Tidak ada --> D([403 / Abort])
    C -- Ada --> E[Isi Form Event]

    E --> F[Masukkan Detail:\nTitle, Kategori\nDeskripsi, Tanggal Mulai]

    F --> G{Apakah Repeat?}
    G -- Tidak / once --> H[Set end_date = start_date\nrepeat = false]
    G -- Ya --> I[Pilih Frekuensi:\nweekly / monthly]

    H --> J[Tambah Invited Emails - Opsional]
    I --> J

    J --> K[Upload Attachment - Opsional]
    K --> L[Submit Save]

    L --> M{Validasi Form}
    M -- Gagal --> N[Tampilkan Error Validasi]
    N --> E
    M -- Lolos --> O[Simpan Event Induk\nstatus = PENDING]

    O --> P{Apakah Repeat?}
    P -- Tidak --> Q{Kirim Notifikasi Email?}
    P -- Ya weekly --> R[Generate Event Anak\nSetiap Minggu hingga Akhir Tahun]
    P -- Ya monthly --> S[Generate Event Anak\nSetiap Bulan hingga Akhir Tahun]

    R --> Q
    S --> Q

    Q -- must_send_email = false --> T([Redirect ke Kalender])
    Q -- must_send_email = true --> U{Ada Invited Emails?}
    U -- Tidak --> T
    U -- Ya --> V[Loop per Email]
    V --> W{User terdaftar di sistem?}
    W -- Ya --> X[Kirim Email type=login]
    W -- Tidak --> Y[Kirim Email type=non-login]
    X --> Z{Masih ada email?}
    Y --> Z
    Z -- Ya --> V
    Z -- Tidak --> T
```

### 4.2 Alur Edit Event

```mermaid
flowchart TD
    A([User akses Edit Event\n/edit-event/id]) --> B{Cek Permission\nCOE - Edit COE}
    B -- Tidak --> C([404 Abort])
    B -- Ya --> D[Load data event ke form]
    D --> E[Edit Form:\nTitle, Kategori, Deskripsi\nTanggal, Invited Emails\nAttachment]
    E --> F[Submit Save]

    F --> G{Event adalah Repeat?}
    G -- Tidak / once --> H[saveSingleEvent\nUpdate hanya event ini]
    G -- Ya --> I[Tampilkan Dialog Konfirmasi]

    I --> J{User Pilih}
    J -- Hanya event ini --> H
    J -- Event ini dan selanjutnya --> K[saveRepeat]

    H --> L[Update status = PENDING\nSimpan ke database]
    L --> M([Redirect ke Kalender])

    K --> N{Event adalah Parent?}
    N -- Ya is_parent --> O{Frekuensi}
    O -- weekly --> P[Update semua child event\n+1 minggu per event]
    O -- monthly --> Q[Update semua child event\n+1 bulan per event]

    N -- Bukan parent --> R{Tanggal berubah?}
    R -- Tidak berubah --> S[Update child PENDING events\ndata baru tanpa geser tanggal]
    R -- Berubah --> T{Frekuensi}
    T -- weekly --> U[Geser tanggal child PENDING\n+1 minggu dari new start]
    T -- monthly --> V[Geser tanggal child PENDING\n+1 bulan dari new start]

    P --> M
    Q --> M
    S --> M
    U --> M
    V --> M
```

### 4.3 Alur Hapus Event

```mermaid
flowchart TD
    A([User klik Hapus Event]) --> B[Tampilkan konfirmasi SweetAlert]
    B --> C{Event adalah Parent?\nrelated_event_id = null}

    C -- Ya dan punya child --> D[Tampilkan warning:\nEvent induk, child ikut terhapus]
    C -- Ya tidak punya child --> E[Konfirmasi hapus biasa]
    C -- Bukan parent --> E

    D --> F{User Konfirmasi?}
    E --> F

    F -- Batal --> G([Tutup modal])
    F -- Hapus --> H{Apakah Parent?}

    H -- Ya --> I[SoftDelete semua child events\nWhere related_event_id = event.id]
    I --> J[SoftDelete event induk]
    H -- Bukan parent --> J

    J --> K([Redirect ke Kalender - Flash success])
```

### 4.4 Alur Manajemen Status Event

```mermaid
flowchart TD
    A([User buka Detail Event di Kalender]) --> B[Tampilkan popup detail event]
    B --> C[Klik tombol Change Status]
    C --> D{Pilih Status Baru}
    D -- PENDING --> E[Update status = PENDING\nWarna kalender Orange]
    D -- DONE --> F[Update status = DONE\nWarna kalender Green]
    D -- CANCELED --> G[Update status = CANCELED\nWarna kalender Red]
    E --> H([Redirect ke Kalender])
    F --> H
    G --> H
```

### 4.5 Alur Manajemen Kategori

```mermaid
flowchart TD
    A([Admin akses /category]) --> B{Cek Permission\nCOE - Manage Category}
    B -- Tidak --> C([404 Abort])
    B -- Ya --> D[Tampilkan Daftar Kategori]

    D --> E{Aksi}
    E -- Tambah --> F[Isi Nama Kategori]
    F --> G[saveCoECategory]
    G --> H{Validasi}
    H -- Gagal --> I[Tampilkan error]
    H -- Berhasil --> J[Simpan ke coe_categories]
    J --> K([Redirect ke /category])

    E -- Hapus --> L[Select kategori]
    L --> M[Tampilkan konfirmasi SweetAlert]
    M --> N{Konfirmasi?}
    N -- Ya --> O[Delete kategori]
    O --> K
    N -- Tidak --> D
```

### 4.6 Alur Akses Kalender Undangan Eksternal

```mermaid
flowchart TD
    A([User menerima email undangan]) --> B[Klik link di email\n/coe/inv?ids=id1,id2,id3]
    B --> C[Tampilkan halaman InvitedEx\nTanpa perlu login]
    C --> D[Muat events berdasarkan IDs\nditambah semua event Kategori Umum]
    D --> E[Tampilkan kalender\ndengan color-coded status]
    E --> F{User klik event}
    F --> G[Tampilkan detail event popup]
    G --> H([Selesai])
```

---

## 5. Alur Data Dashboard & Statistik

```mermaid
flowchart LR
    subgraph "Data Sources"
        DB[(coe_events\nDatabase)]
    end

    subgraph "Dashboard Charts"
        CH1["Chart 1\nJumlah DONE per Bulan"]
        CH2["Chart 2\nEvent per Area Manager"]
        CH3["Chart 3\nDistribusi Status Event"]
    end

    subgraph "API Endpoints"
        API1["GET /api/coe/dashboard/\nSemua statistik"]
        API2["GET /api/coe/dashboard/ytd\nYear-to-Date count"]
        API3["GET /api/coe/dashboard/bycategory\nCount per kategori"]
    end

    DB --> CH1
    DB --> CH2
    DB --> CH3
    DB --> API1
    DB --> API2
    DB --> API3
```

### 5.1 Metrik Dashboard yang Tersedia

| Metrik | Endpoint API | Keterangan |
|--------|-------------|------------|
| Total event tahunan | `getAllIn` | Count semua event tahun ini |
| Completion rate | `getAnnualCompletion` | % event DONE vs total |
| Event YTD | `getYtd` | Count event bulan ini |
| Count by category | `getBycategory` | URGENT / IMPORTANT / MEDIUM / LOW |
| Monthly completion | `getCompletionByMonth` | Breakdown per bulan |
| Event bulanan per hari | `getMonthlyListsCount` | Untuk mobile calendar dots |
| Detail event by day | `getEventDayLists` | Untuk mobile day view |

---

## 6. Komponen Livewire & Fungsinya

| Komponen | Route | Permission | Fungsi Utama |
|----------|-------|-----------|--------------|
| `Dashboard` | `/dashboard` | `COE - View Dashboard` | Statistik dan chart analitik |
| `CallendarView` | `/calendar` | Semua auth user | Tampilan kalender interaktif, import/export |
| `Lists` | `/list` | `COE - View List` | Tabel daftar event + export Excel |
| `Add` | `/add-event` | — | Form buat event baru + repeat logic |
| `Edit` | `/edit-event/{id}` | `COE - Edit COE` | Form edit event + cascade update |
| `Category` | `/category` | `COE - Manage Category` | CRUD master kategori |
| `InvitedEx` | `/inv?ids=...` | Public (no auth) | Kalender untuk undangan eksternal |

---

## 7. Permission Matrix

| Permission | Dashboard | Lihat Kalender | Lihat List | Edit Event | Hapus Event | Kelola Kategori |
|-----------|-----------|----------------|------------|-----------|------------|-----------------|
| `COE - View Dashboard` | ✅ | — | — | — | — | — |
| `COE - View List` | — | — | ✅ | — | ✅ | — |
| `COE - Edit COE` | — | — | — | ✅ | — | — |
| `COE - Manage Category` | — | — | — | — | — | ✅ |
| `COE - Superuser` | ✅ | ✅ semua | ✅ semua | ✅ | ✅ | ✅ |

> **Catatan:** User non-Superuser hanya melihat event yang:
> - Mereka buat sendiri (`user_id = auth user`)
> - Mereka diundang (`invited_emails contains email`)
> - Berkategori **"Umum"** (event publik)

---

## 8. Alur Repeat Event (Recurring Logic)

```mermaid
flowchart TD
    A["Event Parent dibuat\nfrequency = weekly/monthly"] --> B["Simpan event induk\nrelated_event_id = NULL"]
    B --> C{Frekuensi}

    C -- weekly --> D["Loop: start_date + 1 minggu\nhingga end_of_year"]
    C -- monthly --> E["Loop: start_date + 1 bulan\nhingga end_of_year"]

    D --> F["Replicate event\nrelated_event_id = parent.id\nStart/End bergeser"]
    E --> F

    F --> G{Masih dalam tahun ini?}
    G -- Ya --> H["Simpan event anak\nstatus = PENDING"]
    H --> G
    G -- Tidak --> I([Selesai - semua event tersimpan])
```

### 8.1 Contoh Visualisasi Repeat Event

```
Event: "Meeting Mingguan" | Frequency: weekly | Start: 2 Jan 2024
│
├── Event INDUK  [related_event_id: NULL]
│   └── Start: 2 Jan 2024 | Status: PENDING
│
├── Event ANAK 1 [related_event_id: induk.id]
│   └── Start: 9 Jan 2024 | Status: PENDING
│
├── Event ANAK 2 [related_event_id: induk.id]
│   └── Start: 16 Jan 2024 | Status: PENDING
│
└── ... berlanjut setiap minggu hingga 31 Des 2024
```

---

## 9. Alur Notifikasi Email

```mermaid
sequenceDiagram
    participant U as User
    participant LW as Livewire Add.php
    participant MAIL as Mail System
    participant EXT as Invited Person

    U->>LW: Submit form event baru
    LW->>LW: Validasi dan simpan event
    LW->>LW: Cek must_send_email = true?
    alt must_send_email = true
        loop Setiap email dalam invited_emails
            LW->>LW: Cek apakah email ada di users?
            alt User terdaftar
                LW->>MAIL: send ReminderCreatedEvent type=login
            else User tidak terdaftar
                LW->>MAIL: send ReminderCreatedEvent type=non-login
            end
            MAIL->>EXT: Kirim email dengan link kalender\n/coe/inv?ids=id1,id2,...
        end
    end
    LW->>U: Flash success dan redirect ke /calendar
```

---

## 10. API Endpoints (Mobile & External)

### Web Routes (`/coe/*`)

| Method | URL | Komponen | Auth |
|--------|-----|----------|------|
| GET | `/coe/` | `Home` | Guest |
| GET | `/coe/login` | `Auth\Login` | Guest |
| GET | `/coe/dashboard` | `Dashboard` | `auth:coe` |
| GET | `/coe/list` | `Lists` | `auth:coe` |
| GET | `/coe/calendar` | `CallendarView` | `auth:coe` |
| GET | `/coe/add-event` | `Add` | `auth:coe` |
| GET | `/coe/edit-event/{event}` | `Edit` | `auth:coe` |
| GET | `/coe/category` | `Category` | `auth:coe` |
| GET | `/coe/inv` | `InvitedEx` | Public |
| GET | `/coe/attachment/{id}` | `CallendarView@attachment` | Public |

### API Routes (`/api/coe/*`)

| Method | URL | Fungsi |
|--------|-----|--------|
| GET | `/api/coe/dashboard/` | Semua statistik dashboard |
| GET | `/api/coe/dashboard/ytd` | Year-to-Date count |
| GET | `/api/coe/dashboard/count-annual` | Total event tahunan |
| GET | `/api/coe/dashboard/annual-completion` | Completion rate |
| GET | `/api/coe/dashboard/annual-on-going` | On-going events |
| GET | `/api/coe/dashboard/bycategory` | Count by category |
| GET | `/api/coe/dashboard/thismonth` | Stats bulan ini |
| GET | `/api/coe/dashboard/thisyear` | Stats tahun ini |
| GET | `/api/coe/dashboard/completion-by-month` | Completion per bulan |
| GET | `/api/coe/monthly-lists` | Count event per hari (Mobile) |
| GET | `/api/coe/day-lists` | List event per hari (Mobile) |
| GET | `/api/coe/event-details/{id}` | Detail event (Mobile) |

---

## 11. Alur Filter & Pencarian Data Dashboard

```mermaid
flowchart TD
    A[Request ke API Dashboard] --> B{Filter Aktif?}

    B -- Filter Perusahaan --> C["whereHas section\n→ department → company\nwhereIn company.id"]
    B -- Filter Bulan --> D["whereRaw MONTH(start_date) IN months"]
    B -- Filter Tahun --> E["whereRaw YEAR(start_date) IN years"]

    C --> F[Kombinasi Filter]
    D --> F
    E --> F

    F --> G[Query ke coe_events]
    G --> H[Return JSON Response]
```

---

## 12. Export & Import Data

| Fitur | Komponen | Format | Keterangan |
|-------|---------|--------|-----------|
| Export Event List | `Lists.php` | `.xlsx` | Export event yang dipilih (multi-select) |
| Export dari Kalender | `CallendarView.php` | `.xlsx` | Export semua event kalender |
| Import Event | `CallendarView.php` | `.xlsx / .xls` | Import massal via file Excel |

---

## 13. Kesimpulan Alur Sistem

```mermaid
flowchart LR
    subgraph "Aktor"
        A1[Admin / Creator]
        A2[Invited Users]
        A3[Mobile App]
        A4[External User]
    end

    subgraph "Modul CoE"
        W1[Dashboard Statistik]
        W2[Calendar View Interaktif]
        W3[Event List Tabular]
        W4[Add / Edit Event Form]
        W5[Category Manager]
        W6[Invited External Calendar]
    end

    subgraph "Database"
        DB1[(coe_events)]
        DB2[(coe_categories)]
        DB3[(users)]
        DB4[(sections / departments / companies)]
    end

    A1 --> W1
    A1 --> W2
    A1 --> W3
    A1 --> W4
    A1 --> W5
    A2 --> W2
    A2 --> W3
    A3 --> |API JSON| DB1
    A4 --> W6

    W4 --> DB1
    W4 --> |Email| A2
    W5 --> DB2
    W1 --> DB1
    W2 --> DB1
    W3 --> DB1
    W6 --> DB1
    DB1 --> DB3
    DB1 --> DB2
    DB1 --> DB4
```

---

*Dokumen ini dibuat secara otomatis berdasarkan analisis source code modul `Modules\Coe` pada sistem AIMS.*

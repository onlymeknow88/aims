# Panduan Penggunaan Python Watermark (`watermark.py`)

> **Lokasi Script**: `app/Helpers/watermark.py`
> **Dibuat**: 2026-06-16
> **Status**: ✅ Active

Script ini digunakan untuk menambahkan watermark semi-transparan ke seluruh halaman file PDF menggunakan **Python** dan library **PyMuPDF**. Watermark diletakkan di **tengah halaman** dan mendukung PDF portrait maupun landscape, termasuk yang disimpan dalam posisi terotasi.

---

## 📋 Daftar Isi

1. [Prasyarat Instalasi](#1-prasyarat-instalasi)
2. [Langkah Instalasi Detail](#2-langkah-instalasi-detail)
   - [2.1 Install Python](#21-install-python) — Windows, Ubuntu, CentOS 7/8/Stream 9, Amazon Linux
   - [2.2 Install PyMuPDF](#22-install-pymupdf) — Semua OS, termasuk tips gcc error
   - [2.3 Konfigurasi Khusus CentOS / RHEL](#23-konfigurasi-khusus-centos--rhel) — SELinux, Firewall, Restart Service, PATH
   - [2.4 Verifikasi Lingkungan](#24-verifikasi-lingkungan)
3. [Cara Menjalankan Script](#3-cara-menjalankan-script)
4. [Gambar Watermark yang Tersedia](#4-gambar-watermark-yang-tersedia)
5. [Parameter Konfigurasi](#5-parameter-konfigurasi)
6. [Integrasi dengan Laravel via PHP](#6-integrasi-dengan-laravel-via-php)
7. [Troubleshooting](#7-troubleshooting)

---

## 1. Prasyarat Instalasi

Pastikan semua komponen berikut terinstall sebelum menjalankan script:

| Komponen | Versi Minimum | Keterangan |
|----------|--------------|------------|
| **Python** | 3.8+ | Interpreter utama |
| **pip** | Bundled dengan Python 3 | Package manager Python |
| **PyMuPDF** (`fitz`) | 1.18+ | Library PDF editing |
| **PHP** | 7.4+ | Diperlukan jika dipanggil dari Laravel |

---

## 2. Langkah Instalasi Detail

### 2.1 Install Python

#### Windows

1. Buka browser, kunjungi: https://www.python.org/downloads/
2. Download **Python 3.8** atau versi lebih baru (contoh: Python 3.11.x)
3. Jalankan installer `.exe`
4. ⚠️ **PENTING**: Centang opsi **"Add Python to PATH"** sebelum klik Install
5. Klik **"Install Now"**
6. Verifikasi instalasi — buka **Command Prompt** atau **PowerShell** baru:

```powershell
python --version
# Output yang diharapkan: Python 3.x.x
```

#### Linux (Ubuntu / Debian)

```bash
sudo apt update && sudo apt install python3 python3-pip -y

# Buat alias 'python' jika belum ada (opsional tapi direkomendasikan)
sudo ln -s /usr/bin/python3 /usr/bin/python

# Verifikasi
python --version
```

#### Linux (CentOS 7)

CentOS 7 secara default hanya menyertakan Python 2. Python 3 harus diinstall secara manual:

```bash
# Langkah 1: Install EPEL Repository (diperlukan untuk Python 3)
sudo yum install epel-release -y

# Langkah 2: Install Python 3 dan pip
sudo yum install python3 python3-pip -y

# Langkah 3: Install build tools (diperlukan jika PyMuPDF dikompilasi dari source)
sudo yum groupinstall "Development Tools" -y
sudo yum install gcc gcc-c++ make openssl-devel libffi-devel -y

# Langkah 4: Buat symlink agar perintah 'python' mengarah ke Python 3
sudo alternatives --install /usr/bin/python python /usr/bin/python3 1
# atau
sudo ln -sf /usr/bin/python3 /usr/bin/python

# Verifikasi
python --version
pip3 --version
```

#### Linux (CentOS 8 / CentOS Stream 8 / RHEL 8)

CentOS 8 sudah memiliki Python 3 sebagai default namun perlu dikonfigurasi:

```bash
# Langkah 1: Install Python 3.8 atau versi tersedia
sudo dnf install python38 python38-pip -y
# atau versi lain yang tersedia:
sudo dnf install python3 python3-pip -y

# Langkah 2: Install build tools
sudo dnf groupinstall "Development Tools" -y
sudo dnf install gcc gcc-c++ make openssl-devel libffi-devel -y

# Langkah 3: Set python3 sebagai default
sudo alternatives --set python /usr/bin/python3
# atau buat symlink manual:
sudo ln -sf /usr/bin/python3 /usr/bin/python

# Verifikasi
python --version
pip3 --version
```

#### Linux (CentOS Stream 9 / RHEL 9 / AlmaLinux 9 / Rocky Linux 9)

```bash
# Langkah 1: Install Python 3.11 (default di CentOS Stream 9)
sudo dnf install python3 python3-pip python3-devel -y

# Langkah 2: Install build tools
sudo dnf groupinstall "Development Tools" -y

# Langkah 3: Buat symlink
sudo ln -sf /usr/bin/python3 /usr/bin/python

# Verifikasi
python --version
pip3 --version
```

#### Amazon Linux 2

```bash
# Langkah 1: Enable Python 3.8 via amazon-linux-extras
sudo amazon-linux-extras enable python3.8
sudo yum install python3.8 -y

# Langkah 2: Buat symlink
sudo ln -sf /usr/bin/python3.8 /usr/bin/python
sudo ln -sf /usr/bin/pip3.8 /usr/bin/pip3

# Verifikasi
python --version
```

---

### 2.2 Install PyMuPDF

PyMuPDF adalah library Python untuk membaca dan memodifikasi file PDF. Library ini di-import dalam script sebagai `fitz`.

#### Windows & Linux Ubuntu/Debian (via pip)

```bash
pip install pymupdf
```

#### Linux CentOS 7 (via pip3)

```bash
# Gunakan pip3 karena pip mungkin mengarah ke Python 2
pip3 install pymupdf

# Jika gagal karena pip3 versi lama, upgrade terlebih dahulu:
pip3 install --upgrade pip
pip3 install pymupdf
```

#### Linux CentOS 8 / Stream / RHEL 8+

```bash
# Pastikan menggunakan pip yang terhubung ke Python 3
python3 -m pip install pymupdf

# Atau via pip3:
pip3 install pymupdf
```

#### Jika muncul error gcc/compiler saat install (CentOS)

Beberapa versi PyMuPDF dikompilasi dari source jika tidak ada wheel yang cocok:

```bash
# Install compiler dan library yang diperlukan terlebih dahulu
sudo yum install gcc gcc-c++ make python3-devel -y   # CentOS 7
sudo dnf install gcc gcc-c++ make python3-devel -y   # CentOS 8/Stream/RHEL 8+

# Kemudian coba install kembali
pip3 install pymupdf
```

#### Verifikasi instalasi PyMuPDF

```bash
python -c "import fitz; print('PyMuPDF version:', fitz.version)"
# Output yang diharapkan: PyMuPDF version: ('1.xx.x', '1.xx.x', None)

# Jika binary 'python' belum ada, gunakan:
python3 -c "import fitz; print('PyMuPDF version:', fitz.version)"
```

> **Note**: Tidak ada dependensi eksternal lain yang diperlukan. PyMuPDF menyertakan engine MuPDF secara bundled (~50 MB disk space).

---

### 2.3 Konfigurasi Khusus CentOS / RHEL

#### 2.3.1 Konfigurasi SELinux (jika PHP tidak bisa memanggil Python)

CentOS/RHEL menggunakan SELinux yang secara default dapat **memblokir** `exec()` dari PHP:

```bash
# Cek status SELinux
getenforce
# Output: Enforcing (aktif) / Permissive / Disabled

# Cek apakah SELinux memblokir eksekusi:
grep -i 'avc.*denied' /var/log/audit/audit.log | tail -20

# Solusi 1 — Beri izin httpd menjalankan script (direkomendasikan)
setsebool -P httpd_execmem on
setsebool -P httpd_enable_cgi on
setsebool -P httpd_unified on

# Solusi 2 — Buat custom SELinux policy dari audit log
grep httpd /var/log/audit/audit.log | audit2allow -M mypol
semodule -i mypol.pp

# Solusi 3 — Set ke Permissive (HANYA untuk development/testing)
sudo setenforce 0
# Untuk permanen, edit /etc/selinux/config:
# SELINUX=permissive
```

#### 2.3.2 Konfigurasi Firewall (opsional)

Jika server menggunakan firewalld (umum di CentOS 7/8):

```bash
# Cek status firewall
sudo systemctl status firewalld

# Buka port HTTP/HTTPS jika perlu
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

#### 2.3.3 Restart Web Server di CentOS

Setelah mengubah konfigurasi PHP, restart service:

```bash
# Apache (httpd) di CentOS 7
sudo systemctl restart httpd

# Apache (httpd) di CentOS 8 / Stream
sudo systemctl restart httpd

# Nginx + PHP-FPM di CentOS 7
sudo systemctl restart nginx
sudo systemctl restart php-fpm

# Nginx + PHP-FPM di CentOS 8 (sesuaikan versi PHP)
sudo systemctl restart nginx
sudo systemctl restart php8.0-fpm   # atau php7.4-fpm, php8.1-fpm

# Cek status setelah restart
sudo systemctl status httpd
```

#### 2.3.4 Verifikasi PATH Python untuk Web Server Process

Web server (Apache/Nginx) mungkin menjalankan dengan user berbeda (`apache`, `www-data`, `nginx`) dan memiliki PATH yang berbeda:

```bash
# Cek lokasi binary python
which python3
# Output contoh: /usr/bin/python3

# Pastikan path ini bisa diakses oleh user web server
ls -la /usr/bin/python3

# Test eksekusi sebagai user apache (CentOS)
sudo -u apache python3 --version
# atau
sudo -u apache /usr/bin/python3 --version
```

> **Tip CentOS**: Jika perintah `python` tidak ditemukan oleh web server, ubah pemanggilan di PHP dari `python` menjadi full path seperti `/usr/bin/python3`.

---

### 2.4 Verifikasi Lingkungan

Jalankan perintah berikut untuk memastikan semuanya siap:

```bash
# Cek Python
python --version

# Cek pip
pip --version

# Cek PyMuPDF
python -c "import fitz; print('OK:', fitz.version)"

# Cek script ada di tempat yang benar
# (jalankan dari root folder Laravel)
python app/Helpers/watermark.py
# Output yang diharapkan: Usage: watermark.py <input_pdf> <output_pdf> <watermark_image> <mode>
```

---

## 3. Cara Menjalankan Script

### 3.1 Sintaks Perintah

```bash
python <path_ke_script> <input_pdf> <output_pdf> <watermark_image> <mode>
```

### 3.2 Deskripsi Argumen

| Posisi | Argumen | Keterangan |
|--------|---------|------------|
| 1 | `input_pdf` | Path lengkap ke file PDF sumber yang ingin diberi watermark |
| 2 | `output_pdf` | Path lengkap ke file PDF hasil output (akan dibuat baru) |
| 3 | `watermark_image` | Path lengkap ke file gambar watermark `.png` |
| 4 | `mode` | Mode watermark: `rooting` atau `review` |

### 3.3 Contoh Penggunaan

#### Windows (PowerShell) — Mode `rooting` (Final Approve)

```powershell
# Jalankan dari root folder Laravel (c:\laragon\www\aims)
python app\Helpers\watermark.py `
  "public\NamaFile.pdf" `
  "public\output_watermarked.pdf" `
  "public\images\watermark.png" `
  rooting
```

#### Windows (PowerShell) — Mode `review` (Uncontrolled Copy)

```powershell
python app\Helpers\watermark.py `
  "public\NamaFile.pdf" `
  "public\output_uncontrolled.pdf" `
  "public\images\uncontrolled.png" `
  review
```

#### Linux / macOS (Bash)

```bash
python app/Helpers/watermark.py \
  "public/NamaFile.pdf" \
  "public/output_watermarked.pdf" \
  "public/images/watermark.png" \
  rooting
```

### 3.4 Output yang Diharapkan

```
Success
```

Jika **berhasil**, script mencetak `Success` dan keluar dengan kode `0`.

Jika **gagal**, script mencetak pesan error dan keluar dengan kode `1`.

---

## 4. Gambar Watermark yang Tersedia

| Mode | Gambar | Path |
|------|--------|------|
| `rooting` | Untuk dokumen Final Approve / Rooting Approval | `public/images/watermark.png` |
| `review` | Untuk dokumen Uncontrolled Copy oleh CRS Reviewer | `public/images/uncontrolled.png` |

> Kedua file gambar ini harus berukuran `500×500` px atau lebih besar, format PNG dengan **alpha channel** (transparan). Script akan secara otomatis menyesuaikan skala gambar terhadap dimensi halaman.

---

## 5. Parameter Konfigurasi

Parameter dapat diubah langsung di dalam file `app/Helpers/watermark.py`:

### 5.1 Opacity (Tingkat Transparansi)

```python
# Baris ~104 dalam watermark.py
WATERMARK_OPACITY = 0.15   # 0.0 = tidak terlihat, 1.0 = penuh
```

| Nilai | Efek Visual |
|-------|------------|
| `0.05` | Sangat samar, hampir tidak terlihat |
| `0.10` | Sangat transparan |
| `0.15` | **Default** — sangat halus, teks tetap terbaca jelas |
| `0.25` | Cukup terlihat |
| `0.50` | Setengah transparan |
| `1.00` | Penuh/opaque |

### 5.2 Ukuran Watermark Berdasarkan Orientasi

```python
# Baris ~23-32 dalam watermark.py
is_landscape = page_w > page_h
if is_landscape:
    max_w = page_w * 0.60   # Landscape: 60% dari lebar halaman
    max_h = page_h * 0.60   # Landscape: 60% dari tinggi halaman
else:
    max_w = page_w * 0.70   # Portrait: 70% dari lebar halaman
    max_h = page_h * 0.70   # Portrait: 70% dari tinggi halaman
```

| Orientasi | Faktor Skala | Keterangan |
|-----------|-------------|------------|
| **Portrait** | `0.70` (70%) | Lebih besar agar proporsional di halaman tinggi |
| **Landscape** | `0.60` (60%) | Lebih kecil agar proporsional di halaman lebar |

> Script secara otomatis mempertahankan **aspect ratio** gambar watermark dan selalu menempatkannya **tepat di tengah** halaman, termasuk pada halaman yang disimpan dalam posisi terotasi (landscape PDF dengan `page.rotation = 90`).

---

## 6. Integrasi dengan Laravel via PHP

### 6.1 Cara PHP Memanggil Script

Script dipanggil dari PHP menggunakan fungsi `exec()`:

```php
$scriptPath = app_path('Helpers/watermark.py');
$cmd = "python " . escapeshellarg($scriptPath)
     . " " . escapeshellarg($inputPdfPath)
     . " " . escapeshellarg($outputPdfPath)
     . " " . escapeshellarg($watermarkImagePath)
     . " rooting";

exec($cmd, $outputCmd, $returnVar);

if ($returnVar !== 0) {
    // Error: watermark gagal
    // Fallback: copy file tanpa watermark
}
```

### 6.2 Lokasi Pemanggilan dalam Codebase

| File PHP | Fungsi | Mode | Dipanggil Saat |
|----------|--------|------|---------------|
| `Modules/DocumentSystem/Services/DocumentSystemService.php` | `handle_document_rooting_approval()` | `rooting` | PJA menekan tombol **Final Approve** |
| `Modules/DocumentSystem/Http/Livewire/Review/ReviewDetail.php` | `setWaterMark()` | `review` | CRS menekan tombol approve di halaman review |
| `app/Services/DocumentSystemService.php` | `handle_document_rooting_approval()` | `rooting` | (App layer — sama seperti Module) |
| `app/Http/Livewire/DocumentSystems/Review/ReviewDetail.php` | `setWaterMark()` | `review` | (App layer — sama seperti Module) |

### 6.3 Prasyarat PHP

Pastikan fungsi `exec()` **tidak diblokir** di `php.ini`:

```ini
; Cari baris ini di php.ini dan pastikan 'exec' tidak ada dalam daftar
disable_functions = pcntl_alarm,pcntl_fork,...
;                   ^-- hapus 'exec' dari sini jika ada
```

Setelah mengubah `php.ini`, restart server (Apache/Nginx):

```bash
# Ubuntu / Debian
sudo systemctl restart apache2
# atau
sudo systemctl restart nginx && sudo systemctl restart php8.x-fpm

# CentOS 7 / RHEL 7 (Apache)
sudo systemctl restart httpd

# CentOS 8 / Stream / RHEL 8+ (Apache)
sudo systemctl restart httpd

# CentOS / RHEL (Nginx + PHP-FPM)
sudo systemctl restart nginx
sudo systemctl restart php-fpm
```

> **Khusus CentOS**: Lokasi `php.ini` biasanya di `/etc/php.ini` (Apache) atau `/etc/php-fpm.d/www.conf` (PHP-FPM). Cek dengan: `php --ini | grep 'Loaded Configuration'`

Verifikasi dari Laravel Tinker:

```php
php artisan tinker
>>> function_exists('exec')
=> true   // harus true

>>> exec('python --version', $out); print_r($out);
// Array ( [0] => Python 3.x.x )
```

---

## 7. Troubleshooting

| Masalah | Kemungkinan Penyebab | Solusi |
|---------|---------------------|--------|
| `python: command not found` | Python tidak ada di PATH | Install Python, centang "Add to PATH" saat install (Windows) atau buat symlink (Linux) |
| `python3: command not found` di Linux | Nama binary berbeda | Gunakan `python3` atau `sudo ln -sf /usr/bin/python3 /usr/bin/python` |
| `ModuleNotFoundError: No module named 'fitz'` | PyMuPDF belum diinstall | Jalankan `pip install pymupdf` atau `pip3 install pymupdf` |
| `error: command 'gcc' failed` saat `pip install pymupdf` | Build tools tidak ada (CentOS) | `sudo yum install gcc gcc-c++ python3-devel -y` lalu install ulang |
| `Error opening source PDF` | File tidak ditemukan atau path salah | Periksa path file PDF sumber |
| `Error saving output PDF: Permission denied` | File output sedang dibuka di viewer lain | Tutup PDF viewer, coba ganti nama file output |
| `Python watermarking script returned error code 1` | Script error saat runtime | Jalankan perintah manual dari terminal untuk melihat detail error |
| Watermark tidak terlihat | Opacity terlalu rendah atau `overlay=False` | Naikkan nilai `WATERMARK_OPACITY`, pastikan `overlay=True` |
| Watermark menutupi teks (terlalu gelap) | Opacity terlalu tinggi | Turunkan `WATERMARK_OPACITY` (contoh: `0.10`) |
| Watermark miring pada PDF landscape | Halaman PDF memiliki rotasi bawaan | Script sudah handle ini otomatis via `page.rotation` dan `page.derotation_matrix` |
| Watermark tidak di tengah halaman landscape | Rotasi koordinat tidak dipetakan | Script sudah handle ini via `dest_rect * page.derotation_matrix` |
| `exec()` tidak berfungsi di PHP | `disable_functions` memblokir `exec` | Edit `php.ini`, hapus `exec` dari daftar, restart server |
| `exec()` diblokir di CentOS meski sudah di-enable | SELinux memblokir httpd | `setsebool -P httpd_execmem on` atau `setenforce 0` (dev only) |
| `python not found` dari web server CentOS | Web server punya PATH berbeda | Gunakan full path `/usr/bin/python3` di pemanggilan PHP |
| Watermark tidak muncul di file hasil approve | Kondisi skip dalam PHP aktif | Pastikan tidak ada kondisi `if ($already_watermarked)` yang meng-skip proses |

---

## 📝 Catatan Tambahan

- Script **tidak mengubah file PDF sumber** — selalu menghasilkan file baru sebagai output.
- Untuk setiap halaman dalam PDF (multi-page), watermark disisipkan secara otomatis.
- Script mendukung **semua versi PDF** (1.0 hingga 1.7+) karena PyMuPDF menggunakan engine MuPDF.
- Tidak diperlukan package Composer PHP tambahan — semua dependensi ada di sisi Python.

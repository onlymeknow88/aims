<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .page-break {
            page-break-after: always;
        }

        @page {
            margin: 100px 25px 25px 25px;
        }

        p {
            margin: 0;
            margin-bottom: 5px;
        }

        header {
            position: fixed;
            font-size: 16px !important;
            color: black;
            text-align: center;
            top: -70px;
            /* top: 0; */
            font-weight: 700;
            left: 0;
            right: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            padding: 5px;
            vertical-align: top;
        }

        header table tbody tr td {
            border: 1px solid black;
            padding: 5px;
            position: relative;
        }

        header table tbody tr td:nth-child(1) {
            width: 20%;
        }

        header table tbody tr td:nth-child(2) {
            width: 50%;
            text-align: center;
        }

        header table tbody tr td:nth-child(3) {
            text-align: left;
            font-weight: 400;
            font-size: 12px;
            width: 30%;
        }

        header table tbody tr td div span:first-child {
            width: 40%;
            display: inline-block;
        }

        footer {
            position: fixed;
            bottom: -70px;
            color: black;
            width: 100%;
        }

        /* main{
                margin: 120px 25px;
            } */
        .tgl {
            display: inline-block;
            margin-bottom: 30px;
        }

        .tgl span:first-child {
            display: inline-block;
            width:
        }

        .data-diri table tr td:first-child {
            width: 25%;
        }

        .content {
            margin-top: 30px;
        }

        .content table {
            width: 100%;
        }

        .content table td {
            border: 1px solid black;
        }

        .content table td .checkbox {
            width: 20px;
            height: 20px;
            border: 1px solid black;
            margin: 0 auto;
        }

        .ttd {
            margin-top: 50px;
        }

        .ttd table tbody td:nth-child(1) {
            width: 25%;
        }

        .ttd table tbody td:nth-child(2) {
            width: 50%;
        }

        .ttd table tbody td:nth-child(3) {
            width: 25%;
        }

        .ttd table tbody td .space-ttd {
            height: 60px;
        }

        .ttd .kurung {
            width: 100%;
        }

        .ttd .kurung:before {
            content: "(";
        }

        .ttd .kurung:after {
            content: ")";
            float: right;
        }
    </style>
</head>

<body>
    <header>
        <table border=0 width="100%">
            <tr>
                <td><img width="100" src="{{ public_path('images/adaro-mineral.png') }}" alt="" /></td>
                {{-- <td><img width="100" src="{{asset   ('images/adaro-mineral.png')}}" alt="" /></td> --}}
                <td>PERSYARATAN ADMINISTRATIF CALON PENANGGUNG JAWAB OPERASIONAL</td>
                <td>
                    <div>
                        <span>No. Dokumen</span>
                        <span>: F-MAC-IMS-11-001</span>
                    </div>
                    <div>
                        <span>No. Revisi</span>
                        <span>: 1.0</span>
                    </div>
                    <div>
                        <span>Tanggal</span>
                        <span>: 31-07-2022</span>
                    </div>

                </td>
            </tr>
        </table>
    </header>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        <div class="tgl">
            <table>
                <tbody>
                    <tr>
                        <td>Tanggal</td>
                        <td>: {{ $data['date'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="data-diri">
            <p>Pengajuan calon PJO pada Operasional di PT Maruwai Coal:</p>
            <table>
                <tbody>
                    <tr>
                        <td>Nama Calon PJO</td>
                        <td>: {{ $data['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Karyawan</td>
                        <td>: {{ $data['number_pjo'] }}</td>
                    </tr>
                    <tr>
                        <td>Perusahaan</td>
                        <td>: {{ $data['company'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="content">
            <p>Telah melengkapi daftar periksa kelengkapan administrasi sebagai berikut:</p>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Riwayat Hidup calon PJO – Pekerja perusahaan jasa pertambangan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Kompetensi (sesuai SKKNI, SKKKK, dll) dari Calon PJO, seperti: POP/POM/POU dan Implementasi
                            SMKP dan/atau Auditor SMKP</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Struktur Organisasi Perusahaan yang ditandatangani oleh Direksi dengan Cap Basah – Struktur
                            Organisasi Puncak dan Site Base</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Surat pernyataan dukungan dari Direksi Perusahaan Jasa Pertambangan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Surat pernyataan komitmen calon PJO (Penanggung Jawab Operasional)</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Proses Bisnis dan Subproses Bisnis kegiatan perusahaan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar IBPR (Tanggal pembuatan dan Tanggal Revisi) pada setiap proses bisnis dan subproses
                            kegiatan pertambangan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Pemenuhan Peraturan Perundang-undangan yang wajib dipenuhi oleh PJP (Perusahaan Jasa
                            Pertambangan), (Persentase Sudah terpenuhi dan belum terpenuhi)</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Peraturan Internal Perusahaan yang berhubungan dengan penerapan Kaidah Teknik
                            Pertambangan yang baik</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Jumlah Manpower (Operasional, Administrasi & Pengawas)</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Pengawas Operasional, Pengawas Teknis dan Tenaga Teknis Pertambangan. (Yang sudah
                            ditunjuk oleh PJO dan sudah/belum disetujui oleh KTT)</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Jumlah Pengawas Operasional dan Pengawas Teknis yang sudah & belum kompeten. Komitmen
                            Pemenuhan Kompetensi100% pada Pengawas Operasional dan Pengawas Teknis</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Perusahaan Jasa Pertambangan (Sub-kontraktor) yang beroperasi di bawahnya - bila ada
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar Sarana, Prasarana, Instalasi & Peralatan Pertambangan (SPIP) yang menjadi tanggung
                            jawabnya – bila ada</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar rencana pelaksanaan kegiatan pengelolaan dan pemantauan lingkungan (sesuai dengan
                            bidang usaha di PT Maruwai Coal)</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Daftar rencana jumlah pengadaan, penggunaan, penyimpanan, dan persediaan bahan dan limbah
                            berbahaya dan beracun – bila ada</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Rencana (bila belum ada dan disetujui oleh PJA/KTT) Program Kerja (seperti: Target, Sasaran
                            & Program) Keselamatan Pertambangan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Menampilkan Laporan RAP (Rencana Anggaran Program) yaitu Rencana & Realisasi (Program &
                            Anggaran) dari RAP yang telah disetujui oleh KTT pada tahun berjalan Evaluasi PJO</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Metode Analisis Perencanaan Strategis dari issue yang ada dengan metode analisis SWOT - Bisa
                            dari pengalaman dan menampilkan dengan grafik dan gambar sebagai informasi dan keterangan
                            tambahan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>
                            Improvement bila menjadi PJO yang berhubungan dengan:
                            <ul>
                                <li>Penerapan Kajian Teknis Pertambangan sesuai Proses Bisnis PJP</li>
                                <li>Penerapan SMKP - Implementasi, Training ISMKP & Auditor</li>
                                <li>Keselamatan Pertambangan</li>
                                <li>Budaya Keselamatan Pertambangan Karyawan</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Dokumen bukti pemegang IPJP yang diterbitkan Oleh Menteri, melaporkan IPJP-nya kepada
                            Gubernur tempat kegiatan usahanya sebelum memulai kegiatan usahanya</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Bagi warga negara asing yang sudah disahkan sebagai PJO maka dilanjutkan dengan lulus Uji
                            Kemahiran Berbahasa Indonesia dengan predikat paling kurang madya dalam jangka waktu 6
                            (enam) bulan. KTT dapat membatalkan kembali pengesahan tersebut apabila PJO tersebut belum
                            lulus Uji Kemahiran Berbahasa Indonesia dalam jangka waktu yang telah ditetapkan</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="content">
            <p>Penilaian Calon PJO untuk PJP Inti meliputi hal-hal berikut yang akan dilakukan oleh KTT:</p>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Pemahaman aspek pengelolaan PJP sesuai dengan peraturan perundang-undangan tentang Kaidah
                            teknik usaha jasa pertambangan dan kewajiban usaha jasa pertambangan dan Pedoman evaluasi
                            kaidah teknik usaha jasa pertambangan</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Pemahaman terhadap aspek teknis pertambangan, konservasi, keselamatan pertambangan,
                            perlindungan lingkungan pertambangan, pemenuhan kewajiban perusahaan jasa pertambangan dan
                            penerapan Kaidah Teknik Pertambangan Yang Baik sesuai dengan peraturan perundang-undangan
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Jenjang sertifikasi kompetensi pengawas operasional atau sertifikasi kualifikasi yang diakui
                            oleh KaIT yang ditentukan berdasarkan pertimbangan KTT</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox"></div>
                        </td>
                        <td>Menerapkan Sistem Manajemen Keselamatan Pertambangan (SMKP) dan Melakukan Pengawasan
                            Penerapan Sistem Manajemen Keselamatan Pertambangan (SMKP)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="ttd">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="ttd-left">
                                <p>Yang bertanda tangan,</p>
                                <div class="space-ttd"></div>
                                <div class="kurung"></div>
                                <p>Direktur Perusahaan</p>
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div class="ttd-left">
                                <p>Mengetahui,</p>
                                <div class="space-ttd"></div>
                                <div class="kurung">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <p>Kepala Teknik Tambang</p>
                                <p>PT. Maruwai Coal</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

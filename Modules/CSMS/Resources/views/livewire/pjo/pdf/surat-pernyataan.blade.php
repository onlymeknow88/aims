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
            width: 50%;
        }

        .ttd table tbody td {
            width: 25%;
        }

        .ttd table tbody td:nth-child(2) {
            width: 50%;
        }

        .ttd table tbody td:nth-child(3) {
            width: 25%;
        }

        .ttd table tbody td .space-ttd {
            height: 100px;
        }

        .ttd .kurung {
            width: 70%;
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
            <p>Saya yang bertanda tangan dibawah ini:</p>
            <table>
                <tbody>
                    <tr>
                        <td>Nama</td>
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
            <p>Sebagai Calon PJO yang akan bekerja di PT Maruwai Coal, saya berkomitmen untuk:</p>
            <ol>
                <li>Bersedia memenuhi persyaratan sebagai PJO yang telah ditetapkan oleh PT Maruwai Coal paling lama 6
                    bulan sejak disetujui pengajuan calon PJO oleh KTT PT Maruwai Coal.</li>
                <li>Melaksanakan menajemen risiko pada setiap proses bisnis dan subproses kegiatan pertambangan.</li>
                <li>Bersedia mengikuti, mematuhi dan menerapkan standar sesuai dengan ketentuan perundang-undangan dan
                    setiap ketentuan berlaku dalam wilayah kerja PT. Maruwai Coal.</li>
                <li>Bertanggung jawab terhadap terlaksananya Aspek Teknis Pertambangan, Keselamatan Pertambangan (K3 dan
                    Keselamatan Operasi) dan Perlindungan Lingkungan sesuai dengan peraturan yang berlaku.</li>
                <li>Melaporkan kegiatan Keselamatan Pertambangan dan Lingkungan Hidup kepada Kepala Teknik Tambang dalam
                    memenuhi Laporan penerapan Kaidah Teknik Pertambangan yang baik kepada KTT, baik laporan berkala,
                    akhir, dan/atau khusus paling lambat tanggal 5 dan /atau sesuai dengan ketentuan SOP. </li>
                <li>Bersedia melaksanakan dan menyelesaikan tugas dengan sebaik-baiknya, sesuai dengan kesepakatan
                    bersama antara Perusahaan yang saya pimpin dan PT. Maruwai Coal.</li>
                <li>Berkomitmen dalam Penerapan Sistem Manajemen Keselamatan Pertambangan (SMKP) dalam perusahaannya dan
                    berkomitmen dalam melakukan pengawasan penerapan SMKP yang dilaksanakan oleh Perusahaan Jasa
                    Pertambangan yang bekerja di wilayah tanggung jawabnya (bagi PJP yang memiliki Sub PJP). </li>
                <li>Perusahaan Jasa Pertambangan Inti WAJIB menyampaikan laporan audit internal penerapan Sistem
                    Manajemen Keselamatan Pertambangan (SMKP) kepada KTT PT Maruwai Coal sesuai dengan
                    perundang-undangan dan SOP PT Maruwai Coal.</li>
                <li>Menetapkan tata cara baku untuk penerapan Kaidah Teknik Pertambangan Yang Baik dan melaksanakan
                    konservasi sumber daya mineral dan batubara.</li>
                <li>Memenuhi Laporan Penerapan Kaidah Teknik Pertambangan Yang Baik dan Pelaksanaan kegiatan pengelolaan
                    dan pemantauan keselamatan pertambangan dan lingkungan secara berkala sesuai dengan bentuk yang
                    ditetapkan</li>
                <li>Memenuhi dan memiliki tenaga pengawas operasional, pengawas teknik dan tenaga teknik pertambangan
                    yang berkompeten sesuai dengan ketentuan perundang-undangan dan SOP PT Maruwai Coal.</li>
                <li>Menyampaikan pemberitahuan awal kecelakaan, kejadian berbahaya, kejadian akibat penyakit tenaga
                    kerja dan penyakit akibat kerja dan kasus lingkungan paling lambat 1x24 jam (satu Kali dua puluh
                    empat) jam dan melaporkan laporan yang telah dilengkapi dan berikut upaya penanggulannya sesuai
                    dengan SOP PT Maruwai Coal.</li>
                <li>Menetapkan tata cara baku untuk penanggulanan pencemaran dan/atau perusakan lingkungan pada tempat
                    yang berpotensi menimbulkan perusakan dan pencemaran lingkungan.</li>
                <li>Bersedia menerima sanksi apapun, apabila dalam melaksanakan tugas tidak sesuai dengan ketentuan yang
                    telah ditetapkan oleh PT. Maruwai Coal.</li>
            </ol>
            <p>Demikian pernyataan komitmen ini saya buat dengan sebenar-benarnya tanpa ada paksaan dari pihak manapun.
            </p>
        </div>

        <div class="ttd">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <div class="ttd-left">
                                <p>Yang Membuat Pernyataan,</p>
                                <div class="space-ttd"></div>
                                <div class="kurung"></div>
                                <p>Calon Penanggung Jawab Operasional (PJO)</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .text-center {
            text-align: center !important
        }

        .text-right {
            text-align: right !important
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }

        .container-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto
        }

        .page-break {
            page-break-after: always;
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
            border: 1px solid black;
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

        .text-lowercase {
            text-transform: lowercase !important
        }

        .text-uppercase {
            text-transform: uppercase !important
        }

        .text-capitalize {
            text-transform: capitalize !important
        }

        .font-weight-light {
            font-weight: 300 !important
        }

        .font-weight-normal {
            font-weight: 400 !important
        }

        .font-weight-bold {
            font-weight: 700 !important
        }

        .font-italic {
            font-style: italic !important
        }


        .table-bordered {
            border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
            border-bottom-width: 2px
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6 !important
        }

        .mt-5,
        .my-5 {
            margin-top: 3rem !important
        }

        .main-header {
            text-align: center;
        }

        .wrapper-sertifikat {
            color: black;
            font-size: 14px;
        }

        .wrapper-sertifikat .border,
        .wrapper-sertifikat .border-top,
        .wrapper-sertifikat .border-bottom,
        .wrapper-sertifikat .border-left,
        .wrapper-sertifikat .border-right {
            border-color: #000000 !important;
        }

        .check-box {
            width: 20px;
            height: 20px;
            border: 1px solid #000000;
            display: inline-block;
            vertical-align: middle;
            margin: 5px 0;
        }

        .space-ttd {
            height: 100px;
        }

        table>tbody>tr>td,
        table>tbody>tr>th,
        table>tfoot>tr>td,
        table>tfoot>tr>th,
        table>thead>tr>td,
        table>thead>tr>th {
            border-color: #000000;
            padding: 2px;
            line-height: 1.2;
        }

        .table-bordered>tbody>tr>td,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>td,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>thead>tr>th {
            border-color: #000000;
            padding: 2px;
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }

        .detail-sertifikat table.table-bordered td {
            font-size: 12px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .status-kesehatan table.table-bordered td {
            font-size: 14px;
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>

<body>

    <div class="wrapper-sertifikat">

        <div class="header mb-3">

            <div class="container p-0">

                <table style="width: 100%">
                    <tr>
                        <td style="width:15%;"><img src="{{ public_path('images/logo-login.png') }}" alt=""
                                height="50" />
                        </td>
                        <td style="width:50%;">
                            <div class="title-sertifikat text-center font-weight-bold">
                                <br>
                                SURAT PENGANTAR PASIEN (RUJUKAN)
                            </div>
                        </td>

                        <td style="width:35%;">
                            <table class="table-borderless">
                                <tr>
                                    <td>No. Dokumen</td>
                                    <td>:</td>
                                    <td>F-MAC-IHH-02-006</td>
                                </tr>
                                <tr>
                                    <td>No. Revisi</td>
                                    <td>:</td>
                                    <td>2.0</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>02-09-2023</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div><!-- /.container -->

        </div><!-- /.header -->

        <div class="content-sertifikat mb-4">

            <div class="detail-sertifikat mb-4">

                <div class="keterangan-wrapper">
                    <div class="container">
                        <div class="row">
                            <br>
                            <div class="title-sertifikat text-right font-weight-bold">
                                KLINIK PRATAMA MUARA TUHUP dan LAMPUNUT
                                <br>
                                Site Adaro Met Coal
                            </div>
                            <div class="title-sertifikat text-right">
                                Kab. Murung Raya
                                <br>
                                Nomor Izin Operasional No.: 440 / 01 / DPMPTSP / 2019 dan 440 / 02 / DPMPTSP / 2020
                            </div>
                            <br>
                            <div>
                                <div class="title-sertifikat text-center font-weight-bold">Surat Pengantar Pasien</div>
                                <div class="title-sertifikat text-center font-weight-bold"><i>Referral Letter</i></div>
                            </div>
                            <br>

                            <table class="table-borderless" style="width: 100%;">
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>{{ $letterNumber }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ $mcuDate }}</td>
                                </tr>
                            </table>
                            <br>
                            <div class="keterangan-content mb-3">
                                <span style="display:block;">
                                    Kepada Yth./ To
                                    <br>
                                    Dr. ..........................
                                    <br>
                                    Di / at
                                    <br>
                                    ..............................
                                    <br>
                                    <br>
                                    Bersama ini saya rujuk pasien. <i>I hereby refer the patient</i>
                                </span>
                            </div>

                            <br>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="container p-0">

                    <table style="width: 100%;">
                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Nama</span>
                                    <span class="font-italic" style="width:100%; display:block;">Name</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $employeeName }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Tanggal Lahir</span>
                                    <span class="font-italic" style="width:100%; display:block;">Date Of Birth</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $employeeBd }} ({{ $employeeAge }}
                                        Tahun)</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">NIK / NRP</span>
                                    <span class="font-italic" style="width:100%; display:block;">Company ID
                                        Number</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $employeeNIK }}/{{ $employeeNRP }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Perusahaan</span>
                                    <span class="font-italic" style="width:100%; display:block;">Company</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $company }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Jabatan</span>
                                    <span class="font-italic" style="width:100%; display:block;">Position</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $position }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Diagnosis & Pengobatan</span>
                                    <span class="font-italic" style="width:100%; display:block;">Diagnose &
                                        Therapy</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{!! $mcuDiagnose !!}</div>
                                </div>
                            </td>
                        </tr>
                        {{--
                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Hasil MCU</span>
                                    <span class="font-italic" style="width:100%; display:block;">MCU Result</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $mcuResult }}</div>
                                </div>
                            </td>
                        </tr> --}}

                    </table>

                </div><!-- /.container -->

            </div><!-- /.detail-sertifikat -->

            <div class="keterangan-wrapper">
                <div class="container">
                    <div class="row">
                        <br>
                        <div class="keterangan-content mb-3">
                            <span style="display:block;">Mohon untuk diberikan pengobatan dan perwatan selanjutnya dari
                                sejawat. Jawaban dan saran
                                dari sejawat sangat saya harapkan.</span>
                            <span style="display:block;" class="font-italic">I would be grateful for your further
                                examination and treatment. Your prompt reply would be highly
                                appreciated.</span>
                        </div>
                        <br>
                        <div class="keterangan-content mb-3">
                            <span style="display:block;">Terimakasih</span>
                            <span style="display:block;" class="font-italic">Thank you</span>
                        </div>
                        <br>
                        <div class="keterangan-content mb-3">
                            <span style="display:block;">Hormat kami, </span>
                            <span style="display:block;" class="font-italic">Yours sincerely</span>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="keterangan-content mb-3">
                            <span style="display:block;">{{ $doctor }}</span>
                        </div>

                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div><!-- /.keterangan-wrapper -->


        </div><!-- /.wrapper-sertifikat -->


        <div class="wrapper-sertifikat mt-5">

            <div class="header mb-3">

                <div class="container p-0">

                    <table style="width: 100%">
                        <tr>
                            <td style="width:15%;"><img src="{{ public_path('images/logo-login.png') }}"
                                    alt="" height="50" />
                            </td>
                            <td style="width:50%;">
                                <div class="title-sertifikat text-center font-weight-bold">
                                    <br>
                                    SURAT PENGANTAR PASIEN (RUJUKAN)
                                </div>
                            </td>

                            <td style="width:35%;">
                                <table class="table-borderless">
                                    <tr>
                                        <td>No. Dokumen</td>
                                        <td>:</td>
                                        <td>F-MAC-IHH-02-006</td>
                                    </tr>
                                    <tr>
                                        <td>No. Revisi</td>
                                        <td>:</td>
                                        <td>2.0</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>02-09-2023</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div><!-- /.container -->

            </div><!-- /.header -->


            <div class="content-sertifikat mb-4">

                <div class="detail-sertifikat mb-4">

                    <div class="keterangan-wrapper">
                        <div class="container">
                            <div class="row">
                                <br>
                                <br>
                                <div>
                                    <div class="title-sertifikat text-center font-weight-bold">Surat Jawaban Konsul
                                    </div>
                                    <div class="title-sertifikat text-center font-weight-bold"><i>Consulting Discharge
                                            Letter</i>
                                    </div>
                                </div>

                                <br>

                                <div class="keterangan-content mb-3">
                                    <span style="display:block;">
                                        Kepada Yth./ To
                                        <br>
                                        Dr. Klinik CHPP-Lampunut Project
                                        <br>
                                        Di / at
                                        <br>
                                        Tempat
                                        <br>
                                        <br>
                                        Menjawab konsul saudara mengenai orang sakit.
                                    </span>
                                    <span style="display:block;" class="font-italic">Concerning the:</span>
                                </div>

                                <br>
                            </div>
                        </div>
                    </div>

                    <div class="container p-0">

                        <table style="width: 100%;">
                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Nama</span>
                                        <span class="font-italic" style="width:100%; display:block;">Name</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        {{-- <div class="content font-weight-bold">{{ $employeeName }}</div> --}}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Tanggal Lahir</span>
                                        <span class="font-italic" style="width:100%; display:block;">Date Of
                                            Birth</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        {{-- <div class="content font-weight-bold">{{ $employeeAge }} Tahun</div> --}}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">NIK / NRP</span>
                                        <span class="font-italic" style="width:100%; display:block;">Company ID
                                            Number</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        {{-- <div class="content font-weight-bold">{{ $company }}</div> --}}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Perusahaan</span>
                                        <span class="font-italic" style="width:100%; display:block;">Company</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        {{-- <div class="content font-weight-bold">{{ $company }}</div> --}}
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Diagnosis</span>
                                        <span class="font-italic" style="width:100%; display:block;">Diagnose</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        {{-- <div class="content font-weight-bold">{{ $mcuDate }}</div> --}}
                                    </div>
                                </td>
                            </tr>
                            </tr>

                        </table>

                    </div><!-- /.container -->

                </div><!-- /.detail-sertifikat -->

                <div class="keterangan-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="keterangan-contentmb-3">
                                <br>
                                <span style="display:block;">Adapun hasil-hasil pemeriksaan yang didapatkan. </span>
                                <span style="display:block;" class="font-italic">Please find the following
                                    examination/treatment carried out during the care</span>
                            </div>
                            <div class="keterangan-content mb-3">
                                <br>
                                <span style="display:block;">Pemeriksaan Fisik : </span>
                                <span style="display:block;" class="font-italic">Physical assessment</span>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>

                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Diagnosa :</span>
                                <span style="display:block;" class="font-italic">Diagnose</span>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>

                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Pengobatan :</span>
                                <span style="display:block;" class="font-italic">Therapy</span>
                                <br>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Perencanaan</span>
                                <span style="display:block;" class="font-italic">Planning</span>
                            </div>

                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Atas konsul sejawat kami sampaikan terimakasih.</span>
                                <span style="display:block;" class="font-italic">Thanks for your referring this
                                    patient to me.</span>
                                ................................
                            </div>

                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Salam, </span>
                                <span style="display:block;" class="font-italic">Yours sincerely</span>
                                <br>
                            </div>

                            <div class="keterangan-content mb-3">
                                <span style="display:block;">
                                    Dr. ..........................</span>
                                {{-- <span style="display:block;" class="font-italic">Yours sincerely</span> --}}
                                <br>
                            </div>

                        </div>
                    </div>
                </div><!-- /.keterangan-wrapper -->


            </div><!-- /.wrapper-sertifikat -->

</body>

</html>

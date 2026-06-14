<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .text-center {
            text-align: center !important
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

    <div class="wrapper-sertifikat mt-5">

        <div class="header mb-3">
            <div class="container p-0">

                <table class="table-bordered">
                    <tr>
                        <td style="width:15%;"><img src="{{ public_path('images/logo-login.png') }}" alt=""
                                height="50" />
                        </td>
                        <td style="width:50%;">
                            <div class="title-sertifikat text-center font-weight-bold">SERTIFIKAT KESEHATAN KERJA (SKK)
                                / OCCUPATIONAL HEALTH CERTIFICATE</div>
                        </td>
                        <td style="width:35%;">
                            <table class="table-borderless">
                                <tr>
                                    <td>No. Dokumen</td>
                                    <td>:</td>
                                    <td>F-MAC-IHH-02-003</td>
                                    {{-- <td>{{ $docNumber }}</td> --}}
                                </tr>
                                <tr>
                                    <td>No. Revisi</td>
                                    <td>:</td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>01-11-2023</td>
                                    {{-- <td>{{ $docDate }}</td>F-MAC-IHH-02-008 --}}
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div><!-- /.container -->
        </div><!-- /.header -->

        <div class="content-sertifikat mb-4">

            <div class="nomer-wrapper mb-4">

                <div class="container p-0">

                    <table>
                        <tr>
                            <td class="font-weight-bold">NOMOR SKK</td>
                            <td>:</td>
                            <td class="font-weight-bold">{{ $letterNumber }}</td>
                        </tr>
                    </table>

                </div>

            </div><!-- /.nomer-wrapper -->

            <div class="detail-sertifikat mb-4">

                <div class="container p-0">

                    <table class="table-bordered" style="width: 100%;">

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
                                    <span class="font-italic"
                                        style="width:100%; display:block;">Date Of Birth</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $employeeBd }} ({{ $employeeAge }} Tahun)</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">NIK / NRP</span>
                                    <span class="font-italic" style="width:100%; display:block;">Company ID Number</span>
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
                                    <span style="width:100%; display:block;">Departemen/Divisi</span>
                                    <span class="font-italic" style="width:100%; display:block;">Department/Division</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $employeeDepartment }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Tanggal Pemeriksaan MCU</span>
                                    <span class="font-italic" style="width:100%; display:block;">Examination
                                        Date</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $mcuDate }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Dokter Peninjau</span>
                                    <span class="font-italic" style="width:100%; display:block;">Reviewing
                                        Doctor</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $doctor }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Penyedia Jasa pemeriksaan Kesehatan</span>
                                    <span class="font-italic" style="width:100%; display:block;">Medical checkup
                                        provider</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $mcuProvider }}</div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Jenis Pemeriksaan Kesehatan</span>
                                    <span style="width:100%; display:block;">Type of Medical assessment</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $medicalType }}</div>
                                </div>
                            </td>
                        </tr>

                        {{-- <tr>
                            <td style="width:30%;">
                                <div class="label">
                                    <span style="width:100%; display:block;">Departemen Pendamping</span>
                                    <span class="font-italic" style="width:100%; display:block;">Host/ Sponsor
                                        Department</span>
                                </div>
                            </td>
                            <td style="width:2%; text-align:center;">
                                <div class="">:</div>
                            </td>
                            <td style="width:68%;">
                                <div class="">
                                    <div class="content font-weight-bold">{{ $mcuCompanionDept }}</div>
                                </div>
                            </td>
                        </tr> --}}

                    </table>

                </div><!-- /.container -->

            </div><!-- /.detail-sertifikat -->

            <div class="status-kesehatan mb-4">

                <div class="container">

                    <table class="table-bordered" style="width: 50%; margin-left:auto; margin-right:auto;">

                        <tr>
                            <td style="width:5%; text-align:center;">
                                <div class="check-box">
                                    @if ($status == 'Fit')
                                        <div class="status-content font-weight-bold">V</div>
                                    @endif
                                </div>
                            </td>
                            <td style="width:75%;">
                                <div class="status-content font-weight-bold">FIT</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:5%; text-align:center;">
                                <div class="check-box">
                                    @if ($status == 'Fit With Recomendation')
                                        <div class="status-content font-weight-bold">V</div>
                                    @endif
                                </div>
                            </td>
                            <td style="width:75%;">
                                <div class="status-content font-weight-bold">FIT WITH RECOMMENDATION</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:5%; text-align:center;">
                                <div class="check-box">
                                    @if ($status == 'Curently Unfit')
                                        <div class="status-content font-weight-bold">V</div>
                                    @endif
                                </div>
                            </td>
                            <td style="width:75%;">
                                <div class="status-content font-weight-bold">CURENTLY UNFIT</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="width:5%; text-align:center;">
                                <div class="check-box">
                                    @if ($status == 'Unfit')
                                        <div class="status-content font-weight-bold">V</div>
                                    @endif
                                </div>
                            </td>
                            <td style="width:75%;">
                                <div class="status-content font-weight-bold">UNFIT</div>
                            </td>
                        </tr>

                    </table>

                </div><!-- /.container -->

            </div><!-- /.status-kesehatan -->

            <div class="keterangan-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="keterangan-content mb-3">
                            <span style="display:block;">Telah diperiksa dan ditinjau ulang hasil pemeriksaan kesehatan
                                berdasarkan Kriteria Hasil Pemeriksaan Kesehatan (F-MAC-IHH-02-002) yang ditetapkan oleh
                                perusahaan.
                            </span>
                            <span style="display:block;" class="font-italic">It has been examined and reviewed in
                                accordance with Company Criterion for Medical Checkup requirement.
                            </span>
                        </div>

                        @if ($status == 'Unfit')

                        @else
                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Sertifikat ini berlaku dari
                                    <strong>{{ $validFrom }}</strong> hingga
                                    <strong>{{ $validUntil }}</strong>
                                    </span>
                                <span style="display:block;" class="font-italic">This health certificate will be valid
                                    from <strong>{{ $validFrom }}</strong> until
                                    <strong>{{ $validUntil }}</strong>
                                </span>
                            </div>
                        @endif

                    </div>
                </div>
            </div><!-- /.keterangan-wrapper -->


            @if ($status == 'Unfit')
                <br>
                <br>
            @else
                <div class="note-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="content-note">
                                <h6 class="font-weight-bold">Note:</h6>
                                <ol class="list-group-unstyled">
                                    {!! $note ? $note : '-' !!}
                                    {{-- <li class="font-weight-bold">Kontrol ke dr sp pd, 3 bln kemudian</li>
                                    <li class="font-weight-bold">Pastikan melaksanakan anjuran dr sp pd</li> --}}
                                </ol>
                            </div>
                        </div>
                    </div>
                </div><!-- /.note-wrapper -->
            @endif

        </div><!-- /.content-sertifikat -->

        <div class="footer-sertifikat">
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col">
                        {{-- <div class="date-sertifikat">Adaro Village, {{ $validFrom }}</div> --}}
                        <div class="label-ttd">Dokter Peninjau / <span class="font-italic">Reviewing doctor</span>,
                        </div>
                        <div class="space-ttd"></div>
                        <div class="name-ttd">{{ $doctor }}</div>
                    </div>
                </div>
            </div>
        </div><!-- /.footer-sertifikat -->

    </div><!-- /.wrapper-sertifikat -->

</body>

</html>

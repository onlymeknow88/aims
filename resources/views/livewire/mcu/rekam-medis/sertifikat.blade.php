<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">

        <title>Sertifikat Adaro</title>
        {{-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"> --}}
        <link rel="stylesheet" href="{{public_path('assets/css/bootstrap.min.css')}}">
        <style>
            @page { margin: 0px; }
            body { margin: 0px; }
            .wrapper-sertifikat{
                color:black;
                font-size: 14px;
            }
            .wrapper-sertifikat .border,
            .wrapper-sertifikat .border-top,
            .wrapper-sertifikat .border-bottom,
            .wrapper-sertifikat .border-left,
            .wrapper-sertifikat .border-right{
                border-color: #000000 !important;
            }
            .check-box{
                width:20px;
                height: 20px;
                border: 1px solid #000000;
                display: inline-block;
                vertical-align: middle;
                margin: 5px 0;
            }
            .space-ttd{
                height:100px;
            }
            table > tbody > tr > td,
            table > tbody > tr > th,
            table > tfoot > tr > td,
            table > tfoot > tr > th,
            table > thead > tr > td,
            table > thead > tr > th {
                border-color: #000000;
                padding: 2px;
                line-height: 1.2;
            }
            .table-bordered > tbody > tr > td,
            .table-bordered > tbody > tr > th,
            .table-bordered > tfoot > tr > td,
            .table-bordered > tfoot > tr > th,
            .table-bordered > thead > tr > td,
            .table-bordered > thead > tr > th {
                border-color: #000000;
                padding: 2px;
            }
            .table-borderless > tbody > tr > td,
            .table-borderless > tbody > tr > th,
            .table-borderless > tfoot > tr > td,
            .table-borderless > tfoot > tr > th,
            .table-borderless > thead > tr > td,
            .table-borderless > thead > tr > th {
                border: none;
            }
            .detail-sertifikat table.table-bordered td{
                font-size: 12px;
                padding-left: 5px;
                padding-right: 5px;
            }

            .status-kesehatan table.table-bordered td{
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
                            <td style="width:15%;"><img src="{{public_path('images/logo-login.png')}}" alt="" /></td>
                            <td style="width:50%;"><div class="title-sertifikat text-center font-weight-bold">SERTIFIKAT KESEHATAN KERJA (SKK) SEMENTARA / TEMPORARY OCCUPATIONAL HEALTH CERTIFICATE</div></td>
                            <td style="width:35%;">
                                <table class="table-borderless">
                                    <tr>
                                        <td>No. Dokumen</td>
                                        <td>:</td>
                                        <td>{{$no_doc ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>No. revisi</td>
                                        <td>:</td>
                                        <td>{{$revisi ?? '-'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{$tgl_doc ?? '-'}}</td>
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
                                <td class="font-weight-bold">NOMOR SKKs</td>
                                <td>:</td>
                                <td class="font-weight-bold">{{$no_skks ?? '-'}}</td>
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
                                        <div class="content font-weight-bold">{{$nama ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Tanggal Lahir</span>
                                        <span class="font-italic" style="width:100%; display:block;">Date of Birth</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$tgl_lahir ?? '-'}}</div>
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
                                        <div class="content font-weight-bold">{{$perusahaan ?? '-'}}</div>
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
                                        <div class="content font-weight-bold">{{$jabatan ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Dokter Peninjau</span>
                                        <span class="font-italic" style="width:100%; display:block;">Reviewing Doctor</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$dokter_peninjau ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Tanggal Pemeriksaan MCU</span>
                                        <span class="font-italic" style="width:100%; display:block;">Examination Date</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$tgl_mcu ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Penyedia Jasa pemeriksaan Kesehatan</span>
                                        <span class="font-italic" style="width:100%; display:block;">Medical checkup provider</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$tempat_mcu ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Nama Pendamping</span>
                                        <span style="width:100%; display:block;">Host/ Sponsor Name</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$pendamping ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:30%;">
                                    <div class="label">
                                        <span style="width:100%; display:block;">Departemen Pendamping</span>
                                        <span class="font-italic" style="width:100%; display:block;">Host/ Sponsor Department</span>
                                    </div>
                                </td>
                                <td style="width:2%; text-align:center;">
                                    <div class="">:</div>
                                </td>
                                <td style="width:68%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$dept_pendamping ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div><!-- /.container -->

                </div><!-- /.detail-sertifikat -->

                <div class="status-kesehatan mb-4">

                    <div class="container">

                        <table class="table-bordered" style="width: 50%; margin-left:auto; margin-right:auto;">

                            <tr>
                                <td style="width:5%; text-align:center;">
                                    <div class="check-box border-white"></div>
                                </td>
                                <td style="width:75%;">
                                    <div class="status-content font-weight-bold">FIT</div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:5%; text-align:center;">
                                    <div class="check-box"></div>
                                </td>
                                <td style="width:75%;">
                                    <div class="status-content font-weight-bold">FIT WITH RECOMMENDATION</div>
                                </td>
                            </tr>

                        </table>

                    </div><!-- /.container -->

                </div><!-- /.status-kesehatan -->

                <div class="keterangan-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Telah diperiksa dan ditinjau ulang hasil pemeriksaan kesehatan berdasarkan Kriteria Hasil Pemeriksaan Kesehatan (F-MAC-IHH-02-002) yang ditetapkan oleh perusahaan.</span>
                                <span style="display:block;" class="font-italic">It has been examined and reviewed in accordance with Company Criterion for Medical Checkup requirement.</span>
                            </div>
                            <div class="keterangan-content mb-3">
                                <span style="display:block;">Sertifikat ini berlaku dari <strong>{{$berlaku_dari ?? '-'}}</strong> hingga <strong>{{$berlaku_sampai ?? '-'}}</strong></span>
                                <span style="display:block;" class="font-italic">This health certificate will be valid from <strong>{{$berlaku_dari ?? '-'}}</strong> until <strong>{{$berlaku_sampai ?? '-'}}</strong></span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.keterangan-wrapper -->

                <div class="note-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="content-note">
                                <h6 class="font-weight-bold">Note:</h6>
                                <ol class="list-group-unstyled">
                                    <li class="font-weight-bold">Kontrol ke dr sp pd, 3 bln kemudian</li>
                                    <li class="font-weight-bold">Pastikan melaksanakan anjuran dr sp pd</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div><!-- /.note-wrapper -->

            </div><!-- /.content-sertifikat -->

            <div class="footer-sertifikat">
                <div class="container p-0">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="date-sertifikat">Adaro Village, {{$berlaku_dari ?? '-'}}</div>
                            <div class="label-ttd">Dokter Peninjau / <span class="font-italic">Reviewing doctor</span>,</div>
                            <div class="space-ttd"></div>
                            <div class="name-ttd">{{$dokter_peninjau ?? '-'}}</div>
                        </div>
                    </div>
                </div>
            </div><!-- /.footer-sertifikat -->

        </div><!-- /.wrapper-sertifikat -->

    </body>
</html>

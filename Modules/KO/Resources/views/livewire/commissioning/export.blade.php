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

        <title>Commissioning</title>
        {{-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"> --}}
        <link rel="stylesheet" href="{{public_path('assets/css/bootstrap.min.css')}}">
        <style>
            @page { margin: 0px; margin-top: 10px }
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

                    <table class="table-bordered" style="width: 100%">
                        <tr style="width: 100%">
                            <td style="width:5%;">
                                <img src="{{public_path('images/logo-login.png')}}" alt="" />
                            </td>
                            <td style="width:55%;">
                                <div class="title-sertifikat text-center font-weight-bold">Formulir Komisioning - {{$data->koUnit->koSpipUnit->name}}</div>
                            </td>
                            <td style="width:40%;">
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

                <div class="detail-sertifikat mb-4">

                    <div class="container p-0">

                        <table class="table-bordered" style="width: 100%;">

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Tanggal Pra / Komisioning
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koCommissioning->date}}</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Merk
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koUnit->koBrand->name ?? '-'}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Perusahaan
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->company->company_name}}</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Model Unit
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koUnit->model_unit}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Department
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->department->name ?? $data->other_department}}</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Tahun Pembuatan
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koUnit->production_year}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Nomer Unit
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koUnit->call_sign}}</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    SMU / ODOMETER
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koCommissioning->commissioning_completion_date}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Nomer Serial
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koUnit->serial_number}}</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Status Mesin
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koCommissioning->engine_status}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Tanggal Lulus Komisioning
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">-</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Tanggal Kadaluarsa
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">{{$data->koCommissioning->expired_date}}</div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td style="width:15%; background-color: #BFBFBF">
                                    Komisioning Periode
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">1</div>
                                    </div>
                                </td>

                                <td style="width: 2%; border-top: 0; border-bottom: 0"></td>

                                <td style="width:15%; background-color: #BFBFBF">
                                    Status komisioning
                                </td>
                                <td style="width:2%; text-align:center; border-left: 0; background-color: #BFBFBF">
                                    :
                                </td>
                                <td style="width:31%;">
                                    <div class="">
                                        <div class="content font-weight-bold">-</div>
                                    </div>
                                </td>
                            </tr>

                        </table>

                    </div><!-- /.container -->

                </div><!-- /.detail-sertifikat -->

                <div class="status-kesehatan mb-4">

                    <div class="container">

                        <table class="table-bordered" style="width: 100%;">

                            <tr style="border-left:1px solid #dddddd;">
                                <th>#</th>
                                <th>ITEMS / DESKRIPSI</th>
                                <th>KONDISI / FUNGSI</th>
                                <th>KETERANGAN dan DEVIASI</th>
                                <th>KODE BAHAYA</th>
                            </tr>

                            <tbody>
                                @foreach($data->koUnit->koSpipUnit->koCommisioningHeaders as $key => $header)
                                    <tr>
                                        <td>{{$header->number}}.</td>
                                        <td colspan="4"><b>DOKUMEN KENDARAAN</b></td>
                                    </tr>
                                    @foreach($header->koCommisioningFields as $key => $field)
                                    <tr>
                                        <td>{{$field->number}}.</td>
                                        <td style="white-space: normal">
                                            @php
                                                echo $field->question;
                                            @endphp
                                        </td>
                                        <td>
                                            {{$field->koCommissioningItem($data->koCommissioning->id)->first()->condition}}
                                        </td>
                                        <td style="white-space: normal">
                                            {{$field->koCommissioningItem($data->koCommissioning->id)->first()->note ?? '-'}}
                                        </td>
                                        <td class="text-center">{{$field->hazard_code}}</td>
                                    </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>

                    </div><!-- /.container -->

                </div><!-- /.status-kesehatan -->

            </div><!-- /.content-sertifikat -->

            {{--<div class="footer-sertifikat">
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
            </div><!-- /.footer-sertifikat -->--}}

        </div><!-- /.wrapper-sertifikat -->

    </body>
</html>

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
        {{-- <link rel="stylesheet" media="print" href="{{public_path('assets/css/bootstrap.min.css')}}"> --}}
        <style>
            @page { margin: 0px; }
            body { margin: 0px; }
            .page-break {
                page-break-after: always;
            }
            /*.wrapper-sertifikat{
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
            }*/

            .table-bordered {

            }

            .text-center {
                text-align: center;
            }
        </style>

    </head>
    <body>
        @foreach($proposals as $key => $proposal)
            @if($key != 0)
                <div class="page-break"></div>
            @endif
            <div class="container p-0">
                <table class="table-bordered" style="width: 100%; border: 2px solid black; border-color: black">
                    <tr style="width: 100%">
                        <td style="padding: 10px"> 
                            <table class="table-bordered" style="width: 100%; border: 2px solid black; border-color: black">
                                <tr style="width: 100%">
                                    <td style="width:70%; padding-top: 10px">
                                        <div class="title-sertifikat text-center font-weight-bold">
                                            <h5><b>KOMISIONING SPIP</b></h5>
                                            <p style="font-size: 9px">ADARO METCOAL COMPANIES</p>   
                                        </div>
                                    </td>
                                    <td style="width:30%; padding: 20px">
                                        <img style="width: 100%" src="{{public_path('images/adaro-mineral.png')}}" alt="" /><br>
                                        <img style="width: 100%" src="{{public_path('images/adaro-mindset.PNG')}}" alt="" />
                                    </td>
                                </tr>
                            </table>
                            <table class="table-borderless" style="width: 100%;">
                                <tr style="width:100%">
                                    <td>
                                        <div class="title-sertifikat font-weight-bold">
                                            {{$proposal->company->company_name}}                               
                                        </div>
                                    </td>
                                    <td align="right" style="text-align: right;">
                                        {{$proposal->koUnit->call_sign}} 
                                    </td>                     
                                </tr>
                            </table>
                            <table class="table-bordered" style="width: 100%; border: 2px solid black; border-color: black">
                                <tr style="width: 100%">
                                    <td style="width:100%;" colspan="2">
                                        <img src="data:image/png;base64, {!! $proposal->getQrCode() !!}">
                                    </td>                           
                                </tr>
                            </table>
                            <table class="table-borderless" style="width: 100%;">
                                <tr style="width: 100%">
                                    <td style="width: 70%;">
                                        <div class="title-sertifikat font-weight-bold">
                                            {{$proposal->ccow->company_name}}                                        
                                        </div>
                                    </td>
                                    <td align="right" style="width: 30%; text-align: right;">
                                        AMC{{ $proposal->updated_at->format('Y') }}
                                    </td>                            
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div><!-- /.container -->

            @endforeach


    </body>
</html>

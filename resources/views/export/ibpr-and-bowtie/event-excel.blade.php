<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$event->name}}</title>
</head>

<body>

    <table style="flex-wrap: wrap !important; background-color: #ebf1d1 !important;border: 1px solid #000 !important">
        {{-- Head --}}
        <tr>
            <th style="width: 10px"></th> {{-- A --}}
            <th style="width: 20px"></th> {{-- B --}}
            <th style="width: 30px"></th> {{-- C --}}
            <th style="width: 150px"></th> {{-- D --}}
            <th style="width: 100px"></th> {{-- E --}}
            <th style="width: 150px"></th> {{-- F --}}
            <th style="width: 80px"></th> {{-- G --}}
            <th style="width: 20px"></th> {{-- H --}}
            <th style="width: 100px"></th> {{-- I --}}
            <th style="width: 30px"></th> {{-- J --}}
            <th style="width: 30px"></th> {{-- K --}}
            <th style="width: 80px"></th> {{-- L --}}
            <th style="width: 30px"></th> {{-- M --}}
            <th style="width: 30px"></th> {{-- N --}}
            <th style="width: 80px"></th> {{-- O --}}
            <th style="width: 80px"></th> {{-- P --}}
            <th style="width: 30px"></th> {{-- Q --}}
            <th style="width: 100px"></th> {{-- R --}}
            <th style="width: 50px"></th> {{-- S --}}
            <th style="width: 50px"></th> {{-- T --}}
            <th style="width: 150px"></th> {{-- U --}}
            <th style="width: 30px"></th> {{-- V --}}
            <th style="width: 30px"></th> {{-- W --}}
            <th style="width: 80px"></th> {{-- X --}}
            <th style="width: 30px"></th> {{-- Y --}}
            <th style="width: 30px"></th> {{-- Z --}}
            <th style="width: 30px"></th> {{-- AA --}}
            <th style="width: 150px"></th> {{-- AB --}}
            <th style="width: 80px"></th> {{-- AC --}}
            <th style="width: 100px"></th> {{-- AD --}}
            <th style="width: 30px"></th> {{-- AE --}}
            <th style="width: 50px"></th> {{-- AF --}}
            <th style="width: 50px"></th> {{-- AG --}}
            <th style="width: 100px"></th> {{-- AH --}}
        </tr>
        {{-- Head --}}

        {{-- Title --}}
        <tr>
            <th></th> {{-- A --}}
            <th></th> {{-- B --}}
            <th></th> {{-- C --}}
            <th></th> {{-- D --}}
            <th></th> {{-- E --}}
            <th></th> {{-- F --}}
            <th></th> {{-- G --}}
            <th></th> {{-- H --}}
            <th></th> {{-- I --}}
            <th></th> {{-- J --}}
            <th></th> {{-- K --}}
            <th></th> {{-- L --}}
            <th colspan="11"
                style="flex-wrap: wrap !important; color: #000000;font-weight: bolder;vertical-align: center;text-align: center;font-size: 20px;">
                <u>
                    BOW-TIE RISK ANALYSIS
                </u>
            </th>
            <th></th> {{-- X --}}
            <th></th> {{-- Y --}}
            <th></th> {{-- Z --}}
            <th></th> {{-- AA --}}
            <th></th> {{-- AB --}}
            <th></th> {{-- AC --}}
            <th></th> {{-- AD --}}
            <th></th> {{-- AE --}}
            <th></th> {{-- AF --}}
            <th></th> {{-- AG --}}
            <th></th> {{-- AH --}}
        </tr>
        {{-- Title --}}

        {{-- GAP --}}
        <tr>
            <th></th>
        </tr>
        {{-- GAP --}}

        {{-- ROW 1 --}}
        <tr>
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                PERUSAHAAN
            </th>
            <th colspan="5"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                @if($event->bowtie->iup == 'INTERNAL')
                    {{$event->bowtie->ccow->company_name ?? ''}}
                @elseif($event->bowtie->iup == 'CONTRACTOR')
                    {{$event->bowtie->contractor->company_name ?? ''}}
                @else
                    {{$event->bowtie->sub_contractor->company_name ?? ''}}
                @endif
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="11"
                style="flex-wrap: wrap !important; background-color: yellow; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                PENJELASAN KEJADIAN RISIKO
            </th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                PENANGGUNG JAWAB RISIKO
            </th>
            <th colspan="5"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                {{$event->bowtie->pja->name ?? ''}}
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th rowspan="3" colspan="11"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000">
                {{$event->description ?? ''}}
            </th>
            <th rowspan="3"></th>
            <th rowspan="3"></th>
            <th rowspan="3"></th>
        </tr>
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                PENANGGUNG JAWAB PENGENDALIAN KRITIS
            </th>
            <th colspan="5"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                @foreach($event->bowtie->teams as $key => $team) {{$team->user_name ?? ''}}, @endforeach
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                NOMOR ID BOWTIE
            </th>
            <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                {{$event->bowtie->document_no ?? ''}}
            </th>
        </tr>
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                JUDUL RISIKO
            </th>
            <th colspan="5"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                {{$event->bowtie->risk_title ?? ''}}
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                TANGGAL
            </th>
            <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff; color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                {{$event->bowtie->request_date ?? ''}}
            </th>
        </tr>
        {{-- ROW 1 --}}

        {{-- GAP --}}
        <tr>
            <th></th>
        </tr>
        {{-- GAP --}}

        {{-- ROW 2 --}}
        <tr>
            <th></th> {{-- A --}}
            <th></th> {{-- B --}}
            <th></th> {{-- C --}}
            <th></th> {{-- D --}}
            <th></th> {{-- E --}}
            <th></th> {{-- F --}}
            <th></th> {{-- G --}}
            <th></th> {{-- H --}}
            <th></th> {{-- I --}}
            <th></th> {{-- J --}}
            <th></th> {{-- K --}}
            <th></th> {{-- L --}}
            <th colspan="11"
                style="flex-wrap: wrap !important; color: #000000;font-weight: bolder;vertical-align: center;text-align: center;font-size: 10px;">
                KERUGIAN MAKSIMAL SEMUA KENDALI TIDAK EFEKTIF
            </th>
            <th></th> {{-- X --}}
            <th></th> {{-- Y --}}
            <th></th> {{-- Z --}}
            <th></th> {{-- AA --}}
            <th></th> {{-- AB --}}
            <th></th> {{-- AC --}}
            <th></th> {{-- AD --}}
            <th></th> {{-- AE --}}
            <th></th> {{-- AF --}}
            <th></th> {{-- AG --}}
            <th></th> {{-- AH --}}
        </tr>
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #4a63ca; color: #000; vertical-align: center; font-size: 11px; text-align: left; border: 1px solid #000;">
                PENYEBAB
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                TIPE DAMPAK
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                KEPARAHAN
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                KERUGIAN MAKSIMAL
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TIPE DAMPAK
            </th>
            <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000">
                PENJELASAN
            </th>
        </tr>

        @php
            $min = 11;
            $reasons_count = $event->reasons->count();
            $min = $min > $reasons_count ? $min : $reasons_count;
        @endphp

        @for($i=0; $i<$min; $i++)
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                {{$i + 1}}
            </th>
            <th colspan="6"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                {{$event->reasons[$i]->name ?? ''}}
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

            <!-- 1 -->
            @if($i == 0)
                <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    K3
                </th>
            @elseif($i == 1)
                <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    LH
                </th>
            @elseif($i == 2)
                <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    KSL
                </th>
            @elseif($i == 3)
                <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    KP
                </th>
            @elseif($i == 4)
                <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    KK
                </th>
            @elseif($i == 5)

            @elseif($i == 6)
                <th colspan="7"
                    style="flex-wrap: wrap !important; color: #000000;font-weight: bolder;vertical-align: center;text-align: center;font-size: 10px;">
                    TINGKAT RISIKO SISA SETELAH PENGENDALIAN
                </th>
            @elseif($i == 7)
                <th colspan="3"
                    style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    TINGKAT RISIKO SISA &#40;TRR&#41;
                </th>
            @elseif($i == 8)
                <th colspan="3"
                    style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    Keparahan (K)
                </th>
            @elseif($i == 9)
                <th colspan="3"
                    style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    Kemungkinan (P)
                </th>
            @elseif($i == 10)
                <th colspan="3"
                    style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    TRR
                </th>
            @else
                <th></th>
            @endif


            @if($i == 0)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->k3_severity}}
                </th>
            @elseif($i == 1)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->lh_severity}}
                </th>
            @elseif($i == 2)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->ksl_severity}}
                </th>
            @elseif($i == 3)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->kp_severity}}
                </th>
            @elseif($i == 4)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->kk_severity}}
                </th>
            @elseif($i == 5)

            @elseif($i == 6)

            @elseif($i == 7)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    FAKTOR
                </th>
            @elseif($i == 8)
                <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->severity_factor ?? ''}}
                </th>
            @elseif($i == 9)
                <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->likelihood_factor ?? ''}}
                </th>
            @elseif($i == 10)
                 <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #FFA600;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->trr_factor ?? ''}}
                </th>
            @else
                <th></th>
            @endif

            
            @if($i == 0)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->k3_max_loss}}
                </th>
            @elseif($i == 1)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->lh_max_loss}}
                </th>
            @elseif($i == 2)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->ksl_max_loss}}
                </th>
            @elseif($i == 3)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->kp_max_loss}}
                </th>
            @elseif($i == 4)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->kk_severity}}
                </th>
            @elseif($i == 5)

            @elseif($i == 6)

            @elseif($i == 7)
                <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #4aca55;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    PENJELASAN
                </th>
            @elseif($i == 8)
                <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->severity_explain ?? ''}}
                </th>
            @elseif($i == 9)
                <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->likelihood_explain ?? ''}}
                </th>
            @elseif($i == 10)
                <th colspan="2"
                    style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$event->trr_explanation ?? ''}}
                </th>
            @else
                <th></th>
            @endif

            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

            @if($i == 0)
                <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$i + 1}}
                </th>
            @elseif($i == 1)
                <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$i + 1}}
                </th>
            @elseif($i == 2)
                <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$i + 1}}
                </th>
            @elseif($i == 3)
                <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$i + 1}}
                </th>
            @elseif($i == 4)
                <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                    {{$i + 1}}
                </th>
            @else
                <th></th>
            @endif

            <!-- 5 -->
            @if($i == 0)
                <th
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                    Keselamatan dan Kesehatan Kerja &#40;K3&#41;
                </th>
            @elseif($i == 1)
                <th
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                    Lingkungan Hidup &#40;LH&#41;
                </th>
            @elseif($i == 2)
                <th
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                    Komunitas Sosial Lokal &#40;KSL&#41;
                </th>
            @elseif($i == 3)
                <th
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                    Kepatuhan terhadap Peraturan &#40;KP&#41;
                </th>
            @elseif($i == 4)
                <th
                style="flex-wrap: wrap !important; background-color: #d3d3d3;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                    Kerugian Keuangan &#40;KK&#41;
                </th>
            @else
                <th></th>
            @endif

            <!-- 6 -->
            @if($i == 0)
                <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                    {{$event->impact_k3 ?? ''}}
                </th>
            @elseif($i == 1)
                <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                    {{$event->impact_lh ?? ''}}
                </th>
            @elseif($i == 2)
                <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                    {{$event->impact_ksl ?? ''}}
                </th>
            @elseif($i == 3)
                <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                    {{$event->impact_kp ?? ''}}
                </th>
            @elseif($i == 4)
                <th colspan="7"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000">
                    {{$event->impact_kk ?? ''}}
                </th>
            @else
                <th>
            @endif
        </tr>
        @endfor
        {{-- ROW 2 --}}

        {{-- GAP --}}
        <tr>
            <th>&nbsp;</th>
        </tr>
        {{-- GAP --}}

        {{-- ROW 3 --}}
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="9"
                style="flex-wrap: wrap !important; background-color: #6583f9;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                TINDAKAN KENDALI PENCEGAHAN SAAT INI
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #6583f9; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                KAITAN DENGAN PENYEBAB
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #6583f9;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                KENDALI KRITIKAL
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #6583f9;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                PENANGGUNG JAWAB KENDALI
            </th>
            <th></th>
            <th colspan="9"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TINDAKAN MITIGASI DAMPAK YANG ADA SAAT INI
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                KAITAN DENGAN DAMPAK
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                MITIGASI KRITIKAL
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                PENNGUNG JAWAB MITIGASI
            </th>
        </tr>

        @php
            $min = $event->cmf->count() > $event->imm->count() ? $event->cmf->count() : $event->imm->count();
        @endphp

        @for($i=0; $i<$min; $i++)
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                {{isset($event->cmf[$i]) ? $i+1 : ''}}
            </th>
            <th colspan="8"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                {{$event->cmf[$i]->control_measures ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf[$i]->associated_with_cause ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf[$i]->critical_control ?? ''}}
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf[$i]->person_in_control ?? ''}}
            </th>
            <th></th>
            <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                {{isset($event->imm[$i]) ? $i+1 : ''}}
            </th>
            <th colspan="8"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                {{$event->imm[$i]->mitigation_measures ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm[$i]->mitigation_associated_with_cause ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm[$i]->mitigation_critical ?? ''}}
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm[$i]->mitigation_person_in_control ?? ''}}
            </th>
        </tr>
        @endfor
        {{-- ROW 3 --}}

        {{-- GAP --}}
        <tr>
            <th>&nbsp;</th>
        </tr>
        {{-- GAP --}}

        {{-- ROW 4 --}}
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th colspan="9"
                style="flex-wrap: wrap !important; background-color: #6583f9; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TUGAS PERBAIKAN
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #6583f9; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TANGGAL TEMPO
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #6583f9; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                PENANGGUNG JAWAB
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #6583f9; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TANGGAL PENYELESAIAN
            </th>
            <th></th>
            <th colspan="9"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center;  border: 1px solid #000;">
                TUGAS PERBAIKAN
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TANGGAL TEMPO
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000; vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                PENANGGUNG JAWAB
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #35a93e; color: #000;  vertical-align: center; font-size: 11px; text-align: center; border: 1px solid #000;">
                TANGGAL PENYELESAIAN
            </th>
        </tr>

        @php
            $min = $event->cmf_repair->count() > $event->imm_repair->count() ? $event->cmf_repair->count() : $event->imm_repair->count();
        @endphp

        @for($i=0; $i<$min; $i++)
        <tr style="flex-wrap: wrap !important; border: 1px;border-color: #0000;">
            <th></th>
            <th></th>
            <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                {{isset($event->cmf_repair[$i]) ? $i+1 : ''}}
            </th>
            <th colspan="8"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                {{$event->cmf_repair[$i]->repair_task ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf_repair[$i]->due_date ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf_repair[$i]->person_responsible ?? ''}}
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->cmf_repair[$i]->completion_date ?? ''}}
            </th>
            <th></th>
            <th
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000">
                {{isset($event->imm_repair[$i]) ? $i+1 : ''}}
            </th>
            <th colspan="8"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: left;border: 1px solid #000;">
                {{$event->imm_repair[$i]->repair_task ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm_repair[$i]->due_date ?? ''}}
            </th>
            <th colspan="2"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm_repair[$i]->person_responsible ?? ''}}
            </th>
            <th colspan="3"
                style="flex-wrap: wrap !important; background-color: #fff;color: #000;vertical-align: center;font-size: 11px;text-align: center;border: 1px solid #000;">
                {{$event->imm_repair[$i]->completion_date ?? ''}}
            </th>
        </tr>
        @endfor
        {{-- ROW 4 --}}
    </table>

</body>

</html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PERFORMANCE STANDARD</title>
</head>

<body>
    <table style="border: 1px solid #000000">
        <tr>
            <th style="width: 15px"></th> {{-- A --}}
            <th style="width: 200px"></th> {{-- B --}}
            <th style="width: 250px"></th> {{-- C --}}
            <th style="width: 200px"></th> {{-- D --}}
            <th style="width: 200px"></th> {{-- E --}}
            <th style="width: 250px"></th> {{-- F --}}
            <th style="width: 150px"></th> {{-- G --}}
            <th style="width: 300px"></th> {{-- H --}}
            <th style="width: 300px"></th> {{-- I --}}
            <th style="width: 300px"></th> {{-- J --}}
            <th style="width: 200px"></th> {{-- K --}}
            <th style="width: 200px"></th> {{-- L --}}
            <th style="width: 300px"></th> {{-- M --}}
            <th style="width: 300px"></th> {{-- N --}}
        </tr>

        <tr>
            <th></th>
            <th colspan="10" style="font-size: 18px; text-align:center; vertical-align:center">
                STANDAR KINERJA <br>
                PERFORMANCE STANDARD
            </th>
        </tr>
        <tr>
            <th></th>
        </tr>

        <tr>
            <th></th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                No ID
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Penjelasan Pengendalian
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Penanggung Jawab Pengendalian
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Tujuan Pengendalian
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Standar Kinerja Pengendalian Risiko Utama
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Kegiatan Verifikasi
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Bukti Verifikasi
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Pelaksanaan Verifikasi
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Pengetesan Efektifitas Pengendalian Kritis
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Pelaksanaan Pengetesan Efektifitas Pengendalian
            </th>
        </tr>

        @foreach($performances as $key => $performance)
        <tr>
            <th></th>
            <th style="text-align:center; vertical-align:center">
                {{$performance->number ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->name ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->responsible_person ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->purpose ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->design_standard ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->ospek ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->obesrvation_file_name ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->obesrvation ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->test_efectivity_file_name ?? ''}}
            </th>
            <th style="text-align:left; vertical-align:center">
                {{$performance->implementation_test_efectivity ?? ''}}
            </th>
        </tr>
        @endforeach

    </table>
</body>

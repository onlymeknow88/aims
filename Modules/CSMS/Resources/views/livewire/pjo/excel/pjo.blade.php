<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PJO</title>

    <style>
        table {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 5px !important;
        }

        th {
            text-align: center !important;
        }

        tr:nth-child(even) {
            background-color: #eee !important;
        }

        tr:nth-child(odd) {
            background-color: #fff !important;
        }

        tr:hover {
            background-color: #ccc !important;
        }

        th {
            background-color: #000 !important;
            color: white !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-justify {
            text-align: justify !important;
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

        .text-lowercase {
            text-transform: lowercase !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .text-capitalize {
            text-transform: capitalize !important;
        }

        .font-weight-bold {
            font-weight: bold !important;
        }

        .font-weight-normal {
            font-weight: normal !important;
        }

        .font-italic {
            font-style: italic !important;
        }

        .font-underline {
            text-decoration: underline !important;
        }

        .font-line-through {
            text-decoration: line-through !important;
        }

        .font-small-caps {
            font-variant: small-caps !important;
        }

        .font-xx-small {
            font-size: 0.5em !important;
        }

        .font-x-small {
            font-size: 0.75em !important;
        }

        .font-small {
            font-size: 0.875em !important;
        }

        .font-medium {
            font-size: 1em !important;
        }

        .font-large {
            font-size: 1.125em !important;
        }

        .font-x-large {
            font-size: 1.25em !important;
        }

        .font-xx-large {
            font-size: 1.5em !important;
        }

        .font-xxx-large {
            font-size: 2em !important;
        }

        .font-xxxx-large {
            font-size: 3em !important;
        }

        .font-xxxxx-large {
            font-size: 4em !important;
        }

        .font-xxxxxx-large {
            font-size: 5em !important;
        }
    </style>
</head>

<body>


    <table>
        <thead>
            <tr>
                <th width="30px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    No.
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Perusahaan
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Kriteria
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    CCOW
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Pengajuan
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Nomor PJO
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Nama
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Tanggal Lahir
                </th>
                <th width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    No. Telepon
                </th>
                <th width="160px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Email
                </th>
                <th width="150px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $p)
                <tr>
                    <td style="vertical-align: middle; text-align: center;">{{ $loop->iteration }}.</td>
                    <td style="vertical-align: middle;">{{ $p['company'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['criteria'] }}</td>
                    <td style="vertical-align: middle;">{{ $p['ccow'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['submission'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['number'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['name'] }}</td>
                    <td style="vertical-align: middle;">{{ $p['date_of_birth'] }}</td>
                    <td style="vertical-align: middle;">{{ $p['phone'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['email'] ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p['status'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10"> {{ __('Data is empty') }}.... </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>

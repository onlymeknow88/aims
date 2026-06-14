<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

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
                <th rowspan="2" width="30px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">No.
                </th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Nomor Peraturan</th>
                <th rowspan="2" width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Judul Peraturan</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Jenis Peraturan</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Otoritas Instansi</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Status</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Document Type</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Kepatuhan</th>
                <th rowspan="2" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Total Extraksi</th>
                <th colspan="4" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Compliance Status</th>
                <th colspan="5" width="200px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Compliance Level</th>
            </tr>
            <tr>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Complied
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Not Comply</th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    Not Applicable</th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    In Review
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    N
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    IA
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    IIA
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    IIIA
                </th>
                <th width="130px"
                    style="font-weight: bold; vertical-align: middle; text-align: center; background-color: #b9f6ca">
                    IIIB
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $p)
                <tr>
                    <td style="vertical-align: middle; text-align: center;">{{ $loop->iteration }}.</td>
                    <td style="vertical-align: middle;">{{ $p->number ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->title ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->ruleType->name ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->agencyAuthority->name ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->status ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->document_type ?? '-' }}</td>
                    <td style="vertical-align: middle;">
                        @foreach ($p->obediences as $obedience)
                            - {{$obedience->company->company_name ?? '~'}} <br/>
                        @endforeach
                    </td>
                    <td style="vertical-align: middle;">{{ $p->extractionTotal ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->compliedExtractionTotal ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->notComplyExtractionTotal ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->notApplicableExtractionTotal ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->inProgressExtractionTotal ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->getComplianceLevelTotal('N') ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->getComplianceLevelTotal('IA') ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->getComplianceLevelTotal('IIA') ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->getComplianceLevelTotal('IIIA') ?? '-' }}</td>
                    <td style="vertical-align: middle;">{{ $p->getComplianceLevelTotal('IIIB') ?? '-' }}</td>
                    <td style="vertical-align: middle;"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="11"> {{ __('Data is empty') }}.... </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>

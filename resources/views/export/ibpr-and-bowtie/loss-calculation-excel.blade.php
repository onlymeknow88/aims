<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>KALKULASI KERUGIAN</title>
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
            <th colspan="5" style="font-size: 18px; vertical-align:center; text-align: center;">
                Kalkulasi Kerugian Keuangan
            </th>
        </tr>

        <tr>
            <th></th>
        </tr>

        <tr>
            <th></th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
               
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Rate
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                14.000
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                No
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Item
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Detail
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Jumlah (IDR)
            </th>
            <th style="background-color: #00ce3e; color: #fff; text-align:center; vertical-align:center">
                Jumlah (USD)
            </th>
        </tr>

        @foreach($loss_calculations as $key => $loss_calculation)
        @php $total_amount = 0; @endphp
            @foreach($loss_calculation->details as $i => $detail)
            <tr>
                <th></th>
                <th style="text-align:center; vertical-align:top; border: 1px solid #000;">
                    @if($i == 0)
                        {{$key+1 ?? ''}}
                    @endif
                </th>
                <th style="text-align:left; vertical-align:top; border: 1px solid #000;">
                    @if($i == 0)
                        {{$loss_calculation->event->name ?? ''}}
                    @endif
                </th>
                <th style="text-align:right; vertical-align:center; border: 1px solid #000;">
                    {{$detail->name ?? ''}}
                </th>
                <th style="text-align:right; vertical-align:center; border: 1px solid #000;">
                    @php $total_amount = $total_amount + $detail->amount; @endphp
                    {{  "Rp " . number_format($detail->amount, 0, ',', '.') ?? '' }}
                </th>
                <th style="text-align:right; vertical-align:center; border: 1px solid #000;">
                    {{  "$ " . number_format($detail->amount / 14000, 2) ?? ''}}
                </th>
            </tr>
            @endforeach
        <tr>
            <th></th>
            <th style="text-align:center; vertical-align:top; border: 1px solid #000;">
            </th>
            <th style="text-align:left; vertical-align:top; border: 1px solid #000;">
            </th>
            <th style="text-align:left; vertical-align:center; border: 1px solid #000;">
                <b>Total</b>
            </th>
            <th style="text-align:right; vertical-align:center; border: 1px solid #000;">
                <b>{{  "Rp " . number_format($total_amount, 0, ',', '.')}}</b>
            </th>
            <th style="text-align:right; vertical-align:center; border: 1px solid #000;">
                <b>{{  "$ " . number_format($total_amount / 14000, 2)}}</b>
            </th>
        </tr>
        @endforeach
    </table>
</body>

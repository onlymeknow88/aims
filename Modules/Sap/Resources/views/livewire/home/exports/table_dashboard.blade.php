<html xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'
    xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>

<head>
    <meta http-equiv=Content-Type content='text/html; charset=windows-1252'>
    <meta name=ProgId content=Excel.Sheet>
    <meta name=Generator content='Microsoft Excel 15'>
</head>

<body>

    @foreach ($data_all as $data)
        @php
            $data = $data['data'];
            $yearly = $data['yearly'];
            
            $monthly = $data['monthly'];
        @endphp

        <table cellspacing='0' border='0'>
            <colgroup width='294'></colgroup>
            <colgroup span='18' width='42'></colgroup>
            <colgroup width='65'></colgroup>
            <colgroup width='32'></colgroup>
            <colgroup width='65'></colgroup>

            <tr height=15 style='height:14.4pt'>
                <td colspan=22 height='23' align='left' valign=middle><b>
                        <font color='#000000'>{{ $data['name'] }}</font>
                    </b></td>
            </tr>

            <tr height=15 style='height:14.4pt'>
                <td colspan=22 height='23' align='left' valign=middle><b>
                        <font color='#000000'>PENCAPAIAN BARU/REVIEW {{ $data['year_now'] }}</font>
                    </b></td>
            </tr>
            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='100px' align='center' valign=bottom bgcolor='#DDDDDD'>
                    <font color='#000000'><br></font>
                </td>
                @foreach ($yearly as $index => $list)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='50px' align='center' valign=bottom bgcolor='#DDDDDD'>
                        <font color='#000000'>{{ $index }}</font>
                    </td>
                @endforeach
            </tr>

            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='100px' align='left' valign=bottom>
                    <font color='#000000'>Target Dept</font>
                </td>
                @foreach ($yearly as $index => $list)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                        <font color='#000000'>{{ $list['target_dept'] }}</font>
                    </td>
                @endforeach
            </tr>

            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='100px' align='left' valign=bottom>
                    <font color='#000000'>Actual Dept</font>
                </td>
                @foreach ($yearly as $index => $list)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                        <font color='#000000'>{{ $list['actual_dept'] }}</font>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='100px' align='left' valign=bottom>
                    <font color='#000000'>(%)Dept</font>
                </td>
                @foreach ($yearly as $index => $list)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                        <font color='#000000'>{{ $list['target_dept'] != 0 && $list['actual_dept'] != 0 ? 100 : null }}%
                        </font>
                    </td>
                @endforeach
            </tr>
            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='100px' align='left' valign=bottom>
                    <font color='#000000'>Deficiency</font>
                </td>
                @foreach ($yearly as $index => $list)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                        <font color='#000000'>{{ $list['deficiency'] }}</font>
                    </td>
                @endforeach
            </tr>
        </table>

        {{-- SPACE --}}
        <table>
            @for ($i = 0; $i < 12; $i++)
                <tr height=15 style='height:14.4pt'>
                    <td> </td>
                </tr>
            @endfor
        </table>
        {{-- ENDSPACE --}}


        @foreach ($monthly as $month)
            <table cellspacing='0' border='0'>
                <colgroup width='294'></colgroup>
                <colgroup span='18' width='42'></colgroup>
                <colgroup width='65'></colgroup>
                <colgroup width='32'></colgroup>
                <colgroup width='65'></colgroup>
                <tr height=15 style='height:14.4pt'>
                    <td colspan=22 height='23' align='left' valign=middle><b>
                            <font color='#000000'>PENCAPAIAN BARU/REVIEW {{ $month['month'] }}
                                {{ $data['year_now'] }}</font>
                        </b></td>
                </tr>
                <tr height=15 style='height:14.4pt'>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='100px' align='center' valign=bottom bgcolor='#DDDDDD'>
                        <font color='#000000'><br></font>
                    </td>
                    @foreach ($month['data'] as $index => $list)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            width='50px' align='center' valign=bottom bgcolor='#DDDDDD'>
                            <font color='#000000'>{{ $index }}</font>
                        </td>
                    @endforeach
                </tr>

                <tr height=15 style='height:14.4pt'>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='100px' align='left' valign=bottom>
                        <font color='#000000'>Target Dept</font>
                    </td>
                    @foreach ($month['data'] as $index => $list)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                            <font color='#000000'>{{ $list['target_dept'] }}</font>
                        </td>
                    @endforeach
                </tr>

                <tr>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='100px' align='left' valign=bottom>
                        <font color='#000000'>Actual Dept</font>
                    </td>
                    @foreach ($month['data'] as $index => $list)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                            <font color='#000000'>{{ $list['actual_dept'] }}</font>
                        </td>
                    @endforeach
                </tr>
                <tr height=15 style='height:14.4pt'>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='100px' align='left' valign=bottom>
                        <font color='#000000'>(%)Dept</font>
                    </td>
                    @foreach ($month['data'] as $index => $list)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                            <font color='#000000'>
                                {{ $list['target_dept'] != 0 && $list['actual_dept'] != 0 ? 100 : null }}%
                            </font>
                        </td>
                    @endforeach
                </tr>
                <tr height=15 style='height:14.4pt'>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        width='100px' align='left' valign=bottom>
                        <font color='#000000'>Deficiency</font>
                    </td>
                    @foreach ($month['data'] as $index => $list)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            width='50px' align='right' valign=bottom sdval='0' sdnum='14345;'>
                            <font color='#000000'>{{ $list['deficiency'] }}</font>
                        </td>
                    @endforeach
                </tr>
            </table>


            {{-- SPACE --}}
            <table>
                @for ($i = 0; $i < 11; $i++)
                    <tr height=15 style='height:14.4pt'>
                        <td> </td>
                    </tr>
                @endfor
            </table>
            {{-- ENDSPACE --}}
        @endforeach
    @endforeach


</body>

</html>

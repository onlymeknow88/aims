<html xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'
    xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns='http://www.w3.org/TR/REC-html40'>

<head>
    <meta http-equiv=Content-Type content='text/html; charset=windows-1252'>
    <meta name=ProgId content=Excel.Sheet>
    <meta name=Generator content='Microsoft Excel 15'>
</head>

<body>

    <table cellspacing='0' border='0'>
        <colgroup width='32'></colgroup>
        <colgroup width='163'></colgroup>
        <colgroup width='239'></colgroup>
        <colgroup width='75'></colgroup>
        <colgroup width='54'></colgroup>
        <colgroup width='196'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='54'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='75'></colgroup>
        <colgroup width='42'></colgroup>
        <tr height=15 style='height:14.4pt'>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                colspan=7 width="30px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'><br></font>
            </td>
            @foreach ($months as $list)
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    colspan=3 width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'>{{ strtoupper($list['month_name']) }}</font>
                </td>
            @endforeach
        </tr>
        <tr height=15 style='height:14.4pt'>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>No</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>ID</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="200px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>Nama Karyawan</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>Posisi Target SAP</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>Dept</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>Company</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                <font color='#000000'>Grade</font>
            </td>
            @foreach ($months as $list)
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'>TARGET</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'>ACTUAL</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width="100px" align='center' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'>ACH</font>
                </td>
            @endforeach
        </tr>

        @foreach ($employee['data'] as $index => $list)
            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    height='0' align='center' valign=middle sdval='1' sdnum='14345;'>
                    <font color='#000000'>{{ ++$index }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['jde'] }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['name'] }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['position'] }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['dept'] }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['company_name'] }}</font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle>
                    <font color='#000000'>{{ $list['grade'] }}</font>
                </td>

                @if (isset($list['months']))
                    @foreach ($list['months'] as $i => $row)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            align='right' valign=middle>
                            <font color='#000000'> {{ $row['target'] }}</font>
                        </td>
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            align='right' valign=middle>
                            <font color='#000000'>{{ $row['actual'] }}</font>
                        </td>
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            align='right' valign=middle>
                            <font color='#000000'>{{ $row['ach'] }}</font>
                        </td>
                    @endforeach
                @endif
            </tr>
        @endforeach
    </table>
    <!-- ************************************************************************** -->
</body>

</html>

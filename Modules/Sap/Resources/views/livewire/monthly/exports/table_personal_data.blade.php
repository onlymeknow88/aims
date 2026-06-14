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
        <colgroup width='75'></colgroup>
        <colgroup width='239'></colgroup>
        <colgroup width='75'></colgroup>
        <colgroup width='54'></colgroup>
        <colgroup width='196'></colgroup>
        <colgroup width='86'></colgroup>
        <colgroup width='98'></colgroup>
        <colgroup span='2' width='65'></colgroup>
        <colgroup width='42'></colgroup>
        <colgroup span='2' width='54'></colgroup>
        <colgroup width='75'></colgroup>
        <colgroup width='108'></colgroup>
        <colgroup width='86'></colgroup>
        <colgroup span='2' width='98'></colgroup>

        <tr height=15 style='height:14.4pt'>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='20pt' align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>No</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt' align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>ID</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt'align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>Nama Karyawan</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt'align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>Posisi Target SAP</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt'align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>Company</font>
            </td>
            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt'align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>Dept</font>
            </td>

            <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                width='100pt'align='center' valign=middle bgcolor='#DDDDDD'>
                <font color='#000000'>Grade</font>
            </td>
            @foreach ($months as $month)
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    width='50pt' align='center' valign=middle bgcolor='#DDDDDD'>
                    <font color='#000000'>{{ ucfirst($month['month_name']) }}</font>
                </td>
            @endforeach
        </tr>
        @foreach ($data as $i => $list)
            <tr height=15 style='height:14.4pt'>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    align='left' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'><br></font>
                </td>
                <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                    colspan=6 align='left' valign=middle bgcolor='#EEEEEE'>
                    <font color='#000000'>{{ $list['name'] }}</font>
                </td>
                @foreach ($months as $month)
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                         align='left' valign=middle bgcolor='#EEEEEE'>
                    </td>
                @endforeach
            </tr>
            @foreach ($list['employee_list'] as $index => $row)
                <tr height=15 style='height:14.4pt'>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='center' valign=middle sdval='1' sdnum='14345;'>
                        <font color='#000000'>{{ ++$index }}</font>
                    </td>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ $row['id_number'] }}</font>
                    </td>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ $row['name'] }}</font>
                    </td>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ $row['position'] }}</font>
                    </td>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ $row['company_name'] }}</font>
                    </td>
                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ $row['code'] }}</font>
                    </td>

                    <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                        align='left' valign=middle>
                        <font color='#000000'>{{ isset($row['grade']) ? $row['grade'] : null }}</font>
                    </td>
                    @foreach ($months as $month)
                        <td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000'
                            align='right' valign=middle sdval='20' sdnum='14345;'>
                            <font color='#000000'> {{ $row[$month['month_name']] }}</font>
                        </td>
                    @endforeach

                </tr>
            @endforeach
        @endforeach
    </table>
    <!-- ************************************************************************** -->
</body>

</html>

<div style="font-family: Arial, sans-serif; color: #333; margin: 20px;">
    <p style="font-weight: bold; font-size: 16px; text-align: center;">FORMULIR REKAPITULASI KETIDAKSESUAIAN</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 16px;">
        <tr>
            <td style="padding: 10px; width:40%">Nama Perusahaan</td>
            <td style="padding: 10px; width:5%">:</td>
            <td style="padding: 10px; width:45%">{{$audit->company->company_name}}</td>
        </tr>
        <tr>
            <td style="padding: 10px; width:40%">Tanggal Audit</td>
            <td style="padding: 10px; width:5%">:</td>
            <td style="padding: 10px; width:45%">{{date('d-m-Y',strtotime($audit->start_at))}}</td>
        </tr>
    </table>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black; font-size: 16px;">
        <tr style="font-weight: bold">
            <td style="padding: 10px; width: 5%; vertical-align: middle; text-align: center;">No</td>
            <td style="padding: 10px; width: 20%; vertical-align: middle; text-align: center;">Nomor Ketidaksesuaian</td>
            <td style="padding: 10px; width: 35%; vertical-align: middle; text-align: center;">Deskripsi Ketidaksesuaian</td>
            @if($category == 'smkp')
                <td style="padding: 10px; width: 15%; vertical-align: middle; text-align: center;">Kategori</td>
            @endif
            <td style="padding: 10px; width: 25%; vertical-align: middle; text-align: center;">Batas Waktu Perbaikan</td>
        </tr>

        @forelse($non_confirmances as $non_confirmance)
        <tr>
            <td style="padding: 10px; width: 5%; text-align: center;">{{ ++$startNumber }}</td>
            <td style="padding: 10px; width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{$non_confirmance->non_confirmance_number}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="padding: 10px; width: 35%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">@php echo str_ireplace(['<br>','<o:p></o:p>','&amp;'],['<br />','','dan'], $non_confirmance->problem_description) @endphp</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            @if($category == 'smkp')
                <td style="padding: 10px; width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{strip_tags($non_confirmance->category)}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            @endif
            <td style="padding: 10px; width: 25%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{date('d-m-Y',strtotime($non_confirmance->due_date))}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach
    </table>

    <table style="width: 100%; margin: 20px auto; margin-top: 50px; border-collapse: collapse; border: 1px solid black; font-size: 16px;">
        <tr>
            <td style="padding: 10px; width: 15%; text-align: center;">Nama Auditor</td>
            <td style="padding: 10px; width: 20%; text-align: center;">{{$audit->auditors[0]->name ?? '-'}}</td>
            <td style="padding: 10px; width: 15%; text-align: center;">Tanda Tangan</td>
            <td style="padding: 10px; width: 15%; text-align: center;"></td>
            <td style="padding: 10px; width: 15%; text-align: center;">Tanggal</td>
            <td style="padding: 10px; width: 20%; text-align: center;">{{date('d-m-Y')}}</td>
        </tr>
    </table>
</div>
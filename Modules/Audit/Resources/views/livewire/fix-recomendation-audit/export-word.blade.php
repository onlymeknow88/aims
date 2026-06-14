<div style="font-family: Arial, sans-serif; color: #333; margin: 20px;">
    <p style="font-weight: bold; font-size: 16px; text-align: center">FORMULIR REKOMENDASI DAN PELUANG UNTUK PERBAIKAN PENERAPAN {{strtoupper($audit_category)}}</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 16px;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width:40%">Nama Perusahaan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:5%">:</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:45%">{{$audit->company->company_name}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width:40%">Tanggal Audit</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:5%">:</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:45%">{{date('d-m-Y',strtotime($audit->start_at))}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width:40%; font-weight: bold;">Uraian Rekomendasi dan Peluang untuk Perbaikan</td>
        </tr>
    </table>

    @foreach($confirmances as $confirmance)
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black; font-size: 16px;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">Elemen</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">{{$confirmance->audit_sub_criteria->criteria->title}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">Sub Elemen</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">@if($confirmance->audit_sub_criteria->parent)@if($confirmance->audit_sub_criteria->parent->parent)@if($confirmance->audit_sub_criteria->parent->parent->parent){{$confirmance->audit_sub_criteria->parent->parent->parent->title}}<br />@endif{{$confirmance->audit_sub_criteria->parent->parent->title}}<br />@endif{{$confirmance->audit_sub_criteria->parent->title}}<br />@endif{{$confirmance->audit_sub_criteria->title}}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">Rekomendasi dan Peluang untuk Perbaikan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; text-align: justify;">@php echo str_ireplace(['<br>','<o:p></o:p>'],['<br />',''],$confirmance->fix_recommendation) @endphp
            </td>
        </tr>
    </table>
    @endforeach

    <table style="width: 100%; margin: 20px auto; margin-top: 50px; border-collapse: collapse; border: 1px solid black; font-size: 16px;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Nama Auditor</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%;"> {{$audit->auditors[0]->name ?? '-'}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Tanda Tangan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;"></td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Tanggal</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%;">{{date('d-m-Y')}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Nama Auditi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%;"></td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Tanda Tangan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;"></td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">Tanggal</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%;">{{date('d-m-Y')}}</td>
        </tr>
    </table>
</div>
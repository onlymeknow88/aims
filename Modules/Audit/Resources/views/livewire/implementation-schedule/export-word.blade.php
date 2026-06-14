<div style="font-family: Arial, sans-serif; color: #333; margin: 20px;">
    <p style="font-weight: bold; font-size: 15px; text-align: center">SUSUNAN KEGIATAN PELAKSANAAN AUDIT {{$audit_category}}</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 15px;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width:40%">Nama Perusahaan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:5%">:</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:45%">{{$audit->company->company_name}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width:40%">Tanggal Audit</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:5%">:</td>
            <td style="border: 1px solid #ddd; padding: 10px; width:45%">{{date('d F Y',strtotime($audit->start_at))}} - {{date('d F Y',strtotime($audit->end_at))}}</td>
        </tr>
    </table>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr style="font-weight: bold">
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; vertical-align: middle;">#</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%; vertical-align: middle;">Waktu</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 65%; vertical-align: middle;">Fungsi / Area / Departemen / Kegiatan yang akan diaudit (termasuk persyaratan terkait)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 15%; vertical-align: middle;">Auditor</td>
        </tr>

        @foreach($implementationActivity->details as $activity)
            <tr style="font-weight: bold">
                <td style="border: 1px solid #ddd; padding: 10px; width: 100%;" colspan="4">Hari ke {{$loop->index+1}} ({{$activity->date->translatedFormat('d F Y')}})</td>
            </tr>
            @forelse($activity->schedules as $schedule)
                <tr style="font-weight: bold">
                    <td style="border: 1px solid #ddd; padding: 10px; width: 5%;">{{$loop->index + 1}}</td>
                    <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">{{Carbon\Carbon::parse($schedule->start_time)->format('H:i')." - ".Carbon\Carbon::parse($schedule->end_time)->format('H:i')}}
                    </td>

                    @if($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::FREE_TEXT)
                        <td style="border: 1px solid #ddd; padding: 10px; width: 65%;">@php echo $schedule->description @endphp</td>
                        <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">{{$schedule->auditors->implode('name',',')}}</td>
                    @elseif($schedule->schedule_activity_type ==\Modules\Audit\Enums\ScheduleActivityType::OPENING || $schedule->schedule_activity_type ==\Modules\Audit\Enums\ScheduleActivityType::CLOSING)
                        <td style="border: 1px solid #ddd; padding: 10px; width: 65%;"><p class="mb-0">{{$schedule->title}}</p>@php echo $schedule->location @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">@php echo $schedule->auditor @endphp</td>
                    @elseif($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ISOMA)
                        <td style="border: 1px solid #ddd; padding: 10px; width: 65%;">{{$schedule->title}}</td>
                        <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">{{$schedule->auditor}}</td>
                    @elseif($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ACTIVITY)
                        <td style="border: 1px solid #ddd; padding: 10px; width: 65%;">
<p>Lokasi : {{$schedule->location}}</p><p>Metode : {{$schedule->method}}</p><p>Auditee : {{$schedule->auditee??"-"}}</p><ul>@foreach($schedule->sub_criteria as $criteria)<li>{{$criteria->title}}</li>@endforeach</ul>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 10px; width: 15%;">{{$schedule->auditors->implode('name',',')}}</td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </table>
</div>
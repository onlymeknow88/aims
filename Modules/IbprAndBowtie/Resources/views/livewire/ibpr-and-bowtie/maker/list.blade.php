@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        .wrapping_table {
            overflow-x: scroll;

        }
        .form_table {
            overflow-x: scroll;
        }
        .form_table th,
        .form_table td {
            min-width: 150px;
            white-space: unset;
            vertical-align: middle;
            text-align: center;
            padding: unset;
            position: unset;
            font-size: 11px;
            border-color: black;
        }
        .form_table td.title a {
            white-space: unset;
            max-width: unset;
            display: unset;
            align-items: unset;
        }
        .form_table td a:hover {
            font-weight: unset;
        }
        .form_table td.td-check {
            width: unset;
        }
        .form_table tr {
            border-left: unset;
            border-color: black;
        }
        .form_table tbody tr:hover {
            border-left-color:unset;
            background-color: unset;
            cursor: unset;
        }
        .form_table tbody tr td .icon-checked {
            display: unset;
            align-items: unset;
            width: unset;
            height: unset;
            background-position: unset;
            background-size: unset;
        }
        .form_table tbody tr:hover td .icon-checked{
            background-image: unset;
        }
        .form_table tbody tr td .icon-checked.selected {
            background-image: unset;
        }
        .table-wrapper {
            width: 100%;
            position: relative;
            overflow: auto;
        }
    </style>
@endpush

<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="/ibpr-and-bowtie/ibpr/active/detail/{{$field_id}}" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div><!-- /.left-header -->
    </div>

<div class="table-responsive">
    <table style="margin-right: 5px" class="form_table table table-bordered">
        <tr>
            <td colspan="3">Kegiatan</td>
            <td rowspan="3" style="min-width: 50px!important;">No.</td>
            <td rowspan="3">Bahaya Keselamatan Pertambangan</td>
            <td rowspan="3">Risiko Kejadian</td>
            <td rowspan="3">Peluang Keselamatan Pertambangan</td>
            <td rowspan="3">Peraturan Perundang-undangan yang relevan</td>
            <td colspan="9">Penilaian Risiko Awal</td>
            <td colspan="2">Pengendalian yang sudah ada saat ini</td>
            <td colspan="7">Penilaian Risiko Sisa</td>
            <td></td>
        </tr>
        <tr>
            <td rowspan="2">Aktifitas/Proses</td>
            <td rowspan="2">Sub-Aktifitas / Sub-proses</td>
            <td rowspan="2">Kondisi (Rutin/tidak rutin)</td>
            <td colspan="5">Konsekuensi Maksimal</td>
            <td style="min-width: 20px!important; background-color: yellow; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">FREKUENSI</td>
            <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2"></td>
            <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Tingkat Risiko</td>
            <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Risiko Utama?</td>
            <td rowspan="2">Model Tindakan kendali saat ini/ yang sudah ada</td>
            <td rowspan="2">Kendali Efektif? (Y / T)</td>
            <td colspan="5">Konsekuensi</td>
            <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Frekuensi</td>
            <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Tingkat Risiko</td>
            <td rowspan="2">Tindakan Pengendalian Risiko lanjutan (jika ada)</td>
        </tr>
        <tr>
            <td style="min-width: 20px!important; background-color: yellow;">K3</td>
            <td style="min-width: 20px!important; background-color: yellow;">LH</td>
            <td style="min-width: 20px!important; background-color: yellow;">KP</td>
            <td style="min-width: 20px!important; background-color: yellow;">KSL</td>
            <td style="min-width: 20px!important; background-color: yellow;">KK</td>
            <td style="min-width: 20px!important;">K3</td>
            <td style="min-width: 20px!important;">LH</td>
            <td style="min-width: 20px!important;">KP</td>
            <td style="min-width: 20px!important;">KSL</td>
            <td style="min-width: 20px!important;">KK</td>
        </tr>
        <tr>
            @for($i = 1; $i <= 31; $i++)
                @if($i !== 5 && $i !== 8 && $i !== 21 && $i !== 29)
                    <td style="min-width: 20px!important;">{{ $i }}</td>
                @endif
            @endfor
        </tr>
        @foreach($forms as $index => $form)
            <tr>
                <td><p class="text-xs">{{$form->activity}}</p></td>
                <td><p class="text-xs">{{$form->sub_activity}}</p></td>
                <td><p class="text-xs">{{$form->kondition}}</p></td>
                <td style="min-width: 20px!important;"></td>
                <td><p class="text-xs">{{$form->safety}}</p></td>
                <td><p class="text-xs">{{$form->incident_risk}}</p></td>
                <td><p class="text-xs">{{$form->safety_opportunity}}</p></td>
                <td><p class="text-xs">{{$form->relevant_legislation}}</p></td>

                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_consequence_k3}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_consequence_lh}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_consequence_kp}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_consequence_ksl}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_consequence_kk}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_frequence}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs"></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_level_of_risk}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->preliminary_main_risk}}</p></td>

                <td><p class="text-xs">{{$form->modal_of_current}}</p></td>
                <td><p class="text-xs">{{$form->effective_control}}</p></td>

                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_consequence_k3}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_consequence_lh}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_consequence_kp}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_consequence_ksl}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_consequence_kk}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_frequence}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->residual_level_of_risk}}</p></td>
                <td style="min-width: 20px!important;"><p class="text-xs">{{$form->follow_risk}}</p></td>
            </tr>
        @endforeach
    </table>
</div>

</div>
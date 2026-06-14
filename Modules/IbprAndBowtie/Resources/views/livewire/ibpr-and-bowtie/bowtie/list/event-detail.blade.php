@push('styles')
    <style type="text/css">
        
    </style>
@endpush
<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="#" onclick="history.back();"
            class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span> Detail</span>
        </a>
    </div>

    

    <div class="detail-maker-content">

        <div class="section-content py-3 px-5 d-flex flex-column gap-3">

            <div class="container overflow-auto">

                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="info-item p-3 border-bottom border-1">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">PERUSAHAAN</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">
                                                @if($event->bowtie->iup == 'INTERNAL')
                                                    {{$event->bowtie->ccow->company_name ?? ''}}
                                                @elseif($event->bowtie->iup == 'CONTRACTOR')
                                                    {{$event->bowtie->contractor->company_name ?? ''}}
                                                @else
                                                    {{$event->bowtie->sub_contractor->company_name ?? ''}}
                                                @endif
                                            </span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->

                                <div class="info-item p-3 border-bottom border-1">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">PENANGGUNG JAWAB RISIKO</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">{{$event->bowtie->pja->name ?? ''}}</span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->

                                <div class="info-item p-3 border-bottom border-1">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">PENANGGUNG JAWAB PENGENDALIAN KRITIS</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">@foreach($event->bowtie->teams as $key => $team) {{$team->user_name ?? ''}}, @endforeach</span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->

                                <div class="info-item p-3">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">JUDUL RISIKO</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">{{$event->bowtie->risk_title ?? ''}}</span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->
                            </div>
                        </div>
                    </div><!-- /.col-sm-12 -->
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header" style="background-color:#198754; color: white; text-align: center;">
                                <h5>Penjelasan Pengendalian Risiko</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">@php echo str_ireplace([';'],['<br />'], $event->description) @endphp</p>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="title-form text-center p-3">
                                <h6>KERUGIAN MAKSIMAL SEMUA KENDALI TIDAK EFEKTIF</h6>
                            </div>
                            <table class="table table-bordered align-items-center table-sm">

                                <thead class="thead-light">
                                <tr style="border-left:1px solid #dddddd;">
                                    <th style="width:5%;vertical-align:middle" class="text-white bg-success">
                                        TIPE DAMPAK
                                    </th>
                                    <th class="text-center text-white bg-success" style="vertical-align:middle">
                                        KEPARAHAN
                                    </th>
                                    <th class="text-center text-white bg-success" style="vertical-align:middle">
                                        KERUGIAN MAKSIMAL
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    <tr>
                                        <th class="text-center">
                                            K3
                                        </th>
                                        <td class="text-center">
                                            {{$event->k3_severity}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->ksl_max_loss}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            LH
                                        </th>
                                        <td class="text-center">
                                            {{$event->lh_severity}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->lh_max_loss}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            KSL
                                        </th>
                                        <td class="text-center">
                                            {{$event->ksl_severity}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->ksl_max_loss}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            KP
                                        </th>
                                        <td class="text-center">
                                            {{$event->kp_severity}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->kp_max_loss}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">
                                            KK
                                        </th>
                                        <td class="text-center">
                                            {{$event->kk_severity}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->kk_max_loss}}
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="card mt-3"> 
                            <div class="title-form text-center p-3">
                                <h6>TINGKAT RISIKO SISA SETELAH PENGENDALIAN</h6>
                            </div>
                            <table class="table table-bordered align-items-center table-sm">

                                <thead class="thead-light">
                                <tr style="border-left:1px solid #dddddd;">
                                    <th style="width:5%;vertical-align:middle" class="text-white bg-success">
                                        TINGKAT RISIKO SISA (TRR)
                                    </th>
                                    <th class="text-center text-white bg-success" style="vertical-align:middle">
                                        FAKTOR
                                    </th>
                                    <th class="text-center text-white bg-success" style="vertical-align:middle">
                                        PENJELASAN
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    <tr>
                                        <th class="text-center">
                                            Keparahan (K)
                                        </th>
                                        <td class="text-center">
                                            {{$event->severity_factor}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->severity_explain}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-center">
                                            Kemungkinan (P)
                                        </th>
                                        <td class="text-center">
                                            {{$event->likelihood_factor}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->likelihood_explain}}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="text-center">
                                            TRR
                                        </th>
                                        <td class="text-center">
                                            {{$event->trr_factor}}
                                        </td>
                                        <td class="text-center">
                                            {{$event->trr_explanation}}
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                    
                        </div>
                    </div><!-- /.col-sm-12 -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="info-item p-3 border-bottom border-1">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">NOMOR ID BOWTIE</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">{{$event->bowtie->document_no ?? ''}}</span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->

                                <div class="info-item p-3">

                                    <div class="created d-flex flex-column gap-2">

                                        <h6 class="fw-normal">TANGGAL</h6>

                                        <div class="item-content d-flex gap-1 align-items-center">
                                            <span class="fw-normal">{{ Carbon\Carbon::parse($event->bowtie->request_date)->format('F d, Y') ?? ''}}</span>
                                        </div>

                                    </div><!-- /.author -->

                                </div><!-- /.info-items -->
                            </div>
                        </div>
                    </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
            </div>

            <div class="container overflow-auto">

                <div class="row">
                    <div class="col-6">
                        
                    </div><!-- /.col-sm-12 -->

                    <div class="col-6"></div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
            </div>

            <div class="container overflow-auto">

                <div class="row">
                    <div class="col-6">
                        <table class="table table-bordered align-items-center table-sm">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th colspan="2" style="vertical-align:middle" class="text-white bg-success">
                                    PENYEBAB
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($event->reasons as $key => $reason)
                                <tr>
                                    <th class="text-center" style="white-space: normal">
                                        {{$key+1}}
                                    </th>
                                    <th style="white-space: normal">
                                        {{$reason->name ?? ''}}
                                    </th>
                                </tr>
                            @endforeach

                            @if($event->reasons->count() == 0)
                                <tr>
                                    <th colspan="2" style="white-space: normal">
                                        Tidak ada data
                                    </th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->

                    <div class="col-6">
                        <table class="table table-bordered align-items-center table-sm">

                            <thead class="thead-light">
                                <tr style="border-left:1px solid #dddddd;">
                                    <th style="vertical-align:middle" class="text-white bg-success">
                                        TIPE DAMPAK
                                    </th>
                                    <th style="vertical-align:middle" class="text-white bg-success">
                                        PENJELASAN
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <tr>
                                    <th style="width:10px">
                                        1. Keselamatan dan Kesehatan Kerja (K3)
                                    </th>
                                    <td style="white-space: normal">
                                        {{$event->impact_k3 ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:10px">
                                        2. Lingkungan Hidup (LH)
                                    </th>
                                    <td style="white-space: normal">
                                        {{$event->impact_lh ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:10px">
                                        3. Komunitas Sosial Lokal (KSL)
                                    </th>
                                    <td style="white-space: normal">
                                        {{$event->impact_ksl ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:10px">
                                        4. Kepatuhan terhadap Peraturan (KP)
                                    </th>
                                    <td style="white-space: normal">
                                        {{$event->impact_kp ?? ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:10px">
                                        5. Kerugian Keuangan (KK)
                                    </th>
                                    <td style="white-space: normal">
                                        {{$event->impact_kk ?? ''}}
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
            </div>

            <div class="container overflow-auto">

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered align-items-center table-sm" width="100%">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th style="width:10px;vertical-align:middle" class="text-white bg-success">
                                    NO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TINDAKAN KENDALI PENCEGAHAN SAAT INI
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    KAITAN DENGAN PENYEBAB
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    KENDALI KRITIKAL
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    PENANGGUNG JAWAB KENDALI
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($event->cmf as $key => $data)
                                <tr>
                                    <td class="text-center" style="width:10px">
                                        {{$key+1}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->control_measures ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->associated_with_cause ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->critical_control ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->person_in_control ?? ''}}
                                    </td>
                                </tr>
                            @endforeach

                            @if($event->cmf->count() == 0)
                                <tr>
                                    <th colspan="5" class="text-center" style="width:10px">
                                        Tidak ada data
                                    </th>
                                </tr>
                            @endif
                                
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->
                </div>
            </div>

            <div class="container overflow-auto">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered align-items-center table-sm" width="100%">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th style="width:10px;vertical-align:middle" class="text-white bg-success">
                                    NO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TUGAS PERBAIKAN
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TANGGAL TEMPO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    PENANGGUNG JAWAB
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TANGGAL PENYELESAIAN
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($event->cmf_repair as $key => $data)
                                <tr>
                                    <td class="text-center" style="width:10px">
                                        {{$key+1}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->repair_task ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->due_date ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->person_responsible ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->completion_date ?? ''}}
                                    </td>
                                </tr>
                            @endforeach

                            @if($event->cmf_repair->count() == 0)
                                <tr>
                                    <th colspan="5" class="text-center" style="width:10px">
                                        Tidak ada data
                                    </th>
                                </tr>
                            @endif
                                
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->

                </div><!-- /.row -->
            </div>

            <div class="container overflow-auto">

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered align-items-center table-sm" width="100%">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th style="width:10px;vertical-align:middle" class="text-white bg-success">
                                    NO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TINDAKAN MITIGASI DAMPAK YANG ADA SAAT INI
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    KAITAN DENGAN DAMPAK
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    MITIGASI KRITIKAL
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    PENNGUNG JAWAB MITIGASI
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($event->imm as $key => $data)
                                <tr>
                                    <td class="text-center">
                                        {{$key+1}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->mitigation_measures ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->mitigation_associated_with_cause ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->mitigation_critical ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->mitigation_person_in_control ?? ''}}
                                    </td>
                                </tr>
                            @endforeach

                            @if($event->imm->count() == 0)
                                <tr>
                                    <th colspan="5" class="text-center" style="width:10px">
                                        Tidak ada data
                                    </th>
                                </tr>
                            @endif
                                
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->
                </div>
            </div>
            <div class="container overflow-auto">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered align-items-center table-sm" width="100%">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th style="width:10px;vertical-align:middle" class="text-white bg-success">
                                    NO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TUGAS PERBAIKAN
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TANGGAL TEMPO
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    PENANGGUNG JAWAB
                                </th>
                                <th style="vertical-align:middle" class="text-white bg-success">
                                    TANGGAL PENYELESAIAN
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($event->imm_repair as $key => $data)
                                <tr>
                                    <td class="text-center">
                                        {{$key+1}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->repair_task ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->due_date ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->person_responsible ?? ''}}
                                    </td>
                                    <td style="white-space: normal">
                                        {{$data->completion_date ?? ''}}
                                    </td>
                                </tr>
                            @endforeach

                            @if($event->imm_repair->count() == 0)
                                <tr>
                                    <th colspan="5" class="text-center" style="width:10px">
                                        Tidak ada data
                                    </th>
                                </tr>
                            @endif
                                
                            </tbody>
                        </table>
                    </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
            </div>

        </div><!-- /.section-content -->
    </div>
</div>

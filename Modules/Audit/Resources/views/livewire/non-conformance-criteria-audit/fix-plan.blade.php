@push('styles')
    <style>
        td.bx-0 {
            border-left: none;
            border-right: none;
        }

        td.bl {
            border-left: 1px solid #ddd;
        }

        td.bb {
            border-bottom: 1px solid #ddd;
        }

    </style>
@endpush
<x-slot name="sidebar">
   @livewire('audit::layouts.sidebar-'.$category,['id'=>$audit->id])
</x-slot>
<div class="inner-content" style="margin-left: 15px;">
   
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Ketidaksesuaian Audit'],
     ]
     ])
    
    <div >
    <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>RENCANA TINDAK LANJUT AUDIT</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Judul
                    </div>
                    <div class="col-8">
                        : {{$audit->title}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Nama Perusahaan
                    </div>
                    <div class="col-8">
                        : {{$audit->company->company_name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Tanggal Audit
                    </div>
                    <div class="col-8">
                        : {{date('d F Y',strtotime($audit->start_at))}} - {{date('d F Y',strtotime($audit->end_at))}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-sm-12" >
                <div class="py-4 d-flex flex-column gap-5">

                    

                    <div class="table-content table-responsive position-relative" >

                        <div class="table-wrapper">

                            <table class="table overflow-auto" id="table-mandays">
                                <thead>
                                <tr>
                                    <th style="width: 2%;" >No</th>
                                    <th style="width: 10%;">Nomor</th>
                                    <th >Deskripsi</th>
                                    <th>Akar Permasalahan</th>
                                    <th>Tindakan Koreksi</th>
                                    <th>Penanggung Jawab</th>
                                    <th style="width: 8%;">Batas Waktu Perbaikan </th>
                                </tr>
                                </thead>
                                <tbody>
                            @forelse($this->non_confirmances as $confirmance)
                                    <tr>
                                        <td style="vertical-align:top">{{++$startNumber}}</td>
                                        <td style="vertical-align:top">{{$confirmance->non_confirmance_number}}</td>
                                        <td style="vertical-align:top">{{strip_tags($confirmance->problem_description)}}</td>
                                        <td style="vertical-align:top">{{strip_tags($confirmance->root_cause_investigation)}}</td>
                                        <td style="vertical-align:top">{{strip_tags($confirmance->fix_action)}}</td>
                                        <td style="vertical-align:top">{{$confirmance->auditee}}</td>
                                        <td style="vertical-align:top">{{date('d-m-Y',strtotime($confirmance->due_date))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.table-wrapper -->
                    </div>
                </div>
            </div><!-- ./col-sm-12 -->
            <div>
                <!-- <a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.fix-plan.export',['id'=>$audit->id])}}" class="btn btn-outline-danger">Ekspor</a> -->
                <a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.fix-plan.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
            </div>
        </div><!-- /.row -->
        
    </div>

</div>
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
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Ketidaksesuaian Audit','url'=>route('audit::'.$category.'.detail.criteria-audit-non-conformance.index',['id'=>$audit->id])],
        ['name'=>$non_conformance->non_confirmance_number]
     ]
     ])
    
    <div class="container">
    <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-4">
                    <h3>FORMULIR KETIDAKSESUAIAN DAN TINDAK LANJUT KETIDAKSESUSIAN AUDIT</h3>
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
                <div class="row">
                    <div class="col-2">
                        Nomor Ketidaksesuaian
                    </div>
                    <div class="col-8">
                        : {{$non_conformance->non_confirmance_number}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-sm-12">
                <div class="content-form d-flex flex-column gap-3">
                    
                    
                    <div class="title-form">
                            <h6>Uraian Ketidaksesuaian Audit</h6>
                        </div><!-- /.title-form -->

                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Uraian Masalah (Problem)</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8"> 
                            {{strip_tags($non_conformance->problem_description)}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Area/Lokasi & Departemen (Location)</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->area_location_department)}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Bukti (Objective Evidence)</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->proof)}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Referensi Elemen/Sub Elemen (reference)</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            @if($non_conformance->audit_sub_criteria->criteria)
                            {{$non_conformance->audit_sub_criteria->criteria->title}}<br>
                            @endif
                            @if($non_conformance->audit_sub_criteria->parent)
                            {{$non_conformance->audit_sub_criteria->parent->title}}<br>
                            @endif
                            
                            {{$non_conformance->audit_sub_criteria->title}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Deskripsi</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->non_confirmance_description)}}
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Batas Waktu Perbaikan</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{date('d-m-Y',strtotime($non_conformance->due_date))}}
                        </div>
                    </div>

                    <div class="title-form">
                        <h6>Tindak Lanjut Audit</h6>
                    </div><!-- /.title-form -->
                    
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Investigasi Akar Permasalahan</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->root_cause_investigation)}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Tidakan Perbaikan</label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->fix_action)}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-3 col-form-label">Bukti </label>
                        <div style="width:5px;">:</div>
                        <div class="col-8">
                            {{strip_tags($non_conformance->proof)}}
                        </div>
                    </div>
                    
                        
                </div><!-- /.form-wrapper -->

            </div>
            <div>
                    <a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.detail.export',['id'=>$audit->id,'non_conformance_id'=>$non_conformance->id])}}" class="btn btn-outline-danger">Ekspor</a>
                    <a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.detail.fix-export',['id'=>$audit->id,'non_conformance_id'=>$non_conformance->id])}}" class="btn btn-outline-primary">Tindak Lanjut Audit</a>
            </div>

        </div><!-- /.section-content-->
        <!-- end content -->

        
    </div>

</div>


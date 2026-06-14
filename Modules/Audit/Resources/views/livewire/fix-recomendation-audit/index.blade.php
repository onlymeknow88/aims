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
        ['name'=>'Rekomendasi dan Perbaikan'],
     ]
     ])
    
    <div class="wrapper_with_sidebar_right">

        <div class="section-content">
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="title-form text-center mb-3 p-3">
                        <h3>REKOMENDASI DAN PELUANG UNTUK PERBAIKAN</h3>
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

                <div class="form-wrapper col-sm-8">

                    <form class="py-4 d-flex flex-column gap-5">
                       
                        <div class="content-form d-flex flex-column gap-3">

                            <div class="title-form">
                                <h6>Uraian Rekomendasi dan Peluang untuk Perbaikan</h6>
                            </div><!-- /.title-form -->

                            @foreach($confirmances as $confirmance)
                            <div class="row form-group">
                                <label for="point" class="col col-form-label">Elemen</label>
                                <div class="col-8">
                                {{$confirmance->audit_sub_criteria->criteria->title}}
                                </div>

                            </div><!-- /.form-group elemen -->

                            <div class="row form-group">
                                <label for="point" class="col col-form-label">Sub Elemen</label>
                                <div class="col-8">
                                @if($confirmance->audit_sub_criteria->parent)
                                    @if($confirmance->audit_sub_criteria->parent->parent)
                                        @if($confirmance->audit_sub_criteria->parent->parent->parent)
                                        {{$confirmance->audit_sub_criteria->parent->parent->parent->title}}<br>
                                        @endif
                                        {{$confirmance->audit_sub_criteria->parent->parent->title}}<br>
                                    @endif
                                    {{$confirmance->audit_sub_criteria->parent->title}}<br>
                                @endif
                                {{$confirmance->audit_sub_criteria->title}}
                                </div>

                            </div><!-- /.form-group sub_elemen -->
                            
                            <div class="row form-group">
                                <label for="keterangan" class="col col-form-label d-flex flex-column">Rekomendasi dan Peluang untuk Perbaikan</label>
                                <div class="col-8">
                                    <x-inputs.texteditor-custom-array
                                        wire:model='fix_recommendation.{{$confirmance->id}}'
                                        id="fix_recommendation_{{$confirmance->id}}"
                                        input="fix_recommendation_{{$confirmance->id}}"
                                        placeholder="Rekomendasi dan perbaikan" 
                                        name="fix_recommendation.{{$confirmance->id}}"
                                        error="'Fix Recomendation'" >
                                    </x-inputs.texteditor-custom-array> 
                                </div>


                            </div><!-- /.form-group keterangan -->
                           
                            @endforeach
                        </div><!-- /.content-form -->
                        <div class="footer-action mb-2">
                                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <!-- <a href="{{route('audit::'.$category.'.detail.audit-fix-recommendation.export',['id'=>$audit->id])}}" class="btn btn-outline-danger">Ekspor</a> -->
                                <a href="{{route('audit::'.$category.'.detail.audit-fix-recommendation.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                                    <!-- <a href="" class="btn btn-outline-secondary">Batal</a> -->
                                    <button type="button" wire:click="save"
                                            class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                        Simpan
                                    </button>
                                </div>
                            </div>

                    </form>
                </div><!-- /.form-wrapper -->

            </div>

        </div><!-- /.section-content-->
        <!-- end content -->

        
    </div>

</div>


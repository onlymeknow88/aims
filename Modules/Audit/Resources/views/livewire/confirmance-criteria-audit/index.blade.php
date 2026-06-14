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
        ['name'=>'Kesesuaian Audit'],
     ]
     ])
    
     <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>KESESUAIAN AUDIT</h3>
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

            <div class="col-sm-12">

                <form class="py-4 d-flex flex-column gap-5">
                    
                    <div class="content-form d-flex flex-column gap-3">

                        <div class="title-form">
                            <h6>Uraian Kesesuaian Audit</h6>
                        </div><!-- /.title-form -->
                        @foreach($confirmances as $confirmance)
                        <div class="row form-group">
                            <label for="point" class="col-2 col-form-label">Elemen</label>
                            <div class="col-8">
                            {{$confirmance->audit_sub_criteria->criteria->title}}
                            </div>
                        </div><!-- /.form-group elemen -->

                        <div class="row form-group">
                            <label for="point" class="col-2 col-form-label">Sub Elemen</label>
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
                        <!-- wire:model="description"  -->
                        <div class="row form-group">
                            <label for="keterangan" class="col-2 col-form-label d-flex flex-column">Keterangan</label>
                            <div class="col-8">
                                <x-inputs.texteditor-custom-array
                                    wire:model='description.{{$confirmance->audit_sub_criteria->id}}'
                                    id="description_{{$confirmance->audit_sub_criteria->id}}"
                                    input="description_{{$confirmance->audit_sub_criteria->id}}"
                                    placeholder="Keterangan Audit" 
                                    name="description.{{$confirmance->audit_sub_criteria->id}}"
                                    error="'description'" >
                                {{-- $confirmance->audit_sub_criteria->description --}}
                                </x-inputs.texteditor-custom-array> 
                            </div>


                        </div><!-- /.form-group keterangan -->
                        
                        @endforeach
                    </div><!-- /.content-form -->
                    <div class="footer-action mb-2">
                            <div class="action-wrapper col-10 d-flex align-items-center justify-content-end gap-2">
                                <!-- <a href="{{route('audit::'.$category.'.detail.criteria-audit-conformance.export',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a> -->
                                <a href="{{route('audit::'.$category.'.detail.criteria-audit-conformance.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                                <!-- <a href="" class="btn btn-outline-secondary">Cancel</a> -->
                                <button type="button" wire:click="save"
                                        class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                    Simpan 
                                </button>
                            </div>
                        </div>

                </form>
            </div>

        </div><!-- /.com-sm-12 -->
        <!-- end content -->

        
    </div>

</div>

@push('styles')
    <style>
        /*table tr {*/
        /*    border-left: 1px solid #ddd;*/
        /*}*/
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
    @livewire('audit::layouts.sidebar-smkp',['id'=>$audit->id])
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=> 'SMKP','url'=>route('audit::smkp.index')],
        ['name'=>$audit->title,'url'=>route('audit::smkp.detail.index',['id'=>$audit->id])],
        ['name'=>'Metode dan Sample Audit'],
     ]
 ])
    <div class="container overflow-auto">
    <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                        <h3>METODE DAN SAMPEL AUDIT</h3>
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
                    <div class="col-2">Progress </div><div class="col-8">: {{$progress}} %</div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                
                <div class="content-form d-flex flex-column gap-3">

                    <div class="kegiatan-loop">
                        <table class="table table-bordered align-items-center table-sm">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th>No</th>
                                <th colspan="3" style="width: 96%;">Kriteria</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audit->criteria_module->criteria as $criteria)
                                <tr>
                                    <td class="bl text-center" width="10"
                                        rowspan="{{($criteria->elements()->count()+1)}}">
                                        {{number2roman($loop->index+1)}}
                                    </td>
                                    <td colspan="3" width="40%">
                                        {{substr(strstr($criteria->title," "), 1)}}
                                    </td>
                                </tr>
                                @foreach($criteria->sub_criteria as $subCriteria)
                                    <tr class="{{!$loop->last?"border-bottom":""}}">
                                        <td width="10"
                                            rowspan="{{$subCriteria->children->count()+1}}">{{strstr($subCriteria->title," ",1)}}</td>
                                        <td colspan="2">{{strstr($subCriteria->title," ")}} {!! $subCriteria->children->count() == 0 && $subCriteria->has_point?'<span  wire:click="goTo('."'".$subCriteria->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}</td>
                                    </tr>
                                    @foreach($subCriteria->children as $child)
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            <td width="10">{{strstr($child->title," ",1)}}</td>
                                            <td>{{strstr($child->title," ")}} <span wire:click="goTo('{{$child->id}}')"><i
                                                        class="fa fa-pencil"></i></span></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div><!-- /.content-form -->
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->
</div>

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
        ['name'=>'Ketidaksesuaian Audit'],
     ]
     ])
    
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-1">
                    <h3>KETIDAKSESUAIAN AUDIT</h3>
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
                <div class="py-4 d-flex flex-column gap-5">
                    
                   
                    <div class="table-content table-responsive position-relative">

                        <div class="table-wrapper">

                            <table class="table overflow-auto" id="table-mandays">
                                <thead>
                                <tr>
                                    <th width="10px" >No</th>
                                    <th width="220px" >Nomor Ketidaksesuaian</th>
                                    <th width="710px" >Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Batas Waktu Perbaikan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($this->non_confirmances as $non_confirmance)
                                    <tr>
                                        <td style="vertical-align:top">{{++$startNumber}}</td>
                                        <td style="vertical-align:top"><a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.detail',['id'=>$audit->id,'non_conformance_id'=>$non_confirmance->id])}}">{{$non_confirmance->non_confirmance_number}}</a></td>
                                        <td style="vertical-align:top">
                                            {{strip_tags($non_confirmance->problem_description)}}
                                        </td>
                                        <td style="vertical-align:top">
                                            {{strip_tags($non_confirmance->category)}}
                                        </td>
                                        <td style="vertical-align:top">{{date('d-m-Y',strtotime($non_confirmance->due_date))}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.table-wrapper -->
                    </div>
                    @if($category == 'smkp')
                        <div class="d-flex flex-column">

                            <div class="row">
                                <div class="col-2">Jumlah Temuan Kritikal</div>
                                <div class="col-8">:
                                    {{$categories["critical"]}}
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="point" class="col-2 ">Jumlah Temuan Mayor</label>
                                <div class="col-8">: {{$categories["mayor"]}}</div>

                            </div>
                            <div class="row form-group">
                                <label for="point" class="col-2">Jumlah Temuan Minor</label>
                                <div class="col-8">:
                                    {{$categories["minor"]}}
                                </div>

                            </div>
                        </div>
                    @endif    
                    <div>

                    <a href="{{route('audit::'.$category.'.detail.criteria-audit-non-conformance.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                    </div>
                </div>
            </div><!-- ./col-sm-12 -->
        </div><!-- /.row -->
        
    </div>

</div>


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
    @livewire('audit::layouts.sidebar-'.$category,['id'=>$audit->id])
</x-slot>
<div class="inner-content" style="margin-left: 15px;">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Kriteria Audit'],
     ]
 ])

    <div class="container overflow-auto">
        {{--<div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>PEMENUHAN TERHADAP POIN SMK3</h3>
                    </div>
                </div>
            </div>
        </div>--}}
        {{--<div class="row justify-content-center">
            <div class="col-sm-12">
                
                <div class="content-form d-flex flex-column gap-3">

                    <div class="kegiatan-loop">
                        <table class="table table-bordered align-items-center table-sm">

                            <thead class="thead-light">
                            <tr style="border-left:1px solid #dddddd;">
                                <th style="width:5%;vertical-align:middle" class="text-white bg-success">
                                    <h5>NO</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>ELEMEN</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>POINT MAX</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>BOBOT ELEMEN</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>POINT PEMENUHAN</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>SKOR AUDIT</h5>
                                </th>
                                <th class="text-center text-white bg-success" style="vertical-align:middle">
                                    <h5>PERSENTASE PEMENUHAN ELEMEN</h5>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audit->criteria_module->criteria as $criteria)
                                <tr>
                                    <td class="bl text-center" width="10">
                                        @if($audit->audit_category == 'SMK3')
                                            {{$loop->index+1}}
                                        @elseif ($audit->audit_category == 'SMKP')
                                            {{number2roman($loop->index+1)}}
                                        @endif
                                    </td>
                                    <td>
                                        {{substr(strstr($criteria->title," "), 1)}}
                                    </td>
                                    <td class="text-center">
                                        0
                                    </td>
                                    <td class="text-center">
                                        0%
                                    </td>
                                    <td class="text-center">
                                        0
                                    </td>
                                    <td class="text-center">
                                        0%
                                    </td>
                                    <td class="text-center">
                                        0%
                                    </td>
                                </tr>
                                
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div><!-- /.content-form -->
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->--}}

    </div><!-- /.container -->

    {{--<div class="container overflow-auto mb-3 mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="shrt6"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.row -->

    </div><!-- /.container -->--}}

    <div class="container overflow-auto">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3 >KRITERIA AUDIT</h3>
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
                        Progress
                    </div>
                    <div class="col-8">
                        : {{$progress}} % 
                    </div>
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
                                <th style="width:5%;vertical-align:middle" class="text-white bg-success"  ><h5>NO</h5></th>
                                <th colspan="3" class="text-center text-white bg-success" style="vertical-align:bottom; white-space: normal"  ><h5>KRITERIA</h5> </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($audit->criteria_module->criteria as $criteria)
                                <tr>
                                    <td class="bl text-center" width="10"
                                        rowspan="{{($criteria->elements()->count()+1)}}">
                                        @if($audit->audit_category == 'SMK3')
                                            {{$loop->index+1}}
                                        @elseif ($audit->audit_category == 'SMKP')
                                            {{number2roman($loop->index+1)}}
                                        @endif
                                    </td>
                                    <td colspan="3" style="white-space: normal">
                                        {{substr(strstr($criteria->title," "), 1)}}
                                    </td>
                                </tr>
                                @foreach($criteria->sub_criteria as $subCriteria)
                                    <tr class="{{!$loop->last?"border-bottom":""}}">
                                        <td width="10"
                                            rowspan="{{$subCriteria->children->count()+1}}">{{strstr($subCriteria->title," ",1)}}</td>
                                        <td colspan="2" style="white-space: normal">{{strstr($subCriteria->title," ")}} {!! $subCriteria->children->count() == 0 && $subCriteria->has_point?'<span wire:click="goTo('."'".$subCriteria->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}</td>
                                    </tr>
                                    @foreach($subCriteria->children as $child)
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            <td width="10">{{strstr($child->title," ",1)}}</td>
                                            <td style="white-space: normal">{{strstr($child->title," ")}} <span wire:click="goTo('{{$child->id}}')"><i
                                                        class="fa fa-pencil"></i></span></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                    {{-- <a href="{{route('audit::'.$category.'.detail.criteria-audit.export-xls',['id'=>$audit->id])}}" class="btn btn-outline-danger">Ekspor</a> --}}
                    {{--<a href="#" wire:click="export" class="btn btn-outline-danger mb-5">Export</a>--}}
                    </div> 
                    
                </div><!-- /.content-form -->
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->
</div>


@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
@endonce
@push('scripts')
<script>
    function generateRandomRGB() {
        const red = Math.floor(Math.random() * 256); // Random value from 0 to 255
        const green = Math.floor(Math.random() * 256);
        const blue = Math.floor(Math.random() * 256);

        return `rgb(${red}, ${green}, ${blue})`;
    }

    var ctx6 = document.getElementById('shrt6').getContext('2d');
    var chart6 = new Chart(ctx6, {
      type: 'radar',
      data: {
        labels: ['KEBIJAKAN', 'PERENCANAAN', 'ORGANISASI DAN PERSONEL', 'IMPLEMENTASI', 'PEMANTAUAN, EVALUASI DAN TINDAK LANJUT', 'DOKUMENTASI', 'TINJAUAN MANAJEMEN DAN PENINGKATAN KINERJA'],
        datasets: [
            @foreach($audit->criteria_module->criteria as $index => $item)
            {
                label: '{{ $item->title }}',
                data: [0],
                borderColor: generateRandomRGB(),
                borderWidth: 1
             },
            @endforeach
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
</script>
@endpush
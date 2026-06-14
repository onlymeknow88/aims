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
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Kriteria Audit'],
     ]
 ])

    {{--<div class="container overflow-auto">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>PEMENUHAN TERHADAP POIN SMKP</h3>
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
                                @php
                                   $index =  4;
                                @endphp
                            @foreach($audit->criteria_module->criteria as $criteria)
                                <tr>
                                    <td class="bl text-center" width="10">
                                        {{number2roman($index++)}}
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
                    <div>
                    <a href="{{route('audit::'.$category.'.detail.criteria-audit.export-xls',['id'=>$audit->id])}}" class="btn btn-outline-danger">Ekspor</a>
                    </div> 
                    
                </div><!-- /.content-form -->
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->--}}

    {{--<div class="container overflow-auto">
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
                    <h3>KRITERIA AUDIT</h3>
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
                                <th scope="col" style="width:10px" class="text-white bg-success"><h5>NO</h5></th>
                                <th colspan="4" scope="col" class="text-center text-white bg-success" style="white-space: normal"><h5>KRITERIA</h5> </th>
                            </tr>
                            </thead>
                            <tbody>
                               @php
                                   $index =  4;
                               @endphp
                            
                            @foreach($audit->criteria_module->criteria as $criteria)
                                <tr>
                                    <td class="bl text-center" width="10"
                                    rowspan="{{($criteria->elements()->count()+1)}}"
                                        >
                                        {{number2roman($index++)}}
                                        <!-- {{$criteria->elements()->count()}} -->
                                        
                                    </td>
                                    <td colspan="4" width="95%">
                                        {{substr(strstr($criteria->title," "), 1)}}
                                    </td>
                                </tr>
                                @foreach($criteria->sub_criteria as $subCriteria)
                                    @php
                                        $rowspan = $subCriteria->children->count();
                                        foreach($subCriteria->children as $children){
                                            $rowspan += $children->children->count();
                                            foreach($children->children as $childChildren){
                                                $rowspan += $childChildren->children->count();
                                            }
                                        }
                                    @endphp
                                    <tr class="{{!$loop->last?"border-bottom":""}}">
                                        <td width="10"
                                            rowspan="{{$rowspan+1}}">{{strstr($subCriteria->title," ",1)}}
                                        </td>
                                        <td colspan="3" style="white-space: normal">{!! strstr($subCriteria->title," ") !!}  {!! $subCriteria->children->count() == 0 && $subCriteria->has_point?'<span  wire:click="goTo('."'".$subCriteria->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}</td>
                                    </tr>
                                    @foreach($subCriteria->children as $child)
                                        @php
                                        
                                            $rowspan = $child->children->count();
                                            foreach($child->children as $childChildren){
                                                $rowspan += $childChildren->children->count();
                                            }
                                            
                                        @endphp
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            @if ($child->children->count() > 0)
                                                
                                            <td rowspan="{{$rowspan+1}}" width="10">{{strstr($child->title," ",1)}}</td>

                                            <td colspan="3" style="white-space: normal">{!! strstr($child->title, " ") !!} 
                                                {!! $child->children->count() == 0 && $child->has_point?'<span  wire:click="goTo('."'".$child->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}
                                                
                                                    </td>
                                            @else
                                            <td colspan="3" style="white-space: normal">{!! $child->title !!} 
                                                {!! $child->children->count() == 0 && $child->has_point?'<span  wire:click="goTo('."'".$child->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}
                                                
                                            @endif
                                        </tr>
                                        @foreach ($child->children as $subChildren )
                                        @php
                                            $rowspan = $subChildren->children->count();
                                        @endphp
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            @if ($subChildren->children->count() > 0)
                                            <td rowspan="{{$rowspan+1}}"  width="10">{{strstr($subChildren->title," ",1)}}</td>
                                            <td >{{strstr($subChildren->title," ")}}
                                            {!! $subChildren->children->count() == 0 && $subChildren->has_point?'<span  wire:click="goTo('."'".$subChildren->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}
                                                
                                                    </td>
                                            @else
                                            <td colspan="2" style="white-space: normal">{!! $subChildren->title," " !!}
                                            {!! $subChildren->children->count() == 0 && $subChildren->has_point?'<span  wire:click="goTo('."'".$subChildren->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}
                                                    </td>
                                            @endif
                                        </tr>
                                        @foreach ($subChildren->children as $subChildChildren )
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            
                                            <td colspan="2" style="white-space: normal">{!! $subChildChildren->title !!}
                                            {!! $subChildChildren->children->count() == 0 && $subChildChildren->has_point?'<span wire:click="goTo('."'".$subChildChildren->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}
                                                    </td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                    {{-- <a href="{{route('audit::smkp.detail.criteria-audit.export-xls',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                    </div> 
                    --}}
                    {{--<a href="#" wire:click="export" class="btn btn-outline-danger mb-5">Export</a>--}}
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
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

        td {
            border: 2px solid black;
        }

        th {
            border: 2px solid black;
        }

        .tooltip-text {
          visibility: hidden;
          position: absolute;
          z-index: 1;
          width: 100px;
          color: white;
          font-size: 12px;
          background-color: #192733;
          border-radius: 10px;
          padding: 10px 15px 10px 15px;
        }

        .hover-text:hover .tooltip-text {
          visibility: visible;
        }

        #top {
          top: -40px;
          left: -50%;
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
                        <table class="align-items-center table-sm">

                            <thead class="">
                            <tr>
                                <th style="width:5%;vertical-align:middle; background-color: #F5F5F5 !important;">
                                    No
                                </th>
                                <th class="text-center" style="min-width:5%;vertical-align:middle; background-color: #F5F5F5 !important;">
                                    Elemen</h5>
                                </th>
                                <th class="text-center" style="vertical-align:middle; white-space: normal; background-color: #F5F5F5 !important;">
                                    Point Max
                                </th>
                                <th class="text-center" style="vertical-align:middle; white-space: normal; background-color: #F5F5F5 !important;">
                                    Bobot Elemen
                                </th>
                                <th class="text-center" style="vertical-align:middle; white-space: normal; background-color: #F5F5F5 !important;">
                                    Point Pemenuhan
                                </th>
                                <th class="text-center" style="vertical-align:middle; white-space: normal; background-color: #F5F5F5 !important;">
                                    Skor Audit
                                </th>
                                <th class="text-center" style="vertical-align:middle; white-space: normal; background-color: #F5F5F5 !important;">
                                    Persentase Pemenuhan Elemen
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $total_max_point = 0;
                                $total_value = 0;
                                $total_point = 0;
                                $total_score = 0;
                                $total_percentage = 0;
                            @endphp
                            @foreach($audit->criteria_module->criteria as $criteria)

                                @php
                                    $criteria_max_point = 0;
                                    $criteria_point = 0;
                                @endphp

                                @foreach($criteria->sub_criteria as $subCriteria)
                                    @php
                                        $sub_criteria_max_point = 0;
                                        $sub_criteria_point = 0;
                                    @endphp

                                    @if($subCriteria->children()->exists())
                                        @foreach($subCriteria->children as $subSubCriteria)
                                            @php
                                                $sub_sub_criteria_max_point = $subSubCriteria->target_point;
                                                $sub_sub_criteria_point = $subSubCriteria->point;

                                                $sub_criteria_max_point = $sub_criteria_max_point + $sub_sub_criteria_max_point;
                                                $sub_criteria_point = $sub_criteria_point + $sub_sub_criteria_point;

                                            @endphp
                                        @endforeach
                                    @else
                                        @php
                                            $sub_criteria_max_point = $subCriteria->target_point;
                                            $sub_criteria_point = $subCriteria->point;
                                        @endphp
                                    @endif

                                    @php
                                        $criteria_max_point = $criteria_max_point + $sub_criteria_max_point;
                                        $criteria_point = $criteria_point + $sub_criteria_point;
                                    @endphp
                                @endforeach

                                <tr>
                                    <td class="text-center" width="10">
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
                                        @php
                                            $total_max_point = $total_max_point + $criteria_max_point;
                                        @endphp
                                        {{$criteria_max_point}}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $total_value = $total_value + $criteria->element_value;
                                        @endphp
                                        {{$criteria->element_value}}%
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $total_point = $total_point + $criteria_point;
                                        @endphp
                                        {{$criteria_point}}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            if ($criteria_max_point != 0) {
                                                $score = $criteria_point / $criteria_max_point * $criteria->element_value;
                                            } else {
                                                $score = 0;
                                            }
                                            $total_score += $score;
                                        @endphp

                                        {{ round($score, 2) }}%
                                    </td>
                                    <td class="text-center">
                                        {{--@php
                                            $total_percentage = $total_percentage + ($criteria_point/$criteria_max_point * 100);
                                        @endphp--}}
                                        {{ $criteria_max_point != 0 ? round($criteria_point / $criteria_max_point * 100, 2) : 0 }}%
                                    </td>
                                </tr>

                            @endforeach

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <b>Total:</b>
                                    </td>
                                    <td class="text-center">
                                        {{$total_max_point}}
                                    </td>
                                    <td class="text-center">
                                        {{$total_value}}%
                                    </td>
                                    <td class="text-center">
                                        {{$total_point}}
                                    </td>
                                    <td class="text-center">
                                        {{round($total_score, 2)}}%
                                    </td>
                                    <td class="text-center">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!-- /.content-form -->
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->

    <div class="container overflow-auto mb-3 mt-3">
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

    </div><!-- /.container -->

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
                        <table class="align-items-center table-sm">

                            <thead class="thead-light">
                            <tr style="border: 2px solid black;">
                                <th rowspan="2" style="min-width:5%; vertical-align:middle; background-color: #F5F5F5 !important;" class="">
                                    No
                                </th>
                                <th rowspan="2" colspan="3" style="min-width:30%; vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    Kriteria
                                </th>
                                <th rowspan="2" style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Nilai Elemen %
                                    </span>
                                </th>
                                <th rowspan="2" style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Nilai Sub Elemen
                                    </span>
                                </th>
                                <th rowspan="2" style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Nilai Sub sub Elemen
                                    </span>
                                </th>
                                <th colspan="4" style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="white-space: nowrap;">
                                        Nilai Audit
                                    </span>
                                </th>
                                <th rowspan="2" style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Status
                                    </span>
                                </th>
                            </tr>
                            <tr style="background-color: #F5F5F5 !important;">
                                <th style="vertical-align:middle" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Nilai Sub Elemen
                                    </span>
                                </th>
                                <th style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Nilai sub sub elemen
                                    </span>
                                </th>
                                <th style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Total Nilai Elemen
                                    </span>
                                </th>
                                <th style="vertical-align:middle; background-color: #F5F5F5 !important;" class="text-center">
                                    <span style="-ms-writing-mode: tb-rl; -webkit-writing-mode: vertical-rl; writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap;">
                                        Presentase Nilai Elemen
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $critical = 0;
                                    $mayor = 0;
                                    $minor = 0;
                                @endphp

                                @foreach($audit->criteria_module->criteria as $criteria)
                                    @php
                                        $criteria_max_point = 0;
                                        $criteria_point = 0;
                                    @endphp

                                    @foreach($criteria->sub_criteria as $subCriteria)
                                        @php
                                            $sub_criteria_max_point = 0;
                                            $sub_criteria_point = 0;
                                        @endphp

                                        @if($subCriteria->children()->exists())
                                            @foreach($subCriteria->children as $subSubCriteria)
                                                @php
                                                    $sub_sub_criteria_max_point = $subSubCriteria->target_point;
                                                    $sub_sub_criteria_point = $subSubCriteria->point;

                                                    $sub_criteria_max_point = $sub_criteria_max_point + $sub_sub_criteria_max_point;
                                                    $sub_criteria_point = $sub_criteria_point + $sub_sub_criteria_point;

                                                @endphp
                                            @endforeach
                                        @else
                                            @php
                                                $sub_criteria_max_point = $subCriteria->target_point;
                                                $sub_criteria_point = $subCriteria->point;
                                            @endphp
                                        @endif

                                        @php
                                            $criteria_max_point = $criteria_max_point + $sub_criteria_max_point;
                                            $criteria_point = $criteria_point + $sub_criteria_point;
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td class="text-center" width="10"
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
                                        {{--<td class="text-center">
                                            {{$criteria_max_point}}
                                        </td>--}}
                                        <td class="text-center">{{$criteria->element_value}}%</td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center">{{$criteria_point}}</td>
                                        <td class="text-center">
                                            {{ $criteria_max_point != 0 ? round($criteria_point / $criteria_max_point * 100, 2) : 0 }}%
                                        </td>
                                        <td class="text-center"></td>
                                    </tr>
                                    @foreach($criteria->sub_criteria as $subCriteria)
                                        <tr class="{{!$loop->last?"border-bottom":""}}">
                                            <td width="10"
                                                rowspan="{{$subCriteria->children->count()+1}}">{{strstr($subCriteria->title," ",1)}}</td>
                                            <td colspan="2" style="white-space: normal">{{strstr($subCriteria->title," ")}} {!! $subCriteria->children->count() == 0 && $subCriteria->has_point?'<span  wire:click="goTo('."'".$subCriteria->id."'".')"><i class="fa fa-pencil"></i></span>':''!!}</td>
                                            <td class="text-center"></td>
                                            <td class="text-center">
                                                @if($subCriteria->children()->exists())
                                                    {{$subCriteria->children()->sum('max_point') ?? '-' }}
                                                @else
                                                    {{$subCriteria->max_point ?? '-' }}
                                                @endif
                                            </td>
                                            <td class="text-center"></td>
                                            <td class="text-center">
                                                @if($subCriteria->children()->exists())
                                                    {{$subCriteria->children()->where('point', '!=', null)->count() > 0 ? $subCriteria->children()->sum('point') : '-'}}
                                                @else
                                                    {{$subCriteria->point ?? '-' }}
                                                @endif
                                            </td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center">
                                                @if($subCriteria->children()->exists())
                                                    @if($subCriteria->children()->where('point', '!=', null)->count() > 0)
                                                        @if($subCriteria->children()->where('is_critical', 1)->count() > 0)
                                                            Kritikal
                                                            @php $critical++ @endphp
                                                        @elseif($subCriteria->children()->sum('point') == $subCriteria->children()->sum('max_point'))

                                                        @else
                                                            @if($subCriteria->children()->sum('point')/$subCriteria->children()->sum('max_point')*100 > 50)
                                                                Minor
                                                                @php $minor++ @endphp
                                                            @else
                                                                Mayor
                                                                @php $mayor++ @endphp
                                                            @endif
                                                        @endif
                                                    @else

                                                    @endif
                                                @else
                                                    @if($subCriteria->is_critical == 1)
                                                        Kritikal
                                                        @php $critical++ @endphp
                                                    @elseif($subCriteria->point != null)
                                                        @if($subCriteria->point == $subCriteria->max_point)

                                                        @elseif($subCriteria->point/$subCriteria->max_point*100 < 50)
                                                            Mayor
                                                            @php $mayor++ @endphp
                                                        @else
                                                            @if($subCriteria->locations->count() > 0)
                                                                @if($subCriteria->locations()->where('status', 'non confirmance')->count() / $subCriteria->locations->count() * 100 > 30)
                                                                    Mayor
                                                                    @php $mayor++ @endphp
                                                                @else
                                                                    Minor
                                                                    @php $minor++ @endphp
                                                                @endif
                                                            @else
                                                                Minor
                                                                @php $minor++ @endphp
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @foreach($subCriteria->children as $child)
                                            <tr class="{{!$loop->last?"border-bottom":""}}">
                                                <td width="10">{{strstr($child->title," ",1)}}</td>
                                                <td style="white-space: normal">{{strstr($child->title," ")}} <span wire:click="goTo('{{$child->id}}')"><i
                                                            class="fa fa-pencil"></i></span></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center">{{$child->max_point ?? '-'}}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center">{{$child->point ?? '-'}}</td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                    {{-- <a href="{{route('audit::'.$category.'.detail.criteria-audit.export-xls',['id'=>$audit->id])}}" class="btn btn-outline-danger">Ekspor</a> --}}
                    <a href="#" wire:click="export" class="btn btn-outline-danger mb-5">Export</a>
                    </div>

                </div><!-- /.content-form -->
                <div class="d-flex flex-column">

                    <div class="row">
                        <div class="col-2">Jumlah Temuan Kritikal</div>
                        <div class="col-8">:
                            {{$critical}}
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-2 ">Jumlah Temuan Mayor</label>
                        <div class="col-8">:
                            {{$mayor}}
                        </div>

                    </div>
                    <div class="row form-group">
                        <label for="point" class="col-2">Jumlah Temuan Minor</label>
                        <div class="col-8">:
                            {{$minor}}
                        </div>

                    </div>
                </div>
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
        // datasets: [
        //     @foreach($audit->criteria_module->criteria as $index => $item)
        //     {
        //         label: '{{ $item->title }}',
        //         data: [{{ $item->element_value }}],
        //         borderColor: generateRandomRGB(),
        //         borderWidth: 1
        //      },
        //     @endforeach
        // ]
        labels: @json($audit->criteria_module->criteria()->pluck('title')),
        datasets: [{
            label: 'Persentase Pemenuhan Elemen',
            data: @json($this->dataset),
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }]
        },
        // options: {
        //     scales: {
        //       y: {
        //         beginAtZero: true
        //       }
        //     }
        // },
        options: {
            scales: {
                r: {
                    grid: {
                        lineWidth: 4
                    }
                }
            }
        }
    });
</script>
@endpush

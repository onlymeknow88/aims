@push('styles')
    <style>
        table tr {
            border-left: 1px solid #ddd;
        }
        table td {
            /* border: solid 1px #666; */
            word-wrap: break-word;
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
        ['name'=>'Susunan kegiatan Pelaksanaan Audit'],
     ]
 ])
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>SUSUNAN KEGIATAN PELAKSANAAN AUDIT</h3>
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
          
                <form class="form-susunan-kegiatan py-4 d-flex flex-column gap-5" action="#" action="post"
                      wire:submit.prevent='save'>
                    
                    <div class="content-form d-flex flex-column gap-3">

                        <div class="kegiatan-loop">
                            @foreach($implementationActivity->details as $activity)
                                <div class="mb-5">
                                    <div class="row mb-3 justify-content-between ">
                                        <div class="col-sm-10 d-flex align-items-center gap-3">
                                            <h6 class=" mb-0">Hari ke {{$loop->index+1}}
                                                ({{$activity->date->translatedFormat('d F Y')}})</h6>
                                            <div>
                                                <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#modalDate"
                                                        wire:click="setDateId('{{$activity->id}}')"
                                                        class="btn btn-secondary btn-sm"><i
                                                        class="fa fa-pencil"></i></button>
                                                <button type="button" wire:click="deleteDate('{{$activity->id}}')"
                                                        class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>

                                        </div>
                                    </div>
                                    <div>

                                        <table class="table table-bordered align-items-center table-sm">

                                            <thead class="thead-light">
                                            <tr style="border-left:1px solid #dddddd;">
                                                <th style="width:40px;padding-left:8px">#</th>
                                                <th style="width:120px;padding-left:8px">Waktu</th>
                                                <th >Fungsi / Area / Departemen / Kegiatan yang akan di audit (termasuk
                                                    persyaratan terkait)
                                                </th>
                                                <th style="width:150px;padding-left:8px">Auditor</th>
                                                <th style="width:50px;text-align:center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($activity->schedules as $schedule)
                                                <tr style="border-left:1px solid #dddddd;">
                                                    <td style="padding-left:8px;vertical-align:top">{{$loop->index + 1}}</td>
                                                    <td style="padding-left:8px;vertical-align:top">{{Carbon\Carbon::parse($schedule->start_time)->format('H:i')." - ".Carbon\Carbon::parse($schedule->end_time)->format('H:i')}}</td>
                                                    @if($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::FREE_TEXT)
                                                        <td style="padding-left:8px;vertical-align:top">{!! $schedule->description !!}</td>
                                                        <td style="padding-left:8px;vertical-align:top">{{$schedule->auditors->implode('name',',')}}</td>
                                                        {{-- <td style="padding-left:8px;vertical-align:top">{!! $schedule->auditor !!}</td> --}}
                                                    @elseif($schedule->schedule_activity_type ==\Modules\Audit\Enums\ScheduleActivityType::OPENING || $schedule->schedule_activity_type ==\Modules\Audit\Enums\ScheduleActivityType::CLOSING)
                                                        <td style="padding-left:8px;vertical-align:top">
                                                            <p class="mb-0">{{$schedule->title}}</p>
                                                            {!! $schedule->location !!}
                                                        </td>
                                                        <td style="padding-left:8px;vertical-align:top">{!! $schedule->auditor !!}</td>
                                                    @elseif($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ISOMA)
                                                        <td style="padding-left:8px;vertical-align:top">{{$schedule->title}}</td>
                                                        <td style="padding-left:8px;vertical-align:top">{{$schedule->auditor}}</td>
                                                    @elseif($schedule->schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ACTIVITY)
                                                        <td style="padding-left:8px;vertical-align:top;word-wrap: break-word;">
                                                            Lokasi : {{$schedule->location}} <br>
                                                            Metode : {{$schedule->method}} <br>
                                                            Auditee : {{$schedule->auditee??"-"}}<br><br>
                                                            <ul>
                                                                @foreach($schedule->sub_criteria as $criteria)
                                                                    {{--@if($criteria->parent)
                                                                        @if($criteria->parent->parent)
                                                                            @if($criteria->parent->parent->parent)
                                                                                {{$criteria->parent->parent->parent->title}}<br>
                                                                            @endif
                                                                            {{$criteria->parent->parent->title}}<br>
                                                                        @endif
                                                                        {{$criteria->parent->title}}<br>
                                                                    @endif--}}
                                                                    <li>{{$criteria->title}}</li>
                                                                @endforeach

                                                            </ul>

                                                        </td>
                                                        <td style="padding-left:8px;vertical-align:top">{{$schedule->auditors->implode('name',',')}}</td>
                                                    @endif


                                                    <td style="text-align:center;vertical-align:top">
                                                        <button type="button" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash"
                                                                wire:click="deleteSchedule('{{$schedule->id}}')"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty

                                            @endforelse

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-right">
                                                    <button type="button" class="btn btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalFormSchedule"
                                                            wire:click="setDateId('{{$activity->id}}')">+ Add Schedule
                                                    </button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                </div>
                            @endforeach
                            <div class="add-kegiatan">
                                <button type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDate"
                                        class="btn btn-outline-success">+ Add Activity
                                </button>

                                <a href="{{route('audit::'.$category.'.detail.implementation-schedule.export-word',['id'=>$audit->id])}}" class="btn btn-outline-danger">Export</a>
                            </div>

                        </div>


                    </div><!-- /.content-form -->

                    <div class="space">
                        <hr>
                    </div>

                    <!-- <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit"
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                Simpan
                            </button>
                        </div>
                    </div> -->

                </form>
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->
    @include('audit::livewire.implementation-schedule.modal-date')
    @include('audit::livewire.implementation-schedule.modal-activity')

</div><!-- /.inner-content -->
@once
    @push('styles')
        <!-- summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @endpush
@endonce

@once
    @push('scripts')
        <!-- summernote -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @endpush
@endonce
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });
    </script>
@endpush

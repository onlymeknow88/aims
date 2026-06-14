<div class="calendar-list card rounded-4 p-3 ">
    <div class="container-right-top py-1 ">
        <h6>Calendar Of Event</h6>
        <div class="item">
            <a href="{{ url('coe') }}"> Show all</a>
        </div>
    </div><!-- /.coe-list-title -->

    
    @php
        $color = ['pink', 'orange', 'green', 'blue', 'purple', 'red', 'pink', 'orange', 'green', 'blue', 'purple', 'red'];
    @endphp

    <div class="calendar-list-body">
        <table class="calendar-of-event-table">

            @foreach ($data as $index => $list)
                <tr>
                    <td>
                        <div class="circle" style="background:{{ isset($color[$index]) ? $color[$index] : null }}">
                            {{ strtoupper(substr($list['title'], 0, 1)) }}</div>
                    </td>
                    <td>
                        <div class="title">{{ $list['title'] }}</div>
                        <div class="date-place"><span class="date">{{ $list['date']}}</span>  <span></span></div>
                        
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</div>

{{-- include popup --}}
{{-- @include('livewire.main-dashboard.public.components.modal.modalCalendarOfEvent', [
    'data' => $data,
    'id' => 'CalendarOfEvent',
]) --}}

@push('styles')
    <style>
        .calendar-of-event-table {
            width: 100%;
            color: gray
        }

        .calendar-of-event-table th,
        .calendar-of-event-table td {
            white-space: unset;
            position: unset;
            padding: 8px 5px !important;
            margin: 0px !important;
            height: auto;
            border-bottom: 1px solid rgb(216, 214, 214);
            font-size: 14px;
            color: rgba(50, 49, 48, 1);
            font-weight: 500;
        }

        .calendar-of-event-table td:nth-child(1) {
            width: 15%;
            padding: .5rem !important;
        }
        .calendar-of-event-table td .title{
            color: rgba(50, 49, 48, 1) !important;
        }
        .calendar-of-event-table td .date-place{
            font-size: 12px;
            font-weight: 400;
            color: rgba(50, 49, 48, .8)
        }
    </style>
@endpush

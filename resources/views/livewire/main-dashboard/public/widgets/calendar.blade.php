<div class="calendar-grid">
    <div class="card bg-white chart-items rounded-3">
        <div class="card-body p3">
            <div id="calendar-right" class="calendar-right"></div>
        </div>
    </div>    
</div>
@once
    @push('styles')
        <link rel="stylesheet" href="{{asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css')}}"/>
    @endpush
@endonce

@push('styles')
    <style>
        #calendar-right table th,
        #calendar-right table td{
            padding:0px !important;
        }
        #calendar-right table tr{
            border-left-width: 1px;
        }
        #calendar-right.fc .fc-scrollgrid, 
        #calendar-right.fc .fc-scrollgrid table{
            max-width: 100%;
        }
        #calendar-right.fc .fc-daygrid-body{
            width: auto !important;
        }
        /* #calendar-right.fc .fc-daygrid-body-natural .fc-daygrid-day-events{
            margin-bottom: 0;
        } */
    </style>
@endpush
@once
    @push('scripts')
    <script src="{{asset('assets/js/fullcalendar/index.global.min.js')}}"></script>
    @endpush
@endonce

@push('scripts')
    <script>

    document.addEventListener('livewire:load', function() {

        $(function() {
            var calendarEl = document.getElementById('calendar-right');
            var calendar = new FullCalendar.Calendar(calendarEl, { 
                aspectRatio:  5, 
                contentHeight: 'auto',                  
                initialView: 'dayGridMonth',
                //themeSystem: 'bootstrap5',
                eventColor: 'blue',
                events: {!! $events !!},
                headerToolbar: {
                    start: 'prev',
                    center: 'title', 
                    end: 'next'
                },
                buttonIcons:{
                    more: 'bi bi-three-dots-vertical',
                    prev: 'chevron-left',
                    next: 'chevron-right',
                }
            });
            calendar.render();
            
        });
    });

    </script>
@endpush

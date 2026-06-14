<div class="inner-content">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="#" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa fa-calendar"></i></span>
                <span>Calendar Of Event</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->
    </div>

    <div class="d-flex">
        {{ $ids }}

    </div>
</div>

{{--
@once
@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
@endpush
@endonce

@once
@push('scripts')
    <script src="{{ asset('assets/js/fullcalendar/index.global.min.js') }}"></script>
@endpush
@endonce

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        $(function() {
            var event = {!! $this->events !!};
            var calendarEl = document.getElementById('calendar-coe');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                eventColor: '#D2FFE9',
                events: event,
                headerToolbar: {
                    start: 'prev,next title',
                    center: '',
                    end: 'countEvent,addNew,import,export,more'
                },
                eventClick: function(info) {
                    Livewire.emit('openDetail', info.event.id);
                    setTimeout(() => calendar.updateSize(), 300)
                },
                customButtons: {
                    countEvent: {
                        text: '{{ $count_event }} Running Event',
                    },
                    addNew: {
                        text: 'Add New',
                        click: function() {
                            window.location.href = "{{ route('add-event') }}"
                        }
                    },
                    import: {
                        text: 'Import',
                        click: function() {
                            @this.import();
                           //  modalWindowOverlay.style.display = 'none';
                        }
                    },
                    export: {
                        text: 'Export',
                        click: function() {
                            @this.export();
                        }
                    },
                    more: {
                        text: '',
                        click: function() {
                            alert('clicked the custom button!');
                        }
                    },
                    prev: {
                        click: function() {
                            calendar.prev();
                            var date = calendar.getDate().toISOString();
                            @this.set('date', date);
                        }
                    },
                    next: {
                        click: function() {
                            calendar.next();
                            var date = calendar.getDate().toISOString();
                            @this.set('date', date);
                        }
                    },
                },

                buttonIcons: {
                    more: 'bi bi-three-dots-vertical',
                    prev: 'chevron-left',
                    next: 'chevron-right',
                }
            });

            function reLoad() {
                calendar.refetchEvents();
            }

            calendar.render();

            /* set dropdown bulan */
            $(".fc-toolbar-chunk:first .fc-toolbar-title").after(
                ' <select class="select_month form-select">' +
                '<option value="">Select Month</option>' +
                '<option value="1">January</option>' +
                '<option value="2">February</option>' +
                '<option value="3">March</option>' +
                '<option value="4">April</option>' +
                '<option value="5">May</option>' +
                '<option value="6">June</option>' +
                '<option value="7">July</option>' +
                '<option value="8">August</option>' +
                '<option value="9">September</option>' +
                '<option value="10">October</option>' +
                '<option value="11">November</option>' +
                '<option value="12">December</option>' +
                '</select>'
            );

            $(".select_month").on("change", function(event) {
                var date = calendar.getDate();
                var year = date.getFullYear();
                calendar.gotoDate(new Date(year, this.value - 1));
                @this.set('date', calendar.getDate());
            });

            window.sidebarOpen = (val) => setTimeout(() => calendar.updateSize(), 300);

            window.closeDetail = () => {
                @this.set('viewDetail', false);
                setTimeout(() => calendar.updateSize(), 300);
            };

            window.deleteEvent = (title, id) => {
                Swal.fire({
                    title: 'Do you want delete ' + title + '?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.destroyDetail(id);
                        @this.closeDetail();
                        setTimeout(() => calendar.updateSize(), 300);
                    }
                })
            };

        });
    });
</script>
@endpush --}}

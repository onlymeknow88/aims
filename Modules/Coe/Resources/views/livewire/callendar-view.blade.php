<div class="inner-content" x-data="{ viewDetail: @entangle('viewDetail'), detailData: @entangle('detail') }">

    <div class="section-content">

        <div class="calendar-wrapper p-3">
            <div class="row">
                <div class="col" wire:ignore>
                    <div id="calendar-coe" class="calendar-coe"></div>
                </div>

                <div class="col-3 pt-1" x-show="viewDetail">

                    <div class="detail-event d-flex flex-column gap-4">

                        @if ($detail)

                            <div class="header-detail d-flex justify-content-between align-items-center border-bottom">

                                <div class="detail-title">
                                    <h6 class="mb-0">Detail Event</h6>
                                </div>

                                <div class="detail-actions d-flex gap-2">
                                    @if ($detail->is_deletable)
                                        <a href="#" class="btn btn-light" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"><img
                                                src="{{ asset('/images/icons/menu.png') }}" alt=""></a>
                                        <ul class="dropdown-menu border-0 shadow">
                                            @can('COE - Edit COE')
                                                <li><a class="dropdown-item"
                                                        href="{{ route('coe::edit-event', $detail->id) }}">Edit</a></li>
                                            @endcan
                                            @can('COE - Delete COE')
                                                <li><a class="dropdown-item"
                                                    {{-- href="#" @click.prevent="deleteEvent(detailData.title)" --}}
                                                    wire:click="delete('{{ $detail->id }}')">Delete</a></li>
                                            @endcan

                                        </ul>
                                    @endif

                                    <button type="button" class="btn btn-light" @click.prevent="closeDetail()"><img
                                            src="{{ asset('/images/icons/delete.png') }}" alt=""></button>
                                </div>

                                {{-- <div class="detail-actions">
                                    @if ($detail->is_deletable)
                                        <a href="{{ route('coe::edit-event', $detail->id) }}" class="btn btn-light"><img
                                                src="{{ asset('/images/icons/pencil.png') }}" alt=""></a>
                                        @can('COE - Delete COE')
                                            <button type="button" class="btn btn-light"
                                                wire:click="delete('{{ $detail->id }}')">
                                                <img src="{{ asset('/images/icons/trash.png') }}" alt="Icon Delete">
                                            </button>
                                        @endcan
                                    @endif
                                    <button type="button" class="btn btn-light" @click.prevent="closeDetail()">
                                        <img src="{{ asset('/images/icons/delete.png') }}" alt="">
                                    </button>
                                </div> --}}

                            </div>
                            <!--/.header-detail-->

                            <div class="detail-items review-document">
                                <div class="item-label">{{ $detail->title }}</div><!-- /.item-label -->
                                <div class="item-content d-flex gap-2 flex-wrap align-items-center">
                                    <span>{{ $detail->frequency }}</span>
                                    <span class="dots"></span>
                                    <span>
                                        @if ($detail->start_date == $detail->end_date)
                                            {{ $detail->start_date->format('d F Y') }}
                                        @else
                                            {{ $detail->start_date->format('d/m/Y') }} -
                                            {{ $detail->end_date->format('d/m/Y') }}
                                        @endif
                                    </span>
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .review-document-->

                            {{-- <div class="detail-items persone">
                                <div class="item-label">Person in Charge</div><!-- /.item-label -->
                                <div class="item-content">
                                    <div class="department-name">{{ $detail->section->department->name }}</div>
                                    <div class="section-name">{{ $detail->section->name }}</div>
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .persone--> --}}

                            <div class="detail-items invited">
                                <div class="item-label">Invited</div><!-- /.item-label -->
                                <div class="item-content d-flex gap-2 flex-wrap">
                                    @if ($detail->invited_emails)
                                        @foreach ($detail->invited_emails as $item)
                                            <div class="email-detail">{{ $item }}</div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .invited-->

                            <div class="detail-items description">
                                <div class="item-label">Attachment</div><!-- /.item-label -->
                                <div class="item-content">
                                    <div class="desc-content">
                                        @if ($detail->attachment)
                                            <small><a href="{{ route('coe::attachment', $detail->id) }}"
                                                    target="_blank">{!! $detail->attachment !!}</a></small>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .description-->

                            <div class="detail-items description">
                                <div class="item-label">Description</div><!-- /.item-label -->
                                <div class="item-content">
                                    <div class="desc-content">
                                        {!! $detail->description !!}
                                    </div>
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .description-->

                            <div class="detail-items event-status">
                                <div class="item-label">Event Status ?</div><!-- /.item-label -->
                                <div class="item-content">
                                    <div class="event-status">

                                        <button type="button"
                                            wire:click="changeStatus('{{ $detail->id }}', '{{ App\Enums\COE\COEStatus::Pending }}')"
                                            class="badge bg-pending
                                            @if ($detail->status === App\Enums\COE\COEStatus::Pending) active @endif">
                                            Pending
                                        </button>

                                        <button type="button"
                                            wire:click="changeStatus('{{ $detail->id }}', '{{ App\Enums\COE\COEStatus::Done }}')"
                                            class="badge bg-done @if ($detail->status === App\Enums\COE\COEStatus::Done) active @endif">Done
                                        </button>

                                        <button type="button"
                                            wire:click="changeStatus('{{ $detail->id }}', '{{ App\Enums\COE\COEStatus::Canceled }}')"
                                            class="badge bg-cancel
                                            @if ($detail->status === App\Enums\COE\COEStatus::Canceled) active @endif">
                                            Cancel
                                        </button>

                                    </div>
                                </div><!-- /.item-content -->
                            </div><!-- /.detail-items .event-status-->
                        @endIf

                    </div><!-- .detail-event -->

                </div><!-- viewDetail -->

            </div>

        </div><!-- /.calendar-wrapper -->

    </div><!-- /.section-content -->

    <!-- Modal -->
    <div class="modal fade modal-lg" id="modalImportCoe" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="import">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel">Import Excel</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Excel File <small style="color: green;">(Fomat
                                    xlsx/xls)</small></label>
                            <input class="form-control form-control-sm @error('excelFile') is-invalid @enderror"
                                wire:model.debounce.500ms="excelFile" type="file">
                            @error('excelFile')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-sm alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between" wire:ignore>
                        <button type="submit" class="btn btn-outline-success">Import</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" />
        <!--<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>-->
    @endpush
@endonce

{{-- @push('styles')
    <style>
        .calendar-coe.fc .fc-event{
            background-color: #ffffff !important;
            border: 1px solid rgba(75, 131, 216, 1) !important;
            font-weight: 700;
            border-left-width: 3px !important;
            border-radius: 3px !important;
        }
        .calendar-coe.fc .fc-event.pending{
            border-color: rgba(245, 133, 0, 1) !important;
            background-color: #ffffff !important;
        }
        .calendar-coe.fc .fc-event.cancel{
            border-color: rgba(255, 0, 61, 1) !important;
            background-color: #ffffff !important;
        }
        .calendar-coe.fc .fc-event.done{
            background-color: #ffffff !important;
            border-color: rgba(0, 125, 64, 1) !important;
            color: rgba(0, 125, 64, 1) !important;
        }
    </style>
@endpush --}}

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
                    dayMaxEventRows: true, // allow "more" link when too many events
                    views: {
                        timeGrid: {
                            eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
                        },
                        week: {
                            // options apply to dayGridWeek and timeGridWeek views
                        }
                    },
                    moreLinkContent: function(args) {
                        return args.num + ' Lainnya';
                    },
                    events: event,
                    headerToolbar: {
                        start: 'prev,next title',
                        center: 'dayGridMonth,listWeek',
                        end: 'countEvent,addNew,import,export'
                    },

                    eventClick: function(info) {
                        Alpine.store('isSidebar').setSidebar(false);

                        Livewire.emit('openDetail', info.event.id);
                        setTimeout(() => calendar.updateSize(), 300)
                    },
                    customButtons: {
                        //  countEvent: {
                        //      text: '{{ $count_event }} Running Event',
                        //  },

                        import: {
                            text: 'Import',
                            click: function() {
                                @can('COE - Import Data')
                                    $("#modalImportCoe").modal('show');
                                    //  @this.import();
                                @endcan
                            }
                        },

                        addNew: {
                            text: 'Add New',
                            click: function() {
                                window.location.href = "{{ route('coe::add-event') }}"
                            }
                        },


                        export: {
                            text: 'Export',
                            click: function() {
                                @can('COE - Export Data')
                                    @this.export();
                                @endcan
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

                //reset calendar size
                window.sidebarOpen();
                window.closeDetail = () => {
                    @this.closeDetail();
                    //setTimeout(() => calendar.updateSize(), 300);
                    //updateSize(300);
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

                window.changeStatus = (id, type) => {
                    var eventEl = calendar.getEventById(id);
                    var classnames = eventEl.classNames;
                    // classNames Object
                    var classNames_obj = eventEl.classNames;
                    //
                    // Transform into array
                    var classNames_arr = Object.values(classNames_obj);

                    var indexT = classNames_arr.indexOf(type);
                    if (indexT !== -1) {
                        classNames_arr.splice(indexT, 1);
                    } else {
                        // remove property cancel, done, pending
                        var indexDOne = classNames_arr.indexOf('done');
                        if (indexDOne !== -1) {
                            classNames_arr.splice(indexDOne, 1);
                        }
                        var indexC = classNames_arr.indexOf('cancel');
                        if (indexC !== -1) {
                            classNames_arr.splice(indexC, 1);
                        }
                        var indexP = classNames_arr.indexOf('pending');
                        if (indexP !== -1) {
                            classNames_arr.splice(indexP, 1);
                        }
                        //append
                        classNames_arr.push(type);
                    }

                    // Update fullcalendar event object
                    eventEl.setProp('classNames', classNames_arr);
                    @this.setStatus(type);

                };

                Alpine.effect(() => {
                    const count = Alpine.store('isSidebar').open;
                    if (count) {
                        updateSize(300);
                    } else {
                        updateSize(300);
                    }
                })

                function updateSize(delay) {
                    setTimeout(() => calendar.updateSize(), delay)
                }

            });
        });
    </script>
@endpush

{{-- {{ dd($this->events) }} --}}
<div>
    <div class="container-fluid fixed-top bg-white shadow-sm">

        <div class="row collapse show d-flex align-items-center justify-content-between h-60px position-relative"
            {{-- style="margin-bottom: 1.5em;" --}}>
            <!-- Start Toggle -->
            <div class="col-3 d-flex align-items-center gap-2">
                <a @click.prevent="$store.isSidebar.toggle()" href="#" role="button"
                    class="text-white toggle-sidebar">
                    <img src="{{ asset('images/icons/layout-sidebar.svg') }}" alt="open sidebar">
                </a>
                <span class="logo">AIMS - Calendar Of Event</span>
            </div>
            <!-- end Toggle -->

            <!-- Start Search -->
            <div class="col">
                {{-- @livewire('header.header-search') --}}
            </div>
            <!-- end Search -->

            <div class="col-3 justify-content-end">
                @if(Auth::guard('web')->check() || Auth::guard('dashboard')->check())
                    <div class="profile-menu d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('coe::dashboard') }}" class="btn btn-success bg-green btn-sm d-flex align-items-center gap-1" style="font-weight: 600; border-radius: 8px;">
                            <i class="fa-solid fa-gauge"></i> Dashboard
                        </a>
                        <div class="d-flex align-items-center gap-3 text-decoration-none position-relative">
                            @php
                                $user = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();
                            @endphp
                            <span class="profile-text text-dark">{{ ucfirst($user->name) }}</span>
                            <span class="profile-image">
                                <span class="text-profile">{{ preg_filter('/[^A-Z]/', '', ucfirst($user->name)) ?: substr(ucfirst($user->name), 0, 1) }}</span>
                            </span>
                        </div>
                    </div>
                @else
                    <div class="profile-menu d-flex justify-content-end align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-success bg-green btn-sm d-flex align-items-center gap-1" style="font-weight: 600; border-radius: 8px;">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </a>
                    </div>
                @endif
            </div>
            <!-- end Profile -->

        </div>
    </div><!-- /.container-fluid -->

    <div class="inner-content" x-data="{ viewDetail: @entangle('viewDetail'), detailData: @entangle('detail') }" x-init="$watch('isSidebar', (value) => sidebarOpen(value))">

        <div class="section-content">

            <div
                class="header-content-coe-home h-100px bg-white d-flex gap-2 align-items-center justify-content-between px-3">
                {{-- <div class="left-header">
                    <a class="d-flex align-items-center gap-3">
                        <h3 class="fs-5 mb-3"><i class="fa fa-calendar"></i></h3>
                        <h3 class="fs-5 mb-3">Calendar Of Event</h3>
                    </a>
                </div><!-- /.left-header -->
                <div class="right-header">
                    <div class="mb-3 d-grid">
                        <a href="{{ route('login') }}" class="btn btn-success bg-green">Login</a>
                    </div>
                </div><!-- /.right-header --> --}}
            </div>

            <div class="calendar-wrapper p-3">
                <div class="row">
                    <div class="col" wire:ignore>
                        <div id="calendar-coe" class="calendar-coe"></div>
                    </div>

                    <div class="col-3 pt-1" x-show="viewDetail">

                        <div class="detail-event d-flex flex-column gap-4">

                            @if ($detail)

                                <div class="header-detail d-flex justify-content-between align-items-center">

                                    <div class="detail-title">
                                        <h6 class="mb-0">Detail Event</h6>
                                    </div>

                                    <div class="detail-actions">
                                        {{-- close --}}
                                        <button type="button" class="btn btn-light" @click.prevent="closeDetail()">
                                            <img src="{{ asset('/images/icons/delete.png') }}" alt="">
                                        </button>
                                    </div>

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
                                        @foreach ($detail->invited_emails as $item)
                                            <div class="email-detail">{{ $item }}</div>
                                        @endforeach
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

                                            @if ($detail->status === App\Enums\COE\COEStatus::Pending)
                                                <button type="button" class="badge bg-pending active">
                                                    Pending
                                                </button>
                                            @elseif ($detail->status === App\Enums\COE\COEStatus::Done)
                                                <button type="button" class="badge bg-done active">Done
                                                </button>
                                            @elseif ($detail->status === App\Enums\COE\COEStatus::Canceled)
                                                <button type="button" class="badge bg-cancel active">
                                                    Cancel
                                                </button>
                                            @endif




                                        </div>
                                    </div><!-- /.item-content -->
                                </div><!-- /.detail-items .event-status-->
                            @endIf

                        </div><!-- .detail-event -->

                    </div><!-- viewDetail -->

                </div>

            </div><!-- /.calendar-wrapper -->

        </div><!-- /.section-content -->

    </div>
</div>

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
                        end: 'countEvent'
                    },
                    eventClick: function(info) {
                        Livewire.emit('openDetail', info.event.id);
                        setTimeout(() => calendar.updateSize(), 300)
                    },
                    customButtons: {
                        countEvent: {
                            text: '',
                            // text: '{{ $count_event }} Running Event',
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
@endpush

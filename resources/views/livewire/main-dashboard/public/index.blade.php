@push('styles')
<style>
/* Fix background image spilling when content is empty */
.dashboard-wrapper {
    background-image: none !important;
    background-color: #F2F3F8 !important;
}

/* Custom premium UI enhancements for AIMS Dashboard */
.inner-dashboard {
    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

/* Modern Glassmorphic Dashboard Navbar */
.dashboard-nav {
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border: 1px solid rgba(255, 255, 255, 0.4) !important;
    border-radius: 16px !important;
    padding: 0.8rem 1.5rem !important;
    margin-bottom: 1.5rem !important;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05) !important;
    align-items: center;
    transition: all 0.3s ease;
    position: relative !important;
    z-index: 1050 !important;
}

.dashboard-nav:hover {
    box-shadow: 0 6px 24px -2px rgba(0, 0, 0, 0.08) !important;
}

.toggle-sidebar-btn:hover {
    background-color: #f1f5f9 !important;
    transform: scale(1.05);
}

.dashboard-title {
    font-weight: 700 !important;
    font-size: 1.25rem !important;
    color: #0f172a !important; /* Dark Slate instead of secondary */
    letter-spacing: -0.02em;
    vertical-align: middle;
}

/* Metric Cards Styling */
.card-top .card {
    background: #ffffff !important;
    border: 1px solid rgba(241, 245, 249, 0.8) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative;
    overflow: hidden;
}

.card-top .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #10b981, #059669);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-top .card:hover::before {
    opacity: 1;
}

.card-top .card:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03) !important;
}

/* Metric Card Title */
.card-top .card .title {
    font-size: 0.85rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    color: #64748b !important; /* Cool grey */
    font-weight: 700 !important;
    margin-bottom: 0.75rem !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
}

.card-top .card .title i {
    font-size: 1rem !important;
    color: #10b981 !important;
}

/* Metric Values */
.card-top .card .text {
    color: #0f172a !important;
    font-size: 1.75rem !important;
    font-weight: 800 !important;
    letter-spacing: -0.03em !important;
}

.card-top .card .sub-text {
    color: #94a3b8 !important;
    font-size: 0.8rem !important;
    font-weight: 500 !important;
}

/* Custom styles for general section widgets */
.widget-title {
    font-size: 1.15rem !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    border-bottom: 2px solid #10b981 !important;
    padding-bottom: 0.5rem !important;
    margin-bottom: 1rem !important;
    display: inline-block !important;
}

/* Standardize other card widgets */
.inner-dashboard .card.rounded-4 {
    border-radius: 16px !important;
    border: 1px solid rgba(241, 245, 249, 0.8) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01) !important;
    transition: all 0.3s ease !important;
}

.inner-dashboard .card.rounded-4:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
}

/* Clean caret styling for values */
.card-top .card .icon {
    margin-right: 0.25rem !important;
    vertical-align: middle !important;
}

.card-top .card .icon i {
    font-size: 1.25rem !important;
}
</style>
@endpush

<div id="app" class="inner-dashboard pb-1 m-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="row dashboard-nav d-flex align-items-center py-2 px-3">
                <div class="col-8 d-flex align-items-center">
                    <a href="#" class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center me-2 toggle-sidebar-btn" onclick="openNavLeft()" style="width: 40px; height: 40px; border: 1px solid rgba(0,0,0,0.05); transition: all 0.2s ease;">
                        <img src="{{ asset('images/icons/layout-sidebar.svg') }}" alt="open sidebar" style="width: 20px; height: 20px;">
                    </a>
                    <a href="#" class="dashboard-title text-decoration-none">Dashboard </a>
                </div>
                <div class="col-4 right d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center gap-3">

                        <div class="logo d-flex align-items-center">
                            <img src="{{ asset('./images/Alamtri Geo Logo - Full Color.png') }}" alt="logo" height="45px" style="object-fit: contain; display: block;" />
                        </div>
                        @if (Auth::guard('web')->check() || Auth::guard('dashboard')->check())
                            @php
                                $userObj = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();
                                $initials = '';
                                if ($userObj) {
                                    $words = explode(' ', $userObj->name);
                                    $initials = strtoupper(
                                        substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''),
                                    );
                                }
                            @endphp
                            <div class="dropdown" id="userProfileDropdown" style="position: relative;">
                                <a href="javascript:void(0)" onclick="toggleDropdownMenu(event)"
                                    class="d-flex align-items-center gap-2 text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center text-white fw-bold rounded-circle"
                                        style="width: 38px; height: 38px; background: linear-gradient(135deg, #059669, #10b981); font-size: 0.9rem; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                                        {{ $initials }}
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-secondary fs-8"
                                        style="font-size: 0.75rem;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3"
                                    id="userDropdownMenu"
                                    style="display: none; position: absolute; right: 0; top: 100%; z-index: 1000; min-width: 240px; border-radius: 12px; margin-top: 10px; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05) !important;">
                                    <div class="d-flex flex-column mb-2">
                                        <span class="fw-semibold text-dark fs-6"
                                            style="line-height: 1.2;">{{ $userObj->name }}</span>
                                        <span class="text-muted mt-1"
                                            style="font-size: 0.8rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $userObj->email }}</span>
                                    </div>
                                    <hr class="my-2" style="border-top: 1px solid #e2e8f0; opacity: 0.15;">
                                    <a href="{{ route('dashboard-setting') }}"
                                        class="dropdown-item py-2 px-2 rounded d-flex align-items-center gap-2 text-dark"
                                        style="font-weight: 600; font-size: 0.9rem; transition: background-color 0.2s; text-decoration: none;">
                                        <i class="fa-solid fa-gauge" style="width: 16px;"></i> Admin Panel
                                    </a>
                                    <a href="{{ route('profile.2fa') }}"
                                        class="dropdown-item py-2 px-2 rounded d-flex align-items-center gap-2 text-dark"
                                        style="font-weight: 600; font-size: 0.9rem; transition: background-color 0.2s; text-decoration: none;">
                                        <i class="fa-solid fa-shield-halved" style="width: 16px;"></i> Otentikasi 2FA
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form-header"
                                        class="d-none">
                                        @csrf
                                    </form>
                                    <a href="javascript:void(0)"
                                        onclick="document.getElementById('logout-form-header').submit();"
                                        class="dropdown-item py-2 px-2 rounded d-flex align-items-center gap-2 text-danger"
                                        style="font-weight: 600; font-size: 0.9rem; transition: background-color 0.2s; text-decoration: none;">
                                        <i class="fa-solid fa-right-from-bracket" style="width: 16px;"></i> Logout
                                    </a>
                                </div>
                            </div>
                            <script>
                                function toggleDropdownMenu(e) {
                                    e.stopPropagation();
                                    var menu = document.getElementById('userDropdownMenu');
                                    if (menu.style.display === 'none' || menu.style.display === '') {
                                        menu.style.display = 'block';
                                    } else {
                                        menu.style.display = 'none';
                                    }
                                }
                                window.addEventListener('click', function(e) {
                                    var dropdown = document.getElementById('userProfileDropdown');
                                    var menu = document.getElementById('userDropdownMenu');
                                    if (dropdown && menu && !dropdown.contains(e.target)) {
                                        menu.style.display = 'none';
                                    }
                                });
                            </script>
                        @else
                            <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}';"
                                class="btn btn-success btn-sm d-flex align-items-center justify-content-center gap-2"
                                style="background-color: #063D56; border: none; font-weight: 600; border-radius: 8px; padding: 0 1rem; font-size: 0.85rem; color: #fff; text-decoration: none; height: 38px; display: inline-flex !important; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-right-to-bracket"></i> Login
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="pb-3 card-top">

                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="row justify-content-sm-center">
                            <div class="col-sm-6 col-lg-3 p-2">
                                <div class="card rounded-4">
                                    <div class="card-body p-3 d-flex flex-column align-items-start">
                                        <div class="title"><i class="fa-solid fa-calendar-check"></i> Project to Date</div>
                                        <div class="d-flex align-items-baseline gap-1 mt-1">
                                            @if ($general)
                                                @if ($general->project_to_date_mark == 'UP')
                                                    <span class="icon text-success"><i
                                                            class="fa-solid fa-caret-up"></i></span>
                                                @elseif ($general->project_to_date_mark == 'DOWN')
                                                    <span class="icon text-danger"><i
                                                            class="fa-solid fa-caret-down"></i></span>
                                                @endif

                                                <span
                                                    class="text fw-semibold fs-3 ">{{ $general->project_to_date }}</span>
                                                <span class="sub-text">/ Day</span>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.content-top -->
                            </div><!-- /.col -->

                            <div class="col-sm-6 col-lg-3  p-2">
                                <div class="card rounded-4">
                                    <div class="card-body p-3 d-flex flex-column align-items-start">
                                        <div class="title"><i class="fa-solid fa-clock"></i> Manhours</div>
                                        <div class="d-flex align-items-baseline gap-1 mt-1">
                                            @if ($general)
                                                @if ($general->manhours_mark == 'UP')
                                                    <span class="icon text-success"><i
                                                            class="fa-solid fa-caret-up"></i>
                                                    </span>
                                                @elseif ($general->manhours_mark == 'DOWN')
                                                    <span class="icon text-danger"><i
                                                            class="fa-solid fa-caret-down"></i>
                                                    </span>
                                                @endif
                                                <span class="text  fw-semibold fs-3">{{ $general->manhours }}</span>
                                                <span class="sub-text ">Hours</span>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.content-top -->
                            </div><!-- /.col -->

                            <div class="col-sm-6 col-lg-3  p-2">
                                <div class="card rounded-4">
                                    <div class="card-body p-3 d-flex flex-column align-items-start">
                                        <div class="title"><i class="fa-solid fa-shield-halved"></i> Day After Last LTI</div>
                                        <div class="d-flex align-items-baseline gap-1 mt-1">
                                            @if ($general)

                                                @if ($general->day_after_last_lti_mark == 'UP')
                                                    <span class="icon text-success"><i
                                                            class="fa-solid fa-caret-up"></i>
                                                    </span>
                                                @elseif ($general->day_after_last_lti_mark == 'DOWN')
                                                    <span class="icon text-danger"><i
                                                            class="fa-solid fa-caret-down"></i>
                                                    </span>
                                                @endif

                                                <span
                                                    class="text fw-semibold fs-3">{{ $general->day_after_last_lti }}</span>
                                                <span class="sub-text">Day</span>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.content-top -->
                            </div><!-- /.col -->

                            <div class="col-sm-6 col-lg-3  p-2">
                                <div class="card rounded-4">
                                    <div class="card-body p-3 d-flex flex-column align-items-start">
                                        <div class="title"><i class="fa-solid fa-users"></i> Manpower</div>
                                        <div class="d-flex align-items-baseline gap-1 mt-1">
                                            @if ($general)

                                                @if ($general->manpower_mark == 'UP')
                                                    <span class="icon text-success"><i
                                                            class="fa-solid fa-caret-up"></i>
                                                    </span>
                                                @elseif ($general->manpower_mark == 'DOWN')
                                                    <span class="icon text-danger"><i
                                                            class="fa-solid fa-caret-down"></i>
                                                    </span>
                                                @endif
                                                <span class="text fw-semibold fs-3">{{ $general->manpower }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.content-top -->
                            </div><!-- /.col -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.col -->
            </div><!-- /.dashboard-top -->

            <div class="dashboard-main mb-3">
                <div class="row">
                    @if (setting('widget_video_slide') !== 'false')
                        <div class="col-lg-12 col-xl-8 mb-3">
                            @livewire('main-dashboard.public.widgets.video-slide')
                        </div>
                    @endif

                    @if (setting('widget_calendar_of_event_list') !== 'false')
                        <div class="col-lg-12 col-xl-4 mb-3">
                            @livewire('main-dashboard.public.widgets.calendar-of-event-list', ['result' => $dataCoe])
                        </div>
                    @endif
                </div>
            </div><!-- /.dashboard-main -->

            <div class="row production">

                @if (setting('widget_production_ytd_chart') !== 'false')
                    <div class="col-lg-12 col-xxl-6 mb-3 p-2">
                        @livewire('main-dashboard.public.widgets.production-ytd-chart', ['result' => $dataProduction])
                    </div>
                @endif

                @if (setting('widget_production_mtd') !== 'false')
                    <div class="col-lg-12 col-xxl-6 mb-3 p-2">
                        @livewire('main-dashboard.public.widgets.production-mtd', ['result' => $dataProduction])
                    </div>
                @endif

            </div>

            <div class="row dashboard-sih">
                @if (setting('widget_safety_performance_chart') !== 'false')
                    <div class="col-lg-12 col-xl-4 col-xxl-5 mb-3 p-2">
                        @livewire('main-dashboard.public.widgets.safety-performance-chart')
                    </div>
                @endif

                @if (setting('widget_image_banner') !== 'false')
                    <div class="col-lg-12 col-xl-4 col-xxl-3 mb-3 p-2">
                        @livewire('main-dashboard.public.widgets.image-banner')
                    </div>
                @endif

                @if (setting('widget_health_performance_chart') !== 'false')
                    <div class="col-lg-12 col-xl-4 col-xxl-4 mb-3 p-2">
                        <div class="content-items">
                            @livewire('main-dashboard.public.widgets.health-performance-chart')
                        </div>
                    </div>
                @endif
            </div>

            <div class="row coe-project mb-3">
                @if (setting('widget_calendar') !== 'false')
                    <div class="col-md-12 col-lg-6 mb-3">
                        @livewire('main-dashboard.public.widgets.calendar')
                    </div>
                @endif
                @if (setting('widget_strategic_project') !== 'false')
                    <div class="col-md-12 col-lg-6 mb-3">
                        @livewire('main-dashboard.public.widgets.strategic-project')
                    </div>
                @endif
            </div>

            <div class="row dashboard-penghargaan-news">
                @if (setting('widget_news_update') !== 'false')
                    <div class="col-lg-12 col-xl-8 mb-3 p-2">
                        <div class="card rounded-4">
                            <div class="card-body ">
                                @livewire('main-dashboard.public.widgets.news-update')
                            </div>
                        </div>
                    </div>
                @endif

                @if (setting('widget_penghargaan_k3lh') !== 'false')
                    <div class="col-lg-12 col-xl-4 mb-3 p-2">
                        <div class="card rounded-4">
                            <div class="card-body">
                                @livewire('main-dashboard.public.widgets.penghargaan-k3lh')
                            </div>
                        </div>
                    </div>
                @endif
            </div>


            <div class="row dashboard-notif-kegiatan">
                @if (setting('widget_incident_notification') !== 'false')
                    <div class="col-lg-12 col-xl-6 col-xxl-4 mb-3 p-2">
                        <div class="card rounded-4">
                            <div class="card-body">
                                @livewire('main-dashboard.public.widgets.incident-notification')
                            </div>
                        </div>
                    </div>
                @endif

                @if (setting('widget_kegiatan_k3lh') !== 'false')
                    <div class="col-lg-12 col-xl-6 col-xxl-8 mb-3 p-2">
                        <div class="card rounded-4">
                            <div class="card-body">
                                @livewire('main-dashboard.public.widgets.kegiatan-k3lh')
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row dashboard-ssa">
                @if (setting('widget_safety_accountability_program') !== 'false')
                    <div class="col-lg-12 col-xl-6 mb-3 p-2">
                        {{-- category --}}
                        @livewire('main-dashboard.public.widgets.safety-accountability-program', ['result' => $dataSapYtdHor])
                    </div>
                @endif

                @if (setting('widget_achievement_sap') !== 'false')
                    <div class="col-lg-12 col-xl-6 mb-3 p-2">
                        @livewire('main-dashboard.public.widgets.achievement-sap', ['result' => $dataSapYtdDept])
                    </div>
                @endif
            </div>

            @if (setting('widget_sap_ytd') !== 'false')
                <div class="sap-ytd mb-3">
                    @livewire('main-dashboard.public.widgets.sap-ytd', ['result' => $dataSapYtdVer, 'category' => $dataSapYtdHor])
                </div>
            @endif

        </div>
    </div><!-- /.col main content -->

    <div class="col-lg-3 col-md-12 sidebar-right d-none">
        @livewire('main-dashboard.public.widgets.filter')
        @livewire('main-dashboard.public.sidebar.sidebar-right')
        @livewire('main-dashboard.public.widgets.penghargaan-k3lh')
        @livewire('main-dashboard.public.widgets.calendar')
        @livewire('main-dashboard.public.widgets.strategic-project')
    </div><!-- /.col sidebar -->

    @php
        //lokasi widget 'main-dashboard.public.widgets.xxx'
        $dataChar = [
            ['name' => 'Calendar Of Event', 'widget' => 'coe', 'data' => $dataCoe],
            ['name' => 'Document System', 'widget' => 'ds', 'data' => $dataDs],
            ['name' => 'Safety Accountability Program', 'widget' => 'sap', 'data' => $dataSap],
            ['name' => 'Field Leadership', 'widget' => 'fls', 'data' => $dataFi],
            ['name' => 'Inspection', 'widget' => 'inspection', 'data' => $dataKplh],
            ['name' => 'Audit', 'widget' => 'audit', 'data' => $dataAudit],
            ['name' => 'Management Resiko', 'widget' => 'mr', 'data' => $dataIbprAndBowtie],
            ['name' => 'Safety Operation', 'widget' => 'ko', 'data' => $dataKo],
            ['name' => 'Compliance Regulation', 'widget' => 'cr', 'data' => $dataKpp],
            ['name' => 'Medical Check Up', 'widget' => 'mcu', 'data' => $dataMcu],
            ['name' => 'Contractor Safety Management System', 'widget' => 'csms', 'data' => $dataCsms],
        ];
    @endphp

    @foreach ($dataChar as $list)
        @if (setting('widget_' . $list['widget']) !== 'false')
            <div class="p-2 mt-5 list-item-category {{ $list['widget'] }}">
                <div class="card-body">
                    <div class="widget-title">
                        {{ $list['name'] }}
                    </div>

                    <div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4 p-2">
                                <div class="card rounded-4 summary-class">
                                    @livewire('main-dashboard.public.widgets.' . $list['widget'] . '.summary', ['result' => $list['data']])
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-8 p-2">
                                <div class="card rounded-4  detail-class">
                                    @livewire('main-dashboard.public.widgets.' . $list['widget'] . '.detail', ['result' => $list['data']])
                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-lg-6 col-xl-4 p-2">
                                <div class="card rounded-4 dougnut-class">
                                    @livewire('main-dashboard.public.widgets.' . $list['widget'] . '.dougnut', ['result' => $list['data']])
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 col-xl-4 p-2">
                                <div class="card rounded-4 chart-class">
                                    @livewire('main-dashboard.public.widgets.' . $list['widget'] . '.chart', ['result' => $list['data']])
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-4 p-2">
                                <div class="card rounded-4 progress-class">
                                    @livewire('main-dashboard.public.widgets.' . $list['widget'] . '.progress', ['result' => $list['data']])
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endforeach

    @include('livewire.main-dashboard.public.components.popup')
</div><!-- /.inner-dashboard -->

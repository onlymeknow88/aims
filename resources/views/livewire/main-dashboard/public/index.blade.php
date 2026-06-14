<div id="app" class="inner-dashboard pb-1 m-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="row dashboard-nav">
                <div class="col-8">
                    <a href="#" class="" onclick="openNavLeft()"><img
                            src="{{ asset('images/icons/layout-sidebar.svg') }}" alt="open sidebar"></a>
                    <a href="#" class="text-secondary dashboard-title">Dashboard </a>
                </div>
                <div class="col-4 right d-flex justify-content-end align-items-center gap-3">
                    <div class="logo">
                        <img src="{{ asset('./images/logo-login.png') }}" alt="logo" height="50px" />
                    </div>
                    @if(Auth::guard('web')->check() || Auth::guard('dashboard')->check())
                        @php
                            $userObj = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();
                            $initials = '';
                            if ($userObj) {
                                $words = explode(' ', $userObj->name);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            }
                        @endphp
                        <div class="dropdown" id="userProfileDropdown" style="position: relative;">
                            <a href="javascript:void(0)" onclick="toggleDropdownMenu(event)"
                                class="d-flex align-items-center gap-2 text-decoration-none">
                                <div class="d-flex align-items-center justify-content-center text-white fw-bold rounded-circle"
                                    style="width: 38px; height: 38px; background: linear-gradient(135deg, #059669, #10b981); font-size: 0.9rem; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                                    {{ $initials }}
                                </div>
                                <i class="fa-solid fa-chevron-down text-secondary fs-8" style="font-size: 0.75rem;"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-3" id="userDropdownMenu"
                                style="display: none; position: absolute; right: 0; top: 100%; z-index: 1000; min-width: 240px; border-radius: 12px; margin-top: 10px; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05) !important;">
                                <div class="d-flex flex-column mb-2">
                                    <span class="fw-semibold text-dark fs-6"
                                        style="line-height: 1.2;">{{ $userObj->name }}</span>
                                    <span class="text-muted mt-1"
                                        style="font-size: 0.8rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $userObj->email }}</span>
                                </div>
                                {{--
                                <hr class="my-2" style="border-top: 1px solid #e2e8f0; opacity: 0.15;">
                                <a href="javascript:void(0)"
                                    class="dropdown-item py-2 px-2 rounded d-flex align-items-center gap-2 text-dark"
                                    style="font-size: 0.9rem; font-weight: 500; transition: background-color 0.2s;">
                                    <i class="fa-regular fa-user text-secondary" style="width: 16px;"></i> Profile
                                </a> --}}
                                <hr class="my-2" style="border-top: 1px solid #e2e8f0; opacity: 0.15;">
                                <form action="{{ route('logout') }}" method="POST" id="logout-form-header" class="d-none">
                                    @csrf
                                </form>
                                <a href="javascript:void(0)"
                                    onclick="document.getElementById('logout-form-header').submit();"
                                    class="dropdown-item py-2 px-2 rounded d-flex align-items-center gap-2 text-danger"
                                    style="font-weight: 600; font-size: 0.9rem; transition: background-color 0.2s;">
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
                            window.addEventListener('click', function (e) {
                                var dropdown = document.getElementById('userProfileDropdown');
                                var menu = document.getElementById('userDropdownMenu');
                                if (dropdown && menu && !dropdown.contains(e.target)) {
                                    menu.style.display = 'none';
                                }
                            });
                        </script>
                    @else
                        <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}';"
                            class="btn btn-success btn-sm d-flex align-items-center gap-1"
                            style="background-color: #059669; border: none; font-weight: 600; border-radius: 8px; padding: 0.4rem 0.8rem; font-size: 0.85rem; color: #fff; text-decoration: none;">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </a>
                    @endif
                </div>
            </div>
            <div class="pb-3 card-top">

                <div class="row">
                    <div class="col-sm-12 ">
                        <div class="row justify-content-sm-center">
                            <div class="col-sm-6 col-lg-3 p-2">
                                <div class="card rounded-4">
                                    <div class="flex-center card-body p-2">
                                        <div class="title">Project to Date</div>
                                        <div>
                                            @if ($general)
                                                @if ($general->project_to_date_mark == 'UP')
                                                    <span class="icon text-success"><i
                                                            class="fa-solid fa-caret-up fa-2x"></i></span>
                                                @elseif ($general->project_to_date_mark == 'DOWN')
                                                    <span class="icon text-danger"><i
                                                            class="fa-solid fa-caret-down fa-2x"></i></span>
                                                @endif

                                                <span class="text fw-semibold fs-3 ">{{ $general->project_to_date }}</span>
                                                <span class="sub-text">/ Day</span>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.content-top -->
                            </div><!-- /.col -->

                            <div class="col-sm-6 col-lg-3  p-2">
                                <div class="card rounded-4">
                                    <div class="flex-center card-body p-2">
                                        <div class="title">Manhours</div>
                                        <div>
                                            @if ($general)
                                                @if ($general->manhours_mark == 'UP')
                                                    <span class="icon text-success"><i class="fa-solid fa-caret-up fa-2x"></i>
                                                    </span>
                                                @elseif ($general->manhours_mark == 'DOWN')
                                                    <span class="icon text-danger"><i class="fa-solid fa-caret-down fa-2x"></i>
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
                                    <div class="flex-center card-body p-2">
                                        <div class="title">Day After Last LTI</div>
                                        <div>
                                            @if ($general)

                                                @if ($general->day_after_last_lti_mark == 'UP')
                                                    <span class="icon text-success"><i class="fa-solid fa-caret-up fa-2x"></i>
                                                    </span>
                                                @elseif ($general->day_after_last_lti_mark == 'DOWN')
                                                    <span class="icon text-danger"><i class="fa-solid fa-caret-down fa-2x"></i>
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
                                    <div class="flex-center card-body p-2">
                                        <div class="title">Manpower</div>
                                        <div>
                                            @if ($general)

                                                @if ($general->manpower_mark == 'UP')
                                                    <span class="icon text-success"><i class="fa-solid fa-caret-up fa-2x"></i>
                                                    </span>
                                                @elseif ($general->manpower_mark == 'DOWN')
                                                    <span class="icon text-danger"><i class="fa-solid fa-caret-down fa-2x"></i>
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
                    <div class="col-lg-12 col-xl-8 mb-3">
                        @livewire('main-dashboard.public.widgets.video-slide')
                    </div>

                    <div class="col-lg-12 col-xl-4 mb-3">
                        @livewire('main-dashboard.public.widgets.calendar-of-event-list', ['result' => $dataCoe])
                    </div>
                </div>
            </div><!-- /.dashboard-main -->

            <div class="row production">

                <div class="col-lg-12 col-xxl-6 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.production-ytd-chart', ['result' => $dataProduction])
                </div>

                <div class="col-lg-12 col-xxl-6 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.production-mtd', ['result' => $dataProduction])
                </div>

            </div>

            <div class="row dashboard-sih">
                <div class="col-lg-12 col-xl-4 col-xxl-5 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.safety-performance-chart')
                </div>

                <div class="col-lg-12 col-xl-4 col-xxl-3 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.image-banner')
                </div>

                <div class="col-lg-12 col-xl-4 col-xxl-4 mb-3 p-2">
                    <div class="content-items">
                        @livewire('main-dashboard.public.widgets.health-performance-chart')
                    </div>
                </div>
            </div>

            <div class="row coe-project mb-3">
                <div class="col-md-12 col-lg-6 mb-3">
                    @livewire('main-dashboard.public.widgets.calendar')
                </div>
                <div class="col-md-12 col-lg-6 mb-3">
                    @livewire('main-dashboard.public.widgets.strategic-project')
                </div>
            </div>

            <div class="row dashboard-penghargaan-news">
                <div class="col-lg-12 col-xl-8 mb-3 p-2">
                    <div class="card rounded-4">
                        <div class="card-body ">
                            @livewire('main-dashboard.public.widgets.news-update')
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-xl-4 mb-3 p-2">
                    <div class="card rounded-4">
                        <div class="card-body">
                            @livewire('main-dashboard.public.widgets.penghargaan-k3lh')
                        </div>
                    </div>
                </div>
            </div>


            <div class="row dashboard-notif-kegiatan">
                <div class="col-lg-12 col-xl-6 col-xxl-4 mb-3 p-2">
                    <div class="card rounded-4">
                        <div class="card-body">
                            @livewire('main-dashboard.public.widgets.incident-notification')
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-xl-6 col-xxl-8 mb-3 p-2">
                    <div class="card rounded-4">
                        <div class="card-body">
                            @livewire('main-dashboard.public.widgets.kegiatan-k3lh')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row dashboard-ssa">
                <div class="col-lg-12 col-xl-6 mb-3 p-2">
                    {{-- category --}}
                    @livewire('main-dashboard.public.widgets.safety-accountability-program', ['result' => $dataSapYtdHor])
                </div>

                {{-- <div class="col-lg-12 col-xl-4 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.sap-ytd', ['result' => $dataSapYtdVer])

                </div> --}}

                <div class="col-lg-12 col-xl-6 mb-3 p-2">
                    @livewire('main-dashboard.public.widgets.achievement-sap', ['result' => $dataSapYtdDept])
                </div>
            </div>

            <div class="sap-ytd mb-3">
                @livewire('main-dashboard.public.widgets.sap-ytd', ['result' => $dataSapYtdVer, 'category' => $dataSapYtdHor])
            </div>

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
        $dataChar = [['name' => 'Calendar Of Event', 'widget' => 'coe', 'data' => $dataCoe], ['name' => 'Document System', 'widget' => 'ds', 'data' => $dataDs], ['name' => 'Safety Accountability Program', 'widget' => 'sap', 'data' => $dataSap], ['name' => 'Field Leadership', 'widget' => 'fls', 'data' => $dataFi], ['name' => 'Inspection', 'widget' => 'inspection', 'data' => $dataKplh], ['name' => 'Audit', 'widget' => 'audit', 'data' => $dataAudit], ['name' => 'Management Resiko', 'widget' => 'mr', 'data' => $dataIbprAndBowtie], ['name' => 'Safety Operation', 'widget' => 'ko', 'data' => $dataKo], ['name' => 'Compliance Regulation', 'widget' => 'cr', 'data' => $dataKpp], ['name' => 'Medical Check Up', 'widget' => 'mcu', 'data' => $dataMcu], ['name' => 'Contractor Safety Management System', 'widget' => 'csms', 'data' => $dataCsms]];
    @endphp

    @foreach ($dataChar as $list)
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
    @endforeach

    @include('livewire.main-dashboard.public.components.popup')
</div><!-- /.inner-dashboard -->

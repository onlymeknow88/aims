<div class="content-sidebar">
    <ul>

        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        @can('MCU - View Dashboard MCU')
            <li class="item-sidebar">
                <a href="{{ route('mcu::doctor') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('mcu::doctor') ? 'active' : '' }} d-flex justify-content-between align-items-center">Dashboard</a>
            </li>
        @endcan

        @can('MCU - View List MCU Medical Staff')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('mcu::medical-staff') || Request::routeIs('mcu::medical-staff-in-review') || Request::routeIs('mcu::medical-staff-reviewed') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#subSidebar" role="button" aria-expanded="false"
                    aria-controls="subSidebar">
                    List Rekam Medis
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('mcu::medical-staff') || Request::routeIs('mcu::medical-staff-in-review') || Request::routeIs('mcu::medical-staff-reviewed') ? 'show' : '' }}" id="subSidebar">
                    <li class="item-sidebar">
                        <a href="{{ route('mcu::medical-staff') }}"
                            class="link-sidebar text-decoration-none justify-content-between {{ Request::routeIs('mcu::medical-staff') ? 'active' : '' }}">Draft<span
                                class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::where('doctor_status_review', 'draft')->where('staff_id', auth()->user()->employee->id)->where('deleted_at', NULL)->get()->count() }}</span></a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{ route('mcu::medical-staff-in-review') }}"
                            class="link-sidebar text-decoration-none justify-content-between {{ Request::routeIs('mcu::medical-staff-in-review') ? 'active' : '' }}">Menunggu Review<span
                                class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::whereNull('doctor_certificate_number')->where('doctor_status_review', '!=', 'draft')->where('staff_id', auth()->user()->employee->id)->where('deleted_at', NULL)->get()->count() }}</span></a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{ route('mcu::medical-staff-reviewed') }}"
                            class="link-sidebar text-decoration-none justify-content-between {{ Request::routeIs('mcu::medical-staff-reviewed') ? 'active' : '' }}">Sudah Review<span
                                class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::whereNotNull('doctor_certificate_number')->where('staff_id', auth()->user()->employee->id)->where('deleted_at', NULL)->get()->count() }}</span></a>
                                {{-- class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::where('doctor_status_review', '!=', 'draft')->where('doctor_status_review', '!=', 'In Review')->where('staff_id', auth()->user()->employee->id)->where('deleted_at', NULL)->get()->count() }}</span></a> --}}
                    </li>
                </ul>
            </li>
        @endcan

        @can('MCU - Manage Formula MCU')
            <li class="item-sidebar">
                <a href="{{ route('mcu::manage-formula') }}" class="link-sidebar text-decoration-none {{ Request::routeIs('mcu::manage-formula') ? 'active' : '' }}">Pengaturan
                    Formula</a>
            </li>
        @endcan

        @can('MCU - Manage Provider MCU')
            <li class="item-sidebar">
                <a href="{{ route('mcu::manage-provider') }}" class="link-sidebar text-decoration-none {{ Request::routeIs('mcu::manage-provider') ? 'active' : '' }}">Master Data
                    Provider</a>
            </li>
        @endcan

        @can('MCU - View List MCU Doctor')
            <li class="item-sidebar">
                <a href="{{ route('mcu::doctor-list') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('mcu::doctor-list') ? 'active' : '' }}">Review
                    Dokter <span
                        class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::whereNull('doctor_certificate_number')->where('doctor_status_review', '!=', 'draft')->get()->count() }}</span></a>
                        {{-- class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::where('doctor_status_review', 'In Review')->get()->count() }}</span></a> --}}
            </li>
        @endcan

    </ul>
</div><!-- /.content-sidebar -->

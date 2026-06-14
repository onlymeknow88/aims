<div class="content-sidebar">
    <ul>
        @if (Session::get('login_email') == 'staff1@gmail.com')
            <li class="item-sidebar">
                <a href="{{ route('mcu::medical-staff') }}" class="link-sidebar text-decoration-none active">Dashboard</a>
            </li>
            <li class="item-sidebar">
                <a href="{{ route('mcu::medical-staff-list') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">List
                    Rekam Medis<span
                        class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::whereNull('doctor_status_review')->get()->count() }}</span></a>
            </li>
            <li class="item-sidebar">
                <a href="{{ route('mcu::formula-settings') }}" class="link-sidebar text-decoration-none">Pengaturan
                    Formula</a>
            </li>
            <li class="item-sidebar">
                <a href="{{ route('mcu::master-data') }}" class="link-sidebar text-decoration-none">Master Data</a>
            </li>
        @elseif (Session::get('login_email') == 'karyawan1@gmail.com')
            <li class="item-sidebar">
                <a href="{{ route('mcu::patient') }}" class="link-sidebar text-decoration-none active">List Rekam
                    Medis</a>
            </li>
        @elseif (Session::get('login_email') == 'doctor1@gmail.com')
            <li class="item-sidebar">
                <a href="{{ route('mcu::doctor') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Dashboard</a>
            </li>
            <li class="item-sidebar">
                <a href="{{ route('mcu::doctor-list') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">List
                    Rekam
                    Medis <span
                        class="badge rounded-pill bg-danger pull-right">{{ App\Models\Mcu\MedicalHistory::whereNull('doctor_status_review')->get()->count() }}</span></a>
            </li>
        @elseif (Session::get('login_email') == 'company1@gmail.com')
            <li class="item-sidebar">
                <a href="{{ route('mcu::company') }}" class="link-sidebar text-decoration-none">List Rekam
                    Medis</a>
            </li>
        @endif

        {{-- <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Pengaturan Formula <span class="badge rounded-pill bg-danger">10</span></a>
        </li> --}}

        {{-- <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Draft</a>
        </li>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Recycle</a>
        </li> --}}
    </ul>
</div><!-- /.content-sidebar -->

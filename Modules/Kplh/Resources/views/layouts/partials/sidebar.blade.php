<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        @can('KPLH - View Dashboard')
            <li class="item-sidebar">
                <a href="{{ route('kplh::dashboard') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('kplh::dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
        @endcan

        <li class="item-sidebar">
            <a href="{{ route('kplh::lists') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('kplh::lists') ? 'active' : '' }} d-flex justify-content-between align-items-center">Inspeksi
                KPLH
                <span
                    class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')
                    // ->where('maker_id', Auth::user()->id)
                    ->count() }}</span>
            </a>
        </li>

        {{-- @can('KPLH - View List Food Hygiene')
            <li class="item-sidebar">
                <a href="{{ route('kplh::list-food-hygiene') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi Food
                    Hygiene
                    <span
                        class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')->where('inspect_criteria', 'food-hygiene')->where('maker_id', Auth::user()->id)->count() }}</span>
                </a>
            </li>
        @endcan

        @can('KPLH - View List Workplace')
            <li class="item-sidebar">
                <a href="{{ route('kplh::list-workplace') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi
                    Tempat Kerja Mingguan
                    <span
                        class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')->where('inspect_criteria', 'workplace')->where('maker_id', Auth::user()->id)->count() }}</span>
                </a>
            </li>
        @endcan

        @can('KPLH - View List K3')
            <li class="item-sidebar">
                <a href="{{ route('kplh::list-k3') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi K3
                    <span
                        class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')->whereIn('inspect_criteria', ['k3-apar', 'k3-apab', 'k3-hydrant', 'k3-hose-rail', 'k3-eye-wash'])->where('maker_id', Auth::user()->id)->count() }}</span>
                </a>
            </li>
        @endcan

        @can('KPLH - View List Area Maintank')
            <li class="item-sidebar">
                <a href="{{ route('kplh::list-area-maintank') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi
                    Area
                    Maintank<span
                        class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')->where('inspect_criteria', 'area-maintank')->where('maker_id', Auth::user()->id)->count() }}</span>
                </a>
            </li>
        @endcan

        @can('KPLH - View List Area Jetty')
            <li class="item-sidebar">
                <a href="{{ route('kplh::list-area-jetty') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi
                    Area
                    Jetty<span
                        class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'draft')->where('inspect_criteria', 'area-jetty')->where('maker_id', Auth::user()->id)->count() }}</span>
                </a>
            </li>
        @endcan --}}

        @can('KPLH - Approval')
            @if (auth()->user()->areaManager)
                <li class="item-sidebar">
                    <a href="{{ route('kplh::approval') }}"
                        class="link-sidebar text-decoration-none {{ Request::routeIs('kplh::approval') ? 'active' : '' }} d-flex justify-content-between align-items-center">Menunggu
                        Persetujuan PJA
                        <span
                            class="badge rounded-pill bg-danger pull-right">{{ Modules\Kplh\Entities\KplhLabel::where('status', 'active')
                            // ->where('pja_id', auth()->user()->areaManager->id)
                            ->count() }}</span>
                    </a>
                    </a>
                </li>
            @endif
        @endcan

    </ul>
</div><!-- /.content-sidebar -->

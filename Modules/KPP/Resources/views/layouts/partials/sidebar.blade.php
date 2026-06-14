<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('kpp::dashboard') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::dashboard') ? 'active' : '' }}">Dashboard</a>
        </li>
        @can('KPP - Master Library')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('kpp::master-library*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#subSidebarMaster" role="button" aria-expanded="false"
                    aria-controls="subSidebarMaster">
                    Master Library
                </a>
                <ul class="collapse sub-menu {{ request()->routeIs('kpp::master-library*') ? 'show' : '' }}" id="subSidebarMaster">
                    <li class="item-sidebar">
                        <a href="{{ route('kpp::master-library.agency-authority.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::master-library.agency-authority.index') ? 'active' : '' }}">Otoritas Instansi</a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{ route('kpp::master-library.type.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::master-library.type.index') ? 'active' : '' }}">Jenis Peraturan</a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('KPP - View Peraturan')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('kpp::rules*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KppHelper)->draftRuleTotal() > 0 ? 'is-notif' : '' }}"
                    data-bs-toggle="collapse" href="#subRule" role="button" aria-expanded="false"
                    aria-controls="subSidebarMaster">
                    Peraturan
                </a>
                <ul class="collapse sub-menu {{ request()->routeIs('kpp::rules*') ? 'show' : '' }}" id="subRule">
                    <li class="item-sidebar">
                        <a href="{{ route('kpp::rules.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::rules.index') ? 'active' : '' }}">Daftar Peraturan</a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{route('kpp::rules.draft')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::rules.draft') ? 'active' : '' }}">
                            Draft
                            @if((new \App\Helpers\KppHelper)->draftRuleTotal() > 0)
                                <span class="badge rounded-pill bg-danger pull-right">
                                    {{ (new \App\Helpers\KppHelper)->draftRuleTotal() }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{ route('kpp::rules.obsolete') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::rules.obsolete') ? 'active' : '' }}">Obsolete</a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('KPP - Approve Kepatuhan')
            <li class="item-sidebar">
                <a href="{{route('kpp::requests.index')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::requests.index') ? 'active' : '' }}">
                    Request Kepatuhan
                    @if((new \App\Helpers\KppHelper)->obedienceRequestTotal() > 0)
                        <span class="badge rounded-pill bg-danger pull-right">
                            {{ (new \App\Helpers\KppHelper)->obedienceRequestTotal() }}
                        </span>
                    @endif
                </a>
            </li>
        @endcan

        <li class="item-sidebar">
            <a href="{{route('kpp::obediences.index')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::obediences.index') ? 'active' : '' }}">
                Kepatuhan
            </a>
        </li>

        @if(auth()->user()->hasAnyPermission(['KPP - Monitoring Ekstraksi']) || Auth::user()->department->company->type == 'CONTRACTOR')
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('kpp::obedience-monitoring*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#obedienceMonitoring" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Monitoring Kepatuhan
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('kpp::obedience-monitoring*') ? 'show' : '' }}" id="obedienceMonitoring">
                @can('KPP - Monitoring Ekstraksi')
                <li class="item-sidebar">
                    <a href="{{route('kpp::obedience-monitoring.internal')}}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::obedience-monitoring.internal') ? 'active' : '' }}">CCOW</a>
                </li>
                @endcan
                @can('KPP - Monitoring Ekstraksi')
                <li class="item-sidebar">
                    <a href="{{route('kpp::obedience-monitoring.contractor')}}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::obedience-monitoring.contractor') ? 'active' : '' }}">Contractor</a>
                </li>
                @endcan
                @if(auth()->user()->hasAnyPermission(['KPP - Monitoring Ekstraksi']) || Auth::user()->department->company->type == 'CONTRACTOR')
                <li class="item-sidebar">
                    <a href="{{route('kpp::obedience-monitoring.subcontractor')}}" class="link-sidebar text-decoration-none {{ request()->routeIs('kpp::obedience-monitoring.subcontractor') ? 'active' : '' }}">SubContractor</a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        <li class="item-sidebar">
            <a href="{{route('kpp::extractions.index')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::extractions.index') ? 'active' : '' }}">
                Ekstraksi
            </a>
        </li>

        @can('KPP - PJA/PJO')
            <li class="item-sidebar">
                <a href="{{route('kpp::extractions.checking')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::extractions.checking') ? 'active' : '' }}">
                    Review PJA/PJO
                    @if((new \App\Helpers\KppHelper)->extractionTotal('Checking') > 0)
                        <span class="badge rounded-pill bg-danger pull-right">
                            {{ (new \App\Helpers\KppHelper)->extractionTotal('Checking') }}
                        </span>
                    @endif
                </a>
            </li>
        @endcan

        @can('KPP - Reviewer')
            <li class="item-sidebar">
                <a href="{{route('kpp::extractions.in-review')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::extractions.in-review') ? 'active' : '' }}">
                    Review Evaluator
                    @if((new \App\Helpers\KppHelper)->extractionTotal('InReview') > 0)
                        <span class="badge rounded-pill bg-danger pull-right">
                            {{ (new \App\Helpers\KppHelper)->extractionTotal('InReview') }}
                        </span>
                    @endif
                </a>
            </li>
        @endcan

        @can('KPP - PICA')
            <li class="item-sidebar">
                <a href="{{route('kpp::pica.index')}}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('kpp::pica.index') ? 'active' : '' }}">
                    PICA
                    @if((new \App\Helpers\KppHelper)->picaTotal() > 0)
                        <span class="badge rounded-pill bg-danger pull-right">
                            {{ (new \App\Helpers\KppHelper)->picaTotal() }}
                        </span>
                    @endif
                </a>
            </li>
        @endcan
    </ul>
</div><!-- /.content-sidebar -->

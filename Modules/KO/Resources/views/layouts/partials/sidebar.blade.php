<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('ko::dashboard') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::dashboard') ? 'active' : '' }}">Dashboard</a>
        </li>

        @can('KO - Master Library')
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::master-library*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#master-library" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Master Library
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::master-library*') ? 'show' : '' }}" id="master-library">
                <li class="item-sidebar">
                    <a href="{{ route('ko::master-library.spip-category.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::master-library.spip-category.index') ? 'active' : '' }}">Spip Category</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::master-library.spip-type.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::master-library.spip-type.index') ? 'active' : '' }}">Spip Type</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::master-library.spip-unit.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::master-library.spip-unit.index') ? 'active' : '' }}">Spip Unit</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::master-library.unit.index') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::master-library.unit.index') ? 'active' : '' }}">Unit</a>
                </li>
            </ul>
        </li>
        @endcan

        @if(auth()->user()->hasAnyPermission(['KO - Admin Revoke Unit Verification','KO - Coordinator Revoke Unit Verification']))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::revoke-request*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->revokeRequestTotal('AdminVerification') + (new \App\Helpers\KoHelper)->revokeRequestTotal('CoordinatorVerification') > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#revoke-request" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Unit Demob Request
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::revoke-request*') ? 'show' : '' }}" id="revoke-request">
                @can('KO - Admin Revoke Unit Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::revoke-request.admin') }}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::revoke-request.admin') ? 'active' : '' }}">
                        Admin
                        @if((new \App\Helpers\KoHelper)->revokeRequestTotal('AdminVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->revokeRequestTotal('AdminVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Coordinator Revoke Unit Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::revoke-request.coordinator') }}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::revoke-request.coordinator') ? 'active' : '' }}">
                        Coordinator
                        @if((new \App\Helpers\KoHelper)->revokeRequestTotal('CoordinatorVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->revokeRequestTotal('CoordinatorVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::ko*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->draftTotal() + (new \App\Helpers\KoHelper)->returnedTotal() > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#ko" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Proposal KO
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::ko*') ? 'show' : '' }}" id="ko">
                <li class="item-sidebar {{ request()->routeIs('ko::ko.index') ? 'active' : '' }}">
                    <a href="{{ route('ko::ko.index') }}"
                        class="link-sidebar text-decoration-none">Daftar KO</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::ko.draft') }}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::ko.draft') ? 'active' : '' }}">
                        Draft
                        @if((new \App\Helpers\KoHelper)->draftTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->draftTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::ko.returned') }}" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::ko.returned') ? 'active' : '' }}">
                        Returned
                        @if((new \App\Helpers\KoHelper)->returnedTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->returnedTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        @if(auth()->user()->hasAnyPermission(['KO - Admin Proposal Verification','KO - Coordinator Proposal Verification']))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::proposal-verification*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->adminVerificationTotal() + (new \App\Helpers\KoHelper)->coordinatorVerificationTotal() > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#proposalVerification" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Verifikasi Proposal
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::proposal-verification*') ? 'show' : '' }}" id="proposalVerification">
                @can('KO - Admin Proposal Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::proposal-verification.admin-verification.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::proposal-verification.admin-verification.index') ? 'active' : '' }}">
                        Admin
                        @if((new \App\Helpers\KoHelper)->adminVerificationTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->adminVerificationTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Coordinator Proposal Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::proposal-verification.coordinator-verification.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::proposal-verification.coordinator-verification.index') ? 'active' : '' }}">
                        Coordinator
                        @if((new \App\Helpers\KoHelper)->coordinatorVerificationTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->coordinatorVerificationTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::commissioning*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->commissioningTotal() + (new \App\Helpers\KoHelper)->proposalTotal('CommissioningReturned') > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#com" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Komisioning
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::commissioning*') ? 'show' : '' }}" id="com">
                @can('KO - Create Commissioning')
                <li class="item-sidebar">
                    <a href="{{ route('ko::commissioning.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::commissioning.index') ? 'active' : '' }}">
                        In Progress Komisioning
                        @if((new \App\Helpers\KoHelper)->commissioningTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->commissioningTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('ko::commissioning.returned') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::commissioning.returned') ? 'active' : '' }}">
                        Returned Komisioning
                        @if((new \App\Helpers\KoHelper)->proposalTotal('CommissioningReturned') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->proposalTotal('CommissioningReturned') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                <li class="item-sidebar">
                    <a href="{{ route('ko::commissioning.commissioned') }}"
                        class="link-sidebar text-decoration-none {{ request()->routeIs('ko::commissioning.commissioned') ? 'active' : '' }}">Daftar Komisioning</a>
                </li>
            </ul>
        </li>

        @if(auth()->user()->hasAnyPermission(['KO - Admin Commissioning Verification','KO - Coordinator Commissioning Verification']))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::commissioning-verification*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->proposalTotal('CommissionerCommissioningVerification') + (new \App\Helpers\KoHelper)->proposalTotal('CoordinatorCommissioningVerification') > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#commissioningVerification" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Verifikasi Komisioning
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::commissioning-verification*') ? 'show' : '' }}" id="commissioningVerification">
                @can('KO - Admin Commissioning Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::commissioning-verification.admin.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::commissioning-verification.admin.index') ? 'active' : '' }}">
                        Commissioner
                        @if((new \App\Helpers\KoHelper)->proposalTotal('CommissionerCommissioningVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->proposalTotal('CommissionerCommissioningVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Coordinator Commissioning Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::commissioning-verification.coordinator.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::commissioning-verification.coordinator.index') ? 'active' : '' }}">
                        Coordinator
                        @if((new \App\Helpers\KoHelper)->proposalTotal('CoordinatorCommissioningVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->proposalTotal('CoordinatorCommissioningVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasAnyPermission(['KO - Request Temporary QR','KO - QR Request Verification','KO - Print Temporary QR']))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::request-qr*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->qrRequestTotal() > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#qrRequest" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Request QR Sementara
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::request-qr*') ? 'show' : '' }}" id="qrRequest">
                @can('KO - Request Temporary QR')
                <li class="item-sidebar">
                    <a href="{{ route('ko::request-qr.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::request-qr.index') ? 'active' : '' }}">
                        Request QR Sementara
                    </a>
                </li>
                @endcan
                @can('KO - QR Request Verification')
                <li class="item-sidebar">
                    <a href="{{ route('ko::request-qr.coordinator-verification') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::request-qr.coordinator-verification') ? 'active' : '' }}">
                        Coordinator Verification
                        @if((new \App\Helpers\KoHelper)->qrRequestTotal() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->qrRequestTotal() }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Print Temporary QR')
                <li class="item-sidebar">
                    <a href="{{ route('ko::request-qr.approved') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::request-qr.approved') ? 'active' : '' }}">
                        Print QR Sementara
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif

        @if(auth()->user()->hasAnyPermission(['KO - Open PICA','KO - Admin PICA','KO - Coordinator PICA','KO - Solved PICA']))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ request()->routeIs('ko::issue-report*') ? '' : 'collapsed' }} {{ (new \App\Helpers\KoHelper)->reportIssueTotal('Open') + (new \App\Helpers\KoHelper)->reportIssueTotal('Returned') + (new \App\Helpers\KoHelper)->reportIssueTotal('AdminVerification') + (new \App\Helpers\KoHelper)->reportIssueTotal('CoordinatorVerification') > 0 ? 'is-notif' : '' }}"
                data-bs-toggle="collapse" href="#pica" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                PICA
            </a>
            <ul class="collapse sub-menu {{ request()->routeIs('ko::issue-report*') ? 'show' : '' }}" id="pica">
                @can('KO - Open PICA')
                <li class="item-sidebar">
                    <a href="{{ route('ko::issue-report.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::issue-report.index') ? 'active' : '' }}">
                        Open
                        @if((new \App\Helpers\KoHelper)->reportIssueTotal('Open') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->reportIssueTotal('Open') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Open PICA')
                <li class="item-sidebar">
                    <a href="{{ route('ko::issue-report.returned') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::issue-report.returned') ? 'active' : '' }}">
                        Returned
                        @if((new \App\Helpers\KoHelper)->reportIssueTotal('Returned') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->reportIssueTotal('Returned') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Admin PICA')
                <li class="item-sidebar">
                    <a href="{{ route('ko::issue-report.admin-verification') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::issue-report.admin-verification') ? 'active' : '' }}">
                        Commissioner Verification
                        @if((new \App\Helpers\KoHelper)->reportIssueTotal('AdminVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->reportIssueTotal('AdminVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Coordinator PICA')
                <li class="item-sidebar">
                    <a href="{{ route('ko::issue-report.coordinator-verification') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::issue-report.coordinator-verification') ? 'active' : '' }}">
                        Coordinator Verification
                        @if((new \App\Helpers\KoHelper)->reportIssueTotal('CoordinatorVerification') > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\KoHelper)->reportIssueTotal('CoordinatorVerification') }}
                            </span>
                        @endif
                    </a>
                </li>
                @endcan
                @can('KO - Solved PICA')
                <li class="item-sidebar">
                    <a href="{{ route('ko::issue-report.solved') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ request()->routeIs('ko::issue-report.solved') ? 'active' : '' }}">
                        Solved
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif



        @can('KO - Print QR')
        <li class="item-sidebar">
            <a href="{{ route('ko::ko.completed') }}" class="link-sidebar text-decoration-none {{ request()->routeIs('ko::ko.completed') ? 'active' : '' }}">Completed KO</a>
        </li>
        @endcan

    </ul>
</div><!-- /.content-sidebar -->

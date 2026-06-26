<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}" class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('field-leadership::dashboard') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('field-leadership::dashboard') ? 'active' : '' }}">Dashboard</a>
        </li>
        @if (auth()->user()->can('Field Leadsership - View Active') || auth()->user()->can('Field Leadsership - View Draft') || auth()->user()->hasRole('Field Leadership - Super Admin', 'field-leadership'))
            <li class="item-sidebar">
                <a href="{{ route('field-leadership::listing.active.index') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('field-leadership::listing.active.*') ? 'active' : '' }}">
                    Field Leadership
                </a>
                {{-- <ul class="collapse sub-menu {{ Request::routeIs('field-leadership::listing.active.*') || Request::routeIs('field-leadership::listing.draft.*') ? 'show' : '' }}"
                    id="subSidebar">
                    @can('Field Leadsership - View Active')
                        <li class="item-sidebar">
                            <a href="{{ route('field-leadership::listing.active.index') }}"
                                class="link-sidebar text-decoration-none {{ Request::routeIs('field-leadership::listing.active.index') ? 'active' : '' }}">Active</a>
                        </li>
                    @endcan
                    @can('Field Leadsership - View Draft')
                        <li class="item-sidebar">
                            <a href="{{ route('field-leadership::listing.draft.index') }}"
                                class="link-sidebar text-decoration-none {{ Request::routeIs('field-leadership::listing.draft.index') ? 'active' : '' }}">Draft</a>
                        </li>
                    @endcan
                </ul> --}}
            </li>
        @endif
        @if (auth()->user()->can('Field Leadsership - View Request Review For PJA') ||
                auth()->user()->can('Field Leadsership - View Draft For PJA'))
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown @if ((new \App\Helpers\FieldLeadershipHelper())->totalRequestPjaPublished() > 0) is-notif @endif {{ Request::routeIs('field-leadership::listing.request-review-pja.*') || Request::routeIs('field-leadership::listing.draft.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#subSidebar1" role="button" aria-expanded="false"
                    aria-controls="subSidebar1">
                    Penanggung Jawab Area
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('field-leadership::listing.request-review-pja.*') || Request::routeIs('field-leadership::listing.draft.*') ? 'show' : '' }}"
                    id="subSidebar1">
                    @can('Field Leadsership - View Request Review For PJA')
                        <li class="item-sidebar">
                            <a href="{{ route('field-leadership::listing.request-review-pja.index') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('field-leadership::listing.request-review-pja.index') ? 'active' : '' }}">
                                Request Review
                                @if ((new \App\Helpers\FieldLeadershipHelper())->totalRequestPjaPublished() > 0)
                                    <span class="badge rounded-pill bg-danger pull-right">
                                        {{ (new \App\Helpers\FieldLeadershipHelper())->totalRequestPjaPublished() }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endcan
                    @can('Field Leadsership - View Draft For PJA')
                        <li class="item-sidebar">
                            <a href="{{ route('field-leadership::listing.request-review-pja.draft') }}"
                                class="link-sidebar text-decoration-none  d-flex justify-content-between align-items-center {{ Request::routeIs('field-leadership::listing.draft.index') ? 'active' : '' }}">
                                Draft
                                @if ((new \App\Helpers\FieldLeadershipHelper())->totalRequestPjaDrafted() > 0)
                                    <span class="badge rounded-pill bg-danger pull-right">
                                        {{ (new \App\Helpers\FieldLeadershipHelper())->totalRequestPjaDrafted() }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
        @if (auth()->user()->can('Field Leadsership - View Request Review For Approval') || auth()->user()->hasRole('Field Leadership - Super Admin', 'field-leadership'))
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center"
                    href="{{ route('field-leadership::listing.request-review-reviewer.index') }}" role="button">
                    Approval PJA
                    @if ((new \App\Helpers\FieldLeadershipHelper())->totalRequestApproval() > 0)
                        <span class="badge rounded-pill bg-danger pull-right">
                            {{ (new \App\Helpers\FieldLeadershipHelper())->totalRequestApproval() }}
                        </span>
                    @endif
                </a>
            </li>
        @endif
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subSidebarMaster" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Master Library
            </a>
            <ul class="collapse sub-menu" id="subSidebarMaster">
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.limit-parameter.index') }}"
                        class="link-sidebar text-decoration-none">Limit Parameter</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.type-kta-tta.index') }}"
                        class="link-sidebar text-decoration-none">Jenis KTA/TTA</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.potency-consequence.index') }}"
                        class="link-sidebar text-decoration-none">Potensi Konsekuensi</a>
                </li>
                {{-- <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.category.index') }}"
                        class="link-sidebar text-decoration-none">Kategori</a>
                </li> --}}
            </ul>
        </li>
    </ul>
</div><!-- /.content-sidebar -->

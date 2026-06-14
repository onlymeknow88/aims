<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('csms::dashboard') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('csms::dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown @if ((new \App\Helpers\CsmsHelper())->totalRequestBidding() > 0) is-notif @endif {{ Request::routeIs('csms::bidding.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebarBidding" role="button" aria-expanded="false"
                aria-controls="subSidebarBidding">
                Bidding
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::bidding.*') ? 'show' : '' }}"
                id="subSidebarBidding">
                <li class="item-sidebar">
                    <a href="{{ route('csms::bidding.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::bidding.index') ? 'active' : '' }}">
                        Active
                        @if ((new \App\Helpers\CsmsHelper())->totalActiveBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalActiveBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::bidding.ongoing') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::bidding.ongoing') ? 'active' : '' }}">
                        On Going
                        @if ((new \App\Helpers\CsmsHelper())->totalOnGoingBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalOnGoingBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::bidding.draft') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::bidding.draft') ? 'active' : '' }}">
                        Draft
                        @if ((new \App\Helpers\CsmsHelper())->totalDraftBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalDraftBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown @if ((new \App\Helpers\CsmsHelper())->totalRequestPostBidding() > 0) is-notif @endif {{ Request::routeIs('csms::post-bidding.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebarPostBidding" role="button" aria-expanded="false"
                aria-controls="subSidebarPostBidding">
                Post Bidding
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::post-bidding.*') ? 'show' : '' }}"
                id="subSidebarPostBidding">
                <li class="item-sidebar">
                    <a href="{{ route('csms::post-bidding.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::post-bidding.index') ? 'active' : '' }}">
                        Active
                        @if ((new \App\Helpers\CsmsHelper())->totalActivePostBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalActivePostBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::post-bidding.inactive') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::post-bidding.inactive') ? 'active' : '' }}">
                        Inactive
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::post-bidding.ongoing') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::post-bidding.ongoing') ? 'active' : '' }}">
                        On Going
                        @if ((new \App\Helpers\CsmsHelper())->totalOnGoingPostBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalOnGoingPostBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::post-bidding.draft') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::post-bidding.draft') ? 'active' : '' }}">
                        Draft
                        @if ((new \App\Helpers\CsmsHelper())->totalDraftPostBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalDraftPostBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::post-bidding.obsolate') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::post-bidding.obsolate') ? 'active' : '' }}">
                        Obsolate
                    </a>
                </li>
            </ul>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('csms::renewal.index') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('csms::renewal.index') ? 'active' : '' }}">
                Renewal
            </a>
        </li>

        {{--
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('csms::renewal.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebarRenewal" role="button" aria-expanded="false"
                aria-controls="subSidebarRenewal">
                Renewal
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::renewal.*') ? 'show' : '' }}"
                id="subSidebarRenewal">
                <li class="item-sidebar">
                    <a href="{{ route('csms::renewal.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::renewal.index') ? 'active' : '' }}">
                        Active
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::renewal.ongoing') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::renewal.ongoing') ? 'active' : '' }}">
                        On Going
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::renewal.draft') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::renewal.draft') ? 'active' : '' }}">
                        Draft
                    </a>
                </li>
            </ul>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('csms::inactive.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebarInactive" role="button" aria-expanded="false"
                aria-controls="subSidebarInactive">
                Inactive
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::inactive.*') ? 'show' : '' }}"
                id="subSidebarInactive">
                <li class="item-sidebar">
                    <a href="{{ route('csms::inactive.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::inactive.index') ? 'active' : '' }}">
                        Active
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::inactive.ongoing') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::inactive.ongoing') ? 'active' : '' }}">
                        On Going
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::inactive.draft') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::inactive.draft') ? 'active' : '' }}">
                        Draft
                    </a>
                </li>
            </ul>
        </li>
        --}}

        <li class="item-sidebar">
            <a href="{{ route('csms::pica') }}"
                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::pica') ? 'active' : '' }}">
                PICA CSMS
                @if ((new \App\Helpers\CsmsHelper())->totalPica() > 0)
                    <span class="badge rounded-pill bg-danger pull-right">
                        {{ (new \App\Helpers\CsmsHelper())->totalPica() }}
                    </span>
                @endif
            </a>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown @if ((new \App\Helpers\CsmsHelper())->totalRequestPJO() > 0) is-notif @endif {{ Request::routeIs('csms::pjo.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebar2" role="button" aria-expanded="false"
                aria-controls="subSidebar2">
                PJO
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::pjo.*') ? 'show' : '' }}" id="subSidebar2">
                <li class="item-sidebar">
                    <a href="{{ route('csms::pjo.index') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::pjo.index') ? 'active' : '' }}">
                        Active
                        @if ((new \App\Helpers\CsmsHelper())->totalPJOActive() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalPJOActive() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::pjo.ongoing') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::pjo.ongoing') ? 'active' : '' }}">
                        On Going
                        @if ((new \App\Helpers\CsmsHelper())->totalRequestPJO() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalRequestPJO() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::pjo.draft') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::pjo.draft') ? 'active' : '' }}">
                        Draft
                        @if ((new \App\Helpers\CsmsHelper())->totalPJODraft() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalPJODraft() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('csms::memo.index') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('csms::memo.index') ? 'active' : '' }}">
                MEMO KTT
            </a>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('csms::letter.index') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('csms::letter.index') ? 'active' : '' }}">
                Surat Edaran
            </a>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('csms::dictionary.index') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('csms::dictionary.index') ? 'active' : '' }}">
                Kamus
            </a>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('csms::approval.*') ? '' : 'collapsed' }}"
                data-bs-toggle="collapse" href="#subSidebarApproval" role="button" aria-expanded="false"
                aria-controls="subSidebarApproval">
                Approval CSMS
            </a>
            <ul class="collapse sub-menu {{ Request::routeIs('csms::approval.*') ? 'show' : '' }}"
                id="subSidebarApproval">
                <li class="item-sidebar">
                    <a href="{{ route('csms::approval.bidding') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::approval.bidding') ? 'active' : '' }}">
                        Bidding
                        @if ((new \App\Helpers\CsmsHelper())->totalApprovalBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalApprovalBidding() }}
                            </span>
                        @endif

                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('csms::approval.post-bidding') }}"
                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('csms::approval.post-bidding') ? 'active' : '' }}">
                        Post Bidding
                        @if ((new \App\Helpers\CsmsHelper())->totalApprovalPostBidding() > 0)
                            <span class="badge rounded-pill bg-danger pull-right">
                                {{ (new \App\Helpers\CsmsHelper())->totalApprovalPostBidding() }}
                            </span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</div><!-- /.content-sidebar -->

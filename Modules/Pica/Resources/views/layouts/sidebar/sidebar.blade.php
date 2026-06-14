<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('pica::dashboard') }}"
                class="link-sidebar text-decoration-none {{ Request::routeIs('pica::dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        @if (auth()->user()->can('Pica - Field Leadership View Document') ||
                auth()->user()->can('Pica - Field Leadership Approve Document'))
            <li class="item-sidebar">
                <a href="{{ route('pica::listing.active-document.index') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('pica::listing.active-document.*') ? 'active' : '' }}">
                    Active Document
                </a>
            </li>
        @endif
        @if (auth()->user()->can('Pica - Field Leadership View Document') ||
                auth()->user()->can('Pica - Field Leadership Approve Document'))
            <li class="item-sidebar">
                <a href="{{ route('pica::listing.draft-document.index') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('pica::listing.draft-document.*') ? 'active' : '' }}">
                    Draft
                </a>
            </li>
        @endif
        @if (auth()->user()->can('Pica - Field Leadership View Document') ||
                auth()->user()->can('Pica - Field Leadership Approve Document'))
            <li class="item-sidebar">
                <a href="{{ route('pica::listing.return-document.index') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('pica::listing.return-document.*') ? 'active' : '' }}">
                    Return Document
                </a>
            </li>
        @endif
        @if (auth()->user()->can('Pica - Field Leadership View Document') ||
                auth()->user()->can('Pica - Field Leadership Approve Document'))
            <li class="item-sidebar">
                <a href="{{ route('pica::listing.review-crs.index') }}"
                    class="link-sidebar text-decoration-none {{ Request::routeIs('pica::listing.review-crs.*') ? 'active' : '' }}">
                    Review CRS
                </a>
            </li>
        @endif
    </ul>
</div><!-- /.content-sidebar -->

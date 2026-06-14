@php
    $routeName = request()
        ->route()
        ->getName();

    $slug = request()->slug;
@endphp

<div class="content-sidebar" id="SidenavLeft">
    <ul>

        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>

        <li class="item-sidebar">
            <a href="{{ route('sap-home-index') }}"
                class="link-sidebar text-decoration-none  @if ($routeName == 'sap-home-index') active @endif">Dashboard</a>
        </li>


        @can('SAP - Summary')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown collapsed" data-bs-toggle="collapse" href="#subSidebar"
                    {{-- collapsed --}} role="button" aria-expanded="false" aria-controls="subSidebar">Summary</a>
                <ul class="collapse sub-menu show-" id="subSidebar"> {{-- show --}}
                    @foreach ($sidebar_left as $list)
                        @if ($list->slug)
                            <li class="item-sidebar">
                                <a href="{{ route('summary-setup-index', $list->slug) }}"
                                    class="link-sidebar text-decoration-none @if ($slug == $list->slug) active @endif">{{ $list->safety_accountability_progam }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endcan


        @can('SAP - Monthly')
            <li class="item-sidebar">
                <a href="{{ route('sap-monthly-category-index') }}"
                    class="link-sidebar text-decoration-none  @if ($routeName == 'sap-monthly-category-index') active @endif">Personal
                    Data</a>
            </li>
        @endcan

        @can('SAP - Setup')
            <li class="item-sidebar">
                <a href="{{ route('sap-setup-category-index') }}"
                    class="link-sidebar text-decoration-none  @if ($routeName == 'sap-setup-category-index') active @endif">Setup</a>
            </li>
        @endcan

    </ul>
</div><!-- /.content-sidebar -->

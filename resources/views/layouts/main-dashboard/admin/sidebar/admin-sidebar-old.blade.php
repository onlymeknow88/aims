@php
    $routeName = request()
        ->route()
        ->getName();
@endphp

<div class="content-sidebar">
    <ul>

        <li class="item-sidebar">
            <a href="/" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>

        @can('Dashboard - Slideshow')
            <li class="item-sidebar">
                <a href="{{ route('slideshow_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'slideshow_index') active @endif">Slideshow</a>
            </li>
        @endcan

        @can('Dashboard - Banner')
            <li class="item-sidebar">
                <a href="{{ route('banner_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'banner_index') active @endif">Banner</a>
            </li>
        @endcan

        @can('Dashboard - General')
            <li class="item-sidebar">
                <a href="{{ route('general_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'general_index') active @endif">General</a>
            </li>
        @endcan

        @can('Dashboard - Performance')
            <li class="item-sidebar">
                <a href="{{ route('performance_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'performance_index') active @endif">Performance</a>
            </li>
        @endcan

        @can('Dashboard - Safety Performance')
            <li class="item-sidebar">
                <a href="{{ route('safety_performance_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'safety_performance_index') active @endif">Safety
                    Performance</a>
            </li>
        @endcan

        @can('Dashboard - Penghargaan K3LH')
            <li class="item-sidebar">
                <a href="{{ route('k3lh_award_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'k3lh_award_index') active @endif">Penghargaan
                    K3LH</a>
            </li>
        @endcan

        @can('Dashboard - Kegiatan K3LH')
            <li class="item-sidebar">
                <a href="{{ route('k3lh_activities_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'k3lh_activities_index') active @endif">Kegiatan
                    K3LH</a>
            </li>
        @endcan

        @can('Dashboard - News and Update')
            <li class="item-sidebar">
                <a href="{{ route('news_and_update_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'news_and_update_index') active @endif">News And
                    Update</a>
            </li>
        @endcan

        @can('Dashboard - Incident Notification')
            <li class="item-sidebar">
                <a href="{{ route('incident_notification_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'incident_notification_index') active @endif">Incident
                    Notification</a>
            </li>
        @endcan

        @can('Dashboard - Strategi Project')
            <li class="item-sidebar">
                <a href="{{ route('strategic_project_index') }}"
                    class="link-sidebar text-decoration-none   @if ($routeName == 'strategic_project_index') active @endif">Strategic
                    Project</a>
            </li>
        @endcan

    </ul>
</div><!-- /.content-sidebar -->

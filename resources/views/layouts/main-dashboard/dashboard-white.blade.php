<x-layouts.base>
    <div id="SidenavLeft" class="sidenav-left sidebar ">
        @livewire('main-dashboard.public.sidebar.sidebar-left')
    </div>

    <div id="SidenavLeft2" class="sidenav-left-2 sidebar">
        @livewire('main-dashboard.public.sidebar.sidebar-left-filter')
    </div>

    <div id="SidebarRight" class="sidenav-right sidebar ">
        @livewire('main-dashboard.public.sidebar.sidebar-right')
    </div>

    <div class="dashboard-wrapper " x-data="">
        <div class="page-wrapper-dashboard">
            <div class="content-wrapper ">
                <div class="main-content" id="MainContent">
                    @yield('content')
                    {{-- @include('layouts.main-dashboard.dashboard-footer') --}}
                </div>
            </div>
        </div>
        @once
            @push('styles')
                <link rel="stylesheet" href="{{ asset('assets/css/main-dashboard.css') }}" />
                <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
                <style>
                    .datepicker table tr td span.active:active,
                    .datepicker table tr td span.active {
                        background-color: #00552f !important;
                        color: rgb(248, 243, 243) !important;
                    }

                    .datepicker table tr td.active:active,
                    .datepicker table tr td.active.highlighted:active,
                    .datepicker table tr td.active.active,
                    .datepicker table tr td.active.highlighted.active {
                        background-color: #00552f !important;
                        color: rgb(248, 243, 243) !important;
                    }

                    .datepicker table tr td.active:active:hover,
                    .datepicker table tr td.active.highlighted:active:hover,
                    .datepicker table tr td.active.active:hover,
                    .datepicker table tr td.active.highlighted.active:hover,
                    .datepicker table tr td.active:active:focus,
                    .datepicker table tr td.active.highlighted:active:focus,
                    .datepicker table tr td.active.active:focus,
                    .datepicker table tr td.active.highlighted.active:focus,
                    .datepicker table tr td.active:active.focus,
                    .datepicker table tr td.active.highlighted:active.focus,
                    .datepicker table tr td.active.active.focus,
                    .datepicker table tr td.active.highlighted.active.focus {

                        background-color: #00552f !important;
                        color: rgb(248, 243, 243) !important;
                    }
                </style>
            @endpush
        @endonce

        @push('scripts')
            <script defer src="{{ asset('assets/js/dashboard.min.js') }}"></script>
            <script>
                Livewire.on('filter', value => {
                    console.log(value);
                })
            </script>
        @endpush

    </div>

</x-layouts.base>

<x-layouts.base>

    <div class="dashboard-wrapper" id="dashboard-wrapper" x-data="{ isSidebar: (window.innerWidth > 600 ? true : false) }">

        <!-- header start -->
        @include('sap::layouts.header.admin-header')
        <!-- /. header end-->

        <div class="page-wrapper">

            <div class="content-wrapper">

                <div :class="isSidebar ? 'show' : 'hidden'" class="sidebar offcanvas offcanvas-start" id="sidebar"
                    data-bs-scroll="true" data-bs-backdrop="false">
                    {{--                     @include('sap::livewire.home.sidebar.sidebar-left' --}}
                    @livewire('sap::home.sidebar.sidebar-left')
                </div><!-- /.sidebar -->

                <div class="main-content" :class="isSidebar ? 'sidebar-open' : ''">
                    @hasSection('title')
                        <h5 class="text-secondary"> @yield('title')</h6>
                    @endif

                    @yield('content')
                    @include('sap::layouts.footer.footer-dashboard')

                </div> <!-- /.main-content -->

                <div>
                    @livewire('sap::home.sidebar.sidebar-right')
                </div>

            </div><!-- /.content-wrapper-->

        </div><!-- /.page-wrapper -->

        @push('scripts')
            <script defer src="{{ asset('assets/js/dashboard.min.js') }}"></script>
            <script defer src="{{ asset('assets/js/sap.js') }}"></script>
        @endpush

        @push('styles')
            <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/sap.css') }}">

            <style>
                .selected {
                    background-image: url('../../images/icons/selected.png');
                    border: none;
                }
            </style>
        @endpush


    </div><!-- /.dashboard-wrapper -->
</x-layouts.base>

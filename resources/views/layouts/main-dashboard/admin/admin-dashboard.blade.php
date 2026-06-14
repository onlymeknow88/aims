<x-layouts.base>

    <div class="dashboard-wrapper" x-data="{ isSidebar: (window.innerWidth > 768 ? true : false) }">

        <!-- header start -->
        @include('layouts.main-dashboard.admin.header.admin-header')
        <!-- /. header end-->

        <div class="page-wrapper">

            <div class="content-wrapper">

                <div :class="isSidebar ? 'show' : 'hidden'" class="sidebar offcanvas offcanvas-start" id="sidebar"
                    data-bs-scroll="true" data-bs-backdrop="false">
                    @include('layouts.main-dashboard.admin.sidebar.admin-sidebar')
                </div><!-- /.sidebar -->

                <div class="col main-content w-100" :class="isSidebar ? 'sidebar-open' : ''">

                    <div class="row justify-content-center">
                        <h5 class="col-11 text-secondary pb-2 text-center">
                            @yield('title')
                        </h5>
                    </div>

                    {{ $slot }}

                    @include('layouts.main-dashboard.admin.footer.footer-dashboard')

                </div> <!-- /.main-content -->

            </div><!-- /.content-wrapper-->

        </div><!-- /.page-wrapper -->

    </div><!-- /.dashboard-wrapper -->

    @push('styles')
        <style>
            table th,
            table td {
                white-space: unset;
                position: unset;
            }

            .container-spinner {
                position: relative;
            }

            .container-spinner>.spinner {
                position: absolute;
                top: 45%;
                left: 45%;
                width: 3rem;
                height: 3rem;
                color: #6c757d
            }

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


        <style>
            .selected {
                background-image: url('../../images/icons/selected.png');
                border: none;
            }
        </style>
    @endpush

</x-layouts.base>

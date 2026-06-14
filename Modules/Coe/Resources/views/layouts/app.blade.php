<x-coe-base>

    <!-- header start -->
    @include('coe::layouts.partials.header')
    <!-- /. header end-->

    <div class="page-wrapper">

        <div class="content-wrapper d-flex">

            <div
                :class="$store.isSidebar.open ? 'show' : 'hidden'"
                class="sidebar offcanvas offcanvas-start" id="sidebar"
                data-bs-backdrop="false"
                data-bs-scroll="true"
            >
                @include('coe::layouts.partials.sidebar')
            </div><!-- /.sidebar -->

            <div
                class="col main-content"
                :class="$store.isSidebar.open ? 'sidebar-open' : ''"
            >
                {{ $slot }}
            </div> <!-- /.main-content -->

        </div><!-- /.content-wrapper-->

    </div><!-- /.page-wrapper -->

</x-coe-base>

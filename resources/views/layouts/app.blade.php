<x-layouts.base>
    
    <!-- header start -->
    @include('layouts.header.admin-header')
    <!-- /. header end-->

    <div class="page-wrapper">

        <div class="content-wrapper d-flex">

            <div 
                :class="$store.isSidebar.open ? 'show' : 'hidden'"
                class="sidebar offcanvas offcanvas-start show" id="sidebar"
                data-bs-backdrop="false"
                data-bs-scroll="true"
            >
                @include('layouts.sidebar.admin-sidebar')
            </div><!-- /.sidebar -->

            <div 
                class="col main-content sidebar-open"
                :class="$store.isSidebar.open ? 'sidebar-open' : ''"
            >
                {{ $slot }}
            </div> <!-- /.main-content -->    

        </div><!-- /.content-wrapper-->                

    </div><!-- /.page-wrapper -->
       
</x-layouts.base>
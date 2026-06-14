<x-layouts.base>
    
    <!-- header start -->
    @include('layouts.header.admin-header')
    <!-- /. header end-->

    <div class="page-wrapper">

        <div class="content-wrapper d-flex">

            <div 
                :class="isSidebar ? 'show' : 'hidden'"
                class="sidebar offcanvas offcanvas-start" id="sidebar"
            >
                @include('layouts.sidebar.admin-sidebar')
            </div><!-- /.sidebar -->

            <div 
                class="col main-content"
                :class="isSidebar ? 'sidebar-open' : ''"
            >
                {{ $slot }}
            </div> <!-- /.main-content -->    

        </div><!-- /.content-wrapper-->                

    </div><!-- /.page-wrapper -->
       
</x-layouts.base>
<x-layouts.base>
    
    <div class="dashboard-wrapper" x-data="{isSidebar:true}">

        <!-- header start -->
        @include('layouts.main-dashboard.admin.header.admin-header')
        <!-- /. header end-->
        
        <div class="page-wrapper">

            <div class="content-wrapper">

                <div :class="isSidebar ? 'show' : 'hidden'" class="sidebar offcanvas offcanvas-start" id="sidebar" data-bs-scroll="true" data-bs-backdrop="false">
                    @include('layouts.main-dashboard.admin.sidebar.dashboard-sidebar')
                </div><!-- /.sidebar -->

                <div class="col main-content" :class="isSidebar ? 'sidebar-open' : ''">

                    @yield('content')

                    @include('layouts.main-dashboard.admin.footer.footer-dashboard')

                </div> <!-- /.main-content -->    

            </div><!-- /.content-wrapper-->                

        </div><!-- /.page-wrapper -->

    </div><!-- /.dashboard-wrapper -->
    
           
</x-layouts.base>
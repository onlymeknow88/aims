<x-layouts.base>
    
    <div class="dashboard page-wrapper pt-3 pb-5 px-5">

        <div class="container-fluid">
            @include('layouts.main-dashboard.dashboard-header')

            <div class="row">

                <div class="col-2">
                    @include('layouts.main-dashboard.dashboard-slidebar')
                </div><!-- /.col-4 -->

                <div class="col-9">

                    <div class="content-wrapper">

                        <div class="main-content">

                            @yield('content')

                        </div> <!-- /.main-content -->    
            
                    </div><!-- /.content-wrapper--> 

                </div><!-- /.col-8 -->

            </div><!-- /.row -->

        </div><!-- /.container -->                    

    </div><!-- /.page-wrapper -->

    @include('layouts.main-dashboard.dashboard-footer')
       
</x-layouts.base>
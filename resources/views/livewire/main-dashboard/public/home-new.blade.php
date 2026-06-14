<div class="inner-dashboard px-3">

    <div class="row">

        <div class="col-lg-9 col-md-12">

            <div class="dashboard-top px-5 py-3 d-flex justify-content-between align-items-center mb-4">

                <div class="content-top">
                    <div class="title text-white mb-2">Project to Date</div>
                    <div class="content d-flex gap-3 align-items-center">
                        <div class="icon text-success"><i class="fa-solid fa-caret-up"></i></div>
                        <div class="text-wrapper d-flex align-items-center gap-1">
                            <span class="text text-white fw-semibold fs-3">987</span>
                            <span class="sub-text text-white">/ Day</span>
                        </div>                        
                    </div>
                </div><!-- /.content-top -->
        
                <div class="content-top">
                    <div class="title text-white mb-2">Manhours</div>
                    <div class="content d-flex gap-3 align-items-center">
                        <div class="icon text-danger"><i class="fa-solid fa-caret-down"></i></div>
                        <div class="text-wrapper d-flex align-items-center gap-1">
                            <span class="text text-white fw-semibold fs-3">1,234,567</span>
                            <span class="sub-text text-white">Hours</span>
                        </div>                        
                    </div>
                </div><!-- /.content-top -->
        
                <div class="content-top">
                    <div class="title text-white mb-2">Day After Last LTI</div>
                    <div class="content d-flex gap-3 align-items-center">
                        <div class="icon text-success"><i class="fa-solid fa-caret-up"></i></div>
                        <div class="text-wrapper d-flex align-items-center gap-1">
                            <span class="text text-white fw-semibold fs-3">1,324</span>
                            <span class="sub-text text-white">Day</span>
                        </div>                        
                    </div>
                </div><!-- /.content-top -->
        
                <div class="content-top">
                    <div class="title text-white mb-2">Manpower</div>
                    <div class="content d-flex gap-3 align-items-center">
                        <div class="icon text-warning"><i class="fa-solid fa-caret-up"></i></div>
                        <div class="text-wrapper d-flex align-items-center gap-1">
                            <span class="text text-white fw-semibold fs-3">3,234</span>
                        </div>                        
                    </div>
                </div><!-- /.content-top -->
        
            </div><!-- /.dashboard-top -->
        
            <div class="dashboard-main">
                <div class="row">
                    <div class="col-lg-4 col-md-12">

                        <div class="content-wrapper d-flex flex-column gap-3">
                            
                            <div class="content-items">
                                @livewire('dashboard.widgets.safety-performance-chart')
                            </div><!-- /.content-items -->

                            <div class="content-items">
                                @livewire('dashboard.widgets.health-performance-chart')
                            </div><!-- /.content-items -->

                            <div class="content-items">
                                @livewire('dashboard.widgets.calendar-of-event-list')
                            </div>
    
                        </div><!-- /.content-wrapper -->
                        
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="slide position-relative">
                                    @livewire('dashboard.widgets.video-slide')
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="content-items">
                                    @livewire('dashboard.widgets.incident-notification')
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div><!-- /.dashboard-main -->

        </div><!-- /.col main content -->

        <div class="col-lg-3 col-md-12 sidebar-right">
            @livewire('dashboard.sidebar.sidebar-right')
        </div><!-- /.col sidebar -->
    </div><!-- /.row -->   
    
</div><!-- /.inner-dashboard -->

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @endpush
@endonce
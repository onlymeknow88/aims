<div class="inner-dashboard px-3 d-flex flex-column gap-3">

    <div class="section-wrapper row">

        <div class="col-lg-8 col-md-12">

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
        
            <div class="dashboard-main d-flex flex-column gap-3">

                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="content-wrapper">                            
                            <div class="content-items">
                                @livewire('dashboard.widgets.safety-performance-chart')
                            </div><!-- /.content-items -->    
                        </div><!-- /.content-wrapper -->
                    </div><!-- /.col-lg-6-->
                    <div class="col-md-12 col-lg-6">
                        <div class="content-wrapper">                            
                            <div class="content-items">
                                @livewire('dashboard.widgets.health-performance-chart')
                            </div><!-- /.content-items -->    
                        </div><!-- /.content-wrapper -->
                    </div><!-- /.col-lg-6-->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <div class="slide position-relative">
                            @livewire('dashboard.widgets.video-slide')
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="content-wrapper">
                            @livewire('dashboard.widgets.calendar-of-event-list')      
                        </div><!-- /.content-wrapper -->
                    </div><!-- /.col-lg-6-->
                </div><!-- /.row -->

                <div class="row gap-3">

                    <div class="col-lg-12 col-md-12">
                        <div class="content-items">
                            @livewire('dashboard.widgets.incident-notification')
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="content-items">
                            @livewire('dashboard.widgets.calendar')
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.dashboard-main -->

        </div><!-- /.col main content -->

        <div class="col-lg-4 col-md-12 sidebar-right">
            @livewire('dashboard.sidebar.sidebar-right')
        </div><!-- /.col sidebar -->
    </div><!-- /.row --> 
    
    <div class="section-wrapper row">

        <div class="col-md-12 col-lg-6">

            <div class="production-ytd">
                @livewire('dashboard.widgets.production-ytd-chart')
            </div>           

        </div><!-- /.col-lg-6 -->

        <div class="col-md-12 col-lg-6">

            <div class="production-ytd">
                @livewire('dashboard.widgets.production-mtd')
            </div>           

        </div><!-- /.col-lg-6 -->

    </div><!-- /.section-wrapper -->

    <div class="section-wrapper row">
        <div class="col-md-12 col-lg-5 d-flex flex-column gap-3">

            <div class="items-wrapper">
                @livewire('dashboard.widgets.safety-accountability-program')
            </div><!-- /.safety-accountability-wrapper -->

            <div class="items-wrapper">
                @livewire('dashboard.widgets.achievement-sap')
            </div><!-- /.safety-accountability-wrapper -->

        </div><!-- /.col-lg-6 -->

        <div class="col-md-12 col-lg-7">
            <div class="items-wrapper">
                @livewire('dashboard.widgets.sap-ytd')
            </div>
        </div><!-- /.col-lg-6 -->
    </div><!-- /.section-wrapper -->

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.coe')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.document-system')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.safety-accountability-bottom')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.field-leadership')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.inspection')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.audit')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.management-resiko')
        </div>
    </div>
    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.compliance-regulation')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.mcu')
        </div>
    </div>

    <div class="section-wrapper row">
        <div class="items-wrapper">
            @livewire('dashboard.widgets.csms')
        </div>
    </div>
    
</div><!-- /.inner-dashboard -->

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    @endpush
@endonce
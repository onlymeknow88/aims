<div class="inner-dashboard px-3 d-flex flex-column gap-3">

    <div class="section-wrapper row">
        <div class="col-md-12">
            @livewire('dashboard.home2.home2-top')
        </div>        
    </div><!-- /.section-wrapper -->

    <div class="section-wrapper row">
        <div class="col-md-12">
            @livewire('dashboard.home2.acheivement-hazard')
        </div>
    </div><!-- /.section-wrapper -->

    <div class="section-wrapper row">
        <div class="col-md-12 col-lg-6">
            @livewire('dashboard.home2.unsafe-condition')
        </div><!-- /.col-lg-6 -->
        <div class="col-md-12 col-lg-6">
            @livewire('dashboard.home2.unsafe-action')
        </div><!-- /.col-lg-6 -->
    </div><!-- /.section-wrapper -->

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
        <div class="col-md-12 col-lg-12">
            <div class="production-ytd">
                @livewire('dashboard.home2.sap-ytd')
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
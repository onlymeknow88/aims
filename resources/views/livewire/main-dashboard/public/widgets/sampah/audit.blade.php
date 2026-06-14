<div class="">
    <div class="">
        <div class="row">
            <div class="col-sm-4 p-2 ">
                <div class="card rounded-4 cummary-class">
                    @livewire('main-dashboard.public.widgets.audit.summary')
                </div>
            </div>
            <div class="col-sm-8 p-2">
                <div class="card rounded-4 detail-class">
                    @livewire('main-dashboard.public.widgets.audit.detail')
                </div>

            </div>
        </div>


        <div class="row">
            <div class="col-sm-4">
                <div class="card rounded-4 dougnut-class">
                    @livewire('main-dashboard.public.widgets.audit.dougnut')
                </div>
            </div>
            <div class="col-sm-4 ">
                <div class="card rounded-4 chart-class">
                    @livewire('main-dashboard.public.widgets.audit.chart')
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card rounded-4 progress-class">
                    @livewire('main-dashboard.public.widgets.audit.progress')
                </div>
            </div>
        </div>

    </div><!-- /.coe-c -->

</div><!-- coe-wrapper -->

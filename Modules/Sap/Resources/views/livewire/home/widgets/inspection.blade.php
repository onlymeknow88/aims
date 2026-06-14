<div class="inspection-wrapper  rounded-3 p-3">

    <div class="inspection-title py-1 text-center ">
        <h6>Inspection</h6>
    </div><!-- /.inspection-list-title -->

    <div class="inspection-c">


        <div class="row">
            <div class="col-sm-1">
                @livewire('main-dashboard.public.widgets.inspection.summary')
            </div>
            <div class="col-sm-3">
                @livewire('main-dashboard.public.widgets.inspection.chart')

            </div>
            <div class="col-sm-2">
                @livewire('main-dashboard.public.widgets.inspection.progress')

            </div>
            <div class="col-sm-3">
                @livewire('main-dashboard.public.widgets.inspection.dougnut')

            </div>
            <div class="col-sm-3">
                @livewire('main-dashboard.public.widgets.inspection.detail')
            </div>
        </div>


    </div><!-- /.inspection-c -->

</div><!-- inspection-wrapper -->

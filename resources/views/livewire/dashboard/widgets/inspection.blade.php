<div class="inspection-wrapper bg-green-op rounded-3 p-3">

    <div class="inspection-title py-1 text-center text-white">
        <h3>Inspection</h3>
    </div><!-- /.inspection-list-title -->

    <div class="inspection-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.inspection.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.inspection.chart')                        
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.inspection.detail')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.inspection.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.inspection-c -->

</div><!-- inspection-wrapper -->


<div class="coe-wrapper bg-green-op rounded-3 p-3">

    <div class="coe-title py-1 text-center text-white">
        <h3>Calendar Of Event</h3>
    </div><!-- /.coe-list-title -->

    <div class="coe-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.coe.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.coe.detail')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.coe.dougnut')                         
                    </div>
                    
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.coe.chart')
                    </div>
                    
                    <div class="col-12">
                        @livewire('dashboard.widgets.coe.progress')
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.coe-c -->

</div><!-- coe-wrapper -->

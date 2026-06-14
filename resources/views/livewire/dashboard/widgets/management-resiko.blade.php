<div class="mr-wrapper bg-green-op rounded-3 p-3">

    <div class="mr-title py-1 text-center text-white">
        <h3>Management Resiko</h3>
    </div><!-- /.mr-title -->

    <div class="mr-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mr.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mr.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.mr.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mr.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mr.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.mr-c -->

</div><!-- mr-wrapper -->
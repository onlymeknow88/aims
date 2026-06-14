<div class="ds-wrapper bg-green-op rounded-3 p-3">

    <div class="ds-title py-1 text-center text-white">
        <h3>Document System</h3>
    </div><!-- /.ds-title -->

    <div class="ds-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.ds.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.ds.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.ds.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.ds.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.ds.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.ds-c -->

</div><!-- ds-wrapper -->


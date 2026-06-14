<div class="cr-wrapper bg-green-op rounded-3 p-3">

    <div class="cr-title py-1 text-center text-white">
        <h3>Compliance Regulation</h3>
    </div><!-- /.cr-title -->

    <div class="cr-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.cr.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.cr.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.cr.chart')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.cr.progress')                        
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.cr.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.cr-c -->

</div><!-- cr-wrapper -->

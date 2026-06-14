<div class="mcu-wrapper bg-green-op rounded-3 p-3">

    <div class="mcu-title py-1 text-center text-white">
        <h3>Medical Check Up</h3>
    </div><!-- /.mcu-title -->

    <div class="mcu-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mcu.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mcu.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.mcu.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mcu.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.mcu.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.mcu-c -->

</div><!-- mcu-wrapper -->


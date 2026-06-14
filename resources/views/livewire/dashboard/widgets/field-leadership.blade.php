<div class="fls-wrapper bg-green-op rounded-3 p-3">

    <div class="fls-title py-1 text-center text-white">
        <h3>Field Leadership</h3>
    </div><!-- /.fls-list-title -->

    <div class="fls-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.fls.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.fls.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.fls.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.fls.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.fls.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.fls-c -->

</div><!-- fls-wrapper -->

<div class="csms-wrapper bg-green-op rounded-3 p-3">

    <div class="csms-title py-1 text-center text-white">
        <h3>Contractor Safety Management System</h3>
    </div><!-- /.csms-title -->

    <div class="csms-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.csms.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.csms.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.csms.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.csms.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.csms.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.csms-c -->

</div><!-- csms-wrapper -->


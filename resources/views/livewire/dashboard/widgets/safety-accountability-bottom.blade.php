<div class="sap-wrapper bg-green-op rounded-3 p-3">

    <div class="sap-title py-1 text-center text-white">
        <h3>Safety Accountability Program</h3>
    </div><!-- /.sap-list-title -->

    <div class="sap-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.sap.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.sap.detail')
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.sap.progress')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.sap.chart')
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.sap.dougnut')
                         
                    </div>
                    
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.sap-c -->

</div><!-- sap-wrapper -->

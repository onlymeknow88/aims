<div class="audit-wrapper bg-green-op rounded-3 p-3">

    <div class="audit-title py-1 text-center text-white">
        <h3>Audit</h3>
    </div><!-- /.audit-list-title -->

    <div class="audit-c">

        <div class="row">

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.audit.summary')
                    </div>
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.audit.detail')             
                    </div>
                    <div class="col-12">
                        @livewire('dashboard.widgets.audit.dougnut')
                    </div>
                </div>                                
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-6">
                <div class="row gap-3">

                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.audit.progress')                                                                          
                    </div>
                    
                    <div class="col-md-12 col-lg-12">
                        @livewire('dashboard.widgets.audit.chart')
                    </div>            
                </div>            
    
            </div><!-- /.col-lg-6 -->
            
        </div><!-- /.row -->

    </div><!-- /.audit-c -->

</div><!-- audit-wrapper -->

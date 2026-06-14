<div class="inner-content">
    
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Demo Chart</h4>
            </div>            
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-6">
    
                        <div class="chart-card bg-white border rounded-4 p-3">
    
                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Bar Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->
                            
                            <div class="chart-content">
                                @livewire('chart.chart-bar', $barChart)
                            </div><!-- /.chart-content -->
    
                        </div><!-- /.chart-card -->
    
                    </div><!-- /.col-1 -->
    
                    <div class="col-6">
    
                        <div class="chart-card bg-white border rounded-4 p-3">
    
                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Line Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->
                            
                            <div class="chart-content">
                                @livewire('chart.chart-line', $lineChart)
                            </div><!-- /.chart-content -->
    
                        </div><!-- /.chart-card -->
    
                    </div><!-- /.col-2 -->

                </div><!-- /.row -->

                <div class="row mb-4">
    
                    <div class="col-6">
    
                        <div class="chart-card bg-white border rounded-4 p-3">
    
                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Pie Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->
                            
                            <div class="chart-content">
                                @livewire('chart.chart-pie', $pieChart)
                            </div><!-- /.chart-content -->
    
                        </div><!-- /.chart-card -->
    
                    </div><!-- /.col-3 -->

                    <div class="col-6">
    
                        <div class="chart-card bg-white border rounded-4 p-3">
    
                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Doughnut Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->
                            
                            <div class="chart-content">
                                @livewire('chart.chart-doughnut', $doughnutChart)
                            </div><!-- /.chart-content -->
    
                        </div><!-- /.chart-card -->
    
                    </div><!-- /.col-3 -->
                    
    
                </div><!-- /.row -->

            </div><!-- /.container -->

            

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

</div>

<div class="chart-wrapper bg-green rounded-2 p-3">
    <div class="row">
        <div class="col-md-12 col-lg-4 d-flex flex-column gap-2 text-white">
            <h6 class="text-center">Fit</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'mcuCompleted',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '125px',
                    'height'    => '125px',
                    'textCenter'=> '98%',
                    'datasets'  =>  [[
                        'label' => 'Complete',
                        'data'  =>  [96, 4],
                        'backgroundColor' => [
                            '#19A7CE',
                            '#FFFAD7',                                    
                        ],
                        'borderWidth' => 1,
                    ]], 
                ]
            )
        </div><!-- /.col-lg-6 -->
        <div class="col-md-12 col-lg-4 d-flex flex-column gap-2 text-white justify-content-center">
            <h6 class="text-center">Unfit</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'mcuOngoing',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '125px',
                    'height'    => '125px',
                    'textCenter'=> '6%',
                    'datasets'  =>  [[
                        'label' => 'Complete',
                        'data'  =>  [6, 94],
                        'backgroundColor' => [
                            '#19A7CE',
                            '#FFFAD7',                                    
                        ],
                        'borderWidth' => 1,
                    ]], 
                ]
            )
        </div><!-- /.col-lg-6 -->
        <div class="col-md-12 col-lg-4 d-flex flex-column gap-2 text-white justify-content-center">
            <h6 class="text-center">Currently Unfit</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'mcuCurrentUnfit',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '125px',
                    'height'    => '125px',
                    'textCenter'=> '6%',
                    'datasets'  =>  [[
                        'label' => 'Complete',
                        'data'  =>  [6, 94],
                        'backgroundColor' => [
                            '#19A7CE',
                            '#FFFAD7',                                    
                        ],
                        'borderWidth' => 1,
                    ]], 
                ]
            )
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
    <div class="row">
        <div class="progress-item text-white">
            <h6>Fit With Recomendation</h6>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100">39%</div>
            </div>
        </div>
    </div>
</div>

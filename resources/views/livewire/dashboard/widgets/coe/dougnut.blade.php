<div class="chart-wrapper bg-green rounded-2 p-3">
    <div class="row">
        <div class="col-md-12 col-lg-6 d-flex flex-column gap-2 text-white">
            <h6 class="text-center">Complete</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'coeCompleted',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '150px',
                    'height'    => '150px',
                    'textCenter'=> '58%',
                    'datasets'  =>  [[
                        'label' => 'Complete',
                        'data'  =>  [58, 42],
                        'backgroundColor' => [
                            '#19A7CE',
                            '#FFFAD7',                                    
                        ],
                        'borderWidth' => 1,
                    ]], 
                ]
            )
        </div><!-- /.col-lg-6 -->
        <div class="col-md-12 col-lg-6 d-flex flex-column gap-2 text-white justify-content-center">
            <h6 class="text-center">On Going</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'coeOngoing',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '150px',
                    'height'    => '150px',
                    'textCenter'=> '17%',
                    'datasets'  =>  [[
                        'label' => 'Complete',
                        'data'  =>  [17, 83],
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
</div>

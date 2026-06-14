<div class="chart-wrapper bg-green rounded-2 p-3">
    <div class="row">
        <div class="col-md-12 col-lg-6 d-flex flex-column gap-2 text-white">
            <h6 class="text-center">Comply</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'crCompleted',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '150px',
                    'height'    => '150px',
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
        <div class="col-md-12 col-lg-6 d-flex flex-column gap-2 text-white justify-content-center">
            <h6 class="text-center">Not Comply</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'crOngoing',
                    'labels'    =>  ['Actual', 'Target'],
                    'width'     => '150px',
                    'height'    => '150px',
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
</div>

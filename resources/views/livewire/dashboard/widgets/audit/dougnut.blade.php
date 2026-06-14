<div class="chart-wrapper bg-green rounded-2 p-3">
    <div class="row">
        <div class="col-md-12 col-lg-6 d-flex flex-column gap-2 text-white">
            <h6 class="text-center">Update</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'auditCompleted',
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
            <h6 class="text-center">Obsolute</h6>
            @livewire(
                'dashboard.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'auditOngoing',
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

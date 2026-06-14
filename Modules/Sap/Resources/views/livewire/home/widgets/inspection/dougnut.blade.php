<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Target</label>
            @livewire(
                'main-dashboard.public.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'inspectionCompleted',
                    'labels'    =>  ['Actual', 'Target'],
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
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Actual</label>
            @livewire(
                'main-dashboard.public.components.doughnut-chart-text-center', 
                [
                    'idChart'   =>  'inspectionOngoing',
                    'labels'    =>  ['Actual', 'Target'],
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

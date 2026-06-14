<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Target</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'sapCompleted',
                'labels' => ['Actual', 'Target'],
            
                'textCenter' => $data['update']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['update']['target'], $data['update']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Actual</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'sapOngoing',
                'labels' => ['Actual', 'Target'],
            
                'textCenter' => $data['obsolute']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['obsolute']['target'], $data['obsolute']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

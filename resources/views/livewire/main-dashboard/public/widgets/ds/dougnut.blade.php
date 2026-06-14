<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Active</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'dsCompleted',
                'labels' => ['Actual', 'Target'],
            
                'textCenter' => $data['active']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['active']['actual'], $data['active']['target']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Obsolute</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'dsOngoing',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['obsolute']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['obsolute']['actual'], $data['obsolute']['target']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

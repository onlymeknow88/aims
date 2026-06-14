<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Complete</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'coeCompleted',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['complete']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['complete']['target'], $data['complete']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">On Going</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'coeOngoing',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['ongoing']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['ongoing']['target'], $data['ongoing']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

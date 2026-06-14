<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Target</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'inspectionCompleted',
                'labels' => ['completed', 'ongoing'],
                'textCenter' => $data['target']['ongoing'].'%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['target']['complete'], $data['target']['ongoing']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Actual</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'inspectionOngoing',
                'labels' => ['completed', 'ongoing'],
                'textCenter' => $data['actual']['ongoing'].'%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['actual']['complete'], $data['actual']['ongoing']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

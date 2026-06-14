<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Comply</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'crCompleted',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['complied']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['complied']['target'], $data['complied']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Not Comply</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'crOngoing',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['notcomply']['actual'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['notcomply']['target'], $data['notcomply']['actual']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

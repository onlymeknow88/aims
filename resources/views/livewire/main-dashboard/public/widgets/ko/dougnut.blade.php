<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-6 d-flex flex-column gap-2 text-secondary">
            <label class="text-center">Update</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'koCompleted',
                'labels' => ['Completed', 'Issue'],
                'textCenter' => $data['completed']['ongoing'] . '%',
                'datasets' => [
                    [
                        // 'label' => 'Complete',
                        'data' => [$data['completed']['completed'], $data['completed']['ongoing']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-6 d-flex flex-column gap-2 text-secondary justify-content-center">
            <label class="text-center">Obsolute</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'koOngoing',
                'labels' => ['Completed', 'Issue'],
                'textCenter' => $data['issue']['ongoing'] . '%',
                'datasets' => [
                    [
                        //'label' => 'Complete',
                        'data' => [$data['issue']['completed'], $data['issue']['ongoing']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
</div>

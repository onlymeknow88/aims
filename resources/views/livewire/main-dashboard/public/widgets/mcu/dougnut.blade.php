<div class="chart-wrapper  rounded-2 p-3">
    <div class="row">
        <div class="col-4 m-0 p-0 text-center text-secondary">
            <label class="text-center">Fit</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'mcuCompleted',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['fit_percent_actual'] . '%',
                'datasets' => [
                    [
                        'label' => 'Complete',
                        'data' => [$data['fit_percent_actual'], $data['fit_percent_target']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-4  m-0 p-0 text-center text-secondary ">
            <label class="text-center">Unfit</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'mcuOngoing',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['unfit_percent_actual'] . '%',
                'datasets' => [
                    [
                        'label' => 'Complete',
                        'data' => [$data['unfit_percent_actual'], $data['unfit_percent_target']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
        <div class="col-4 m-0 p-0 text-center text-secondary ">
            <label class="text-center">Currently Unfit</label>
            @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                'idChart' => 'mcuCurrentUnfit',
                'labels' => ['Actual', 'Target'],
                'textCenter' => $data['curentlyUnfit_percent_actual'] . '%',
                'datasets' => [
                    [
                        'label' => 'Complete',
                        'data' => [$data['curentlyUnfit_percent_actual'], $data['curentlyUnfit_percent_target']],
                        'backgroundColor' => ['#00552F', '#91BA5F'],
                        'borderWidth' => 1,
                    ],
                ],
            ])
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->


    {{--  <div class="row">
        <div class="progress-item text-secondary">
            <label>Fit With Recomendation</label>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 39%;" aria-valuenow="39"
                    aria-valuemin="0" aria-valuemax="100">39%</div>
            </div>
        </div>
    </div> --}}


</div>

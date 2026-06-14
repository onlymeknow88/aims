<div class="chart-card">
    <div class="p-tyd-title py-1 text-center">
        <h6>Production MTD</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        <div class="row">
            <div class="col-6">
                <div class="card bg-white chart-items rounded-3">
                    <div class="card-body p3">
                        @livewire('main-dashboard.public.components.doughnut-chart', [
                            'idChart' => 'productionMtdDoughnut',
                            'labels' => $dataCategory['labels'],
                            'datasets' => [
                                [
                                    //'label' => 'Pie Chart',
                                    'data' => $dataCategory['datasets'],
                                    'backgroundColor' => ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#00552F'],
                                    'borderWidth' => 1,
                                ],
                            ],
                            'legend' => [
                                'display' => true,
                                'position' => 'bottom',
                                'labels' => [
                                    'boxWidth' => 10,
                                    'color' => 'gray',
                                ],
                            ],
                        ])
                    </div>
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

            <div class="col-6">
                <div class="card bg-white chart-items rounded-3">
                    <div class="card-body p3">
                        @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                            'idChart' => 'productionMtdActual',
                            'labels' => ['Actual', 'Target'],
                        
                            'textCenter' => $dataProgress['actual'] . '%',
                            'datasets' => [
                                [
                                    // 'label' => 'Pie Chart',
                                    'data' => [$dataProgress['actual'], $dataProgress['target']],
                                    'backgroundColor' => ['#00552F', '#91BA5F'],
                                    'borderWidth' => 1,
                                ],
                            ],
                        ])
                    </div>
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

        </div><!-- /.row -->

    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->

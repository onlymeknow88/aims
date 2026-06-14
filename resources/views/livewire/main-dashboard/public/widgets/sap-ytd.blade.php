<div class="card rounded-4">
    <div class="card-body">
        <div class="chart-header d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0  fw-normal">SAP YTD</h6>
        </div>


        <div class="chart-content">
            <div class="row">
                <div class="col-lg-12 col-xl-4">
                    @livewire('main-dashboard.public.components.chart-line', [
                        'idChart' => 'sapLine',
                        'labels' => $data['label'],
                        'datasets' => [
                            [
                                'label' => 'Performance 01',
                                'backgroundColor' => '#00552F',
                                'data' => $data['actual'],
                                'borderColor' => '#00552F',
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'gray',
                            'beginAtZero' => true,
                        ],
                    ])
                </div>
                <div class="col-lg-12 col-xl-4 mt-auto">
                    @livewire('main-dashboard.public.components.gauge', [
                        'actual' => $dataProccess['actual'],
                        'target' => $dataProccess['target'],
                        'persen' => '50',
                    ])
                </div>

                <div class="col-lg-12 col-xl-4">
                    @livewire('main-dashboard.public.components.doughnut-chart', [
                        'idChart' => 'sapDoughnut',
                        'labels' => $dataCategory['label'],
                        'datasets' => [
                            [
                                //'label' => 'Pie Chart',
                                'data' => $dataCategory['actual'],
                                'backgroundColor' => ['#00552F', '#91BA5F', '#A5C882', '#ECF39E', '#00552F'],
                                'borderWidth' => 1,
                            ],
                        ],
                        'legend' => [
                            'display' => false,
                            'position' => 'top',
                            'labels' => [
                                'boxWidth' => 10,
                                'color' => 'gray',
                            ],
                        ],
                    ])
                </div>
            </div>

        </div><!-- /.chart-content -->

    </div><!-- /.chart-body -->
</div><!-- chart-card -->

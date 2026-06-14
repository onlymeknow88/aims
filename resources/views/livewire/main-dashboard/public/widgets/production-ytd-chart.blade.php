<div class="chart-card">
    <div class="p-tyd-title py-1 text-center">
        <h6>Production YTD</h6>
    </div><!-- /.p-tyd-title -->

    <div class="chart-content">
        <div class="row">
            <div class="col-sm-12 col-xl-6 mb-3">
                <div class="card bg-white chart-items rounded-3">
                    <div class="card-body p-3">
                        @livewire('main-dashboard.public.components.horizontal-bar-chart', [
                            'idChart' => 'productionBar',
                            'labels' => $dataBlock['labels'],
                            'datasets' => $dataBlock['datasets'],
                        ])
                    </div>

                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

            <div class="col-sm-12 col-xl-6 mb-3">
                <div class="card bg-white chart-items rounded-3">
                    <div class="card-body p-3">
                        @livewire('main-dashboard.public.components.chart-line', [
                            'idChart' => 'productionLine',
                            'labels' => $dataLine['labels'],
                            'datasets' => [
                                [
                                    //'label' => 'Performance 01',
                                    'backgroundColor' => '#00552F',
                                    'data' => $dataLine['datasets'],
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
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

        </div><!-- /.row -->

    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->

<div class="chart-card bg-green-op rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Production YTD</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        <div class="row gap-3">
            <div class="col-md-12 col-lg-12">
                <div class="chart-items bg-green rounded-3 p-3">
                    @livewire(
                        'dashboard.components.horizontal-bar-chart', 
                        [
                            'idChart'   =>  'productionBar',
                            'labels'    =>  ['2021', '2022', '2023', '2024'],
                            'datasets'  =>  [
                                [
                                    'label' => 'P 01',                                                
                                    'backgroundColor'   => '#FFFAD7',
                                    'data'  =>  [140, 150, 160, 200],
                                ],
                                [
                                    'label' => 'P 02',                                                
                                    'backgroundColor'   => '#FEFF86',
                                    'data'  =>  [100, 100, 110, 160],
                                ],
                                [
                                    'label' => 'P 03',                                                
                                    'backgroundColor'   => '#B0DAFF',
                                    'data'  =>  [150, 150, 200, 300],
                                ],
                                [
                                    'label' => 'P 04',                                                
                                    'backgroundColor'   => '#19A7CE',
                                    'data'  =>  [300, 350, 430, 470],
                                ]
                            ],
                        ]
                    )
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-12">
                <div class="chart-items bg-green rounded-3 p-3">
                    @livewire(
                        'dashboard.components.chart-line', 
                        [
                            'idChart'   =>  'productionLine',
                            'labels'    =>  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
                            'datasets'  =>  [
                                [
                                    'label' => 'Performance 01',                                                
                                    'backgroundColor'   => '#D9DC30',
                                    'data'  =>  [20, 28, 22, 37, 39],
                                    'borderColor' => '#D9DC30',
                                ]
                            ],
                            'labelX'    => [
                                'display'       => true,
                                'color'         => '#ffffff',
                                'beginAtZero'   => true
                            ]
                        ]
                    )
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

        </div><!-- /.row -->
        
    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->


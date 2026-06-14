<div class="chart-card bg-green rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>SAP YTD</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content d-flex flex-column gap-3">

        @livewire(
            'dashboard.components.chart-line', 
            [
                'idChart'   =>  'sapYtd',
                'labels'    =>  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
                'datasets'  =>  [
                    [
                        'label' => 'Performance 01',                                                
                        'backgroundColor'   => '#D9DC30',
                        'data'  =>  [19, 28, 22, 36, 38, 40],
                        'borderColor' => '#D9DC30',
                    ],
                    [
                        'label' => 'Performance 02',                                                
                        'backgroundColor'   => '#19A7CE',
                        'data'  =>  [20, 22, 23, 24, 28, 31, 32, 35, 33, 39, 41, 43],
                        'borderColor' => '#19A7CE',
                    ]
                ],
                'labelX'    => [
                    'display'       => true,
                    'color'         => '#ffffff',
                    'beginAtZero'   => true
                ]
            ]
        )
        <div class="row">
            <div class="col-md-12 col-lg-6 p-1">
                @livewire(
                    'dashboard.components.doughnut-chart', 
                    [
                        'idChart'   =>  'sapDoughnut',
                        'labels'    =>  ['TTT', 'Hazard Report', 'Inspeksi', 'PTO'],
                        'width'     => '250px',
                        'height'    => '250px',
                        'datasets'  =>  [[
                            'label' => 'Pie Chart',
                            'data'  =>  [47.8, 36.9, 10.5, 4.7],
                            'backgroundColor' => [
                                '#FFFAD7',
                                '#FEFF86',
                                '#B0DAFF',
                                '#19A7CE',
                            ],
                            'borderWidth' => 1,
                        ]],
                        'legend'    => [
                            'disply' => false,
                            'position' => 'top',
                            'labels'    => [
                                'boxWidth'  => 10,
                                'color'     => '#ffffff',                                  
                            ]
                        ],
                    ]
                )
            </div><!-- /.col-lg-6 -->
            <div class="col-md-12 col-lg-6 d-flex justify-content-center align-items-end">
                @livewire('dashboard.components.gauge')
            </div>
        </div><!-- /.row -->
    </div><!-- /.chart-content -->

</div><!-- chart-card -->

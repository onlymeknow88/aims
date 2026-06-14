<div class="chart-card bg-green-op rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Production MTD</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        <div class="row gap-3">
            <div class="col-md-12 col-lg-12">
                <div class="chart-items bg-green rounded-3 p-3">
                    @livewire(
                        'dashboard.components.doughnut-chart', 
                        [
                            'idChart'   =>  'productionMtdDoughnut',
                            'labels'    =>  ['Waste Removal', 'Coal Mining', 'Coal Hauling', 'Coal Barge', 'Coal Shiping'],
                            'width'     => '300px',
                            'height'    => '300px',
                            'datasets'  =>  [[
                                'label' => 'Pie Chart',
                                'data'  =>  [65, 59, 20, 81, 56],
                                'backgroundColor' => [
                                    '#FFFAD7',
                                    '#FEFF86',
                                    '#B0DAFF',
                                    '#19A7CE',
                                    '#FFFFFF',
                                ],
                                'borderWidth' => 1,
                            ]],
                            'legend'    => [
                                'disply' => true,
                                'position' => 'top',
                                'labels'    => [
                                    'boxWidth'  => 10,
                                    'color'     => '#ffffff',                                  
                                ]
                            ],
                        ]
                    )
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

            <div class="col-md-12 col-lg-12">
                <div class="chart-items bg-green rounded-3 p-3">
                    @livewire(
                        'dashboard.components.doughnut-chart-text-center', 
                        [
                            'idChart'   =>  'productionMtdActual',
                            'labels'    =>  ['Actual', 'Target'],
                            'width'     => '300px',
                            'height'    => '300px',
                            'textCenter'=> '34%',
                            'datasets'  =>  [[
                                'label' => 'Pie Chart',
                                'data'  =>  [34, 66],
                                'backgroundColor' => [
                                    '#19A7CE',
                                    '#FFFAD7',                                    
                                ],
                                'borderWidth' => 1,
                            ]], 
                        ]
                    )
                </div><!-- /.chart-items -->
            </div><!-- /.col-lg-6 -->

        </div><!-- /.row -->
        
    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->
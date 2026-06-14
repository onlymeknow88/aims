<div class="chart-card bg-green rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Achievement Hazard By Departement</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content d-flex flex-column gap-3">

        <div class="row">
            <div class="col-md-12 col-lg-4">
                @livewire(
                    'dashboard.components.vertical-bar-chart', 
                    [
                        'idChart'   =>  'achievementHazard',
                        'labels'    =>  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des'],
                        'datasets'  =>  [
                            [
                                'label' => 'Target',                                                
                                'backgroundColor'   => '#19A7CE',
                                'data'  =>  [140, 150, 160, 200, 300, 350, 400, 450, 500, 550, 600, 650],
                            ],
                            [
                                'label' => 'Actual',                                                
                                'backgroundColor'   => '#FEFF86',
                                'data'  =>  [100, 100, 110, 160, 200, 220, 250, 300, 330, 390, 400, 450],
                            ]
                        ],
                    ]
                )

                <div class="p-achievement">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 67%;" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100">67%</div>
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->
            <div class="col-md-12 col-lg-4">
                @livewire(
                    'dashboard.components.doughnut-chart', 
                    [
                        'idChart'   =>  'hazardDoughnut',
                        'labels'    =>  ['Waste Removal', 'Coal Mining', 'Coal Hauling', 'Coal Barge', 'Coal Shiping'],
                        'width'     => '250px',
                        'height'    => '250px',
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
            </div><!-- ./col-lg-4 -->
            <div class="col-md-12 col-lg-4">
                @livewire(
                    'dashboard.components.doughnut-chart-text-center', 
                    [
                        'idChart'   =>  'hazardActual',
                        'labels'    =>  ['Actual', 'Target'],
                        'width'     => '250px',
                        'height'    => '250px',
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
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

    </div><!-- /.chart-content -->

</div><!-- chart-card -->



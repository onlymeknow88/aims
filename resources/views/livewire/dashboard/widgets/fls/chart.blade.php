<div class="chart-wrapper bg-green rounded-2 p-3">
    @livewire(
            'dashboard.components.vertical-bar-chart', 
            [
                'idChart'   =>  'flsChart',
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
</div>

<div class="chart-card bg-green rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Safety Accountability Program YTD</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        @livewire(
            'dashboard.components.horizontal-bar-chart', 
            [
                'idChart'   =>  'safetyProgram',
                'labels'    =>  ['PTO', 'TTT', 'Hazard Report', 'Inspeksi'],
                'datasets'  =>  [
                    [
                        'label' => 'Target',                                                
                        'backgroundColor'   => '#19A7CE',
                        'data'  =>  [140, 150, 160, 200],
                    ],
                    [
                        'label' => 'Actual',                                                
                        'backgroundColor'   => '#FEFF86',
                        'data'  =>  [100, 100, 110, 160],
                    ]
                ],
            ]
        )
    </div><!-- /.chart-content -->

</div><!-- chart-card -->

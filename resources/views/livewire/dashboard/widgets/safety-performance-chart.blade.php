<div class="chart-card bg-green rounded-3 p-3">
    <div class="chart-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white fw-normal">Safety Performance PT AMC</h6>
        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
    </div><!-- /.chart-header -->
    <div class="chart-content">
        @livewire(
            'dashboard.components.chart-line', 
            [
                'idChart'   =>  'safetyPerformace',
                'labels'    =>  ['AIFR', 'AINFR', 'LTI FR', 'LTI SR'],
                'datasets'  =>  [
                    [
                        'label' => 'Performance 01',                                                
                        'backgroundColor'   => '#D9DC30',
                        'data'  =>  [0, 13, 38, 30],
                        'borderColor' => '#D9DC30',
                    ],
                    [
                        'label' => 'Performance 02',                                                
                        'backgroundColor'   => '#009D50',
                        'data'  =>  [11, 4, 20, 16],
                        'borderColor' => '#009D50',
                    ],
                    [
                        'label' => 'Performance 03',                                                
                        'backgroundColor'   => '#009D50',
                        'data'  =>  [11, 25, 27, 38],
                        'borderColor' => 'yellow',
                      
                    ],
                    [
                        'label' => 'Performance 04',                                                
                        'backgroundColor'   => 'blue',
                        'data'  =>  [24, 29, 20, 40],
                        'borderColor' => 'blue',
                    ],
                    [
                        'label' => 'Performance 05',                                                
                        'backgroundColor'   => 'red',
                        'data'  =>  [28, 30, 24, 40],
                        'borderColor' => 'red',
                      
                    ]
                ],
                'labelX'    => [
                    'display'       => true,
                    'color'         => '#ffffff',
                    'beginAtZero'   => true
                ],
            ]
        )
    </div><!-- /.chart-content -->
</div><!-- /.chart-card -->

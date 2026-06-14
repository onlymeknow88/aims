<div class="chart-card bg-green rounded-3 p-3">
    <div class="chart-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-white fw-normal">Performance</h6>
        <button type="button" class="btn text-white btn-transparent p-0"><i class="fa-solid fa-ellipsis"></i></button>
    </div><!-- /.chart-header -->
    <div class="chart-content">
        @livewire(
            'dashboard.components.chart-line', 
            [
                'idChart'   =>  'healthPerformance',
                'labels'    =>  ['RKK', 'CMR', 'MMR', 'SSR', 'ASR'],
                'datasets'  =>  [
                    [
                        'label' => 'Performance 01',                                                
                        'backgroundColor'   => '#D9DC30',
                        'data'  =>  [0, 13, 38, 30, 38],
                        'borderColor' => '#D9DC30',
                    ],
                    [
                        'label' => 'Performance 02',                                                
                        'backgroundColor'   => '#009D50',
                        'data'  =>  [11, 4, 20, 16, 25],
                        'borderColor' => '#009D50',
                    ],
                    [
                        'label' => 'Performance 03',                                                
                        'backgroundColor'   => '#009D50',
                        'data'  =>  [11, 25, 27, 38, 29],
                      
                    ],
                ],
                'labelX'    => [
                    'display'       => true,
                    'color'         => '#ffffff',
                    'beginAtZero'   => true
                ]
            ]
        )
    </div><!-- /.chart-content -->

</div><!-- /.chart-card -->

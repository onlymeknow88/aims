<div class="chart-card bg-green rounded-3 p-3">
    <div class="p-tyd-title py-1 text-center text-white">
        <h6>Achievement SAP By Departement</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content d-flex flex-column gap-3">

        @livewire(
            'dashboard.components.vertical-bar-chart', 
            [
                'idChart'   =>  'achievementSap',
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


    </div><!-- /.chart-content -->

</div><!-- chart-card -->


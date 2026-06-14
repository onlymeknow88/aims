<div class="card rounded-4 p-3" style="min-height:315px !important">
    <div class="p-tyd-title py-1 text-center ">
        <h6>Achievement SAP By Departement</h6>
    </div><!-- /.p-tyd-title -->


    <div class="chart-content">
        @livewire('main-dashboard.public.components.vertical-bar-chart', [
            'idChart' => 'achievementSap',
            'labels' => $data['label'],
            'datasets' => [
                [
                    'label' => 'Target',
                    'backgroundColor' => '#00552F',
                    'data' => $data['target'],
                ],
                [
                    'label' => 'Actual',
                    'backgroundColor' => '#91BA5F',
                    'data' => $data['actual'],
                ],
            ],
        ])

    </div><!-- /.chart-content -->
</div><!-- /.chart-card -->

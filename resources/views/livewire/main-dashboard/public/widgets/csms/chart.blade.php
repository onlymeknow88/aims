<div class="chart-wrapper  rounded-2 p-3">
    @livewire('main-dashboard.public.components.vertical-bar-chart', [
        'idChart' => 'csmsChart',
        'labels' => $data['labels'],
        'datasets' => [
            /* [
                    'label' => 'Target',
                    'backgroundColor' => '#00552F',
                    'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                ], */
            [
                'label' => 'Actual',
                'backgroundColor' => '#91BA5F',
                'data' => $data['actual'],
            ],
        ],
    ])
</div>

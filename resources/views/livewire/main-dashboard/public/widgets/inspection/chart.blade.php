<div class="chart-wrapper  rounded-2 p-3">
    @livewire('main-dashboard.public.components.vertical-bar-chart', [
        'idChart' => 'inspectionChart',
        'labels' => $data['label'],
        'datasets' => [
          /*   [
                'label' => 'Target',
                'backgroundColor' => '#00552F',
                'data' => $data['target'],
            ], */
            [
                'label' => 'Actual',
                'backgroundColor' => '#91BA5F',
                'data' => $data['actual'],
            ],
        ],
    ])
</div>

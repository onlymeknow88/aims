<div class="chart-wrapper  rounded-2 p-3">
    @livewire('csms::dashboard.components.vertical-bar-chart', [
        'idChart' => $data['idChart'],
        'labels' => $data['labels'],
        'datasets' => [
            [
                'label' => $data['label'],
                'backgroundColor' => '#91BA5F',
                'data' => $data['actual'],
            ],
            [
                'label' => $data['label2'],
                'backgroundColor' => '#d94141',
                'data' => $data['target'],
            ],
        ],
    ])
</div>

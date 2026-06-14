<div class="chart-wrapper  rounded-2 p-3">
    @livewire('csms::dashboard.components.vertical-bar-chart', [
        'idChart' => $data['idChart'],
        'labels' => $data['labels'],
        'datasets' => [
            [
                'label' => $data['label'],
                'backgroundColor' => '#00552F',
                'data' => $data['val1'],
            ],
            [
                'label' => $data['label2'],
                'backgroundColor' => '#91BA5F',
                'data' => $data['val2'],
            ],
            [
                'label' => $data['label3'],
                'backgroundColor' => '#91BA5F',
                'data' => $data['val3'],
            ],
            [
                'label' => $data['label4'],
                'backgroundColor' => '#91BA5F',
                'data' => $data['val4'],
            ],
        ],
    ])
</div>

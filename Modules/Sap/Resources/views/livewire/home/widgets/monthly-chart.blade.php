@php
    $data = $data['data'];
    $monthly = $data['monthly'];

    $slug = str_replace('-', '', $data['slug']);
    $label = [];
    $target = [];
    $actual = [];
    $dept = [];
    foreach ($monthly as $month) {
        foreach ($month['data'] as $key => $list) {
            $label[] = $key;
            $target[] = $list['target_dept'];
            $actual[] = $list['actual_dept'];
            $dept[] = 100;
        }
    }
@endphp


<div>
    <div class="text-secondary text-center">TARGET VS AKTUAL</div>
    @include('sap::livewire.home.components.vertical-bar-chart', [
        'idChart' => 'sapMonthlyChart' . $slug,
        'labels' => $label,
        'datasets' => [
            [
                'label' => 'Target',
                'backgroundColor' => '#FFC0CB',
                'data' => $target,
            ],
            [
                'label' => 'Actual',
                'backgroundColor' => '#FF00FF',
                'data' => $actual, //$actual_dept,
            ],
            [
                'type' => 'line',
                'label' => 'Dept',
                'backgroundColor' => 'green',
                'color'=>'green',
                'data' => $dept, //$actual_dept,
            ],
        ],
        'options' => [
            'aspectRatio' => '1 | 4',
        ],
    ])
</div>

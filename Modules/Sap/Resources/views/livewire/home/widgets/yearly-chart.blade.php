@php
    $data = $data['data'];
    $yearly = $data['yearly'];
    $slug = str_replace('-', '', $data['slug']);
    $label = [];
    $target = [];
    $actual = [];
    $dept = [];
    foreach ($yearly as $index => $list) {
        $label[] = $index;
        $target[] = $list['target_dept'];
        $actual[] = $list['actual_dept'];
        $dept[] = 100;
    }
@endphp

<div>
    <div class="text-secondary text-center">TARGET VS AKTUAL</div>
    @include('sap::livewire.home.components.combo-bar-line-chart', [
        'idChart' => 'sapYearlyChart' . $slug,
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
                'data' => $actual,
            ],
    
            [
                'type' => 'line',
                'label' => 'Dept',
                'backgroundColor' => 'green',
                'color' => 'green',
                'data' => $dept,
            ],
        ],
        'options' => [
            'aspectRatio' => '1 | 4',
        ],
    ])
</div>

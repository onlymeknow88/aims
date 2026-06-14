@php
    $data = $data['data'];
    $monthly = $data['monthly'];
    
    $slug = str_replace('-', '', $data['slug']);
    $label = [];
    $target = [];
    $actual = [];
    foreach ($monthly as $month) {
        foreach ($month['data'] as $key => $list) {
            $label[] = $key;
            $target[] = $list['target_dept'];
            $actual[] = $list['actual_dept'];
        }
    }
@endphp


<div  wire:ignore>
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
        ],
        'options' => [
            'aspectRatio' => '1 | 4',
        ],
    ])
</div>

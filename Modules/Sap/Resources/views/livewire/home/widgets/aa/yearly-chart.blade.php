@php
     $data = $data['data'];
    $yearly = $data['yearly'];
    $slug = str_replace('-', '', $data['slug']);
    $label = [];
    $target = [];
    $actual = [];
    foreach ($yearly as $index => $list) {
        $label[] = $index;
        $target[] = $list['target_dept'];
        $actual[] = $list['actual_dept'];
    }
@endphp

<div  wire:ignore>
    <div class="text-secondary text-center">TARGET VS AKTUAL</div>
    @include('sap::livewire.home.components.vertical-bar-chart', [
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
        ],
        'options' => [
            'aspectRatio' => '1 | 4',
        ],
    ])
</div>

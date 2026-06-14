<div class="card rounded-4 bg-white pb-3">
    <div class="card-body p-3">
        <div class="chart-header d-flex justify-content-between align-items-center  mb-3">
            <h6 class="mb-0  fw-normal">Safety Performance PT AMC</h6>
        </div><!-- /.chart-header -->

        <div class="chart-content">
            @livewire('main-dashboard.public.components.chart-line', [
                'idChart' => 'safetyPerformace',
                'labels' => ['AIFR', 'AINFR', 'LTI FR', 'LTI SR'],
                'datasets' => $data,
                'labelX' => [
                    'display' => true,
                    'color' => 'gray',
                    'beginAtZero' => true,
                ],
            ])
        </div><!-- /.chart-content -->
    </div><!-- /.chart-content -->
</div><!-- /.chart-card -->

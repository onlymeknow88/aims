<div class="card rounded-4 bg-white pb-3">
    <div class="card-body p-3">
        <div class="chart-header d-flex justify-content-between align-items-center  mb-3">
            <h6 class="mb-0  fw-normal">Safety Accountability Program YTD
            </h6>
        </div><!-- /.chart-header -->


        <div class="chart-content">
            @livewire('main-dashboard.public.components.horizontal-bar-chart', [
                'idChart' => 'horizontalSapYtd',
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
    </div>
</div><!-- /.chart-card -->

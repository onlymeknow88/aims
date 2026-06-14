<div class="dashboard-main p-3">
    <div class="row">

        @foreach ($allChart as $key => $item)
            <div class="col-4 mb-3">
                <div class="chart-card bg-white border rounded-4 p-3">
                    <div class="chart-header  d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-normal">{{ $item['department'] }} - {{ $item['department_company'] }} </h6>
                        <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                                class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                        @livewire('documentsystem::dashboard.chart-bar', [
                            'idChart' => 'chartdocsys' . $loop->iteration,
                            'labels' => null,
                            'datasets' => [
                                [
                                    'label' => 'Total Document',
                                    'backgroundColor' => '#004d9d',
                                    'hoverBackgroundColor' => '#01009d',
                                    'data' => $item['total'],
                                ],
                                [
                                    'label' => 'Document Active',
                                    'backgroundColor' => '#009D50',
                                    'hoverBackgroundColor' => '#00ea77',
                                    'data' => $item['active'],
                                ],
                                [
                                    'label' => 'Document Expired',
                                    'backgroundColor' => '#4f009d',
                                    'hoverBackgroundColor' => '#9d009c',
                                    'data' => $item['expired'],
                                ],
                            ],
                            'labelX' => [
                                'display' => true,
                                'color' => 'rgba(0,0,0,0.8)',
                                'beginAtZero' => true,
                            ],
                        ])
                    </div><!-- /.chart-content -->
                </div><!-- /.chart-card -->

            </div>
        @endforeach

    </div>
</div>

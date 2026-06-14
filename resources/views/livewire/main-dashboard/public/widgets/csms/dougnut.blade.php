<div class="chart-wrapper  rounded-2 p-3" style="overflow: auto">
    <div class="row">
        @foreach ($data as $index => $list)
            <div class="col-6 m-0 p-0 text-center text-secondary">
                <label class="text-center">{{ $list['name'] }}</label>
                @livewire('main-dashboard.public.components.doughnut-chart-text-center', [
                    'idChart' => 'csms' . $index,
                    'labels' => ['Actual', 'Target'],
                    'textCenter' => $list['actual'] . '%',
                    'datasets' => [
                        [
                            'label' => 'Complete',
                            'data' => [$list['actual'], $list['target']],
                            'backgroundColor' => ['#00552F', '#91BA5F'],
                            'borderWidth' => 1,
                        ],
                    ],
                ])
            </div><!-- /.col-lg-6 -->
        @endforeach
    </div><!-- /.row -->


    {{--  <div class="row">
        <div class="progress-item text-secondary">
            <label>Fit With Recomendation</label>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 39%;" aria-valuenow="39"
                    aria-valuemin="0" aria-valuemax="100">39%</div>
            </div>
        </div>
    </div> --}}


</div>

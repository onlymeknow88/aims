<div>
    <div class="chart-wrapper" style="width:{{$width}}px; height:{{$height}}px;margin:0 auto;">

        <canvas id="{{$idChart}}"></canvas>

    </div><!-- /.chart-wrapper -->


    @once
        @push('scripts')
            <!--<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>-->
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>
        @endpush
    @endonce

    @push('scripts')

    <script type="text/javascript">

        const {{$idChart}} = document.getElementById('{{$idChart}}');

        Chart.register(ChartDataLabels);
        Chart.defaults.set('plugins.datalabels', {
            color: 'white'
        });

        const {{$idChart}}Main = new Chart({{$idChart}}, {
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                barPercentage: 0.7,
                plugins:{
                    legend: {
                        display: @json($legend),
                        position: 'right'
                    },
                    tooltip: {
                        intersect: false,
                        mode: 'index',
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value*100 / sum).toFixed(2)+"%";
                            return percentage;
                        },
                        color: '#fff',
                    }
                },                
                scales: {
                    y: {
                        stacked: true,
                        barThickness: 6,
                        ticks: {
                            display: false,
                            color: 'red',
                            beginAtZero: true
                        },
                        grid: {
                            display: false,
                        },
                        border:{
                            display:false,
                        }
                    },
                    x: {
                        stacked: true,
                        barThickness: 6,                     
                        grid: {
                            display: false,
                        },
                        border:{
                            display:false,
                        },
                        ticks: @json($labelX)
                    }
                },                
            }
        });

    </script>

    @endpush

</div>

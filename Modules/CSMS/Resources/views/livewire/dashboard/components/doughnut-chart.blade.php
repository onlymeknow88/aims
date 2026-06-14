<div>
    <div class="chart-wrapper" style="width:{{$width}}; height:{{$height}};margin:0 auto;">

        <canvas id="{{$idChart}}"></canvas>

    </div><!-- /.chart-wrapper -->


    @once
        @push('scripts')
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @push('scripts')

    <script type="text/javascript">

        const {{$idChart}} = document.getElementById('{{$idChart}}');

        window.{{$idChart}}Main = new Chart({{$idChart}}, {
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                plugins:{
                    legend: @json($legend),
                    tooltip: {
                        intersect: false,
                        mode: 'index',
                    },
                },                
                scales: {
                    y: {
                        stacked: true,
                        barThickness: 2,
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
                        barThickness: 2,                     
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


<div>
    <div class="chart-wrapper">

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

        new Chart({{$idChart}}, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins:{
                    legend: {
                        display: false
                    },
                    tooltip: {
                        intersect: false,
                        mode: 'index',
                    },
                },                
                scales: {
                    y: {
                        grid: {
                            display: true,
                            color: '#ffffff'
                        },
                        border:{
                            display:true,
                            color: '#ffffff'
                        },
                        ticks:{
                            color:'#ffffff'
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
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

        window.{{$idChart}}Main = new Chart({{$idChart}}, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                barPercentage: 0.7,
                responsive: true,
                maintainAspectRatio: false,
                plugins:{
                    legend: {
                        display: true,
                        labels: {
                            color: 'gray', 
                        }
                    },
                    tooltip: {
                        intersect: false,
                        mode: 'index',
                    },
                },                
                scales: {
                    y: {
                        barThickness: 6,
                        ticks: {
                            display: true,
                            color: 'gray',
                            beginAtZero: true
                        },
                        grid: {
                            display: false,
                        },
                        border:{
                            display:true,
                        }
                    },
                    x: {
                        barThickness: 6,                     
                        grid: {
                            display: true,
                            color: 'gray'
                        },
                        border:{
                            display:true,
                            color: 'gray'
                        },
                        ticks: {
                            display: true,
                            color: 'gray',
                            beginAtZero: true
                        },
                    }
                },                
            }
        });

    </script>

    @endpush

</div>

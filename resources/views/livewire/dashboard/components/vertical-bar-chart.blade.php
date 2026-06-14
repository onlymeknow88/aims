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

        const {{$idChart}}Main = new Chart({{$idChart}}, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                indexAxis: 'x',
                responsive: true,
                barPercentage: 0.7,
                responsive: true,
                maintainAspectRatio: false,
                plugins:{
                    legend: {
                        display: true,
                        labels: {
                            color: '#ffffff', 
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
                            color: '#ffffff',
                            beginAtZero: true
                        },
                        grid: {
                            display: true,
                            color: '#ffffff'
                        },
                        border:{
                            display:true,
                        }
                    },
                    x: {
                        barThickness: 6,                     
                        grid: {
                            display: false,
                            color: '#ffffff'
                        },
                        border:{
                            display:true,
                            color: '#ffffff'
                        },
                        ticks: {
                            display: true,
                            color: '#ffffff',
                            beginAtZero: true
                        },
                    }
                },                
            }
        });

    </script>

    @endpush

</div>

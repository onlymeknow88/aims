<div>
    <div class="chart-wrapper">

        <canvas id="{{$idChart}}"></canvas>

    </div><!-- /.chart-wrapper -->

    @once
        @push('scripts')
            <!--<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>-->
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @push('scripts')

    <script type="text/javascript">

        const {{$idChart}} = document.getElementById('{{$idChart}}');

        new Chart({{$idChart}}, {
            type: 'radar',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                barPercentage: 0.7,
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
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: -100,
                        suggestedMax: 100
                    },
                }     
              
            }
        });
    </script>

    @endpush

</div>

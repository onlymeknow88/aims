<div>
    <div class="chart-wrapper">

        <canvas id="{{ $idChart }}"></canvas>

    </div><!-- /.chart-wrapper -->

    @once
        @push('scripts')
            <!--<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>-->
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @push('scripts')
        <script type="text/javascript">
            const {{ $idChart }} = document.getElementById('{{ $idChart }}');

            const {{ $idChart }}Main = new Chart({{ $idChart }}, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: @json($datasets),
                },
                options: {
                    barPercentage: 0.9,
                    plugins: {
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
                            stacked: false,
                            barThickness: 6,
                            ticks: {
                                display: false,
                                color: 'red',
                                beginAtZero: true
                            },
                            grid: {
                                display: false,
                            },
                            border: {
                                display: false,
                            }
                        },
                        x: {
                            stacked: false,
                            barThickness: 6,
                            grid: {
                                display: false,
                            },
                            border: {
                                display: false,
                            },
                            ticks: @json($labelX)
                        }
                    },
                }
            });
        </script>
    @endpush

</div>

<div>
    <div class="chart-wrapper">
        <canvas id="{{ $idChart }}" class="canvas-chart-line"></canvas>
    </div><!-- /.chart-wrapper -->

    <style>
        .canvas-chart-line {}
    </style>

    @once
        @push('scripts')
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @push('scripts')
        <script type="text/javascript">
            const {{ $idChart }} = document.getElementById('{{ $idChart }}');

            window.{{ $idChart }}Main = new Chart({{ $idChart }}, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: @json($datasets),
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    aspectRatio: 1 | 1,
                    barPercentage: 0.7,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                            }
                        },
                        tooltip: {
                            intersect: false,
                            mode: 'index',
                        },
                    },
                    scales: {
                        y: {
                            stacked: false,
                            grid: {
                                display: true,
                                color: '#f2f2f2'
                            },
                            border: {
                                display: true,
                            },
                            ticks: {}
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

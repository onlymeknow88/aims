<div>
    <div class="chart-wrapper">

        <canvas id="{{ $idChart }}"></canvas>

    </div><!-- /.chart-wrapper -->

    @once
        @push('scripts')
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @push('scripts')
        <script type="text/javascript">
            const {{ $idChart }} = document.getElementById('{{ $idChart }}');

            window.{{ $idChart }}Main = new Chart({{ $idChart }}, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: @json($datasets),
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    aspectRatio: 1 | 1,
                    indexAxis: 'y',
                    barPercentage: 0.7,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#4F4F4F',
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
                                beginAtZero: true
                            },
                            grid: {
                                display: false,
                                color: '#f2f2f2'
                            },
                            border: {
                                display: true,
                                color: '#f2f2f2'
                            }
                        },
                        x: {
                            barThickness: 6,
                            grid: {
                                display: true,
                                color: '#f2f2f2'
                            },
                            border: {
                                display: true,
                                color: '#f2f2f2'
                            },
                            ticks: {
                                display: true,
                                beginAtZero: true
                            },
                        }
                    },
                }
            });
        </script>
    @endpush

</div>

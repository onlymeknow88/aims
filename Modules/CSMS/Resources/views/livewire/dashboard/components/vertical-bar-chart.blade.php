<div>
    <div class="chart-wrapper">

        <canvas id="{{ $idChart }}" style="height: 300px"></canvas>

    </div><!-- /.chart-wrapper -->

    @once
        @push('scripts')
            <script src="{{ asset('assets/libs/chartjs/dist/chart.umd.js') }}"></script>
        @endpush
    @endonce

    @php
        $Ratio = !empty($ratio) ? $ratio : null;
    @endphp

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
                    aspectRatio: 1 | 1,
                    responsive: true,
                    indexAxis: 'x',
                    barPercentage: 0.7,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
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
                                beginAtZero: true
                            },
                            grid: {
                                display: true,
                            },
                            border: {
                                display: true,
                                color: '#f2f2f2'
                            }
                        },
                        x: {
                            barThickness: 6,
                            grid: {
                                display: false,
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

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
        <script>
            const {{ $idChart }} = document.getElementById('{{ $idChart }}');
            var id = {{ $idChart }} + 'Main';

            window.{{ $idChart }}Main = new Chart({{ $idChart }}, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: @json($datasets),
                },
                options: {
                    maintainAspectRatio: false,
                    aspectRatio: 1 | 4,
                    responsive: true,
                    indexAxis: 'x',
                    barPercentage: 0.7,
                    plugins: {
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
                                display: true,
                                color: 'gray'
                            },
                            border: {
                                display: true,
                            }
                        },
                        x: {
                            barThickness: 6,
                            grid: {
                                display: false,
                                color: 'gray'
                            },
                            border: {
                                display: true,
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

            // Livewire.on('filter', value => {
            //     alert();
            //     window[id].data.labels = @json($labels);
            //     window[id].data.datasets = @json($datasets);
            //     window[id].update();
            // })
        </script>
    @endpush

</div>

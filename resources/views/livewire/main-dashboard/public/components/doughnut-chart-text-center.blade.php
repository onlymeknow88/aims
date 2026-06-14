<div>
    <div class="chart-wrapper" style="width:{{ $width }}; height:{{ $height }};margin:0 auto;">

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
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: @json($datasets),
                },
                options: {
                    cutout: '75%',
                    plugins: {
                        legend: {
                            'display': true,
                            'position': 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 10,
                            }
                        },
                        tooltip: {
                            intersect: true,
                            mode: 'index',
                            borderWidth: 1,
                        }
                    },
                    scales: {
                        y: {
                            barThickness: 2,
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
                            barThickness: 2,
                            grid: {
                                display: false,
                            },
                            border: {
                                display: false,
                            },
                            ticks: @json($labelX)
                        }
                    },
                },
                plugins: [{
                    id: 'text',
                    beforeDraw: function(chart, a, b) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;
                        console.log(chart);

                        ctx.restore();
                        var fontSize = (chart.chartArea.height / 50).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.textColor = "red";

                        var text = "{{ $textCenter }}",
                            textX = Math.round((width - ctx.measureText(text).width) / 2) + 4,
                            textY = chart.chartArea.height / 2;
                        ctx.fillStyle = 'rgba(0, 0, 0, 1)';
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }]
            });
        </script>
    @endpush

</div>

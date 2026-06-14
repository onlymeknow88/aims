<div>
    <div class="chart-wrapper" style="width:{{$width}}; height:{{$height}};margin:0 auto;">

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
            type: 'doughnut',
            data: {
                labels: @json($labels),
                datasets: @json($datasets),
            },
            options: {
                cutout: '75%',
                plugins:{
                    legend: false,
                    tooltip: {
                        intersect: true,
                        mode: 'index',
                        borderWidth :1,
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
                        border:{
                            display:false,
                        }
                    },
                    x: {
                        barThickness: 2,                     
                        grid: {
                            display: false,
                        },
                        border:{
                            display:false,
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

                ctx.restore();
                var fontSize = (height / 144).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.textColor = "white";

                var text = "{{$textCenter}}",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    //textY = (height - ctx.measureText(text).height) / 2
                    textY = height / 2;
                ctx.fillStyle = 'rgba(255, 255, 255, 1)';
                ctx.fillText(text, textX, textY);
                ctx.save();
                }
            }]
        });

    </script>

    @endpush

</div>



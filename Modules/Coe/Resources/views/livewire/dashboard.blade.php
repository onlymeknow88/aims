<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Event Terlaksana (DONE)
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            Total Event Berdasarkan Status Tahun {{ \Carbon\Carbon::now()->format('Y') }}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <br>
    <div class="row">
        <div class="col-md-12">
            <div class="chart-card bg-white border rounded-4 p-3">

                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Pie Chart</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->

                <div class="chart-content">

                    @livewire('chart.chart-pie', $pieChart)
                </div><!-- /.chart-content -->

            </div><!-- /.chart-card -->
        </div>
    </div> --}}
</div>
@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
@endonce
@push('scripts')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
        var ctx = document.getElementById('shrt').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [{!! implode(', ', $label1) !!}],
                datasets: [{
                    label: 'Event Terlaksana /Bulan',
                    data: [{{ implode(', ', $data1) }}],
                    backgroundColor: '#009D50',
                    borderColor: '#009D50',
                    borderWidth: 1
                }
            ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx3 = document.getElementById('shrt3').getContext('2d');
        var chart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [{!! implode(', ', $label3) !!}],
                datasets: [{
                    label: 'Total Event ',
                    data: [{{ implode(', ', $data3) }}],
                    backgroundColor: '#009D50',
                    borderColor: '#009D50',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('shrt2').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [{!! implode(', ', $label2) !!}],
                datasets: [{
                    label: 'Pemenuhan Inspeksi KPLH PJA',
                    data: [{{ implode(', ', $data2) }}],
                    backgroundColor: '#009D50',
                    borderColor: '#009D50',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
@endpush

<div class="container">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Pemenuhan Inspeksi KPLH CCOW
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
                        <div class="col-md-7">
                            Status Inspeksi KPLH
                        </div>
                        <div class="col-md-5" style="display: flex; justify-content: space-between;">
                            <span>
                                <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-calendar"></i> Tanggal
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                        <div class="sort-search">
                                            <div class="input-group">
                                                <x-inputs.datepicker wire:model.1500ms="filter_date_start"
                                                    placeholder="Tanggal Awal" aria-describedby="search-icon"
                                                    id="filter_date_start" />
                                            </div>
                                            <center>Sampai</center>
                                            <div class="input-group">
                                                <x-inputs.datepicker wire:model.1500ms="filter_date_end"
                                                    placeholder="Tanggal Akhir" aria-describedby="search-icon"
                                                    id="filter_date_end" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--./dropdown-content-->
                                </div><!-- /.dropdown-menu -->
                            </span>
                            <span>
                                <button class="btn border-0 p-0" type="button"
                                    @if (in_array('ccow_id', $sortSelected)) data-toggle="tooltip" title="Pilih CCOW terlebih dahulu"
                                    @else
                                    data-bs-toggle="dropdown" @endif>
                                    <i class="fa fa-filter"></i> Departemen
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                        <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                            {{-- @if (in_array('ccow_id', $sortSelected)) --}}
                                            @foreach ($optDepartment as $index => $item)
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault"
                                                        wire:click="sortCheck('department_id', '{{ $item->id }}')">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">{{ $item->name }}</label>
                                                </div>
                                            @endforeach
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    <!--./dropdown-content-->
                                </div><!-- /.dropdown-menu -->
                            </span>
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

    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Pemenuhan Inspeksi KPLH PJA
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="shrt2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    label: 'Pemenuhan Inspeksi KPLH CCOW',
                    data: [{{ implode(', ', $data1) }}],
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

        var ctx3 = document.getElementById('shrt3').getContext('2d');
        var chart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [{!! implode(', ', $label3) !!}],
                datasets: [{
                    label: 'Status Inspeksi KPLH',
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

        Livewire.on('updateChart3', data => {
            chart3.data = {
                labels: data.label3,
                datasets: [{
                    label: data.title,
                    data: data.data3,
                    backgroundColor: '#009D50',
                    borderColor: '#009D50',
                    borderWidth: 1
                }]
            };
            chart3.update();
        });
    </script>
@endpush

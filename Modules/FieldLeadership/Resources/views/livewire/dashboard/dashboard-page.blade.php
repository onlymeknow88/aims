<div class="dashboard-main p-3">
    <div class="container py-3">
        <div class="row mb-3">
            <div class="col-4"></div>
            <label for="year" class="col-sm-1 col-form-label">Year</label>
            <div class="col-4">
                <form method="get">
                    <select class="form-control" wire:model="year" onchange="this.form.submit()" id="year"
                        name="year" placeholder="Select Year">
                        @for ($i = 2021; $i <= 2035; $i++)
                            <option value="{{ $i }}" {{ $i == ($_GET['year'] ?? '') ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="row mb-3 py-3">
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">CCOW </h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'CCOW',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'CCOW',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $ccow,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->

        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Company</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'Company',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Company',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $company,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Detail Company</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'Detail_Company',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Detail Company',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $detail_company,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Department</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'Department',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Department',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $department,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Section</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'Section',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Section',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $section,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Area Location</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'Area_Location',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Area Location',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $location,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Jenis Field Leadership</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'type_field_leadership',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Hazard Report',
                                'backgroundColor' => '#9d004d',
                                'hoverBackgroundColor' => '#ea0073',
                                'data' => $type_hr,
                            ],
                            [
                                'label' => 'Take Time Talk',
                                'backgroundColor' => '#b7ba1f',
                                'hoverBackgroundColor' => '#e5e771',
                                'data' => $type_ttt,
                            ],
                            [
                                'label' => 'Planned Task Observation',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#00ea77',
                                'data' => $type_pto,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Perilaku / Kondisi Berisiko - Kategori</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'category',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Kategori',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $category,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Perilaku / Kondisi Berisiko - KTA/TTA</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'kta_tta',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'KTA/TTA',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $kta_tta,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header  d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Perilaku / Kondisi Berisiko - Potensi</h6>
                    <button type="button" class="btn btn-transparent p-0  opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content" wire:ignore>
                    @include('fieldleadership::livewire.dashboard.partials.chart', [
                        'idChart' => 'potency',
                        'labels' => null,
                        'datasets' => [
                            [
                                'label' => 'Potensi',
                                'backgroundColor' => '#009D50',
                                'hoverBackgroundColor' => '#D9DC30',
                                'data' => $potency,
                            ],
                        ],
                        'labelX' => [
                            'display' => true,
                            'color' => 'rgba(0,0,0,0.8)',
                            'beginAtZero' => true,
                        ],
                    ])
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>

    <livewire:fieldleadership::dashboard.partials.table-maker :year="$year" />
</div>

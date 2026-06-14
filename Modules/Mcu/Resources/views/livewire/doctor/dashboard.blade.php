<div class="container">
    <div class="row mb-3">

        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Data MCU Harian</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-bar', $dailyCart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Record MCU Tahunan</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-bar', $annualCart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Distribusi Hasil MCU</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-bar', $outcomeCart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Jumlah SKK Release</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-bar', $skkCart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Distribusi Index Massa Tubuh</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-pie', $imtChart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Distribusi Hipertensi Pekerja</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-pie', $hipertensiChart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Framingham Score Level</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-pie', $framinghamChart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
        <div class="col-6">
            <div class="chart-card bg-white border rounded-4 p-3">
                <div class="chart-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-normal">Jakarta Cardiovascular Score</h6>
                    <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                            class="fa-solid fa-ellipsis"></i></button>
                </div><!-- /.chart-header -->
                <div class="chart-content">
                    @livewire('chart.chart-pie', $jcChart)
                </div><!-- /.chart-content -->
            </div><!-- /.chart-card -->
        </div>
    </div>
</div>

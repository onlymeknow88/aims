<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Dashboard</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Field Leadership Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                                        class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content">
                                @include(
                                    'pica::livewire.dashboard.partials.chart-pie',
                                    $this->fieldLeadershipChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-3 -->

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Inspeksi KPLH Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                                        class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content">
                                @include('pica::livewire.dashboard.partials.chart-pie', $this->kplhChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-3 -->

                </div><!-- /.row -->

                <div class="row mb-4">


                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Audit Chart</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                                        class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content">
                                @include('pica::livewire.dashboard.partials.chart-pie', $this->auditChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-3 -->


                </div><!-- /.row -->

            </div><!-- /.container -->



        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

</div>

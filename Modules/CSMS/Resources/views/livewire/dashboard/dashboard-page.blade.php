<div id="app" class="inner-dashboard pb-1 m-0">

    <div class="p-4 mt-5 list-item-category csms">
        <div class="card-body">

            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 p-2">
                        <div class="card rounded-4 dougnut-class" style="align-items: center">
                            <div class="widget-title pt-2">
                                Persentase Evaluasi PJO
                            </div>
                            @livewire('csms::dashboard.widgets.dougnut', ['result' => $dataCsms])
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="card rounded-4 chart-class">
                            <div class="widget- pt-2 text-center">
                                Evaluasi PJO
                            </div>
                            @livewire('csms::dashboard.widgets.chart', ['result' => $dataCsms, 'idChart' => 'evaluatedPJO'])
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="card rounded-4 chart-class">
                            <div class="widget- pt-2 text-center">
                                Approved KTT
                            </div>
                            @livewire('csms::dashboard.widgets.chart', ['result' => $dataCsms, 'idChart' => 'approvedKTT'])
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="card rounded-4 chart-class">
                            <div class="widget- pt-2 text-center">
                                Post Bidding
                            </div>
                            @livewire('csms::dashboard.widgets.chart', ['result' => $dataCsms, 'idChart' => 'postBidding'])
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="card rounded-4 chart-class">
                            <div class="widget- pt-2 text-center">
                                Perpanjangan
                            </div>
                            @livewire('csms::dashboard.widgets.chart', ['result' => $dataCsms, 'idChart' => 'renewal'])
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="widget- pt-2 text-center">
                            Status Ijin Perusahaan
                        </div>
                        <div class="card rounded-4 chart-class">
                            @livewire('csms::dashboard.widgets.chart', ['result' => $dataCsms, 'idChart' => 'biddingValid'])
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6 p-2">
                        <div class="widget- pt-2 text-center">
                            Tingkat Resiko
                        </div>
                        <div class="card rounded-4 chart-class">
                            @livewire('csms::dashboard.widgets.chart3', ['result' => $dataCsms, 'idChart' => 'riskLevel'])
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12 p-2">
                        <div class="widget- pt-2 text-center">
                            PICA
                        </div>
                        <div class="card rounded-4 chart-class">
                            @livewire('csms::dashboard.widgets.chart3', ['result' => $dataCsms, 'idChart' => 'picaCount'])
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 p-2">
                        <div class="widget- pt-2 text-center">
                            Klasifikasi Kontraktor
                        </div>
                        <div class="card rounded-4 chart-class">
                            @livewire('csms::dashboard.widgets.chart4', ['result' => $dataCsms, 'idChart' => 'contractorClasification'])
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12 p-2">
                        <div class="widget- pt-2 text-center">
                            Kompetensi PJO
                        </div>
                        <div class="card rounded-4 chart-class">
                            @livewire('csms::dashboard.widgets.chart3', ['result' => $dataCsms, 'idChart' => 'spvStats'])
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

</div><!-- /.inner-dashboard -->

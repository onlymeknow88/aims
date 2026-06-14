<div class="inner-dashboard">

    <div class="section-content">
        <div class="section-title py-3 px-2">
            <div class="container">
                <div class="mb-3 row form-group">
                    <label for="department" class="col-sm-4 col-form-label">Document Type</label>
                    <div class="col-sm-8">
                        <form method="get">
                            <select name="document_type" onchange="this.form.submit()"
                                    placeholder="Select Document Type" class="form-select w-100">
                                <option value="">--ALL--</option>
                                @foreach(App\Enums\KPP\RuleDocumentType::toSelectArray() as $key => $value)
                                    <option
                                        value="{{ $key }}" {{ $key == ($_GET['document_type'] ?? '') ? 'selected' : ''}}>{{ $key }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.section-title -->

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Summary</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    <b>Patuh</b>
                                </h4>
                                <h1 class="card-text text-center mb-3">
                                    {{round($this->compliedTotal / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->compliedTotal}})
                                </h1>
                                <p class="card-text">
                                    {{round($this->peraturanComplied / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->peraturanComplied}}) <span class="text-muted">Kepatuhan</span>
                                    <br>
                                    {{round($this->perizinanComplied / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->perizinanComplied}}) <span class="text-muted">Perizinan</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    <b>Tidak Patuh</b>
                                </h4>
                                <h1 class="card-text text-center mb-3">
                                    {{round($this->notComplyTotal / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->notComplyTotal}})
                                </h1>
                                <p class="card-text">
                                    {{round($this->peraturanNotComply / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->peraturanNotComply}}) <span class="text-muted">Kepatuhan</span>
                                    <br>
                                    {{round($this->perizinanNotComply / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->perizinanNotComply}}) <span class="text-muted">Perizinan</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    <b>Tidak Berlaku</b>
                                </h4>
                                <h1 class="card-text text-center mb-3">
                                    {{round($this->notApplicableTotal / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->notApplicableTotal}})
                                </h1>
                                <p class="card-text">
                                    {{round($this->peraturanNotApplicable / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->peraturanNotApplicable}}) <span class="text-muted">Kepatuhan</span>
                                    <br>
                                    {{round($this->perizinanNotApplicable / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->perizinanNotApplicable}}) <span class="text-muted">Perizinan</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    <b>In Progress</b>
                                </h4>
                                <h1 class="card-text text-center mb-3">
                                    {{round($this->inProgressTotal / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->inProgressTotal}})
                                </h1>
                                <p class="card-text">
                                    {{round($this->peraturanInProgress / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->peraturanInProgress}}) <span class="text-muted">Kepatuhan</span>
                                    <br>
                                    {{round($this->perizinanInProgress / $this->extractionTotal * 100) ?? 0}}%
                                    ({{$this->perizinanInProgress}}) <span class="text-muted">Perizinan</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Compliance Level Chart</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Patuh</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                                        class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content" wire:ignore>
                                @include('kpp::livewire.dashboard.partials.chart-doughnut', $this->compliedChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-1 -->

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Tidak Patuh</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i
                                        class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content" wire:ignore>
                                @include('kpp::livewire.dashboard.partials.chart-doughnut', $this->notComplyChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-2 -->

                </div><!-- /.row -->

            </div><!-- /.container -->


        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="dashboard-main">

        <div class="table-rule">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">

                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">
                        <table border="1" class="table" style="height: fit-content">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Company</th>
                                <th>Total Ekstraksi</th>
                                <th>Patuh</th>
                                <th>Tidak Patuh</th>
                                <th>Tidak Berlaku</th>
                                <th>In Progress</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($this->companySummary as $key => $company)
                                <tr data-bs-toggle="collapse" data-bs-target=".parent{{$key}}" class="accordion-toggle">
                                    @php
                                        $total = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($company->id)->total_extraction;
                                        $patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($company->id)->patuh;
                                        $tidak_patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($company->id)->tidak_patuh;
                                        $tidak_berlaku = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($company->id)->tidak_berlaku;
                                        $in_progress = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($company->id)->in_progress;
                                    @endphp
                                    <td style="color: green"><i class="fas fa-chevron-down"></i></td>
                                    <td style="color: green">{{ $company->company_name }}</td>
                                    <td>{{ $total }}</td>
                                    <td>{{ $total != 0 ? round($patuh/$total*100 , 2) : 0 }}% ({{ $patuh }})</td>
                                    <td>{{ $total != 0 ? round($tidak_patuh/$total*100 , 2) : 0 }}% ({{ $tidak_patuh }})</td>
                                    <td>{{ $total != 0 ? round($tidak_berlaku/$total*100 , 2) : 0 }}% ({{ $tidak_berlaku }})</td>
                                    <td>{{ $total != 0 ? round($in_progress/$total*100 , 2) : 0 }}% ({{ $in_progress }})</td>
                                </tr>
                                @if($company->children)
                                @foreach($company->children as $key2 => $contractor)
                                    <tr data-bs-toggle="collapse" data-bs-target=".child{{$key2}}"
                                        class="accordion-toggle collapse parent{{$key}}">
                                        @php
                                            $total = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($contractor->id)->total_extraction;
                                            $patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($contractor->id)->patuh;
                                            $tidak_patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($contractor->id)->tidak_patuh;
                                            $tidak_berlaku = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($contractor->id)->tidak_berlaku;
                                            $in_progress = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($contractor->id)->in_progress;
                                        @endphp
                                        <td style="color: purple"><i class="fas fa-chevron-down"></i></td>
                                        <td style="color: purple">{{ $contractor->company_name }}</td>
                                        <td>{{ $total }}</td>
                                        <td>{{ $total != 0 ? round($patuh/$total*100 , 2) : 0 }}% ({{ $patuh }})</td>
                                        <td>{{ $total != 0 ? round($tidak_patuh/$total*100 , 2) : 0 }}% ({{ $tidak_patuh }})</td>
                                        <td>{{ $total != 0 ? round($tidak_berlaku/$total*100 , 2) : 0 }}% ({{ $tidak_berlaku }})</td>
                                        <td>{{ $total != 0 ? round($in_progress/$total*100 , 2) : 0 }}% ({{ $in_progress }})</td>
                                    </tr>
                                    @if($contractor->children)
                                    @foreach($contractor->children as $key3 => $subcontractor)
                                        <tr class="collapse child{{$key2}}">
                                            @php
                                            $total = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($subcontractor->id)->total_extraction;
                                            $patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($subcontractor->id)->patuh;
                                            $tidak_patuh = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($subcontractor->id)->tidak_patuh;
                                            $tidak_berlaku = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($subcontractor->id)->tidak_berlaku;
                                            $in_progress = (new \Modules\KPP\Entities\KppExtraction)->getCompanySummaryProperty($subcontractor->id)->in_progress;
                                            @endphp
                                            <td></td>
                                            <td style="color: maroon">{{ $subcontractor->company_name }}</td>
                                            <td>{{ $total }}</td>
                                            <td>{{ $total != 0 ? round($patuh/$total*100 , 2) : 0 }}% ({{ $patuh }})</td>
                                            <td>{{ $total != 0 ? round($tidak_patuh/$total*100 , 2) : 0 }}% ({{ $tidak_patuh }})</td>
                                            <td>{{ $total != 0 ? round($tidak_berlaku/$total*100 , 2) : 0 }}% ({{ $tidak_berlaku }})</td>
                                            <td>{{ $total != 0 ? round($in_progress/$total*100 , 2) : 0 }}% ({{ $in_progress }})</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                @endforeach
                                @endif
                            @endforeach
                            <!-- Add more parent rows with nested child rows as needed -->
                            </tbody>
                        </table>

                        {{--<div class="info" x-show="info">test</div>--}}

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div><!-- /.table-container -->

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->


    <div class="dashboard-main">

        <div class="table-rule">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">
                        @if ($countSelected > 0)
                            @can('KPP - Export Peraturan')
                                <a href="#" type="button"
                                   class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                   wire:click="exportExcel()">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/export.png') }}" alt="image export"></span>
                                    <span class="text-button">Export</span>
                                </a>
                            @endcan
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                               wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{ asset('images/icons/delete.png') }}" alt="image delete">
                                </span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                        <button
                            class="btn btn-outline-light button-toolbar d-flex text-white position-relative py-2 px-3 border-0"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon d-flex align-items-center">
                                <img src="{{ asset('images/icons/filter.png') }}" alt="image-filter">
                            </span>
                        </button>
                        <ul class="dropdown-menu" style="z-index: 9999;">
                            @foreach ($columns as $column)
                                <li class="ms-2">
                                    <input type="checkbox" wire:model="selectedColumns" value="{{ $column }}">
                                    <label>{{ $column }}</label>
                                </li>
                            @endforeach
                        </ul>

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                            <thead>
                            <tr>
                                <td rowspan="2"></td>
                                @if (in_array('Nomor Peraturan', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; white-space: normal">Nomor
                                        Peraturan
                                    </th>
                                    {{--<th rowspan="2" style="text-align: center; vertical-align: middle; white-space: normal">
                                        <div class="column-sort d-flex justify-content-between">
                                            <span>
                                                Nomor Peraturan
                                            </span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                        alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                        <div class="sort-search">
                                                            <div class="input-group">
                                                                <span class="input-group-text border-end-0"
                                                                    id="search-icon">
                                                                    <img src="{{ asset('images/icons/search.png') }}"
                                                                        alt="Search"
                                                                        srcset="{{ asset('images/icons/search.png') }}">
                                                                </span>
                                                                <input type="text" class="form-control"
                                                                    wire:model.1500ms="searchNumber"
                                                                    placeholder="Cari data" aria-label="Name"
                                                                    aria-describedby="search-icon">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--./dropdown-content-->

                                                </div><!-- /.dropdown-menu -->
                                            </span>
                                        </div>
                                    </th>--}}
                                @endif

                                @if (in_array('Judul Peraturan', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; white-space: normal">Judul
                                        Peraturan
                                    </th>
                                @endif

                                @if (in_array('Jenis Peraturan', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Jenis Peraturan
                                    </th>
                                    {{--<th rowspan="2" style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        <div class="column-sort d-flex justify-content-between">
                                            <span>
                                                Jenis Peraturan
                                            </span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                        alt="sorting" />
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                        <div
                                                            class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                            @foreach ($fieldType as $index => $item)
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault"
                                                                        wire:click="sortCheck('rule_type_id', '{{ $item->id }}')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">{{ $item->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    </th>--}}
                                @endif

                                @if (in_array('Otoritas Instansi', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Otoritas Instansi
                                                </span>
                                            <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                             alt="sorting"/>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldAgencyAuthority as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('agency_authority_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                        </div>
                                    </th>
                                @endif

                                @if (in_array('Status', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Status
                                                </span>
                                            <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                             alt="sorting"/>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Terdaftar')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Terdaftar</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Mengubah')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Mengubah</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Diubah')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Diubah</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Mencabut')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Mencabut</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Mencabut Sebagian')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Mencabut Sebagian</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('status', 'Dicabut')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">Dicabut</label>
                                                                    </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                        </div>
                                    </th>
                                @endif

                                @if (in_array('Kepatuhan', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Kepatuhan
                                    </th>
                                @endif

                                @if (in_array('Total Pasal', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Total Pasal
                                    </th>
                                @endif

                                @if (in_array('Total Ekstraksi', $selectedColumns))
                                    <th rowspan="2"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Total Ekstraksi
                                    </th>
                                @endif

                                @if (in_array('Status Kepatuhan', $selectedColumns))
                                    <th colspan="4" class="text-center"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Status Kepatuhan
                                    </th>
                                @endif

                                @if (in_array('Level Kepatuhan', $selectedColumns))
                                    <th colspan="5" class="text-center"
                                        style="text-align: center; vertical-align: middle; width: 100px; white-space: normal">
                                        Level Kepatuhan
                                    </th>
                                @endif
                            </tr>
                            <tr>
                                @if (in_array('Status Kepatuhan', $selectedColumns))
                                    <th>Patuh</th>
                                    <th>Tidak Patuh</th>
                                    <th>Tidak Berlaku</th>
                                    <th>In Progress</th>
                                @endif

                                @if (in_array('Level Kepatuhan', $selectedColumns))
                                    <th>N</th>
                                    <th>IA</th>
                                    <th>IIA</th>
                                    <th>IIIA</th>
                                    <th>IIIB</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $articleTotal = 0;
                                $extractionTotal = 0;
                                $compliedTotal = 0;
                                $notComplyTotal = 0;
                                $notApplicableTotal = 0;
                                $inProgressTotal = 0;
                                $N = 0;
                                $IA = 0;
                                $IIA = 0;
                                $IIIA = 0;
                                $IIIB = 0;
                            @endphp
                            @foreach ($this->rules as $itemIndex => $item)

                                <tr>
                                    <td></td>
                                    @if (in_array('Nomor Peraturan', $selectedColumns))
                                        <td scope="row">
                                            <a style="color: green; font-weight: bold"
                                               href="{{ route('kpp::rules.detail', ['id' => $item->id]) }}">
                                                {{ $item->number }}
                                            </a>
                                        </td>
                                    @endif
                                    @if (in_array('Judul Peraturan', $selectedColumns))
                                        <td style="min-width: 500px; white-space: normal">{{$item->title}}</td>
                                    @endif
                                    @if (in_array('Jenis Peraturan', $selectedColumns))
                                        <td>{{$item->ruleType->name ?? '-'}}</td>
                                    @endif
                                    @if (in_array('Otoritas Instansi', $selectedColumns))
                                        <td>{{$item->agencyAuthority->name ?? '-'}}</td>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <td>{{$item->status ?? '-'}}</td>
                                    @endif

                                    @if (in_array('Kepatuhan', $selectedColumns))
                                        <th class="text-center">{{$item->extractionTotal == ($item->compliedExtractionTotal + $item->notApplicableExtractionTotal) ? 'Patuh' : 'Tidak Patuh'}}</th>
                                    @endif

                                    @if (in_array('Total Pasal', $selectedColumns))
                                        @php
                                            $articleTotal = $articleTotal + $item->articleTotal;
                                        @endphp
                                        <td class="text-center">{{$item->articleTotal}}</td>
                                    @endif

                                    @if (in_array('Total Ekstraksi', $selectedColumns))
                                        @php
                                            $extractionTotal = $extractionTotal + $item->extractionTotal;
                                        @endphp
                                        <td class="text-center">{{$item->extractionTotal}}</td>
                                    @endif

                                    @if (in_array('Status Kepatuhan', $selectedColumns))
                                        @php
                                            $compliedTotal = $compliedTotal + $item->compliedExtractionTotal;
                                            $notComplyTotal = $notComplyTotal + $item->notComplyExtractionTotal;
                                            $notApplicableTotal = $notApplicableTotal + $item->notApplicableExtractionTotal;
                                            $inProgressTotal = $inProgressTotal + $item->inProgressExtractionTotal;
                                        @endphp
                                        <td class="text-center">{{$item->compliedExtractionTotal}}</td>
                                        <td class="text-center">{{$item->notComplyExtractionTotal}}</td>
                                        <td class="text-center">{{$item->notApplicableExtractionTotal}}</td>
                                        <td class="text-center">{{$item->inProgressExtractionTotal}}</td>
                                    @endif

                                    @if (in_array('Level Kepatuhan', $selectedColumns))
                                        @php
                                            $N = $N + $item->getComplianceLevelTotal('N');
                                            $IA = $IA + $item->getComplianceLevelTotal('IA');
                                            $IIA = $IIA + $item->getComplianceLevelTotal('IIA');
                                            $IIIA = $IIIA + $item->getComplianceLevelTotal('IIIA');
                                            $IIIB = $IIIB + $item->getComplianceLevelTotal('IIIB');
                                        @endphp
                                        <td class="text-center">{{$item->getComplianceLevelTotal('N')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIIA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIIB')}}</td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr>
                                <th class="text-center">Total:</th>
                                @if (in_array('Nomor Peraturan', $selectedColumns))
                                    <th>{{$this->rules->count()}}</th>
                                @endif
                                @if (in_array('Judul Peraturan', $selectedColumns))
                                    <th></th>
                                @endif
                                @if (in_array('Jenis Peraturan', $selectedColumns))
                                    <th></th>
                                @endif

                                @if (in_array('Kepatuhan', $selectedColumns))
                                    <th></th>
                                @endif


                                @if (in_array('Total Pasal', $selectedColumns))
                                    <th class="text-center">{{$articleTotal}}</th>
                                @endif
                                @if (in_array('Total Ekstraksi', $selectedColumns))
                                    <th class="text-center">{{$extractionTotal}}</th>
                                @endif
                                @if (in_array('Status Kepatuhan', $selectedColumns))
                                    <th class="text-center">{{$compliedTotal}}</th>
                                    <th class="text-center">{{$notComplyTotal}}</th>
                                    <th class="text-center">{{$notApplicableTotal}}</th>
                                    <th class="text-center">{{$inProgressTotal}}</th>
                                @endif
                                @if (in_array('Level Kepatuhan', $selectedColumns))
                                    <th class="text-center">{{$N}}</th>
                                    <th class="text-center">{{$IA}}</th>
                                    <th class="text-center">{{$IIA}}</th>
                                    <th class="text-center">{{$IIIA}}</th>
                                    <th class="text-center">{{$IIIB}}</th>
                                @endif
                            </tr>
                            </tbody>
                        </table>

                        {{--<div class="info" x-show="info">test</div>--}}

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div><!-- /.table-container -->

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    {{--<div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
        <div class="update-on opacity-80">{{ $latestUpdate }}</div>

        <div class="row-data opacity-80 d-flex gap-2 align-items-center">
            <span class="input-limit w-100px">
                <x-inputs.text wire:model="limit" id="limit" placeholder="0" value="{{ $limit }}"
                    :error="'limit'" />
            </span>
            <span>{!! __('of') !!}</span>
            <span class="font-medium">{{ $countData }}</span>
            <span>{!! __('Row Data') !!}</span>
        </div>

    </div><!-- /.section-footer -->--}}

    {{--<div class="section-footer d-flex justify-content-between">
        <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div>
    </div><!-- /.section-footer -->--}}

</div>

<script>
$(document).ready(function () {
  $('.accordion-toggle').click(function () {
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
    //$(this).nextUntil('.accordion-toggle').slideToggle(100);
  });
});
</script>

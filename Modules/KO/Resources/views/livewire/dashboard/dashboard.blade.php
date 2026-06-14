<div class="inner-dashboard">

{{--<div class="description mb-5">
    <div class="mb-3">
        <h5 class="fw-normal">Description</h5>
    </div>
    <div class="mb-3 row form-group">
        <div class="col-sm-12">
            <x-inputs.texteditor-custom wire:model.defer="desc" id="desc" :error="'desc'"/>
        </div>
    </div>
</div>

<button type="button" wire:click="save()" class="dropdown-item"
    href="#">
    Submit
</button>--}}

    {{--<div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Summary</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>Returned</b>
                                </h6>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->returnedCount / $this->proposalCount * 100) : 0 }}% ({{$this->returnedCount}})
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>Admin Check</b>
                                </h6>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->adminVerificationCount / $this->proposalCount * 100) : 0 }}% ({{$this->adminVerificationCount}})
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h7 class="card-title">
                                    <b>Coor Verification</b>
                                </h7>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->coordinatorVerificationCount / $this->proposalCount * 100) : 0 }}% ({{$this->coordinatorVerificationCount}})
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>Commissioning</b>
                                </h6>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->commissioningCount / $this->proposalCount * 100) : 0 }}% ({{$this->commissioningCount}})
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>Issue</b>
                                </h6>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->issueCount / $this->proposalCount * 100) : 0 }}% ({{$this->issueCount}})
                                </h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>Completed</b>
                                </h6>
                                <h1 class="card-text text-center">
                                    {{ $this->proposalCount !== 0 ? round($this->completedCount / $this->proposalCount * 100) : 0 }}% ({{$this->completedCount}})
                                </h1>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </div>--}}

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <div class="container">
                <h4>Categories Chart</h4>
            </div>
        </div><!-- /.section-title -->

        <div class="content p-3">

            <div class="container">

                <div class="row mb-4">

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Completed</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content" wire:ignore>
                                @include('ko::livewire.dashboard.partials.chart-doughnut', $this->completedChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-1 -->

                    <div class="col-6">

                        <div class="chart-card bg-white border rounded-4 p-3">

                            <div class="chart-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-normal">Issue</h6>
                                <button type="button" class="btn btn-transparent p-0 opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                            </div><!-- /.chart-header -->

                            <div class="chart-content" wire:ignore>
                                @include('ko::livewire.dashboard.partials.chart-doughnut', $this->issueChart)
                            </div><!-- /.chart-content -->

                        </div><!-- /.chart-card -->

                    </div><!-- /.col-2 -->

                </div><!-- /.row -->

            </div><!-- /.container -->



        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Keselamatan Operasional</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">


                    <div class="toolbar-left d-flex align-items-center">
                        @if ($countSelected > 0)
                            <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                        alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a> -->
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                        alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                        <div class="column-sort d-flex justify-content-between">
                            <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/icons/filter-top.svg') }}" alt="sorting" />
                                <span>Filter</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg">
                                <div class="dropdown-content p-3 d-flex gap-2 flex-column">

                                    <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                        @foreach ($columns as $column)
                                            <div class="form-check">
                                                <input class="form-check-input rounded-circle" type="checkbox"
                                                    id="flexCheckDefault" wire:model="selectedColumns"
                                                    value="{{ $column }}">
                                                <label class="form-check-label fw-normal" for="flexCheckDefault">
                                                    {{ $column }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div><!--./dropdown-content-->

                            </div><!-- /.dropdown-menu -->

                        </div><!-- /.column-sort -->

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">
                    <div class="table-wrapper overflow-auto">
                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr>
                                    @if (in_array('Number', $selectedColumns))
                                        <th>Number</th>
                                    @endif

                                    @if (in_array('CCOW', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    CCOW
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCcow as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('ccow_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Perusahaan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Perusahaan
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('company_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Kriteria Perusahaan', $selectedColumns))
                                        <th>Kriteria Perusahaan</th>
                                    @endif

                                    @if (in_array('Area', $selectedColumns))
                                        <th>Area</th>
                                    @endif

                                    @if (in_array('Waktu Komisioning', $selectedColumns))
                                        <th>Waktu Komisioning</th>
                                    @endif

                                    @if (in_array('Jadwal Komisioning', $selectedColumns))
                                        <th>Jadwal Komisioning</th>
                                    @endif

                                    @if (in_array('Komisioning Selanjutnya', $selectedColumns))
                                        <th>Komisioning Selanjutnya</th>
                                    @endif

                                    @if (in_array('Periode', $selectedColumns))
                                        <th>Periode</th>
                                    @endif
                                
                                    @if (in_array('SPIP Desc', $selectedColumns))
                                        <th>SPIP Desc</th>
                                    @endif

                                    @if (in_array('Call Sign', $selectedColumns))
                                        <th>Call Sign</th>
                                    @endif

                                    @if (in_array('Status', $selectedColumns))
                                        <th>Status</th>
                                    @endif

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->koProposals as $itemIndex => $item)
                                    <tr>
                                        @if (in_array('Number', $selectedColumns))
                                            <td scope="row">
                                                <a style="color: green; font-weight: bold" href="{{ route('ko::ko.show', $item->id) }}">
                                                    {{ $item->number }}
                                                </a>
                                            </td>
                                        @endif

                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>{{ $item->ccow->company_name }}</td>
                                        @endif

                                        @if (in_array('Perusahaan', $selectedColumns))
                                            <td>{{ $item->company->company_name }}</td>
                                        @endif

                                        @if (in_array('Kriteria Perusahaan', $selectedColumns))
                                            <td>{{ $item->company->type }}</td>
                                        @endif

                                        @if (in_array('Area', $selectedColumns))
                                            <td>{{ $item->area }}</td>
                                        @endif

                                        @if (in_array('Waktu Komisioning', $selectedColumns))
                                            <td>
                                                {{ $item->koCommissioning ? date("d-m-Y", strtotime($item->koCommissioning->created_at)) : '-' }}
                                            </td>
                                        @endif

                                        @if (in_array('Jadwal Komisioning', $selectedColumns))
                                            <td>
                                                {{ $item->internal_komisioning_schedule ?? '-' }}
                                            </td>
                                        @endif

                                        @if (in_array('Komisioning Selanjutnya', $selectedColumns))
                                            <td>
                                                {{ $item->next_commissioning ?? '-' }}
                                            </td>
                                        @endif

                                        @if (in_array('Periode', $selectedColumns))
                                            <td>{{ $item->commissioning_period }}</td>
                                        @endif

                                        @if (in_array('SPIP Desc', $selectedColumns))
                                            <td>{{ $item->koUnit->koSpipUnit->name }}</td>
                                        @endif

                                        @if (in_array('Call Sign', $selectedColumns))
                                            <td>{{ $item->koUnit->call_sign }}</td>
                                        @endif

                                        @if (in_array('Ayat', $selectedColumns))
                                            <td>{{ $item->sub_section }}</td>
                                        @endif

                                        @if (in_array('Status', $selectedColumns))
                                            <td>{{ $item->status }}</td>
                                        @endif

                                        @if (in_array('Date Created', $selectedColumns))
                                            <td>{{ Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    <!-- <div class="info" x-show="info">test</div> -->
                    </div><!-- /.table-content-->
                </div>

            </div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

</div>




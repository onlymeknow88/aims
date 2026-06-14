<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Obsolete Peraturan</h4>
        </div><!-- /.section-title -->

        <div class="table-rule">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">
                        @can('KPP - Create Peraturan')
                            <a href="{{ route('kpp::rules.create') }}" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                <span class="icon d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                      </svg>                      
                                </span>
                                <span class="text-button">Add New</span>
                            </a>
                        @endcan
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

                        <table class="table" style="height: fit-content" x-data="unCheck">
                            <thead>
                                <tr>
                                    @if (in_array('Nomor Peraturan', $selectedColumns))
                                        <th style="vertical-align: middle;" rowspan="2">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                    <span>
                                                        Nomor Peraturan
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        wire:click="removeItemFilter('searchNumber')">
                                                                        Hapus Filter
                                                                    </a>
                                                                </div>

                                                                <div class="sort-search">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text border-end-0"
                                                                            id="search-icon">
                                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                                alt="Search"
                                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                                        </span>
                                                                        <input type="text" class="form-control" wire:model.1500ms="searchNumber" placeholder="Cari data" aria-label="Name" aria-describedby="search-icon">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                    @endif
                                    
                                    @if (in_array('Judul Peraturan', $selectedColumns))
                                        <th style="vertical-align: middle; text-align: center" rowspan="2">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                    <span>
                                                        Judul Peraturan
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchTitle) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                                
                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        wire:click="removeItemFilter('searchTitle')">
                                                                        Hapus Filter
                                                                    </a>
                                                                </div>

                                                                <div class="sort-search">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text border-end-0"
                                                                            id="search-icon">
                                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                                alt="Search"
                                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                                        </span>
                                                                        <input type="text" class="form-control" wire:model.1500ms="searchTitle" placeholder="Cari data" aria-label="Name" aria-describedby="search-icon">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Jenis Peraturan', $selectedColumns))
                                        <th style="vertical-align:middle; width: 100px;" rowspan="2">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                    <span>
                                                        Jenis Peraturan
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['rule_type_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}" alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('rule_type_id')"
                                                                        wire:click="removeItemFilter('rule_type_id')">
                                                                        Hapus Filter
                                                                    </a>
                                                                </div>

                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    @foreach ($fieldType as $index => $item)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input rounded-circle"
                                                                                type="checkbox" value=""
                                                                                id="rule_type_id"
                                                                                wire:click="sortCheck('rule_type_id', '{{ $item->id }}')">
                                                                            <label class="form-check-label fw-normal" for="flexCheckDefault">{{ $item->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Otoritas Instansi', $selectedColumns))
                                        <th rowspan="2" style="vertical-align:middle; width: 100px;" rowspan="2">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                    <span>
                                                        Otoritas Instansi
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['agency_authority_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}" alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>
                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('agency_authority_id')"
                                                                        wire:click="removeItemFilter('agency_authority_id')">
                                                                        Hapus Filter
                                                                    </a>
                                                                </div>

                                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    @foreach ($fieldAgencyAuthority as $index => $item)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input rounded-circle"
                                                                                type="checkbox" value=""
                                                                                id="agency_authority_id"
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
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Status', $selectedColumns))
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                    <span>
                                                        Status
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['status']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}" alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('status')"
                                                                        wire:click="removeItemFilter('status')">
                                                                        Hapus Filter
                                                                    </a>
                                                                </div>

                                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Terdaftar')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Terdaftar</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Mengubah')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Mengubah</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Diubah')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Diubah</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Mencabut')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Mencabut</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Mencabut Sebagian')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Mencabut Sebagian</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Dicabut')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Dicabut</label>
                                                                    </div>

                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="status"
                                                                            wire:click="sortCheck('status', 'Dicabut Sebagian')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">Dicabut Sebagian</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Document Type', $selectedColumns))
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 100px;">
                                            <div class="column-sort d-flex justify-content-between">
                                                <div class="column-sort d-flex justify-content-between gap-5">
                                                <span>
                                                    Document Type
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['document_type']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}" alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('document_type')"
                                                                    wire:click="removeItemFilter('document_type')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="document_type"
                                                                        wire:click="sortCheck('document_type', 'OHS')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">OHS</label>
                                                                </div>

                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="document_type"
                                                                        wire:click="sortCheck('document_type', 'ENV')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">ENV</label>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Kepatuhan', $selectedColumns))
                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Kepatuhan</th>
                                    @endif

                                    @if (in_array('Total Ekstraksi', $selectedColumns))
                                        <th style="text-align: center; vertical-align: middle; width: 100px; white-space: normal" rowspan="2">Total Ekstraksi</th>
                                    @endif

                                    @if (in_array('Compliance Status', $selectedColumns))
                                        <th colspan="4" class="text-center">Compliance Status</th>
                                    @endif

                                    @if (in_array('Compliance Level', $selectedColumns))    
                                        <th colspan="5" class="text-center">Compliance Level</th>
                                    @endif
                                </tr>
                                <tr>
                                    @if (in_array('Compliance Status', $selectedColumns))
                                        <th>Complied</th>
                                        <th>Not Comply</th>
                                        <th>Not Applicable</th>
                                        <th>In Progress</th>
                                    @endif

                                    @if (in_array('Compliance Level', $selectedColumns))
                                        <th>N</th>
                                        <th>IA</th>
                                        <th>IIA</th>
                                        <th>IIIA</th>
                                        <th>IIIB</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($this->rules as $itemIndex => $item)

                                <tr>
                                    @if (in_array('Nomor Peraturan', $selectedColumns))
                                        <td scope="row">
                                            <a style="color: green; font-weight: bold" href="{{ route('kpp::rules.edit', ['id' => $item->id]) }}">
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
                                        <td style="width: 150px; white-space: normal">{{$item->status ?? '-'}}</td>
                                    @endif
                                    @if (in_array('Document Type', $selectedColumns))
                                        <td>{{$item->document_type ?? '-'}}</td>
                                    @endif
                                    @if (in_array('Kepatuhan', $selectedColumns))
                                        <td>
                                            @if($item->obediences->count() > 0)
                                                @foreach($item->obediences as $obedience)
                                                    - {{$obedience->company->company_name ?? '~'}}<br>
                                                @endforeach
                                            @else
                                                
                                            @endif
                                        </td>
                                    @endif

                                    @if (in_array('Total Ekstraksi', $selectedColumns))
                                        <td class="text-center">{{$item->extractionTotal}}</td>
                                    @endif

                                    @if (in_array('Compliance Status', $selectedColumns))
                                        <td class="text-center">{{$item->compliedExtractionTotal}}</td>
                                        <td class="text-center">{{$item->notComplyExtractionTotal}}</td>
                                        <td class="text-center">{{$item->notApplicableExtractionTotal}}</td>
                                        <td class="text-center">{{$item->inProgressExtractionTotal}}</td>
                                    @endif

                                    @if (in_array('Compliance Level', $selectedColumns))
                                        <td class="text-center">{{$item->getComplianceLevelTotal('N')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIIA')}}</td>
                                        <td class="text-center">{{$item->getComplianceLevelTotal('IIIB')}}</td>
                                    @endif
                                </tr>

                            @endforeach
                            </tbody>
                        </table>

                        {{--<div class="info" x-show="info">test</div>--}}
                    
                    </div>

                </div><!-- /.table-content-->

            </div><!-- /.table-container -->

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
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

    </div><!-- /.section-footer -->

    {{--<div class="section-footer d-flex justify-content-between">
        <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div>
    </div><!-- /.section-footer -->--}}

</div>
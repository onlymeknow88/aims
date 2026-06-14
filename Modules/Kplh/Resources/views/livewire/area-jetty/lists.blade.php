<div class="inner-content">
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Data Inspeksi Area Jetty</h4>
        </div><!-- /.section-title -->

        <div class="content-inspeksi">
            <div x-data="{ itemSelected: @entangle('itemSelected') }">


                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @if ($countSelected == 0)
                            @can('KPLH - Create K3')
                                <a href="{{ route('kplh::add-area-jetty') }}" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    <span class="text-button">Add New</span>
                                </a>
                            @endcan
                        @endif

                        @if ($countSelected > 0)
                            @if ($countSelected == 1)

                                @can('KPLH - View Detail K3')
                                    <a href="{{ route('kplh::detail', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <i class="fa fa-eye"></i>
                                        <span class="text-button">Detail</span>
                                    </a>
                                @endcan

                                @if ($status == 'draft')
                                    @can('KPLH - Edit K3')
                                        <a href="{{ route('kplh::edit-' . $criteria . '', $idSelected) }}" type="button"
                                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                            <span class="icon d-flex align-items-center"><img
                                                    src="{{ asset('images/icons/pencil.png') }}" alt="image edit"></span>
                                            <span class="text-button">Edit</span>
                                        </a>
                                    @endcan

                                    @can('KPLH - Delete K3')
                                        <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                            wire:click="$emit('delete-data')">
                                            <span class="icon d-flex align-items-center">
                                                <img src="{{ asset('/images/icons/trash.png') }}" alt="Icon Delete">
                                            </span>
                                            <span class="text-button">Delete</span>
                                        </a>
                                    @endcan
                                @endif
                            @endif
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/delete.png') }}" alt="image delete"></span>
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
                            @foreach ($columns as $index => $column)
                                <li class="ms-2">
                                    <input type="checkbox" wire:model="selectedColumns"
                                        id="selectedColumns_{{ $index }}" value="{{ $column }}">
                                    <label for="selectedColumns_{{ $index }}">{{ $column }}</label>
                                </li>
                            @endforeach
                        </ul>

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table table-bordered align-items-center table-sm">
                            <thead class="sticky-top z-index-10">
                                <tr>
                                    <th class="sticky-top"></th>

                                    @if (in_array('Nomor Identitas', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>Nomor Identitas</span>
                                            </div><!-- /.column-sort -->
                                        </th>
                                    @endif

                                    @if (in_array('Tanggal Inspeksi', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Tanggal Inspeksi
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <x-inputs.datepicker
                                                                        wire:model.1500ms="filterTanggalInspeksi"
                                                                        placeholder="Tanggal Awal"
                                                                        aria-describedby="search-icon"
                                                                        id="filterTanggalInspeksi" />
                                                                </div>
                                                                <center>Sampai</center>
                                                                <div class="input-group">
                                                                    <x-inputs.datepicker
                                                                        wire:model.1500ms="filterTanggalInspeksi2"
                                                                        placeholder="Tanggal Akhir"
                                                                        aria-describedby="search-icon"
                                                                        id="filterTanggalInspeksi2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
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
                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchCcow" id="searchCcow"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCcow as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox"
                                                                            id="CheckBoxInspectCcowId_{{ $index }}"
                                                                            wire:click="sortCheck('ccow_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCcowId_{{ $index }}">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Departemen', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Departemen
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchDepartemen"
                                                                        id="searchDepartemen" placeholder="Cari data"
                                                                        aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldDepartemen as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox"
                                                                            id="CheckBoxInspectDepartmentId_{{ $index }}"
                                                                            wire:click="sortCheck('department_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectDepartmentId_{{ $index }}">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Section', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Section
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchSection"
                                                                        id="searchSection" placeholder="Cari data"
                                                                        aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldSection as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox"
                                                                            id="CheckBoxInspectSectionId_{{ $index }}"
                                                                            wire:click="sortCheck('section_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectSectionId_{{ $index }}">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Lokasi', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Lokasi
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchLokasi"
                                                                        id="searchLokasi" placeholder="Cari data"
                                                                        aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldLokasi as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox"
                                                                            id="CheckBoxInspectAreaLocationId_{{ $index }}"
                                                                            wire:click="sortCheck('area_location_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectAreaLocationId_{{ $index }}">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Detail Lokasi', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Lokasi
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchDetailLokasi"
                                                                        id="searchDetailLokasi"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('KTT', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    KTT
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchKTT" id="searchKTT"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            {{-- <div
                                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                                    @foreach ($fieldCcow as $index => $item)
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input rounded-circle"
                                                                                                type="checkbox"
                                                                                                id="CheckBoxInspectCompanyId"
                                                                                                wire:click="sortCheck('ccow_id', '{{ $item->id }}')">
                                                                                            <label class="form-check-label fw-normal"
                                                                                                for="CheckBoxInspectCompanyId">{{ $item->company_name }}</label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div> --}}

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('PJA', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    PJA
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
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
                                                                        wire:model.1500ms="searchPJA" id="searchPJA"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Keterangan Temuan', $selectedColumns))
                                        <th class="sticky-top">
                                            Keterangan Temuan
                                        </th>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Status
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
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus1"
                                                                        wire:click="sortCheck('status', 'draft')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus1">Draft</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus2"
                                                                        wire:click="sortCheck('status', 'active')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus2">Active</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus3"
                                                                        wire:click="sortCheck('status', 'approved')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus3">Approved</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->LabelListings as $itemIndex => $items)
                                    <tr wire:key="'{{ $itemIndex }}'"
                                        wire:click="onSelectedItem('{{ $items['id'] }}')">
                                        <td class="td-check">
                                            @if (in_array($items['id'], $itemSelected))
                                                <span class="icon-checked selected"></span>
                                            @else
                                                <span class="icon-checked"></span>
                                            @endif
                                        </td>

                                        @if (in_array('Nomor Identitas', $selectedColumns))
                                            <td>
                                                <a href="{{ route('kplh::detail', $items->id) }}"
                                                    style="font-weight: 600; color: #00552f;">
                                                    {{ $items->inspect_id }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Tanggal Inspeksi', $selectedColumns))
                                            <td>
                                                {{ \Carbon\Carbon::parse($items->date)->format('d M Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('Jenis Inspeksi', $selectedColumns))
                                            <td>
                                                @isset($items->inspect_criteria)
                                                    {{ $items->inspect_criteria }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>
                                                @isset($items->ccow->company_name)
                                                    {{ $items->ccow->company_name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Departemen', $selectedColumns))
                                            <td>
                                                @isset($items->department->name)
                                                    {{ $items->department->name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Section', $selectedColumns))
                                            <td>
                                                @isset($items->section->name)
                                                    {{ $items->section->name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Lokasi', $selectedColumns))
                                            <td>
                                                @isset($items->areaLocation->name)
                                                    {{ $items->areaLocation->name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Detail Lokasi', $selectedColumns))
                                            <td>
                                                @isset($items->location_detail)
                                                    {{ $items->location_detail }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('KTT', $selectedColumns))
                                            <td>
                                                @isset($items->ktt->name)
                                                    {{ $items->ktt->name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('PJA', $selectedColumns))
                                            <td>
                                                @isset($items->pja->user->name)
                                                    {{ $items->pja->user->name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Keterangan Temuan', $selectedColumns))
                                            <td><small>{!! $items->summary !!}</small></td>
                                        @endif
                                        @if (in_array('Status', $selectedColumns))
                                            <td>
                                                <button type="button"
                                                    class="btn {{ $items->status == 'draft' ? 'btn-warning' : ($items->status == 'approved' ? 'btn-success' : 'btn-primary') }}">
                                                    {{ $items->status }}
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div><!-- /.item-selected -->

        </div><!-- /.content-inspeksi -->

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
            <span>{!! __('Inspeksi') !!}</span>
        </div>

    </div><!-- /.section-footer -->
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('delete-data', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin akan menghapus data ini?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {

                    if (result.value) {

                        @this.call('delete')

                    }

                });
            });
        });
    </script>
@endpush

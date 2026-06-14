<div>
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Inactive - Active</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">
            <div x-data="{ itemSelected: @entangle('itemSelected') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">

                        {{-- @can('KPLH - Create K3') --}}
                            <div class="new-wrapper">
                                <a href="{{ route('csms::inactive.create') }}" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                    <span class="icon d-flex align-items-center">
                                        <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                                    </span>
                                    <span class="text-button">Add New</span>
                                </a>
                            </div>
                        {{-- @endcan --}}

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
                                            wire:click="$emit('remove-item')">
                                            <span class="icon d-flex align-items-center">
                                                <img src="{{ asset('/images/icons/delete-top.svg') }}" alt="image Delete">
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
                                        src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
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

                    <div class="table-wrapper">

                        <table class="table overflow-auto">
                            <thead>
                                <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                    <th class="sticky-top" wire:click="toggleSelectAll">
                                        <span class="icon-checked"></span>
                                    </th>

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

                                    @if (in_array('Jenis Badan Usaha', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Jenis Badan Usaha
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

                                    @if (in_array('Nama Perusahaan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Nama Perusahaan
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
                                                                        wire:model.1500ms="searchJenisInspeksi"
                                                                        id="searchJenisInspeksi"
                                                                        placeholder="Cari data"
                                                                        aria-label="Nama Perusahaan"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                                @can('KPLH - View List Food Hygiene')
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria6"
                                                                            wire:click="sortCheck('inspect_criteria', 'food-hygiene')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria6">Food
                                                                            Hygiene</label>
                                                                    </div>
                                                                @endcan

                                                                @can('KPLH - View List Workplace')
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria7"
                                                                            wire:click="sortCheck('inspect_criteria', 'workplace')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria7">Tempat Kerja
                                                                            Mingguan</label>
                                                                    </div>
                                                                @endcan

                                                                @can('KPLH - View List Area Maintank')
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria8"
                                                                            wire:click="sortCheck('inspect_criteria', 'area-maintank')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria8">Area
                                                                            Maintank</label>
                                                                    </div>
                                                                @endcan

                                                                @can('KPLH - View List Area Jetty')
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria9"
                                                                            wire:click="sortCheck('inspect_criteria', 'area-jetty')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria9">Area
                                                                            Jetty</label>
                                                                    </div>
                                                                @endcan

                                                                @can('KPLH - View List K3')
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria1"
                                                                            wire:click="sortCheck('inspect_criteria', 'k3-apar')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria1">K3 APAR</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria2"
                                                                            wire:click="sortCheck('inspect_criteria', 'k3-apab')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria2">K3 APAB</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria3"
                                                                            wire:click="sortCheck('inspect_criteria', 'k3-hydrant')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria3">K3
                                                                            Hydrant</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria4"
                                                                            wire:click="sortCheck('inspect_criteria', 'k3-hose-rail')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria4">K3 Hose
                                                                            Rail</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" id="CheckBoxInspectCriteria5"
                                                                            wire:click="sortCheck('inspect_criteria', 'k3-eye-wash')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCriteria5">K3 Eye
                                                                            Wash</label>
                                                                    </div>
                                                                @endcan
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @if (in_array('Alamat Perusahaan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Alamat Perusahaan
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

                                    @if (in_array('Site Perusahaan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Site Perusahaan
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

                                    @if (in_array('Nomor Ijin Badan Usaha', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Nomor Ijin Badan Usaha
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

                                    @if (in_array('Perusahaan Induk', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Perusahaan Induk
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

                                    @if (in_array('Nama Penanggung Jawab Bidder', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Nama Penanggung Jawab Bidder
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->LabelListings as $itemIndex => $items)
                                    <tr wire:key="{{ $itemIndex }}"
                                        wire:click="onSelectedItem('{{ $items->id }}')"
                                        @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>

                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>
                                                @isset($items->ccow->company_name)
                                                    {{ $items->ccow->company_name }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Jenis Badan Usaha', $selectedColumns))
                                            <td>
                                                {{ \Carbon\Carbon::parse($items->date)->format('d M Y') }}
                                            </td>
                                        @endif

                                        @if (in_array('Nama Perusahaan', $selectedColumns))
                                            <td>
                                                @isset($items->inspect_criteria)
                                                    {{ $items->inspect_criteria }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Alamat Perusahaan', $selectedColumns))
                                            <td>
                                                @isset($items->department->name)
                                                    {{ $items->department->name }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Site Perusahaan', $selectedColumns))
                                            <td>
                                                @isset($items->section->name)
                                                    {{ $items->section->name }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Nomor Ijin Badan Usaha', $selectedColumns))
                                            <td>
                                                @isset($items->areaLocation->name)
                                                    {{ $items->areaLocation->name }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Perusahaan Induk', $selectedColumns))
                                            <td>
                                                @isset($items->location_detail)
                                                    {{ $items->location_detail }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Nama Penanggung Jawab Bidder', $selectedColumns))
                                            <td>
                                                @isset($items->ktt->name)
                                                    {{ $items->ktt->name }}
                                                @endisset
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

    <div class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px px-3">
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

            @this.on('remove-item', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin akan menghapus data ini?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {

                    if (result.value) {

                        @this.call('removeItem')

                    }

                });
            });
        });
    </script>
@endpush

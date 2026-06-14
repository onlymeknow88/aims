<div class="inner-content">
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>List Approval Data Inspeksi</h4>
        </div><!-- /.section-title -->

        <div class="content-inspeksi">
            <div x-data="{ itemSelected: @entangle('itemSelected') }">


                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @if ($countSelected > 0)
                            @if ($countSelected == 1)
                                @can('KPLH - View Detail K3')
                                    <a href="{{ route('kplh::detail', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <i class="fa fa-eye"></i>
                                        <span class="text-button">Detail</span>
                                    </a>
                                @endcan
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

                        <table class="table table-bordered align-items-center table-sm">
                            <thead class="sticky-top z-index-10">
                                <tr>
                                    {{-- <th class="sticky-top"></th> --}}

                                    @if (in_array('Nomor Identitas', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>Nomor Identitas</span>

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
                                                                        wire:model.1500ms="searchIDInspeksi"
                                                                        id="searchIDInspeksi" placeholder="Cari data"
                                                                        aria-label="Jenis Inspeksi"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
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
                                                        <img src="{{ asset('images/icons/filter-default.svg') }}"
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

                                    @if (in_array('Jenis Inspeksi', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Jenis Inspeksi
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
                                    @if (in_array('KTT/PJO', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    KTT/PJO
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
                                                        <img src="{{ asset('images/icons/filter-default.svg') }}"
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
                                                                        for="CheckBoxInspectStatus2">Waiting
                                                                        Approval</label>
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
                                    @if (in_array('Pica Status', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Pica Status
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
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxPicaStatus1"
                                                                        wire:click="sortCheck('pica_status', 'Open')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxPicaStatus1">Open</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxPicaStatus2"
                                                                        wire:click="sortCheck('pica_status', 'Overdue')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxPicaStatus2">Overdue</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxPicaStatus3"
                                                                        wire:click="sortCheck('pica_status', 'Closed')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxPicaStatus3">Closed</label>
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
                                    <tr>
                                        {{-- <tr wire:key="'{{ $itemIndex }}'"
                                        wire:click="onSelectedItem('{{ $items['id'] }}')"
                                        @if (in_array($items['id'], $itemSelected)) class="selected"
                                    @else
                                        class="tr" @endif"> --}}

                                        {{-- <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td> --}}

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
                                        @if (in_array('KTT/PJO', $selectedColumns))
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
                                                <span
                                                    class="badge {{ $items->status == 'draft' ? 'pending' : ($items->status == 'approved' ? 'done' : 'default') }}">
                                                    @if ($items->status == 'draft')
                                                        Draft
                                                    @elseif ($items->status == 'active')
                                                        Waiting Approval
                                                    @else
                                                        Approved
                                                    @endif

                                                </span>
                                            </td>
                                        @endif
                                        @if (in_array('Pica Status', $selectedColumns))
                                            <td>
                                                <span
                                                    class="badge {{ $items->pica_status == 'Open' ? 'pending' : ($items->pica_status == 'closed' ? 'done' : 'cancel') }}">
                                                    {{ $items->pica_status ? $items->pica_status : '-'  }}
                                                </span>

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

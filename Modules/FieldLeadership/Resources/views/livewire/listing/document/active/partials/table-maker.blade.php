<div>
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Field Leadership</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

        <div x-data="{
                selectedIds: [],
                get countSelected() { return this.selectedIds.length; },
                get editUrl() {
                    if (this.selectedIds.length === 1) {
                        return '{{ url('field-leadership/listing/active/edit') }}/' + this.selectedIds[0];
                    }
                    return '#';
                },
                init() {
                    // Sync Alpine selectedIds setiap kali PHP toggleSelectAll dipanggil
                    window.addEventListener('fl-sync-selection', (e) => {
                        this.selectedIds = e.detail.ids ?? [];
                    });
                },
                toggleRow(id) {
                    const idx = this.selectedIds.indexOf(id);
                    if (idx === -1) {
                        this.selectedIds.push(id);
                    } else {
                        this.selectedIds.splice(idx, 1);
                    }
                },
                isSelected(id) {
                    return this.selectedIds.includes(id);
                },
                syncToWire() {
                    $wire.set('itemSelected', this.selectedIds);
                    $wire.set('countSelected', this.selectedIds.length);
                },
                clearSelection() {
                    this.selectedIds = [];
                    $wire.call('removeSeleced');
                }
            }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">

                        <a href="{{ route('field-leadership::listing.active.create') }}" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                            <span class="icon d-flex align-items-center">
                                <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                            </span>
                            <span class="text-button">Add New</span>
                        </a>

                        <a type="button" data-bs-toggle="modal" data-bs-target="#importModal"
                            class="button-toolbar btn-outline d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center">
                                <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                            </span>
                            <span class="text-button">Import File</span>
                        </a>

                        <template x-if="selectedIds.length > 0">
                            <div class="d-flex gap-2 align-items-center">
                                <a href="#" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    @click.prevent="syncToWire(); $nextTick(() => $wire.call('exportExcel'))">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/export-top.svg') }}" alt="image export"></span>
                                    <span class="text-button">Export</span>
                                </a>

                                <a href="#" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    @click.prevent="syncToWire(); $nextTick(() => Livewire.emit('remove-item'))">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                                    <span class="text-button">Delete</span>
                                </a>
                            </div>
                        </template>

                        <template x-if="selectedIds.length === 1">
                            <a :href="editUrl" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/pencil.png') }}" alt="image edit"></span>
                                <span class="text-button">Edit</span>
                            </a>
                        </template>
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        <template x-if="selectedIds.length > 0">
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                @click.prevent="clearSelection()">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                                <span class="text-button"><span x-text="selectedIds.length"></span> Row Selected</span>
                            </a>
                        </template>

                        <div class="column-sort d-flex justify-content-between">
                            <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/icons/filter-top.svg') }}" alt="sorting" />
                                <span>Filter</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>
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

                        <table class="table overflow-auto" x-data="unCheck">
                            <thead>
                                <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                    <th class="sticky-top" wire:click="toggleSelectAll">
                                        <span class="icon-checked"></span>
                                    </th>
                                    @if (in_array('Company', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Company
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchCompany) || (!empty($this->sortSelected) && isset($this->sortSelected['company_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('company_id')"
                                                                    wire:click="removeItemFilter('company_id')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchCompany"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="company_id"
                                                                            wire:click="sortCheck('company_id', '{{ $item->id }}')"
                                                                            @if (in_array($item->id, $this->sortSelected)) checked @endif>
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->company_name }}</label>
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
                                    @if (in_array('Date', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Date
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->startDate) && !empty($this->endDate) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('date')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-search">

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center">
                                                                    Dari
                                                                </span>
                                                                <x-inputs.datepicker wire:model="startDate"
                                                                    id="startDate" :error="'startDate'"
                                                                    placeholder="Select Date" />

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center mt-2">
                                                                    Sampai
                                                                </span>
                                                                <x-inputs.datepicker wire:model="endDate"
                                                                    id="endDate" :error="'endDate'"
                                                                    placeholder="Select Date" />

                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('CCOW', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    CCOW
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchCcow) || (!empty($this->sortSelected) && isset($this->sortSelected['ccow_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('ccow_id')"
                                                                    wire:click="removeItemFilter('ccow_id')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchCcow"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCcow as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="ccow_id"
                                                                            wire:click="sortCheck('ccow_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->company_name }}</label>
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
                                    @if (in_array('Detail Company', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Company
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['detail_company']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('detail_company')"
                                                                    wire:click="removeItemFilter('detail_company')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldDetailCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="detail_company"
                                                                            wire:click="sortCheck('detail_company', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $index }}</label>
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
                                    @if (in_array('Department', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Department
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchDepartment) || (!empty($this->sortSelected) && isset($this->sortSelected['department_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('department_id')"
                                                                    wire:click="removeItemFilter('department_id')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchDepartment"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldDepartment as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="department_id"
                                                                            wire:click="sortCheck('department_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
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
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Section
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchSection) || (!empty($this->sortSelected) && isset($this->sortSelected['section_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('section_id')"
                                                                    wire:click="removeItemFilter('section_id')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchSection"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldSection as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="section_id"
                                                                            wire:click="sortCheck('section_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
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
                                    @if (in_array('Location', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Location
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchLocation) || (!empty($this->sortSelected) && isset($this->sortSelected['area_location_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('area_location_id')"
                                                                    wire:click="removeItemFilter('area_location_id')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchLocation"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldLocation as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="area_location_id"
                                                                            wire:click="sortCheck('area_location_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
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
                                    @if (in_array('Detail Location', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Location
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchDetailLocation) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('detail_location')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchDetailLocation"
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
                                    @if (in_array('Type', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Type
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['type']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('type')"
                                                                    wire:click="removeItemFilter('type')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldType as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="type"
                                                                            wire:click="sortCheck('type', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $index }}</label>
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
                                    @if (in_array('Members', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Member
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchMember) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('member')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchMember"
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
                                    @if (in_array('Positive Condition', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Positive Condition
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchPositive) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('positive')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchPositive"
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
                                    @if (in_array('Risk Condition', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Risk Condition
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchRiskCondition) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('risk_condition')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchRiskCondition"
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
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Category
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchCategory) || (!empty($this->sortSelected) && isset($this->sortSelected['category'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('category')"
                                                                    wire:click="removeItemFilter('category')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchCategory"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCategory as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="category"
                                                                            wire:click="sortCheck('category', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Condition Type
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchConditionType) || (!empty($this->sortSelected) && isset($this->sortSelected['conditionType'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('condition_type')"
                                                                    wire:click="removeItemFilter('condition_type')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchconditionType"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldConditionType as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="condition_type"
                                                                            wire:click="sortCheck('conditionType', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Potency
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchPotency) || (!empty($this->sortSelected) && isset($this->sortSelected['potency'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('potency')"
                                                                    wire:click="removeItemFilter('potency')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchPotency"
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldPotency as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="potency"
                                                                            wire:click="sortCheck('potency', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item->name }}</label>
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
                                    @if (in_array('Repair Action', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Repair Action
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchRepairAction) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('repair_action')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchRepairAction"
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
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    PJA
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchPja) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('pja')">
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
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchPja"
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
                                        <th class="sticky-top">Due Date</th>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <th class="sticky-top">Status</th>
                                    @endif
                                    <th class="sticky-top">Published</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->activeListings as $itemIndex => $items)
                                    <tr wire:key="{{ $itemIndex }}"
                                        @click="toggleRow('{{ $items->id }}')"
                                        :class="isSelected('{{ $items->id }}') ? 'selected' : 'tr'"
                                        style="cursor: pointer;">
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>
                                        @if (in_array('Company', $selectedColumns))
                                            <td>
                                                <a href="{{ route('field-leadership::listing.active.detail', $items->id) }}"
                                                    style="font-weight: 600; color: #00552f;">
                                                    {{ $items->company->company_name ?? '-' }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Date', $selectedColumns))
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($items->date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>{{ $items->ccow->company_name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Detail Company', $selectedColumns))
                                            <td>{{ $items->detail_company }}</td>
                                        @endif
                                        @if (in_array('Department', $selectedColumns))
                                            <td>{{ $items->department->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Section', $selectedColumns))
                                            <td>{{ $items->section->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Location', $selectedColumns))
                                            <td>{{ $items->areaLocation->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Detail Location', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 200px;">
                                                    {{ $items->detail_location }}
                                                </div>
                                            </td>
                                        @endif
                                        @if (in_array('Type', $selectedColumns))
                                            <td>{{ $items->type }}</td>
                                        @endif
                                        @if (in_array('Members', $selectedColumns))
                                            <td>
                                                <ol>
                                                    @foreach ($items->members as $member)
                                                        <li>
                                                            {{ $member->employee->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Positive Condition', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->positives as $positive)
                                                            <li>
                                                                {{ $positive->description ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                        @endif
                                        @if (in_array('Risk Condition', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->risks as $risk)
                                                            <li>
                                                                {{ $risk->risk_condition ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->category->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->type->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->potency->name ?? '-' }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Repair Action', $selectedColumns))
                                            <td>
                                                <div style="white-space:normal; width: 400px">
                                                    <ol>
                                                        @foreach ($items->risks as $risk)
                                                            <li>
                                                                {{ $risk->repair_action ?? '-' }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $items->pja->user->name ?? '-' }}
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ Carbon\Carbon::parse($risk->due_date)->format('F d, Y') }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                        @endif
                                        @if (in_array('Status', $selectedColumns))
                                            <td>
                                                <span
                                                    class="{{ $items->status == App\Enums\FieldLeadership\FieldLeadershipType::Open ? 'cancel' : ($items->status == App\Enums\FieldLeadership\FieldLeadershipType::Close ? 'done' : ($items->status == App\Enums\FieldLeadership\FieldLeadershipType::OnReviewPja ? 'default' : ($items->status == App\Enums\FieldLeadership\FieldLeadershipType::Overdue ? 'cancel' : 'pending'))) }}">
                                                    {{ $items->status }}
                                                </span>
                                            </td>
                                        @endif
                                        <td>
                                            <span class="{{ $items->published == 'Draft' ? 'pending' : 'done' }}">
                                                {{ $items->published }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <div class="info" x-show="info">test</div> --}}

                    </div><!-- /.table-wrapper -->

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

    <!-- Modal -->
    <div class="modal fade modal-lg" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="import">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel">Import Excel</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-4">
                                <label for="excelType" class="form-label mb-3">Jenis Field Leadership</label>
                                <select class="form-select mb-3 @error('excelType') is-invalid @enderror"
                                    wire:model.debounce.500ms="excelType" id="excelType">
                                    <option value="">Choose Type</option>
                                    <option value="Planned Task Observation">Planned Task Observation</option>
                                    <option value="Take Time Talk">Take Time Talk</option>
                                    <option value="Hazard Report">Hazard Report</option>
                                </select>
                                @error('excelType')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-8">
                                <label for="excelFile" class="form-label mb-3">
                                    Excel File
                                </label>
                                <input class="form-control mb-3 @error('excelFile') is-invalid @enderror"
                                    wire:model.debounce.500ms="excelFile" type="file" accept="xlsx, xls">
                                <small class="mt-3" style="color: green;">(Fomat xlsx/xls)</small>
                                <br>
                                <small style="color: green;">
                                    <a href="{{ asset('fl_excel_template/Template-Import-Filed-Leadership-PT0.xlsx') }}"
                                        style="color:#3fb8ff;">
                                        <u>(Download Template Excel Planned Task Observation)</u>
                                    </a>
                                </small>
                                <br>
                                <small style="color: green;">
                                    <a href="{{ asset('fl_excel_template/Template-Import-Filed-Leadership-TTT.xlsx') }}"
                                        style="color:#3fb8ff;">
                                        <u>(Download Template Excel Take Time Talk)</u>
                                    </a>
                                </small>
                                <br>
                                <small style="color: green;">
                                    <a href="{{ asset('fl_excel_template/Template-Import-Filed-Leadership-HR.xlsx') }}"
                                        style="color:#3fb8ff;">
                                        <u>(Download Template Excel Hazard Report)</u>
                                    </a>
                                </small>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-sm alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><small>{{ $error }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer d-flex align-items-center justify-content-between" wire:ignore>
                        <button type="submit" class="btn btn-outline-success">Import</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            Livewire.on('remove-item', () => {
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

        function unCheck() {
            return {
                selectAllCheckboxes(id) {
                    checkboxes = document.querySelectorAll('[id^=' + id + ']');
                    [...checkboxes].map((el) => {
                        el.checked = false;
                    })
                }
            }
        };
    </script>
@endpush

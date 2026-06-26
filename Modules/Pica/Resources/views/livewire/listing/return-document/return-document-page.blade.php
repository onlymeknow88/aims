<div class="inner-content">
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Return Document</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

            <div x-data="{ 
                itemSelected: @entangle('itemSelected').defer, 
                info: @entangle('info'),
                selectAll: @entangle('selectAll').defer,
                init() {
                    window.addEventListener('pica-sync-selection', (e) => {
                        this.itemSelected = e.detail.ids ?? [];
                        this.selectAll = e.detail.selectAll ?? false;
                    });
                },
                toggleItem(id) {
                    id = String(id);
                    let current = [...this.itemSelected];
                    let idx = current.indexOf(id);
                    if (idx > -1) {
                        current.splice(idx, 1);
                    } else {
                        current.push(id);
                    }
                    this.itemSelected = current;
                }
            }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">

                        {{-- <a href="{{ route('pica::listing.field-leadership.create') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                                        alt="image add"></span>
                                <span class="text-button">Add New</span>
                            </a> --}}
                        <a href="#" type="button"
                            x-bind:class="itemSelected.length > 0 ? 'd-flex' : 'd-none'"
                            class="button-toolbar gap-2 align-items-center py-2 px-3"
                            wire:click="exportExcel()">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/export-top.svg') }}" alt="image export"></span>
                            <span class="text-button">Export</span>
                        </a>

                        <a href="#" type="button"
                            x-bind:class="itemSelected.length > 0 ? 'd-flex' : 'd-none'"
                            class="button-toolbar gap-2 align-items-center py-2 px-3"
                            wire:click="$emit('remove-item')">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a>
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        <a href="#" type="button"
                            x-bind:class="itemSelected.length > 0 ? 'd-flex' : 'd-none'"
                            class="button-toolbar gap-2 align-items-center py-2 px-3"
                            @click.prevent="itemSelected = []; selectAll = false;">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                            <span class="text-button" x-text="itemSelected.length + ' Row Selected'"></span>
                        </a>

                        {{-- <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal"
                                data-bs-target="#sortModal_table">
                                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                                        alt="image add"></span>
                            </a> --}}

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

                        {{-- <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="activedInfo()">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/info.png') }}" alt="image info"></span>
                            </a>
    
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/menu.png') }}" alt="image menu"></span>
                            </a> --}}

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr :class="selectAll ? 'selected' : 'tr'">
                                    <th class="sticky-top" @click="
                                         selectAll = !selectAll;
                                         if (selectAll) {
                                             itemSelected = Array.from(document.querySelectorAll('tbody tr[wire\\:key]')).map(tr => tr.getAttribute('wire:key').replace('return-pica-row-', ''));
                                         } else {
                                             itemSelected = [];
                                         }
                                     ">
                                        <span class="icon-checked" :class="selectAll ? 'selected' : ''"></span>
                                    </th>
                                    @if (in_array('Identity ID', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Identity ID
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchIdentityId) || (!empty($this->sortSelected) && isset($this->sortSelected['company_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('identity_id')">
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
                                                                        wire:model.1500ms="searchIdentityId"
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
                                    @if (in_array('Source NCAR', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Source NCAR
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['source']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('source')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldSource as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('source', '{{ $index }}')">
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
                                    @if (in_array('Date', $selectedColumns))
                                        <th>
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
                                    @if (in_array('Initiator/Auditor', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Initiator/Auditor
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
                                                                    wire:click="removeItemFilter('auditor')">
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
                                                                        wire:model.1500ms="searchAuditor"
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
                                    @if (in_array('Company', $selectedColumns))
                                        <th>
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
                                                                    wire:click="removeItemFilter('company_id')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('company_id', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item }}</label>
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
                                    @if (in_array('Penanggung Jawab', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Penanggung Jawab
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchPja) || (!empty($this->sortSelected) && isset($this->sortSelected['pja'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
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
                                                        <img src="{{ !empty($this->searchPjo) || (!empty($this->sortSelected) && isset($this->sortSelected['pjo'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('pjo')">
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
                                                                        wire:model.1500ms="searchPjo"
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
                                    @if (in_array('Location', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Location
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchLocation) || (!empty($this->sortSelected) && isset($this->sortSelected['location_id'])) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('location_id')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldLocation as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('location_id', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $item }}</label>
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
                                    @if (in_array('Work Activities', $selectedColumns))
                                        <th>Work Activities</th>
                                    @endif
                                    @if (in_array('Description Non Compliance', $selectedColumns))
                                        <th>Description Non Compliance</th>
                                    @endif
                                    @if (in_array('Corrective Action', $selectedColumns))
                                        <th>Corrective Action</th>
                                    @endif
                                    @if (in_array('Target Settlement', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Target Settlement
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->startDateTarget) && !empty($this->endDateTarget) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('dateTarget')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-search">

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center">
                                                                    Dari
                                                                </span>
                                                                <x-inputs.datepicker wire:model="startDateTarget"
                                                                    id="startDateTarget" :error="'startDateTarget'"
                                                                    placeholder="Select Date" />

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center mt-2">
                                                                    Sampai
                                                                </span>
                                                                <x-inputs.datepicker wire:model="endDateTarget"
                                                                    id="endDateTarget" :error="'endDateTarget'"
                                                                    placeholder="Select Date" />

                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Settlement Date', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Settlement Date
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->startDateSettlement) && !empty($this->endDateSettlement) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    wire:click="removeItemFilter('dateSettlement')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div class="sort-search">

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center">
                                                                    Dari
                                                                </span>
                                                                <x-inputs.datepicker wire:model="startDateSettlement"
                                                                    id="startDateSettlement" :error="'startDateSettlement'"
                                                                    placeholder="Select Date" />

                                                                <span
                                                                    class="sort sort-desc fw-normal d-block text-center mt-2">
                                                                    Sampai
                                                                </span>
                                                                <x-inputs.datepicker wire:model="endDateSettlement"
                                                                    id="endDateSettlement" :error="'endDateSettlement'"
                                                                    placeholder="Select Date" />

                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <th>
                                            Status
                                            {{-- <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Status
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

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldStatus as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            wire:click="sortCheck('ccow_id', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="flexCheckDefault">{{ $index }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div> --}}
                                        </th>
                                    @endif
                                    @if (in_array('Published', $selectedColumns))
                                        <th>Published</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->activeListings as $itemIndex => $items)
                                    <tr wire:key="return-pica-row-{{ $items->id }}"
                                        @click="toggleItem('{{ $items->id }}')"
                                        :class="itemSelected.includes('{{ $items->id }}') ? 'selected' : 'tr'"
                                        style="cursor: pointer;">
                                        <td class="td-check">
                                            <span class="icon-checked" :class="itemSelected.includes('{{ $items->id }}') ? 'selected' : ''"></span>
                                        </td>
                                        @if (in_array('Identity ID', $selectedColumns))
                                            <td>
                                                <a href="{{ route('pica::listing.active-document.detail', $items->id) }}"
                                                    style="font-weight: 600; color: #00552f;">
                                                    {{ $items->identity_id ?? '-' }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Source NCAR', $selectedColumns))
                                            <td scope="row">
                                                {{ $items->source ?? '-' }}
                                            </td>
                                        @endif
                                        @if (in_array('Date', $selectedColumns))
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($items->date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('Initiator/Auditor', $selectedColumns))
                                            <td>{{ $items->auditor_name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Company', $selectedColumns))
                                            <td>{{ $items->company->company_name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Penanggung Jawab', $selectedColumns))
                                            <td>{{ $items->pja->user->employee->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('KTT/PJO', $selectedColumns))
                                            <td>{{ $items->pjo->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Location', $selectedColumns))
                                            <td>{{ $items->areaLocation->name ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Work Activities', $selectedColumns))
                                            <td>{{ $items->type ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Description Non Compliance', $selectedColumns))
                                            <td>{{ $items->non_compliance ?? '-' }}</td>
                                        @endif
                                        @if (in_array('Corrective Action', $selectedColumns))
                                            <td>
                                                {{ $items->corrective_action ?? '-' }}
                                            </td>
                                        @endif
                                        @if (in_array('Target Settlement', $selectedColumns))
                                            <td>
                                                {{ Carbon\Carbon::parse($items->target_settlement_date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('Settlement Date', $selectedColumns))
                                            <td>
                                                {{ Carbon\Carbon::parse($items->settlement_date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('Status', $selectedColumns))
                                            <td>
                                                <span
                                                    class="{{ $items->status == App\Enums\Pica\PicaStatus::Open ? 'cancel' : 'done' }}">
                                                    {{ $items->status }}
                                                </span>
                                            </td>
                                        @endif
                                        @if (in_array('Published', $selectedColumns))
                                            <td>
                                                <span class="{{ $items->published == 'Draft' ? 'pending' : 'done' }}">
                                                    {{ $items->published }}
                                                </span>
                                            </td>
                                        @endif
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

    {{-- Modal --}}

    <div class="modal fade" id="sortModal_table" tabindex="-1" aria-labelledby="sortModal_tableLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sortModal_tableLabel">Multiple Sort</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bootstrap-table">
                        {{-- <div class="fixed-table-toolbar">
                        <div class="bars">
                            <div id="toolbar" class="pb-3">
                                <button id="add" type="button" class="btn btn-secondary"><i
                                        class="bi bi-plus"></i> Add Level</button>
                                <button id="delete" type="button" class="btn btn-secondary"><i
                                        class="bi bi-dash"></i> Delete Level</button>
                            </div>
                        </div>
                    </div> --}}
                        <div class="fixed-table-container">
                            <table id="multi-sort" class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                            <div class="th-inner">Column</div>
                                        </th>
                                        <th>
                                            <div class="th-inner">Order</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sort by</td>
                                        <td><select class="btn-group dropdown multi-sort-name form-control">
                                                <option value="github.name">Name</option>
                                                <option value="github.count.stargazers">Stargazers</option>
                                                <option value="github.count.forks" selected="selected">Forks
                                                </option>
                                                <option value="github.description">Description</option>
                                            </select></td>
                                        <td><select class="btn-group dropdown multi-sort-order form-control">
                                                <option value="asc">Ascending</option>
                                                <option value="desc" selected="selected">Descending</option>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td>Then by</td>
                                        <td><select class="btn-group dropdown multi-sort-name form-control">
                                                <option value="github.name">Name</option>
                                                <option value="github.count.stargazers" selected="selected">
                                                    Stargazers
                                                </option>
                                                <option value="github.count.forks">Forks</option>
                                                <option value="github.description">Description</option>
                                            </select></td>
                                        <td><select class="btn-group dropdown multi-sort-order form-control">
                                                <option value="asc">Ascending</option>
                                                <option value="desc" selected="selected">Descending</option>
                                            </select></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary multi-sort-order-button">Sort</button>
                </div>
            </div>
        </div>
    </div>


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

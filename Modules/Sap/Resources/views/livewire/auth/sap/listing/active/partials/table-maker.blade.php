<div>
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Active Document</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                    <div class="toolbar-left d-flex align-items-center">

                        <a href="{{ route('field-leadership::listing.active.create') }}" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                                    alt="image add"></span>
                            <span class="text-button">Add New</span>
                        </a>
                        @if ($countSelected > 0)
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="exportExcel()">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/export.png') }}" alt="image export"></span>
                                <span class="text-button">Export</span>
                            </a>

                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                wire:click="$emit('remove-item')">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/delete.png') }}" alt="image delete"></span>
                                <span class="text-button">Delete</span>
                            </a>
                        @endif

                        @if ($countSelected == 1)
                            <a href="{{ route('field-leadership::listing.active.edit', $itemSelected) }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/pencil.png') }}" alt="image delete"></span>
                                <span class="text-button">Edit</span>
                            </a>
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

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal"
                            data-bs-target="#sortModal_table">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                                    alt="image add"></span>
                        </a>

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

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="activedInfo()">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/info.png') }}" alt="image info"></span>
                        </a>

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/menu.png') }}" alt="image menu"></span>
                        </a>

                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->

                <div class="table-content table-responsive position-relative overflow-auto d-flex">

                    <div class="table-wrapper">

                        <table class="table overflow-auto" style="height: fit-content">
                            <thead>
                                <tr>
                                    <th></th>
                                    @if (in_array('Company', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Company
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <a href="#" class="sort sort-asc fw-normal d-block"
                                                                wire:click="sort('asc', 'company')">Urutkan A-Z</a>
                                                            <a href="#" class="sort sort-desc fw-normal d-block"
                                                                wire:click="sort('desc', 'company')">Urutkan Z-A</a>
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green">Pilih
                                                                    Semua</a>
                                                                <a href="#"
                                                                    class="fw-normal text-green">Kosongkan</a>
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
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 1</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 2</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 3</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 4</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 5</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 6</label>
                                                                </div>
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
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <a href="#" class="sort sort-asc fw-normal d-block"
                                                                wire:click="sort('asc', 'date')">Urutkan A-Z</a>
                                                            <a href="#" class="sort sort-desc fw-normal d-block"
                                                                wire:click="sort('desc', 'date')">Urutkan Z-A</a>
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green">Pilih
                                                                    Semua</a>
                                                                <a href="#"
                                                                    class="fw-normal text-green">Kosongkan</a>
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
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 1</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 2</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 3</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 4</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 5</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 6</label>
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

                                                            <a href="#" class="sort sort-asc fw-normal d-block"
                                                                wire:click="sort('asc', 'ccow')">Urutkan A-Z</a>
                                                            <a href="#" class="sort sort-desc fw-normal d-block"
                                                                wire:click="sort('desc', 'ccow')">Urutkan Z-A</a>
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green">Pilih
                                                                    Semua</a>
                                                                <a href="#"
                                                                    class="fw-normal text-green">Kosongkan</a>
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
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 1</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 2</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 3</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 4</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 5</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 6</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Detail Company', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Detail Company
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <a href="#" class="sort sort-asc fw-normal d-block"
                                                                wire:click="sort('asc', 'detail_company')">Urutkan
                                                                A-Z</a>
                                                            <a href="#" class="sort sort-desc fw-normal d-block"
                                                                wire:click="sort('desc', 'detail_company')">Urutkan
                                                                Z-A</a>
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green">Pilih
                                                                    Semua</a>
                                                                <a href="#"
                                                                    class="fw-normal text-green">Kosongkan</a>
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
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldDetailCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
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
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Department
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <a href="#"
                                                                class="sort sort-asc fw-normal d-block">Urutkan
                                                                A-Z</a>
                                                            <a href="#"
                                                                class="sort sort-desc fw-normal d-block">Urutkan
                                                                Z-A</a>
                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green">Pilih
                                                                    Semua</a>
                                                                <a href="#"
                                                                    class="fw-normal text-green">Kosongkan</a>
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
                                                                        placeholder="Cari data" aria-label="Name"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 1</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 2</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 3</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 4</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 5</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" value=""
                                                                        id="flexCheckDefault">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="flexCheckDefault">Name 6</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Section', $selectedColumns))
                                        <th>Section</th>
                                    @endif
                                    @if (in_array('Location', $selectedColumns))
                                        <th>Location</th>
                                    @endif
                                    @if (in_array('Detail Location', $selectedColumns))
                                        <th>Detail Location</th>
                                    @endif
                                    @if (in_array('Type', $selectedColumns))
                                        <th>Type</th>
                                    @endif
                                    @if (in_array('Members', $selectedColumns))
                                        <th>Members</th>
                                    @endif
                                    @if (in_array('Positive Condition', $selectedColumns))
                                        <th>Positive Condition</th>
                                    @endif
                                    @if (in_array('Risk Condition', $selectedColumns))
                                        <th>Risk Condition</th>
                                        <th>Category</th>
                                        <th>Potency</th>
                                    @endif
                                    @if (in_array('Repair Action', $selectedColumns))
                                        <th>Repair Action</th>
                                        <th>PJA</th>
                                        <th>Due Date</th>
                                    @endif
                                    @if (in_array('Status', $selectedColumns))
                                        <th>Status</th>
                                    @endif
                                </tr>
                                {{-- <tr>
                    @if (in_array('Risk Condition', $selectedColumns))
                        <th class="text-center">Risk Condition</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Potency</th>
                    @endif
                    @if (in_array('Repair Action', $selectedColumns))
                        <th class="text-center">Repair Action</th>
                        <th class="text-center">PJA</th>
                        <th class="text-center">Due Date</th>
                    @endif
                </tr> --}}
                            </thead>
                            <tbody>
                                @foreach ($this->activeListings as $itemIndex => $items)
                                    <tr wire:key="{{ $itemIndex }}"
                                        wire:click="onSelectedItem('{{ $items->id }}')">
                                        <td class="td-check">
                                            @if (in_array($items->id, $itemSelected))
                                                <span class="icon-checked selected"></span>
                                            @else
                                                <span class="icon-checked"></span>
                                            @endif
                                        </td>
                                        @if (in_array('Company', $selectedColumns))
                                            <td>
                                                <a
                                                    href="{{ route('field-leadership::listing.active.detail', $items->id) }}">
                                                    {{ $items->company->company_name }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Date', $selectedColumns))
                                            <td scope="row">
                                                {{ Carbon\Carbon::parse($items->date)->format('F d, Y') }}
                                            </td>
                                        @endif
                                        @if (in_array('CCOW', $selectedColumns))
                                            <td>{{ $items->ccow->company_name }}</td>
                                        @endif
                                        @if (in_array('Detail Company', $selectedColumns))
                                            <td>{{ $items->detail_company }}</td>
                                        @endif
                                        @if (in_array('Department', $selectedColumns))
                                            <td>{{ $items->department->name }}</td>
                                        @endif
                                        @if (in_array('Section', $selectedColumns))
                                            <td>{{ $items->section->name }}</td>
                                        @endif
                                        @if (in_array('Location', $selectedColumns))
                                            <td>{{ $items->areaLocation->name }}</td>
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
                                                            {{ $member->employee->name ?? null }}
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
                                                                {{ $positive->description }}
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
                                                                {{ $risk->risk_condition }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->category->name }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($items->risks as $risk)
                                                        <li>
                                                            {{ $risk->potency->name }}
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
                                                                {{ $risk->repair_action }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $items->pja->user->name }}
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
                                                <button type="button"
                                                    class="btn {{ $items->status == 'Open' ? 'btn-danger' : 'btn-success' }}">
                                                    {{ $items->status }}
                                                </button>
                                            </td>
                                        @endif
                                        {{-- @if (in_array('Action', $selectedColumns))
                            <td>
                                <a href="{{ route('field-leadership::listing.active.detail', $items->id) }}"
                                    class="action-icon">
                                    <i class="fa fa-eye"></i> Detail
                                </a> <br>
                                <a href="{{ route('field-leadership::listing.active.edit', $items->id) }}"
                                    class="action-icon">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </td>
                        @endif --}}
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
                                                <option value="github.count.forks" selected="selected">Forks</option>
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
                                                <option value="github.count.stargazers" selected="selected">Stargazers
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

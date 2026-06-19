<div class="inner-content">
    <div>
        <div class="section-content">

            <div class="section-title py-3 px-2">
                <h4>PJO - Active</h4>
            </div><!-- /.section-title -->

            <div class="table-demo position-relative">

                <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                        <div class="toolbar-left d-flex align-items-center">

                            <a href="{{ route('csms::pjo.create') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                                </span>
                                <span class="text-button">Add New</span>
                            </a>

                            @if ($countSelected > 0)
                                <a href="#" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    wire:click="exportExcel()">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/export-top.svg') }}" alt="image export"></span>
                                    <span class="text-button">Export</span>
                                </a>

                                <a href="#" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    wire:click="$emit('remove-item')">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                                    <span class="text-button">Delete</span>
                                </a>
                            @endif

                            @if ($countSelected == 1)
                                <a href="{{ route('csms::pjo.edit', $itemSelected) }}" type="button"
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
                                <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>
                                    <div class="dropdown-content p-3 d-flex gap-2 flex-column">

                                        <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                                            @foreach ($columns as $column)
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        id="flexCheckDefault" wire:model.defer="selectedColumns"
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
                                                                            <input
                                                                                class="form-check-input rounded-circle"
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
                                        @if (in_array('Criteria', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Criteria
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchCriteria) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('criteria')"
                                                                        wire:click="removeItemFilter('criteria')">
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
                                                                            wire:model.1500ms="searchCriteria"
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
                                                                            <input
                                                                                class="form-check-input rounded-circle"
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
                                        @if (in_array('Submission', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Submission
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchSubmission) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('submission')"
                                                                        wire:click="removeItemFilter('submission')">
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
                                                                            wire:model.1500ms="searchSubmission"
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
                                        @if (in_array('Number', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Number
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('number')"
                                                                        wire:click="removeItemFilter('number')">
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
                                            </th>
                                        @endif
                                        @if (in_array('Name', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Name
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchName) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('name')"
                                                                        wire:click="removeItemFilter('name')">
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
                                                                            wire:model.1500ms="searchName"
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
                                        @if (in_array('Date Of Birth', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Date Of Birth
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
                                                                    <x-inputs.datepicker wire:model.defer="startDate"
                                                                        id="startDate" :error="'startDate'"
                                                                        placeholder="Select Date" />

                                                                    <span
                                                                        class="sort sort-desc fw-normal d-block text-center mt-2">
                                                                        Sampai
                                                                    </span>
                                                                    <x-inputs.datepicker wire:model.defer="endDate"
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
                                        @if (in_array('Phone', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Phone
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchPhone) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('phone')"
                                                                        wire:click="removeItemFilter('phone')">
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
                                                                            wire:model.1500ms="searchPhone"
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
                                        @if (in_array('Email', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Email
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ !empty($this->searchEmail) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div class="pilih-all d-flex gap-2">
                                                                    <a href="#" class="fw-normal text-green"
                                                                        x-on:click="selectAllCheckboxes('email')"
                                                                        wire:click="removeItemFilter('email')">
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
                                                                            wire:model.1500ms="searchEmail"
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
                                        @if (in_array('Status', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Status
                                                    </span>
                                                </div>
                                            </th>
                                        @endif
                                        @if (in_array('Published', $selectedColumns))
                                            <th class="sticky-top">Published</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->activeListings as $itemIndex => $items)
                                        <tr wire:key="{{ $itemIndex }}"
                                            wire:click="onSelectedItem('{{ $items->id }}')"
                                            @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                                            <td class="td-check">
                                                <span class="icon-checked"></span>
                                            </td>
                                            @if (in_array('Company', $selectedColumns))
                                                <td>
                                                    <a href="{{ route('csms::pjo.detail', $items->id) }}"
                                                        style="font-weight: 600; color: #00552f;">
                                                        {{ $items->company->company_name ?? '-' }}
                                                    </a>
                                                </td>
                                            @endif
                                            @if (in_array('Criteria', $selectedColumns))
                                                <td>
                                                    {{ $items->criteria ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('CCOW', $selectedColumns))
                                                <td>
                                                    {{ $items->ccow->company_name ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Submission', $selectedColumns))
                                                <td>
                                                    {{ $items->submission ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Number', $selectedColumns))
                                                <td>
                                                    {{ $items->number_pjo ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Name', $selectedColumns))
                                                <td>
                                                    {{ $items->name ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Date Of Birth', $selectedColumns))
                                                <td>
                                                    {{ $items->date_of_birth ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Phone', $selectedColumns))
                                                <td>
                                                    {{ $items->phone ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Email', $selectedColumns))
                                                <td>
                                                    {{ $items->email ?? '-' }}
                                                </td>
                                            @endif
                                            @if (in_array('Status', $selectedColumns))
                                                <td>
                                                    <span
                                                        class="{{ $items->status == App\Enums\CSMS\CsmsStatus::Open ? 'cancel' : ($items->status == App\Enums\CSMS\CsmsStatus::Approved ? 'done' : ($items->status == App\Enums\CSMS\CsmsStatus::OnReviewOHS ? 'default' : ($items->status == App\Enums\CSMS\CsmsStatus::Inactive ? 'cancel' : 'pending'))) }}">
                                                        {{ $items->status }}
                                                    </span>
                                                </td>
                                            @endif
                                            @if (in_array('Published', $selectedColumns))
                                                <td>
                                                    <span
                                                        class="{{ $items->published == 'Draft' ? 'pending' : 'done' }}">
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
                    <x-inputs.text wire:model.defer="limit" id="limit" placeholder="0" value="{{ $limit }}"
                        :error="'limit'" />
                </span>
                <span>{!! __('of') !!}</span>
                <span class="font-medium">{{ $countData }}</span>
                <span>{!! __('Row Data') !!}</span>
            </div>

        </div><!-- /.section-footer -->
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

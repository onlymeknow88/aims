@push('styles')
    <style>
        .title a {
            font-weight: 600;
            color: #00552f;
        }

        .table-document {
            width: 150%;
        }

        .table-document thead tr th:nth-child(2) {
            width: 20%;
        }

        .table-document thead tr th:nth-child(3) {
            width: 5%;
        }
    </style>
    <style>
        .table-content table tbody tr td:nth-child(2) {
            white-space: nowrap;
            min-width: 250px;
        }

        .table-content table tbody tr td:nth-child(7) {
            white-space: nowrap;
            min-width: 250px;
        }

        .table-content table tbody tr td:nth-child(9) {
            white-space: nowrap;
            min-width: 250px;
        }

        .table-content table tbody tr td:nth-child(10) {
            white-space: nowrap;
            min-width: 250px;
        }

        .table-content table tbody tr td:nth-child(11) {
            white-space: nowrap;
            min-width: 250px;
        }
    </style>
@endpush

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            @can('Document System - Create Document')
                <a href="{{ route('document-systems::add-maker') }}" type="button"
                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                    <span class="icon d-flex align-items-center">
                        <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                    </span>
                    <span class="text-button">Add New</span>
                </a>
            @endcan

            @if ($countSelected > 0)
                @can('Document System - Export Document')
                    <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                        wire:click.prevent="export">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export-top.svg') }}"
                                alt="image export"></span>
                        <span class="text-button">Export</span>
                    </a>
                @endcan
            @endif
        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">

            @if ($countSelected > 0)
                <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                    wire:click="removeSeleced()">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete-top.svg') }}"
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
                <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>
                    <div class="dropdown-content p-3 d-flex gap-2 flex-column">

                        <div class="sort-list d-flex gap-1 flex-column mh-200px overflow-auto">
                            @foreach ($columns as $column)
                                <div class="form-check">
                                    <input class="form-check-input rounded-circle" type="checkbox" id="flexCheckDefault"
                                        wire:model="selectedColumns" value="{{ $column }}">
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

    <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">

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
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['company_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('company_id')"
                                                        wire:click="removeItemFilter('company_id')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldCompany as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="company_id"
                                                                wire:click="sortCheck('company_id', '{{ $item->id }}')">
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
                        @if (in_array('Department', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Department
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['department_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('department_id')"
                                                        wire:click="removeItemFilter('department_id')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldDepartment as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="department_id"
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
                        @if (in_array('PIC', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        PIC
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->searchPic) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('pic')"
                                                        wire:click="removeItemFilter('pic')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-search">
                                                    <div class="input-group">
                                                        <span class="input-group-text border-end-0" id="search-icon">
                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                alt="Search"
                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                        </span>
                                                        <input type="text" class="form-control"
                                                            wire:model.1500ms="searchPic" placeholder="Cari data"
                                                            aria-label="Name" aria-describedby="search-icon">
                                                    </div>
                                                </div>

                                            </div>
                                            <!--./dropdown-content-->

                                        </div><!-- /.dropdown-menu -->
                                    </span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('Modul', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Module
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['module_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('module_id')"
                                                        wire:click="removeItemFilter('module_id')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldModule as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="module_id"
                                                                wire:click="sortCheck('module_id', '{{ $item->id }}')">
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
                        @if (in_array('Category', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Category
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['category_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('category_id')"
                                                        wire:click="removeItemFilter('category_id')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldCategory as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="category_id"
                                                                wire:click="sortCheck('category_id', '{{ $item->id }}')">
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
                        @if (in_array('Document Type', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Document Type
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['document_level']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('document_level')"
                                                        wire:click="removeItemFilter('document_level')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldDocumentTypes as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="document_level"
                                                                wire:click="sortCheck('document_level', {{ $index }})">
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
                        @if (in_array('Mapping', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Mapping
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['mapping_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('mapping_id')"
                                                        wire:click="removeItemFilter('mapping_id')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                    @foreach ($fieldMapping as $index => $item)
                                                        <div class="form-check">
                                                            <input class="form-check-input rounded-circle"
                                                                type="checkbox" value="" id="mapping_id"
                                                                wire:click="sortCheck('mapping_id', '{{ $item->id }}')">
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
                        @if (in_array('Title Document', $selectedColumns))
                            <th class="sticky-top" style="width: 10%">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Title
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->searchTitle) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('title')"
                                                        wire:click="removeItemFilter('title')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-search">
                                                    <div class="input-group">
                                                        <span class="input-group-text border-end-0" id="search-icon">
                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                alt="Search"
                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                        </span>
                                                        <input type="text" class="form-control"
                                                            wire:model.1500ms="searchTitle" placeholder="Cari data"
                                                            aria-label="Name" aria-describedby="search-icon">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--./dropdown-content-->

                                        </div><!-- /.dropdown-menu -->
                                    </span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('ID Document', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        ID Document
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->searchIdDocument) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('id_document')"
                                                        wire:click="removeItemFilter('id_document')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-search">
                                                    <div class="input-group">
                                                        <span class="input-group-text border-end-0" id="search-icon">
                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                alt="Search"
                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                        </span>
                                                        <input type="text" class="form-control"
                                                            wire:model.1500ms="searchIdDocument"
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
                        @if (in_array('Revisi No.', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Revisi No.
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ $sortField == 'revision' ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('revision')"
                                                        wire:click="removeItemFilter('revision')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                    <a href="#" class="sort sort-asc fw-normal d-block"
                                                        wire:click="sort('asc', 'revision')">
                                                        Urutkan
                                                        A-Z
                                                    </a>
                                                    <a href="#" class="sort sort-desc fw-normal d-block"
                                                        wire:click="sort('desc', 'revision')">
                                                        Urutkan
                                                        Z-A
                                                    </a>

                                                </div>
                                            </div>
                                            <!--./dropdown-content-->

                                        </div><!-- /.dropdown-menu -->
                                    </span>
                                </div>
                            </th>
                        @endif
                        @if (in_array('Date of Created', $selectedColumns))
                            <th class="sticky-top">
                                <div class="column-sort d-flex justify-content-between">
                                    <span>
                                        Date Created
                                    </span>
                                    <span>
                                        <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <img src="{{ !empty($this->startDate) && !empty($this->endDate) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                alt="sorting" />
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end shadow-lg" wire:ignore.self>

                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                <div class="pilih-all d-flex gap-2">
                                                    <a href="#" class="fw-normal text-green"
                                                        x-on:click="selectAllCheckboxes('date')"
                                                        wire:click="removeItemFilter('date')">
                                                        Hapus Filter
                                                    </a>
                                                </div>

                                                <div class="sort-search">

                                                    <span class="sort sort-desc fw-normal d-block text-center">
                                                        Dari
                                                    </span>
                                                    <x-inputs.datepicker wire:model="startDate" id="startDate"
                                                        :error="'startDate'" placeholder="Select Date" />

                                                    <span class="sort sort-desc fw-normal d-block text-center mt-2">
                                                        Sampai
                                                    </span>
                                                    <x-inputs.datepicker wire:model="endDate" id="endDate"
                                                        :error="'endDate'" placeholder="Select Date" />

                                                </div>
                                            </div>
                                            <!--./dropdown-content-->

                                        </div><!-- /.dropdown-menu -->
                                    </span>

                                </div>
                            </th>
                        @endif
                        @if (in_array('Attachment', $selectedColumns))
                            <th class="sticky-top">
                                <span>
                                    Attachment
                                </span>
                            </th>
                        @endif
                        @if (in_array('Status', $selectedColumns))
                            <th class="sticky-top">
                                <span>
                                    Status
                                </span>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->listings as $itemIndex => $items)
                        <tr wire:key="{{ $itemIndex }}" wire:click="onSelectedItem('{{ $items->id }}')"
                            @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                            <td class="td-check">
                                <span class="icon-checked"></span>
                            </td>
                            <td class="title">
                                <a
                                    href="{{ route('document-systems::detail-maker', ['id' => $items->id, 'type' => 'active-document']) }}">
                                    {{ $items->department->company->company_name }}
                                </a>
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->department->name }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{-- <span>
                                    <img src="{{ asset('images/icons/user.png') }}" alt="">
                                </span> --}}
                                {{ $items->user->name ?? '-' }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->mapping->category->module->index ?? null }}.
                                {{ $items->mapping->category->module->name ?? null }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->mapping->category->index ?? null }}.
                                {{ $items->mapping->category->name ?? null }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->documenttype }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->mapping->index ?? null }}. {{ $items->mapping->name ?? null }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->title }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->fix_document_number === '-' ? $items->document_number : $items->fix_document_number }}
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ $items->revision ?? 0 }}.0
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                {{ date('d F Y', strtotime($items->doc_created)) }}
                            </td>
                            <td>
                                <b>
                                    <ol>
                                        {{-- @foreach ($items->attachments as $attachment)
                                            <li>
                                                <a href="javascript:void(0)" onclick="event.stopPropagation(); previewBlobFile('{{ $attachment->id }}', '{{ $attachment->file_name }}', 'document')" class="d-block">
                                                    {{ $attachment->file_name }}
                                                </a>
                                            </li>
                                        @endforeach --}}
                                        @foreach ($items->attachments as $attachment)
    @if (str_starts_with($attachment->file_name, 'Final-'))
        <li>
            <a href="javascript:void(0)" onclick="event.stopPropagation(); previewBlobFile('{{ $attachment->id }}', '{{ $attachment->file_name }}', 'document')" class="d-block">
                {{ $attachment->file_name }}
            </a>
        </li>
    @endif
@endforeach
                                    </ol>
                                </b>
                            </td>
                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                <span>{!! $items->status_badge !!}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div><!-- /.table-wrapper -->

        {{-- <div class="info bg-white px-3 pt-0" x-show="info">
            <livewire:document-systems.maker.sidebar-info />
        </div> --}}

    </div><!-- /.table-content-->


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


</div>

@push('scripts')
    <script>
        window.addEventListener('confirm-delete', () => {
            newSwal.fire({
                title: 'Are you sure?',
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText: "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('submitDelete')
                    }
                },
            });
        });

        window.addEventListener('resetSelect2', (detail) => {
            for (let a = 0; a < detail.detail.length; a++) {
                $('#' + detail.detail[a]).val(null).trigger('change');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            @this.on('submitFilter', () => {
                let data = $('#form-filter').serialize();
                @this.call('filterSort', data);
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

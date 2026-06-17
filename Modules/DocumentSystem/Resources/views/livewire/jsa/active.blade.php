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

        .table-content table tbody tr td:nth-child(8) {
            white-space: normal;
            min-width: 300px;
        }
    </style>
@endpush

<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Active Job Safety Analysis (JSA)</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @if (auth()->user()->can('Document System - Create JSA'))
                            <a href="{{ route('document-systems::jsa.create') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                                </span>
                                <span class="text-button">Add New</span>
                            </a>
                        @endif

                        @if ($countSelected > 0)
                            @if (auth()->user()->can('Document System - Export JSA'))
                                <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    wire:click.prevent="export">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/export-top.svg') }}" alt="image export"></span>
                                    <span class="text-button">Export</span>
                                </a>
                            @endif

                            {{-- @if (auth()->user()->can('Document System - Delete JSA'))
                                <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    wire:click.prevent="confirmDelete">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                                    <span class="text-button">Delete</span>
                                </a>
                            @endif --}}
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
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['company_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
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

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox" value=""
                                                                            id="company_id"
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
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->sortSelected) && isset($this->sortSelected['department_id']) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
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
                                    @if (in_array('PIC', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    PIC
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchPic) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

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
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchPic"
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
                                    @if (in_array('Title', $selectedColumns))
                                        <th class="sticky-top" style="width: 10%">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Title
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchTitle) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

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
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control"
                                                                        wire:model.1500ms="searchTitle"
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
                                    @if (in_array('ID Document', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    ID Document
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchIdDocument) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

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
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
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
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ $sortField == 'revision' ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('revision')"
                                                                    wire:click="removeItemFilter('revision')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                                <a href="#"
                                                                    class="sort sort-asc fw-normal d-block"
                                                                    wire:click="sort('asc', 'revision')">
                                                                    Urutkan
                                                                    A-Z
                                                                </a>
                                                                <a href="#"
                                                                    class="sort sort-desc fw-normal d-block"
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
                                                                    x-on:click="selectAllCheckboxes('detail_location')"
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
                                    @if (in_array('Date Created', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Date Created
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ $sortField == 'doc_created' ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                        wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                            <div class="pilih-all d-flex gap-2">
                                                                <a href="#" class="fw-normal text-green"
                                                                    x-on:click="selectAllCheckboxes('doc_created')"
                                                                    wire:click="removeItemFilter('doc_created')">
                                                                    Hapus Filter
                                                                </a>
                                                            </div>

                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                                <a href="#"
                                                                    class="sort sort-asc fw-normal d-block"
                                                                    wire:click="sort('asc', 'doc_created')">
                                                                    Urutkan
                                                                    A-Z
                                                                </a>
                                                                <a href="#"
                                                                    class="sort sort-desc fw-normal d-block"
                                                                    wire:click="sort('desc', 'doc_created')">
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
                                    <tr wire:key="{{ $itemIndex }}"
                                        wire:click="onSelectedItem('{{ $items->id }}')"
                                        @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>
                                        <td class="title">
                                            <a
                                                href="{{ route('document-systems::jsa.detail', ['id' => $items->id, 'type' => 'active-document']) }}">
                                                {{ $items->department->company->company_name }}
                                            </a>
                                        </td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ $items->department->name }}</td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            <span>
                                                <img src="{{ asset('images/icons/user.png') }}" alt="">
                                            </span>
                                            {{ $items->user->name ?? '-' }}
                                        </td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ $items->title }}
                                        </td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ $items->document_number }}</td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ $items->revision == '' ? 0 : $items->revision }}.0
                                        </td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ $items->detail_location }}</td>
                                        <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                            {{ date('d F Y', strtotime($items->doc_created)) }}
                                        </td>
                                        <td>
                                            <b>
                                                <ol>
                                                    @foreach ($items->attachments as $attachment)
                                                        @php
                                                            $explode = explode('-', $attachment->file_name);
                                                            $name = $explode[0];
                                                        @endphp
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="event.stopPropagation(); previewBlobFile('{{ $attachment->id }}', '{{ $attachment->file_name }}', 'jsa')" class="d-block">
                                                                {{ $attachment->file_name }}
                                                            </a>
                                                        </li>
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

                </div><!-- /.table-content-->


                <div
                    class="section-footer d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
                    <div class="update-on opacity-80">{{ $latestUpdate }}</div>

                    <div class="row-data opacity-80 d-flex gap-2 align-items-center">
                        <span class="input-limit w-100px">
                            <x-inputs.text wire:model="limit" id="limit" placeholder="0"
                                value="{{ $limit }}" :error="'limit'" />
                        </span>
                        <span>{!! __('of') !!}</span>
                        <span class="font-medium">{{ $countData }}</span>
                        <span>{!! __('Row Data') !!}</span>
                    </div>

                </div><!-- /.section-footer -->

            </div>

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

</div>

@push('scripts')
    <script>
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
    </script>
@endpush

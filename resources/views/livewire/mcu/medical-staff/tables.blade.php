<div class="inner-content">

    <link rel="stylesheet"
        href="https://unpkg.com/@fortawesome/fontawesome-free@5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <div class="alert @if (!empty(session('alert'))) alert-{{ session('alert') }} @else d-none @endif">
        @if (!empty(session('msg')))
            {{ session('msg') }}
        @endif
    </div>

    <div class="section-content">

        {{-- <div class="section-title py-3 px-2">
            <h4>Demo Sorting Tables</h4>
        </div><!-- /.section-title --> --}}

        <div class="table-demo position-relative">

            <div x-data="{ itemSelected: @entangle('itemSelected')}">
                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">


            <div class="toolbar-left d-flex align-items-center">

                @if ($countSelected < 1)

                <a href="{{ route('mcu::medical-staff-f', 'add') }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add New</span>
            </a>
            {{-- <div class="" style="margin-right: 10px">
                <a class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                            alt="image add"></span>
                    Add New
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('mcu::medical-staff-f', 'annual') }}" type="button"
                            class="dropdown-item">
                            Add New Annual
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mcu::medical-staff-f', 'pre-employment') }}" type="button"
                            class="dropdown-item">
                            Add New Pre-Employment
                        </a>
                    </li>
                </ul>
            </div> --}}
            {{-- <a href="{{ route('mcu::medical-staff-f', 'annual') }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add New Annual</span>
            </a>
            <a href="{{ route('mcu::medical-staff-f', 'pre-employment') }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add New Pre-Employment</span>
            </a> --}}
            <a type="button" data-bs-toggle="modal" data-bs-target="#importModal"
                class="button-toolbar btn-outline d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Import File</span>
            </a>

            {{-- <a type="button" wire:click="export()"
                class="button-toolbar btn-outline d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Export</span>
            </a> --}}

                @elseif ($countSelected > 0)
                    @if ($countSelected == 1)
                    {{-- <h6>{{ var_dump($this->itemSelected) }}</h6> --}}
                    {{ $this->get_mcu() }}
                        {{-- <a wire:click="export()" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                    alt="image export"></span>
                            <span class="text-button">Export</span>
                        </a> --}}
                        {{-- <h5>{{ $carbonNow }}</h5> --}}
                        @if ($doctorStatusReview == 'Fit')
                        <a href="{{ route('mcu::print-skk', $itemSelected[0]) }}" target="_blank"
                            class="btn btn-sm btn-outline-success">Download</a>
                        @elseif ($doctorStatusReview == 'Fit With Recomendation')
                            <a href="{{ route('mcu::print-skk', $itemSelected[0]) }}" target="_blank"
                                class="btn btn-sm btn-outline-success">Download</a>
                        @elseif ($doctorStatusReview == 'Curently Unfit')

                        @elseif ($doctorStatusReview == 'Unfit')

                        @elseif ($doctorStatusReview == 'draft')
                            {{-- <a href="{{ route('mcu::medical-staff-e', $itemSelected[0]) }}"
                                class="btn btn-sm btn-outline-primary">Edit</a> --}}

                            <a href="{{ route('mcu::medical-staff-e', $itemSelected[0]) }}" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            {{-- <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                    alt="image export"></span> --}}
                            <span class="text-button">Edit</span>
                        </a>
                        @else
                            @if ($carbonNow <= 60)
                                <a href="{{ route('mcu::medical-staff-e', $itemSelected[0]) }}"
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            @else
                                -
                            @endif
                        @endif
                        @endif


                    <a wire:click="export()" type="button"
                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/export.png') }}"
                                alt="image export"></span>
                        <span class="text-button">Export</span>
                    </a>

                        {{-- @if ($detail->is_deletable)
                            <a href="{{ route('edit-event', $detail->id) }}"  class="btn btn-light"><img src="{{ asset('/images/icons/pencil.png') }}" alt=""></a>
                            <button type="button" class="btn btn-light" wire:click="delete('{{ $detail->id }}')">
                                <img src="{{ asset('/images/icons/trash.png') }}" alt="Icon Delete">
                            </button>
                        @endif --}}

                    <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="delete()">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                alt="image delete"></span>
                        <span class="text-button">Delete</span>
                    </a>
                @endif
            </div><!-- /.toolbar-left -->

            <div class="toolbar-right d-flex align-items-center">

                @if ($countSelected > 0)
                    <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                                alt="image delete"></span>
                        <span class="text-button">{{ $countSelected }} Row Selected</span>
                    </a>
                @endif

                <div class="keep-open btn-group" title="Columns">
                    <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="dropdown">
                        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/sort.png') }}"
                                alt="image add"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        @foreach ($columns as $column)
                            <label class="dropdown-item dropdown-item-marker">
                                <input type="checkbox" wire:model="selectedColumns" value="{{ $column }}"checked="checked"> <span>{{ $column }}</span>
                            </label> @endforeach
                    </div>
                </div>

                <a href="#"
        type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal"
        data-bs-target="#sortModal_table"><span class="icon d-flex align-items-center">
        <img src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
    </a>

    <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
        wire:click="activedInfo()">
        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/info.png') }}"
                alt="image info"></span>
    </a>

    <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
        <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/menu.png') }}"
                alt="image menu"></span>
    </a>
    <div class="float-right search btn-group">
        <input class="form-control search-input" type="search" placeholder="Search" autocomplete="off"
            wire:model="searchTerm">
    </div>
</div><!-- /.toolbar-right -->

</div><!-- /.toolsbar-tables -->

<div class="table-content table-responsive position-relative">

    <div class="table-wrapper">

        <table class="table overflow-auto">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($columns as $column)
                        @if ($this->showColumn('{{ $column }}'))
                            <td>{{ $column }}</td>
                        @endif
                    @endforeach

                    @if (in_array('Date', $selectedColumns))
                        <th>
                            <div class="column-sort d-flex justify-content-between" x-data="{ openMenu: false }"
                                @mouseover="openMenu = true">
                                <span>Date</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="{{ asset('images/icons/sorting.png') }}" alt="sorting" />
                                    </button>
                                    <div x-cloak class="dropdown-menu dropdown-menu-end" x-show="openMenu"
                                        @mouseover.away="openMenu = false">
                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                            alt="Search"
                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari data document" aria-label="Name"
                                                        aria-describedby="search-icon">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.dropdown-menu -->
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                    @endif
                    @if (in_array('Name', $selectedColumns))
                        <th>
                            <div class="column-sort d-flex justify-content-between" x-data="{ openMenu: false }"
                                @mouseover="openMenu = true">
                                <span>Nama</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="{{ asset('images/icons/sorting.png') }}" alt="sorting" />
                                    </button>
                                    <div x-cloak class="dropdown-menu dropdown-menu-end" x-show="openMenu"
                                        @mouseover.away="openMenu = false">
                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                            alt="Search"
                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari data document" aria-label="Name"
                                                        aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        4</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        5</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        6</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./dropdown-content-->
                                    </div><!-- /.dropdown-menu -->
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                    @endif
                    @if (in_array('Tanggal Lahir', $selectedColumns))
                        <th>Tanggal Lahir</th>
                    @endif
                    @if (in_array('Company', $selectedColumns))
                        <th>
                            <div class="column-sort d-flex justify-content-between" x-data="{ openMenu: false }"
                                @mouseover="openMenu = true">
                                <span>Perusahaan</span>
                                <span>
                                    <button class="btn border-0 p-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="{{ asset('images/icons/sorting.png') }}" alt="sorting" />
                                    </button>
                                    <div x-cloak class="dropdown-menu dropdown-menu-end" x-show="openMenu"
                                        @mouseover.away="openMenu = false">
                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                            <a href="#" class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                            <a href="#" class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
                                            <div class="pilih-all d-flex gap-2">
                                                <a href="#" class="fw-normal text-green">Pilih Semua</a>
                                                <a href="#" class="fw-normal text-green">Kosongkan</a>
                                            </div>
                                            <div class="sort-search">
                                                <div class="input-group">
                                                    <span class="input-group-text border-end-0" id="search-icon">
                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                            alt="Search"
                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                    </span>
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari data document" aria-label="Name"
                                                        aria-describedby="search-icon">
                                                </div>
                                            </div>
                                            <div class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        4</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        5</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rounded-circle" type="checkbox"
                                                        value="" id="flexCheckDefault">
                                                    <label class="form-check-label fw-normal"
                                                        for="flexCheckDefault">Name
                                                        6</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./dropdown-content-->
                                    </div><!-- /.dropdown-menu -->
                                </span>
                            </div><!-- /.column-sort -->
                        </th>
                    @endif
                    @if (in_array('Department', $selectedColumns))
                        <th>Department</th>
                    @endif
                    @if (in_array('Kesehatan', $selectedColumns))
                        <th>Kesehatan</th>
                    @endif
                    @if (in_array('Status', $selectedColumns))
                        <th>Status</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($dataTables as $itemIndex => $items)
                    <tr wire:key="'{{ $itemIndex }}'" wire:click="onSelectedItem('{{ $items['id'] }}')">
                        <td class="td-check">
                            @if (in_array($items['id'], $itemSelected))
                                <span class="icon-checked selected"></span>
                            @else
                                <span class="icon-checked"></span>
                            @endif
                        </td>

                        @if (in_array('Date', $selectedColumns))
                            <td>
                                <a
                                    href="{{ route('mcu::medical-staff-detail', $items['id']) }}">{{ $items['mcu_date'] }}</a>
                            </td>
                        @endif
                        @if (in_array('Name', $selectedColumns))
                            <td><a href="{{ route('mcu::medical-staff-detail', $items['id']) }}"><span><img
                                            src="{{ asset('images/icons/user.png') }}" alt=""></span>
                                    {{ $items['employee']['name'] }}</a></td>
                        @endif
                        @if (in_array('Tanggal Lahir', $selectedColumns))
                            <td>{{ \Carbon\Carbon::parse($items['employee']['date_of_birth'])->format('d M Y') }}</td>
                        @endif
                        @if (in_array('Company', $selectedColumns))
                            <td>{{ $items['employee']['company'] }}</td>
                        @endif
                        @if (in_array('Department', $selectedColumns))
                            <td>{{ $items['employee']['department'] }}</td>
                        @endif
                        @if (in_array('Kesehatan', $selectedColumns))
                            <td>{{ $items['frammingham_risk_level'] }}</td>
                        @endif
                        @if (in_array('Status', $selectedColumns))
                            <td>
                                <span
                                    style="color:@if ($items['doctor_status_review'] == 'Fit') green
                                                    @elseif ($items['doctor_status_review'] == 'Fit With Recomendation') blue
                                                    @elseif ($items['doctor_status_review'] == 'Curently Unfit') orange
                                                    @elseif ($items['doctor_status_review'] == 'Unfit') red
                                                    @else grey @endif;">
                                    @if (empty($items['doctor_status_review']))
                                        {{ 'In Review' }}
                                    @else
                                        {{ $items['doctor_status_review'] }}
                                    @endif
                                </span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div><!-- /.table-wrapper -->

</div><!-- /.table-content-->

</div>

</div><!-- /.table-maker -->

</div><!-- /.section-content -->

<div class="section-footer
        d-flex justify-content-between sticky-bottom bg-white align-items-center h-60px">
    <div class="update-on opacity-80">{{ $latestUpdate }}</div>
    <div class="row-data opacity-80 d-flex gap-2 align-items-center">
        <span class="input-limit w-100px">
            <x-inputs.text wire:model="limit" id="limit" placeholder="0" value="{{ $limit }}"
                :error="'limit'" />
        </span>
        <span>{!! __('of') !!}</span>
        <span class="font-medium">{{ $countData }}</span>
        <span>{!! __('Document Active') !!}</span>
    </div>
</div><!-- /.section-footer -->

<!-- Modal -->
<div class="modal fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <form wire:submit.prevent="import">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">Excel File</label>
                        <input class="form-control form-control-sm @error('excelFile') is-invalid @enderror"
                            wire:model.debounce.500ms="excelFile" type="file">
                        @error('excelFile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="mb-1">
                            <a href="#" class="btn btn-dark btn-sm">Example Template</a>
                        </div> --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer d-flex align-items-center justify-content-between" wire:ignore>
                    <button type="submit" class="btn btn-outline-success btn-sm">Import</button>
                    <button type="button" class="btn btn-outline-danger btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="sortModal_table" tabindex="-1" aria-labelledby="sortModal_tableLabel"
    aria-hidden="true" style="display: none;" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sortModal_tableLabel">Filter & Sort</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="filterSort">

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
                                            <div class="th-inner">Filtered by</div>
                                        </th>
                                        <th>
                                            <div class="th-inner">Order</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($columns as $column)
                                        @if ($column == 'Date')
                                            <tr>
                                                <td>{{ $column }}</td>
                                                <td>
                                                    <x-inputs.datepicker wire:model="sortBy" id="sortBy"
                                                        placeholder="Pilih Tanggal" :error="'sortBy'" />
                                                </td>
                                                <td>
                                                    <select class="btn-group dropdown multi-sort-order form-control">
                                                        <option value="ASC">A - Z</option>
                                                        <option value="DESC">Z - A</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @elseif ($column == 'Name')
                                            {{-- <tr>
                                            <td>{{ $column }}</td>
                                            <td>
                                                <x-inputs.text wire:model="sortBy" id="sortBy" placeholder=""
                                                    :error="'sortBy'" />
                                            </td>
                                            <td>
                                                <x-inputs.select2 id="" class="btn-group dropdown multi-sort-order form-control">
                                                    <option value="ASC">A - Z</option>
                                                    <option value="DESC">Z - A</option>
                                                </x-inputs.select2>
                                            </td>
                                        </tr> --}}
                                        @elseif ($column == 'Tanggal Lahir')

                                        @elseif ($column == 'Company')
                                            <tr>
                                                <td>{{ $column }}</td>
                                                <td>
                                                    <x-inputs.select2 id=""
                                                        class="btn-group dropdown multi-sort-name form-control"
                                                        wire:model="companyFilter" id="companyFilter"
                                                        placeholder="Pilih Company">
                                                        <option value="1">M Coal</option>
                                                        <option value="2">K Coal</option>
                                                    </x-inputs.select2>
                                                </td>
                                                <td>
                                                    <select class="btn-group dropdown multi-sort-order form-control"
                                                        wire:model="companySort" id="companySort">
                                                        <option value="ASC">A - Z</option>
                                                        <option value="DESC">Z - A</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @elseif ($column == 'Department')
                                            <tr>
                                                <td>{{ $column }}</td>
                                                <td>
                                                    <x-inputs.select2 id=""
                                                        class="btn-group dropdown multi-sort-name form-control"
                                                        wire:model="departmentFilter" id="departmentFilter"
                                                        placeholder="Pilih Department">
                                                        <option value="IT">IT</option>
                                                        <option value="2">Litbang</option>
                                                    </x-inputs.select2>
                                                </td>
                                                <td>

                                                    {{-- <select class="btn-group dropdown multi-sort-order form-control" wire:model="departmentSort" id="departmentSort">
                                                <option value="ASC">A - Z</option>
                                                <option value="DESC">Z - A</option>
                                            </select> --}}
                                                </td>
                                            </tr>
                                        @elseif ($column == 'Aksi')

                                        @elseif ($column == 'Kesehatan')

                                        @elseif ($column == 'Status')
                                            <tr>
                                                <td>{{ $column }}</td>
                                                <td>
                                                    <x-inputs.select2 id=""
                                                        class="btn-group dropdown multi-sort-name form-control"
                                                        wire:model="statusFilter" id="statusFilter"
                                                        placeholder="Pilih Status">
                                                        <option value="draft">Draft</option>
                                                        <option value="in review">In Review</option>
                                                        <option value="Fit">Fit</option>
                                                        <option value="Fit With Recomendation">Fit With Recomendation
                                                        </option>
                                                        <option value="Curently Unfit">Curently Unfit</option>
                                                        <option value="Unfit">Unfit</option>
                                                    </x-inputs.select2>
                                                </td>
                                                <td>
                                                    <select class="btn-group dropdown multi-sort-order form-control"
                                                        wire:model="statusSort" id="statusSort">
                                                        <option value="ASC">A - Z</option>
                                                        <option value="DESC">Z - A</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $column }}</td>
                                                <td>
                                                    <x-inputs.datepicker wire:model="dateSort" id="dateSort"
                                                        placeholder="Pilih Tanggal" />
                                                </td>
                                                <td>
                                                    <select class="btn-group dropdown multi-sort-order form-control"
                                                        wire:model="dateFilter" id="dateFilter">
                                                        <option value="ASC">A - Z</option>
                                                        <option value="DESC">Z - A</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFilterSort()">Reset</button>
                    <button type="submit" class="btn btn-primary multi-sort-order-button"
                        data-bs-dismiss="modal">Sort</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

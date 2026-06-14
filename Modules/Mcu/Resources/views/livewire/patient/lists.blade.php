<div class="inner-content">

    <div class="alert @if (!empty(session('alert'))) alert-{{ session('alert') }} @else d-none @endif">
        @if (!empty(session('msg')))
            {{ session('msg') }}
        @endif
    </div>

    <div class="section-content">
        <div class="table-demo position-relative">

            <div x-data="{ itemSelected: @entangle('itemSelected') }">
                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @if ($countSelected < 1)
                        @elseif ($countSelected > 0)
                            @if ($countSelected == 1)
                                @if ($doctorStatusReview == 'Fit')
                                    <a href="{{ route('mcu::print-skk', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <span class="text-button"><i class="fa fa-download"></i> Download SKK</span>
                                    </a>
                                @elseif ($doctorStatusReview == 'Fit With Recomendation')
                                    <a href="{{ route('mcu::print-skk', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <span class="text-button"><i class="fa fa-download"></i> Download SKK</span>
                                    </a>
                                @elseif ($doctorStatusReview == 'Curently Unfit')

                                @elseif ($doctorStatusReview == 'Unfit')

                                @elseif ($doctorStatusReview == 'draft')
                                    <a href="{{ route('mcu::medical-staff-e', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <span class="text-button"><img src="{{ asset('/images/icons/pencil.png') }}"
                                                alt=""> Edit</span>
                                    </a>
                                @else
                                @endif
                                <a href="{{ route('mcu::doctor-detail', $idSelected) }}" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="text-button"><i class="fa fa-eye"></i> Detail</span>
                                </a>
                            @endif
                        @endif
                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if ($countSelected > 0)
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center">
                                    {{-- <img src="{{ asset('images/icons/delete.png') }}" alt="image delete"> --}}
                                    <i class="fa fa-check"></i>
                                </span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif

                        <div class="keep-open btn-group" title="Columns">
                            <a href="#" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                data-bs-toggle="dropdown">
                                <span class="icon d-flex align-items-center"><img
                                        src="{{ asset('images/icons/sort.png') }}" alt="image add"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" style="">
                                @foreach ($columns as $column)
                                    <label class="dropdown-item dropdown-item-marker">
                                        <input type="checkbox" wire:model="selectedColumns"
                                            value="{{ $column }}"checked="checked">
                                        <span>{{ $column }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <a href="#" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal"
                            data-bs-target="#sortModal_table">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
                        </a>

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
                        <div class="float-right search btn-group">
                            <input class="form-control search-input" type="search" placeholder="Search"
                                autocomplete="off" wire:model="searchTerm">
                        </div>
                    </div><!-- /.toolbar-right -->

                </div><!-- /.toolsbar-tables -->
            </div>

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
                                        <div class="column-sort d-flex justify-content-between"
                                            x-data="{ openMenu: false }" @mouseover="openMenu = true">
                                            <span>Tanggal MCU</span>
                                            {{-- <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/icons/sorting.png') }}"
                                                        alt="sorting" />
                                                </button>
                                                <div x-cloak class="dropdown-menu dropdown-menu-end" x-show="openMenu"
                                                    @mouseover.away="openMenu = false">
                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                        <a href="#"
                                                            class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                                        <a href="#"
                                                            class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
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
                                                                    placeholder="Cari data document" aria-label="Name"
                                                                    aria-describedby="search-icon">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.dropdown-menu -->
                                            </span> --}}
                                        </div><!-- /.column-sort -->
                                    </th>
                                @endif
                                @if (in_array('Name', $selectedColumns))
                                    <th>
                                        <div class="column-sort d-flex justify-content-between"
                                            x-data="{ openMenu: false }" @mouseover="openMenu = true">
                                            <span>Nama</span>
                                        </div><!-- /.column-sort -->
                                    </th>
                                @endif
                                @if (in_array('Umur', $selectedColumns))
                                    <th>Umur</th>
                                @endif
                                @if (in_array('Company', $selectedColumns))
                                    <th>
                                        <div class="column-sort d-flex justify-content-between"
                                            x-data="{ openMenu: false }" @mouseover="openMenu = true">
                                            <span>Perusahaan</span>
                                            <span>
                                                <button class="btn border-0 p-0" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="{{ asset('images/icons/sorting.png') }}"
                                                        alt="sorting" />
                                                </button>
                                                <div x-cloak class="dropdown-menu dropdown-menu-end" x-show="openMenu"
                                                    @mouseover.away="openMenu = false">
                                                    <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                        <a href="#"
                                                            class="sort sort-asc fw-normal d-block">Urutkan A-Z</a>
                                                        <a href="#"
                                                            class="sort sort-desc fw-normal d-block">Urutkan Z-A</a>
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
                                                                    placeholder="Cari data document" aria-label="Name"
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
                                                                    for="flexCheckDefault">M Coal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input rounded-circle"
                                                                    type="checkbox" value=""
                                                                    id="flexCheckDefault">
                                                                <label class="form-check-label fw-normal"
                                                                    for="flexCheckDefault">K Coal</label>
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
                                <tr wire:key="'{{ $itemIndex }}'"
                                    wire:click="onSelectedItem('{{ $items['id'] }}')">
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
                                                        src="{{ asset('images/icons/user.png') }}"
                                                        alt=""></span>
                                                {{ $items['employee']['name'] }}</a></td>
                                    @endif
                                    @if (in_array('Umur', $selectedColumns))
                                        <td>{{ \Carbon\Carbon::parse($items['employee']['date_of_birth'])->age }} Tahun
                                            {{-- <td>{{ \Carbon\Carbon::parse($items['employee']['date_of_birth'])->format('d M Y') }} --}}
                                        </td>
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
                                                                @elseif ($items['doctor_status_review'] == 'In Review') blue
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

        <div
            class="section-footer
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
                            <div class="mb-3">
                                <label for="excelFile" class="form-label">Excel File <small
                                        style="color: green;">(Fomat xlsx/xls)</small></label>
                                <input class="form-control form-control-sm @error('excelFile') is-invalid @enderror"
                                    wire:model.debounce.500ms="excelFile" type="file">
                                {{-- @error('excelFile')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror --}}
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
                            <button type="button" class="btn btn-outline-danger"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

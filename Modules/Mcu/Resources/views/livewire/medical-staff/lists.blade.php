<div>
    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Data Medical Check Up (Draft)</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">
            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2"">

                    <div class="toolbar-left d-flex align-items-center">

                        @can('MCU - Create MCU')
                            <a href="{{ route('mcu::medical-staff-add') }}" type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                                </span>
                                <span class="text-button">Add New</span>
                            </a>
                        @endcan

                        @can('MCU - Import Data MCU')
                            <a type="button" data-bs-toggle="modal" data-bs-target="#importModal"
                                class="button-toolbar btn-outline d-flex gap-2 align-items-center py-2 px-3">
                                <span class="icon d-flex align-items-center">
                                    <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                                </span>
                                <span class="text-button">Import File</span>
                            </a>
                        @endcan

                        @if ($countSelected < 1)
                        @elseif ($countSelected > 0)
                            @can('MCU - Export Data MCU')
                                <a wire:click="export()" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/export-top.svg') }}" alt="image export"></span>
                                    <span class="text-button">Export</span>
                                </a>
                            @endcan
                            @if ($countSelected == 1)
                                @if ($doctorStatusReview == 'Fit')
                                @elseif ($doctorStatusReview == 'Fit With Recomendation')

                                @elseif ($doctorStatusReview == 'Curently Unfit')

                                @elseif ($doctorStatusReview == 'Unfit')

                                @elseif ($doctorStatusReview == 'draft')
                                    @can('MCU - Edit MCU')
                                        <a href="{{ route('mcu::medical-staff-edit', $idSelected) }}" type="button"
                                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                            <span class="text-button"><img src="{{ asset('/images/icons/pencil.png') }}"
                                                    alt=""> Edit</span>
                                        </a>
                                    @endcan
                                @else
                                    @if ($carbonNow <= 60)
                                        @can('MCU - Edit MCU')
                                            <a href="{{ route('mcu::medical-staff-edit', $idSelected) }}" type="button"
                                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                                <span class="text-button"><img src="{{ asset('/images/icons/pencil.png') }}"
                                                        alt="">
                                                    Edit</span>
                                            </a>
                                        @endcan
                                    @else
                                    @endif
                                @endif

                                {{-- @can('MCU - View Detail MCU Medical Staff')
                                    <a href="{{ route('mcu::medical-staff-detail', $idSelected) }}" type="button"
                                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                        <span class="text-button"><i class="fa fa-eye"></i> Detail</span>
                                    </a>
                                @endcan --}}

                                <a href="#" type="button"
                                    class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                    wire:click="$emit('remove-item')">
                                    <span class="icon d-flex align-items-center"><img
                                            src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                                    <span class="text-button">Delete</span>
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
                                {{-- <tr> --}}
                                <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                    <th class="sticky-top" wire:click="toggleSelectAll">
                                        <span class="icon-checked"></span>
                                    </th>
                                    {{-- <th class="sticky-top"></th> --}}

                                    @if (in_array('Nama Pasien', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Nama Pasien
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
                                                                        wire:model.1500ms="searchName" id="searchName"
                                                                        placeholder="Cari data"
                                                                        aria-label="Nama Pasien"
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

                                    @if (in_array('Tanggal MCU', $selectedColumns))
                                        <th class="sticky-top">
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Tanggal MCU
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
                                                                        wire:model.1500ms="filterMcuDate"
                                                                        placeholder="Tanggal Awal"
                                                                        aria-describedby="search-icon"
                                                                        id="filterMcuDate" />
                                                                </div>
                                                                <center>Sampai</center>
                                                                <div class="input-group">
                                                                    <x-inputs.datepicker
                                                                        wire:model.1500ms="filterMcuDate2"
                                                                        placeholder="Tanggal Akhir"
                                                                        aria-describedby="search-icon"
                                                                        id="filterMcuDate2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div><!-- /.column-sort -->
                                        </th>
                                    @endif
                                    @if (in_array('Tanggal Pembuatan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Tanggal Pembuatan
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
                                                                        wire:model.1500ms="filterCreatedDate"
                                                                        placeholder="Tanggal Awal"
                                                                        aria-describedby="search-icon"
                                                                        id="filterCreatedDate" />
                                                                </div>
                                                                <center>Sampai</center>
                                                                <div class="input-group">
                                                                    <x-inputs.datepicker
                                                                        wire:model.1500ms="filterCreatedDate2"
                                                                        placeholder="Tanggal Akhir"
                                                                        aria-describedby="search-icon"
                                                                        id="filterCreatedDate2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--./dropdown-content-->

                                                    </div><!-- /.dropdown-menu -->
                                                </span>
                                            </div>
                                        </th>
                                    @endif
                                    @if (in_array('Perusahaan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Perusahaan
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                            type="checkbox"
                                                                            id="CheckBoxInspectCompanyId_{{ $index }}"
                                                                            wire:click="sortCheck('company_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                            for="CheckBoxInspectCompanyId_{{ $index }}">{{ $item->company_name }}</label>
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
                                                                        wire:model.1500ms="searchDepartment"
                                                                        id="searchDepartment" placeholder="Cari data"
                                                                        aria-label="Nama Departemen"
                                                                        aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                @foreach ($fieldDepartment as $index => $item)
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
                                    @if (in_array('Status Kesehatan', $selectedColumns))
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Status Kesehatan
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ asset('images/icons/sorting.png') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div
                                                                class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus1"
                                                                        wire:click="sortCheck('doctor_status_review', 'draft')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus1">Draft</label>
                                                                </div>
                                                                {{-- <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus2"
                                                                        wire:click="sortCheck('doctor_status_review', 'In Review')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus2">In Review</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus3"
                                                                        wire:click="sortCheck('doctor_status_review', 'Unfit')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus3">Unfit</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus4"
                                                                        wire:click="sortCheck('doctor_status_review', 'Curently Unfit')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus4">Curently
                                                                        Unfit</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus5"
                                                                        wire:click="sortCheck('doctor_status_review', 'Fit With Recomendation')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus5">Fit With
                                                                        Recomendation</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input rounded-circle"
                                                                        type="checkbox" id="CheckBoxInspectStatus6"
                                                                        wire:click="sortCheck('doctor_status_review', 'Fit')">
                                                                    <label class="form-check-label fw-normal"
                                                                        for="CheckBoxInspectStatus6">Fit</label>
                                                                </div> --}}
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
                                @foreach ($this->McuDatas as $itemIndex => $items)
                                    <tr wire:key="'{{ $itemIndex }}'"
                                        wire:click="onSelectedItem('{{ $items->id }}')"
                                        @if (in_array($items->id, $itemSelected)) class="selected" @else class="tr" @endif>
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>

                                        @if (in_array('Nama Pasien', $selectedColumns))
                                            <td>
                                                @isset($items->employee->name)
                                                    <a href="{{ route('mcu::medical-staff-detail', $items['id']) }}"
                                                        style="font-weight: 600; color: #00552f;">
                                                        {{ $items->employee->name }}
                                                    </a>
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Tanggal MCU', $selectedColumns))
                                            <td>
                                                <a href="{{ route('mcu::medical-staff-detail', $items['id']) }}"
                                                    style="font-weight: 600; color: #00552f;">
                                                    {{ \Carbon\Carbon::parse($items->mcu_date)->format('d F Y') }}
                                                </a>
                                            </td>
                                        @endif
                                        @if (in_array('Tanggal Pembuatan', $selectedColumns))
                                            <td>
                                                @isset($items->employee)
                                                    {{ \Carbon\Carbon::parse($items->created_at)->format('d F Y') }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Perusahaan', $selectedColumns))
                                            <td>
                                                @isset($items->employee->user->department)
                                                    {{ $items->employee->user->department->company->company_name }}
                                                @endisset
                                            </td>
                                        @endif
                                        @if (in_array('Departemen', $selectedColumns))
                                            <td>
                                                @isset($items->employee->user->department)
                                                    {{ $items->employee->user->department->name }}
                                                @endisset
                                            </td>
                                        @endif

                                        @if (in_array('Status Kesehatan', $selectedColumns))
                                            <td class="text-center">
                                                <span {{-- class="done">{{ $items->doctor_status_review }}</span> --}}
                                                    class="{{ $items->doctor_status_review == 'draft' ? 'pending' : ($items->doctor_status_review == 'approved' ? 'success' : ($items->doctor_status_review == 'Fit With Recomendation' ? 'success' : ($items->doctor_status_review == 'Unfit' ? 'cancel' : ($items->doctor_status_review == 'Curently Unfit' ? 'cancel' : 'default')))) }}">{{ $items->doctor_status_review }}</span>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!-- /.table-wrapper -->

                </div><!-- /.table-content-->

            </div><!-- /.item-selected -->

        </div><!-- /.table-demo -->

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
            <span>{!! __('Rekam Medis') !!}</span>
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
                            <label for="excelFile" class="form-label mb-3">Excel File <small style="color: green;"><a
                                        href="{{ asset('mcu_attachment/template-excel_v_1_1.xlsx') }}"
                                        style="color:#3fb8ff;"><u>(Download Template Excel)</u></a></small></label>
                            <input class="form-control mb-3 @error('excelFile') is-invalid @enderror"
                                wire:model.debounce.500ms="excelFile" type="file">
                            <small class="mt-3" style="color: green;">(Fomat xlsx/xls)</small>

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

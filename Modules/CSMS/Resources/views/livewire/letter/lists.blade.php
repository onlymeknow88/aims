<div class="inner-content">
    <div>
        <div class="section-content">

            <div class="section-title py-3 px-2">
                <h4>Letter</h4>
            </div><!-- /.section-title -->

            <div class="table-demo position-relative">

                <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2">

                        <div class="toolbar-left d-flex align-items-center">

                            <a href="{{ route('csms::letter.create') }}" type="button"
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
                                <a href="{{ route('csms::letter.edit', $itemSelected) }}" type="button"
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
                                    <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                        <th class="sticky-top" wire:click="toggleSelectAll">
                                            <span class="icon-checked"></span>
                                        </th>
                                        @if (in_array('Letter Number', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Letter Number
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

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
                                                                            wire:model.1500ms="searchCompany"
                                                                            placeholder="Cari data" aria-label="Name"
                                                                            aria-describedby="search-icon">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    {{-- @foreach ($fieldCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('company_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach --}}
                                                                </div>

                                                            </div>
                                                            <!--./dropdown-content-->

                                                        </div><!-- /.dropdown-menu -->
                                                    </span>
                                                </div>
                                            </th>
                                        @endif
                                        @if (in_array('Title', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Title
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">

                                                                    <a href="#"
                                                                        class="sort sort-asc fw-normal d-block"
                                                                        wire:click="sort('asc', 'date')">Urutkan
                                                                        A-Z</a>
                                                                    <a href="#"
                                                                        class="sort sort-desc fw-normal d-block"
                                                                        wire:click="sort('desc', 'date')">Urutkan
                                                                        Z-A</a>

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
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

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
                                                                            wire:model.1500ms="searchCcow"
                                                                            placeholder="Cari data" aria-label="Name"
                                                                            aria-describedby="search-icon">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    {{-- @foreach ($fieldCcow as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('ccow_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">{{ $item->company_name }}</label>
                                                                    </div>
                                                                @endforeach --}}
                                                                </div>

                                                            </div>
                                                            <!--./dropdown-content-->

                                                        </div><!-- /.dropdown-menu -->
                                                    </span>
                                                </div>
                                            </th>
                                        @endif
                                        @if (in_array('Initiator KTT', $selectedColumns))
                                            <th class="sticky-top">
                                                <div class="column-sort d-flex justify-content-between">
                                                    <span>
                                                        Initiator KTT
                                                    </span>
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">

                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    {{-- @foreach ($fieldDetailCompany as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('detail_company', '{{ $index }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">{{ $index }}</label>
                                                                    </div>
                                                                @endforeach --}}
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
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

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
                                                                            placeholder="Cari data" aria-label="Name"
                                                                            aria-describedby="search-icon">
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="sort-list d-flex gap-3 flex-column mh-200px overflow-auto">
                                                                    {{-- @foreach ($fieldDepartment as $index => $item)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input rounded-circle"
                                                                               type="checkbox" value=""
                                                                               id="flexCheckDefault"
                                                                               wire:click="sortCheck('department_id', '{{ $item->id }}')">
                                                                        <label class="form-check-label fw-normal"
                                                                               for="flexCheckDefault">{{ $item->name }}</label>
                                                                    </div>
                                                                @endforeach --}}
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
                                                    <span>
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/icons/filter-default.svg') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end shadow-lg"
                                                            wire:ignore.self>

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
                                            @if (in_array('Letter Number', $selectedColumns))
                                                <td>{{ $items->letter_number ?? '-' }}</td>
                                            @endif
                                            @if (in_array('Title', $selectedColumns))
                                                <td>{{ $items->title ?? '-' }}</td>
                                            @endif
                                            @if (in_array('CCOW', $selectedColumns))
                                                <td>{{ $items->ccow->company_name ?? '-' }}</td>
                                            @endif
                                            @if (in_array('Initiator KTT', $selectedColumns))
                                                <td>{{ $items->ktt_id ?? '-' }}</td>
                                            @endif
                                            @if (in_array('Date', $selectedColumns))
                                                <td scope="row">
                                                    {{ Carbon\Carbon::parse($items->date)->format('F d, Y') }}
                                                </td>
                                            @endif
                                            @if (in_array('Status', $selectedColumns))
                                                <td>
                                                    <span
                                                        class="{{ $items->status == 'Active' ? 'done' : 'cancel' }}">
                                                        {{ $items->status }}
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
                            <button type="button" class="btn btn-outline-danger"
                                data-bs-dismiss="modal">Cancel</button>
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

</div>

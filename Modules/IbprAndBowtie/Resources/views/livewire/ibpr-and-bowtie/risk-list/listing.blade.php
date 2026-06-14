@push('styles')
    <style>
        .table-document {
            width: 150%;
        }

        .table-document thead tr th:nth-child(2) {
            width: 10%;
        }
        .table-document thead tr th:nth-child(3) {
            width: 5%;
        }

        .text-link {
            color:green;
            font-weight: bold;
        }
    </style>
@endpush

<div class="inner-content">
    <div class="section-content">
        <div class="section-title py-3 px-2">
            <h4>Daftar Bowtie</h4>
        </div><!-- /.section-title -->
        <div class="table-maker">
            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">
                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
                    <div class="toolbar-right d-flex align-items-center">
                        @if($countSelected > 0 )
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif
            
                    </div><!-- /.toolbar-right -->
            
                </div><!-- /.toolsbar-tables -->
            
                <div class="table-content table-responsive position-relative">

                    <div class="table-wrapper overflow-auto">

                        <table class="table" style="height: fit-content">
                            <thead>
                                <tr>
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Nomor Dokument
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
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Judul Risiko
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
                                        <th>
                                            <div class="column-sort d-flex justify-content-between">
                                                <span>
                                                    Dokument Bowtie
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bowtie as $index => $item)
                                <tr>
                                    <td>{{ $item->document_no }}</td>
                                    <td>{{ $item->risk_title }}</td>
                                    <td>Ya</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
            
                    </div><!-- /.table-wrapper -->
            
                    {{-- <div class="info bg-white px-3 pt-0" x-show="info">
                        <livewire:document-systems.maker.sidebar-info />
                    </div> --}}
            
                </div><!-- /.table-content-->
            
                {{-- filter --}}
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
                                                    {{-- @foreach ($columns as $column => $detail)
                                                        @include('livewire.document-systems.maker.components.table-filter', [
                                                            'detail' => $detail,
                                                            'column' => $column,
                                                        ])
                                                    @endforeach --}}
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
                </div> <!-- end Filter -->
            
            </div>

        </div><!-- /.table-maker -->
    </div><!-- /.section-content -->
</div>

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        function confirmDelete() {
            newSwal.fire({
                title: 'Are you sure?',
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText : "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('submitDelete')
                    }
                },
            });
        }
    </script>
@endpush

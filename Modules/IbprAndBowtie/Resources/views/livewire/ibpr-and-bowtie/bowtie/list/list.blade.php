@push('styles')
    <style>
        .text-link {
            color:green;
            font-weight: bold;
        }
    </style>
@endpush

<div class="inner-content">
    <div class="section-content">
        <div class="section-title py-3 px-2">
            <h4>BOWTIE</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">
            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                    <div class="toolbar-left d-flex align-items-center">

                        @can('Ibpr And Bowtie - Create BOWTIE')
                            <a href="/ibpr-and-bowtie/bowtie/create" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                                <span class="icon d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                      </svg>
                                </span>
                                <span class="text-button">Add New</span>
                            </a>
                        @endcan

                        @if($countSelected > 0 )
                            <a type="button"
                                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                                onclick="confirmDelete()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                                <span class="text-button">Delete</span>
                            </a>
                        @endif

                    </div><!-- /.toolbar-left -->

                    <div class="toolbar-right d-flex align-items-center">

                        @if($countSelected > 0 )
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
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

                        <table class="table table-document">
                            <thead>
                                <tr>
                                    @if (in_array('No Document', $selectedColumns))
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-100">
                                                <span>
                                                    No Document
                                                </span>
                                                <span>
                                                    <button class="btn border-0 p-0" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ !empty($this->searchNumber) ? asset('images/icons/filter-solid.png') : asset('images/icons/filter-default.svg') }}"
                                                            alt="sorting" />
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" wire:ignore.self>

                                                        <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                            <div class="sort-search">
                                                                <div class="input-group">
                                                                    <span class="input-group-text border-end-0"
                                                                        id="search-icon">
                                                                        <img src="{{ asset('images/icons/search.png') }}"
                                                                            alt="Search"
                                                                            srcset="{{ asset('images/icons/search.png') }}">
                                                                    </span>
                                                                    <input type="text" class="form-control" wire:model.1500ms="searchNumber" placeholder="Cari data" aria-label="Name" aria-describedby="search-icon">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </th>
                                    @endif

                                    @foreach ($selectedColumns as $column)
                                        @if($column != 'No Document')
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-100">
                                                <span>
                                                    {{ $column }}
                                                </span>
                                            </div>
                                        </th>
                                        @endif
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $itemIndex => $items)
                                    <tr>
                                        <td><a href="/ibpr-and-bowtie/bowtie/detail/{{ $items->id }}" class="text-link">{{$items->document_no}}</a></td>
                                        <td>{{ $items->iup }}</td>
                                        <td>{{ $items->ccow->company_name ?? '-' }}</td>
                                        <td>{{ $items->contractor->company_name ?? '-' }}</td>
                                        <td>{{ $items->sub_contractor->company_name ?? '-' }}</td>
                                        <td>{{ $items->department->name ?? "-" }}</td>
                                        <td>{{ $items->pja->name ?? '-' }}</td>
                                        <td>{{ $items->approve_at ?? '-'}}</td>
                                        <td>{{ $items->next_date ?? '-'}}</td>
                                        <td>{{ $items->status ?? '-'}}</td>
                                        <td><a href="" wire:click.prevent="export('{{ $items->id }}')" class="btn btn-outline-danger"><i class="fa-solid fa-file-export"></i> Export</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!-- /.table-wrapper -->

                    {{-- <div class="info bg-white px-3 pt-0" x-show="info">
                        <livewire:document-systems.maker.sidebar-info />
                    </div> --}}

                </div><!-- /.table-content-->

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

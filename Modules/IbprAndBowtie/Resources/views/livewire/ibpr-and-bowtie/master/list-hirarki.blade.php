

<div class="inner-content">
    <div class="section-content">
        <div class="section-title py-3 px-2">
            <h4>Master Hirarki Kendali</h4>
        </div><!-- /.section-title -->

        <div class="table-maker" style="padding-left: 300px; padding-right: 300px; padding-top: 50px;">
            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
            
                    <div class="toolbar-left d-flex align-items-center">
            
                        {{-- @if($title === 'Active') --}}
                        <a onclick="openModalMasterHirarki()" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                            <span class="text-button">Add New</span>
                        </a>
                    
                        <a type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                            onclick="confirmDelete()">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a>
                    </div><!-- /.toolbar-left -->
            
                    <div class="toolbar-right d-flex align-items-center">
            
                        @if($countSelected > 0 )
                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="removeSeleced()">
                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                                <span class="text-button">{{ $countSelected }} Row Selected</span>
                            </a>
                        @endif
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/sort.png')}}" alt="image add"></span>
                        </a>
            
                        <a href="#"
                            type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" data-bs-toggle="modal"
                            data-bs-target="#sortModal_table"><span class="icon d-flex align-items-center">
                            <img src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3" wire:click="activedInfo()">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/info.png')}}" alt="image info"></span>
                        </a>
            
                        <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
                        </a>
            
                    </div><!-- /.toolbar-right -->
            
                </div><!-- /.toolsbar-tables -->
            
                <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">
                    <div class="table-wrapper">

                        <table class="table table-document">
                            <thead>
                                <tr>
                                    <th></th>
                                    @foreach ($columns as $column => $d)
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-100">
                                                <span>
                                                    {{ $column }}
                                                    <span style="position: relative;">
                                                        <button class="btn border-0 p-0" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="{{ asset('images/icons/sorting.png') }}"
                                                                alt="sorting" />
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" style="width: 384px; postition:absolute;">
                                                            <div class="dropdown-content p-3 d-flex gap-3 flex-column">
                                                                <div class="sort-search">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text border-end-0"
                                                                            id="search-icon">
                                                                            <img src="{{ asset('images/icons/search.png') }}"
                                                                                alt="Search"
                                                                                srcset="{{ asset('images/icons/search.png') }}">
                                                                        </span>
                                                                        <input 
                                                                            type="text" 
                                                                            class="form-control"
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
                                                </span>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $itemIndex => $items)
            
                                        <tr wire:key="{{ $itemIndex }}">
                                            <td class="td-check">
                                                @if(in_array($items->id, $itemSelected))
                                                        <span class="icon-checked selected"></span>
                                                @else
                                                    <span class="icon-checked"></span>
                                                @endif
                                            </td>
                                            <td><a href="/ibpr-and-bowtie/bowtie/detail/{{ $items->id }}" class="text-link">{{ $itemIndex + 1 }}</a></td>
                                            <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ $items->name }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" wire:click="open_edit('{{ $items->id }}', '{{ $items->name }}')">Edit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                        <tr>
                                            <td colspan="14" class="text-center">@lang('global.empty_data')</td>
                                        </tr>
                                @endif
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
                                                    @foreach ($columns as $column => $detail)
                                                        @include('livewire.document-systems.maker.components.table-filter', [
                                                            'detail' => $detail,
                                                            'column' => $column,
                                                        ])
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
                </div> <!-- end Filter -->
            
            </div>
        </div><!-- /.table-maker -->
    </div><!-- /.section-content -->

    <div wire:ignore.self class="modal fade" id="modal_master_hirarki" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_master_hirarkiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <div class="modal-title" id="modal_master_hirarkiLabel">Keselamatan Hirarki Pertambangan</div>
                <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
    
            <div class="row mb-3">
                <label for="code" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <x-inputs.text 
                        wire:model.defer="name"
                        id="name"
                        error="'name'"
                        placeholder="Nama"
                    />
                </div>
            </div>
                
            <hr />
            <br />
            <div class="modal-footer">
                <div class="flex w-full justify-end gap-3">
                    <button onclick="closeModalMasterHirarki()" type="button" class="btn btn-danger">
                        Cancel
                    </button>
    
                    @if($is_edit === false)
                    <button type="button" wire:click="submit" class="btn btn-success">
                        Add
                    </button>
                    @else
                    <button type="button" wire:click="submit_edit" class="btn btn-success">
                        Save
                    </button>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>
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

        function closeModalMasterHirarki() {
            $('#modal_master_hirarki').modal('hide');
        }

        function openModalMasterHirarki() {
            $('#modal_master_hirarki').modal('show');
        }

        Livewire.on('closeModalHirarki', () => {
            closeModalMasterHirarki();
        })

        Livewire.on('openModalHirarki', () => {
            openModalMasterHirarki();
        })
    </script>
@endpush

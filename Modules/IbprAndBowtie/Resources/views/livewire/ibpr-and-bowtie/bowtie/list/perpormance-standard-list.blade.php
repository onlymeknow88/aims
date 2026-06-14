@push('styles')
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
@endpush

<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{ session('route') }}" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Back</span>
            </a>
        </div><!-- /.left-header -->
    </div>

    <div class="section-content">

        <div class="py-3 px-2 flex gap-4">
            <div class="section-title ">
                <p class="text-xl text-black">Bowtie Perpormance Standard List</p>
            </div>
            <div class="flex items-end">
                <p class="text-sm text-gray-600">{{ $bowtie->no_document }}</p>
            </div>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

                <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">
            
                    <div class="toolbar-left d-flex align-items-center">
                        <button onclick="tryToOpenModalPerformance()" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                            <span class="text-button">Add Form</span>
                        </button>
                        
                        <!-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                            <span class="text-button">Export</span>
                        </a>
            
                        <a type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                            wire:click.prevent="confirmDelete">
                            <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/delete.png')}}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a> -->
                    </div><!-- /.toolbar-left -->
            
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
                                    
                                    @foreach ($columns as $column => $d)
                                        <th style="min-width: 150px;">
                                            <div class="column-sort d-flex justify-content-between w-full">
                                                <span>
                                                    {{ $column }}
                                                    
                                                </span>
                                            </div>
                                        </th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) > 0)
                                    @foreach ($data as $itemIndex => $item)
                                        <tr>
                                            
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->name }}</td>
                                            <!-- <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->department->name ?? '' }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->section->name ?? '' }}</td> -->
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->responsible_person }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->purpose }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->design_standard }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->operation_standard }}</td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->ospek }}</td>
                                            <td wire:click.prevent="downloadFile('{{ $item->obesrvation_file }}')">
                                                <p class="text-green-700 duration-500 hover:scale-105">{{ $item->obesrvation_file_name }}</p>
                                            </td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->obesrvation }}</td>
                                            <td wire:click.prevent="downloadFile('{{ $item->test_efectivity_file }}')">
                                                <p class="text-green-700 duration-500 hover:scale-105">{{ $item->test_efectivity_file_name }}</p>
                                            </td>
                                            <td wire:click.prevent="onSelectedItem('{{ $item->id }}')">{{ $item->implementation_test_efectivity }}</td>
    
                                            <td>
                                                <button type="button" onclick="openModalEditCca('{{ $item->id }}')" class="px-3 py-2 bg-green-500 rounded-md text-white duration-300 hover:bg-green-700" onclick="clickEditModalFromList('{{ $item->id }}')">
                                                    Edit
                                                </button>
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

    <livewire:ibprandbowtie::bowtie.modal.modal-performance :bowtie_id="$bowtie_id"/>

    @push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        window.addEventListener('confirm-delete', () => {
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
                didOpen: () => {
                    const cancelButton = Swal.getCancelButton();
                    cancelButton.style.color = 'black';
                }
            });
        });

        $('#modal_performance').on('hide.bs.modal', function (e) {
            Livewire.emit('check_perpormance_standard');
        });
    
       
        function tryToOpenModalPerformance() {
            Livewire.emit('clear_performance_modal')
            $("#modal_performance").modal("show");
        }

        function openModalEditCca(id){
            Livewire.emit('click_edit_performance', id)
        }

    </script>
    @endpush
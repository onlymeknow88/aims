@push('styles')
    <style>
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
@endpush

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">

            @if (auth()->user()->can('Create Document'))
                <a href="/maker/add-maker" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                    <span class="text-button">Add New</span>
                </a>
            @endif

            @if($countSelected > 0 )
            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/export.png')}}" alt="image export"></span>
                <span class="text-button">Export</span>
            </a>

            <a type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click.prevent="confirmDelete">
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
                            <th>{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) > 0)
                        @foreach ($data as $itemIndex => $items)

                            <tr wire:key="{{ $itemIndex }}" wire:click="selectRow({{ $itemIndex }})>
                                <td class="td-check">
                                    @if(in_array($items->id, $itemSelected))
                                            <span class="icon-checked selected"></span>
                                    @else
                                        <span class="icon-checked"></span>
                                    @endif
                                </td>
                                <td class="title"><a href="{{ route('detail-maker', ['id' => $items->id, 'type' => 'active-document']) }}">{{$items->title}}</a></td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ $items->fix_document_number }}</td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ $items->department->company->company_name }}</td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ $items->department->name }}</td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                    <span>
                                        <img src="{{asset('images/icons/user.png')}}" alt="">
                                    </span>
                                    {{ $items->user->name }}
                                </td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ $items->mapping->category->module->name }}</td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">{{ date('d F Y', strtotime($items->doc_created)) }}</td>
                                <td wire:click.prevent="onSelectedItem('{{ $items->id }}')">
                                    <span>{!! $items->status_badge !!}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <td colspan="9" class="text-center">@lang('global.empty_data')</td>
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

@push('scripts')
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
            });
        });
    </script>
@endpush

@section('title')
    Setup Category
@endsection

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">
            <a href="{{ route('sap-setup-category-create') }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add New Category</span>
            </a>


            <a type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                wire:click="confirmDelete">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/delete.png') }}"
                        alt="image delete"></span>
                <span class="text-button">Delete</span>
            </a>

        </div><!-- /.toolbar-left -->

        <div class="toolbar-right d-flex align-items-center">
            {{-- <input type="text" class="form-control form-sm-control" wire:model="search" wire:keydown="render()"
                placeholder="search"> --}}

            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3"
                onclick="openNav()"><span class="icon d-flex align-items-center">
                    <img src="{{ asset('images/icons/filter.png') }}"alt="image export"></span>
            </a>
        </div><!-- /.toolbar-right -->

    </div><!-- /.toolsbar-tables -->

    <div class="container-spinner">
        <div class="spinner-center spinner-border" role="status" wire:loading>
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="table-wrapper">
            <table class="table table-document">
                <thead>
                    <tr>
                        <th>
                            <input wire:change="SelectAll" wire:model="itemSelectedAll" value="true"
                                class="form-check-input" type="checkbox" />
                        </th>
                        <th>Category</th>
                        {{-- <th>Available</th> --}}
                        <th>Add Setup</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) > 0)
                        @foreach ($data as $index => $list)
                            <tr> 
                                {{-- wire:key="{{ $index }}" wire:click="SelectRow('{{ $list->id }}')" --}}
                                <td>
                                    <input class="form-check-input" name="selected" type="checkbox"
                                        value="{{ $list->id }}" id="selected" x-model="itemSelected" />
                                </td>
                                <td>{{ $list['name'] }} </td>
                                {{-- <td class="text-center">
                                    <div class="form-check form-switch text-center">
                                        <input class="form-check-input" type="checkbox" name="flexRadioDefault"
                                            wire:change="AvailableChange('{{ $list->id }}')" value="true"
                                            id="flexSwitchCheckDefault"
                                            @if ($list['available'] == 'true') checked @endif>
                                        <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                    </div>
                                </td> --}}
                                <td class="text-center">
                                    <a href="{{ route('sap-setup-index', $list->id) }}" class="text-center">
                                        <span class="icon d-flex align-items-center text-center"><img
                                                src="{{ asset('images/icons/add.png') }}" alt="image add"></span>
                                    </a>
                                </td>

                                <td><span>
                                        <a href="{{ route('sap-setup-category-update', $list->id) }}">
                                            <i class="fas fa-pencil-alt fa-1x"></i>
                                        </a>
                                    </span>
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

    </div><!-- /.table-content-->

    {{-- @livewire('sap::setup.create') --}}

</div>

@push('styles')
    <style>
        .table-document {
            width: 100%;
        }

        .table-document tbody tr td {
            color: gray
        }

        .table-document tbody tr td:nth-child(1),
        .table-document tbody tr td:nth-child(6) {
            width: 5%;
            text-align: center;
        }

        .table-document tbody tr td:nth-child(2),
        .table-document tbody tr td:nth-child(3),
        .table-document tbody tr td:nth-child(4),
        .table-document tbody tr td:nth-child(5),
        {
        width: 20%;
        text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        window.addEventListener('confirm-delete', () => {
            newSwal.fire({
                title: 'Are you sure?',
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText: "{{ trans('global.cancel') }}",
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

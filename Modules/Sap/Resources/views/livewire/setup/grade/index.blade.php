@section('title')
    Setup {{ $category_name }}
@endsection

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

        <div class="toolbar-left d-flex align-items-center">
            <a href="{{ route('sap-setup-create', $category_id) }}" type="button"
                class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                <span class="icon d-flex align-items-center"><img src="{{ asset('images/icons/add.png') }}"
                        alt="image add"></span>
                <span class="text-button">Add New</span>
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
                        <th rowspan="2">
                            <input wire:change="SelectAll" wire:model="itemSelectedAll" value="true"
                                class="form-check-input" type="checkbox" />
                        </th>
                        <th rowspan="2">Safety Accountability Progam</th>
                        <th colspan="3" class="text-center">Posisi</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    <tr>
                        <th>Dept. Head</th>
                        <th>Foreman Supervisor & Sec. Head</th>
                        <th>Employee</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data as $index => $list)
                        <tr>
                            {{-- wire:key="{{ $index }}" wire:click="SelectRow('{{ $list->id }}')" --}}
                            <td>
                                <input class="form-check-input" name="selected" type="checkbox"
                                    value="{{ $list->id }}" id="selected" x-model="itemSelected" />
                            </td>
                            <td>{{ $list['safety_accountability_progam'] }} </td>
                            <td>{{ $list['dept_head'] }} </td>
                            <td>{{ $list['foreman_supervisor_sechead'] }} </td>
                            <td>{{ $list['employee'] }} </td>
                            <td>
                                <span>
                                    <a href="{{ route('sap-setup-update', [$list->category_id, $list->id]) }}">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @endforeach

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
        }

        .table-document tbody tr td:nth-child(2),
        .table-document tbody tr td:nth-child(3),
        .table-document tbody tr td:nth-child(4),
        .table-document tbody tr td:nth-child(5),
        {
        width: 20%;
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

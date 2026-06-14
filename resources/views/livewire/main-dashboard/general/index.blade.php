@section('title')
    Slideshow
@endsection

@push('styles')
    <style>
        .table-document {
            width: 100%;
        }

        .table-document thead tr th:nth-child(1) {
            width: 5%;
        }

        .table-document thead tr th:nth-child(2) {
            width: 20%;
        }

        .table-document thead tr th:nth-child(3) {
            width: 20%;
        }

        .table-document thead tr th:nth-child(4) {
            width: 20%;
        }

        .table-document thead tr th:nth-child(5) {
            width: 20%;
        }

        .table-document thead tr th:nth-child(6) {
            width: 5%;
        }
    </style>
@endpush

<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">
    <div class="row justify-content-center">

        <div class="col-11">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif

            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                <div class="toolbar-left d-flex align-items-center">
                    <a href="{{ route('general_create') }}" type="button"
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


                </div><!-- /.toolbar-right -->

            </div><!-- /.toolsbar-tables -->

            <div class="table-content " :class="info ? 'infoOpen' : ''">
                <div class="table-wrapper">

                    <table class="table table-document">
                        <thead>
                            <tr>
                                <th>
                                    <input wire:change="SelectAll" wire:model="itemSelectedAll" value="true"
                                        class="form-check-input" type="checkbox" />
                                <th>Visible</th>
                                <th>Month</th>
                                <th>Project to Date</th>
                                <th>manhours</th>
                                <th>Day After Last LTI</th>
                                <th>Manpower</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $list)
                                <tr>
                                    <td>
                                        <input class="form-check-input" name="selected" type="checkbox"
                                            value="{{ $list->id }}" id="selected" x-model="itemSelected" />
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch text-center">
                                            <input class="form-check-input" type="checkbox" name="flexRadioDefault"
                                                wire:change="AvailableChange('{{ $list->id }}')" value="true"
                                                id="flexSwitchCheckDefault"
                                                @if ($list->visible == 'true') checked @endif>
                                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                        </div>
                                    </td>
                                    <td>{{ $list->monthYear }}</td>

                                    <td>
                                        <div>
                                            {{ $list->project_to_date }}
                                            <span>
                                                @if ($list->project_to_date_mark == 'UP')
                                                    <i class="fa-solid fa-caret-up icon text-success"></i>
                                                @elseif ($list->project_to_date_mark == 'DOWN')
                                                    <i class="fa-solid fa-caret-down icon text-danger"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $list->manhours }}
                                        <span>

                                            @if ($list->manhours_mark == 'UP')
                                                <i class="fa-solid fa-caret-up icon text-success"></i>
                                            @elseif ($list->manhours_mark == 'DOWN')
                                                <i class="fa-solid fa-caret-down icon text-danger"></i>
                                            @endif
                                        </span>

                                    </td>
                                    <td>
                                        {{ $list->day_after_last_lti }}
                                        <span>

                                            @if ($list->day_after_last_lti_mark == 'UP')
                                                <i class="fa-solid fa-caret-up icon text-success"></i>
                                            @elseif ($list->day_after_last_lti_mark == 'DOWN')
                                                <i class="fa-solid fa-caret-down icon text-danger"></i>
                                            @endif
                                        </span>

                                    </td>
                                    <td>
                                        {{ $list->manpower }}
                                        <span>

                                            @if ($list->manpower_mark == 'UP')
                                                <i class="fa-solid fa-caret-up icon text-success"></i>
                                            @elseif ($list->manpower_mark == 'DOWN')
                                                <i class="fa-solid fa-caret-down icon text-danger"></i>
                                            @endif
                                        </span>

                                    </td>
                                    <td><a href="{{ route('general_edit', $list->id) }}"><i
                                                class="fas fa-pencil-alt fa-1x"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-wrapper -->

                {{-- <div class="info bg-white px-3 pt-0" x-show="info">
            <livewire:document-systems.maker.sidebar-info />
        </div> --}}
            </div><!-- /.table-content-->
            {{ $data->links('pagination::bootstrap-5') }}

            {{-- filter --}}
            <div class="modal fade" id="sortModal_table" tabindex="-1" aria-labelledby="sortModal_tableLabel"
                aria-hidden="true" style="display: none;" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sortModal_tableLabel">Filter & Sort</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="filterSort">

                            <div class="modal-body">
                                <div class="bootstrap-table">

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

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="resetFilterSort()">Reset</button>
                                <button type="submit" class="btn btn-primary multi-sort-order-button"
                                    data-bs-dismiss="modal">Sort</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end Filter -->
        </div>
    </div>
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

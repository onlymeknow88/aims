@push('styles')
    <style>
        .table-content {
            min-height: 300px;
        }
    </style>
@endpush

<div class="inner-content">

    @include('livewire.document-systems.master.add-mapping')

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>@lang('global.mapping')</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">
            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                <div class="toolbar-left d-flex align-items-center">

                    <a wire:click.prevent="createMapping"
                        data-bs-toggle="modal"
                        data-bs-target="#modalForm"
                        type="button"
                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                        <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/add.png')}}" alt="image add"></span>
                        <span class="text-button">Add New</span>
                    </a>

                    @if($countSelected > 0 )
                        <a wire:click.prevent="confirmBulkDelete" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
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

                </div><!-- /.toolbar-right -->

            </div><!-- /.toolsbar-tables -->

            <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">

                <div class="table-wrapper">

                    <table class="table overflow-auto">
                        <thead>
                            <tr>
                                <th style="width: 5%;"></th>
                                <th>@lang('global.name')</th>
                                <th>@lang('global.category')</th>
                                <th style="width: 5%;">@lang('global.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($mappings) > 0)
                                @foreach ($mappings as $key => $item)
                                    <tr id="module-{{ $item['id'] }}"
                                        class="@if(in_array($item['id'], $selected_rows)) selected @endif">
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            @if (in_array($item['id'], $selected_rows))
                                                <span class="icon-checked selected"></span>
                                            @else
                                                <span class="icon-checked"></span>
                                            @endif
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>{{ $item['name'] }}</td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>{{ $item->category->name }}</td>
                                        <td class="action">
                                            {{-- <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
                                            </a> --}}
                                            <div class="dropdown text-center">
                                                <a type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <button type="button"
                                                        class="dropdown-item"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalForm"
                                                        wire:click="editMapping(`{{ $item['id'] }}`)">
                                                        Edit
                                                    </button>
                                                    </li>
                                                  <li>
                                                    <button class="dropdown-item"
                                                        wire:click.prevent="confirmDelete('{{ $item['id'] }}')">
                                                    Delete</button>
                                                </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">@lang('global.no_entry_found')</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div><!-- /.table-wrapper -->

            </div><!-- /.table-content-->

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->
</div>

@push('scripts')
    <script>
        window.addEventListener('updateModalAttribute', (param) => {
            if (param.detail.type == 'edit') {
                $('#exampleModalLabel').html("{{ trans('global.edit_module') }}");
                $('#form-mapping').attr('wire:submit.prevent', `saveData('${param.detail.id}')`)
            } else if (param.detail.type == 'create') {
                $('#form-mapping').attr('wire:submit.prevent', `saveData()`)
            }
        });
        window.addEventListener('close-modal', () => {
            $('#modalForm').modal('hide');
        })
        window.addEventListener('confirm-delete', (id) => {
            let uid = id.detail;
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
                        return @this.call('submitDelete', uid)
                    }
                },
            });
        });
        window.addEventListener('confirmBulkDelete', () => {
            newSwal.fire({
                title: "{{ trans('global.bulk_confirmation') }}",
                text: "{{ trans('global.confirm_delete') }}",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: "{{ trans('global.yes') }}" + ' ' + "{{ trans('global.delete') }}",
                cancelButtonText : "{{ trans('global.cancel') }}",
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: function(result) {
                    if (result) {
                        return @this.call('submitBulkDelete')
                    }
                },
            });
        });

        // modal event
        $('#modalForm').on('hidden.bs.modal', () => {
            // reset form when user close the modal
            @this.reset_form();
            @this.clearErrorBag();
        });
        $('#modalForm').on('shown.bs.modal', () => {
            // set focus to name field
            $('#name').focus();
        });

    </script>
@endpush

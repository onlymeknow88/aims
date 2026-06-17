@push('styles')
    <style>
        .table-content {
            min-height: 300px;
        }
    </style>
@endpush

<div class="inner-content">

    @include('documentsystem::livewire.master.add-category')

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>@lang('global.categories')</h4>
        </div><!-- /.section-title -->

        <div class="table-maker" x-data="{ info: false }">
            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                <div class="toolbar-left d-flex align-items-center">

                    <a onclick="openCreateCategory()" type="button"
                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                        <span class="icon d-flex align-items-center">
                            <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                        </span>
                        <span class="text-button">Add New</span>
                    </a>

                    @if ($countSelected > 0)
                        <a wire:click.prevent="confirmBulkDelete" type="button"
                            class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                            <span class="icon d-flex align-items-center"><img
                                    src="{{ asset('images/icons/delete-top.svg') }}" alt="image delete"></span>
                            <span class="text-button">Delete</span>
                        </a>
                    @endif

                    @if ($countSelected == 1)
                        @php
                            $reset = reset($itemSelected);
                        @endphp
                        <a onclick="openEditCategory('{{ $reset }}')" type="button"
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

                </div><!-- /.toolbar-right -->

            </div><!-- /.toolsbar-tables -->

            <div class="table-content table-responsive position-relative" :class="info ? 'infoOpen' : ''">

                <div class="table-wrapper">

                    <table class="table overflow-auto">
                        <thead>
                            <tr @if ($selectAll) class="selected" @else class="tr" @endif>
                                <th class="sticky-top" wire:click="toggleSelectAll">
                                    <span class="icon-checked"></span>
                                </th>
                                <th>Index</th>
                                <th>@lang('global.name')</th>
                                <th>@lang('global.module')</th>
                                {{-- <th style="width: 5%;">@lang('global.action')</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($categories) > 0)
                                @foreach ($categories as $key => $item)
                                    <tr wire:key="{{ $key }}"
                                        wire:click="onSelectedItem('{{ $item->id }}')"
                                        @if (in_array($item->id, $itemSelected)) class="selected" @else class="tr" @endif>
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            {{ $item['index'] }}
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            {{ $item['name'] }}
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            {{ $item->module->name }}</td>
                                        {{-- <td class="action">
                                            <a href="#" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                                                <span class="icon d-flex align-items-center"><img src="{{asset('images/icons/menu.png')}}" alt="image menu"></span>
                                            </a>
                                            <div class="dropdown text-center">
                                                <a type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="icon d-flex align-items-center"><img
                                                            src="{{ asset('images/icons/menu.png') }}"
                                                            alt="image menu"></span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button" class="dropdown-item"
                                                            data-bs-toggle="modal" data-bs-target="#modalForm"
                                                            wire:click="editCategory(`{{ $item['id'] }}`)">
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
                                        </td> --}}
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
                $('#form-category').attr('wire:submit.prevent', `saveData('${param.detail.id}')`)
            } else if (param.detail.type == 'create') {
                $('#form-category').attr('wire:submit.prevent', `saveData()`)
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
                cancelButtonText: "{{ trans('global.cancel') }}",
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
                cancelButtonText: "{{ trans('global.cancel') }}",
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
             window.livewire.emit('select2');
        });

        // Open create modal: dispatch event directly in JS, no Livewire round-trip needed
        window.openCreateCategory = function() {
            $('#modalForm').modal('show');
            window.dispatchEvent(new CustomEvent('updateModalAttribute', {
                detail: { type: 'create' }
            }));
        };

        // Open edit modal: show modal first, then call Livewire editCategory
        window.openEditCategory = function(id) {
            // Open the modal immediately
            $('#modalForm').modal('show');
            // Call editCategory after modal is visible to avoid spinner on open
            @this.call('editCategory', id);
        };

        // Tampilkan spinner hanya saat saveData
Livewire.hook('message.processed', (message, component) => {
    $('#btn-save-spinner').addClass('d-none');
    $('#btn-save-label').removeClass('d-none');
    $('#btn-save-category').prop('disabled', false);
});

window.addEventListener('livewire:response', () => {
    $('#btn-save-spinner').addClass('d-none');
    $('#btn-save-label').removeClass('d-none');
    $('#btn-save-category').removeAttr('disabled');
});
    </script>
@endpush

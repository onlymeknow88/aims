@push('styles')
    <style>
        .table-content {
            min-height: 300px;
        }
    </style>
@endpush

<div class="inner-content">

    @include('documentsystem::livewire.master.add-module')

    {{-- Modal Import --}}
    <div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Module dari Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih File Excel</label>
                        <input type="file" wire:model="importFile" accept=".xlsx,.xls,.csv"
                            class="form-control @error('importFile') is-invalid @enderror" />
                        @error('importFile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div wire:loading wire:target="importFile" class="text-muted small mt-1">
                            Mengupload...
                        </div>
                    </div>

                    @if ($importDone)
                        <div class="alert alert-success py-2 small mb-2">✓ Import berhasil!</div>
                    @endif

                    @if (count($importErrors) > 0)
                        <div class="alert alert-warning py-2 small">
                            <strong>Baris yang dilewati:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach ($importErrors as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <small class="text-muted">
                        Format kolom Excel: <code>index</code>, <code>name</code>, <code>has_document_number</code>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" wire:click="importModule" wire:loading.attr="disabled"
                        wire:target="importModule" class="btn btn-primary">
                        <span wire:loading.remove wire:target="importModule">Import</span>
                        <span wire:loading wire:target="importModule">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>@lang('global.module')</h4>
        </div><!-- /.section-title -->

        <div class="table-maker" x-data="{ info: false }">
            <div class="toolbar-tables border-top border-bottom d-flex justify-content-between p-2 sticky-top">

                <div class="toolbar-left d-flex align-items-center">

                    <a data-bs-toggle="modal" data-bs-target="#modalForm" type="button"
                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                        <span class="icon d-flex align-items-center">
                            <img src="{{ asset('images/icons/add-new.svg') }}" alt="image add new">
                        </span>
                        <span class="text-button">Add New</span>
                    </a>

                    <a data-bs-toggle="modal" data-bs-target="#modalImport" type="button"
                        class="button-toolbar d-flex gap-2 align-items-center py-2 px-3">
                        <span class="icon d-flex align-items-center">
                            <img src="{{ asset('images/icons/add-new.svg') }}" alt="image import">
                        </span>
                        <span class="text-button">Import</span>
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
                            $reset = reset($selected_rows);
                        @endphp
                        <a wire:click="editModule(`{{ $reset }}`)" type="button" data-bs-toggle="modal"
                            data-bs-target="#modalForm"
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
                                {{-- <th style="width: 5%;">@lang('global.action')</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($modules) > 0)
                                @foreach ($modules as $key => $item)
                                    <tr wire:key="{{ $key }}" wire:click="selectTable('{{ $item->id }}')"
                                        @if (in_array($item->id, $selected_rows)) class="selected" @else class="tr" @endif>
                                        <td class="td-check">
                                            <span class="icon-checked"></span>
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            {{ $item['index'] }}
                                        </td>
                                        <td wire:click.prevent='selectTable(`{{ $item['id'] }}`)'>
                                            {{ $item['name'] }}
                                        </td>
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
                                                            wire:click="editModule(`{{ $item['id'] }}`)">
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
                $('#form-module').attr('wire:submit.prevent', `saveData('${param.detail.id}')`)
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

        // Reset state import saat modal ditutup
        $('#modalImport').on('hidden.bs.modal', () => {
            @this.call('resetImport');
        });

        // Auto close modal + redirect setelah import sukses
        window.addEventListener('import-success', () => {
            $('#modalImport').modal('hide');
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

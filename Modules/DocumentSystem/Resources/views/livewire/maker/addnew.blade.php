@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .alert-warning {
            background: rgba(255, 199, 0, 0.06);
            border: 1px solid #FFC700;
            border-radius: 8px;
        }

        #dropbox {
            width: 100%;
            height: 100px;
            background: rgba(129, 13, 168, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px dashed #810DA8;
            border-radius: 12px;
        }

        #dropbox.active {
            background: rgba(129, 13, 168, 0.1);
        }

        #select {
            text-decoration: underline;
            cursor: pointer;
        }

        #file {
            display: none;
        }

        .review-box {
            background: #FFFFFF;
            border: 1px solid #E5E5E5;
            border-radius: 8px;
            width: 100%;
            height: 150px;
            padding: 10px;
        }

        .review-box .name {
            width: 90%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 8px;
        }

        .review-box .header .delete-icon {
            cursor: pointer;
        }

        .review-box .header .file-icon {
            width: 30px;
            height: 30px;
        }

        .document-prefix {
            background-color: transparent !important;
            width: auto !important;
            border: 1px solid #ced4da;
            border-right: none !important;
        }

        .input-group-doc-form input {
            border-left: none !important;
        }

        .input-group-doc-form input:focus {
            border-color: #ced4da !important;
        }

        .input-group-text.is-invalid {
            border: 1px solid #dc3545;
            border-right: none;
        }
    </style>
@endpush

<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('document-systems::maker') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>@lang('global.add_new')</span>
            </a>
        </div><!-- /.left-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form wire:submit.prevent='saveData' wire:ignore.self class="form-horizontal">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Owner Information</h4>
                        </div>

                        <div class="mb-3 row form-group ">

                            <label for="company_id" class="col-sm-4 col-form-label">Company</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="company_id" placeholder="Select Company"
                                    :error="'company_id'" wire:model="company_id" disabled="{{ $readonly }}" data-child="department_id,listEmployee">

                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company['id'] }}">{{ $company['company_name'] }}</option>
                                    @endforeach

                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="department_id" class="col-sm-4 col-form-label">Department</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="department_id" placeholder="Select Department"
                                    error="department_id" wire:model="department_id" :disabled="$readonly || empty($company_id)" data-child="pic">

                                    @foreach ($departments as $key => $department)
                                        <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                                    @endforeach

                                </x-document-system-select-2>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-link text-info"
                                    wire:click="toggleDepartmentHelp">
                                    <i class="fas fa-info-circle"></i> Info
                                </button>

                                @if ($showDepartmentHelp)
                                    <div
                                        class="position-absolute mt-2 p-3 bg-white border rounded shadow-sm"
                                        style="z-index: 1000; max-width: 320px;">
                                        Hanya department yang sudah memiliki <b>Codes</b> pada bagian Admin yang akan muncul dalam daftar pilihan.
                                    </div>
                                @endif

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="pic" class="col-sm-4 col-form-label">Penanggung Jawab</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="pic" placeholder="Select Penanggung Jawab"
                                    error="pic" wire:model="pic" :disabled="$readonly || empty($department_id)">

                                    @foreach ($pics as $key => $itemPj)
                                        <option class="d-flex gap-2 align-items-center" value="{{ $itemPj['id'] }}">
                                            {{ $itemPj['name'] }}
                                        </option>
                                    @endforeach

                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.own-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Mapping Information</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <label for="module_id" class="col-sm-4 col-form-label">Module</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="module_id" placeholder="Select Module"
                                    wire:model="module_id" error="module_id" disabled="{{ $readonly }}" data-child="category_id">

                                    @foreach ($modules as $key => $module)
                                        <option value="{{ $module['id'] }}">{{ $module['index'] }}.
                                            {{ $module['name'] }}</option>
                                    @endforeach

                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="category_id" class="col-sm-4 col-form-label">Category</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="category_id" placeholder="Select Category Module"
                                    wire:model="category_id" error="category_id" data-child="mapping_id" :disabled="$readonly || empty($module_id)">

                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category['id'] }}">{{ $category['index'] }}.
                                            {{ $category['name'] }}</option>
                                    @endforeach

                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="mapping_id" class="col-sm-4 col-form-label">Mapping</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="mapping_id" placeholder="Select Mapping"
                                    error="mapping_id" wire:model="mapping_id" :disabled="$readonly || empty($category_id)">

                                    <option value="">Select Mapping</option>
                                    @foreach ($mapping as $key => $map)
                                        <option value="{{ $map->id }}">{{ $map->index }}. {{ $map->name }}
                                        </option>
                                    @endforeach

                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="doc-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Document</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <label for="upload_type" class="col-sm-4 col-form-label">@lang('global.upload_type')</label>

                            <div class="col-sm-8">

                                <x-document-system-select-2 id="upload_type" placeholder="Select upload metode"
                                    wire:model="upload_type">
                                    <option value="">@lang('global.select_upload_type')</option>
                                    <option value="document">Dokumen</option>
                                    <option value="record">Rekaman</option>
                                </x-document-system-select-2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group {{ $showDocumentType ? '' : 'd-none' }}">

                            <label for="document_type" class="col-sm-4 col-form-label">@lang('global.document_type')</label>

                            <div class="col-sm-8">
                                <x-document-system-select-2 id="document_type" placeholder="Choose document"
                                    wire:model="document_type">

                                    <option value="">@lang('global.choose_document')</option>
                                    @foreach ($documentTypes as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach

                                </x-document-system-select-2>
                            </div>

                        </div><!-- /.form-group -->

                        <div
                            class="mb-3 row form-group document-number {{ $document_type == \Modules\DocumentSystem\Entities\Document::SOP_DOC_TYPE ? '' : 'd-none' }}">

                            <label for="sop_number" class="col-sm-4 col-form-label">@lang('global.sop_number')</label>

                            <div class="col-sm-8">
                                @if ($template_form != '')
                                    <div class="input-group">
                                        <span
                                            class="input-group-text document-prefix @error('sop_number') is-invalid @enderror"
                                            id="basic-addon1">{{ $template_form }}</span>
                                        <input type="text" id="sop_number1"
                                            class="form-control autocomplete-sop @error('sop_number') is-invalid @enderror"
                                            wire:model="sop_number" autocomplete="off"
                                            placeholder="{{ trans('global.sop_number') }}"
                                            aria-describedby="basic-addon1" disabled="{{ $readonly }}">
                                    </div>
                                    @error('sop_number')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @if (!empty($errorMessageSop))
                                        <div class="invalid-feedback d-block">
                                            {{ $errorMessageSop }}
                                        </div>
                                    @endif
                                @else
                                    <input type="text" class="form-control"
                                        placeholder="{{ trans('global.sop_number') }}"
                                        aria-describedby="basic-addon1">
                                @endif
                            </div>

                        </div><!-- /.form-group -->

                        <div
                            class="mb-3 row form-group {{ $document_type == \Modules\DocumentSystem\Entities\Document::WIN_DOC_TYPE || $document_type == \Modules\DocumentSystem\Entities\Document::FORM_DOC_TYPE ? '' : 'd-none' }}">

                            <label for="select_sop_number" class="col-sm-4 col-form-label">@lang('global.sop_number')</label>

                            <div class="col-sm-8">
                                <x-document-system-select-2 id="select_sop_number" placeholder="Choose document"
                                    wire:model="select_sop_number" disabled="{{ $readonly }}">

                                    <option value="">@lang('global.choose_document')</option>
                                    @if (!empty($activeSopNumbers))
                                        @foreach ($activeSopNumbers as $key => $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->prefix_code }}{{ $item->sop_number }}
                                            </option>
                                        @endforeach
                                    @endif

                                </x-document-system-select-2>
                            </div>

                        </div><!-- /.form-group -->

                        @if ($show_children_form)

                            {{-- <div class="mb-3 row form-group">

                                <label for="category_number" class="col-sm-4 col-form-label">
                                    Category Number
                                </label>

                                <div class="col-sm-8">
                                    <x-document-system-select-2 id="category_number" placeholder="Choose document"
                                        wire:model="category_number">

                                        <option value="WIN">Working Instruction</option>
                                        <option value="FORM">FORM</option>

                                    </x-document-system-select-2>
                                </div>

                            </div><!-- /.form-group --> --}}

                            @if ($document_type == \Modules\DocumentSystem\Entities\Document::WIN_DOC_TYPE)
                                <div class="mb-3 row form-group document-number">

                                    <label for="win_number" class="col-sm-4 col-form-label">@lang('global.win_number')</label>

                                    <div class="col-sm-8">
                                        @if ($template_win_number != '')
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text document-prefix @error('win_number') is-invalid @enderror"
                                                    id="basic-addon2">{{ $template_win_number }}</span>
                                                <input type="text"
                                                    class="form-control autocomplete-sop @error('win_number') is-invalid @enderror"
                                                    id="win_number" wire:model="win_number"
                                                    placeholder="{{ trans('global.win_number') }}"
                                                    aria-describedby="basic-addon2" disabled="{{ $readonly }}">
                                            </div>
                                            @error('win_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" disabled
                                                placeholder="{{ trans('global.win_number') }}"
                                                aria-describedby="basic-addon2">
                                        @endif
                                    </div>

                                </div><!-- /.form-group -->
                            @endif

                            @if ($document_type == \Modules\DocumentSystem\Entities\Document::FORM_DOC_TYPE)
                                <div class="mb-3 row form-group document-number">

                                    <label for="form_number" class="col-sm-4 col-form-label">@lang('global.form_number')</label>

                                    <div class="col-sm-8">
                                        @if ($template_form_number != '')
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text document-prefix @error('form_number') is-invalid @enderror"
                                                    id="basic-addon3">{{ $template_form_number }}</span>
                                                <input type="text"
                                                    class="form-control autocomplete-sop @error('form_number') is-invalid @enderror"
                                                    id="form_number" wire:model="form_number"
                                                    placeholder="{{ trans('global.form_number') }}"
                                                    aria-describedby="basic-addon3" disabled="{{ $readonly }}">
                                            </div>
                                            @error('form_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @else
                                            <input type="text" class="form-control" disabled
                                                placeholder="{{ trans('global.form_number') }}"
                                                aria-describedby="basic-addon3">
                                        @endif
                                    </div>

                                </div><!-- /.form-group -->
                            @endif

                            {{-- <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <div
                                        class="alert alert-warning text-center d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/icons/exclamation.png') }}" alt="">
                                        @lang('global.sop_form_alert')
                                    </div>
                                </div>
                            </div> --}}
                        @endif

                        <div
                            class="mb-3 row form-group document-number {{ $document_type != \Modules\DocumentSystem\Entities\Document::SOP_DOC_TYPE && $document_type != \Modules\DocumentSystem\Entities\Document::WIN_DOC_TYPE && $document_type != \Modules\DocumentSystem\Entities\Document::FORM_DOC_TYPE ? '' : 'd-none' }}">
                            <label for="document_number" class="col-sm-4 col-form-label">
                                @lang('global.document_number')
                            </label>
                            <div class="col-sm-8">
                                <div class="@if ($showDocumentType) input-group @endif">
                                    @if ($showDocumentType)
                                        <span
                                            class="input-group-text document-prefix @error('document_number') is-invalid @enderror"
                                            id="basic-addon4">{{ $template_document_number }}</span>
                                    @endif
                                    <input type="text"
                                        class="form-control @error('document_number') is-invalid @enderror"
                                        id="document_number" wire:model="document_number"
                                        placeholder="{{ trans('global.document_number') }}"
                                        aria-describedby="basic-addon4" {{ $readonly ? 'disabled' : '' }}>
                                </div>
                                @error('document_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- @endif --}}


                    </div><!-- /.doc-info -->

                    <div class="detail-doc mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">@lang('global.detailed_document')</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <label for="title" class="col-sm-4 col-form-label">Title</label>

                            <div class="col-sm-8">
                                <x-inputs.text wire:model="title" id="title" error="title"
                                    placeholder="Document title"></x-inputs.text>
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="doc_created" class="col-sm-4 col-form-label">Date of Create Document</label>

                            <div class="col-sm-8">
                                <x-inputs.datepicker wire:model="doc_created" id="doc_created" :error="'doc_created'" />
                            </div>

                        </div><!-- /.form-group -->


                    </div><!-- /.detail-doc -->

                    <div class="invited-people mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Invited People</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <div class="col-sm-12" wire:ignore>
                                <select id="listEmployee" placeholder="Choose document" wire:model="invitedPeople"
                                    data-placeholder="Select Employee" class="form-select w-100 select2"
                                    multiple="multiple" @if(empty($company_id)) disabled @endif>
                                    @foreach ($listEmployee as $key => $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group d-flex gap-3 flex-wrap">
                            @if ($invitedPeople)
                                {{-- @foreach ($invitedPeople as $key => $people)
                                    <div
                                        class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center">
                                        <span class="opacity-80">{{ $people }}</span>
                                        @if (!$readonly)
                                            <button class="btn-closed"><img
                                                    src="{{ asset('/images/icons/delete.png') }}"
                                                    wire:click.prevent="removeInvited('{{ $people }}')"
                                                    alt=""></button>
                                        @endif
                                    </div>
                                @endforeach --}}
                                <div class="form-group mt-2">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            wire:model="notify_via_email" id="notify_via_email" checked>
                                        <label class="form-check-label"
                                            for="notify_via_email">@lang('global.notify_via_email')</label>
                                    </div>
                                </div>
                            @endif

                        </div><!-- /.form-group -->


                    </div><!-- /.invited-people -->

                    <div class="description mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Description</h4>
                        </div>

                        <div class="mb-3 row form-group ">

                            <div class="col-sm-12">
                                <x-inputs.texteditor-custom wire:model="description" id="description"
                                    model="description" :error="'description'" />
                            </div>

                        </div><!-- /.form-group -->


                    </div><!-- /.description -->

                    <div class="attachment mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Attachment</h4>
                        </div>

                        <div class="mb-3 row form-group ">

                            <div class="col-sm-12">
                                {{-- <x-inputs.upload-files :docs="$docs" id="docs" :error="'docs'" /> --}}
                                <div id="dropbox">
                                    <span>
                                        <img src="{{ asset('/images/icons/upload.png') }}" alt="image upload" />
                                    </span>
                                    Drop or <span id="select" class="ms-2">Select File</span>
                                </div>

                                <input type="file" wire:model="file" id="file" style="display: none;">
                            </div>

                        </div><!-- /.form-group -->

                        {{-- review --}}
                        @if (count($tmp) > 0)
                            <div class="module-attachment-items gap-2">

                                <div class="files-content d-flex flex-column gap-2">
                                    @foreach ($tmp as $item)
                                        @php
                                            $id_media = null;
                                            if (isset($item['id'])) {
                                                $id_media = $item['id'];
                                            }
                                        @endphp
                                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                            <div class="thumb">
                                                <img src="{{ $item['ext_icon'] }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $item['name'] }}</div>
                                            <div class="img-size opacity-50 ms-auto">{{ $item['size'] }} Kb</div>
                                            <div class="delete-icon">
                                                <img src="/images/icons/delete-top.svg" alt=""
                                                    wire:click="removeFile('{{ $item['name'] }}', '{{ $id_media }}')">
                                            </div>
                                        </div><!-- image -->
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div><!-- /.attachment -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('document-systems::maker') }}" class="btn btn-outline-secondary"
                                wire:loading.remove wire:target='saveData'>
                                Cancel
                            </a>
                            <x-button-spinner target="saveData" :text="trans('global.processing')"></x-button-spinner>
                            @if ($status != 6)
                                <div class="button-document" wire:loading.remove wire:target='saveData'>
                                    <button
                                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Submit Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" wire:click="saveData(2)" class="dropdown-item">
                                                @lang('global.save_as_draft')
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" wire:click.prevent="saveData(1)"
                                                class="dropdown-item">
                                                @lang('global.submit_for_review')
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <div class="button-document" wire:loading.remove wire:target='saveData'>
                                    <button
                                        class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        type="button" wire:click.prevent="saveData(1)">
                                        Submit Review
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->

</div>

@once
    @push('styles')
        <!-- Select2 -->
        <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
        <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
        <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />-->
        <link href="{{ asset('assets/libs/select2-bootstrap-5-theme/select2-bootstrap-5-theme.min.css') }}"
            rel="stylesheet" />
    @endpush
@endonce

@once
    @push('scripts')
        <!-- Select2 -->
        <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->
        <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            $('#company_id').select2({
                theme: 'bootstrap-5',
            });

            $('#company_id').on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('company_id', data);
            });

            $('#listEmployee').select2({
                theme: 'bootstrap-5',
                closeOnSelect: false
            });

            $('#listEmployee').on('change', function(e) {
                var data = $(this).select2("val");
                @this.set('invitedPeople', data);
            });

            // show selected invited people
            var $listEmployeeSelect = @json($listEmployee);
            var $listSelected = @json($invitedPeople);

            $.each($listEmployeeSelect, function(index, employee) {
                $.each($listSelected, function(index, selected) {
                    if (employee.email == selected) {
                        $('#listEmployee').append(new Option(employee.email, employee.id, true,
                            true));
                    }
                });
            });
            // update data model Livewire ketika nilai pada dropdown berubah
            Livewire.on('employeeDataUpdated', function(listEmployee) {
                var $listEmployeeSelect = $('#listEmployee');

                // Hapus opsi yang ada
                $listEmployeeSelect.empty();

                // Tambahkan opsi baru berdasarkan data yang baru
                $.each(listEmployee, function(index, employee) {
                    $listEmployeeSelect.append(new Option(employee.email, employee.id, true, true));
                });

                // Hapus pilihan lama
                $listEmployeeSelect.val(null).trigger('change');

                // Update Select2 state based on company selection
                let companyVal = $('#company_id').val();
                if (!companyVal) {
                    $listEmployeeSelect.prop('disabled', true).trigger('change');
                    const $container = $listEmployeeSelect.next('.select2-container');
                    if ($container.length) {
                        $container.addClass('select2-container--disabled');
                        $container.css({
                            'pointer-events': 'none',
                            'opacity': '0.6'
                        });
                    }
                } else {
                    $listEmployeeSelect.prop('disabled', false).trigger('change');
                    const $container = $listEmployeeSelect.next('.select2-container');
                    if ($container.length) {
                        $container.removeClass('select2-container--disabled');
                        $container.css({
                            'pointer-events': '',
                            'opacity': ''
                        });
                    }
                }
            });
        });

        window.addEventListener('resetSummernote', () => {
            $('#description').summernote('code', '');
        });

        $('#module_id').on('change', function(e) {
            @this.call('showDocumentTypes', $(this).val());
        });

        // begin::custom dropbox
        let dropbox;
        dropbox = document.getElementById("dropbox");
        window.addEventListener("dragenter", dragenter, false);
        window.addEventListener("dragover", dragover, false);
        window.addEventListener("drop", drop, false);

        function dragenter(e) {
            e.stopPropagation();
            e.preventDefault();
            $('#dropbox').addClass('active');
        }

        function dragover(e) {
            e.stopPropagation();
            e.preventDefault();
        }

        function drop(e) {
            e.stopPropagation();
            e.preventDefault();
            $('#dropbox').removeClass('active');

            const dt = e.dataTransfer;
            const files = dt.files[0];
            let form = new FormData();
            form.append('file', files);
            uploadTmpFile(form);
        }

        $('#select').on('click', function(e) {
            e.preventDefault();

            $('#file').click();
        })

        $('#file').on('change', function(e) {
            e.preventDefault();
            let input = this;
            let form = new FormData();
            form.append('file', input.files[0]);
            uploadTmpFile(form);
        });

        function uploadTmpFile(data) {
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('document-systems::maker.files') }}",
                data: data,
                success: function(res) {
                    @this.createdFiles(res);
                },
                error: function(err) {
                    console.log('err', err);
                }
            })
        }
        // end::custom dropbox
        window.Livewire.on('summernote', () => {
            $('.summernote').each(function(i, e) {
                const id = $(e).attr('id')
                $(e).summernote({
                    height: 300,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.
                            set(id, contents);
                        }
                    },
                })
            })
        })



        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.sent', (message, component) => {

                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload File',
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload File Success',
                        timer: 2000,
                    });
                }

            })

        });
    </script>
@endpush

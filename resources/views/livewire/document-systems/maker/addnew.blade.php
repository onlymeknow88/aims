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
    </style>
@endpush

<div class="inner-content">

    <div class="header-add-maker h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('maker') }}" class="d-flex align-items-center gap-3 text-white">
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

                                <x-inputs.select2 id="company_id" placeholder="Select Company" :error="'company_id'"
                                    wire:model="company_id">

                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company['id'] }}">{{ $company['company_name'] }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="department_id" class="col-sm-4 col-form-label">Department</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 id="department_id" placeholder="Select Department"
                                    error="department_id" wire:model="department_id">

                                    @foreach ($departments as $key => $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="pic" class="col-sm-4 col-form-label">Penanggung Jawab</label>

                            <div class="col-sm-8">

                                <x-inputs.select2-avatar id="pic" placeholder="Select Penanggung Jawab"
                                    error="pic" wire:model="pic">

                                    @foreach ($pics as $key => $itemPj)
                                        <option class="d-flex gap-2 align-items-center" value="{{ $itemPj['id'] }}"
                                            data-avatar="@if ($itemPj['avatar']) $itemPj['avatar'] @else {{ asset('./images/profile.png') }} @endif"
                                            data-email="@if ($itemPj['email']) {{ $itemPj['email'] }} @endif">
                                            {{ $itemPj['name'] }}</option>
                                    @endforeach

                                    </x-inputs-select2-avatar>

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

                                <x-inputs.select2 id="module_id" placeholder="Select Module" wire:model="module_id"
                                    error="module_id">

                                    @foreach ($modules as $key => $module)
                                        <option value="{{ $module['id'] }}">{{ $module['name'] }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="category_id" class="col-sm-4 col-form-label">Category</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 id="category_id" placeholder="Select Category Module"
                                    wire:model="category_id" error="category_id">

                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group ">

                            <label for="mapping_id" class="col-sm-4 col-form-label">Mapping</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 id="mapping_id" placeholder="Select Mapping" error="mapping_id"
                                    wire:model="mapping_id">

                                    <option value="">Select Mapping</option>
                                    @foreach ($mapping as $key => $map)
                                        <option value="{{ $map['id'] }}">{{ $map['name'] }}</option>
                                    @endforeach

                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="doc-info mb-5" x-data="{ jenis_doc: @entangle('jenis_doc') }">

                        <div class="mb-5">
                            <h5 class="fw-normal">Document</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <label for="upload_type" class="col-sm-4 col-form-label">@lang('global.upload_type')</label>

                            <div class="col-sm-8">

                                <x-inputs.select2 id="upload_type" placeholder="Select upload metode"
                                    wire:model="upload_type">
                                    <option value="">@lang('global.select_upload_type')</option>
                                    <option value="document">Document</option>
                                    <option value="record">Record</option>
                                </x-inputs.select2>

                            </div>

                        </div><!-- /.form-group -->                        

                        <div class="mb-3 row form-group">

                            <label for="document_type" class="col-sm-4 col-form-label">@lang('global.document_type')</label>

                            <div class="col-sm-8">
                                <x-inputs.select2 id="document_type" placeholder="Choose document"
                                    wire:model="document_type">

                                    <option value="">@lang('global.choose_document')</option>
                                    @foreach ($documentTypes as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach

                                </x-inputs.select2>
                            </div>

                        </div><!-- /.form-group -->
                        @if ($document_type == \Modules\DocumentSystem\Entities\Document::SOP_DOC_TYPE)

                            <div class="mb-3 row form-group">

                                <label for="sop_number" class="col-sm-4 col-form-label">@lang('global.sop_number')</label>

                                <div class="col-sm-8">
                                    {{-- <x-inputs.text wire:model="sop_number"
                                        id="sop_number"
                                        error="sop_number"
                                        placeholder="Your ID Document"></x-inputs.text> --}}
                                    @if ($template_form != '')
                                        <div class="input-group input-group-doc-form">
                                            <span class="input-group-text document-prefix"
                                                id="basic-addon1">{{ $template_form }}</span>
                                            <input type="text" class="form-control" id="sop_number"
                                                wire:model="sop_number"
                                                placeholder="{{ trans('global.sop_number') }}"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    @else
                                        <input type="text" class="form-control" disabled
                                            placeholder="{{ trans('global.sop_number') }}"
                                            aria-describedby="basic-addon1">
                                    @endif
                                </div>

                            </div><!-- /.form-group -->

                            <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <div
                                        class="alert alert-warning text-center d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('images/icons/exclamation.png') }}" alt="">
                                        @lang('global.sop_form_alert')
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if ($document_type == \Modules\DocumentSystem\Entities\Document::TS_DOC_TYPE)
                            <div class="mb-3 row form-group">

                                <label for="win_number" class="col-sm-4 col-form-label">@lang('global.win_number')</label>

                                <div class="col-sm-8">
                                    <x-inputs.text wire:model="win_number" id="win_number" error="win_number"
                                        placeholder="Your ID Document"></x-inputs.text>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group">

                                <label for="form_number" class="col-sm-4 col-form-label">@lang('global.form_number')</label>

                                <div class="col-sm-8">
                                    <x-inputs.text wire:model="form_number" id="form_number" error="form_number"
                                        placeholder="Your ID Document"></x-inputs.text>
                                </div>

                            </div><!-- /.form-group -->
                        @endif

                        @if ($document_type == \Modules\DocumentSystem\Entities\Document::MN_DOC_TYPE)
                            <div class="mb-3 row form-group">
                                <label for="document_number" class="col-sm-4 col-form-label">
                                    @lang('global.document_number')
                                </label>

                                <div class="col-sm-8">
                                    <x-inputs.text wire:model="document_number" id="document_number"
                                        error="document_number" placeholder="{{ trans('global.document_number') }}">
                                    </x-inputs.text>
                                </div>
                            </div>
                        @endif

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

                            <div class="col-sm-12">
                                <div class="position-relative input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input class="form-control" type="email" id="invited_people"
                                        wire:model="inputInvited" wire:keydown.enter.prevent="setInvitedPeople" />

                                </div>
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group d-flex gap-3 flex-wrap">
                            @if ($invitedPeople)
                                @foreach ($invitedPeople as $key => $people)
                                    <div
                                        class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center">
                                        <span class="opacity-80">{{ $people }}</span>
                                        <button class="btn-closed"><img src="{{ asset('/images/icons/delete.png') }}"
                                                wire:click.prevent="removeInvited('{{ $people }}')"
                                                alt=""></button>
                                    </div>
                                @endforeach
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
                                <x-inputs.texteditor wire:model="description" id="description" model="description"
                                    :error="'description'" />
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
                                    Drop or <span id="select" class="ms-2">Select File</span>
                                </div>

                                <input type="file" wire:model="file" id="file" style="display: none;">
                            </div>

                        </div><!-- /.form-group -->

                        {{-- review --}}
                        @if (count($tmp) > 0)
                            <div class="row">
                                @foreach ($tmp as $item)
                                    @php
                                        $id_media = null;
                                        if (isset($item['id'])) {
                                            $id_media = $item['id'];
                                        }
                                    @endphp
                                    <div class="col-md-3 mb-2">
                                        <div class="review-box">
                                            <div class="header d-flex align-items-center justify-content-between">
                                                <img class="file-icon" src="{{ $item['ext_icon'] }}" alt="">
                                                <img class="delete-icon"
                                                    wire:click="removeFile('{{ $item['name'] }}', '{{ $id_media }}')"
                                                    src="{{ asset('images/icons/delete.png') }}" alt="">
                                            </div>
                                            <div class="body mt-4">
                                                <p class="name">{{ $item['name'] }}</p>
                                                <p class="size">{{ $item['size'] }} Kb</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div><!-- /.attachment -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('maker') }}" class="btn btn-outline-secondary" wire:loading.remove
                                wire:target='saveData'>
                                Cancel
                            </a>
                            <x-button-spinner target="saveData" :text="trans('global.processing')"></x-button-spinner>
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
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div><!---/.addnew-maker-content -->

</div>

@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#invited_people").autocomplete({
                autoFocus: true,
                source: function(request, response) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('document-sysmtes.invited_people_list') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        data: {
                            term: request.term,
                            department_id: $('#department').val(),
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#invited_people').val(ui.item.label);
                }
            });
        });

        window.addEventListener('setInvitedPeople', () => {
            let val = $('#invited_people').val();
            @this.addInvitedPeople(val);
        });
        window.addEventListener('resetSummernote', () => {
            $('#description').summernote('code', '');
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
                url: "{{ route('maker.files') }}",
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
    </script>
@endpush

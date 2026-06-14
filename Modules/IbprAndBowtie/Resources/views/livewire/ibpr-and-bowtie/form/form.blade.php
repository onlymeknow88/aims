@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #dropdown_submit {
            display: none;
        }

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

        .wrapping_table {
            overflow-x: scroll;

        }

        .form_table {
            overflow-x: scroll;
        }

        .form_table th,
        .form_table td {
            min-width: 150px;
            white-space: unset;
            vertical-align: middle;
            text-align: center;
            padding: unset;
            position: unset;
            font-size: 11px;
            border-color: black;
        }

        .form_table td.title a {
            white-space: unset;
            max-width: unset;
            display: unset;
            align-items: unset;
        }

        .form_table td a:hover {
            font-weight: unset;
        }

        .form_table td.td-check {
            width: unset;
        }

        .form_table tr {
            border-left: unset;
            border-color: black;
        }

        .form_table tbody tr:hover {
            border-left-color: unset;
            background-color: unset;
            cursor: unset;
        }

        .form_table tbody tr td .icon-checked {
            display: unset;
            align-items: unset;
            width: unset;
            height: unset;
            background-position: unset;
            background-size: unset;
        }

        .form_table tbody tr:hover td .icon-checked {
            background-image: unset;
        }

        .form_table tbody tr td .icon-checked.selected {
            background-image: unset;
        }

        .tooltip_info {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 9999px;
            border-width: 1px;
            border-color: black;
        }

        .tooltip_info p {
            margin: 0;
            font-size: 12px;
        }

        .border_add_modal {
            border-width: 1px;
            border-style: dashed;
            border-color: green;
        }

        label {
            font-size: 13px !important;
            color: black !important;
            font-weight: 500;
        }

        .form-control {
            font-size: 13px !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: 13px !important;
        }

        .input_tags {
            font-size: 13px !important;
            padding-left: 4px;
        }

        .input_tags::placeholder {
            font-size: 13px !important;
            font-weight: 400;
            line-height: 1.5;
            color: #6c757d;
            padding-left: 4px;
        }

        .custom .select2-container--bootstrap-5 .select2-dropdown .select2-results__options .select2-results__option {
            font-size: 12px !important;
        }

        .hidden {
            display: none;
        }
    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{ route('ibpr-and-bowtie::ibpr.active.list-active-ibpr-and-bowtie')}}"
               class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>@lang('global.add_new')</span>
            </a>
        </div><!-- /.left-header -->
    </div>

    <div class="addnew-maker-content container py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <form wire:ignore.self class="form-horizontal">
                    <div>
                        <p class="text-lg mb-5">Informasi Perusahaan</p>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="ccow_id" class="col-sm-4 col-form-label">Perusahaan <span
                                class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="ccow_id"
                                placeholder="Select Company"
                                :error="'ccow_id'"
                                wire:model.defer="ccow_id"
                            >
                                @foreach ($ccow as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="kriteria" class="col-sm-4 col-form-label">Kriteria Analisa <span
                                class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="kriteria"
                                placeholder="Select Kiretria Analisa"
                                :error="'kriteria'"
                                wire:model="kriteria"
                                disabled>
                                <option value="IBPR">IBPR</option>
                                <option value="IADL">IADL</option>
                                <option value="BOWTIE">BOWTIE</option>
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="iup" class="col-sm-4 col-form-label">Perusahaan IUP <span
                                class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                disabled
                                id="iup"
                                placeholder="Perusahaan IUP"
                                :error="'iup'"
                                wire:model="iup">
                                <option value="INTERNAL">INTERNAL</option>
                                <option value="CONTRACTOR">CONTRACTOR</option>
                                <option value="SUBCONTRACTOR">SUBCONTRACTOR</option>
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="contractor_id" class="col-sm-4 col-form-label">Mitra Kerja</label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="contractor_id"
                                placeholder="Select Mitra Kerja"
                                :error="'contractor_id'"
                                wire:model="contractor_id"
                            >

                                @foreach ($contractors as $key => $contractor)
                                    <option value="{{ $contractor->id }}">{{$contractor->company_name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="sub_contractor_id" class="col-sm-4 col-form-label">Sub Mitra Kerja</label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="sub_contractor_id"
                                placeholder="Select Sub Mitra Kerja"
                                :error="'sub_contractor_id'"
                                wire:model="sub_contractor_id"
                            >

                                @foreach ($sub_contractors as $key => $sub_contractor)
                                    <option value="{{ $sub_contractor->id }}">{{$sub_contractor->company_name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="pja_id" class="col-sm-4 col-form-label">Penanggung Jawab <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pja_id"
                                placeholder="Select Penanggung Jawab"
                                :error="'pja_id'"
                                wire:model="pja_id"
                            >

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>

                    <div wire:ignore class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Tim Management Risiko
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8 px-[0.8] flex justify-center">
                            <div class="w-full border flex flex-wrap rounded-md">
                                <div id="tags-list" class="flex items-center flex-wrap gap-y-5">
                                    <div class="h-full"><input type="text" id="tags-input" name="tags"
                                                               class="px-2 rounded-md input_tags h-full focus:outline-none"
                                                               placeholder="Input here"/></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t mt-5">
                        <p class="text-lg my-5">Detail Dokumen</p>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="document_no" class="col-sm-4 col-form-label flex">No. Dokumen

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.text wire:model="document_no"
                                           disabled
                                           id="document_no"
                                           error="document_no"
                                           placeholder="No. Dokumen"/>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="request_date" class="col-sm-4 col-form-label flex">Tanggal Diajukan

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.datepicker
                                placeholder="Tanggal diajukan"
                                wire:model="request_date"
                                id="request_date"
                                :error="'request_date'"/>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="department_id" class="col-sm-4 col-form-label">Department <span
                                class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="department_id"
                                placeholder="Select Department"
                                :error="'department_id'"
                                wire:model="department_id"
                            >

                                @foreach ($departments as $key => $department)
                                    <option value="{{ $department->id }}">{{$department->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="section_id" class="col-sm-4 col-form-label">Section <span
                                class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="section_id"
                                placeholder="Select Section"
                                :error="'section_id'"
                                wire:model="section_id"
                            >

                                @foreach ($sections as $key => $section)
                                    <option value="{{ $section->id }}">{{$section->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="next_date" class="col-sm-4 col-form-label flex">Tanggal Selanjutnya

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.datepicker
                                disabled
                                placeholder="Tanggal selanjutnya"
                                value="{{Carbon\Carbon::parse($request_date)->addYear()->format('F d, Y') }}"
                                id="next_date"
                                :error="'next_date'"/>
                        </div>
                    </div>
                    @if($iup === 'CONTRACTOR')
                        <div class="mb-3 row form-group ">
                            <label for="pjo_id" class="col-sm-4 col-form-label">Nama PJO <span
                                    class="text-red-600">*</span></label>
                            <div class="col-sm-8">
                                <x-ibprandbowtie-select-2
                                    id="pjo_id"
                                    placeholder="Select"
                                    :error="'pjo_id'"
                                    wire:model="pjo_id"
                                >

                                    @foreach ($pjo as $key => $user)
                                        <option value="{{ $user->id }}">{{$user->name}}</option>
                                    @endforeach
                                </x-ibprandbowtie-select-2>
                            </div>
                        </div>
                    @endif
                    <div class="mb-5 mt-5">
                        <div class="mt-5">
                            <div class="mt-10 flex">
                                <div class="w-[50%]">
                                    <p class="text-sm">Form IBPR</p>
                                </div>
                                <div class="w-full">
                                    @if(count($form) > 0)
                                        <div class="text-blue-800 font-semibold text-sm cursor-pointer"
                                             wire:click="goto_list_ibpr">{{count($form)}} IBPR Active Record
                                        </div>
                                    @else
                                        <p class="text-blue-800 font-semibold text-sm cursor-pointer"
                                           onclick="tryToOpenModal()">+ Tambah Form Baru</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div class="w-full flex justify-end gap-2 footer-action">
                            <button type="button" wire:click="cancel" class="btn btn-outline-secondary">
                                CANCEL
                            </button>
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <div class="button-document">
                                    <button wire:loading.attr="disabled"
                                            class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Submit Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" wire:loading.attr="disabled"
                                                    wire:click="save_ibpr('DRAFT')" class="dropdown-item"
                                                    href="#">
                                                Save as Draft
                                            </button>
                                        </li>
                                        @if($iup === 'INTERNAL')
                                            <li>
                                                <button type="button" wire:loading.attr="disabled"
                                                        wire:click="save_ibpr('Pengajuan Kepada PJA')"
                                                        class="dropdown-item"
                                                        href="#">
                                                    Ajukan PJA
                                                </button>
                                            </li>
                                        @elseif($iup === 'CONTRACTOR' || $iup === 'SUBCONTRACTOR')
                                            <li>
                                                <button type="button" wire:loading.attr="disabled"
                                                        wire:click="save_ibpr('Pengajuan Kepada PJO')"
                                                        class="dropdown-item"
                                                        href="#">
                                                    Ajukan PJO
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('ibprandbowtie::livewire.ibpr-and-bowtie.form.partials.ibpr-form')
    
</div>



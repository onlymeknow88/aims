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
            border-left-color:unset;
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
        .form_table tbody tr:hover td .icon-checked{
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

        .tooltip_info p{
            margin: 0;
            font-size: 12px;
        }

        .border_add_modal {
            border-width: 1px;
            border-style: dashed;
            border-color: green;
        }

        label {
            font-size: 13px!important;
            color: black!important;
            font-weight: 500;
        }

        .form-control {
            font-size: 13px!important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: 13px!important;
        }

        .input_tags {
            font-size:13px!important;
            padding-left: 4px;
        }

        .input_tags::placeholder {
            font-size:13px!important;
            font-weight: 400;
            line-height: 1.5;
            color: #6c757d;
            padding-left: 4px;
        }

    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="{{ route('ibpr-and-bowtie::iadl.active.list-active-iadl-and-bowtie')}}" class="d-flex align-items-center gap-3">
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
                        <label for="ccow_id" class="col-sm-4 col-form-label">Perusahaan <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="ccow_id"
                                placeholder="Select Perusahaan"
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
                        <label for="kriteria" class="col-sm-4 col-form-label">Kriteria Analisa <span class="text-red-600">*</span></label>
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
                        <label for="iup" class="col-sm-4 col-form-label">Perusahaan IUP <span class="text-red-600">*</span></label>
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
                    {{-- <div class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Tim Management Risiko
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8 px-2 flex justify-center relative ">
                           <div wire:click="toggle_multi_select" class="w-[99%] border flex flex-wrap rounded-md items-center px-2 cursor-pointer gap-2">
                            @if(count($team_names) === 0)
                                <p class="text-gray-500 ml-1 text-[13px]">Select Teams</p>
                            @else
                                @foreach($team_names as $team)
                                    <div class="bg-gray-100 px-2 rounded-md">
                                        <p class="text-black">{{$team}}</p>
                                    </div>
                                @endforeach
                            @endif
                           </div> --}}

                           {{-- @if($open_multiselect) --}}
                           {{-- <div wire:blur="toggle_multi_select" class="w-[98%] border h-96 overflow-scroll absolute top-0 z-10 left-0 mt-10 ml-3 rounded-md bg-white px-3 grid grid-cols-1 gap-y-3 py-2"> --}}

                            {{-- </div> --}}
                           {{-- @endif --}}
                        {{-- </div>
                    </div> --}}

                    <div wire:ignore class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Tim Management Risiko
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8 px-[0.8] flex justify-center">
                            <div class="w-full border flex flex-wrap rounded-md">
                                <div id="tags-list" class="flex items-center flex-wrap gap-y-5">
                                    <div class="h-full"><input type="text" id="tags-input" name="tags" class="px-2 rounded-md input_tags h-full focus:outline-none" placeholder="Input here"/></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t mt-5">
                        <p class="text-lg my-5">Detailed Document</p>
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
                        <label for="department_id" class="col-sm-4 col-form-label">Department <span class="text-red-600">*</span></label>
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
                        <label for="section_id" class="col-sm-4 col-form-label">Section <span class="text-red-600">*</span></label>
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
                    {{-- @if($iup === 'INTERNAL')
                    <div class="mb-3 row form-group ">
                        <label for="pja_id" class="col-sm-4 col-form-label">Nama PJA <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pja_id"
                                placeholder="Select"
                                :error="'pja_id'"
                                wire:model="pja_id"
                                >

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div> --}}
                    @if($iup === 'CONTRACTOR')
                    {{-- <div class="mb-3 row form-group ">
                        <label for="pja_id" class="col-sm-4 col-form-label">Nama PJA <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pja_id"
                                placeholder="Select"
                                :error="'pja_id'"
                                wire:model="pja_id"
                                >

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div> --}}
                    <div class="mb-3 row form-group ">
                        <label for="pjo_id" class="col-sm-4 col-form-label">Nama PJO <span class="text-red-600">*</span></label>
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
                    <div class="my-5 border-t">

                    </div>
                    <div class="mb-5 mt-5">
                        {{-- <div class="row mb-2">
                            <div class="col-md-6">
                                <h5 class="fw-normal">Document Data</h4>
                            </div>
                        </div> --}}
                    {{-- <div class="table-responsive">
                        <table style="margin-right: 5px" class="form_table table table-bordered">
                            <tr>
                                <td colspan="3">Kegiatan</td>
                                <td rowspan="3" style="min-width: 50px!important;">No.</td>
                                <td rowspan="3">Bahaya Keselamatan Pertambangan</td>
                                <td rowspan="3">Risiko Kejadian</td>
                                <td rowspan="3">Peluang Keselamatan Pertambangan</td>
                                <td rowspan="3">Peraturan Perundang-undangan yang relevan</td>
                                <td colspan="9">Penilaian Risiko Awal</td>
                                <td colspan="2">Pengendalian yang sudah ada saat ini</td>
                                <td colspan="7">Penilaian Risiko Sisa</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td rowspan="2">Aktifitas/Proses</td>
                                <td rowspan="2">Sub-Aktifitas / Sub-proses</td>
                                <td rowspan="2">Kondisi (Rutin/tidak rutin)</td>
                                <td colspan="5">Konsekuensi Maksimal</td>
                                <td style="min-width: 20px!important; background-color: yellow; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">FREKUENSI</td>
                                <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2"></td>
                                <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Tingkat Risiko</td>
                                <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Risiko Utama?</td>
                                <td rowspan="2">Model Tindakan kendali saat ini/ yang sudah ada</td>
                                <td rowspan="2">Kendali Efektif? (Y / T)</td>
                                <td colspan="5">Konsekuensi</td>
                                <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Frekuensi</td>
                                <td style="min-width: 20px!important; writing-mode:vertical-rl; transform: rotate(180deg);" rowspan="2">Tingkat Risiko</td>
                                <td rowspan="2">Tindakan Pengendalian Risiko lanjutan (jika ada)</td>
                            </tr>
                            <tr>
                                <td style="min-width: 20px!important; background-color: yellow;">K3</td>
                                <td style="min-width: 20px!important; background-color: yellow;">LH</td>
                                <td style="min-width: 20px!important; background-color: yellow;">KP</td>
                                <td style="min-width: 20px!important; background-color: yellow;">KSL</td>
                                <td style="min-width: 20px!important; background-color: yellow;">KK</td>
                                <td style="min-width: 20px!important;">K3</td>
                                <td style="min-width: 20px!important;">LH</td>
                                <td style="min-width: 20px!important;">KP</td>
                                <td style="min-width: 20px!important;">KSL</td>
                                <td style="min-width: 20px!important;">KK</td>
                            </tr>
                            <tr>
                                @for($i = 1; $i <= 31; $i++)
                                    @if($i !== 5 && $i !== 8 && $i !== 21 && $i !== 29)
                                        <td style="min-width: 20px!important;">{{ $i }}</td>
                                    @endif
                                @endfor
                            </tr>
                        </table>
                    </div> --}}
                <div class="mt-5">
                    {{-- <div class="w-full justify-center mt-10">
                            <p class="m-0 text-blue-800 font-semibold">{{ count($form) }} IBPR</p>
                            <br />
                            <div data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="bg-[#F5FAF8] cursor-pointer w-full p-3 border-2_add_modal flex justify-center items-center rounded-md">
                                <p class="text-green-700">+ Add form</p>
                            </div>

                    </div> --}}
                    <div class="mt-10 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">Form IADL</p>
                        </div>
                        <div class="w-full">
                           @if(count($form) > 0)
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_iadl">{{count($form)}} IADL Active Record</div>
                           @else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" onclick="tryToOpenModal()">+ Add new Form</p>
                           @endif
                        </div>
                       {{-- <div class="grid grid-cols-1 gap-y-5 px-32 mt-10">
                        @foreach($form as $index => $forms)
                            <div class="flex w-full items-center gap-3">
                                <div>
                                    <img src="{{ asset('./images/icons/vector.png') }}" alt="vector">
                                </div>
                                <div class="border py-4 px-4 !border-[#088E52] w-full rounded-xl flex">
                                    <div class="w-full">
                                        <div class="flex gap-2">
                                            <p class="font-semibold text-sm">{{ $forms['activity'] }}, </p>
                                            <p class="font-semibold text-sm">{{ $forms['sub_activity'] }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs">Form IBPR </p>
                                        </div>
                                    </div>
                                    <div class="w-full flex justify-end items-center gap-3">
                                        <button type="button" wire:click.stop="open_modal_edit('{{ $index }}')" class="duration-500 hover:scale-105">
                                            Edit
                                        </button>
                                        <button type="button" wire:click.stop="delete_form('{{ $index }}')" class="text-gray-500 duration-500 hover:scale-105">
                                            Delete {{ $index }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                       </div> --}}

                    </div>
                </div>
                </div>
                    <div class="w-full flex">
                        <div class="w-full">
                            {{-- <button type="button" wire:click="save_ibpr('DRAFT')" class="text-[14px] font-[500] text-[#088E52]  duration-300 hover:scale-105">
                                Save as Draft
                            </button> --}}
                        </div>
                        <div class="w-full flex justify-end gap-2">
                            <button type="button" wire:click="cancel" class="btn btn-outline-secondary">
                                CANCEL
                            </button>
                            {{-- <button type="button" wire:click="save_ibpr('Pengajuan Kepada PJA/PJO')" class="tpy-2 px-5 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                                Submit
                            </button> --}}
                           <div class="relative">
                            <div id="dropdown_submit"  tabindex="0" class="absolute w-56 border @if(isset($iup)) -mt-28 @else -mt-16 @endif rounded-md shadow-md z-10 bg-white" onblur="close_dropdown_submit()">
                                <div wire:click="save_ibpr('DRAFT')" class="py-3 cursor-pointer py-2 px-4 text-[13px] text-semibold text-[#323130] rounded-md duration-300 hover:bg-[#EEFFF7]">
                                    Save as Draft
                                </div>
                                @if($iup === 'INTERNAL')
                                    <div wire:click="save_ibpr('Pengajuan Kepada PJA')" class="pb-3 cursor-pointer py-2 px-4 text-[13px] text-semibold text-[#323130] rounded-md duration-300 hover:bg-[#EEFFF7]">
                                        Ajukan PJA
                                    </div>
                                @elseif($iup === 'CONTRACTOR' || $iup === 'SUBCONTRACTOR')
                                    <div wire:click="save_ibpr('Pengajuan Kepada PJO')" class="pb-3 cursor-pointer py-2 px-4 text-[13px] text-semibold text-[#323130] rounded-md duration-300 hover:bg-[#EEFFF7]">
                                        Ajukan PJO
                                    </div>
                                @endif
                            </div>
                            <div onclick="toggle_dropdown_submit()" class="flex cursor-pointer py-2 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                                <div class="w-full flex items-center justify-center ml-5">
                                    <p>Submit</p>
                                </div>
                                <div class="w-full flex justify-end items-center ml-5 mr-3">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="staticBackdropLabel"></div>
          <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
            <div class="mb-3 row form-group">
                <label for="activity" class="col-sm-4 col-form-label flex">Proses
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        id="activity"
                        error="activity"
                        wire:model.defer="activity"
                        placeholder="Proses"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="sub_activity" class="col-sm-4 col-form-label flex">Aktifitas
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="sub_activity"
                        id="sub_activity"
                        error="sub_activity"
                        placeholder="Aktifitas"
                    />
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="kondition" class="col-sm-4 col-form-label flex">Aspek Lingkungan Hidup
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="kondition"
                        id="kondition"
                        error="kondition"
                        placeholder="Aspek Lingkungan Hidup"
                    />
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="safety" class="col-sm-4 col-form-label flex">Dampak Lingkungan Hidup
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="safety"
                        id="safety"
                        error="safety"
                        placeholder="Dampak Lingkungan Hidup"
                    />
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="incident_risk" class="col-sm-4 col-form-label flex">Peluang LH
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="incident_risk"
                        id="incident_risk"
                        error="incident_risk"
                        placeholder="Peluang LH "
                    />
                </div>
            </div>
            {{-- <div class="mb-3 row form-group ">
                <label for="kondition" class="col-sm-4 col-form-label">Type of Activity <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="kondition"
                        placeholder="Select"
                        :error="'kondition'"
                        wire:model.defer="kondition"
                        >
                        <option value="Rutin">Rutin</option>
                        <option value="Tidak Rutin">Tidak Rutin</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div> --}}
            <div class="mb-3 row form-group ">
                <label for="safety_opportunity" class="col-sm-4 col-form-label flex">Kondisi Aspek
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="safety_opportunity"
                        placeholder="Select"
                        :error="'safety_opportunity'"
                        wire:model.defer="safety_opportunity"
                        >
                            <option value="Normal">Normal</option>
                            <option value="Abnormal">Abnormal</option>
                            <option value="Darurat">Darurat</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            {{-- <div class="mb-3 row form-group">
                <label for="incident_risk" class="col-sm-4 col-form-label">Incident Risk <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="incident_risk"
                        id="incident_risk"
                        error="incident_risk"
                        placeholder="Incident Risk"/>
                </div>
            </div> --}}
            <div class="mb-3 row form-group">
                <label for="relevant_legislation" class="col-sm-4 col-form-label">Peraturan Relevan <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="relevant_legislation"
                        id="relevant_legislation"
                        error="relevant_legislation"
                        placeholder="Peraturan Relevan"/>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h5 class="font-semibold">Penilaian Aspek & Dampak LH</h4>
            </div>
            <img src="{{ asset('images/ibpr-and-bowtie/matrix-ibpr.jpg') }}" alt="" width="100%">
            <br />
            <div class="row mb-3">
                <div class="col-sm-4 flex items-center">
                    <label for="preliminary_frequence" class="col-form-label flex">Keparahan
                        <span class="text-red-600">*</span>

                    </label>
                </div>
                <div class="col-sm-8 flex">
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-lh" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">LH</label>
                         </div>
                         <div id="tooltip_lh" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terjadi Gangguan terhadap keanekaragaman flora dan fauna dan kecil kemungkinan untuk mengembalikan seperti fungsi rona awal
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Gangguan / pencemaran signifikan/major di luar area kerja organisasi yang terjadi terus menerus/berkala
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terjadi gangguan terhadap keanekaragaman flora dan fauna dan masih dapat dikembalikan seperti fungsi rona awal
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Gangguan / pencemaran keluar area kerja organisasi yang signifikan/major yang tidak terjadi terus menerus/berkala
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(3, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Gangguan / pencemaran signifikan/major di dalam lingkungan area kerja organisasi atau menyebar ke area kerja yang lain
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (3)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(2, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Gangguan / pencemaran minor sampai keluar lingkungan kerja organisasi yang dampak terhadap lingkungan tidak signifikan
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (2)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(2, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Penggunaan sumber daya alam (air, minyak, dll) yang ada pada kondisi tertentu tidak sesuai dengan peruntukannya / perijinannya
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (2)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(1, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Gangguan/pencemaran terhadap kondisi lingkungan yang minor dan terlokalisir hanya di satu tempat di area kerja organisasi (tidak menyebar)
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (1)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(2, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Penggunaan sumber daya alam (air, minyak, dll) yang yang masih sesuai dengan peruntukannya / perijinannya
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (1)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-12">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_lh"
                                 id="preliminary_consequence_lh"
                                 error="preliminary_consequence_lh"
                                 placeholder="LH"/>
                         </div>
                     </div>
                </div>
            </div>
            <div class="mb-3 row form-group" style="z-index: 9">
                <label for="preliminary_frequence" class="col-sm-4 col-form-label flex">Kemungkinan
                    <span class="text-red-600">*</span>
                    <span class="ml-2 relative">
                        <img class="cursor-pointer duration-500 hover:scale-125" onmouseover="show_preliminary_frequence_info()" onmouseout="show_preliminary_frequence_info()" src="{{ asset('./images/icons/info.png') }}" alt="info">
                        {{-- <span id="preliminary_frequence_info" class="bg-white w-[600px] border rounded absolute p-3 transition-all z-10">
                            <div class="bg-white grid grid-cols-1 w-full">
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">A</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Terjadi dalam banyak keadaan (mulai dari tiap saat/hari hingga 1x/ minggu)</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">B</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi dalam tiap bulan</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">C</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi beberapa kali dalam 1 tahun</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">D</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi lebih dari 1 tahun</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">E</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi tetapi dalam situasi yang luar biasa</p>
                                </div>
                            </div>
                        </span> --}}
                    </span>
                </label>
                <div class="col-sm-8">
                    <select
                        class="form-control"
                        id="preliminary_frequence"
                        placeholder="Select Frequence"
                        :error="'preliminary_frequence'"
                        wire:model.defer="preliminary_frequence"
                        >
                            <option>Select Frequence</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="preliminary_level_of_risk" class="col-sm-4 col-form-label flex">Tingkat Rasio
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        disabled
                        wire:model.defer="preliminary_level_of_risk_label"
                        id="preliminary_level_of_risk_label"
                        error="preliminary_level_of_risk"
                        placeholder="Tingkat Rasio"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="preliminary_main_risk" class="col-sm-4 col-form-label flex">Aspek Significan
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        disabled
                        wire:model.defer="preliminary_main_risk"
                        id="preliminary_main_risk"
                        error="preliminary_main_risk"
                        placeholder="Aspek Significan "/>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h5 class="font-semibold"></h4>
            </div>
            <br />
            <div id="sembunyi" class="mb-3 row form-group" >
                <label for="modal_of_current" class="col-sm-4 col-form-label truncate">Hirarki kendali</label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="modal_of_current"
                        placeholder="Select"
                        :error="'modal_of_current'"
                        wire:model.defer="modal_of_current"
                        >
                            @foreach($ibprHirarki as $hirarki)
                                <option value="{{$hirarki->name}}">{{$hirarki->name}}</option>
                            @endforeach
                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            {{-- <div class="mb-3 row form-group ">
                <label for="effective_control" class="col-sm-4 col-form-label flex">Detail Pengendalian
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="effective_control"
                        placeholder="Select"
                        :error="'effective_control'"
                        wire:model.defer="effective_control"
                        >

                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div> --}}

            <div class="mb-3 row form-group">
                <label for="effective_control" class="col-sm-4 col-form-label flex">Detail Pengendalian
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="effective_control"
                        id="effective_control"
                        error="effective_control"
                        placeholder="Detail Pengendalian "/>
                </div>
            </div>
            <br />

        </div>
        <div class="modal-footer w-full flex justify-end footer-action">
          {{-- <div wire:click.stop="push_form" class="bg-[#F5FAF8] cursor-pointer w-full p-3 border_add_modal flex justify-center items-center rounded-md">
            <p class="text-green-700">+ @if(!is_null($index_edit)) Change @else Add @endif form</p>
          </div> --}}
          <div>
            <button type="button" onclick="closeModal()"  class="btn btn-outline-secondary">Cancel</button>
          </div>
          <div>
            <button type="button" wire:click.stop="push_form" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Save activity</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        let teams = [];
        $(document).ready(function() {

            $('#tags-input').on('keydown', function(event) {
                if (event.keyCode === 13) { // 13 is the keycode for the Enter key
                    var team = $(this).val().trim();
                    teams.push(team);
                    if (team !== '') {
                        $('#tags-list').before('<div class="tag bg-gray-100 px-3 flex items-center mr-2 ml-2 rounded-md my-1">' + team + '<button type="button" class="close ml-2 border rounded-full h-3 w-3 flex items-center justify-center p-2 border-black" data-name="'+ team +'" aria-label="Close"><span aria-hidden="true">x</span></button></div>');
                        $(this).val('');
                    }

                    @this.set('teams', teams);
                }
            });

            $('body').on('click', '.close', function() {
                console.log('tes')
                var name = $(this).data('name');

                let newValue = teams.filter(e => e !== name)
                teams = newValue;

                $(this).parent().remove();
                @this.set('teams', newValue);
            });

        });

        function toggle_dropdown_submit(){
            $('#dropdown_submit').toggle();
        }

        function close_dropdown_submit(){
            console.log('tes')
            // $('#dropdown_submit').toggle();
        }

        $(document).ready(function() {
            $('#menu_dropdown').blur(function() {
                alert('The input field lost focus');
            });
        });

        $('#preliminary_frequence_info').addClass('hidden');
        function show_preliminary_frequence_info(){
            $('#preliminary_frequence_info').toggleClass('hidden');
        }

        $('#residual_frequence_info').addClass('hidden');
        function show_residual_frequence_info(){
            $('#residual_frequence_info').toggleClass('hidden');
        }

        $('#btn-togle-k3').click(function() {
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_k3').toggleClass('hidden');
        });

        $('#btn-togle-lh').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_lh').toggleClass('hidden');
        });

        $('#btn-togle-kp').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').toggleClass('hidden');
        });

        $('#btn-togle-ksl').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').toggleClass('hidden');
        });

        $('#btn-togle-kk').click(function() {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').toggleClass('hidden');
        });




        $('#btn-togle-k3-v2').click(function() {
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3-v2').toggleClass('hidden');
        });

        $('#btn-togle-lh-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_lh-v2').toggleClass('hidden');
        });

        $('#btn-togle-kp-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').toggleClass('hidden');
        });

        $('#btn-togle-ksl-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').toggleClass('hidden');
        });

        $('#btn-togle-kk-v2').click(function() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').toggleClass('hidden');
        });


        Livewire.on('openModal', (e) => {
            let preliminary_main_risk = $('#preliminary_main_risk').val();
            chooseModaelOfCurrent(preliminary_main_risk);

            $("#staticBackdrop").modal("show");
        });

        function tryToOpenModal() {
            let doc = $('#document_no').val();
            $('#staticBackdropLabel').text(doc);
            $("#staticBackdrop").modal("show");
        }


        function closeModal() {
            $("#staticBackdrop").modal("hide");
        }

        Livewire.on('closeModal', () => {
            $("#staticBackdrop").modal("hide");
        });

        Livewire.on('closeAllToooltip', () => {
            closeAllToooltip();
        });

        function closeAllToooltip() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
        }


        $('#preliminary_frequence').on('input', function() {
            // Call your function here
            let preliminary_frequence = $('#preliminary_frequence').val();
            Livewire.emit('event_formula_level_of_risk', preliminary_frequence);
        });

        $('#residual_frequence').on('input', function() {
            // Call your function here
            let residual_frequence = $('#residual_frequence').val();
            Livewire.emit('event_formula_level_of_risk_residual', residual_frequence);
        });

        $(document).ready(function() {
            // Attach a change event handler to the form
            $('#document_no').change(function() {
                // Code to execute when the form value changes
                let val =  $('#document_no').val();
                $('#staticBackdropLabel').text(val);
            });
        });

        Livewire.on('chooseModaelOfCurrent', (preliminary_main_risk) => {
            $('#preliminary_frequence_info').addClass('hidden');
            $('#residual_frequence_info').addClass('hidden');
            chooseModaelOfCurrent(preliminary_main_risk);
        });

        $('#staticBackdrop').on('hide.bs.modal', function() {
            Livewire.emit('event_unset_index_edit');
        });

        $('#staticBackdrop').on('show.bs.modal', function() {
            $('#preliminary_frequence_info').addClass('hidden');
            $('#residual_frequence_info').addClass('hidden');
        });

        function chooseModaelOfCurrent(preliminary_main_risk) {
            // if(preliminary_main_risk === 'Ya') {
            //     let options = `
            //         <option value="Interaksi kendaraan">Interaksi kendaraan</option>
            //         <option value="Pengangkatan">Pengangkatan</option>
            //         <option value="Penanganan ban">Penanganan ban</option>
            //         <option value="Bekerja dekat Air">Bekerja dekat Air</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);
            // }

            // if(preliminary_main_risk === 'Tidak') {
            //     let options = `
            //         <option value="ELIMINASI">ELIMINASI</option>
            //         <option value="SUBSTITUSI">SUBSTITUSI</option>
            //         <option value="TEKNIK REKAYASA">TEKNIK REKAYASA</option>
            //         <option value="ADMINISTRASI">ADMINISTRASI</option>
            //         <option value="ALAT PELINDUNG DIRI">ALAT PELINDUNG DIRI</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);

            // }
            return true;
        }
    </script>
@endpush

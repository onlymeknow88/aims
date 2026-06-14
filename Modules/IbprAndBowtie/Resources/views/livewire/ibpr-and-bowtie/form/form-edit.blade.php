@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
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

        .hidden {
            display: none;
        }
    </style>
@endpush

<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="/ibpr-and-bowtie/ibpr/active/detail/{{$ibpr->id}}" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Edit IBPR</span>
            </a>
        </div><!-- /.left-header -->
    </div>

    <div class="addnew-maker-content container py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <form wire:ignore.self class="form-horizontal">
                    <div>
                        <p class="text-lg mb-5">Company Information</p>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="ccow_id" class="col-sm-4 col-form-label">Company <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="ccow_id"
                                placeholder="Select Company"
                                :error="'ccow_id'"
                                wire:model.defer="ccow_id"
                                :disabled="$readonly">
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
                                dosa
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
                                id="iup"
                                placeholder="Select Perusahaan IUP"
                                :error="'iup'"
                                wire:model="iup"
                                disabled>
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
                                :disabled="$readonly">

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
                                :disabled="$readonly">

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
                                wire:model="pja_id"
                                :disabled="$readonly">

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
                           <div wire:click="toggle_multi_select" class="w-[99%] border flex flex-wrap rounded-md items-center px-3 cursor-pointer gap-2">
                            @if(count($team_names) === 0)
                                <p class="text-gray-500 ml-1 text-[13px]">Select Teams</p>
                            @else
                                @foreach($team_names as $team)
                                    <div class="bg-gray-50 py-1 px-2 rounded-md">
                                        <p class="text-gray-500">{{$team}}</p>
                                    </div>
                                @endforeach
                            @endif
                           </div>

                           @if($open_multiselect)
                           <div wire:blur="toggle_multi_select" class="w-[98%] border h-96 overflow-scroll absolute top-0 z-10 left-0 mt-10 ml-3 rounded-md bg-white px-3 grid grid-cols-1 gap-y-3 py-2">
                                @foreach ($users as $key => $user)
                                    <div class="cursor-pointer @if(in_array($user->id, $teams)) bg-blue-200 @endif" wire:click="change_teams('{{$user->id}}', '{{$user->name}}')">{{$user->name}}</div>
                                @endforeach
                            </div>
                           @endif
                        </div>
                    </div> --}}
                    <div wire:ignore class="mb-3 row form-group">
                        <label for="teams" class="col-sm-4 col-form-label flex">Tim Management Risiko
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8 px-[0.8] flex justify-center">
                            <div class="w-full border flex flex-wrap rounded-md">
                                <div id="tags-list" class="flex items-center flex-wrap gap-y-5">
                                    <div class="h-full"><input type="text" id="tags-input" name="tags" class="px-2 rounded-md h-full focus:outline-none" /></div>
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
                                :disabled="$readonly">

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
                                :disabled="$readonly">

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
                                :disabled="$readonly">

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div> --}}
                    @if($iup === 'CONTRACTOR')
                    <div class="mb-3 row form-group ">
                        <label for="pjo_id" class="col-sm-4 col-form-label">Nama PJO <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pjo_id"
                                placeholder="Select"
                                :error="'pjo_id'"
                                wire:model="pjo_id"
                                :disabled="$readonly">

                                @foreach ($pja as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <div class="mb-3 row form-group ">
                        <label for="pjo_id" class="col-sm-4 col-form-label">Nama PJO <span class="text-red-600">*</span></label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="pjo_id"
                                placeholder="Select"
                                :error="'pjo_id'"
                                wire:model="pjo_id"
                                :disabled="$readonly">

                                @foreach ($pjo as $key => $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    @endif
                    <div class="my-5 border-t">

                    </div>
                    <div class="mb-2 flex">
                        <div class="w-[50%]">
                            <p class="text-sm">Form IBPR</p>
                        </div>
                        <div class="w-full">
                           {{--@if(count($form) > 0)--}}
                           <div class="text-blue-800 font-semibold text-sm cursor-pointer" wire:click="goto_list_ibpr">{{count($form)}} IBPR Active Record</div>
                           {{--@else
                            <p class="text-blue-800 font-semibold text-sm cursor-pointer" data-bs-toggle="modal" data-bs-target="#staticBackdrop">+ Add new Form</p>
                           @endif--}}
                        </div>
                    </div>
                    <div class="mb-5 mt-5">
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
                </div>
                <div class="w-full flex footer-action">
                    <div class="w-full">

                    </div>
                    <div class="w-full flex justify-end gap-2">
                        <a href="/ibpr-and-bowtie/ibpr/active/detail/{{$ibpr->id}}" class="btn btn-outline-secondary">
                            CANCEL
                        </a>
                        <button type="button" wire:click="save_ibpr" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                            Save
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>


<!-- Modal -->
<div wire:ignore class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title" id="staticBackdropLabel"></div>
          <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
            <div class="mb-3 row form-group">
                <label for="activity" class="col-sm-4 col-form-label flex">Activity
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        id="activity"
                        error="activity"
                        wire:model.defer="activity"
                        placeholder="Activity"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="sub_activity" class="col-sm-4 col-form-label flex">Sub Activity
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="sub_activity"
                        id="sub_activity"
                        error="sub_activity"
                        placeholder="Sub Activity"
                    />
                </div>
            </div>
            <div class="mb-3 row form-group ">
                <label for="kondition" class="col-sm-4 col-form-label">Type of Activity <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="kondition"
                        placeholder="Select"
                        :error="'kondition'"
                        wire:model.defer="kondition"
                        :disabled="$readonly">
                        <option value="Rutin">Rutin</option>
                        <option value="Tidak Rutin">Tidak Rutin</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            <div class="mb-3 row form-group ">
                <label for="safety" class="col-sm-4 col-form-label flex">Mine Safety Hazard
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="safety"
                        placeholder="Select"
                        :error="'safety'"
                        wire:model.defer="safety"
                        :disabled="$readonly">
                            <option value="Bahaya 1">Bahaya 1</option>
                            <option value="Bahaya 2">Bahaya 2</option>
                            <option value="Bahaya 3">Bahaya 3</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="incident_risk" class="col-sm-4 col-form-label">Incident Risk <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="incident_risk"
                        id="incident_risk"
                        error="incident_risk"
                        placeholder="Incident Risk"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="relevant_legislation" class="col-sm-4 col-form-label">Relevant Legislation <span class="text-red-600">*</span></label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="relevant_legislation"
                        id="relevant_legislation"
                        error="relevant_legislation"
                        placeholder="Relevant Legislation"/>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h5 class="font-semibold">Preliminary Risk Assessment</h4>
            </div>
            <br />
            <div class="row mb-3">
                <div class="col-sm-4 flex items-center">
                    <label for="preliminary_frequence" class="col-form-label flex">Maximum Consequences
                        <span class="text-red-600">*</span>

                    </label>
                </div>
                <div class="col-sm-8 flex">
                    <div class="mb-3 col-md form-group relative">
                        <div class="flex items-center">
                         <div class="cursor-pointer duration-500 hover:scale-105">
                             <button id="btn-togle-k3" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                 !
                             </button>
                         </div>
                         <label for="title" class="col-sm-4 col-form-label">K3</label>
                        </div>
                        <div id="tooltip_k3" class="tooltip_custom border hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                             <div class="grid grid-cols-1">
                                 <div wire:click="change_consequences(5, 'preliminary_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                 <div wire:click="change_consequences(5, 'preliminary_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                 <div wire:click="change_consequences(5, 'preliminary_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_k3"
                                 id="preliminary_consequence_k3"
                                 error="preliminary_consequence_k3"
                                 placeholder="K3"/>
                         </div>
                     </div>
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
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                 <div wire:click="change_consequences(5, 'preliminary_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_lh"
                                 id="preliminary_consequence_lh"
                                 error="preliminary_consequence_lh"
                                 placeholder="LH"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-kp" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KP</label>
                         </div>
                         <div id="tooltip_kp" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_kp"
                                 id="preliminary_consequence_kp"
                                 error="preliminary_consequence_kp"
                                 placeholder="KP"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-ksl" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KSL</label>
                         </div>
                         <div id="tooltip_ksl" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_ksl"
                                 id="preliminary_consequence_ksl"
                                 error="preliminary_consequence_ksl"
                                 placeholder="KSL"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-kk" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KK</label>
                         </div>
                         <div id="tooltip_kk" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'preliminary_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="preliminary_consequence_kk"
                                 id="preliminary_consequence_kk"
                                 error="preliminary_consequence_kk"
                                 placeholder="KK"/>
                         </div>
                     </div>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="preliminary_frequence" class="col-sm-4 col-form-label flex">Frequency
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <select
                        class="form-control"
                        id="preliminary_frequence"
                        placeholder="Select Frequence"
                        :error="'preliminary_frequence'"
                        wire:model.defer="preliminary_frequence"
                        :disabled="$readonly">
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
                <label for="preliminary_level_of_risk" class="col-sm-4 col-form-label flex">Level of Risk
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        disabled
                        wire:model.defer="preliminary_level_of_risk"
                        id="preliminary_level_of_risk"
                        error="preliminary_level_of_risk"
                        placeholder="Level of Risk"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="preliminary_main_risk" class="col-sm-4 col-form-label flex">Main Risk
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        disabled
                        wire:model.defer="preliminary_main_risk"
                        id="preliminary_main_risk"
                        error="preliminary_main_risk"
                        placeholder="Main Risk"/>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h5 class="font-semibold">Existing Controls</h4>
            </div>
            <br />
            <div id="sembunyi" class="mb-3 row form-group" >
                <label for="modal_of_current" class="col-sm-4 col-form-label truncate">Model of current/existing control measures</label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="modal_of_current"
                        placeholder="Select"
                        :error="'modal_of_current'"
                        wire:model.defer="modal_of_current"
                        :disabled="$readonly">

                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            <div class="mb-3 row form-group ">
                <label for="effective_control" class="col-sm-4 col-form-label flex">Effective Control (Y/N)
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-ibprandbowtie-select-2
                        id="effective_control"
                        placeholder="Select"
                        :error="'effective_control'"
                        wire:model.defer="effective_control"
                        :disabled="$readonly">

                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </x-ibprandbowtie-select-2>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h5 class="font-semibold">Residual Risk Assessment</h4>
            </div>
            <br />
            <div class="row mb-3">
                <div class="col-sm-4 flex items-center">
                    <label for="residual_frequence" class="col-form-label flex">Maximum Consequences
                        <span class="text-red-600">*</span>

                    </label>
                </div>
                <div class="col-sm-8 flex">
                    <div class="mb-3 col-md form-group relative">
                        <div class="flex items-center">
                         <div class="cursor-pointer duration-500 hover:scale-105">
                             <button id="btn-togle-k3-v2" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                 !
                             </button>
                         </div>
                         <label for="title" class="col-sm-4 col-form-label">K3</label>
                        </div>
                        <div id="tooltip_k3-v2" class="tooltip_custom border hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                             <div class="grid grid-cols-1">
                                <div wire:click="change_consequences(5, 'residual_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                 <div wire:click="change_consequences(5, 'residual_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                 <div wire:click="change_consequences(5, 'residual_consequence_k3')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Pelanggaran serius terhadap peraturan perundang-undangan yang dapat dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="residual_consequence_k3"
                                 id="residual_consequence_k3"
                                 error="residual_consequence_k3"
                                 placeholder="K3"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-lh-v2" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">LH</label>
                         </div>
                         <div id="tooltip_lh-v2" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_lh')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="residual_consequence_lh"
                                 id="residual_consequence_lh"
                                 error="residual_consequence_lh"
                                 placeholder="LH"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-kp-v2" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KP</label>
                         </div>
                         <div id="tooltip_kp-v2" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kp')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="residual_consequence_kp"
                                 id="residual_consequence_kp"
                                 error="residual_consequence_kp"
                                 placeholder="KP"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-ksl-v2" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KSL</label>
                         </div>
                         <div id="tooltip_ksl-v2" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_ksl')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="residual_consequence_ksl"
                                 id="residual_consequence_ksl"
                                 error="residual_consequence_ksl"
                                 placeholder="KSL"/>
                         </div>
                     </div>
                     <div class="mb-3 col-md form-group relative">
                         <div class="flex items-center">
                          <div class="cursor-pointer duration-500 hover:scale-105">
                              <button id="btn-togle-kk-v2" type="button" class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                  !
                              </button>
                          </div>
                          <label for="title" class="col-sm-4 col-form-label">KK</label>
                         </div>
                         <div id="tooltip_kk-v2" class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                              <div class="grid grid-cols-1">
                                <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(4, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan terpapar di atas 10 orang
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (4)
                                          </div>
                                      </div>
                                  </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                     <div class="py-3 px-4">
                                         Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                         <div class="mt-2 text-sm text-blue-500 font-bold">
                                             Konsekuensi (5)
                                         </div>
                                     </div>
                                 </div>
                                  <div wire:click="change_consequences(5, 'residual_consequence_kk')" class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                      <div class="py-3 px-4">
                                         Terpapar PAK yang tidak dapat pulih/ sembuh
                                          <div class="mt-2 text-sm text-blue-500 font-bold">
                                              Konsekuensi (5)
                                          </div>
                                      </div>
                                  </div>
                              </div>
                         </div>
                         <div class="col-sm-8">
                             <x-inputs.number
                                 disabled
                                 wire:model.defer="residual_consequence_kk"
                                 id="residual_consequence_kk"
                                 error="residual_consequence_kk"
                                 placeholder="KK"/>
                         </div>
                     </div>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="residual_frequence" class="col-sm-4 col-form-label flex">Frequency
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <select
                        class="form-control"
                        id="residual_frequence"
                        placeholder="Select Frequence"
                        :error="'residual_frequence'"
                        wire:model.defer="residual_frequence"
                        :disabled="$readonly">
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
                <label for="residual_level_of_risk" class="col-sm-4 col-form-label flex">Maximum Consequences
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text wire:model.defer="residual_level_of_risk"
                        disabled
                        id="residual_level_of_risk"
                        error="residual_level_of_risk"
                        placeholder="Maximum Consequences"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="residual_main_risk" class="col-sm-4 col-form-label flex">Main of Risk
                    <span class="text-red-600">*</span>

                </label>
                <div class="col-sm-8">
                    <x-inputs.text
                        wire:model.defer="residual_main_risk"
                        disabled
                        id="residual_main_risk"
                        error="residual_main_risk"
                        placeholder="Main of Risk"/>
                </div>
            </div>
            <div class="mb-3 row form-group">
                <label for="follow_risk" class="col-sm-4 col-form-label truncate">Follow-up Risk Control Measures (if any)</label>
                <div class="col-sm-8">
                    <x-inputs.text wire:model.defer="follow_risk"
                        id="follow_risk"
                        error="follow_risk"
                        placeholder="Tindakan Pengendalian Resiko lanjutan (jika ada)"/>
                </div>
            </div>
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

        let stringTeams = '{{ $team_names }}'.split(',');
        let teams = stringTeams;

            $(document).ready(function() {
                teams.forEach(team => {
                    if (team !== '') {
                        $('#tags-list').before('<div class="tag bg-gray-100 px-3 flex items-center mr-2 ml-2 rounded-md my-1">' + team + '<button type="button" class="close ml-2 border rounded-full h-3 w-3 flex items-center justify-center p-2 border-black" data-name="'+ team +'" aria-label="Close"><span aria-hidden="true">x</span></button></div>');
                        $(this).val('');
                    }
                });

                @this.set('teams', teams);

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
                    console.log('tesssss')
                    var name = $(this).data('name');

                    let newValue = teams.filter(e => e !== name)
                    teams = newValue;

                    $(this).parent().remove();
                    @this.set('teams', newValue);
                });

            });
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

        function closeModal() {
            $("#staticBackdrop").modal("hide");
        }

        Livewire.on('openModal', (e) => {
            let preliminary_main_risk = $('#preliminary_main_risk').val();
            chooseModaelOfCurrent(preliminary_main_risk);

            $("#staticBackdrop").modal("show");
        });


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
            chooseModaelOfCurrent(preliminary_main_risk);
        });

        $('#staticBackdrop').on('hide.bs.modal', function() {
            Livewire.emit('event_unset_index_edit');
        });

        function chooseModaelOfCurrent(preliminary_main_risk) {
            if(preliminary_main_risk === 'Ya') {
                let options = `
                    <option value="Interaksi kendaraan">Interaksi kendaraan</option>
                    <option value="Pengangkatan">Pengangkatan</option>
                    <option value="Penanganan ban">Penanganan ban</option>
                    <option value="Bekerja dekat Air">Bekerja dekat Air</option>
                `
                $('#modal_of_current').empty();
                $('#modal_of_current').append(options);
            }

            if(preliminary_main_risk === 'Tidak') {
                let options = `
                    <option value="ELIMINASI">ELIMINASI</option>
                    <option value="SUBSTITUSI">SUBSTITUSI</option>
                    <option value="TEKNIK REKAYASA">TEKNIK REKAYASA</option>
                    <option value="ADMINISTRASI">ADMINISTRASI</option>
                    <option value="ALAT PELINDUNG DIRI">ALAT PELINDUNG DIRI</option>
                `
                $('#modal_of_current').empty();
                $('#modal_of_current').append(options);

            }
        }
    </script>
@endpush

<div class="inner-content">

    <div
        class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>TAMBAH DATA BARU - RENEWAL</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-csms-add-new-bidding -->

    <div class="content-csms-add-new-bidding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post"
                        wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>TAMBAH DATA BARU - RENEWAL</h4>
                        </div><!-- /.title-form -->

                        <div>
                            <div class="content-section p-4" wire:ignore.self>

                                <div class="row mb-3 form-group">
                                    <label for="bidding_id" class="col col-form-label">Data Post Bidding *</label>
                                    <div class="col-6">
                                        <h5>
                                            {{ $bidding_id }}
                                        </h5>
                                    </div>
                                </div><!-- /.form-group date -->


                                <div class="row mb-3 form-group">
                                    <label for="ccow_id" class="col col-form-label">CCOW*</label>
                                    <div class="col-6">

                                        <x-inputs.select2 id="ccow_id" placeholder="" :error="'ccow_id'"
                                            wire:model.defer="ccow_id" disabled>
                                            @foreach ($this->ccows as $index => $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->company_name }}
                                                </option>
                                            @endforeach
                                        </x-inputs.select2>

                                    </div>
                                </div><!-- /.form-group ccow_id -->

                                <div class="row mb-3 form-group">
                                    <label for="business_entity_id" class="col col-form-label">Jenis Badan
                                        Usaha</label>
                                    <div class="col-6">
                                        <x-inputs.select2 id="business_entity_id" placeholder="" :error="'business_entity_id'"
                                            wire:model.defer="business_entity_id" disabled>
                                            @foreach ($this->CompanyBusinessTypes as $index => $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group business_entity_id -->

                                <div class="row mb-3 form-group">
                                    <label for="company_name" class="col col-form-label">Nama Perusahaan *<br>(Penulisan
                                        Perusahaan Sesuai Akta Perusahaan)</label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model="company_name" id="company_name" placeholder=""
                                            :error="'company_name'" disabled />
                                    </div>
                                </div><!-- /.form-group company_name -->

                                <div class="row mb-3 form-group">
                                    <label for="address" class="col col-form-label">Alamat Perusahaan *</label>
                                    <div class="col-6">

                                        <x-inputs.textarea wire:model="address" id="addresss" placeholder=""
                                            :error="'addresss'" disabled />
                                        {{-- <x-kplh-texteditor wire:model="address" id="address" value="{{ $address }}"
                                            placeholder="Alamat Perusahaan" :error="'address'" /> --}}
                                    </div>
                                </div><!-- /.form-group address -->

                                <div class="row mb-3 form-group">
                                    <label for="company_site" class="col col-form-label">Site Perusahaan *</label>
                                    <div class="col-6">

                                        <x-inputs.textarea wire:model="company_site" id="company_sites" placeholder=""
                                            :error="'company_sites'" disabled />
                                        {{-- <x-kplh-texteditor wire:model="company_site" id="company_site"
                                            placeholder="Site Perusahaan" :error="'company_site'" /> --}}
                                    </div>
                                </div><!-- /.form-group company_site -->

                                <div class="row mb-3 form-group">
                                    <label for="license_number" class="col col-form-label">Nomor Ijin
                                        Badan Usaha
                                        *</label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model="license_number" id="license_number" placeholder=""
                                            :error="'license_number'" disabled />
                                    </div>
                                </div><!-- /.form-group license_number -->

                                <div class="row mb-3 form-group">
                                    <label for="service_criteria" class="col-lg-6 col-md-12 col-form-label">Kriteria
                                        Jasa
                                        Perusahaan</label>
                                    <div class="col-lg-6 col-md-12">

                                        <x-inputs.select2 id="service_criteria" placeholder="" :error="'service_criteria'"
                                            wire:model.defer="service_criteria" disabled>

                                            <option value="{{ Modules\CSMS\Enums\ServiceCriteria::Contractor }}">
                                                {{ Modules\CSMS\Enums\ServiceCriteria::Contractor }}
                                            </option>
                                            <option value="{{ Modules\CSMS\Enums\ServiceCriteria::SubContractor }}">
                                                {{ Modules\CSMS\Enums\ServiceCriteria::SubContractor }}
                                            </option>


                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group service_criteria -->

                                @if ($service_criteria == Modules\CSMS\Enums\ServiceCriteria::SubContractor)
                                    <div class="mb-3">

                                        <div class="row mb-3 form-group">
                                            <label for="company_id" class="col-lg-6 col-md-12 col-form-label">Perusahaan
                                                Induk</label>
                                            <div class="col-lg-6 col-md-12">
                                                <x-inputs.select2 id="company_id" placeholder="" :error="'company_id'"
                                                    wire:model.defer="company_id" disabled>
                                                    @foreach ($this->CompanyParents as $index => $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->company_name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            </div>

                                        </div>
                                    </div><!-- /.form-group company_id -->
                                @endif

                                <div class="row mb-3 form-group">
                                    <label for="company_nickname" class="col col-form-label">
                                        <a href="#" style="color: #00552f">Singkatan Nama Perusahaan (Max 5
                                            Huruf)</a></label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model="company_nickname" id="company_nickname"
                                            placeholder="Contoh: Maruwai Coal > MAC" :error="'company_nickname'" />
                                    </div>
                                </div><!-- /.form-group company_nickname -->

                                <div class="row mb-3 form-group">
                                    <label for="scope_of_business" class="col-lg-6 col-md-12 col-form-label"><a
                                            href="#" style="color: #00552f">Lingkup Usaha/Jasa (Sesuai Surat
                                            Ijin
                                            Dari Instansi
                                            Terkait)</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model="scope_of_business" id="scope_of_business"
                                            placeholder="Lingkup Usaha/Jasa" :error="'scope_of_business'" />
                                    </div>
                                </div><!-- /.form-group scope_of_business -->

                                <div class="row mb-3 form-group">
                                    <label for="contract_period" class="col-lg-6 col-md-12 col-form-label"><a
                                            href="#" style="color: #00552f">Periode Kontrak</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model="contract_period" id="contract_period"
                                            placeholder="Periode Kontrak" :error="'contract_period'" />
                                    </div>
                                </div><!-- /.form-group contract_period -->

                                <div class="row mb-3 form-group">
                                    <label for="number_of_workers" class="col-lg-6 col-md-12 col-form-label"><a
                                            href="#" style="color: #00552f">Jumlah Pekerja yang bekerja di
                                            Adaro</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model="number_of_workers" id="number_of_workers"
                                            placeholder="Jumlah Pekerja yang bekerja di Adaro" :error="'number_of_workers'" />
                                    </div>
                                </div><!-- /.form-group number_of_workers -->

                                <div class="row mb-3 form-group">
                                    <label for="number_of_competent_supervisors"
                                        class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Jumlah Pengawas yang Berkompetensi</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="number_of_spv_pop" id="number_of_spv_pop"
                                                placeholder="POP :" :error="'number_of_spv_pop'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="number_of_spv_pom" id="number_of_spv_pom"
                                                placeholder="POM :" :error="'number_of_spv_pom'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="number_of_spv_pou" id="number_of_spv_pou"
                                                placeholder="POU :" :error="'number_of_spv_pou'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="number_of_spv_imp_smkp"
                                                id="number_of_spv_imp_smkp" placeholder="Implementasi SMKP :"
                                                :error="'number_of_spv_imp_smkp'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="number_of_spv_auditor_smkp"
                                                id="number_of_spv_auditor_smkp" placeholder="Auditor SMKP :"
                                                :error="'number_of_spv_auditor_smkp'" />
                                        </div>
                                    </div>
                                </div><!-- /.form-group number_of_competent_supervisors -->

                                <div class="row mb-3 form-group">
                                    <label for="equipped_by" class="col-lg-6 col-md-12 col-form-label"><a
                                            href="#" style="color: #00552f">Dilengkapi oleh</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="equipped_name" id="equipped_name"
                                                placeholder="Nama :" :error="'equipped_name'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="equipped_position" id="equipped_position"
                                                placeholder="Jabatan :" :error="'equipped_position'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="equipped_telephone" id="equipped_telephone"
                                                placeholder="Telepon :" :error="'equipped_telephone'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model="equipped_email" id="equipped_email"
                                                placeholder="Alamat Email :" :error="'equipped_email'" />
                                        </div>
                                    </div>
                                </div><!-- /.form-group equipped_by -->

                                <div class="row mb-3 form-group">
                                    <label for="risk_category" class="col-lg-6 col-md-12 col-form-label">Kategori
                                        Resiko</label>
                                    <div class="col-lg-6 col-md-12">

                                        <x-inputs.select2 id="risk_category" placeholder="" :error="'risk_category'"
                                            wire:model.defer="risk_category">

                                            <option value="{{ App\Enums\CSMS\RiskCategory::Rendah }}">
                                                {{ App\Enums\CSMS\RiskCategory::Rendah }}
                                            </option>
                                            <option value="{{ App\Enums\CSMS\RiskCategory::Menengah }}">
                                                {{ App\Enums\CSMS\RiskCategory::Menengah }}
                                            </option>
                                            <option value="{{ App\Enums\CSMS\RiskCategory::Tinggi }}">
                                                {{ App\Enums\CSMS\RiskCategory::Tinggi }}
                                            </option>


                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group risk_category -->

                            </div><!-- ./content-label -->
                        </div>

                        <div id="label" class="section-label" x-data="{ accordionOpen: true }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">CHECKLIST CSMS</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="label"
                                x-bind:style="accordionOpen ? 'max-height: ' + $refs.label.scrollHeight + 'px' : ''"
                                x-transition.delay.5000ms>
                                <div>
                                    <div class="content-section p-4" wire:ignore.self>
                                        @foreach ($this->ChecklistCsms->groupBy('sub_point') as $index => $v)
                                            <h6>{{ $index }}</h6>
                                            @foreach ($v as $i => $value)
                                                <div class="row form-group mb-4 mt-4" x-data="{ checklist_csms_value_{{ $value->id }}: @entangle('checklist_csms_value_' . $value->id) }">
                                                    <label for="checklist_csms_{{ $value->id }}_label"
                                                        class="col-lg-6 col-md-12 col-form-label">{{ $value->ordinal_number }}.
                                                        {!! $value->crtiteria !!}
                                                        <br>
                                                        <br>
                                                        <small style="color: blue">{!! $value->legal_base !!}</small>
                                                        <br>
                                                        <br>
                                                        <small style="color: blue">{!! $value->note !!}</small>
                                                    </label>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div
                                                            class="checklist_csms_value_{{ $value->id }} d-flex flex-column gap-3">
                                                            <x-inputs.select2
                                                                wire:model="checklist_csms_value_{{ $value->id }}"
                                                                id="checklist_csms_value_{{ $value->id }}"
                                                                class="form-select" placeholder="Pemenuhan">
                                                                <option value="Ya">Ya</option>
                                                                <option value="Tidak">Tidak</option>
                                                                <option value="N/A">N/A</option>
                                                            </x-inputs.select2>

                                                            <div>
                                                                <div class="mt-3">

                                                                    <div x-cloak
                                                                        x-show="checklist_csms_value_{{ $value->id }} === 'Tidak'"
                                                                        class="mb-3">
                                                                        <x-kplh-texteditor
                                                                            wire:model="checklist_csms_note_{{ $value->id }}"
                                                                            id="checklist_csms_note_{{ $value->id }}"
                                                                            placeholder="Alamat Perusahaan"
                                                                            :error="'checklist_csms_note_{{ $value->id }}'" />
                                                                    </div>

                                                                    {{-- <div class="file-upload-wrapper"
                                                                        x-data="fileUpload()">

                                                                        <div class="file-upload-input"
                                                                            x-on:drop="isDroppingFile = false"
                                                                            x-on:drop.prevent="handleFileDrop($event)"
                                                                            x-on:dragover.prevent="isDroppingFile = true"
                                                                            x-on:dragleave.prevent="isDroppingFile = false"> --}}
                                                                            <button
                                                                                class="btn btn-outline-upload w-100 position-relative h-128px"
                                                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                                                type="button">
                                                                                <span>
                                                                                    <img src="{{ asset('/images/icons/upload.png') }}"
                                                                                        alt="image upload" />
                                                                                </span>
                                                                                <span class="text-upload">
                                                                                    Drop or <a href="#">Select
                                                                                        File</a>
                                                                                </span>
                                                                                <input type="file" name=""
                                                                                    id=""
                                                                                    wire:model="checklist_csms_file_{{ $value->id }}"
                                                                                    accept=".pdf, .png, .jpeg, .jpg"
                                                                                    multiple
                                                                                    @change="handleFileSelect" />
                                                                            </button>
                                                                        {{-- </div>
                                                                    </div> --}}

                                                                    @if (count(${'files_data_' . $value->id}) > 0)
                                                                        <div
                                                                            class="module-attachment-items gap-2 mt-3">
                                                                            <div
                                                                                class="files-content d-flex flex-column gap-2">

                                                                                @foreach (${'files_data_' . $value->id} as $keyFile => $itemFile)
                                                                                    <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="attachment">
                                                                                        <div class="thumb">
                                                                                            <img src="{{ asset('/images/icons/pdf.png') }}"
                                                                                                alt="excel">
                                                                                        </div>
                                                                                        <div class="img-name">
                                                                                            {{ $itemFile['name'] }}
                                                                                        </div>
                                                                                        <div
                                                                                            class="img-size opacity-50 ms-auto">
                                                                                            {{ $itemFile['size'] }} Kb
                                                                                        </div>

                                                                                        <div class="delete-icon">
                                                                                            <img src="/images/icons/delete-top.svg"
                                                                                                alt=""
                                                                                                wire:click="removeFile({{ $value->id }},{{ $keyFile }})">
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach

                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach

                                    </div><!-- ./content-bangunan -->
                                </div>
                            </div>
                        </div>

                        {{-- <hr>
                        <div class="row form-group">
                            <label for="tanggal_service" class="col col-form-label">Ringkasan Hasil Inspeksi</label>
                            <div class="col-6">
                                <x-kplh-texteditor wire:model="summary" id="summary"
                                    placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                            </div>
                        </div> --}}

                        <div class="space">
                            <hr>
                        </div>


                        <div class="footer-action mb-2">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <a href="javascript:history.go(-1)" class="btn btn-outline-secondary"
                                    wire:loading.remove wire:target='saved'>
                                    Cancel
                                </a>
                                <x-button-spinner target="saved" :text="trans('global.processing')"></x-button-spinner>
                                <div class="button-document" wire:loading.remove wire:target='saved'>
                                    <button
                                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Submit Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button"
                                                wire:click="save('{{ App\Enums\CSMS\CsmsStatus::Draft }}','{{ App\Enums\CSMS\CsmsStatus::Draft }}')"
                                                class="dropdown-item" href="#">
                                                Submit as draft
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button"
                                                wire:click="save('{{ App\Enums\CSMS\CsmsStatus::Publish }}','{{ App\Enums\CSMS\CsmsStatus::OnReviewOHS }}')"
                                                class="dropdown-item" href="#">
                                                Submit for review
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-csms-add-new-bidding -->

</div><!-- /.inner-content -->

@push('scripts')
    <script>
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

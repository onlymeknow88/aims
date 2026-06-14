<div class="inner-content">

    <div
        class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>TAMBAH DATA BARU - BIDDING</span>
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
                            <h4>TAMBAH DATA BARU - BIDDING</h4>
                        </div><!-- /.title-form -->

                        <div x-data="{ service_criteria: @entangle('service_criteria') }">
                            <div class="content-section p-4" wire:ignore.self>

                                {{-- <div class="row mb-3 form-group">
                                    <label for="criteria" class="col col-form-label">Kriteria CSMS *</label>
                                    <div class="col-6">

                                        <x-inputs.select2 id="criteria" placeholder="" :error="'criteria'"
                                            wire:model.defer="criteria">
                                            <option value="Bidding">
                                                Bidding
                                            </option>
                                        </x-inputs.select2>

                                    </div>
                                </div> --}}

                                <div class="row mb-3 form-group">
                                    <label for="ccow_id" class="col col-form-label">CCOW*</label>
                                    <div class="col-6">

                                        <x-inputs.select2 id="ccow_id" placeholder="" :error="'ccow_id'"
                                            wire:model.defer="ccow_id">
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
                                            wire:model.defer="business_entity_id">
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
                                            :error="'company_name'" />
                                    </div>
                                </div><!-- /.form-group company_name -->

                                <div class="row mb-3 form-group">
                                    <label for="address" class="col col-form-label">Alamat Perusahaan *</label>
                                    <div class="col-6">
                                        <x-inputs.textarea wire:model="address" id="address" placeholder=""
                                            :error="'address'"></x-inputs.textarea>
                                        {{-- <x-kplh-texteditor wire:model="address" id="address"
                                            placeholder="Alamat Perusahaan" :error="'address'" /> --}}
                                    </div>
                                </div><!-- /.form-group address -->

                                <div class="row mb-3 form-group">
                                    <label for="company_site" class="col col-form-label">Site Perusahaan *</label>
                                    <div class="col-6">
                                        <x-inputs.textarea wire:model="company_site" id="company_site" placeholder=""
                                            :error="'company_site'"></x-inputs.textarea>
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
                                            :error="'license_number'" />
                                    </div>
                                </div><!-- /.form-group license_number -->

                                <div class="row mb-3 form-group">
                                    <label for="service_criteria" class="col-lg-6 col-md-12 col-form-label">Kriteria
                                        Jasa
                                        Perusahaan</label>
                                    <div class="col-lg-6 col-md-12">

                                        <x-inputs.select2 id="service_criteria" placeholder="" :error="'service_criteria'"
                                            wire:model.defer="service_criteria">

                                            <option value="{{ Modules\CSMS\Enums\ServiceCriteria::Contractor }}">
                                                {{ Modules\CSMS\Enums\ServiceCriteria::Contractor }}
                                            </option>
                                            <option value="{{ Modules\CSMS\Enums\ServiceCriteria::SubContractor }}">
                                                {{ Modules\CSMS\Enums\ServiceCriteria::SubContractor }}
                                            </option>


                                        </x-inputs.select2>
                                    </div>
                                </div><!-- /.form-group service_criteria -->

                                <div x-cloak x-show="service_criteria === 'SUBCONTRACTOR'" class="mb-3">

                                    <div class="row mb-3 form-group">
                                        <label for="company_id" class="col-lg-6 col-md-12 col-form-label">Perusahaan
                                            Induk</label>
                                        <div class="col-lg-6 col-md-12">
                                            <x-inputs.select2 id="company_id" placeholder="" :error="'company_id'"
                                                wire:model.defer="company_id">
                                                @foreach ($this->CompanyParents as $index => $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->company_name }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select2>
                                        </div>

                                    </div>
                                </div><!-- /.form-group company_id -->

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
                                                    <label for="building_criteria_1_label"
                                                        class="col-lg-6 col-md-12 col-form-label">{!! $value->crtiteria !!}
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
                                                                            accept=".pdf, .png, .jpeg, .jpg" multiple
                                                                            @change="handleFileSelect" />
                                                                    </button>

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

                        <hr>
                        <div class="row form-group">
                            <label for="person_in_charge" class="col col-form-label">Penanggung Jawab Bidder</label>
                            <div class="col-6">
                                {{-- <x-kplh-texteditor wire:model="summary" id="summary"
                                    placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" /> --}}

                                <x-inputs.text wire:model="person_in_charge" id="person_in_charge" placeholder=""
                                    :error="'person_in_charge'" />
                            </div>
                        </div>

                        <div class="space">
                            <hr>
                        </div>


                        <div class="footer-action mb-2">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <a href="javascript:history.go(-1)" class="btn btn-outline-secondary"
                                    wire:loading.remove wire:target='save'>
                                    Cancel
                                </a>
                                <x-button-spinner target="save" :text="trans('global.processing')"></x-button-spinner>
                                <div class="button-document" wire:loading.remove wire:target='save'>
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

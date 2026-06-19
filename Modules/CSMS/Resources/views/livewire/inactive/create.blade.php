<div class="inner-content">

    <div
        class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>TAMBAH DATA BARU - INACTIVE</span>
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
                            <h4>TAMBAH DATA BARU - INACTIVE</h4>
                        </div><!-- /.title-form -->

                        <div>
                            <div class="content-section p-4" wire:ignore.self>

                                <div class="row mb-3 form-group">
                                    <label for="date" class="col col-form-label">Kriteria CSMS *</label>
                                    <div class="col-6">

                                        <x-inputs.select2 id="criteria" placeholder="Pilih Kriteria CSMS"
                                            :error="'criteria'" wire:model.defer="criteria">
                                            <option value="1">
                                                Post Bidding
                                            </option>
                                        </x-inputs.select2>

                                    </div>
                                </div><!-- /.form-group date -->

                                <div class="row mb-3 form-group">
                                    <label for="ccow_id" class="col col-form-label">CCOW*</label>
                                    <div class="col-6">

                                        <x-inputs.select2 id="ccow_id" placeholder="CCOW" :error="'ccow_id'"
                                            wire:model.defer="ccow_id">
                                            @foreach ($this->ccows as $index => $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->company_name }}
                                                </option>
                                            @endforeach
                                        </x-inputs.select2>

                                    </div>
                                </div><!-- /.form-group ccow -->

                                <div class="row mb-3 form-group">
                                    <label for="companyId" class="col col-form-label">Jenis Badan Usaha</label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model.defer="criteria_company" id="criteria_company"
                                            placeholder="Jenis Badan Usaha" :error="'criteria_company'" />
                                    </div>
                                </div><!-- /.form-group companyId -->

                                <div class="row mb-3 form-group">
                                    <label for="departmentId" class="col col-form-label">Nama Perusahaan *<br>(Penulisan
                                        Perusahaan Sesuai Akta Perusahaan)</label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model.defer="criteria_company" id="criteria_company"
                                            placeholder="Nama Perusahaan" :error="'criteria_company'" />
                                    </div>
                                </div><!-- /.form-group departmentId -->

                                <div class="row mb-3 form-group">
                                    <label for="sectionId" class="col col-form-label">Alamat Perusahaan *</label>
                                    <div class="col-6">
                                        <x-kplh-texteditor wire:model.defer="summary" id="summary"
                                            placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                                    </div>
                                </div><!-- /.form-group sectionId -->

                                <div class="row mb-3 form-group">
                                    <label for="company_sites" class="col col-form-label">Site Perusahaan *</label>
                                    <div class="col-6">
                                        <x-kplh-texteditor wire:model.defer="company_sites" id="company_sites"
                                            placeholder="Site Perusahaan" :error="'company_sites'" />
                                    </div>
                                </div><!-- /.form-group location -->

                                <div class="row mb-3 form-group">
                                    <label for="detail_location" class="col col-form-label">Nomor Ijin Badan Usaha
                                        *</label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Nomor Ijin Badan Usaha" :error="'detail_location'" />
                                    </div>
                                </div><!-- /.form-group detail_location -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label">Kriteria Jasa
                                        Perusahaan</label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Kriteria Jasa Perusahaan" :error="'detail_location'" />
                                    </div>
                                </div><!-- /.form-group kttId -->

                                <div class="row mb-3 form-group">
                                    <label for="departmentId" class="col col-form-label">
                                        <a href="#" style="color: #00552f">Singkatan Nama Perusahaan (Max 5
                                            Huruf)</a></label>
                                    <div class="col-6">
                                        <x-inputs.text wire:model.defer="criteria_company" id="criteria_company"
                                            placeholder="Contoh: Maruwai Coal > MAC" :error="'criteria_company'" />
                                    </div>
                                </div><!-- /.form-group departmentId -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Lingkup Usaha/Jasa (Sesuai Surat Ijin Dari Instansi
                                            Terkait)</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Lingkup Usaha/Jasa" :error="'detail_location'" />
                                    </div>
                                </div><!-- /.form-group kttId -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Periode Kontrak</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Periode Kontrak" :error="'detail_location'" />
                                    </div>
                                </div><!-- /.form-group kttId -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Jumlah Pekerja yang bekerja di Adaro</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Jumlah Pekerja yang bekerja di Adaro" :error="'detail_location'" />
                                    </div>
                                </div><!-- /.form-group kttId -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Jumlah Pengawas yang Berkompetensi</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="POP :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="POM :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="POU :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Implementasi SMKP :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Auditor SMKP :" :error="'detail_location'" />
                                        </div>
                                    </div>
                                </div><!-- /.form-group kttId -->

                                <div class="row mb-3 form-group">
                                    <label for="kttId" class="col-lg-6 col-md-12 col-form-label"><a href="#"
                                            style="color: #00552f">Dilengkapi oleh</a></label>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Nama :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Jabatan :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Telepon :" :error="'detail_location'" />
                                        </div>
                                        <div class="mb-3">
                                            <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                                placeholder="Alamat Email :" :error="'detail_location'" />
                                        </div>
                                    </div>
                                </div><!-- /.form-group kttId -->

                                {{-- <div class="row mb-3 form-group">
                                    <label for="pjaId" class="col-lg-6 col-md-12 col-form-label">Perusahaan
                                        Induk</label>
                                    <div class="col-lg-6 col-md-12">
                                        <x-inputs.text wire:model.defer="detail_location" id="detail_location"
                                            placeholder="Perusahaan Induk" :error="'detail_location'" />
                                    </div>
                                </div> --}}

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
                                                <div class="row form-group mb-4 mt-4">
                                                    <label for="building_criteria_1_label"
                                                        class="col-lg-6 col-md-12 col-form-label">{!! $value->crtiteria !!}
                                                        <br>
                                                        <small style="color: blue">{!! $value->legal_base !!}</small>
                                                        <br>
                                                        <small style="color: blue">{!! $value->note !!}</small>
                                                    </label>
                                                    <div class="col-lg-6 col-md-12">
                                                        <div
                                                            class="wrapper_building_criteria_1 d-flex flex-column gap-3">
                                                            <x-inputs.select2
                                                                wire:model.defer="checklist_csms_value_{{ $i }}_{{ $value->id }}"
                                                                id="checklist_csms_value_{{ $i }}_{{ $value->id }}"
                                                                class="form-select" placeholder="Pemenuhan">
                                                                <option value="Ya">Ya</option>
                                                                <option value="Tidak">Tidak</option>
                                                                <option value="N/A">N/A</option>
                                                            </x-inputs.select2>

                                                            <div>
                                                                <div class="mt-3">
                                                                    <div>
                                                                        <button
                                                                            class="btn btn-outline-upload w-100 position-relative h-128px"
                                                                            style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                                            type="button">
                                                                            <span><img
                                                                                    src="{{ asset('/images/icons/upload.png') }}"
                                                                                    alt="image upload" /></span>
                                                                            <span class="text-upload">Drop or <a
                                                                                    href="#">Select
                                                                                    File</a></span>
                                                                            <input type="file" name=""
                                                                                id=""
                                                                                wire:model.defer="checklist_csms_file_{{ $i }}_{{ $value->id }}"
                                                                                accept=".pdf, .png, .jpeg, .jpg"
                                                                                multiple />

                                                                        </button>
                                                                    </div>
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
                                <x-kplh-texteditor wire:model.defer="summary" id="summary"
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
                                            <button type="button" wire:click="saved('Draft')" class="dropdown-item"
                                                href="#">
                                                Submit as draft
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" wire:click="saved('Publish')"
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

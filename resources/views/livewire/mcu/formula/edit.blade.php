<div class="inner-content">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('mcu::medical-staff/list') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Edit Formula</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->

    </div><!-- /.header-edit-event -->

    <div class="container position-relative">

        <div class="row">

            <div class="col p-4">

                <form action="#" method="post" wire:submit.prevent='save'>

                    <!-- anamnesis_2 Accordion -->
                    <div id="tanda-vital" class="section-anamnesis_2" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Anamnesis dan Riwayat Kesehatan</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group">

                                    <label for="tinggi" class="col col-form-label">Tanda-tanda vital dan antropometry</label>

                                    <div class="col-4 input-group w-33">

                                        <x-inputs.number wire:model="tinggi" id="tinggi" placeholder="Masukkan tinggi" value="0" :error="'tinggi'" />
                                        <span class="input-group-text" id="addons-tinggi">/cm</span>

                                    </div>

                                    <div class="col-4 input-group w-33">

                                        <x-inputs.number wire:model="berat" id="berat" placeholder="Masukkan berat" value="0" :error="'berat'" />
                                        <span class="input-group-text" id="addons-berat">/kg</span>

                                    </div>

                                </div><!-- /.form-group tanda vital -->

                                <div class="mb-3 row form-group">

                                    <label for="name" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Body Mass Index</span>
                                        <span class="opacity-50 lh-sm">Auto calculation</span>
                                    </label>

                                    <div class="col-8 input-group">
                                        <x-inputs.text wire:model="body_mass" id="body_mass" placeholder="Masukkan tinggi" value="0" :error="'body_mass'" disabled />
                                        <span class="input-group-text" id="addons-body_mass">kg/m2</span>
                                    </div>

                                </div><!-- /.form-group body mass -->

                                <div class="mb-3 row form-group">

                                    <label for="gizi" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Status gizi</span>
                                        <span class="opacity-50 lh-sm">Auto calculation</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.text wire:model="gizi" id="gizi" placeholder="Show Result" :error="'gizi'" disabled />
                                    </div>

                                </div><!-- /.form-group gizi -->

                                <div class="mb-3 row form-group">

                                    <label for="bb_terendah" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">BB Sehat Terendah</span>
                                        <span class="opacity-50 lh-sm">Auto calculation</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.text wire:model="bb_terendah" id="bb_terendah" placeholder="Show Result" :error="'bb_terendah'" disabled />
                                    </div>

                                </div><!-- /.form-group bb_terendah -->

                                <div class="mb-3 row form-group">

                                    <label for="bb_tertinggi" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">BB Sehat Tertinggi</span>
                                        <span class="opacity-50 lh-sm">Auto calculation</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.text wire:model="bb_tertinggi" id="bb_tertinggi" placeholder="Show Result" :error="'bb_tertinggi'" disabled />
                                    </div>

                                </div><!-- /.form-group bb_tertinggi -->

                                <div class="mb-3 row form-group">

                                    <label for="sistolik" class="col d-flex flex-column col-form-label">Tekanan Darah Sistolik</label>

                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="sistolik" id="sistolik" placeholder="Masukkan tinggi" value="0" :error="'sistolik'" />
                                        <span class="input-group-text" id="addons-sistolik">mmHg</span>
                                    </div>

                                </div><!-- /.form-group sistolik -->

                                <div class="mb-3 row form-group">

                                    <label for="diastolik" class="col d-flex flex-column col-form-label">Tekanan Darah Diastolik</label>

                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="diastolik" id="diastolik" placeholder="Masukkan tinggi" value="0" :error="'diastolik'" />
                                        <span class="input-group-text" id="addons-diastolik">mmHg</span>
                                    </div>

                                </div><!-- /.form-group diastolik -->

                                <div class="mb-3 row form-group">

                                    <label for="nadi" class="col d-flex flex-column col-form-label">Nadi</label>

                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="nadi" id="nadi" placeholder="Masukkan tinggi" value="0" :error="'nadi'" />
                                        <span class="input-group-text" id="addons-nadi">x/m</span>
                                    </div>

                                </div><!-- /.form-group nadi -->

                                <div class="mb-3 row form-group">

                                    <label for="respiratory" class="col d-flex flex-column col-form-label">Respiratory Rate</label>

                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="respiratory" id="respiratory" placeholder="Masukkan tinggi" value="0" :error="'respiratory'" />
                                        <span class="input-group-text" id="addons-respiratory">x/m</span>
                                    </div>

                                </div><!-- /.form-group respiratory -->

                                <div class="mb-3 row form-group">

                                    <label for="suhu" class="col d-flex flex-column col-form-label">Suhu Tubuh</label>

                                    <div class="col-8 input-group">
                                        <x-inputs.number wire:model="suhu" id="suhu" placeholder="Masukkan tinggi" value="0" :error="'suhu'" />
                                        <span class="input-group-text" id="addons-suhu">x/m</span>
                                    </div>

                                </div><!-- /.form-group suhu -->

                                <div class="mb-3 row form-group">

                                    <label for="tekanan_darah" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Status tekanan darah</span>
                                        <span class="opacity-50 lh-sm">Auto calculation</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.text wire:model="tekanan_darah" id="tekanan_darah" placeholder="Show Result" :error="'tekanan_darah'" disabled />
                                    </div>

                                </div><!-- /.form-group tekanan_darah -->



                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.anamnesis_2 -->

                    <!-- Pemeriksaan Penunjang Accordion -->
                    <div id="penunjang" class="section-penunjang" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Penunjang</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group">

                                    <label for="xray_thorax" class="col col-form-label">X-RAY THORAX</label>

                                    <div class="col-8">

                                        <x-inputs.select2_multiple wire:model="xray_thorax" id="xray_thorax" class="form-select" placeholder="Select result" multiple>
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="xray_thorax_1">X-RAY THORAX 1</option>
                                            <option value="xray_thorax_2">X-RAY THORAX 2</option>
                                            <option value="xray_thorax_3">X-RAY THORAX 3</option>
                                            <option value="xray_thorax_4">X-RAY THORAX 4</option>
                                            <option value="xray_thorax_5">X-RAY THORAX 5</option>
                                            <option value="xray_thorax_6">X-RAY THORAX 6</option>
                                        </x-inputs.select2_multiple>

                                    </div>

                                </div><!-- /.form-group xray_thorax -->

                                <div class="mb-3 row form-group">

                                    <label for="ekg" class="col col-form-label">EKG</label>

                                    <div class="col-8">

                                        <x-inputs.select2_multiple wire:model="ekg" id="ekg" class="form-select" placeholder="Select result" multiple>
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="ekg_1">EKG 1</option>
                                            <option value="ekg_2">EKG 2</option>
                                            <option value="ekg_3">EKG 3</option>
                                            <option value="ekg_4">EKG 4</option>
                                            <option value="ekg_5">EKG 5</option>
                                            <option value="ekg_6">EKG 6</option>
                                        </x-inputs.select2_multiple>

                                    </div>

                                </div><!-- /.form-group ekg -->

                                <div class="mb-3 row form-group">

                                    <label for="treadmill" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Treadmill</span>
                                        <span class="opacity-50 lh-sm">Usia >40 tahun wajib mengikuti treadmill test</span>
                                    </label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="treadmill" id="treadmill" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="treadmill_1">Treadmill 1</option>
                                            <option value="treadmill_2">Treadmill 2</option>
                                            <option value="treadmill_3">Treadmill 3</option>
                                            <option value="treadmill_4">Treadmill 4</option>
                                            <option value="treadmill_5">Treadmill 5</option>
                                            <option value="treadmill_6">Treadmill 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group treadmill -->

                                <div class="mb-3 row form-group">

                                    <label for="echocardiography" class="col col-form-label">ECHOCARDIOGRAPHY</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="echocardiography" id="echocardiography" rows="7" placeholder="Description" :error="'echocardiography'" />

                                    </div>

                                </div><!-- /.form-group echocardiography -->

                                <div class="mb-3 row form-group">

                                    <label for="additional_diagnosis" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Additional Diagnosis</span>
                                        <span class="opacity-50 lh-sm">post Cardiologist evaluation</span>
                                    </label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="additional_diagnosis" id="additional_diagnosis" rows="7" placeholder="Description" :error="'additional_diagnosis'" />

                                    </div>

                                </div><!-- /.form-group additional_diagnosis -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.penunjang -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('mcu::medical-staff') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Submit for review</button>
                        </div>
                    </div>

                </form>

            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->


</div>

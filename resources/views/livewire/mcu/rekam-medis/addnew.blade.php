<div class="inner-content">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('rekam-medis') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New Rekam Medis</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->

    </div><!-- /.header-edit-event -->

    <div class="container position-relative">

        <div class="row g-0">

            <div class="col py-4 border-end border-1">

                <form action="#" method="post" wire:submit.prevent='save'>

                    <div id="karyawan" class="section-karyawan" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"

                        >
                            <h6 class="mb-0 fw-normal">Karyawan</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                            x-transition.delay.5000ms
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group required">

                                    <label for="nama_perusahaan" class="col col-form-label">Nama Perusahaan</label>

                                    <div class="col-8">

                                        <x-inputs.text wire:model="nama_perusahaan" id="nama_perusahaan" placeholder="Masukkan Perusahaan" :error="'nama_perusahaan'" />

                                    </div>

                                </div><!-- /.form-group nama_perusahaan -->

                                <div class="mb-3 row form-group">

                                    <label for="status" class="col col-form-label">Status</label>

                                    <div class="col-8">

                                        <x-inputs.text wire:model="status" id="status" placeholder="Auto filled" :error="'status'" disabled />

                                    </div>

                                </div><!-- /.form-group status -->

                                <div class="mb-3 row form-group required">

                                    <label for="department" class="col col-form-label">Department</label>

                                    <div class="col-8">

                                        <x-inputs.text wire:model="department" id="department" placeholder="Masukkan Departemen" :error="'department'" />

                                    </div>

                                </div><!-- /.form-group department -->

                                <div class="mb-5 row form-group required">

                                    <label for="position" class="col-sm-4 col-form-label">Posision</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2 wire:model="position" id="position" class="form-select" placeholder="Select Position">
                                            <option value="">Select Position</option>
                                            <option value="position_1">Position 1</option>
                                            <option value="position_2">Position 2</option>
                                            <option value="position_3">Position 3</option>
                                            <option value="position_4">Position 4</option>
                                            <option value="position_5">Position 5</option>
                                            <option value="position_6">Position 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group position -->

                                <div class="mb-3 row form-group required">

                                    <label for="nip" class="col col-form-label">NIP</label>

                                    <div class="col-8">

                                        <x-inputs.nip wire:model="nip" id="nip" x-mask="99-9999-999999-999-9" placeholder="XX-XXXX-XXXXXX-XXX-X" :error="'nip'" />

                                    </div>

                                </div><!-- /.form-group nip -->

                                <div class="mb-3 row form-group required">

                                    <label for="no_ktp" class="col col-form-label">No KTP</label>

                                    <div class="col-8">

                                        <x-inputs.nip wire:model="no_ktp" id="no_ktp" x-mask="99-9999-999999-999-9" placeholder="XX-XXXX-XXXXXX-XXX-X" :error="'no_ktp'" />

                                    </div>

                                </div><!-- /.form-group no_ktp -->

                                <div class="mb-3 row form-group required">

                                    <label for="name" class="col col-form-label">Nama</label>

                                    <div class="col-8">

                                        <x-inputs.text wire:model="name" id="name" placeholder="Masukkan Nama" :error="'name'" />

                                    </div>

                                </div><!-- /.form-group name -->

                                <div class="mb-3 row form-group required">

                                    <label for="tgl_lahir" class="col col-form-label">Tangal Lahir</label>

                                    <div class="col-4">

                                        <x-inputs.datepicker wire:model="tgl_lahir" id="tgl_lahir" placeholder="Date" :error="'tgl_lahir'" />

                                    </div>

                                    <div class="col-4 input-group w-33">

                                        <x-inputs.text wire:model="umur" id="umur" placeholder="0" value="0" :error="'umur'" disabled />
                                        <span class="input-group-text" id="addons-umur">Tahun</span>

                                    </div>

                                </div><!-- /.form-group tanggal lahir -->

                                <div class="mb-5 row form-group required">

                                    <label for="jk" class="col col-form-label">Jenis Kelamin</label>

                                    <div class="col-8">

                                        <x-inputs.jk wire:model="jk" id="jk" :error="'jk'" />

                                    </div>

                                </div><!-- /.form-group jk -->

                                <div class="mb-3 row form-group required">

                                    <label for="medical_type" class="col-sm-4 col-form-label">Type of medical examination</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2 wire:model="medical_type" id="medical_type" class="form-select" placeholder="Select of medical type">
                                            <option value="">Select Medical Type</option>
                                            <option value="medical_type_1">Medical Type 1</option>
                                            <option value="medical_type_2">Medical Type 2</option>
                                            <option value="medical_type_3">Medical Type 3</option>
                                            <option value="medical_type_4">Medical Type 4</option>
                                            <option value="medical_type_5">Medical Type 5</option>
                                            <option value="medical_type_6">Medical Type 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group medial-type -->

                                <div class="mb-5 row form-group required">

                                    <label for="provider" class="col-sm-4 col-form-label">Provider</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2 wire:model="provider" id="medical-type" class="form-select" placeholder="Select Provider">
                                            <option value="">Select Provider</option>
                                            <option value="provider_1">Provider 1</option>
                                            <option value="provider_2">Provider 2</option>
                                            <option value="provider_3">Provider 3</option>
                                            <option value="provider_4">Provider 4</option>
                                            <option value="provider_5">Provider 5</option>
                                            <option value="provider_6">Provider 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group provider -->

                                <div class="mb-3 row form-group required">

                                    <label for="mcu_date" class="col col-form-label">MCU's Date</label>

                                    <div class="col-8">

                                        <x-inputs.datepicker wire:model="mcu_date" id="mcu_date" placeholder="Salect Date" :error="'mcu_date'" />

                                    </div>

                                </div><!-- /.form-group MCU's Date -->

                                <div class="mb-3 row form-group required">

                                    <label for="mcu_exp_date" class="col col-form-label">MCU's Expiration Date</label>

                                    <div class="col-8">

                                        <x-inputs.datepicker wire:model="mcu_exp_date" id="mcu_exp_date" placeholder="Salect Date" :error="'mcu_exp_date'" />

                                    </div>

                                </div><!-- /.form-group MCU's Expiration Date -->

                                <div class="mb-3 row form-group required">

                                    <label for="mcu_review_date" class="col col-form-label">Reviewing date</label>

                                    <div class="col-8">

                                        <x-inputs.datepicker wire:model="mcu_review_date" id="mcu_review_date" placeholder="Salect Date" :error="'mcu_review_date'" />

                                    </div>

                                </div><!-- /.form-group Reviewing date -->

                            </div><!-- ./content-karyawan -->

                        </div>

                    </div><!-- /.karyawan -->

                    <!-- Anamnesis dan Riwayat Kesehatan -->
                    <div id="anamnesis" class="section-anamnesis" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
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

                                <h6 class="fw-normal mb-5">Penyakit</h6>

                                <div class="mb-3 row form-group required">

                                    <label for="keluhan" class="col col-form-label">Keluhan</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="keluhan" class="form-check-input" type="radio" name="keluhan" id="keluhan-1" value="ada">
                                            <label class="form-check-label" for="keluhan-1">Ada</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="keluhan" class="form-check-input" type="radio" name="keluhan" id="keluhan-2" value="tidak">
                                            <label class="form-check-label" for="keluhan-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group keluhan -->

                                <div class="mb-3 row form-group required">

                                    <label for="r_penyakit" class="col-sm-4 col-form-label">Riwayat Penyakit Dahulu</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2_multiple wire:model="r_penyakit" id="r_penyakit" name="r_penyakit[]" class="form-select" placeholder="Select Multiple Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Multiple Option</option>
                                            <option value="penyakit_1">Penyakit 1</option>
                                            <option value="penyakit_2">Penyakit 2</option>
                                            <option value="penyakit_3">Penyakit 3</option>
                                            <option value="penyakit_4">Penyakit 4</option>
                                            <option value="penyakit_5">Penyakit 5</option>
                                            <option value="penyakit_6">Penyakit 6</option>
                                        </x-inputs.select2_multiple>

                                    </div>

                                </div><!-- /.form-group r_penyakit -->

                                <div class="mb-3 row form-group required">

                                    <label for="r_penyakit_keluarga" class="col-sm-4 col-form-label">Riwayat Penyakit Keluarga</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2_multiple wire:model="r_penyakit_keluarga" id="r_penyakit_keluarga" class="form-select" placeholder="Select Multiple Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Multiple Option</option>
                                            <option value="penyakit_1">Penyakit 1</option>
                                            <option value="penyakit_2">Penyakit 2</option>
                                            <option value="penyakit_3">Penyakit 3</option>
                                            <option value="penyakit_4">Penyakit 4</option>
                                            <option value="penyakit_5">Penyakit 5</option>
                                            <option value="penyakit_6">Penyakit 6</option>
                                        </x-inputs.select2_multiple>

                                    </div>

                                </div><!-- /.form-group r_penyakit_keluarga -->

                                <div class="mb-3 row form-group required">

                                    <label for="alergi" class="col-sm-4 col-form-label">Alergi</label>

                                    <div class="col-sm-8">

                                        <x-inputs.select2_multiple wire:model="alergi" id="alergi" class="form-select" placeholder="Select Multiple Option" multiple>
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Multiple Option</option>
                                            <option value="alergi_1">Alergi 1</option>
                                            <option value="alergi_2">Alergi 2</option>
                                            <option value="alergi_3">Alergi 3</option>
                                            <option value="alergi_4">Alergi 4</option>
                                            <option value="alergi_5">Alergi 5</option>
                                            <option value="alergi_6">Alergi 6</option>
                                        </x-inputs.select2_multiple>

                                    </div>

                                </div><!-- /.form-group alergi -->

                                <h6 class="fw-normal mb-5">Gaya Hidup</h6>

                                <div class="mb-3 row form-group required">

                                    <label for="merokok" class="col col-form-label">Apakah anda merokok</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="merokok" class="form-check-input" type="radio" name="merokok" id="merokok-1" value="ya">
                                            <label class="form-check-label" for="keluhan-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="merokok" class="form-check-input" type="radio" name="merokok" id="merokok-2" value="tidak">
                                            <label class="form-check-label" for="keluhan-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group merokok -->

                                <div class="mb-3 row form-group">

                                    <label for="merokok" class="col col-form-label"></label>

                                    <div class="col-8 input-group">

                                        <x-inputs.text wire:model="rokok" id="rokok" placeholder="0" value="0" :error="'rokok'" />
                                        <span class="input-group-text" id="addons-jumlah-rokok">Batang/Hari</span>

                                    </div>

                                </div><!-- /.form-group jumlah rokok -->

                                <div class="mb-3 row form-group required">

                                    <label for="olahraga" class="col col-form-label">Apakah anda berolahraga</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="olahraga" class="form-check-input" type="radio" name="olahraga" id="olahraga-1" value="ya">
                                            <label class="form-check-label" for="olahraga-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="olahraga" class="form-check-input" type="radio" name="olahraga" id="olahraga-2" value="tidak">
                                            <label class="form-check-label" for="olahraga-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group olahraga -->

                                <div class="mb-3 row form-group">

                                    <label for="merokok" class="col col-form-label"></label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="f_olahraga" id="f_olahraga" class="form-select" placeholder="Pilih Frekuensi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Pilih Frekuensi</option>
                                            <option value="f_olahraga_1">Frekuensi 1</option>
                                            <option value="f_olahraga_2">Frekuensi 2</option>
                                            <option value="f_olahraga_3">Frekuensi 3</option>
                                            <option value="f_olahraga_4">Frekuensi 4</option>
                                            <option value="f_olahraga_5">Frekuensi 5</option>
                                            <option value="f_olahraga_6">Frekuensi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group f_olahraga -->

                                <div class="mb-3 row form-group">

                                    <label for="j_olahraga" class="col col-form-label"></label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="j_olahraga" id="j_olahraga" class="form-select" placeholder="Jenis Olahraga">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Jenis Olahraga</option>
                                            <option value="olahraga_1">Olahraga 1</option>
                                            <option value="olahraga_2">Olahraga 2</option>
                                            <option value="olahraga_3">Olahraga 3</option>
                                            <option value="olahraga_4">Olahraga 4</option>
                                            <option value="olahraga_5">Olahraga 5</option>
                                            <option value="olahraga_6">Olahraga 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group j_olahraga -->

                                <div class="mb-3 row form-group required">

                                    <label for="m_alkohol" class="col col-form-label">Apakah anda meminum alkohol</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="m_alkohol" class="form-check-input" type="radio" name="m_alkohol" id="m_alkohol-1" value="ya">
                                            <label class="form-check-label" for="m_alkohol-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="m_alkohol" class="form-check-input" type="radio" name="m_alkohol" id="m_alkohol-2" value="tidak">
                                            <label class="form-check-label" for="m_alkohol-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group olahraga -->

                                <h6 class="fw-normal mb-5">Menstruasi</h6>

                                <div class="mb-3 row form-group">

                                    <label for="k_menstruasi" class="col col-form-label">Kondisi menstruasi</label>

                                    <div class="col-8">

                                        <x-inputs.text wire:model="k_menstruasi" id="k_menstruasi" placeholder="Type Condition" :error="'k_menstruasi'" />

                                    </div>

                                </div><!-- /.form-group k_menstruasi -->

                                <div class="mb-3 row form-group">

                                    <label for="siklus_m_1" class="col col-form-label">Kondisi keteraturan siklus</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="siklus_m_1" class="form-check-input" type="radio" name="siklus_m_1" id="siklus_m_1-1" value="ya">
                                            <label class="form-check-label" for="siklus_m_1-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="siklus_m_1" class="form-check-input" type="radio" name="siklus_m_1" id="siklus_m_1-2" value="tidak">
                                            <label class="form-check-label" for="siklus_m_1-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group siklus_m_1 -->

                                <div class="mb-3 row form-group">

                                    <label for="siklus_m_2" class="col col-form-label">Kondisi keteraturan siklus</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="siklus_m_2" class="form-check-input" type="radio" name="siklus_m_2" id="siklus_m_2-1" value="ya">
                                            <label class="form-check-label" for="siklus_m_2-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="siklus_m_2" class="form-check-input" type="radio" name="siklus_m_2" id="siklus_m_2-2" value="tidak">
                                            <label class="form-check-label" for="siklus_m_2-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group siklus_m_2 -->

                                <div class="mb-3 row form-group">

                                    <label for="lama_haid" class="col col-form-label">Kondisi lama haid</label>

                                    <div class="col-8 input-group">

                                        <x-inputs.number wire:model="lama_haid" id="lama_haid" placeholder="0" value="0" :error="'lama_haid'" />
                                        <span class="input-group-text" id="addons-lama-haid">Hari</span>

                                    </div>

                                </div><!-- /.form-group k_menstruasi -->

                                <h6 class="fw-normal mb-5">Kehamilan</h6>

                                <div class="mb-3 row form-group">

                                    <label for="r_hamil" class="col col-form-label">Riwayat Hamil</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="r_hamil" id="r_hamil" class="form-select" placeholder="Pilih Frekuensi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Pilih Frekuensi</option>
                                            <option value="r_hamil_1">Frekuensi 1</option>
                                            <option value="r_hamil_2">Frekuensi 2</option>
                                            <option value="r_hamil_3">Frekuensi 3</option>
                                            <option value="r_hamil_4">Frekuensi 4</option>
                                            <option value="r_hamil_5">Frekuensi 5</option>
                                            <option value="r_hamil_6">Frekuensi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group r_hamil -->

                                <div class="mb-3 row form-group">

                                    <label for="spontan" class="col col-form-label">Spontan</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="spontan" id="spontan" class="form-select" placeholder="Pilih Frekuensi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Pilih Frekuensi</option>
                                            <option value="spontan_1">Frekuensi 1</option>
                                            <option value="spontan_2">Frekuensi 2</option>
                                            <option value="spontan_3">Frekuensi 3</option>
                                            <option value="spontan_4">Frekuensi 4</option>
                                            <option value="spontan_5">Frekuensi 5</option>
                                            <option value="spontan_6">Frekuensi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group spontan -->

                                <div class="mb-3 row form-group">

                                    <label for="bantuan" class="col col-form-label">Bantuan / Operasi</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="bantuan" id="bantuan" class="form-select" placeholder="Pilih Frekuensi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Pilih Frekuensi</option>
                                            <option value="bantuan_1">Frekuensi 1</option>
                                            <option value="bantuan_2">Frekuensi 2</option>
                                            <option value="bantuan_3">Frekuensi 3</option>
                                            <option value="bantuan_4">Frekuensi 4</option>
                                            <option value="bantuan_5">Frekuensi 5</option>
                                            <option value="bantuan_6">Frekuensi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group bantuan -->

                                <div class="mb-3 row form-group">

                                    <label for="keguguran" class="col col-form-label">Keguguran</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="keguguran" id="keguguran" class="form-select" placeholder="Pilih Frekuensi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Pilih Frekuensi</option>
                                            <option value="keguguran_1">Frekuensi 1</option>
                                            <option value="keguguran_2">Frekuensi 2</option>
                                            <option value="keguguran_3">Frekuensi 3</option>
                                            <option value="keguguran_4">Frekuensi 4</option>
                                            <option value="keguguran_5">Frekuensi 5</option>
                                            <option value="keguguran_6">Frekuensi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group keguguran -->

                                <div class="mb-3 row form-group">

                                    <label for="kontrasepsi" class="col col-form-label">Apakah menggunakan alat kontrasepsi</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="kontrasepsi" class="form-check-input" type="radio" name="kontrasepsi" id="kontrasepsi-1" value="ya">
                                            <label class="form-check-label" for="kontrasepsi-1">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="kontrasepsi" class="form-check-input" type="radio" name="kontrasepsi" id="kontrasepsi-2" value="tidak">
                                            <label class="form-check-label" for="kontrasepsi-2">Tidak</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group kontrasepsi -->

                                <div class="mb-3 row form-group">

                                    <label for="j_kontrasepsi" class="col col-form-label"></label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="j_kontrasepsi" id="j_kontrasepsi" class="form-select" placeholder="Jenis konstrasepsi">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Jenis konstrasepsi</option>
                                            <option value="j_kontrasepsi_1">Jenis konstrasepsi 1</option>
                                            <option value="j_kontrasepsi_2">Jenis konstrasepsi 2</option>
                                            <option value="j_kontrasepsi_3">Jenis konstrasepsi 3</option>
                                            <option value="j_kontrasepsi_4">Jenis konstrasepsi 4</option>
                                            <option value="j_kontrasepsi_5">Jenis konstrasepsi 5</option>
                                            <option value="j_kontrasepsi_6">Jenis konstrasepsi 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group j_kontrasepsi -->

                                <h6 class="fw-normal mb-5">Pekerjaan</h6>

                                <div class="mb-3 row form-group">

                                    <label for="pekerjaan_sekarang" class="col col-form-label">Pekerjaan saat ini</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="pekerjaan_sekarang" id="pekerjaan_sekarang" rows="7" placeholder="Description" :error="'pekerjaan_sekarang'" />

                                    </div>

                                </div><!-- /.form-group pekerjaan_sekarang -->

                                <div class="mb-3 row form-group">

                                    <label for="pekerjaan_sebelumnya" class="col col-form-label">Pekerjaan sebelumnya</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="pekerjaan_sebelumnya" id="pekerjaan_sebelumnya" rows="7" placeholder="Description" :error="'pekerjaan_sebelumnya'" />

                                    </div>

                                </div><!-- /.form-group pekerjaan_sebelumnya -->

                                <h6 class="fw-normal mb-5">Vaksin Khusus Food Handler</h6>

                                <div class="mb-3 row form-group">

                                    <label for="hep_1" class="col col-form-label">Hep A - 1st</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="hep_1" id="hep_1" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="hep_1_1">Hep A 1</option>
                                            <option value="hep_1_2">Hep A 2</option>
                                            <option value="hep_1_3">Hep A 3</option>
                                            <option value="hep_1_4">Hep A 4</option>
                                            <option value="hep_1_5">Hep A 5</option>
                                            <option value="hep_1_6">Hep A 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group hep_1 -->

                                <div class="mb-3 row form-group">

                                    <label for="hep_2" class="col col-form-label">Hep A - 2nd</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="hep_2" id="hep_2" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="hep_2_1">Hep A 1</option>
                                            <option value="hep_2_2">Hep A 2</option>
                                            <option value="hep_2_3">Hep A 3</option>
                                            <option value="hep_2_4">Hep A 4</option>
                                            <option value="hep_2_5">Hep A 5</option>
                                            <option value="hep_2_6">Hep A 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group hep_2 -->

                                <div class="mb-3 row form-group">

                                    <label for="hep_3" class="col col-form-label">Hep A - 3 years</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="hep_3" id="hep_3" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="hep_3_1">Hep A 1</option>
                                            <option value="hep_3_2">Hep A 2</option>
                                            <option value="hep_3_3">Hep A 3</option>
                                            <option value="hep_3_4">Hep A 4</option>
                                            <option value="hep_3_5">Hep A 5</option>
                                            <option value="hep_3_6">Hep A 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group hep_3 -->

                                <div class="mb-3 row form-group">

                                    <label for="typhoid_1" class="col col-form-label">Typhoid - 1st</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="typhoid_1" id="typhoid_1" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="typhoid_1_1">Typhoid 1</option>
                                            <option value="typhoid_1_2">Typhoid 2</option>
                                            <option value="typhoid_1_3">Typhoid 3</option>
                                            <option value="typhoid_1_4">Typhoid 4</option>
                                            <option value="typhoid_1_5">Typhoid 5</option>
                                            <option value="typhoid_1_6">Typhoid 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group Typhoid - 1st -->

                                <div class="mb-3 row form-group">

                                    <label for="typhoid_3" class="col col-form-label">Typhoid - 3 years</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="typhoid_3" id="typhoid_3" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="typhoid_3_1">Typhoid 1</option>
                                            <option value="typhoid_3_2">Typhoid 2</option>
                                            <option value="typhoid_3_3">Typhoid 3</option>
                                            <option value="typhoid_3_4">Typhoid 4</option>
                                            <option value="typhoid_3_5">Typhoid 5</option>
                                            <option value="typhoid_3_6">Typhoid 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group Typhoid - 3 years -->

                                <div class="mb-3 row form-group">

                                    <label for="albendandazole" class="col col-form-label">Albendandazole 400mg</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="albendandazole" id="albendandazole" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="albendandazole_1">Albendandazole 1</option>
                                            <option value="albendandazole_2">Albendandazole 2</option>
                                            <option value="albendandazole_3">Albendandazole 3</option>
                                            <option value="albendandazole_4">Albendandazole 4</option>
                                            <option value="albendandazole_5">Albendandazole 5</option>
                                            <option value="albendandazole_6">Albendandazole 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group Albendandazole -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.Anamnesis dan Riwayat Kesehatan -->

                    <!-- anamnesis_2 Accordion -->
                    <div id="tanda-vital" class="section-anamnesis_2" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
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

                    <!-- Pemeriksaan Generalisata Accordion -->
                    <div id="generalisata" class="section-generalisata" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Generalisata</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group">

                                    <label for="heent" class="col col-form-label">HEENT</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="heent" id="heent" rows="7" placeholder="Description" :error="'heent'" />

                                    </div>

                                </div><!-- /.form-group heent -->

                                <div class="mb-3 row form-group">

                                    <label for="orodental" class="col col-form-label">ORODENTAL</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="orodental" id="orodental" rows="7" placeholder="Description" :error="'orodental'" />

                                    </div>

                                </div><!-- /.form-group orodental -->

                                <div class="mb-3 row form-group">

                                    <label for="kardiovaskuler" class="col col-form-label">SISTEM KARDIOVASKULER</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="kardiovaskuler" id="kardiovaskuler" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="kardiovaskuler_1">Kardiovaskuler 1</option>
                                            <option value="kardiovaskuler_2">Kardiovaskuler 2</option>
                                            <option value="kardiovaskuler_3">Kardiovaskuler 3</option>
                                            <option value="kardiovaskuler_4">Kardiovaskuler 4</option>
                                            <option value="kardiovaskuler_5">Kardiovaskuler 5</option>
                                            <option value="kardiovaskuler_6">Kardiovaskuler 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group kardiovaskuler -->

                                <div class="mb-3 row form-group">

                                    <label for="respiratorius" class="col col-form-label">SISTEM RESPIRATORIUS</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="respiratorius" id="respiratorius" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="respiratorius_1">Respiratorius 1</option>
                                            <option value="respiratorius_2">Respiratorius 2</option>
                                            <option value="respiratorius_3">Respiratorius 3</option>
                                            <option value="respiratorius_4">Respiratorius 4</option>
                                            <option value="respiratorius_5">Respiratorius 5</option>
                                            <option value="respiratorius_6">Respiratorius 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group respiratorius -->

                                <div class="mb-3 row form-group">

                                    <label for="digestivus" class="col col-form-label">SISTEM DIGESTIVUS</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="digestivus" id="digestivus" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="digestivus_1">Digestivus 1</option>
                                            <option value="digestivus_2">Digestivus 2</option>
                                            <option value="digestivus_3">Digestivus 3</option>
                                            <option value="digestivus_4">Digestivus 4</option>
                                            <option value="digestivus_5">Digestivus 5</option>
                                            <option value="digestivus_6">Digestivus 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group digestivus -->

                                <div class="mb-3 row form-group">

                                    <label for="genitourinarius" class="col col-form-label">SISTEM GENITOURINARIUS+KULIT</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="genitourinarius" id="genitourinarius" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="genitourinarius_1">Genitourinarius 1</option>
                                            <option value="genitourinarius_2">Genitourinarius 2</option>
                                            <option value="genitourinarius_3">Genitourinarius 3</option>
                                            <option value="genitourinarius_4">Genitourinarius 4</option>
                                            <option value="genitourinarius_5">Genitourinarius 5</option>
                                            <option value="genitourinarius_6">Genitourinarius 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group genitourinarius -->

                                <div class="mb-3 row form-group">

                                    <label for="neuromuskular" class="col col-form-label">SISTEM NEUROMUSKULAR</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="neuromuskular" id="neuromuskular" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="neuromuskular_1">Neuromuskular 1</option>
                                            <option value="neuromuskular_2">Neuromuskular 2</option>
                                            <option value="neuromuskular_3">Neuromuskular 3</option>
                                            <option value="neuromuskular_4">Neuromuskular 4</option>
                                            <option value="neuromuskular_5">Neuromuskular 5</option>
                                            <option value="neuromuskular_6">Neuromuskular 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group neuromuskular -->

                                <div class="mb-3 row form-group">

                                    <label for="hep_A_1" class="col d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Hep A - 1st</span>
                                        <span class="opacity-50 lh-sm">Fitness harvard test</span>
                                    </label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="hep_A_1" id="hep_A_1" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="hep_A_1_1">Hep A 1</option>
                                            <option value="hep_A_1_2">Hep A 2</option>
                                            <option value="hep_A_1_3">Hep A 3</option>
                                            <option value="hep_A_1_4">Hep A 4</option>
                                            <option value="hep_A_1_5">Hep A 5</option>
                                            <option value="hep_A_1_6">Hep A 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group hep_A_1 -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.generalisata -->

                    <!-- Pemeriksaan Virus Accordion -->
                    <div id="virus" class="section-virus" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Virus</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <h6 class="fw-normal mb-3">Non Koreksi</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">

                                        <label for="non_koreksi_od" class="col col-form-label">Visus jauh OD</label>
                                        <x-inputs.mask wire:model="non_koreksi_od" id="non_koreksi_od" x-mask="9/9" placeholder="0/0" :error="'non_koreksi_od'" />

                                    </div>

                                    <div class="col">

                                        <label for="non_koreksi_os" class="col col-form-label">Visus jauh OS</label>
                                        <x-inputs.mask wire:model="non_koreksi_os" id="non_koreksi_os" x-mask="9/9" placeholder="0/0" :error="'non_koreksi_os'" />

                                    </div>

                                    <div class="col">

                                        <label for="non_koreksi_ods" class="col col-form-label">Visus jauh ODS</label>
                                        <x-inputs.mask wire:model="non_koreksi_ods" id="non_koreksi_ods" x-mask="9/9" placeholder="0/0" :error="'non_koreksi_ods'" />

                                    </div>

                                </div><!-- /.form-group non koreksi -->

                                <h6 class="fw-normal mb-3">Koreksi</h6>

                                <div class="mb-5 row form-group">

                                    <div class="col">

                                        <label for="koreksi_od" class="col col-form-label">Visus jauh OD</label>
                                        <x-inputs.mask wire:model="koreksi_od" id="koreksi_od" x-mask="9/9" placeholder="0/0" :error="'koreksi_od'" />

                                    </div>

                                    <div class="col">

                                        <label for="koreksi_os" class="col col-form-label">Visus jauh OS</label>
                                        <x-inputs.mask wire:model="koreksi_os" id="koreksi_os" x-mask="9/9" placeholder="0/0" :error="'koreksi_os'" />

                                    </div>

                                    <div class="col">

                                        <label for="koreksi_ods" class="col col-form-label">Visus jauh ODS</label>
                                        <x-inputs.mask wire:model="koreksi_ods" id="koreksi_ods" x-mask="9/9" placeholder="0/0" :error="'koreksi_ods'" />

                                    </div>

                                </div><!-- /.form-group koreksi -->

                                <div class="mb-3 row form-group">

                                    <label for="kesan_visus_jauh" class="col col-form-label">Kesan Visus Jauh</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="kesan_visus_jauh" id="kesan_visus_jauh" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="kesan_visus_jauh_1">Kesan Visus Jauh 1</option>
                                            <option value="kesan_visus_jauh_2">Kesan Visus Jauh 2</option>
                                            <option value="kesan_visus_jauh_3">Kesan Visus Jauh 3</option>
                                            <option value="kesan_visus_jauh_4">Kesan Visus Jauh 4</option>
                                            <option value="kesan_visus_jauh_5">Kesan Visus Jauh 5</option>
                                            <option value="kesan_visus_jauh_6">Kesan Visus Jauh 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group kesan_visus_jauh -->

                                <div class="mb-3 row form-group">

                                    <label for="reading_test" class="col col-form-label">READING TEST / Visus Dekat / Jaeger Test</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="reading_test" id="reading_test" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="reading_test_1">READING TEST 1</option>
                                            <option value="reading_test_2">READING TEST 2</option>
                                            <option value="reading_test_3">READING TEST 3</option>
                                            <option value="reading_test_4">READING TEST 4</option>
                                            <option value="reading_test_5">READING TEST 5</option>
                                            <option value="reading_test_6">READING TEST 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group reading_test -->

                                <div class="mb-3 row form-group">

                                    <label for="buta_warna" class="col col-form-label">Buta Warna</label>

                                    <div class="col-8">

                                        <div class="form-check form-check-inline">
                                            <input wire:model="buta_warna" class="form-check-input" type="radio" name="buta_warna" id="buta_warna-1" value="normal">
                                            <label class="form-check-label" for="buta_warna-1">Normal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="buta_warna" class="form-check-input" type="radio" name="buta_warna" id="buta_warna-2" value="abnormal">
                                            <label class="form-check-label" for="buta_warna-2">Abnormal</label>
                                        </div>

                                    </div>

                                </div><!-- /.form-group buta_warna -->

                                <div class="mb-3 row form-group">

                                    <label for="catatan" class="col col-form-label">Catatan</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="catatan" id="catatan" rows="7" placeholder="Description" :error="'catatan'" />

                                    </div>

                                </div><!-- /.form-group catatan -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.virus -->

                    <!-- Audiometri Accordion -->
                    <div id="audiometri" class="section-audiometri" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Audiometri</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <h6 class="fw-normal mb-3">Air conduction Kanan</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">

                                        <label for="ac_kanan_500" class="col col-form-label">500</label>
                                        <x-inputs.number wire:model="ac_kanan_500" id="ac_kanan_500" placeholder="0" :error="'ac_kanan_500'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_1000" class="col col-form-label">1000</label>
                                        <x-inputs.number wire:model="ac_kanan_1000" id="ac_kanan_1000" placeholder="0" :error="'ac_kanan_1000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_2000" class="col col-form-label">2000</label>
                                        <x-inputs.number wire:model="ac_kanan_2000" id="ac_kanan_2000" placeholder="0" :error="'ac_kanan_2000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_3000" class="col col-form-label">3000</label>
                                        <x-inputs.number wire:model="ac_kanan_3000" id="ac_kanan_3000" placeholder="0" :error="'ac_kanan_3000'" />

                                    </div>

                                </div><!-- /.form-group ac_kanan -->

                                <div class="mb-5 row form-group">

                                    <div class="col">

                                        <label for="ac_kanan_4000" class="col col-form-label">4000</label>
                                        <x-inputs.number wire:model="ac_kanan_4000" id="ac_kanan_4000" placeholder="0" :error="'ac_kanan_4000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_6000" class="col col-form-label">6000</label>
                                        <x-inputs.number wire:model="ac_kanan_6000" id="ac_kanan_6000" placeholder="0" :error="'ac_kanan_6000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_8000" class="col col-form-label">8000</label>
                                        <x-inputs.number wire:model="ac_kanan_8000" id="ac_kanan_8000" placeholder="0" :error="'ac_kanan_8000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kanan_htl" class="col col-form-label">HTL</label>
                                        <x-inputs.number wire:model="ac_kanan_htl" id="ac_kanan_htl" placeholder="0" :error="'ac_kanan_htl'" />

                                    </div>

                                </div><!-- /.form-group ac_kanan -->

                                <h6 class="fw-normal mb-3">Bone conduction Kanan</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">

                                        <label for="bc_kanan_500" class="col col-form-label">500</label>
                                        <x-inputs.number wire:model="bc_kanan_500" id="bc_kanan_500" placeholder="0" :error="'bc_kanan_500'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_1000" class="col col-form-label">1000</label>
                                        <x-inputs.number wire:model="bc_kanan_1000" id="bc_kanan_1000" placeholder="0" :error="'bc_kanan_1000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_2000" class="col col-form-label">2000</label>
                                        <x-inputs.number wire:model="bc_kanan_2000" id="bc_kanan_2000" placeholder="0" :error="'bc_kanan_2000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_3000" class="col col-form-label">3000</label>
                                        <x-inputs.number wire:model="bc_kanan_3000" id="bc_kanan_3000" placeholder="0" :error="'bc_kanan_3000'" />

                                    </div>

                                </div><!-- /.form-group bc_kanan -->

                                <div class="mb-5 row form-group">

                                    <div class="col">

                                        <label for="bc_kanan_4000" class="col col-form-label">4000</label>
                                        <x-inputs.number wire:model="bc_kanan_4000" id="bc_kanan_4000" placeholder="0" :error="'bc_kanan_4000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_6000" class="col col-form-label">6000</label>
                                        <x-inputs.number wire:model="bc_kanan_6000" id="bc_kanan_6000" placeholder="0" :error="'bc_kanan_6000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_8000" class="col col-form-label">8000</label>
                                        <x-inputs.number wire:model="bc_kanan_8000" id="bc_kanan_8000" placeholder="0" :error="'bc_kanan_8000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kanan_htl" class="col col-form-label">HTL</label>
                                        <x-inputs.number wire:model="bc_kanan_htl" id="bc_kanan_htl" placeholder="0" :error="'bc_kanan_htl'" />

                                    </div>

                                </div><!-- /.form-group bc_kanan -->

                                <h6 class="fw-normal mb-3">Air conduction Kiri</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">

                                        <label for="ac_kiri_500" class="col col-form-label">500</label>
                                        <x-inputs.number wire:model="ac_kiri_500" id="ac_kiri_500" placeholder="0" :error="'ac_kiri_500'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_1000" class="col col-form-label">1000</label>
                                        <x-inputs.number wire:model="ac_kiri_1000" id="ac_kiri_1000" placeholder="0" :error="'ac_kiri_1000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_2000" class="col col-form-label">2000</label>
                                        <x-inputs.number wire:model="ac_kiri_2000" id="ac_kiri_2000" placeholder="0" :error="'ac_kiri_2000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_3000" class="col col-form-label">3000</label>
                                        <x-inputs.number wire:model="ac_kiri_3000" id="ac_kiri_3000" placeholder="0" :error="'ac_kiri_3000'" />

                                    </div>

                                </div><!-- /.form-group ac_kanan -->

                                <div class="mb-5 row form-group">

                                    <div class="col">

                                        <label for="ac_kiri_4000" class="col col-form-label">4000</label>
                                        <x-inputs.number wire:model="ac_kiri_4000" id="ac_kiri_4000" placeholder="0" :error="'ac_kiri_4000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_6000" class="col col-form-label">6000</label>
                                        <x-inputs.number wire:model="ac_kiri_6000" id="ac_kiri_6000" placeholder="0" :error="'ac_kiri_6000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_8000" class="col col-form-label">8000</label>
                                        <x-inputs.number wire:model="ac_kiri_8000" id="ac_kiri_8000" placeholder="0" :error="'ac_kiri_8000'" />

                                    </div>

                                    <div class="col">

                                        <label for="ac_kiri_htl" class="col col-form-label">HTL</label>
                                        <x-inputs.number wire:model="ac_kiri_htl" id="ac_kiri_htl" placeholder="0" :error="'ac_kiri_htl'" />

                                    </div>

                                </div><!-- /.form-group ac_kiri -->

                                <h6 class="fw-normal mb-3">Bone conduction Kiri</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">

                                        <label for="bc_kiri_500" class="col col-form-label">500</label>
                                        <x-inputs.number wire:model="bc_kiri_500" id="bc_kiri_500" placeholder="0" :error="'bc_kiri_500'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_1000" class="col col-form-label">1000</label>
                                        <x-inputs.number wire:model="bc_kiri_1000" id="bc_kiri_1000" placeholder="0" :error="'bc_kiri_1000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_2000" class="col col-form-label">2000</label>
                                        <x-inputs.number wire:model="bc_kiri_2000" id="bc_kiri_2000" placeholder="0" :error="'bc_kiri_2000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_3000" class="col col-form-label">3000</label>
                                        <x-inputs.number wire:model="bc_kiri_3000" id="bc_kiri_3000" placeholder="0" :error="'bc_kiri_3000'" />

                                    </div>

                                </div><!-- /.form-group ac_kanan -->

                                <div class="mb-5 row form-group">

                                    <div class="col">

                                        <label for="bc_kiri_4000" class="col col-form-label">4000</label>
                                        <x-inputs.number wire:model="bc_kiri_4000" id="bc_kiri_4000" placeholder="0" :error="'bc_kiri_4000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_6000" class="col col-form-label">6000</label>
                                        <x-inputs.number wire:model="bc_kiri_6000" id="bc_kiri_6000" placeholder="0" :error="'bc_kiri_6000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_8000" class="col col-form-label">8000</label>
                                        <x-inputs.number wire:model="bc_kiri_8000" id="bc_kiri_8000" placeholder="0" :error="'bc_kiri_8000'" />

                                    </div>

                                    <div class="col">

                                        <label for="bc_kiri_htl" class="col col-form-label">HTL</label>
                                        <x-inputs.number wire:model="bc_kiri_htl" id="bc_kiri_htl" placeholder="0" :error="'bc_kiri_htl'" />

                                    </div>

                                </div><!-- /.form-group ac_kiri -->

                                <div class="mb-3 row form-group">

                                    <label for="kesimpulan" class="col col-form-label">Kesimpulan</label>

                                    <div class="col-8">

                                        <x-inputs.textarea wire:model="kesimpulan" id="kesimpulan" rows="7" placeholder="Description" :error="'kesimpulan'" />

                                    </div>

                                </div><!-- /.form-group kesimpulan -->

                                <div class="mb-3 row form-group">

                                    <label for="kesan_audiometri" class="col col-form-label">Kesan</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="kesan_audiometri" id="kesan_audiometri" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="kesan_1">Kesan 1</option>
                                            <option value="kesan_2">Kesan 2</option>
                                            <option value="kesan_3">Kesan 3</option>
                                            <option value="kesan_4">Kesan 4</option>
                                            <option value="kesan_5">Kesan 5</option>
                                            <option value="kesan_6">Kesan 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group kesan_audiometri -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.audiometri -->

                    <!-- Spirometri Accordion -->
                    <div id="spirometri" class="section-spirometri" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Spirometri</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group">

                                    <label for="fvc" class="col col-form-label">FVC</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="fvc" id="fvc" placeholder="0" value="0" :error="'fvc'" />
                                    </div>

                                </div><!-- /.form-group FVC -->

                                <div class="mb-3 row form-group">

                                    <label for="fev1" class="col col-form-label">FEV1</label>
                                    <div class="col-8">
                                        <x-inputs.number wire:model="fev1" id="fev1" placeholder="0" value="0" :error="'fev1'" />
                                    </div>

                                </div><!-- /.form-group FVC -->

                                <div class="mb-3 row form-group">

                                    <label for="kesan_spirometri" class="col col-form-label">Kesan</label>

                                    <div class="col-8">

                                        <x-inputs.select2 wire:model="kesan_spirometri" id="kesan_spirometri" class="form-select" placeholder="Select result">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select result</option>
                                            <option value="kesan_1">Kesan 1</option>
                                            <option value="kesan_2">Kesan 2</option>
                                            <option value="kesan_3">Kesan 3</option>
                                            <option value="kesan_4">Kesan 4</option>
                                            <option value="kesan_5">Kesan 5</option>
                                            <option value="kesan_6">Kesan 6</option>
                                        </x-inputs.select2>

                                    </div>

                                </div><!-- /.form-group kesan_spirometri -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.spirometri -->

                    <!-- Pemeriksaan Penunjang Accordion -->
                    <div id="penunjang" class="section-penunjang" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
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

                                    <label for="treadmill" class="col d-flex gap-3 align-items-center">
                                        <span class="col-form-label pb-0 lh-sm">Treadmill</span>
                                        <span
                                            class="icon-tooltip"
                                            x-data="{tooltip:false}"
                                            x-on:mouseover="tooltip = true"
                                            x-on:mouseleave="tooltip = false"
                                        >
                                            <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                            <div class="tooltip-content" x-show="tooltip">Usia >40 tahun wajib mengikuti treadmill test</div>
                                        </span>
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

                    <!-- Laboratorium Accordion -->
                    <div id="lab" class="section-lab" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Laboratorium</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <h6 class="fw-normal mb-3">Complete Blood Count</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="hb" class="col col-form-label">Hb</label>
                                        <x-inputs.number wire:model="hb" id="hb" placeholder="0/0" :error="'hb'" />
                                    </div>

                                    <div class="col">
                                        <label for="ht" class="col col-form-label">Ht</label>
                                        <x-inputs.number wire:model="ht" id="ht" placeholder="0/0" :error="'ht'" />
                                    </div>

                                    <div class="col">
                                        <label for="leukosit" class="col col-form-label">Leukosit</label>
                                        <x-inputs.number wire:model="leukosit" id="leukosit" placeholder="0/0" :error="'leukosit'" />
                                    </div>

                                    <div class="col">
                                        <label for="thrombosit" class="col col-form-label">Thrombosit</label>
                                        <x-inputs.number wire:model="thrombosit" id="thrombosit" placeholder="0/0" :error="'thrombosit'" />
                                    </div>

                                </div><!-- /.form-group hb, ht -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="eritrosit" class="col col-form-label">Eritrosit</label>
                                        <x-inputs.number wire:model="eritrosit" id="eritrosit" placeholder="0/0" :error="'eritrosit'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="led" class="col col-form-label">LED</label>
                                        <x-inputs.number wire:model="led" id="led" placeholder="0/0" :error="'led'" />
                                    </div>

                                </div><!-- /.form-group non koreksi -->

                                <h6 class="fw-normal mb-3">Blood Group</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="gol_darah" class="col col-form-label">Golongan Darah</label>
                                        <x-inputs.select2 wire:model="gol_darah" id="gol_darah" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="ab">AB</option>
                                            <option value="o">O</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="rhesus" class="col col-form-label">Rhesus</label>
                                        <x-inputs.select2 wire:model="rhesus" id="rhesus" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="plus">Plus</option>
                                            <option value="negative">Negative</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group gol_darah -->

                                <h6 class="fw-normal mb-3">Fungsi Hati</h6>

                                <div class="mb-5 row form-group">

                                    <div class="col">
                                        <label for="sgot" class="col col-form-label">SGOT</label>
                                        <x-inputs.number wire:model="sgot" id="sgot" placeholder="0" :error="'sgot'" />
                                    </div>

                                    <div class="col">
                                        <label for="sgpt" class="col col-form-label">SGPT</label>
                                        <x-inputs.number wire:model="sgpt" id="sgpt" placeholder="0" :error="'sgpt'" />
                                    </div>

                                    <div class="col">
                                        <label for="gamma_gt" class="col col-form-label">Gamma GT</label>
                                        <x-inputs.number wire:model="gamma_gt" id="gamma_gt" placeholder="0" :error="'gamma_gt'" />
                                    </div>

                                </div><!-- /.form-group fungsi hati -->

                                <h6 class="fw-normal mb-3">Profil Lipid</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="kolesterol" class="col col-form-label">Kolesterol Total</label>
                                        <x-inputs.number wire:model="kolesterol" id="kolesterol" placeholder="0" :error="'kolesterol'" />
                                    </div>

                                    <div class="col">
                                        <label for="hdl" class="col col-form-label">HDL</label>
                                        <x-inputs.number wire:model="hdl" id="hdl" placeholder="0" :error="'hdl'" />
                                    </div>

                                    <div class="col">
                                        <label for="ldl" class="col col-form-label">LDL</label>
                                        <x-inputs.number wire:model="ldl" id="ldl" placeholder="0" :error="'ldl'" />
                                    </div>

                                    <div class="col">
                                        <label for="tga" class="col col-form-label">TGA</label>
                                        <x-inputs.number wire:model="tga" id="tga" placeholder="0" :error="'tga'" />
                                    </div>

                                </div><!-- /.form-group kolesterol -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="billirubin_total" class="col col-form-label">Billirubin Total</label>
                                        <x-inputs.number wire:model="billirubin_total" id="billirubin_total" placeholder="0" :error="'billirubin_total'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="billirubin_direk" class="col col-form-label">Billirubin direk</label>
                                        <x-inputs.number wire:model="billirubin_direk" id="billirubin_direk" placeholder="0" :error="'billirubin_direk'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="billirubin_indirek" class="col col-form-label">Billirubin indirek</label>
                                        <x-inputs.number wire:model="billirubin_indirek" id="billirubin_indirek" placeholder="0" :error="'billirubin_indirek'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="dislipidemia" class="col col-form-label">Status Dislipidemia</label>
                                        <x-inputs.number wire:model="dislipidemia" id="dislipidemia" placeholder="0" :error="'dislipidemia'" />
                                    </div>

                                </div><!-- /.form-group billirubin -->

                                <h6 class="fw-normal mb-3">Glukosa Darah</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="gdpt" class="col col-form-label">GDPt</label>
                                        <x-inputs.number wire:model="gdpt" id="gdpt" placeholder="0" :error="'gdpt'" />
                                    </div>

                                    <div class="col">
                                        <label for="g2pp" class="col col-form-label">G2PP</label>
                                        <x-inputs.number wire:model="g2pp" id="g2pp" placeholder="0" :error="'g2pp'" />
                                    </div>

                                    <div class="col">
                                        <label for="hiperglikemia" class="col col-form-label">STATUS HIPERGLIKEMIA</label>
                                        <x-inputs.text wire:model="hiperglikemia" id="hiperglikemia" placeholder="Input" :error="'hiperglikemia'" />
                                    </div>

                                    <div class="col">
                                        <label for="hba1c" class="col col-form-label">HbA1C</label>
                                        <x-inputs.number wire:model="hba1c" id="hba1c" placeholder="0" :error="'hba1c'" />
                                    </div>

                                </div><!-- /.form-group -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="dm" class="col col-form-label">Status DM</label>
                                        <x-inputs.text wire:model="dm" id="dm" placeholder="0" :error="'dm'" />
                                    </div>

                                </div><!-- /.form-group Glukosa Darah -->

                                <h6 class="fw-normal mb-3">Framingham Risk</h6>

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="risk_score" class="col col-form-label">SCORE</label>
                                        <x-inputs.text wire:model="risk_score" id="risk_score" placeholder="Show Result" :error="'risk_score'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="risk_level" class="col col-form-label">RISK LEVEL</label>
                                        <x-inputs.select2 wire:model="risk_level" id="risk_level" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="risk_level_1">RISK LEVEL 1</option>
                                            <option value="risk_level_2">RISK LEVEL 2</option>
                                            <option value="risk_level_3">RISK LEVEL 3</option>
                                            <option value="risk_level_4">RISK LEVEL 4</option>
                                            <option value="risk_level_5">RISK LEVEL 5</option>
                                            <option value="risk_level_6">RISK LEVEL 6</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Framingham Risk -->

                                <h6 class="fw-normal mb-3">Fungsi Ginjal</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="ureum" class="col col-form-label">Ureum</label>
                                        <x-inputs.number wire:model="ureum" id="ureum" placeholder="0" :error="'ureum'" />
                                    </div>

                                    <div class="col">
                                        <label for="bun" class="col col-form-label">BUN</label>
                                        <x-inputs.number wire:model="bun" id="bun" placeholder="0" :error="'bun'" />
                                    </div>

                                    <div class="col">
                                        <label for="creatinin" class="col col-form-label">Creatinin</label>
                                        <x-inputs.number wire:model="creatinin" id="creatinin" placeholder="Input" :error="'creatinin'" />
                                    </div>

                                    <div class="col">
                                        <label for="asam_urat" class="col col-form-label">Asam urat</label>
                                        <x-inputs.number wire:model="asam_urat" id="asam_urat" placeholder="0" :error="'asam_urat'" />
                                    </div>

                                </div><!-- /.form-group -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="egfr" class="col col-form-label">eGFR</label>
                                        <x-inputs.text wire:model="egfr" id="egfr" placeholder="0" :error="'egfr'" />
                                    </div>

                                </div><!-- /.form-group Fungsi Ginjal -->

                                <h6 class="fw-normal mb-3">Imunoserologi</h6>

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="hbs_ag" class="col col-form-label">HBs-Ag</label>
                                        <x-inputs.select2 wire:model="hbs_ag" id="hbs_ag" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="hbs_ag_1">HBs-Ag 1</option>
                                            <option value="hbs_ag_2">HBs-Ag 2</option>
                                            <option value="hbs_ag_3">HBs-Ag 3</option>
                                            <option value="hbs_ag_4">HBs-Ag 4</option>
                                            <option value="hbs_ag_5">HBs-Ag 5</option>
                                            <option value="hbs_ag_6">HBs-Ag 6</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="anti_hbs" class="col col-form-label">Anti HBs</label>
                                        <x-inputs.select2 wire:model="anti_hbs" id="anti_hbs" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="anti_hbs_1">Anti HBs 1</option>
                                            <option value="anti_hbs_2">Anti HBs 2</option>
                                            <option value="anti_hbs_3">Anti HBs 3</option>
                                            <option value="anti_hbs_4">Anti HBs 4</option>
                                            <option value="anti_hbs_5">Anti HBs 5</option>
                                            <option value="anti_hbs_6">Anti HBs 6</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="anti_hav" class="col col-form-label">Anti HAV IgM</label>
                                        <x-inputs.select2 wire:model="anti_hav" id="anti_hav" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="anti_hav_1">Anti HAV IgM 1</option>
                                            <option value="anti_hav_2">Anti HAV IgM 2</option>
                                            <option value="anti_hav_3">Anti HAV IgM 3</option>
                                            <option value="anti_hav_4">Anti HAV IgM 4</option>
                                            <option value="anti_hav_5">Anti HAV IgM 5</option>
                                            <option value="anti_hav_6">Anti HAV IgM 6</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="widal" class="col col-form-label">Widal</label>
                                        <x-inputs.select2 wire:model="widal" id="widal" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="widal_1">Widal 1</option>
                                            <option value="widal_2">Widal 2</option>
                                            <option value="widal_3">Widal 3</option>
                                            <option value="widal_4">Widal 4</option>
                                            <option value="widal_5">Widal 5</option>
                                            <option value="widal_6">Widal 6</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Imunoserologi -->

                                <h6 class="fw-normal mb-3">Malaria</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="malaria" class="col col-form-label">Malaria</label>
                                        <x-inputs.select2 wire:model="malaria" id="malaria" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="malaria_1">Malaria 1</option>
                                            <option value="malaria_2">Malaria 2</option>
                                            <option value="malaria_3">Malaria 3</option>
                                            <option value="malaria_4">Malaria 4</option>
                                            <option value="malaria_5">Malaria 5</option>
                                            <option value="malaria_6">Malaria 6</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Malaria -->

                                <h6 class="fw-normal mb-3">Urine Analisis Makroskopis</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="warna_urine" class="col col-form-label">Warna</label>
                                        <x-inputs.select2 wire:model="warna_urine" id="warna_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="kuning">Kuning</option>
                                            <option value="putih">Putih</option>
                                            <option value="merah">Merah</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="kejernihan_urine" class="col col-form-label">Kejernihan</label>
                                        <x-inputs.select2 wire:model="kejernihan_urine" id="kejernihan_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="jernih">Jernih</option>
                                            <option value="keruh">Keruh</option>
                                            <option value="merah">Merah</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="ph_urine" class="col col-form-label">pH</label>
                                        <x-inputs.number wire:model="ph_urine" id="ph_urine" placeholder="0" :error="'ph_urine'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="berat_jenis_urine" class="col col-form-label">Berat Jenis</label>
                                        <x-inputs.number wire:model="berat_jenis_urine" id="berat_jenis_urine" placeholder="0" :error="'berat_jenis_urine'" />
                                    </div>

                                </div><!-- /.form-group Urine warna, ph, berat jenis -->

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="protein_urine" class="col col-form-label">Protein</label>
                                        <x-inputs.select2 wire:model="protein_urine" id="protein_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="protein_urine_1">Protein 1</option>
                                            <option value="protein_urine_1">Protein 2</option>
                                            <option value="protein_urine_2">Protein 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="glukosa_urine" class="col col-form-label">Glukosa</label>
                                        <x-inputs.select2 wire:model="glukosa_urine" id="glukosa_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="glukosa_urine_1">Glukosa 1</option>
                                            <option value="glukosa_urine_2">Glukosa 2</option>
                                            <option value="glukosa_urine_3">Glukosa 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="bilirubin_urine" class="col col-form-label">Bilirubin</label>
                                        <x-inputs.select2 wire:model="bilirubin_urine" id="bilirubin_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="bilirubin_urine_1">Bilirubin 1</option>
                                            <option value="bilirubin_urine_2">Bilirubin 2</option>
                                            <option value="bilirubin_urine_3">Bilirubin 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="urobilin_urine" class="col col-form-label">Urobilinogen/Urobilin</label>
                                        <x-inputs.select2 wire:model="urobilin_urine" id="urobilin_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="urobilin_urine_1">Urobilinogen/Urobilin 1</option>
                                            <option value="urobilin_urine_2">Urobilinogen/Urobilin 2</option>
                                            <option value="urobilin_urine_3">Urobilinogen/Urobilin 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Urine protein, glukosa, billirubin -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="keton_urine" class="col col-form-label">Keton</label>
                                        <x-inputs.select2 wire:model="keton_urine" id="keton_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="keton_urine_1">Keton 1</option>
                                            <option value="keton_urine_1">Keton 2</option>
                                            <option value="keton_urine_2">Keton 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="darah_urine" class="col col-form-label">Darah</label>
                                        <x-inputs.select2 wire:model="darah_urine" id="darah_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="darah_urine_1">Darah 1</option>
                                            <option value="darah_urine_2">Darah 2</option>
                                            <option value="darah_urine_3">Darah 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="lekositesterase_urine" class="col col-form-label">Lekositesterase</label>
                                        <x-inputs.select2 wire:model="lekositesterase_urine" id="lekositesterase_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="lekositesterase_urine_1">Lekositesterase 1</option>
                                            <option value="lekositesterase_urine_2">Lekositesterase 2</option>
                                            <option value="lekositesterase_urine_3">Lekositesterase 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="nitrit_urine" class="col col-form-label">Nitrit</label>
                                        <x-inputs.select2 wire:model="nitrit_urine" id="nitrit_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="nitrit_urine_1">Nitrit 1</option>
                                            <option value="nitrit_urine_2">Nitrit 2</option>
                                            <option value="nitrit_urine_3">Nitrit 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Urine keton, darah, nitrit -->

                                <h6 class="fw-normal mb-3">Urine Analisis Mikroskopis</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="sedimen_urine" class="col col-form-label">Sedimen Leukosit</label>
                                        <x-inputs.number wire:model="sedimen_urine" id="sedimen_urine" placeholder="0" :error="'sedimen_urine'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="eritrosit_urine" class="col col-form-label">Eritrosit</label>
                                        <x-inputs.number wire:model="eritrosit_urine" id="eritrosit_urine" placeholder="0" :error="'eritrosit_urine'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="epitel_urine" class="col col-form-label">Epitel</label>
                                        <x-inputs.number wire:model="epitel_urine" id="epitel_urine" placeholder="0" :error="'epitel_urine'" />
                                    </div>

                                    <div class="col-3">
                                        <label for="silinder_urine" class="col col-form-label">Silinder</label>
                                        <x-inputs.select2 wire:model="silinder_urine" id="silinder_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="silinder_urine_1">Silinder 1</option>
                                            <option value="silinder_urine_2">Silinder 2</option>
                                            <option value="silinder_urine_3">Silinder 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Urine sediman, eritrosit, epitel -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="kristal_urine" class="col col-form-label">Kristal</label>
                                        <x-inputs.select2 wire:model="kristal_urine" id="kristal_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="kristal_urine_1">Kristal 1</option>
                                            <option value="kristal_urine_2">Kristal 2</option>
                                            <option value="kristal_urine_3">Kristal 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="bakteri_urine" class="col col-form-label">Bakteri</label>
                                        <x-inputs.select2 wire:model="bakteri_urine" id="bakteri_urine" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="bakteri_urine_1">Bakteri 1</option>
                                            <option value="bakteri_urine_2">Bakteri 2</option>
                                            <option value="bakteri_urine_3">Bakteri 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Urine kristal, bakteri -->

                                <div class="mb-5 row form-group">

                                    <div class="col">
                                        <label for="lainnya_urine" class="col-form-label">Lainnya</label>
                                        <x-inputs.textarea wire:model="lainnya_urine" id="lainnya_urine" rows="7" placeholder="Description" :error="'lainnya_urine'" />
                                    </div>

                                </div><!-- /.form-group hasil_temuan -->

                                <h6 class="fw-normal mb-3">Drug Test</h6>

                                <div class="mb-3 row form-group">

                                    <div class="col-3">
                                        <label for="amp" class="col col-form-label">AMP</label>
                                        <x-inputs.select2 wire:model="amp" id="amp" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="amp_1">AMP 1</option>
                                            <option value="amp_2">AMP 2</option>
                                            <option value="amp_3">AMP 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="met" class="col col-form-label">MET</label>
                                        <x-inputs.select2 wire:model="met" id="met" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="met_1">MET 1</option>
                                            <option value="met_2">MET 2</option>
                                            <option value="met_3">MET 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="bdz" class="col col-form-label">BDZ</label>
                                        <x-inputs.select2 wire:model="bdz" id="bdz" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="bdz_1">BDZ 1</option>
                                            <option value="bdz_2">BDZ 2</option>
                                            <option value="bdz_3">BDZ 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="coc" class="col col-form-label">COC</label>
                                        <x-inputs.select2 wire:model="coc" id="coc" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="coc_1">COC 1</option>
                                            <option value="coc_2">COC 2</option>
                                            <option value="coc_3">COC 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group AMP, MET, BDZ, COC -->

                                <div class="mb-5 row form-group">

                                    <div class="col-3">
                                        <label for="opi" class="col col-form-label">OPI</label>
                                        <x-inputs.select2 wire:model="opi" id="opi" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="opi_1">OPI 1</option>
                                            <option value="opi_2">OPI 2</option>
                                            <option value="opi_3">OPI 3</option>
                                        </x-inputs.select2>
                                    </div>

                                    <div class="col-3">
                                        <label for="thc" class="col col-form-label">THC</label>
                                        <x-inputs.select2 wire:model="thc" id="thc" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="thc_1">THC 1</option>
                                            <option value="thc_2">THC 2</option>
                                            <option value="thc_3">THC 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group OPI, THC -->

                                <h6 class="fw-normal mb-3">Feses</h6>

                                <div class="mb-3 row form-group">

                                    <label for="analisa_feses" class="col-4 d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Analisis feses</span>
                                        <span class="opacity-50 lh-sm">Khusus food handler</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.select2 wire:model="analisa_feses" id="analisa_feses" class="form-select" placeholder="Select Option">
                                            <!-- option bisa di ambil dari livewire controller tinggal foreach di sini -->
                                            <option value="">Select Option</option>
                                            <option value="analisa_feses_1">Analisis feses 1</option>
                                            <option value="analisa_feses_2">Analisis feses 2</option>
                                            <option value="analisa_feses_3">Analisis feses 3</option>
                                        </x-inputs.select2>
                                    </div>

                                </div><!-- /.form-group Analisis feses -->

                                <div class="mb-3 row form-group">

                                    <label for="analisa_feses" class="col-4 d-flex flex-column">
                                        <span class="col-form-label pb-0 lh-sm">Kultur feses</span>
                                        <span class="opacity-50 lh-sm">Khusus food handler</span>
                                    </label>

                                    <div class="col-8">
                                        <x-inputs.textarea wire:model="kultur_feses" id="kultur_feses" rows="7" placeholder="Description" :error="'kultur_feses'" />
                                    </div>

                                </div><!-- /.form-group Analisis feses -->


                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.Laboratorium -->

                    <!-- Temuan Accordion -->
                    <div id="temuan" class="section-temuan" x-data="{accordionOpen: true}">

                        <button
                            class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-3 border-1 border-top border-bottom"
                            @click.prevent="accordionOpen = ! accordionOpen"
                        >
                            <h6 class="mb-0 fw-normal title-accordion">Temuan</h6>
                            <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
                        </button>
                        <div
                            class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                            x-ref="karyawan"
                            x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
                        >

                            <div class="content-section p-4">

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="hasil_temuan" class="col-form-label">Hasil Temuan</label>
                                        <x-inputs.textarea wire:model="hasil_temuan" id="hasil_temuan" rows="7" placeholder="Description" :error="'hasil_temuan'" />
                                    </div>

                                </div><!-- /.form-group hasil_temuan -->

                                <div class="mb-3 row form-group">

                                    <div class="col">
                                        <label for="matrix" class="col col-form-label">Kesesuaian Matrix</label>
                                        <x-inputs.textarea wire:model="matrix" id="matrix" rows="3" placeholder="Description" :error="'matrix'" />
                                    </div>

                                </div><!-- /.form-group matrix -->

                            </div><!-- /.content-section -->

                        </div><!-- /.wrapper-content-accordion -->

                    </div><!-- /.temuan -->

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('rekam-medis') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Submit for review</button>
                        </div>
                    </div>

                </form>

            </div><!-- content center -->

            <div class="col-3">
                <div class="section-sidebar-nav position-sticky top-0 py-4">
                    <ul>
                        <li><a href="#" @click.prevent="document.getElementById('karyawan').scrollIntoView()">Karyawan</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('anamnesis').scrollIntoView()">Riwayat</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('tanda-vital').scrollIntoView()">Tanda Vital</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('generalisata').scrollIntoView()">Pemeriksaan Generalisata</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('virus').scrollIntoView()">Pemeriksaan Virus</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('audiometri').scrollIntoView()">Audiometri</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('spirometri').scrollIntoView()">Spirometri</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('penunjang').scrollIntoView()">Pemeriksaan Penunjang</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('lab').scrollIntoView()">Laboratorium</a></li>
                    </ul>
                </div><!-- /.section-sidebar-nav -->
            </div><!-- sidebar navigation -->

        </div><!-- /.row -->
    </div><!-- /.container -->


</div>

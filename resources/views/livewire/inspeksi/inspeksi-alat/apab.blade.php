<div class="inner-content">

    <div class="header-content-inspeksi-alat h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - APAB</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-alat -->
    <div class="content-inspeksi-alat">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Alat K3 - APAB</h4>
                        </div><!-- /.title-form -->

                        <div class="content-form d-flex flex-column gap-3">

                            <div class="row form-group">
                                <label for="nomor_identitas" class="col col-form-label">Nomor Identitas</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="nomor_identitas" id="nomor_identitas" placeholder="Nomor Identitas" :error="'nomor_identitas'" />
                                </div>
                            </div><!-- /.form-group nomor_identitas -->

                            <div class="row form-group">
                                <label for="kriteria_inspeksi" class="col col-form-label">Kriteria Inspeksi</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="kriteria_inspeksi" id="kriteria_inspeksi" placeholder="Kriteria Inspeksi" :error="'kriteria_inspeksi'" />
                                </div>
                            </div><!-- /.form-group kriteria_inspeksi -->

                            <div class="row form-group">
                                <label for="tanggal" class="col col-form-label">Tanggal</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="tanggal" id="tanggal" placeholder="Tanggal Inspeksi" :error="'tanggal'" />
                                </div>
                            </div><!-- /.form-group tanggal -->

                            <div class="row form-group">
                                <label for="ccow" class="col col-form-label">CCOW</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="ccow" id="ccow" class="form-select" placeholder="Select CCOW">
                                        <option value="">Select CCOW</option>
                                        <option value="pt_1">PT Lahai Coal - LC</option>
                                        <option value="pt_2">PT Maruwai Coal - MC</option>
                                        <option value="pt_3">PT Juloi Coal - JC</option>
                                        <option value="pt_4">PT Kalteng Coal - KC</option>
                                        <option value="pt_5">PT Sumber Barito Caol - SBC</option>
                                        <option value="pt_6">PT Pari Coal - PC</option>
                                        <option value="pt_7">PT Ratah Coal - RC</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group ccow -->

                            <div class="row form-group">
                                <label for="nama_perusahaan" class="col col-form-label">Nama Perusahaan</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="nama_perusahaan" id="nama_perusahaan" class="form-select" placeholder="Select Nama Perusahaan">
                                        <option value="">Select Nama Perusahaan</option>
                                        <option value="pt_1">PT Lahai Coal - LC</option>
                                        <option value="pt_2">PT Maruwai Coal - MC</option>
                                        <option value="pt_3">PT Juloi Coal - JC</option>
                                        <option value="pt_4">PT Kalteng Coal - KC</option>
                                        <option value="pt_5">PT Sumber Barito Caol - SBC</option>
                                        <option value="pt_6">PT Pari Coal - PC</option>
                                        <option value="pt_7">PT Ratah Coal - RC</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group nama_perusahaan -->

                            <div class="row form-group">
                                <label for="departemen" class="col col-form-label">Departemen</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="departemen" id="departemen" placeholder="Departemen" :error="'departemen'" readonly />
                                </div>
                            </div><!-- /.form-group departemen -->

                            <div class="row form-group">
                                <label for="section" class="col col-form-label">Section</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="section" id="section" placeholder="Section" :error="'section'" readonly />
                                </div>
                            </div><!-- /.form-group section -->

                            <div class="row form-group">
                                <label for="lokasi" class="col col-form-label">Lokasi</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="lokasi" id="lokasi" placeholder="Lokasi" :error="'lokasi'" readonly />
                                </div>
                            </div><!-- /.form-group lokasi -->

                            <div class="row form-group">
                                <label for="detail_lokasi" class="col col-form-label">Detail Lokasi</label>
                                <div class="col-8">
                                    <x-inputs.text wire:model="detail_lokasi" id="detail_lokasi" placeholder="Detail Lokasi" :error="'detail_lokasi'" />
                                </div>
                            </div><!-- /.form-group detail_lokasi -->

                            <div class="row form-group">
                                <label for="ktt" class="col-lg-4 col-md-12 col-form-label">KTT</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.select2 wire:model="ktt" id="ktt" class="form-select" placeholder="Select KTT">
                                        <option value="">Select KTT</option>
                                        <option value="pt_1">PT Lahai Coal - LC</option>
                                        <option value="pt_2">PT Maruwai Coal - MC</option>
                                        <option value="pt_3">PT Juloi Coal - JC</option>
                                        <option value="pt_4">PT Kalteng Coal - KC</option>
                                        <option value="pt_5">PT Sumber Barito Caol - SBC</option>
                                        <option value="pt_6">PT Pari Coal - PC</option>
                                        <option value="pt_7">PT Ratah Coal - RC</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group ktt -->

                            <div class="row form-group">
                                <label for="pja" class="col-lg-4 col-md-12 col-form-label">PJA</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.text wire:model="pja" id="pja" placeholder="PJA" :error="'pja'" readonly />
                                </div>
                            </div><!-- /.form-group pja -->

                            <div class="row form-group">
                                <label for="petugas_inspeksi" class="col-lg-4 col-md-12 col-form-label">Petugas Inspeksi</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_petugas d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="petugas_inspeksi_1" id="petugas_inspeksi_1" class="form-select" placeholder="Petugas Inspeksi 1">
                                            <option value="">Petugas Inspeksi 1</option>
                                            <option value="pt_1">Petugas 1</option>
                                            <option value="pt_2">Petugas 2</option>
                                            <option value="pt_3">Petugas 3</option>
                                            <option value="pt_4">Petugas 4</option>
                                            <option value="pt_5">Petugas 5</option>
                                            <option value="pt_6">Petugas 6</option>
                                            <option value="pt_7">Petugas 7</option>
                                        </x-inputs.select2>

                                        <x-inputs.select2 wire:model="petugas_inspeksi_2" id="petugas_inspeksi_2" class="form-select" placeholder="Petugas Inspeksi 2">
                                            <option value="">Petugas Inspeksi 2</option>
                                            <option value="pt_1">Petugas 1</option>
                                            <option value="pt_2">Petugas 2</option>
                                            <option value="pt_3">Petugas 3</option>
                                            <option value="pt_4">Petugas 4</option>
                                            <option value="pt_5">Petugas 5</option>
                                            <option value="pt_6">Petugas 6</option>
                                            <option value="pt_7">Petugas 7</option>
                                        </x-inputs.select2>

                                        <x-inputs.select2 wire:model="petugas_inspeksi_3" id="petugas_inspeksi_3" class="form-select" placeholder="Petugas Inspeksi 3">
                                            <option value="">Petugas Inspeksi 3</option>
                                            <option value="pt_1">Petugas 1</option>
                                            <option value="pt_2">Petugas 2</option>
                                            <option value="pt_3">Petugas 3</option>
                                            <option value="pt_4">Petugas 4</option>
                                            <option value="pt_5">Petugas 5</option>
                                            <option value="pt_6">Petugas 6</option>
                                            <option value="pt_7">Petugas 7</option>
                                        </x-inputs.select2>
                                    </div><!-- /.wrapper_petugas -->
                                </div>
                            </div><!-- /.form-group petugas_inspeksi -->

                            <div class="row form-group">
                                <label for="id_apab" class="col-lg-4 col-md-12 col-form-label">No. ID APAB</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.select2 wire:model="id_apab" id="id_apab" class="form-select" placeholder="Select No ID APAB">
                                        <option value="">Select No ID APAB</option>
                                        <option value="id_1">ID 1</option>
                                        <option value="id_2">ID 2</option>
                                        <option value="id_3">ID 3</option>
                                        <option value="id_4">ID 4</option>
                                        <option value="id_5">ID 5</option>
                                        <option value="id_6">ID 6</option>
                                        <option value="id_7">ID 6</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group id_apab -->

                            <div class="row form-group">
                                <label for="tanggal_service" class="col col-form-label">Tanggal Service Tabung Tertera</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="tanggal_service" id="tanggal_service" placeholder="Tanggal Service Tabung Tertera" :error="'tanggal_service'" />
                                </div>
                            </div><!-- /.form-group tanggal_service -->

                            <div class="row form-group">
                                <label for="isi_apab" class="col-lg-4 col-md-12 col-form-label">Isi APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_isi_apab d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="isi_apab" id="isi_apab" class="form-select" placeholder="Select Isi APAB">
                                            <option value="">Select Isi APAB</option>
                                            <option value="powder">Powder</option>
                                            <option value="co2">CO2</option>
                                            <option value="water">Water</option>
                                            <option value="halon">Halon</option>
                                            <option value="foam">Foam</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_isi" id="file_isi" placeholder="Choose File" :error="'file_isi'" />

                                        <x-inputs.texteditor wire:model="komentar_isi" id="komentar_isi" placeholder="Komentar Isi" :error="'komentar_isi'" />

                                    </div><!-- /.wrapper_isi_apab -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group isi_apab -->

                            <div class="row form-group">
                                <label for="gol_apab" class="col-lg-4 col-md-12 col-form-label">Golongan APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_inspeksi d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="gol_apab" id="gol_apab" class="form-select" placeholder="Select Golongan APAB">
                                            <option value="">Select Golongan APAB</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="abc">A+B+C</option>
                                            <option value="na">N/A</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_gol" id="file_gol" placeholder="Choose File" :error="'file_gol'" />

                                        <x-inputs.texteditor wire:model="komentar_gol" id="komentar_gol" placeholder="Komentar Golongan APAB" :error="'komentar_gol'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group gol_apab -->

                            <div class="row form-group">
                                <label for="kapasitas_apab" class="col-lg-4 col-md-12 col-form-label">Kapasitas APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_inspeksi d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="kapasitas_apab" id="kapasitas_apab" class="form-select" placeholder="Select Kapasitas APAB">
                                            <option value="">Select Golongan APAB</option>
                                            <option value="1">1KG</option>
                                            <option value="2">2KG</option>
                                            <option value="3">3KG</option>
                                            <option value="4">4KG</option>
                                            <option value="5">5KG</option>
                                            <option value="6">6KG</option>
                                            <option value="7">7KG</option>
                                            <option value="8">8KG</option>
                                            <option value="9">9KG</option>
                                            <option value="10">10KG</option>
                                            <option value="na">N/A</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_kapasitas" id="file_kapasitas" placeholder="Choose File" :error="'file_kapasitas'" />

                                        <x-inputs.texteditor wire:model="komentar_kapasitas" id="komentar_kapasitas" placeholder="Komentar Kapasitas APAB" :error="'komentar_kapasitas'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kapasitas_apab -->

                            <div class="row form-group">
                                <label for="tuas_apab" class="col-lg-4 col-md-12 col-form-label">Tuas APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ tuas_apab: @entangle('tuas_apab') }"
                                        x-init="$watch('tuas_apab', (value) => {
                                            $refs.kondisi_tuas_apab.value = '';
                                            $refs.kondisi_tuas_apab.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="tuas_apab" id="tuas_apab" class="form-select" placeholder="Select Tuas APAB">
                                            <option value="">Select tuas APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_tuas_apab'  x-show="tuas_apab === 'Tidak Standard'" wire:model="kondisi_tuas_apab" id="kondisi_tuas_apab" class="form-select" placeholder="Select Kondisi Tuas APAB">
                                            <option value="">Select Konsidi Tuas APAB</option>
                                            <option value="Berkarat">Berkarat</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_tuas" id="file_tuas" placeholder="Choose File" :error="'file_tuas'" />

                                        <x-inputs.texteditor wire:model="komentar_tuas" id="komentar_tuas" placeholder="Komentar Tuas APAB" :error="'komentar_tuas'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group tuas_apab -->

                            <div class="row form-group">
                                <label for="handle_apab" class="col-lg-4 col-md-12 col-form-label">Handle APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ handle_apab: @entangle('handle_apab') }"
                                        x-init="$watch('handle_apab', (value) => {
                                            $refs.kondisi_handle_apab.value = '';
                                            $refs.kondisi_handle_apab.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="handle_apab" id="handle_apab" class="form-select" placeholder="Select Handle APAB">
                                            <option value="">Select Handle APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_handle_apab'  x-show="handle_apab === 'Tidak Standard'" wire:model="kondisi_handle_apab" id="kondisi_handle_apab" class="form-select" placeholder="Select Kondisi Handle APAB">
                                            <option value="">Select Konsidi Handle APAB</option>
                                            <option value="Berkarat">Berkarat</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_handle_apab" id="file_handle_apab" placeholder="Choose File" :error="'file_handle_apab'" />

                                        <x-inputs.texteditor wire:model="komentar_handle_apab" id="komentar_handle_apab" placeholder="Komentar Handle APAB" :error="'komentar_handle_apab'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group tuas_apab -->

                            <div class="row form-group">
                                <label for="pressure_gauge" class="col-lg-4 col-md-12 col-form-label">Pressure Gauge</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ pressure_gauge: @entangle('pressure_gauge') }"
                                        x-init="$watch('pressure_gauge', (value) => {
                                            $refs.kondisi_pressure_gauge.value = '';
                                            $refs.kondisi_pressure_gauge.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="pressure_gauge" id="pressure_gauge" class="form-select" placeholder="Select Pressure Gauge">
                                            <option value="">Select Pressure Gauge</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_pressure_gauge'  x-show="pressure_gauge === 'Tidak Standard'" wire:model="kondisi_pressure_gauge" id="kondisi_pressure_gauge" class="form-select" placeholder="Select Kondisi Pressure Gauge">
                                            <option value="">Select Konsidi Pressure Gauge</option>
                                            <option value="low">Low Pressure</option>
                                            <option value="over">Over pressure</option>
                                        </select>

                                        <x-inputs.file wire:model="file_pressure_gauge" id="file_pressure_gauge" placeholder="Choose File" :error="'file_pressure_gauge'" />

                                        <x-inputs.texteditor wire:model="komentar_pressure_gauge" id="komentar_pressure_gauge" placeholder="Komentar Pressure Gauge" :error="'komentar_pressure_gauge'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group pressure_gauge -->

                            <div class="row form-group">
                                <label for="pin_apab" class="col-lg-4 col-md-12 col-form-label">Pin APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ pin_apab: @entangle('pin_apab') }"
                                        x-init="$watch('pin_apab', (value) => {
                                            $refs.kondisi_pin_apab.value = '';
                                            $refs.kondisi_pin_apab.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="pin_apab" id="pin_apab" class="form-select" placeholder="Select PIN APAB">
                                            <option value="">Select PIN APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_pin_apab'  x-show="pin_apab === 'Tidak Standard'" wire:model="kondisi_pin_apab" id="kondisi_pin_apab" class="form-select" placeholder="Select Kondisi PIN APAB">
                                            <option value="">Select Konsidi PIN APAB</option>
                                            <option value="lepas">Terlepas</option>
                                            <option value="Berkarat">Berkarat</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_pin_apab" id="file_pin_apab" placeholder="Choose File" :error="'file_pin_apab'" />

                                        <x-inputs.texteditor wire:model="komentar_pin_apab" id="komentar_pin_apab" placeholder="Komentar PIN APAB" :error="'komentar_pin_apab'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group pin_apab -->

                            <div class="row form-group">
                                <label for="hose_apab" class="col-lg-4 col-md-12 col-form-label">Hose APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ hose_apab: @entangle('hose_apab') }"
                                        x-init="$watch('hose_apab', (value) => {
                                            $refs.kondisi_hose_apab.value = '';
                                            $refs.kondisi_hose_apab.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="hose_apab" id="hose_apab" class="form-select" placeholder="Select Hose APAB">
                                            <option value="">Select Hose APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_hose_apab'  x-show="hose_apab === 'Tidak Standard'" wire:model="kondisi_hose_apab" id="kondisi_hose_apab" class="form-select" placeholder="Select Kondisi Hose APAB">
                                            <option value="">Select Konsidi Hose APAB</option>
                                            <option value="robek">Robek</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_hose_apab" id="file_hose_apab" placeholder="Choose File" :error="'file_hose_apab'" />

                                        <x-inputs.texteditor wire:model="komentar_hose_apab" id="komentar_hose_apab" placeholder="Komentar Hose APAB" :error="'komentar_hose_apab'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group hose_apab -->

                            <div class="row form-group">
                                <label for="nozzle_apab" class="col-lg-4 col-md-12 col-form-label">Nozzle APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ nozzle_apab: @entangle('nozzle_apab') }"
                                        x-init="$watch('nozzle_apab', (value) => {
                                            $refs.kondisi_nozzle_apab.value = '';
                                            $refs.kondisi_nozzle_apab.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="nozzle_apab" id="nozzle_apab" class="form-select" placeholder="Select Nozzle APAB">
                                            <option value="">Select Nozzle APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_nozzle_apab'  x-show="nozzle_apab === 'Tidak Standard'" wire:model="kondisi_nozzle_apab" id="kondisi_nozzle_apab" class="form-select" placeholder="Select Kondisi Nozzle APAB">
                                            <option value="">Select Konsidi Nozzle APAB</option>
                                            <option value="buntu">Buntu</option>
                                            <option value="pecah">Pecah</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_nozzle_apab" id="file_nozzle_apab" placeholder="Choose File" :error="'file_nozzle_apab'" />

                                        <x-inputs.texteditor wire:model="komentar_nozzle_apab" id="komentar_nozzle_apab" placeholder="Komentar Nozzle APAB" :error="'komentar_nozzle_apab'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group nozzle_apab -->

                            <div class="row form-group">
                                <label for="kondisi_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi tabung/cylinder APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ kondisi_tabung: @entangle('kondisi_tabung') }"
                                        x-init="$watch('kondisi_tabung', (value) => {
                                            $refs.kondisi_kondisi_tabung.value = '';
                                            $refs.kondisi_kondisi_tabung.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="kondisi_tabung" id="kondisi_tabung" class="form-select" placeholder="Select Kondisi tabung/cylinder APAB">
                                            <option value="">Select Kondisi tabung/cylinder APAB</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_kondisi_tabung'  x-show="kondisi_tabung === 'Tidak Standard'" wire:model="kondisi_kondisi_tabung" id="kondisi_kondisi_tabung" class="form-select" placeholder="Select Kondisi tabung/cylin">
                                            <option value="">Select Konsidi Kondisi tabung/cylinder APAB</option>
                                            <option value="Berkarat">Berkarat</option>
                                            <option value="penyok">Penyok</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_tabung" id="file_kondisi_tabung" placeholder="Choose File" :error="'file_kondisi_tabung'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_tabung" id="komentar_kondisi_tabung" placeholder="Komentar Kondisi tabung/cylinder APAB" :error="'komentar_kondisi_tabung'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_tabung -->

                            <div class="row form-group">
                                <label for="cat_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi Cat Tabung APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ cat_tabung: @entangle('cat_tabung') }"
                                        x-init="$watch('cat_tabung', (value) => {
                                            $refs.kondisi_cat_tabung.value = '';
                                            $refs.kondisi_cat_tabung.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="cat_tabung" id="cat_tabung" class="form-select" placeholder="Select Cat Tabung">
                                            <option value="">Select Cat Tabung</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_cat_tabung'  x-show="cat_tabung === 'Tidak Standard'" wire:model="kondisi_cat_tabung" id="kondisi_cat_tabung" class="form-select" placeholder="Select Kondisi Cat Tabung">
                                            <option value="">Select Konsidi Cat Tabung</option>
                                            <option value="pudar">Warna Pudar</option>
                                            <option value="bukan_merah">Bukan Warna Merah</option>
                                        </select>

                                        <x-inputs.file wire:model="file_cat_tabung" id="file_cat_tabung" placeholder="Choose File" :error="'file_cat_tabung'" />

                                        <x-inputs.texteditor wire:model="komentar_cat_tabung" id="komentar_cat_tabung" placeholder="Komentar Cat Tabung" :error="'komentar_cat_tabung'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group cat_tabung -->

                            <div class="row form-group">
                                <label for="powder" class="col-lg-4 col-md-12 col-form-label">Kondisi Powder APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ powder: @entangle('powder') }"
                                        x-init="$watch('powder', (value) => {
                                            $refs.kondisi_powder.value = '';
                                            $refs.kondisi_powder.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="powder" id="powder" class="form-select" placeholder="Select Powder">
                                            <option value="">Select Powder</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_powder'  x-show="powder === 'Tidak Standard'" wire:model="kondisi_powder" id="kondisi_powder" class="form-select" placeholder="Select Kondisi Powder">
                                            <option value="">Select Konsidi Powder</option>
                                            <option value="beku">Beku</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_powder" id="file_powder" placeholder="Choose File" :error="'file_powder'" />

                                        <x-inputs.texteditor wire:model="komentar_powder" id="komentar_powder" placeholder="Komentar Powder" :error="'komentar_powder'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group powder -->

                            <div class="row form-group">
                                <label for="kip" class="col-lg-4 col-md-12 col-form-label">KIP (Kartu Inspeksi Peralatan)</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ kip: @entangle('kip') }"
                                        x-init="$watch('kip', (value) => {
                                            $refs.kondisi_kip.value = '';
                                            $refs.kondisi_kip.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="kip" id="kip" class="form-select" placeholder="Select KIP">
                                            <option value="">Select KIP</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_kip'  x-show="kip === 'Tidak Standard'" wire:model="kondisi_kip" id="kondisi_kip" class="form-select" placeholder="Select Kondisi KIP">
                                            <option value="">Select Konsidi KIP</option>
                                            <option value="belum">Belum Diperiksa</option>
                                            <option value="hilang">Hilang</option>
                                            <option value="rusak">Rusak</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kip" id="file_kip" placeholder="Choose File" :error="'file_kip'" />

                                        <x-inputs.texteditor wire:model="komentar_kip" id="komentar_kip" placeholder="Komentar KIP" :error="'komentar_kip'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kip -->

                            <div class="row form-group">
                                <label for="bracket" class="col-lg-4 col-md-12 col-form-label">Bracket APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ bracket: @entangle('bracket') }"
                                        x-init="$watch('bracket', (value) => {
                                            $refs.kondisi_bracket.value = '';
                                            $refs.kondisi_bracket.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="bracket" id="bracket" class="form-select" placeholder="Select Bracket">
                                            <option value="">Select Bracket</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Tidak Standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_bracket'  x-show="bracket === 'Tidak Standard'" wire:model="kondisi_bracket" id="kondisi_bracket" class="form-select" placeholder="Select Kondisi Bracket">
                                            <option value="">Select Konsidi Bracket</option>
                                            <option value="low">Low Pressure</option>
                                            <option value="over">Over pressure</option>
                                        </select>

                                        <x-inputs.file wire:model="file_bracket" id="file_bracket" placeholder="Choose File" :error="'file_bracket'" />

                                        <x-inputs.texteditor wire:model="komentar_bracket" id="komentar_bracket" placeholder="Komentar Bracket" :error="'komentar_bracket'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group bracket -->

                            <div class="row form-group">
                                <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label Penanda Lokasi APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                    >

                                        <select wire:model="label_penanda" id="label_penanda" class="form-select" placeholder="Select Label Penanda">
                                            <option value="">Select Label Penanda</option>
                                            <option value="ada">Ada</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                        </select>

                                        <x-inputs.file wire:model="file_label_penanda" id="file_label_penanda" placeholder="Choose File" :error="'file_label_penanda'" />

                                        <x-inputs.texteditor wire:model="komentar_label_penanda" id="komentar_label_penanda" placeholder="Komentar Label Penanda" :error="'komentar_label_penanda'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group label_penanda -->

                            <div class="row form-group">
                                <label for="demarkasi" class="col-lg-4 col-md-12 col-form-label">Demarkasi APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                    >

                                        <select wire:model="demarkasi" id="demarkasi" class="form-select" placeholder="Select Demarkasi APAB">
                                            <option value="">Select Demarkasi APAB</option>
                                            <option value="Ada Demarkasi">Ada Demarkasi</option>
                                            <option value="Warna Demarkasi Pudar">Warna Demarkasi Pudar</option>
                                            <option value="Tidak Ada">Tidak Ada Demarkasi</option>
                                        </select>

                                        <x-inputs.file wire:model="file_demarkasi" id="file_demarkasi" placeholder="Choose File" :error="'file_demarkasi'" />

                                        <x-inputs.texteditor wire:model="komentar_demarkasi" id="komentar_demarkasi" placeholder="Komentar Demarkasi APAB" :error="'komentar_demarkasi'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group demarkasi -->

                            <div class="row form-group">
                                <label for="kain_pelindung" class="col-lg-4 col-md-12 col-form-label">Kain Pelindung APAB (Cover APAB)</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                    >

                                        <select wire:model="kain_pelindung" id="kain_pelindung" class="form-select" placeholder="Select Cover APAB">
                                            <option value="">Select Cover APAB</option>
                                            <option value="Ada">Ada Pelindung</option>
                                            <option value="Tidak Ada">Tidak Ada Pelindung</option>
                                            <option value="Tidak Perlu Pelindung">Tidak Perlu Pelindung</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kain_pelindung" id="file_kain_pelindung" placeholder="Choose File" :error="'file_kain_pelindung'" />

                                        <x-inputs.texteditor wire:model="komentar_kain_pelindung" id="komentar_kain_pelindung" placeholder="Komentar Cover APAB" :error="'komentar_kain_pelindung'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kain_pelindung -->

                            <div class="row form-group">
                                <label for="kondisi_kain" class="col-lg-4 col-md-12 col-form-label">Kondisi Kain Pelindung APAB (Cover APAB)</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                    >

                                        <select wire:model="kondisi_kain" id="kondisi_kain" class="form-select" placeholder="Select Kondisi Cover APAB">
                                            <option value="">Select KondisiCover APAB</option>
                                            <option value="Perlu Penggantian">Perlu Penggantian</option>
                                            <option value="Tidak Perlu Penggantian">Tidak Perlu Penggantian</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_kain" id="file_kondisi_kain" placeholder="Choose File" :error="'file_kondisi_kain'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_kain" id="komentar_kondisi_kain" placeholder="Komentar Kondisi Cover APAB" :error="'komentar_kondisi_kain'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_kain -->

                            <div class="row form-group">
                                <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi Penempatan APAB</label>
                                <div class="col-lg-8 col-md-12">

                                    <div
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                        x-data="{ penempatan: @entangle('penempatan') }"
                                        x-init="$watch('penempatan', (value) => {
                                            $refs.kondisi_penempatan.value = '';
                                            $refs.kondisi_penempatan.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="penempatan" id="penempatan" class="form-select" placeholder="Select Penempatan">
                                            <option value="">Select Penempatan</option>
                                            <option value="Mudah Dijangkau">Mudah Dijangkau</option>
                                            <option value="Terdapat Penghalang">Terdapat Penghalang</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_penempatan'  x-show="penempatan === 'Terdapat Penghalang'" wire:model="kondisi_penempatan" id="kondisi_penempatan" class="form-select" placeholder="Select Kondisi Penempatan">
                                            <option value="">Select Konsidi Penempatan</option>
                                            <option value="Penghalang Dipindahkan">Penghalang Dipindahkan</option>
                                            <option value="tidak_dapat_Penghalang Dipindahkan">Penghalang Tidak Dapat Dipindahkan</option>
                                        </select>

                                        <x-inputs.file wire:model="file_penempatan" id="file_penempatan" placeholder="Choose File" :error="'file_penempatan'" />

                                        <x-inputs.texteditor wire:model="komentar_penempatan" id="komentar_penempatan" placeholder="Komentar Penempatan" :error="'komentar_penempatan'" />

                                    </div><!-- /.wrapper_inspeksi -->

                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group penempatan -->

                        </div><!-- /.content-form -->

                        <div class="space">
                            <hr>
                        </div>

                        <div class="footer-action mb-2 p-3">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <a href="{{ route('inspeksi-alat-k3') }}" class="btn btn-outline-secondary" >Cancel</a>
                                <button type="submit" class="btn btn-outline-warning d-flex justify-content-center align-item-center position-relative px-4">Save Draft</button>
                                <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Simpan</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-inspeksi-alat -->

</div><!-- /.inner-content -->


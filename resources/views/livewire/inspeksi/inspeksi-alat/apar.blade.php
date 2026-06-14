<div class="inner-content">

    <div class="header-content-inspeksi-alat h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - APAR</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-content-inspeksi-alat -->
    <div class="content-inspeksi-alat">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Alat K3 - APAR</h4>
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
                                <label for="id_apar" class="col-lg-4 col-md-12 col-form-label">No. ID APAR</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.select2 wire:model="id_apar" id="id_apar" class="form-select" placeholder="Select No ID APAR">
                                        <option value="">Select No ID APAR</option>
                                        <option value="id_1">ID 1</option>
                                        <option value="id_2">ID 2</option>
                                        <option value="id_3">ID 3</option>
                                        <option value="id_4">ID 4</option>
                                        <option value="id_5">ID 5</option>
                                        <option value="id_6">ID 6</option>
                                        <option value="id_7">ID 6</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group id_apar -->

                            <div class="row form-group">    
                                <label for="tanggal_service" class="col col-form-label">Tanggal Service Tabung Tertera</label>
                                <div class="col-8">
                                    <x-inputs.datepicker wire:model="tanggal_service" id="tanggal_service" placeholder="Tanggal Service Tabung Tertera" :error="'tanggal_service'" />
                                </div>
                            </div><!-- /.form-group tanggal_service -->

                            <div class="row form-group">    
                                <label for="isi_apar" class="col-lg-4 col-md-12 col-form-label">Isi APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_isi_apar d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="isi_apar" id="isi_apar" class="form-select" placeholder="Select Isi APAR">
                                            <option value="">Select Isi APAR</option>
                                            <option value="powder">Powder</option>
                                            <option value="co2">CO2</option>
                                            <option value="water">Water</option>
                                            <option value="halon">Halon</option>
                                            <option value="foam">Foam</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_isi" id="file_isi" placeholder="Choose File" :error="'file_isi'" />

                                        <x-inputs.texteditor wire:model="komentar_isi" id="komentar_isi" placeholder="Komentar Isi" :error="'komentar_isi'" />
                                        
                                    </div><!-- /.wrapper_isi_apar -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group isi_apar -->

                            <div class="row form-group">    
                                <label for="gol_apar" class="col-lg-4 col-md-12 col-form-label">Golongan APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_inspeksi d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="gol_apar" id="gol_apar" class="form-select" placeholder="Select Golongan APAR">
                                            <option value="">Select Golongan APAR</option>
                                            <option value="a">A</option>
                                            <option value="b">B</option>
                                            <option value="c">C</option>
                                            <option value="abc">A+B+C</option>
                                            <option value="na">N/A</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_gol" id="file_gol" placeholder="Choose File" :error="'file_gol'" />

                                        <x-inputs.texteditor wire:model="komentar_gol" id="komentar_gol" placeholder="Komentar Golongan APAR" :error="'komentar_gol'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group gol_apar -->

                            <div class="row form-group">    
                                <label for="kapasitas_apar" class="col-lg-4 col-md-12 col-form-label">Kapasitas APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_inspeksi d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="kapasitas_apar" id="kapasitas_apar" class="form-select" placeholder="Select Kapasitas APAR">
                                            <option value="">Select Golongan APAR</option>
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

                                        <x-inputs.texteditor wire:model="komentar_kapasitas" id="komentar_kapasitas" placeholder="Komentar Kapasitas APAR" :error="'komentar_kapasitas'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kapasitas_apar -->

                            <div class="row form-group">    
                                <label for="tuas_apar" class="col-lg-4 col-md-12 col-form-label">Tuas APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ tuas_apar: @entangle('tuas_apar') }" 
                                        x-init="$watch('tuas_apar', (value) => {
                                            $refs.kondisi_tuas_apar.value = '';
                                            $refs.kondisi_tuas_apar.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="tuas_apar" id="tuas_apar" class="form-select" placeholder="Select Tuas APAR">
                                            <option value="">Select tuas APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_tuas_apar'  x-show="tuas_apar === 'tidak_standard'" wire:model="kondisi_tuas_apar" id="kondisi_tuas_apar" class="form-select" placeholder="Select Kondisi Tuas APAR">
                                            <option value="">Select Konsidi Tuas APAR</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_tuas" id="file_tuas" placeholder="Choose File" :error="'file_tuas'" />

                                        <div class="wrapper-text-editor" x-cloak x-show="tuas_apar === 'tidak_standard'">
                                            <x-inputs.texteditor wire:model="komentar_tuas" id="komentar_tuas" placeholder="Komentar Tuas APAR" :error="'komentar_tuas'" />
                                        </div>                                        
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group tuas_apar -->

                            <div class="row form-group">    
                                <label for="handle_apar" class="col-lg-4 col-md-12 col-form-label">Handle APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ handle_apar: @entangle('handle_apar') }" 
                                        x-init="$watch('handle_apar', (value) => {
                                            $refs.kondisi_handle_apar.value = '';
                                            $refs.kondisi_handle_apar.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="handle_apar" id="handle_apar" class="form-select" placeholder="Select Handle APAR">
                                            <option value="">Select Handle APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_handle_apar'  x-show="handle_apar === 'tidak_standard'" wire:model="kondisi_handle_apar" id="kondisi_handle_apar" class="form-select" placeholder="Select Kondisi Handle APAR">
                                            <option value="">Select Konsidi Handle APAR</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_handle_apar" id="file_handle_apar" placeholder="Choose File" :error="'file_handle_apar'" />

                                        <x-inputs.texteditor wire:model="komentar_handle_apar" id="komentar_handle_apar" placeholder="Komentar Handle APAR" :error="'komentar_handle_apar'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group tuas_apar -->

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
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_pressure_gauge'  x-show="pressure_gauge === 'tidak_standard'" wire:model="kondisi_pressure_gauge" id="kondisi_pressure_gauge" class="form-select" placeholder="Select Kondisi Pressure Gauge">
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
                                <label for="pin_apar" class="col-lg-4 col-md-12 col-form-label">Pin APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ pin_apar: @entangle('pin_apar') }" 
                                        x-init="$watch('pin_apar', (value) => {
                                            $refs.kondisi_pin_apar.value = '';
                                            $refs.kondisi_pin_apar.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="pin_apar" id="pin_apar" class="form-select" placeholder="Select PIN APAR">
                                            <option value="">Select PIN APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_pin_apar'  x-show="pin_apar === 'tidak_standard'" wire:model="kondisi_pin_apar" id="kondisi_pin_apar" class="form-select" placeholder="Select Kondisi PIN APAR">
                                            <option value="">Select Konsidi PIN APAR</option>
                                            <option value="lepas">Terlepas</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_pin_apar" id="file_pin_apar" placeholder="Choose File" :error="'file_pin_apar'" />

                                        <x-inputs.texteditor wire:model="komentar_pin_apar" id="komentar_pin_apar" placeholder="Komentar PIN APAR" :error="'komentar_pin_apar'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group pin_apar -->

                            <div class="row form-group">    
                                <label for="hose_apar" class="col-lg-4 col-md-12 col-form-label">Hose APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ hose_apar: @entangle('hose_apar') }" 
                                        x-init="$watch('hose_apar', (value) => {
                                            $refs.kondisi_hose_apar.value = '';
                                            $refs.kondisi_hose_apar.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="hose_apar" id="hose_apar" class="form-select" placeholder="Select Hose APAR">
                                            <option value="">Select Hose APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_hose_apar'  x-show="hose_apar === 'tidak_standard'" wire:model="kondisi_hose_apar" id="kondisi_hose_apar" class="form-select" placeholder="Select Kondisi Hose APAR">
                                            <option value="">Select Konsidi Hose APAR</option>
                                            <option value="robek">Robek</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_hose_apar" id="file_hose_apar" placeholder="Choose File" :error="'file_hose_apar'" />

                                        <x-inputs.texteditor wire:model="komentar_hose_apar" id="komentar_hose_apar" placeholder="Komentar Hose APAR" :error="'komentar_hose_apar'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group hose_apar -->

                            <div class="row form-group">    
                                <label for="nozzle_apar" class="col-lg-4 col-md-12 col-form-label">Nozzle APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ nozzle_apar: @entangle('nozzle_apar') }" 
                                        x-init="$watch('nozzle_apar', (value) => {
                                            $refs.kondisi_nozzle_apar.value = '';
                                            $refs.kondisi_nozzle_apar.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="nozzle_apar" id="nozzle_apar" class="form-select" placeholder="Select Nozzle APAR">
                                            <option value="">Select Nozzle APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_nozzle_apar'  x-show="nozzle_apar === 'tidak_standard'" wire:model="kondisi_nozzle_apar" id="kondisi_nozzle_apar" class="form-select" placeholder="Select Kondisi Nozzle APAR">
                                            <option value="">Select Konsidi Nozzle APAR</option>
                                            <option value="buntu">Buntu</option>
                                            <option value="pecah">Pecah</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="hilang">Hilang</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_nozzle_apar" id="file_nozzle_apar" placeholder="Choose File" :error="'file_nozzle_apar'" />

                                        <x-inputs.texteditor wire:model="komentar_nozzle_apar" id="komentar_nozzle_apar" placeholder="Komentar Nozzle APAR" :error="'komentar_nozzle_apar'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group nozzle_apar -->

                            <div class="row form-group">    
                                <label for="kondisi_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi tabung/cylinder APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ kondisi_tabung: @entangle('kondisi_tabung') }" 
                                        x-init="$watch('kondisi_tabung', (value) => {
                                            $refs.kondisi_kondisi_tabung.value = '';
                                            $refs.kondisi_kondisi_tabung.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="kondisi_tabung" id="kondisi_tabung" class="form-select" placeholder="Select Kondisi tabung/cylinder APAR">
                                            <option value="">Select Kondisi tabung/cylinder APAR</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_kondisi_tabung'  x-show="kondisi_tabung === 'tidak_standard'" wire:model="kondisi_kondisi_tabung" id="kondisi_kondisi_tabung" class="form-select" placeholder="Select Kondisi tabung/cylin">
                                            <option value="">Select Konsidi Kondisi tabung/cylinder APAR</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="penyok">Penyok</option>
                                            <option value="rusak">Rusak</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_tabung" id="file_kondisi_tabung" placeholder="Choose File" :error="'file_kondisi_tabung'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_tabung" id="komentar_kondisi_tabung" placeholder="Komentar Kondisi tabung/cylinder APAR" :error="'komentar_kondisi_tabung'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_tabung -->

                            <div class="row form-group">    
                                <label for="cat_tabung" class="col-lg-4 col-md-12 col-form-label">Kondisi Cat Tabung APAR</label>
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
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_cat_tabung'  x-show="cat_tabung === 'tidak_standard'" wire:model="kondisi_cat_tabung" id="kondisi_cat_tabung" class="form-select" placeholder="Select Kondisi Cat Tabung">
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
                                <label for="powder" class="col-lg-4 col-md-12 col-form-label">Kondisi Powder APAR</label>
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
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_powder'  x-show="powder === 'tidak_standard'" wire:model="kondisi_powder" id="kondisi_powder" class="form-select" placeholder="Select Kondisi Powder">
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
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_kip'  x-show="kip === 'tidak_standard'" wire:model="kondisi_kip" id="kondisi_kip" class="form-select" placeholder="Select Kondisi KIP">
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
                                <label for="bracket" class="col-lg-4 col-md-12 col-form-label">Bracket APAR</label>
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
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_bracket'  x-show="bracket === 'tidak_standard'" wire:model="kondisi_bracket" id="kondisi_bracket" class="form-select" placeholder="Select Kondisi Bracket">
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
                                <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label Penanda Lokasi APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="label_penanda" id="label_penanda" class="form-select" placeholder="Select Label Penanda">
                                            <option value="">Select Label Penanda</option>
                                            <option value="ada">Ada</option>
                                            <option value="tidak_ada">Tidak Ada</option>
                                        </select>

                                        <x-inputs.file wire:model="file_label_penanda" id="file_label_penanda" placeholder="Choose File" :error="'file_label_penanda'" />

                                        <x-inputs.texteditor wire:model="komentar_label_penanda" id="komentar_label_penanda" placeholder="Komentar Label Penanda" :error="'komentar_label_penanda'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group label_penanda -->

                            <div class="row form-group">    
                                <label for="demarkasi" class="col-lg-4 col-md-12 col-form-label">Demarkasi APAR</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="demarkasi" id="demarkasi" class="form-select" placeholder="Select Demarkasi APAR">
                                            <option value="">Select Demarkasi APAR</option>
                                            <option value="ada">Ada Demarkasi</option>
                                            <option value="pudar">Warna Demarkasi Pudar</option>
                                            <option value="tidak_ada">Tidak Ada Demarkasi</option>
                                        </select>

                                        <x-inputs.file wire:model="file_demarkasi" id="file_demarkasi" placeholder="Choose File" :error="'file_demarkasi'" />

                                        <x-inputs.texteditor wire:model="komentar_demarkasi" id="komentar_demarkasi" placeholder="Komentar Demarkasi APAR" :error="'komentar_demarkasi'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group demarkasi -->

                            <div class="row form-group">    
                                <label for="kain_pelindung" class="col-lg-4 col-md-12 col-form-label">Kain Pelindung APAR (Cover APAR)</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="kain_pelindung" id="kain_pelindung" class="form-select" placeholder="Select Cover APAR">
                                            <option value="">Select Cover APAR</option>
                                            <option value="ada">Ada Pelindung</option>
                                            <option value="tidak_ada">Tidak Ada Pelindung</option>
                                            <option value="tidak_perlu">Tidak Perlu Pelindung</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kain_pelindung" id="file_kain_pelindung" placeholder="Choose File" :error="'file_kain_pelindung'" />

                                        <x-inputs.texteditor wire:model="komentar_kain_pelindung" id="komentar_kain_pelindung" placeholder="Komentar Cover APAR" :error="'komentar_kain_pelindung'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kain_pelindung -->

                            <div class="row form-group">    
                                <label for="kondisi_kain" class="col-lg-4 col-md-12 col-form-label">Kondisi Kain Pelindung APAR (Cover APAR)</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="kondisi_kain" id="kondisi_kain" class="form-select" placeholder="Select Kondisi Cover APAR">
                                            <option value="">Select KondisiCover APAR</option>
                                            <option value="ganti">Perlu Penggantian</option>
                                            <option value="tidak_perlu_ganti">Tidak Perlu Penggantian</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_kain" id="file_kondisi_kain" placeholder="Choose File" :error="'file_kondisi_kain'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_kain" id="komentar_kondisi_kain" placeholder="Komentar Kondisi Cover APAR" :error="'komentar_kondisi_kain'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_kain -->

                            <div class="row form-group">    
                                <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi Penempatan APAR</label>
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
                                            <option value="mudah_dijangkau">Mudah Dijangkau</option>
                                            <option value="ada_penghalang">Terdapat Penghalang</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_penempatan'  x-show="penempatan === 'ada_penghalang'" wire:model="kondisi_penempatan" id="kondisi_penempatan" class="form-select" placeholder="Select Kondisi Penempatan">
                                            <option value="">Select Konsidi Penempatan</option>
                                            <option value="dipindahkan">Penghalang Dipindahkan</option>
                                            <option value="tidak_dapat_dipindahkan">Penghalang Tidak Dapat Dipindahkan</option>
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

<div class="inner-content">

    <div class="header-content-inspeksi-alat h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - Hose Rail</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-content-inspeksi-alat -->
    <div class="content-inspeksi-alat">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Alat K3 - Hose Rail</h4>
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
                                <label for="id_hose_rail" class="col-lg-4 col-md-12 col-form-label">No. ID Hose Rail</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.select2 wire:model="id_hose_rail" id="id_hose_rail" class="form-select" placeholder="Select No ID Hose Rail">
                                        <option value="">Select No ID Hose Rail</option>
                                        <option value="id_1">ID 1</option>
                                        <option value="id_2">ID 2</option>
                                        <option value="id_3">ID 3</option>
                                        <option value="id_4">ID 4</option>
                                        <option value="id_5">ID 5</option>
                                        <option value="id_6">ID 6</option>
                                        <option value="id_7">ID 6</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group id_hose_rail -->


                            <div class="row form-group">    
                                <label for="type_hose_rail" class="col-lg-4 col-md-12 col-form-label">Isi Hose Rail</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_type_hose_rail d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="type_hose_rail" id="type_hose_rail" class="form-select" placeholder="Select Isi Hose Rail">
                                            <option value="">Select Isi Hose Rail</option>
                                            <option value="john_morish">John Morish</option>
                                            <option value="machino">Machino</option>
                                            <option value="storz">Storz</option>
                                            <option value="lainnya">Tipe Lainnya</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_type_hose_rail" id="file_type_hose_rail" placeholder="Choose File" :error="'file_type_hose_rail'" />

                                        <x-inputs.texteditor wire:model="komentar_type_hose_rail" id="komentar_type_hose_rail" placeholder="Komentar Type Hose Rail" :error="'komentar_type_hose_rail'" />
                                        
                                    </div><!-- /.wrapper_type_hose_rail -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group type_hose_rail -->


                            <div class="row form-group">    
                                <label for="ukuran_coupling" class="col-lg-4 col-md-12 col-form-label">Ukuran Coupling</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_coupling: @entangle('versi_coupling') }" 
                                        x-init="$watch('versi_coupling', (value) => {
                                            $refs.kondisi_ukuran_coupling.value = '';
                                            $refs.kondisi_ukuran_coupling.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="ukuran_coupling" id="ukuran_coupling" class="form-select" placeholder="Select Ukuran Coupling">
                                            <option value="">Select ukuran Coupling</option>
                                            <option value="1,5">1,5 Inch</option>
                                            <option value="2,5">2,5 Inch</option>
                                        </select>

                                        <select wire:model="versi_coupling" id="versi_coupling" class="form-select" placeholder="Select Versi Coupling">
                                            <option value="">Select Versi Coupling</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select x-cloak x-ref='kondisi_ukuran_coupling'  x-show="versi_coupling === 'tidak_standard'" wire:model="kondisi_ukuran_coupling" id="kondisi_ukuran_coupling" class="form-select" placeholder="Select Kondisi Ukuran Coupling">
                                            <option value="">Select Konsidi Ukuran Coupling</option>
                                            <option value="pecah">Pecah, Penutup Hilang, Lainnya</option>
                                            <option value="penutup_hilang">Penutup Hilang</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_ukuran_coupling" id="file_ukuran_coupling" placeholder="Choose File" :error="'file_ukuran_coupling'" />

                                        <x-inputs.texteditor wire:model="komentar_ukuran_coupling" id="komentar_ukuran_coupling" placeholder="Komentar Ukuran Coupling" :error="'komentar_ukuran_coupling'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group ukuran_coupling -->

                            <div class="row form-group">    
                                <label for="outer_pilar" class="col-lg-4 col-md-12 col-form-label">Jumlah Outer Pilar</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="outer_pilar" id="outer_pilar" class="form-select" placeholder="Select Outer Pilar">
                                            <option value="">Select Outer Pilar</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>

                                        <x-inputs.file wire:model="file_outer_pilar" id="file_outer_pilar" placeholder="Choose File" :error="'file_outer_pilar'" />

                                        <x-inputs.texteditor wire:model="komentar_outer_pilar" id="komentar_outer_pilar" placeholder="Komentar Outer Pilar" :error="'komentar_outer_pilar'" />

                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group outer_pilar -->

                            <div class="row form-group">    
                                <label for="jenis_hose_rail" class="col-lg-4 col-md-12 col-form-label">Jenis Hose Rail</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_hose: @entangle('versi_hose') }" 
                                        x-init="$watch('versi_hose', (value) => {
                                            $refs.kondisi_jenis_hose_rail.value = '';
                                            $refs.kondisi_jenis_hose_rail.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="jenis_hose_rail" id="jenis_hose_rail" class="form-select" placeholder="Select Hose Hose Rail">
                                            <option value="">Select Hose Hose Rail</option>
                                            <option value="rubber">Rubber</option>
                                            <option value="canvas">Canvas</option>
                                        </select>

                                        <select wire:model="versi_hose" id="versi_hose" class="form-select" placeholder="Select Hose Hose Rail">
                                            <option value="">Select Hose Hose Rail</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_jenis_hose_rail'  x-show="versi_hose === 'tidak_standard'" wire:model="kondisi_jenis_hose_rail" id="kondisi_jenis_hose_rail" class="form-select" placeholder="Select Kondisi Hose Hose Rail">
                                            <option value="">Select Konsidi Hose Hose Rail</option>
                                            <option value="robek">Hose Robek</option>
                                            <option value="ujung_pecah">Coupling Diujung Pecah</option>
                                            <option value="seal_rusak">Seal Dalam Coupling Hose Rusak / Hilang</option>
                                            <option value="tidak_proper">Saat Dipasang ke Pilar Tidak Proper</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_jenis_hose_rail" id="file_jenis_hose_rail" placeholder="Choose File" :error="'file_jenis_hose_rail'" />

                                        <x-inputs.texteditor wire:model="komentar_jenis_hose_rail" id="komentar_jenis_hose_rail" placeholder="Komentar Hose Hose Rail" :error="'komentar_jenis_hose_rail'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group jenis_hose_rail -->

                            <div class="row form-group">    
                                <label for="ukuran_hose" class="col-lg-4 col-md-12 col-form-label">Ukuran Hose</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="ukuran_hose" id="ukuran_hose" class="form-select" placeholder="Select Ukuran Hose">
                                            <option value="">Select Ukuran Hose</option>
                                            <option value="1,5">1,5 Inch</option>
                                            <option value="2,5">2,5 Inch</option>
                                        </select>

                                        <x-inputs.file wire:model="file_ukuran_hose" id="file_ukuran_hose" placeholder="Choose File" :error="'file_ukuran_hose'" />

                                        <x-inputs.texteditor wire:model="komentar_ukuran_hose" id="komentar_ukuran_hose" placeholder="Komentar Ukuran Hose" :error="'komentar_ukuran_hose'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group ukuran_hose -->

                            <div class="row form-group">    
                                <label for="type_nozzle" class="col-lg-4 col-md-12 col-form-label">Type Nozzle</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_nozzle: @entangle('versi_nozzle') }" 
                                        x-init="$watch('versi_nozzle', (value) => {
                                            $refs.kondisi_type_nozzle.value = '';
                                            $refs.kondisi_type_nozzle.dispatchEvent(new Event('change'));
                                        })"
                                    >
                                        <select wire:model="type_nozzle" id="type_nozzle" class="form-select" placeholder="Select Type Nozzle">
                                            <option value="">Select Type Nozzle</option>
                                            <option value="hose_rail_straight">Hose Rail Straight Nozzle</option>
                                            <option value="variable_head_spray">Tidak Variable Head Spray</option>
                                            <option value="gun_nozzle">Gun Nozzle</option>
                                            <option value="jenis_lainnya">Jenis Lainnya</option>
                                        </select>

                                        <select wire:model="versi_nozzle" id="versi_nozzle" class="form-select" placeholder="Select Versi Nozzle">
                                            <option value="">Select Versi Nozzle</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_type_nozzle'  x-show="versi_nozzle === 'tidak_standard'" wire:model="kondisi_type_nozzle" id="kondisi_type_nozzle" class="form-select" placeholder="Select Kondisi Nozzle Hose Rail">
                                            <option value="">Select Konsidi Nozzle Hose Rail</option>
                                            <option value="rusak">Kondisi Fisik Rusak</option>
                                            <option value="tidak_tersambung">Tidak Dapat Tersambung Dengan Hose</option>
                                            <option value="tersumbat">Tersumbat</option>
                                            <option value="hilang">Hilang</option>
                                        </select>

                                        <x-inputs.file wire:model="file_type_nozzle" id="file_type_nozzle" placeholder="Choose File" :error="'file_type_nozzle'" />

                                        <x-inputs.texteditor wire:model="komentar_type_nozzle" id="komentar_type_nozzle" placeholder="Komentar Type Nozzle" :error="'komentar_type_nozzle'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group type_nozzle -->

                            <div class="row form-group">    
                                <label for="box_hose_rail" class="col-lg-4 col-md-12 col-form-label">Box Hose Rail</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ box_hose_rail: @entangle('box_hose_rail') }" 
                                        x-init="$watch('box_hose_rail', (value) => {
                                            $refs.kondisi_box_hose_rail.value = '';
                                            $refs.kondisi_box_hose_rail.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="box_hose_rail" id="box_hose_rail" class="form-select" placeholder="Select Box Hose Rail">
                                            <option value="">Select Box Hose Rail</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_box_hose_rail'  x-show="box_hose_rail === 'tidak_standard'" wire:model="kondisi_box_hose_rail" id="kondisi_box_hose_rail" class="form-select" placeholder="Select Kondisi Box Hose Rail">
                                            <option value="">Select Konsidi Box Hose Rail</option>
                                            <option value="pudar">Cat Pudar</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="penyok">Penyok</option>
                                        </select>

                                        <x-inputs.file wire:model="file_box_hose_rail" id="file_box_hose_rail" placeholder="Choose File" :error="'file_box_hose_rail'" />

                                        <x-inputs.texteditor wire:model="komentar_box_hose_rail" id="komentar_box_hose_rail" placeholder="Komentar Box Hose Rail" :error="'komentar_box_hose_rail'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group box_hose_rail -->

                            <div class="row form-group">    
                                <label for="penempatan" class="col-lg-4 col-md-12 col-form-label">Kondisi Penempatan Hose Rail</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="penempatan" id="penempatan" class="form-select" placeholder="Select Penempatan">
                                            <option value="">Select Penempatan</option>
                                            <option value="mudah_dijangkau">Mudah Dijangkau</option>
                                            <option value="ada_penghalang">Terdapat Penghalang</option>
                                        </select>                                        

                                        <x-inputs.file wire:model="file_penempatan" id="file_penempatan" placeholder="Choose File" :error="'file_penempatan'" />

                                        <x-inputs.texteditor wire:model="komentar_penempatan" id="komentar_penempatan" placeholder="Komentar Penempatan" :error="'komentar_penempatan'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group penempatan -->

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
                                            <option value="hilang">KIP Hilang</option>
                                            <option value="rusak">KIP Rusak</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kip" id="file_kip" placeholder="Choose File" :error="'file_kip'" />

                                        <x-inputs.texteditor wire:model="komentar_kip" id="komentar_kip" placeholder="Komentar KIP" :error="'komentar_kip'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kip -->

                            <div class="row form-group">    
                                <label for="label_penanda" class="col-lg-4 col-md-12 col-form-label">Label Penanda Lokasi Hose Rail</label>
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
                                <label for="demarkasi" class="col-lg-4 col-md-12 col-form-label">Demarkasi Hose Rail</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                    >

                                        <select wire:model="demarkasi" id="demarkasi" class="form-select" placeholder="Select Demarkasi Hose Rail">
                                            <option value="">Select Demarkasi Hose Rail</option>
                                            <option value="ada">Ada Demarkasi</option>
                                            <option value="pudar">Warna Demarkasi Pudar</option>
                                            <option value="tidak_ada">Tidak Ada Demarkasi</option>
                                        </select>

                                        <x-inputs.file wire:model="file_demarkasi" id="file_demarkasi" placeholder="Choose File" :error="'file_demarkasi'" />

                                        <x-inputs.texteditor wire:model="komentar_demarkasi" id="komentar_demarkasi" placeholder="Komentar Demarkasi Hose Rail" :error="'komentar_demarkasi'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group demarkasi -->

                            <div class="row form-group">    
                                <label for="velve_pipa" class="col-lg-4 col-md-12 col-form-label">Kondisi Valve Pipa Air</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ velve_pipa: @entangle('velve_pipa') }" 
                                        x-init="$watch('velve_pipa', (value) => {
                                            $refs.kondisi_velve_pipa.value = '';
                                            $refs.kondisi_velve_pipa.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="velve_pipa" id="velve_pipa" class="form-select" placeholder="Select Velve Pipa">
                                            <option value="">Select Velve Pipa</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_velve_pipa'  x-show="velve_pipa === 'tidak_standard'" wire:model="kondisi_velve_pipa" id="kondisi_velve_pipa" class="form-select" placeholder="Select Kondisi Velve Pipa">
                                            <option value="">Select Konsidi Velve Pipa</option>
                                            <option value="bocor">Bocor</option>
                                            <option value="berkarat">Berkarat</option>
                                            <option value="patah">Patah</option>
                                        </select>

                                        <x-inputs.file wire:model="file_velve_pipa" id="file_velve_pipa" placeholder="Choose File" :error="'file_velve_pipa'" />

                                        <x-inputs.texteditor wire:model="komentar_velve_pipa" id="komentar_velve_pipa" placeholder="Komentar Velve Pipa" :error="'komentar_velve_pipa'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group velve_pipa -->

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

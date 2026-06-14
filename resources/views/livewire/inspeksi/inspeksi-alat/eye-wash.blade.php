<div class="inner-content">

    <div class="header-content-inspeksi-alat h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Alat K3 - Eye Wash</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-content-inspeksi-alat -->
    <div class="content-inspeksi-alat">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Alat K3 - Eye Wash</h4>
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
                                <label for="id_eye_wash" class="col-lg-4 col-md-12 col-form-label">No. ID Eye Wash</label>
                                <div class="col-lg-8 col-md-12">
                                    <x-inputs.select2 wire:model="id_eye_wash" id="id_eye_wash" class="form-select" placeholder="Select No ID Eye Wash">
                                        <option value="">Select No ID Eye Wash</option>
                                        <option value="id_1">ID 1</option>
                                        <option value="id_2">ID 2</option>
                                        <option value="id_3">ID 3</option>
                                        <option value="id_4">ID 4</option>
                                        <option value="id_5">ID 5</option>
                                        <option value="id_6">ID 6</option>
                                        <option value="id_7">ID 6</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group id_eye_wash -->

                            <div class="row form-group">    
                                <label for="merk_eye_wash" class="col-lg-4 col-md-12 col-form-label">Merk Eye Wash</label>
                                <div class="col-lg-8 col-md-12">

                                    <div class="wrapper_merk_eye_wash d-flex flex-column gap-3">

                                        <x-inputs.select2 wire:model="merk_eye_wash" id="merk_eye_wash" class="form-select" placeholder="Select Merk Eye Wash">
                                            <option value="">Select Merk Eye Wash</option>
                                            <option value="sperian">Sperian</option>
                                            <option value="haws">Haws</option>
                                            <option value="honeywell">Honeywell</option>
                                            <option value="krisbow">krisbow</option>
                                            <option value="lainnya">Tipe Lainnya</option>
                                        </x-inputs.select2>

                                        <x-inputs.file wire:model="file_merk_eye_wash" id="file_merk_eye_wash" placeholder="Choose File" :error="'file_merk_eye_wash'" />

                                        <x-inputs.texteditor wire:model="komentar_merk_eye_wash" id="komentar_merk_eye_wash" placeholder="Komentar Merk Eye Wash" :error="'komentar_merk_eye_wash'" />
                                        
                                    </div><!-- /.wrapper_merk_eye_wash -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group merk_eye_wash -->


                            <div class="row form-group">    
                                <label for="type_eye_wash" class="col-lg-4 col-md-12 col-form-label">Tipe Eye Wash</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3"
                                    >

                                        <select wire:model="type_eye_wash" id="type_eye_wash" class="form-select" placeholder="Select Type Eye Wash">
                                            <option value="">Select Type Eye Wash</option>
                                            <option value="permanen">Permanen</option>
                                            <option value="portable">Portable</option>
                                        </select>

                                        <x-inputs.file wire:model="file_type_eye_wash" id="file_type_eye_wash" placeholder="Choose File" :error="'file_type_eye_wash'" />

                                        <x-inputs.texteditor wire:model="komentar_type_eye_wash" id="komentar_type_eye_wash" placeholder="Komentar Type Eye Wash" :error="'komentar_type_eye_wash'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group type_eye_wash -->

                            <div class="row form-group">    
                                <label for="kondisi_tangki" class="col-lg-4 col-md-12 col-form-label">Kondisi Tangki</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_tangki: @entangle('versi_tangki') }" 
                                        x-init="$watch('versi_tangki', (value) => {
                                            $refs.kondisi_tangki.value = '';
                                            $refs.kondisi_tangki.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="versi_tangki" id="versi_tangki" class="form-select" placeholder="Select Versi Tangki">
                                            <option value="">Select versi Tangki</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_tangki'  x-show="versi_tangki === 'tidak_standard'" wire:model="kondisi_tangki" id="kondisi_tangki" class="form-select" placeholder="Select Kondisi Tangki">
                                            <option value="">Select Konsidi Tangki</option>
                                            <option value="pecah">Pecah</option>
                                            <option value="penutup_hilang">Penutup Hilang</option>
                                            <option value="rusak_lainnya">Rusak Lainnya</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_tangki" id="file_kondisi_tangki" placeholder="Choose File" :error="'file_kondisi_tangki'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_tangki" id="komentar_kondisi_tangki" placeholder="Komentar Kondisi Tangki" :error="'komentar_kondisi_tangki'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_tangki -->

                            <div class="row form-group">    
                                <label for="kondisi_air" class="col-lg-4 col-md-12 col-form-label">Kondisi Air Didalam Tangki</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_air: @entangle('versi_air') }" 
                                        x-init="$watch('versi_air', (value) => {
                                            $refs.kondisi_air.value = '';
                                            $refs.kondisi_air.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="versi_air" id="versi_air" class="form-select" placeholder="Select Versi Air">
                                            <option value="">Select Versi Air</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_air'  x-show="versi_air === 'tidak_standard'" wire:model="kondisi_air" id="kondisi_air" class="form-select" placeholder="Select Kondisi Air">
                                            <option value="">Select Konsidi Air</option>
                                            <option value="keruh">Keruh</option>
                                            <option value="bau">Bau</option>
                                            <option value="kurang">Kurang</option>
                                            <option value="habis">Habis / Kosong</option>
                                        </select>

                                        <x-inputs.file wire:model="file_kondisi_air" id="file_kondisi_air" placeholder="Choose File" :error="'file_kondisi_air'" />

                                        <x-inputs.texteditor wire:model="komentar_kondisi_air" id="komentar_kondisi_air" placeholder="Komentar Kondisi Air" :error="'komentar_kondisi_air'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group kondisi_air -->

                            <div class="row form-group">    
                                <label for="pancuran_air" class="col-lg-4 col-md-12 col-form-label">Pancuran Air</label>
                                <div class="col-lg-8 col-md-12">

                                    <div 
                                        class="wrapper_inspeksi d-flex flex-column gap-3" 
                                        x-data="{ versi_pancuran_air: @entangle('versi_pancuran_air') }" 
                                        x-init="$watch('versi_pancuran_air', (value) => {
                                            $refs.kondisi_pancuran_air.value = '';
                                            $refs.kondisi_pancuran_air.dispatchEvent(new Event('change'));
                                        })"
                                    >

                                        <select wire:model="versi_pancuran_air" id="versi_pancuran_air" class="form-select" placeholder="Select Versi Pancuran Air">
                                            <option value="">Select Versi Pancuran Air</option>
                                            <option value="standard">Standard</option>
                                            <option value="tidak_standard">Tidak Standard</option>
                                        </select>

                                        <select  x-cloak x-ref='kondisi_pancuran_air'  x-show="versi_pancuran_air === 'tidak_standard'" wire:model="kondisi_pancuran_air" id="kondisi_pancuran_air" class="form-select" placeholder="Select Kondisi Pancuran Air">
                                            <option value="">Select Konsidi Pancuran Air</option>
                                            <option value="tersumbat">Tersumbat</option>
                                        </select>

                                        <x-inputs.file wire:model="file_pancuran_air" id="file_pancuran_air" placeholder="Choose File" :error="'file_pancuran_air'" />

                                        <x-inputs.texteditor wire:model="komentar_pancuran_air" id="komentar_pancuran_air" placeholder="Komentar Pancuran Air" :error="'komentar_pancuran_air'" />
                                        
                                    </div><!-- /.wrapper_inspeksi -->
                                    
                                </div><!-- /.col-lg-12 -->

                            </div><!-- /.form-group pancuran_air -->                            

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
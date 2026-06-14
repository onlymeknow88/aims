<div class="inner-content">

    <div class="header-formulir h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Formulir Rencana Audit</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->
        
    </div><!-- /.header-formulir -->

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-sm-12">

                <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                    <div class="title-form text-center">
                        <h4>RENCANA AUDIT</h4>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <div class="row form-group">    
                            <label for="jenis_audit" class="col col-form-label">Jenis Audit</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jenis_audit" id="jenis_audit" placeholder="Jenis Audit" :error="'jenis_audit'" />
                            </div>
                        </div><!-- /.form-group jenis_audit -->

                        <div class="row form-group">    
                            <label for="kriteria_audit" class="col col-form-label">Kriteria Audit</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="kriteria_audit" id="kriteria_audit" placeholder="Kriteria Audit" :error="'kriteria_audit'" />  
                            </div>
                        </div><!-- /.form-group kriteria_audit -->

                        <div class="row form-group">    
                            <label for="nama_perusahaan" class="col col-form-label">Nama Perusahaan</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_perusahaan" id="nama_perusahaan" placeholder="Nama Perusahaan" :error="'nama_perusahaan'" />
                            </div>
                        </div><!-- /.form-group nama_perusahaan -->

                        <div class="row form-group">    
                            <label for="alamat" class="col col-form-label">Alamat</label>
                            <div class="col-8">
                                <x-inputs.textarea rows="5" wire:model="alamat" id="alamat" placeholder="Alamat" :error="'alamat'" />
                            </div>
                        </div><!-- /.form-group alamat -->

                        <div class="row form-group">    
                            <label for="tanggal_audit" class="col col-form-label">Tanggal Pelaksanaan Audit</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_audit" id="tanggal_audit" :error="'tanggal_audit'" />
                            </div>
                        </div><!-- /.form-group tanggal_audit -->

                        <div class="row form-group">    
                            <label for="tujuan_audit" class="col col-form-label">Tujuan Audit</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="tujuan_audit" id="tujuan_audit" placeholder="Tujuan Audit" :error="'tujuan_audit'" />  
                            </div>
                        </div><!-- /.form-group tujuan_audit -->

                        <div class="row form-group">    
                            <label for="ruang_lingkup" class="col col-form-label">Ruang Lingkup Audit</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="ruang_lingkup" id="ruang_lingkup" placeholder="Ruang Lingkup Audit" :error="'ruang_lingkup'" />  
                            </div>
                        </div><!-- /.form-group ruang_lingkup -->

                        <div class="row form-group">    
                            <label for="pengecualian" class="col col-form-label">Pengecualian</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="pengecualian" id="pengecualian" placeholder="Pengecualian" :error="'pengecualian'" />  
                            </div>
                        </div><!-- /.form-group pengecualian -->

                        <div class="row form-group">    
                            <label for="tim_audit" class="col col-form-label">Tim Audit</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="tim_audit" id="tim_audit" placeholder="Tim Audit" :error="'tim_audit'" />  
                            </div>
                        </div><!-- /.form-group tim_audit -->

                        <div class="row form-group">    
                            <label for="doc_relevan" class="col col-form-label">Dokumentasi Relevan</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="doc_relevan" id="doc_relevan" placeholder="Dokumentasi Relevan" :error="'doc_relevan'" />  
                            </div>
                        </div><!-- /.form-group doc_relevan -->

                        <div class="row form-group">    
                            <label for="fasilitas" class="col col-form-label">Fasilitas</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="fasilitas" id="fasilitas" placeholder="Fasilitas" :error="'fasilitas'" />  
                            </div>
                        </div><!-- /.form-group fasilitas -->

                        <div class="row form-group">    
                            <label for="distribusi_laporan" class="col col-form-label">Distribusi Laporan</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="distribusi_laporan" id="distribusi_laporan" placeholder="Distriusi Laporan" :error="'distribusi_laporan'" />  
                            </div>
                        </div><!-- /.form-group distribusi_laporan -->

                    </div><!-- /.content-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Perhitungan Hari Kerja Audit dan Jumlah Auditor</h6>

                        <hr>

                        <div class="row form-group">    
                            <label for="jml_pekerja" class="col-4 col-form-label">Jumlah Pekerja Auditi</label>
                            <div class="col-4">
                                <x-inputs.text wire:model="jml_pekerja" id="jml_pekerja" placeholder="Jumlah Pekerja Auditi" :error="'jml_pekerja'" />
                            </div>
                        </div><!-- /.form-group jml_pekerja -->

                        <div class="row form-group">    
                            <label for="kelas_resiko" class="col-4 col-form-label">Kelas Resiko</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="kelas_resiko" id="kelas_resiko" placeholder="Kelas Resiko" :error="'kelas_resiko'" />
                            </div>
                        </div><!-- /.form-group kelas_resiko -->

                        <div class="row form-group">    
                            <label for="mandays" class="col-4 col-form-label">Mandays</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="mandays" id="mandays" placeholder="Mandays" :error="'mandays'" />
                            </div>
                        </div><!-- /.form-group mandays -->

                        <div class="row form-group">    
                            <label for="f_penyesuaian" class="col-4 col-form-label">Faktor Penyesuaian</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="f_penyesuaian" id="f_penyesuaian" placeholder="Faktor Penyesuaian" :error="'f_penyesuaian'" />
                            </div>
                        </div><!-- /.form-group f_penyesuaian -->

                        <div class="row form-group">    
                            <label for="t_mandays" class="col-4 col-form-label">Total Mandays</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="t_mandays" id="t_mandays" placeholder="Total Mandays" :error="'t_mandays'" />
                            </div>
                        </div><!-- /.form-group t_mandays -->

                        <div class="row form-group">    
                            <label for="alokasi_mandays_tahap_1" class="col-4 col-form-label">Alokasi Mandays untuk Tahap I Audit (Maksimal 10% dari Total)</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="alokasi_mandays_tahap_1" id="alokasi_mandays_tahap_1" placeholder="Alokasi Mandays untuk Tahap I Audit (Maksimal 10% dari Total)" :error="'alokasi_mandays_tahap_1'" />
                            </div>
                        </div><!-- /.form-group alokasi_mandays_tahap_1 -->

                        <div class="row form-group">    
                            <label for="alokasi_mandays_tahap_2" class="col-4 col-form-label">Alokasi Mandays untuk Tahap II Audit (Maksimal 10% dari Total)</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="alokasi_mandays_tahap_2" id="alokasi_mandays_tahap_2" placeholder="Alokasi Mandays untuk Tahap I Audit (Maksimal 90% dari Total)" :error="'alokasi_mandays_tahap_2'" />
                            </div>
                        </div><!-- /.form-group alokasi_mandays_tahap_2 -->

                    </div><!-- /.content-form-2 -->

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Data Kinerja Keselamatan Pertambangan pada Periode Audit</h6>

                        <hr>

                        <div class="row form-group">    
                            <label for="jml_kecelakaan_ringan" class="col-4 col-form-label">Jumlah Kecelakaan Tambang Berakibat Cidera Ringan</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jml_kecelakaan_ringan" id="jml_kecelakaan_ringan" placeholder="Jumlah Kecelakaan Tambang Ringan" :error="'jml_kecelakaan_ringan'" />
                            </div>
                        </div><!-- /.form-group jml_kecelakaan_ringan -->

                        <div class="row form-group">    
                            <label for="jml_kecelakaan_berat" class="col-4 col-form-label">Jumlah Kecelakaan Tambang Berakibat Cidera Berat</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jml_kecelakaan_berat" id="jml_kecelakaan_berat" placeholder="Jumlah Kecelakaan Tambang Berat" :error="'jml_kecelakaan_berat'" />
                            </div>
                        </div><!-- /.form-group jml_kecelakaan_berat -->

                        <div class="row form-group">    
                            <label for="jml_kecelakaan_mati" class="col-4 col-form-label">Jumlah Kecelakaan Tambang Berakibat Mati</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jml_kecelakaan_mati" id="jml_kecelakaan_mati" placeholder="Jumlah Kecelakaan Tambang Mati" :error="'jml_kecelakaan_mati'" />
                            </div>
                        </div><!-- /.form-group jml_kecelakaan_mati -->

                        <div class="row form-group">    
                            <label for="rate_kecelakaan_tambang" class="col-4 col-form-label">Frequency Rate Kecelakaan Tambang</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="rate_kecelakaan_tambang" id="rate_kecelakaan_tambang" placeholder="Frequency Rate Kecelakaan Tambang" :error="'rate_kecelakaan_tambang'" />
                            </div>
                        </div><!-- /.form-group rate_kecelakaan_tambang -->

                        <div class="row form-group">    
                            <label for="severity_rate" class="col-4 col-form-label">Severity Rate Kecelakaan Tambang</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="severity_rate" id="severity_rate" placeholder="Severity Rate Kecelakaan Tambang" :error="'severity_rate'" />
                            </div>
                        </div><!-- /.form-group severity_rate -->

                        <div class="row form-group">    
                            <label for="jml_kejadian_berbahaya" class="col-4 col-form-label">Jumlah Kejadian Berbahaya</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jml_kejadian_berbahaya" id="jml_kejadian_berbahaya" placeholder="Jumlah Kejadian Berbahaya" :error="'jml_kejadian_berbahaya'" />
                            </div>
                        </div><!-- /.form-group jml_kejadian_berbahaya -->

                        <div class="row form-group">    
                            <label for="absence_severity_rate" class="col-4 col-form-label">Absence Severity Rate</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="absence_severity_rate" id="absence_severity_rate" placeholder="Absence Severity Rate" :error="'absence_severity_rate'" />
                            </div>
                        </div><!-- /.form-group absence_severity_rate -->

                        <div class="row form-group">    
                            <label for="morbidity_frequency_rate" class="col-4 col-form-label">Morbidity Frequency Rate</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="morbidity_frequency_rate" id="morbidity_frequency_rate" placeholder="Morbidity Frequency Rate" :error="'morbidity_frequency_rate'" />
                            </div>
                        </div><!-- /.form-group morbidity_frequency_rate -->

                        <div class="row form-group">    
                            <label for="jml_kejadian_akibat_penyakit" class="col-4 col-form-label">Jumlah Kejadian Akibat Penyakit Tenaga Kerja</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="jml_kejadian_akibat_penyakit" id="jml_kejadian_akibat_penyakit" placeholder="Jumlah Kejadian Akibat Penyakit Tenaga Kerja" :error="'jml_kejadian_akibat_penyakit'" />
                            </div>
                        </div><!-- /.form-group jml_kejadian_akibat_penyakit -->

                        <div class="row form-group">    
                            <label for="frekuensi_penyakit_akibat_kerja" class="col-4 col-form-label">Frekuensi Penyakit Akibat Kerja</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="frekuensi_penyakit_akibat_kerja" id="frekuensi_penyakit_akibat_kerja" placeholder="Frekuensi Penyakit Akibat Kerja" :error="'frekuensi_penyakit_akibat_kerja'" />
                            </div>
                        </div><!-- /.form-group frekuensi_penyakit_akibat_kerja -->

                    </div><!-- /.content-form-3 -->

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('audit') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Simpan</button>                   
                        </div>
                    </div>

                </form><!-- /.form -->

            </div><!-- ./col-sm-8 -->
        </div><!-- /.row -->
    </div><!--/.container-->

</div><!--innner-content-->
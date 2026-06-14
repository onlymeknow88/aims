<div class="inner-content with_right_sidebar">

    <div class="wrapper_with_sidebar_right">

        <div class="section-content">

            <div class="row justify-content-center">

                <div class="form-wrapper col-sm-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>
    
                        <div class="title-form text-center mb-3">
                            <h5>PENYUSUNAN KEBIJAKAN</h5>
                        </div><!-- /.title-form -->
    
                        <div class="content-form d-flex flex-column gap-3" x-data="{ konfirmasi: @entangle('konfirmasi') }" x-init="$watch('konfirmasi', value => console.log(value))">
    
                            <div class="row form-group">    
                                <label for="nilai_sub_elemen" class="col col-form-label">Nilai Sub Elemen</label>
                                <div class="col-8">
                                    <x-inputs.select2 wire:model="nilai_sub_elemen" id="nilai_sub_elemen" class="form-select" placeholder="Select Nilai Sub Elemen">
                                        <option value="">Select Position</option>
                                        <option value="nilai_0">Nilai 0</option>
                                        <option value="nilai_1">Nilai 1</option>
                                        <option value="nilai_2">Nilai 2</option>
                                        <option value="nilai_3">Nilai 3</option>
                                        <option value="nilai_4">Nilai 4</option>
                                    </x-inputs.select2>
                                </div>
                            </div><!-- /.form-group nilai_sub_elemen -->

                            <div class="row form-group">    
                                <label for="keterangan" class="col col-form-label d-flex flex-column">Keterangan</label>
                                <div class="col-8">
                                    <x-inputs.texteditor wire:model="keterangan" id="keterangan" placeholder="Keterangan Audit" :error="'keterangan'" />
                                </div>
                            </div><!-- /.form-group keterangan -->

                            <div class="row form-group">    
                                <label for="konfirmasi" class="col col-form-label d-flex flex-column">Konfirmasi</label>
                                <div class="col-8">
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input class="btn-check" wire:model='konfirmasi' type="radio" name="konfirmasi" id="confirmance" value="confirmance">
                                        <label class="btn btn-outline-primary" for="confirmance">Confirmance</label>
                                      
                                        <input class="btn-check" wire:model='konfirmasi' type="radio" name="konfirmasi" id="non_confirmance" value="non_confirmance" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="non_confirmance">Non - Confirmance</label>
                                    </div>            
                                </div>
                            </div><!-- /.form-group keterangan -->

                            <div x-cloak class="confirmance_wrapper" x-show="konfirmasi === 'confirmance'">

                                <div class="inner_confirmance d-flex flex-column gap-3">

                                    <div class="row form-group">    
                                        <label for="rekomendasi" class="col col-form-label d-flex flex-column">Rekomendasi Peluang Perbaikan</label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="rekomendasi" id="rekomendasi" placeholder="Rekomendasi Peluang Perbaikan" :error="'rekomendasi'" />
                                        </div>
                                    </div><!-- /.form-group rekomendasi -->

                                </div><!-- /.inner_confirmance -->

                            </div><!-- /.confirmance_wrapper -->
                            
                            <div x-cloak x-show="konfirmasi === 'non_confirmance'" class="non_confirmance_wrapper">

                                <div class="inner_non_confirmance d-flex flex-column gap-3">

                                    <div class="row form-group">    
                                        <label for="no_non_confirmance" class="col col-form-label d-flex flex-column">No Non Confirmance</label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="no_non_confirmance" id="no_non_confirmance" placeholder="No Non Confirmance" :error="'no_non_confirmance'" />
                                        </div>
                                    </div><!-- /.form-group no_non_confirmance -->
    
                                    <div class="row form-group">    
                                        <label for="masalah" class="col col-form-label d-flex flex-column">
                                            <span>Uraian Masalah</span>
                                            <span class="fst-italic">Problem</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="masalah" id="masalah" placeholder="Uraian Masalah" :error="'masalah'" />
                                        </div>
                                    </div><!-- /.form-group masalah -->
            
                                    <div class="row form-group">    
                                        <label for="area" class="col col-form-label d-flex flex-column">
                                            <span>Area / Lokasi & Departemen</span>
                                            <span class="fst-italic">Location</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="area" id="area" placeholder="Area / Lokasi & Departemen" :error="'area'" />
                                        </div>
                                    </div><!-- /.form-group area -->
            
                                    <div class="row form-group">    
                                        <label for="bukti" class="col col-form-label d-flex flex-column">
                                            <span>Bukti</span>
                                            <span class="fst-italic">Objective Evidence</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="bukti" id="bukti" placeholder="Bukti" :error="'bukti'" />
                                        </div>
                                    </div><!-- /.form-group bukti -->
            
                                    <div class="row form-group">    
                                        <label for="referensi" class="col col-form-label d-flex flex-column">
                                            <span>Referensi</span>
                                            <span class="fst-italic">Reference</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="referensi" id="referensi" placeholder="referensi" :error="'referensi'" />
                                        </div>
                                    </div><!-- /.form-group referensi -->
            
                                    <div class="row form-group">    
                                        <label for="elemen" class="col col-form-label d-flex flex-column">
                                            <span>Elemen</span>
                                            <span class="fst-italic">Element</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="elemen" id="elemen" placeholder="Elemen" :error="'elemen'" />
                                        </div>
                                    </div><!-- /.form-group elemen -->
            
                                    <div class="row form-group">    
                                        <label for="sub_elemen" class="col col-form-label d-flex flex-column">
                                            <span>Sub Elemen</span>
                                            <span class="fst-italic">Sub Element</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="sub_elemen" id="sub_elemen" placeholder="Sub Elemen" :error="'sub_elemen'" />
                                        </div>
                                    </div><!-- /.form-group sub_elemen -->
            
                                    <div class="row form-group">    
                                        <label for="deskripsi" class="col col-form-label d-flex flex-column">
                                            <span>Deskripsi</span>
                                            <span class="fst-italic">Description</span>
                                        </label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="deskripsi" id="deskripsi" placeholder="Deskripsi" :error="'deskripsi'" />
                                        </div>
                                    </div><!-- /.form-group deskripsi -->
        
                                    <div class="row form-group">
        
                                        <label for="kategori" class="col col-form-label">Kategori</label>
                                        <div class="col-8">
                                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="kategori" id="kritikal" value="kritikal" autocomplete="off" checked>
                                                <label class="btn btn-outline-danger" for="kritikal">Kritikal</label>
                                              
                                                <input type="radio" class="btn-check" name="kategori" id="mayor" value="mayor" autocomplete="off">
                                                <label class="btn btn-outline-warning" for="mayor">Mayor</label>
                                              
                                                <input type="radio" class="btn-check" name="kategori" id="minor" value="minor" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="minor">Minor</label>
                                            </div>
                                        </div>
                                    </div><!-- /.form-group kategori -->
    
                                    <div class="row form-group">    
                                        <label for="batas_waktu" class="col col-form-label">Batas Waktu Perbaikan</label>
                                        <div class="col-8">
                                            <x-inputs.datepicker wire:model="batas_waktu" id="batas_waktu" :error="'batas_waktu'" />
                                        </div>
                                    </div><!-- /.form-group batas_waktu -->
    
                                    <div class="row form-group">    
                                        <label for="nama_auditor" class="col-4 col-form-label">Nama Auditor</label>
                                        <div class="col-3">
                                            <x-inputs.text wire:model="nama_auditor" id="nama_auditor" placeholder="Nama Auditor" :error="'nama_auditor'" />
                                        </div>
                                        <label for="tanggal_auditor" class="col-2 col-form-label">Tanggal</label>
                                        <div class="col-3">
                                            <x-inputs.datepicker wire:model="tanggal_auditor" id="tanggal_auditor" :error="'tanggal_auditor'" />
                                        </div>
                                    </div><!-- /.form-group nama_auditor -->
            
                                    <div class="row form-group mb-5">    
                                        <label for="nama_auditi" class="col-4 col-form-label">Nama Auditi</label>
                                        <div class="col-3">
                                            <x-inputs.text wire:model="nama_auditi" id="nama_auditi" placeholder="Nama Auditi" :error="'nama_auditi'" />
                                        </div>
                                        <label for="tanggal_auditi" class="col-2 col-form-label">Tanggal</label>
                                        <div class="col-3">
                                            <x-inputs.datepicker wire:model="tanggal_auditi" id="tanggal_auditi" :error="'tanggal_auditi'" />
                                        </div>
                                    </div><!-- /.form-group nama_auditi -->
    
                                    <h6>Tidak Lanjut Audit</h6>
    
                                    <div class="row form-group">    
                                        <label for="akar_masalah" class="col col-form-label">Investigasi Akar Masalah</label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="akar_masalah" id="akar_masalah" placeholder="Investigasi Akar Masalah" :error="'akar_masalah'" /> 
                                        </div>
                                    </div><!-- /.form-group akar_masalah -->
    
                                    <div class="row form-group">    
                                        <label for="tindakan_perbaikan" class="col col-form-label">Tindakan Perbaikan</label>
                                        <div class="col-8">
                                            <x-inputs.texteditor wire:model="tindakan_perbaikan" id="tindakan_perbaikan" placeholder="Tindakan Perbaikan" :error="'tindakan_perbaikan'" /> 
                                        </div>
                                    </div><!-- /.form-group tindakan_perbaikan -->

                                </div><!-- inner_non_confirmance -->                                

                            </div><!-- /.non_confirmance_wrapper --> 
                            
                        </div><!-- /.content-form -->

                        <div class="footer-action mb-2">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save Draft</button> 
                                <a href="{{ route('smkp-grafik') }}" class="btn btn-outline-secondary" >Cancel</a>                                                  
                            </div>
                        </div>
    
                    </form>
                </div><!-- /.form-wrapper -->

            </div>

        </div><!-- /.section-content-->
        <!-- end content -->

        <!-- sidebar right start -->
        <div class="sidebar-menu-right sidebar">

            <div class="menu-right-content content-sidebar">
                <ul>
                    <li class="item-sidebar">
                        <a class="link-sidebar text-decoration-none dropdown collapsed" data-bs-toggle="collapse" href="#elemen-1" role="button" aria-expanded="false" aria-controls="subSidebar">ELEMEN 1 - KEBIJAKAN</a>
                        <ul class="collapse sub-menu" id="elemen-1">
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>I.1</span>
                                        <span>Penyusunan kebijakan</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>I.2</span>
                                        <span>lsi  Kebiiakan</span>
                                    </span>
                                </a>
                            </li>            
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>I.3</span>
                                        <span>Penetapan Kebijakan</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>I.4</span>
                                        <span>Komunikasi Kebijakan</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>I.5</span>
                                        <span>Tinjauan Kebijakan</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- /ELEMEN 1 -->

                    <li class="item-sidebar">
                        <a class="link-sidebar text-decoration-none dropdown collapsed" data-bs-toggle="collapse" href="#elemen-2" role="button" aria-expanded="false" aria-controls="subSidebar">ELEMEN 2 - PERENCANAAN</a>
                        <ul class="collapse sub-menu" id="elemen-2">
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>II.1</span>
                                        <span>Penelaahan Awal</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a class="link-sidebar text-decoration-none dropdown collapsed" data-bs-toggle="collapse" href="#elemen-2-1" role="button" aria-expanded="false" aria-controls="subSidebar">
                                    <span class="d-flex gap-2">
                                        <span>II.2</span>
                                        <span>Manajemen Risiko</span>
                                    </span>
                                </a>
                                <ul class="collapse sub-menu" id="elemen-2-1">
                                    <li class="item-sidebar">
                                        <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-2">
                                                <span>II.2.1</span>
                                                <span>Komunikasi dan konsultasi risiko</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="item-sidebar">
                                        <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-2">
                                                <span>II.2.2</span>
                                                <span>Penetapan konteks risiko</span>
                                            </span>
                                        </a>
                                    </li>            
                                    <li class="item-sidebar">
                                        <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-2">
                                                <span>II.2.3</span>
                                                <span>Identifikasi bahaya</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="item-sidebar">
                                        <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-2">
                                                <span>II.2.4</span>
                                                <span>Penilaian dan pengendalian risiko</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="item-sidebar">
                                        <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-2">
                                                <span>II.2.5</span>
                                                <span>Pemantauan dan peninjauan</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>            
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>II.3</span>
                                        <span>Identifikasi dan Kepatuhan Terhadap Ketentuan Peraturan Perundang-undangan dan Persyaratan Lainnya yang Terkait</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>II.4</span>
                                        <span>Penetapan Tujuan, Sasaran, dan Program</span>
                                    </span>
                                </a>
                            </li>
                            <li class="item-sidebar">
                                <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>II.5</span>
                                        <span>Rencana Kerja dan Anggaran Keselamatan Pertambangan</span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- /ELEMEN 2 -->

                </ul>
            </div><!-- /.menu-right-content -->
    
        </div><!-- /.sidebar-menu-right -->
        
    </div>    

</div><!-- /.inner-content -->
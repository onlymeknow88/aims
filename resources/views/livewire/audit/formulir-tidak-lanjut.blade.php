<div class="inner-content">

    <div class="header-formulir h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>FORMULIR KETIDAKSESUAIAN DAN TINDAK LANJUT KETIDAKSESUAIAN AUDIT</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-formulir -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-9">

                <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                    <div class="title-form text-center mb-3">
                        <h6>FORMULIR KETIDAKSESUAIAN DAN TINDAK LANJUT KETIDAKSESUAIAN AUDIT</h6>
                        <h6>PENERAPAN SISTEM MANAJEMEN KESELAMATAN DAN KESEHATAN KERJA</h6>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <div class="row form-group">    
                            <label for="nama_perusahaan" class="col col-form-label">Nama Perusahaan</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_perusahaan" id="nama_perusahaan" placeholder="Nama Perusahaan" :error="'nama_perusahaan'" />
                            </div>
                        </div><!-- /.form-group nama_perusahaan -->

                        <div class="row form-group">    
                            <label for="tanggal_audit" class="col col-form-label">Tanggal Audit</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_audit" id="tanggal_audit" :error="'tanggal_audit'" />
                            </div>
                        </div><!-- /.form-group tanggal_audit -->

                        <div class="row form-group">    
                            <label for="no_ketidaksesuaian" class="col col-form-label">Nomor Ketidaksesuaian</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="no_ketidaksesuaian" id="no_ketidaksesuaian" placeholder="Nomor Ketidaksesuaian" :error="'no_ketidaksesuaian'" />
                            </div>
                        </div><!-- /.form-group no_ketidaksesuaian -->

                    </div><!-- /.content-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Uraian Ketidaksesuaian</h6>

                        <div class="row form-group">

                            <label for="kategori" class="col col-form-label">Kategori</label>
                            <div class="col-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kritikal" value="kritikal" checked>
                                    <label class="form-check-label" for="kritikal">Kritikal</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="mayor" value="mayor">
                                    <label class="form-check-label" for="mayor">Mayor</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="minor" value="minor">
                                    <label class="form-check-label" for="minor">Minor</label>
                                </div>
                            </div>
                        </div><!-- /.form-group kategori -->

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

                    </div>

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Batas Waktu</h6>

                        <div class="row form-group">    
                            <label for="batas_waktu" class="col col-form-label">Batas Waktu Perbaikan</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="batas_waktu" id="batas_waktu" :error="'batas_waktu'" />
                            </div>
                        </div><!-- /.form-group batas_waktu -->

                    </div>

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Auditor</h6>

                        <div class="row form-group">    
                            <label for="nama_auditor" class="col col-form-label">Nama Auditor</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditor" id="nama_auditor" placeholder="Nama Auditor" :error="'nama_auditor'" />
                            </div>
                        </div><!-- /.form-group nama_auditor -->

                        <div class="row form-group">    
                            <label for="tanggal_auditor" class="col col-form-label">Tanggal</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditor" id="tanggal_auditor" :error="'tanggal_auditor'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditor -->
                    </div>

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Auditi</h6>

                        <div class="row form-group">    
                            <label for="nama_auditi" class="col col-form-label">Nama Auditi</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditi" id="nama_auditi" placeholder="Nama Auditi" :error="'nama_auditi'" />
                            </div>
                        </div><!-- /.form-group nama_auditi -->

                        <div class="row form-group">    
                            <label for="tanggal_auditi" class="col col-form-label">Tanggal</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditi" id="tanggal_auditi" :error="'tanggal_auditi'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditi -->
                    </div>

                    <div class="space my-3">
                        <hr>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">

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

                        <div class="row form-group">    
                            <label for="bukti_perbaikan" class="col col-form-label">Bukti Perbaikan</label>
                            <div class="col-8">
                                <x-inputs.texteditor wire:model="bukti_perbaikan" id="bukti_perbaikan" placeholder="Bukti Perbaikan" :error="'bukti_perbaikan'" /> 
                            </div>
                        </div><!-- /.form-group bukti_perbaikan -->

                        <div class="row form-group">    
                            <label for="tanggal_perbaikan" class="col col-form-label">Tanggal Perbaikan</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_perbaikan" id="tanggal_perbaikan" :error="'tanggal_perbaikan'" />
                            </div>
                        </div><!-- /.form-group tanggal_perbaikan -->

                        <div class="row form-group">    
                            <label for="nama_auditi_perbaikan" class="col col-form-label">Nama Auditi</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditi_perbaikan" id="nama_auditi_perbaikan" placeholder="Nama Auditi" :error="'nama_auditi_perbaikan'" />
                            </div>
                        </div><!-- /.form-group nama_auditi_perbaikan -->

                        <div class="row form-group">    
                            <label for="tanggal_auditi_perbaikan" class="col col-form-label">Tanggal</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditi_perbaikan" id="tanggal_auditi_perbaikan" :error="'tanggal_auditi_perbaikan'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditi_perbaikan -->

                    </div>

                    <div class="space my-3">
                        <hr>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Ulasan Tim Auditor</h6>

                        <div class="row form-group">    
                            <label for="no_tindak_lanjut" class="col col-form-label">Nomor Tindak Lanjut</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="no_tindak_lanjut" id="no_tindak_lanjut" placeholder="Nomor Tindak Lanjut" :error="'no_tindak_lanjut'" />
                            </div>
                        </div><!-- /.form-group no_tindak_lanjut -->

                        <div class="row form-group">    
                            <label for="verifikasi" class="col col-form-label">Verifikasi</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditi" id="tanggal_auditi" :error="'tanggal_auditi'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditi -->

                        <div class="row form-group">    
                            <label for="nama_auditor_verifikasi" class="col col-form-label">Nama Auditor</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditor_verifikasi" id="nama_auditor_verifikasi" placeholder="Nama Auditor" :error="'nama_auditor_verifikasi'" />
                            </div>
                        </div><!-- /.form-group nama_auditor_verifikasi -->

                        <div class="row form-group">    
                            <label for="tanggal_auditor_verifikasi" class="col col-form-label">Tanggal</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditor_verifikasi" id="tanggal_auditor_verifikasi" :error="'tanggal_auditor_verifikasi'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditor_verifikasi -->

                    </div>

                    <div class="space">
                        <hr>
                    </div>

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('audit') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Simpan</button>                   
                        </div>
                    </div>

                </form>

            </div><!-- /.col-sm-8 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

</div><!-- /.inner-content -->

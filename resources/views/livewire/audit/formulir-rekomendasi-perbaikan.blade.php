<div class="inner-content">

    <div class="header-formulir h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Formulir Rencana Audit</span>
            </a>
        </div><!-- /.left-header -->        
    </div><!-- /.header-formulir -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">

                <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                    <div class="title-form text-center mb-3">
                        <h4>FORMULIR REKOMENDASI DAN PELUANG UNTUK PERBAIKAN</h4>
                        <h4>PENERAPAN SISTEM MANAJEMEN KESELAMATAN DAN KESEHATAN KERJA</h4>
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

                    </div><!-- /.content-form -->

                    <div class="content-form d-flex flex-column gap-3" x-data="{labelButton:'+ Add Elemen'}">

                        <h6>Uraian Rekomendasi dan Peluang untuk Perbaikan</h6>

                        <div class="elemen-perbaikan">

                        @foreach($elemen_perbaikan as $index => $perbaikan)

                            <?php // dd($perbaikan); ?>

                            <div class="items-loop row" :key="{{ $index }}">

                                <div class="col-11 d-flex flex-column gap-3">

                                    <div class="row form-group">    
                                        <label for="elemen" class="col col-form-label">Elemen</label>
                                        <div class="col-8">
                                            {{ $perbaikan['elemen'] }}
                                        </div>
                                    </div><!-- /.form-group elemen -->

                                    <div class="row form-group">    
                                        <label for="sub_elemen" class="col col-form-label">Sub Elemen</label>
                                        <div class="col-8">
                                            {{ $perbaikan['sub_elemen'] }}
                                        </div>
                                    </div><!-- /.form-group sub_elemen -->

                                    <div class="row form-group">    
                                        <label for="keterangan" class="col col-form-label">Rekomendasi dan peluang untuk perbaikan</label>
                                        <div class="col-8">
                                            {{ $perbaikan['keterangan'] }}
                                        </div>
                                    </div><!-- /.form-group keterangan -->

                                </div> <!-- /.col-11 -->

                                <div class="col-1 d-flex justify-content-center align-items-center gap-1">
                                    <button type="button" class="btn btn-danger btn-small" wire:click.prevent="removeField({{$index}})">&times;</button>
                                    <button type="button" class="btn btn-warning btn-small text-white" @click="editField({{$index}})">&#9998;</button>
                                </div>

                            </div>

                            <hr>

                        @endforeach

                        </div><!-- /.elemen-perbaikan -->

                        <div  class="add-element d-flex flex-column gap-3">                       

                            <div class="items-add row">

                                <div class="col-12 d-flex flex-column gap-3">

                                    <div class="row form-group">    
                                        <label for="elemen" class="col col-form-label">Elemen</label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="template_elemen.elemen" id="template_elemen.elemen" placeholder="Elemen" :error="'template_elemen.elemen'" />
                                        </div>
                                    </div><!-- /.form-group elemen -->

                                    <div class="row form-group">    
                                        <label for="sub_elemen" class="col col-form-label">Sub Elemen</label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="template_elemen.sub_elemen" id="template_elemen.sub_elemen" placeholder="Sub Elemen" :error="'template_elemen.sub_elemen'" />
                                        </div>
                                    </div><!-- /.form-group sub_elemen -->

                                    <div class="row form-group">    
                                        <label for="keterangan" class="col col-form-label">Rekomendasi dan peluang untuk perbaikan</label>
                                        <div class="col-8">
                                            <x-inputs.textarea rows="5" wire:model="template_elemen.keterangan" id="template_elemen.keterangan" placeholder="Keterangan" :error="'template_elemen.keterangan'" />
                                        </div>
                                    </div><!-- /.form-group keterangan -->

                                </div> <!-- /.col-12 -->                             

                            </div>

                            <div x-cloak class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" wire:click.prevent="addNewField()"><span x-text="labelButton"></span></button>
                            </div><!-- /.add_loop -->

                        </div><!-- /.loop-element -->
                    
                    </div><!-- /.content-form-elemen -->

                    <hr>

                    <div class="content-form d-flex flex-column gap-3">

                        <div class="row form-group">    
                            <label for="nama_auditor" class="col col-form-label">Nama Auditor</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditor" id="nama_auditor" placeholder="Nama Auditor" :error="'nama_auditor'" />
                            </div>
                        </div><!-- /.form-group nama_auditor -->

                        <div class="row form-group">    
                            <label for="tanggal_auditor" class="col col-form-label">Tanggal Audit</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditor" id="tanggal_auditor" :error="'tanggal_auditor'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditor -->

                    </div><!-- /.content-form-auditor -->

                    <hr>

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('audit') }}" class="btn btn-outline-secondary" >Cancel</a>
                            <button type="submit" class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Simpan</button>                   
                        </div>
                    </div>

                </form>

            </div><!-- /.col-sm-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->

    <!-- Modal edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEdit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Edit Elemen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-group">    
                            <label for="elemen" class="col col-form-label">Elemen</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="template_elemen.elemen" id="template_elemen.elemen" placeholder="Elemen" :error="'template_elemen.elemen'" />
                            </div>
                        </div><!-- /.form-group elemen -->

                        <div class="row form-group">    
                            <label for="sub_elemen" class="col col-form-label">Sub Elemen</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="template_elemen.sub_elemen" id="template_elemen.sub_elemen" placeholder="Sub Elemen" :error="'template_elemen.sub_elemen'" />
                            </div>
                        </div><!-- /.form-group sub_elemen -->

                        <div class="row form-group">    
                            <label for="keterangan" class="col col-form-label">Rekomendasi dan peluang untuk perbaikan</label>
                            <div class="col-8">
                                <x-inputs.textarea rows="5" wire:model="template_elemen.keterangan" id="template_elemen.keterangan" placeholder="Keterangan" :error="'template_elemen.keterangan'" />
                            </div>
                        </div><!-- /.form-group keterangan -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-edit -->

</div>
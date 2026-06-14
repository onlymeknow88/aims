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
                        <h4>FORMULIR KESESUAIAN AUDIT</h4>
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
                            <label for="tanggal_audit" class="col col-form-label">Tanggal Pelaksanaan Audit</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_audit" id="tanggal_audit" :error="'tanggal_audit'" />
                            </div>
                        </div><!-- /.form-group tanggal_audit -->

                    </div><!-- /.content-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <h6>Uraian Kesesuaian</h6>

                        <div class="loop-element d-flex flex-column gap-3" x-data="handler()">
                            <template x-for="(field, index) in fields" :key="index">

                                <div class="items-loop row">

                                    <div class="col-11 d-flex flex-column gap-3">

                                        <div class="row form-group">    
                                            <label for="elemen" class="col col-form-label">Elemen</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="field.elemen" id="field.elemen[]" placeholder="Elemen" :error="'field.elemen[]'" />
                                            </div>
                                        </div><!-- /.form-group elemen -->

                                        <div class="row form-group">    
                                            <label for="sub_elemen" class="col col-form-label">Sub Elemen</label>
                                            <div class="col-8">
                                                <x-inputs.text wire:model="field.sub_elemen" id="field.sub_elemen[]" placeholder="Sub Elemen" :error="'field.sub_elemen[]'" />
                                            </div>
                                        </div><!-- /.form-group sub_elemen -->

                                        <div class="row form-group">    
                                            <label for="keterangan" class="col col-form-label">Keterangan</label>
                                            <div class="col-8">
                                                <x-inputs.textarea rows="5" wire:model="field.keterangan" id="field.keterangan[]" placeholder="Keterangan" :error="'field.keterangan[]'" />
                                            </div>
                                        </div><!-- /.form-group keterangan -->

                                    </div> <!-- /.col-11 -->
                                    
                                    <div class="col-1">
                                    <button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button>
                                    </div>

                                </div>

                            </template>

                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" @click="addNewField()">+ Add Elemen</button>
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

                        <div class="row form-group">    
                            <label for="nama_auditi" class="col col-form-label">Nama Auditi</label>
                            <div class="col-8">
                                <x-inputs.text wire:model="nama_auditi" id="nama_auditi" placeholder="Nama Auditi" :error="'nama_auditi'" />
                            </div>
                        </div><!-- /.form-group nama_auditi -->

                        <div class="row form-group">    
                            <label for="tanggal_auditi" class="col col-form-label">Tanggal Auditi</label>
                            <div class="col-8">
                                <x-inputs.datepicker wire:model="tanggal_auditi" id="tanggal_auditi" :error="'tanggal_auditi'" />
                            </div>
                        </div><!-- /.form-group tanggal_auditi -->

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

    <script>

        function handler() {
            return {
            fields: [
                {
                    elemen: '',
                    sub_elemen: '',
                    keterangan: ''
                }
            ],
            addNewField() {
                this.fields.push({
                    elemen: '',
                    sub_elemen: '',
                    keterangan: ''
                });
                },
                removeField(index) {
                this.fields.splice(index, 1);
                }
            }
        }
    </script>
</div>
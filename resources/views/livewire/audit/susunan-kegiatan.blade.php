<div class="inner-content">

    <div class="header-formulir h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">

        <div class="left-header">
            <a href="{{ route('/') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>SUSUNAN KEGIATAN PELAKSANAAN AUDIT</span>
            </a>
        </div><!-- /.left-header -->
        
    </div><!-- /.header-formulir -->

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-sm-12">

                <form class="form-susunan-kegiatan py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                    <div class="title-form text-center">
                        <h6>SUSUNAN KEGIATAN PELAKSANAAN AUDIT</h6>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">

                        <div class="kegiatan-loop">

                            <div class="mb-3">         
 
                                <div class="row mb-3 justify-content-between">
                                    <div class="col-sm-11">
                                        <div class="row form-group">    
                                            <label for="title.0" class="col-2 col-form-label">Judul Kegiatan</label>
                                            <div class="col-10">
                                                <x-inputs.text id="title.0" placeholder="Hari ke 1" :error="'title.0'" />
                                            </div>
                                        </div><!-- /.form-group elemen -->
                                    </div>
                                    <div class="col-sm-1 text-end"><button type="button" class="btn btn-danger btn-small" wire:click.prevent="removeHaris(0)">&times;</button></div>
                                </div>

                                <div x-data="{
                                    fields: [],
                                    addNewField() {
                                        this.fields.push({
                                            tanggal: '',
                                            waktu: '',
                                            fungsi: '',
                                            auditor: ''
                                        });
                                    },
                                    removeField(index) {
                                        this.fields.splice(index, 1);
                                    }
                                    }">

                                    <table class="table table-bordered align-items-center table-sm">

                                        <thead class="thead-light">
                                            <tr style="border-left:1px solid #dddddd;">
                                                <th>#</th>
                                                <th>Tangal</th>
                                                <th>Waktu</th>
                                                <th>Fungsi / Area / Departemen / Kegiatan yang akan di audit (termasuk persyaratan terkait)</th>
                                                <th>Auditor</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(field, index) in fields" :key="index">
                                                <tr style="border-left:1px solid #dddddd;">
                                                    <td x-text="index + 1"></td>
                                                    <td><input type="date" x-model="field.tanggal" name="tanggal.0.[]" class="form-control"></td>
                                                    <td><input type="time" x-model="field.waktu" name="waktu.0.[]" class="form-control"></td>
                                                    <td><input type="text" x-model="field.fungsi" name="fungsi.0.[]" class="form-control"></td>
                                                    <td><input type="text" x-model="field.auditor" name="auditor.0.[]" class="form-control"></td>
                                                    <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-right"><button type="button" class="btn btn-outline-success" @click="addNewField()">+ Add Row</button></td>
                                            </tr>
                                        </tfoot>
                                    </table>                                    

                                </div>

                            </div>

                            @foreach($listKegiatan as $key => $value)

                                <hr>

                                <div class="my-3">
                                    <div class="row mb-3 justify-content-between">
                                        <div class="col-sm-11">
                                            <div class="row form-group">    
                                                <label for="title.{{$key}}" class="col-sm-2 col-form-label">Judul kegiatan</label>
                                                <div class="col-sm-10">
                                                    <x-inputs.text id="title.{{$key+1}}" placeholder="Hari ke {{$key+2}}" :error="'title.{{$key+1}}'" />
                                                </div>
                                            </div><!-- /.form-group elemen -->
                                        </div>
                                        <div class="col-sm-1 text-end"><button type="button" class="btn btn-danger btn-small" wire:click.prevent="removeHaris({{$key    }})">&times;</button></div>
                                    </div>

                                        

                                    <div x-data="{
                                        fields: [],
                                        addNewField() {
                                            this.fields.push({
                                                tanggal: '',
                                                waktu: '',
                                                fungsi: '',
                                                auditor: ''
                                            });
                                        },
                                        removeField(index) {
                                            this.fields.splice(index, 1);
                                        }
                                        }">

                                        <table class="table table-bordered align-items-center table-sm">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tangal</th>
                                                    <th>Waktu</th>
                                                    <th>Fungsi / Area / Departemen / Kegiatan yang akan di audit (termasuk persyaratan terkait)</th>
                                                    <th>Auditor</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="(field, index) in fields" :key="index">
                                                    <tr>
                                                        <td x-text="index + 1"></td>
                                                        <td><input type="date" x-model="field.tanggal" name="tanggal.{{$key+1}}.[]" class="form-control"></td>
                                                        <td><input type="time" x-model="field.waktu" name="waktu.{{$key+1}}.[]" class="form-control"></td>
                                                        <td><input type="text" x-model="field.fungsi" name="fungsi.{{$key+1}}.[]" class="form-control"></td>
                                                        <td><input type="text" x-model="field.auditor" name="auditor.{{$key+1}}.[]" class="form-control"></td>
                                                        <td><button type="button" class="btn btn-danger btn-small" @click="removeField(index)">&times;</button></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" class="text-right"><button type="button" class="btn btn-outline-success" @click="addNewField()">+ Add Row</button></td>
                                                </tr>
                                            </tfoot>
                                        </table>                                    

                                    </div>
                                </div>                                

                            @endforeach

                            <div class="add-kegiatan">
                                <button type="button" class="btn btn-outline-success" wire:click.prevent="addNewKegiatan({{$i}})">+ Add Kegiatan</button>
                            </div><!-- /.add-kegiatan -->
    
                        </div><!-- /.kegiatan-loop -->
                        
                    </div><!-- /.content-form -->

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
            </div><!-- /.col-sm-12 -->

        </div><!-- /.row -->

    </div><!-- /.container -->


</div><!-- /.inner-content -->

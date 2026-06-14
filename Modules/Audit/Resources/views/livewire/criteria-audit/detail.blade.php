@push('styles')
    <style>
        td.bx-0 {
            border-left: none;
            border-right: none;
        }

        td.bl {
            border-left: 1px solid #ddd;
        }

        td.bb {
            border-bottom: 1px solid #ddd;
        }

    </style>
@endpush
<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-'.$module_category,['id'=>$audit->id])
</x-slot>
<div class="inner-content with_right_sidebar">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($module_category),'url'=>route('audit::'.$module_category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$module_category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Kriteria Audit','url'=>route('audit::'.$module_category.'.detail.criteria-audit.index',['id'=>$audit->id])],
        ['name'=>' Detail'],
     ]
 ])
    <div class="wrapper_with_sidebar_right">

        <div class="section-content">

            <div class="row justify-content-center" >

                <div class="form-wrapper col-sm-8" >
                    <div class="title-form text-center p-2">
                        <h3>KRITERIA AUDIT</h3>
                    </div><!-- /.title-form -->
                    <form class="py-4 d-flex flex-column gap-5">
                        <div class="title-form text-left mb-3">

                        @if($auditSubCriteria->parent)
                            @if($auditSubCriteria->parent->parent)
                                @if($auditSubCriteria->parent->parent->parent)
                                <h6>{{$auditSubCriteria->parent->parent->parent->title}}</h5><br>
                                @endif
                                <h6>{{$auditSubCriteria->parent->parent->title}}</h5><br>
                            @endif
                        <h6>{{$auditSubCriteria->parent->title}}</h5><br>
                        @endif
                        {{$auditSubCriteria->title}}
                        </div><!-- /.title-form -->
                        <div class="content-form d-flex flex-column gap-3">

                            <div class="row form-group">
                                <label for="point" class="col col-form-label">Nilai Sub Elemen</label>
                                <div class="col-9">
                                    <x-inputs.select2 wire:model="point" id="point"
                                                      placeholder="Pilih Nilai Sub Elemen">
                                        @foreach($auditSubCriteria->list_points as $point)
                                            @if($module_category == 'smkp')
                                            <option value="{{$point->point}}">{{$point->point}}</option>
                                            @else
                                            <option value="{{$point->point}}">{{$point->point}} - {{$point->tooltip}}</option>
                                            @endif
                                        @endforeach
                                    </x-inputs.select2>
                                    <!-- @isset($tooltip)
                                        <textarea disabled class="form-control mt-2">{{$tooltip}} </textarea>
                                    @endisset -->
                                </div>

                            </div><!-- /.form-group nilai_sub_elemen -->

                            <div class="row form-group">
                                <label for="keterangan" class="col col-form-label d-flex flex-column">Keterangan</label>
                                <div class="col-9">
                                    <x-inputs.texteditor-custom wire:model="description" id="description"
                                                                placeholder="Keterangan Audit" error="'description'"/>
                                </div>
                            </div><!-- /.form-group keterangan -->

                            @if($module_category != 'smkp')
                            <div class="row form-group">
                                <label for="system_references" class="col col-form-label d-flex flex-column">Referensi Sistem</label>
                                <div class="col-9">
                                    <x-inputs.texteditor-custom
                                        wire:model="system_references" id="system_references"

                                        placeholder="Referensi Sistem" error="'system_references'"/>
                                </div>
                            </div><!-- /.form-group keterangan -->
                            <div class="row form-group">
                                <label for="current_system_verification" class="col col-form-label d-flex flex-column">Verifikasi Sistem saat ini</label>
                                <div class="col-9">
                                    <x-inputs.texteditor-custom
                                        wire:model="current_system_verification" id="current_system_verification"

                                        placeholder="Verifikasi Sistem saat ini" error="'current_system_verification'"/>
                                </div>
                            </div><!-- /.form-group keterangan -->
                            @endif

                            @if(isset($status))
                                <div class="row form-group">
                                    <span class="col col-form-label d-flex flex-column">Konfirmasi</span>
                                    <div class="col-9">
                                        <div class="btn-group" role="group"
                                             aria-label="Basic radio toggle button group">

                                            <button class="btn btn-outline-primary" type="button" wire:click="confirm">{{
                                                   ($status == "non relation" ? "Non Relation" : ($status == "non confirmance"?"Non Confirmance ":"Confirmance"))
                                                }}
                                            </button>

                                        </div>
                                    </div>
                                </div><!-- /.form-group keterangan -->
                                <div class="space">
                                    <hr>
                                </div>
                            @endif

                           {{--  @if(isset($status))
                                <div class="row form-group">
                                    <span class="col col-form-label d-flex flex-column">Konfirmasi</span>
                                    <div class="col-9">
                                        <div class="btn-group" role="group"
                                             aria-label="Basic radio toggle button group">

                                            <button class="btn btn-outline-primary"
                                            type="button"
                                            wire:click="confirm"
                                            >{{$status =="non confirmance"?"Non ":""}}Confirmance
                                            </button>

                                        </div>
                                    </div>
                                </div><!-- /.form-group keterangan -->
                                <div class="space">
                                    <hr>
                                </div>
                            @endif --}}


                            @if($isConfirm && !$isRelation)
                                <div class="confirmance_wrapper">

                                    <div class="inner_confirmance d-flex flex-column gap-3">

                                        <div class="row form-group">
                                            <label for="fix_recommendation"
                                                   class="col col-form-label d-flex flex-column">Rekomendasi
                                                Peluang Perbaikan</label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="fix_recommendation"
                                                                            id="fix_recommendation"
                                                                            placeholder="Rekomendasi Peluang Perbaikan"
                                                                            error="fix_recommendation"/>
                                            </div>
                                        </div><!-- /.form-group rekomendasi -->
                                        <!-- <div class="row form-group">
                                            <label for="audit_team_id" class="col-3 col-form-label">Nama
                                                Auditor</label>
                                            <div class="col-3">
                                                <x-inputs.select2 wire:model="audit_team_id"
                                                                  id="audit_team_id"
                                                                  placeholder="Nama Auditor" error="audit_team_id">
                                                    @foreach($teams as $team)
                                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            </div>
                                            <label for="auditor_date" class="col-2 col-form-label">Tanggal</label>
                                            <div class="col-3">
                                                <x-inputs.datepicker
                                                wire:model="auditor_date"
                                                id="auditor_date"
                                                error="auditor_date"/>
                                            </div>
                                        </div>/.form-group nama_auditor -->

                                        <!-- <div class="row form-group mb-5">
                                            <label for="auditee" class="col-3 col-form-label">Nama Auditi</label>
                                            <div class="col-3">
                                                <x-inputs.text
                                                    wire:model="auditee" id="auditee"
                                                    placeholder="Nama Auditi" error="auditee"/>
                                            </div>
                                            <label for="tanggal_auditi" class="col-2 col-form-label">Tanggal</label>
                                            <div class="col-3">
                                                <x-inputs.datepicker
                                                    wire:model="auditee_date"
                                                    id="auditee_date"
                                                    error="auditee_date"/>
                                            </div>
                                        </div>/.form-group nama_auditi -->

                                    </div><!-- /.inner_confirmance -->

                                </div><!-- /.confirmance_wrapper -->

                            @endif

                            @if((isset($isConfirm) && !$isConfirm) && (isset($isRelation) && !$isRelation))
                                <div class="non_confirmance_wrapper">

                                    <div class="inner_non_confirmance d-flex flex-column gap-3">

                                        <div class="row form-group">
                                            <label for="non_confirmance_number"
                                                   class="col col-form-label d-flex flex-column">Non
                                                Confirmance Number</label>
                                            <div class="col-9">
                                                <x-inputs.text wire:model="non_confirmance_number"
                                                               id="non_confirmance_number" disabled
                                                               placeholder="No Non Confirmance"
                                                               error="non_confirmance_number"/>
                                            </div>
                                        </div><!-- /.form-group no_non_confirmance -->

                                        <div class="row form-group">
                                            <label for="problem_description"
                                                   class="col col-form-label d-flex flex-column">
                                                <span>Uraian Masalah</span>
                                                <span class="fst-italic">Problem</span>
                                            </label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="problem_description"
                                                                            id="problem_description"
                                                                            placeholder="Uraian Masalah"
                                                                            error="problem_description"/>
                                                @error('problem_description')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group masalah -->

                                        <div class="row form-group">
                                            <label for="area" class="col col-form-label d-flex flex-column">
                                                <span>Area / Lokasi & Departemen</span>
                                                <span class="fst-italic">Location</span>
                                            </label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="area_location_department"
                                                                            id="area_location_department"
                                                                            placeholder="Area / Lokasi & Departemen"
                                                                            error="area_location_department"/>
                                                @error('area_location_department')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group area -->

                                        <div class="row form-group">
                                            <label for="bukti" class="col col-form-label d-flex flex-column">
                                                <span>Bukti</span>
                                                <span class="fst-italic">Objective Evidence</span>
                                            </label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="proof" id="proof"
                                                                            placeholder="Bukti"
                                                                            error="proof"/>
                                                @error('proof')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group bukti -->

                                        <div class="row form-group">
                                            <label for="referensi" class="col col-form-label d-flex flex-column">
                                                <span>Referensi</span>
                                                <span class="fst-italic">Reference</span>
                                            </label>
                                            <div class="col-9">
                                                <ul>
                                                    <li>{{$auditSubCriteria->criteria->title}}</li>
                                                    @if($auditSubCriteria->parent)
                                                        <li>{{$auditSubCriteria->parent->title}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div><!-- /.form-group referensi -->

                                        <div class="row form-group">
                                            <label for="description" class="col col-form-label d-flex flex-column">
                                                <span>Deskripsi</span>
                                                <span class="fst-italic">Description</span>
                                            </label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="non_confirmance_description"
                                                                            id="non_confirmance_description"
                                                                            placeholder="Deskripsi"
                                                                            error="non_confirmance_description"/>
                                                @error('non_confirmance_description')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group deskripsi -->
                                        @if($module_category == 'smkp')
                                        <div class="row form-group">

                                            <span class="col col-form-label">Kategori</span>
                                            <div class="col-9">
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" wire:model="category"
                                                           id="critical"
                                                           value="critical" autocomplete="off" checked>
                                                    <label class="btn btn-outline-danger"
                                                           for="critical">Kritikal</label>

                                                    <input type="radio" class="btn-check" wire:model="category"
                                                           id="mayor"
                                                           value="mayor" autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="mayor">Mayor</label>

                                                    <input type="radio" class="btn-check" wire:model="category"
                                                           id="minor"
                                                           value="minor" autocomplete="off">
                                                    <label class="btn btn-outline-primary" for="minor">Minor</label>
                                                </div>
                                                @error('category')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>


                                                @enderror
                                            </div>
                                        </div><!-- /.form-group kategori -->
                                        @endif
                                        <div class="row form-group">
                                            <label for="batas_waktu" class="col col-form-label">Batas Waktu
                                                Perbaikan</label>
                                            <div class="col-9">
                                                <x-inputs.datepicker wire:model="due_date" id="due_date"
                                                                     error="due_date"/>
                                            </div>
                                        </div><!-- /.form-group batas_waktu -->

                                        <div class="row form-group">
                                            <label for="audit_team_id" class="col-3 col-form-label">Nama
                                                Auditor</label>
                                            <div class="col-4">
                                                <x-inputs.select2 wire:model="audit_team_id"
                                                                  id="audit_team_id"
                                                                  placeholder="Nama Auditor" error="audit_team_id">
                                                    @foreach($teams as $team)
                                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            </div>
                                            <label for="auditor_date" class="col-2 col-form-label">Tanggal</label>
                                            <div class="col-3">
                                                <x-inputs.datepicker wire:model="auditor_date" id="auditor_date"
                                                                     error="auditor_date"/>
                                            </div>
                                        </div><!-- /.form-group nama_auditor -->

                                        <div class="row form-group mb-5">
                                            <label for="auditee" class="col-3 col-form-label">Nama Auditi</label>
                                            <div class="col-4">
                                                <x-inputs.text wire:model="auditee" id="auditee"
                                                               placeholder="Nama Auditi" error="auditee"/>
                                            </div>
                                            <label for="tanggal_auditi" class="col-2 col-form-label">Tanggal</label>
                                            <div class="col-3">
                                                <x-inputs.datepicker wire:model="auditee_date" id="auditee_date"
                                                                     error="auditee_date"/>
                                            </div>
                                        </div><!-- /.form-group nama_auditi -->

                                        <h6>Tidak Lanjut Audit</h6>

                                        <div class="row form-group">
                                            <label for="akar_masalah" class="col col-form-label">Investigasi Akar
                                                Masalah</label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="root_cause_investigation"
                                                                            id="root_cause_investigation"
                                                                            placeholder="Investigasi Akar Masalah"
                                                                            error="root_cause_investigation"/>
                                                @error('root_cause_investigation')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group akar_masalah -->

                                        <div class="row form-group">
                                            <label for="fix_action" class="col col-form-label">Tindakan
                                                Perbaikan</label>
                                            <div class="col-9">
                                                <x-inputs.texteditor-custom wire:model="fix_action"
                                                                     id="fix_action"
                                                                     placeholder="Tindakan Perbaikan"
                                                                     error="fix_action"/>
                                                @error('fix_action')
                                                <div class="is-invalid">
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div><!-- /.form-group tindakan_perbaikan -->

                                    </div><!-- inner_non_confirmance -->

                                </div><!-- /.non_confirmance_wrapper -->
                            @endif


                        </div><!-- /.content-form -->
                        @if(isset($isConfirm) || isset($isRelation))
                            <div class="footer-action mb-2">
                                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                    <!-- <a href="" class="btn btn-outline-secondary">Cancel</a> -->
                                    <button type="button" wire:click="save"
                                            class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        @endif

                    </form>
                </div><!-- /.form-wrapper -->
                @if($module_category == 'smkp')
                <div class="col-sm-3" style="padding-top:170px">
                    <div class="row">
                        <div class="col-sm-12"  style="padding:5px"><b>Nilai Sub Elemen</b></div>
                    </div>
                    @foreach ($auditSubCriteria->list_points as $list_point )
                    <div class="row">
                        <div class="col-sm-12" style="padding:5px">
                            Nilai : {{$list_point->point}}
                        </div>
                        <div class="col-sm-12" style="padding:5px">
                            {{$list_point->tooltip}}
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div><!-- /.section-content-->
        <!-- end content -->

        <!-- sidebar right start -->
        @livewire('audit::layouts.sidebar-'.$module_category.'-criteria',['audit'=>$audit,'selected'=>$auditSubCriteria->id])

    </div>

</div>
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });

        window.addEventListener('showModal', event => {
            $('#modalFormSampel').modal('show');
        });
        window.addEventListener('summerNote', event => {
            $(document).find('.summernote.disabled').each(function (i, e) {
                $(e).summernote({
                    height: 200,
                    toolbar: [],
                });
                $(e).summernote('disable')
            })
        });
        window.Livewire.on('summernote', () => {
            $('.summernote').each(function (i, e) {
                const id = $(e).attr('id')
                $(e).summernote(
                    {
                        height: 300,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ],
                        callbacks: {
                            onChange: function (contents, $editable) {
                                @this.
                                set(id, contents);
                            }
                        },
                    }
                )
            })
        })
    </script>
@endpush

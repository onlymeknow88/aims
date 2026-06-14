<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-'.$category,['id'=>$audit->id])
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
     'trees'=>[
        ['name'=>'Audit','url'=>route('audit::dashboard')],
        ['name'=>strtoupper($category),'url'=>route('audit::'.$category.'.index')],
        ['name'=>$audit->title,'url'=>route('audit::'.$category.'.detail.index',['id'=>$audit->id])],
        ['name'=>'Rencana Audit'],
    ]
])
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-1">
                    <h3>RENCANA AUDIT</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Judul
                    </div>
                    <div class="col-8">
                        : {{$audit->title}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Nama Perusahaan
                    </div>
                    <div class="col-8">
                        : {{$audit->company->company_name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        Tanggal Audit
                    </div>
                    <div class="col-8">
                        : {{date('d F Y',strtotime($audit->start_at))}} - {{date('d F Y',strtotime($audit->end_at))}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-sm-12">

                <form class="py-4 d-flex flex-column gap-5" action="#" action="post" wire:submit.prevent='save'>

                    
                    <div class="content-form d-flex flex-column gap-3">

                        <div class="row form-group">
                            <label for="audit_type" class="col-3 col-form-label">Jenis Audit</label>
                            <div class="col-9">
                                <x-inputs.text disabled wire:model="audit_type" id="audit_type"
                                               placeholder="Jenis Audit" error="audit_type"/>
                            </div>
                        </div><!-- /.form-group jenis_audit -->

                        <div class="row form-group">
                            <label for="audit_criteria_reference" class="col-3 col-form-label">Kriteria Audit</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom disabled wire:model="audit_criteria_reference"
                                                            id="audit_criteria_reference"
                                                            placeholder="Kriteria Audit"
                                                            error="audit_criteria_reference"/>
                            </div>
                        </div><!-- /.form-group kriteria_audit -->

                        <div class="row form-group">
                            <label for="company_name" class="col-3 col-form-label">Nama Perusahaan</label>
                            <div class="col-9">
                                <x-inputs.text disabled wire:model="company_name" id="company_name"
                                               placeholder="Nama Perusahaan" error="company_name"/>
                            </div>
                        </div><!-- /.form-group nama_perusahaan -->

                        <div class="row form-group">
                            <label for="address" class="col-3 col-form-label">Alamat</label>
                            <div class="col-9">
                                <x-inputs.textarea rows="5" wire:model="address" id="address" placeholder="Alamat"
                                                   error="address"/>
                            </div>
                        </div><!-- /.form-group alamat -->
                        <div class="row form-group">
                            <label for="site_address" class="col-3 col-form-label">Alamat Site</label>
                            <div class="col-9">
                                <x-inputs.textarea rows="5" wire:model="site_address" id="site_address"
                                                   placeholder="Alamat Site" error="site_address"/>
                            </div>
                        </div><!-- /.form-group alamat -->

                        <div class="row form-group">
                            <label for="audit_date" class="col-3 col-form-label">Tanggal Pelaksanaan Audit</label>
                            <div class="col-9">
                                <x-inputs.text disabled wire:model="audit_date" id="audit_date" error="audit_date"/>
                            </div>
                        </div><!-- /.form-group tanggal_audit -->

                        <div class="row form-group">
                            <label for="purpose" class="col-3 col-form-label">Tujuan Audit</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom wire:model="purpose" id="purpose" placeholder="Tujuan Audit"
                                                            error="purpose"/>
                            </div>
                        </div><!-- /.form-group tujuan_audit -->

                        <div class="row form-group">
                            <label for="audit_scope" class="col-3 col-form-label">Ruang Lingkup Audit</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom wire:model="audit_scope" id="audit_scope"
                                                            placeholder="Ruang Lingkup Audit" error="audit_scope"/>
                            </div>
                        </div><!-- /.form-group ruang_lingkup -->
                        @if($category == 'smkp')
                        <div class="row form-group">
                            <label for="methods" class="col-3 col-form-label">Pengecualian</label>
                            <div wire:ignore class="col-8">
                                <select data-placeholder="" id="exceptions" wire:model="exceptions"
                                        class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                    <option></option>
                                    @foreach($criteria as $id=>$value)
                                        <option value="{{$id}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- /.form-group pengecualian -->
                        @endif
                        <div class="row form-group">
                            <label for="tim_audit" class="col-3 col-form-label">Tim Audit</label>
                            <div class="col-9">
                                @foreach($audit->auditors as $auditor)
                                    <div class="mb-3">
                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                       value="{{$auditor->role->name}} : {{$auditor->name}}">

                                        </x-inputs.text>
                                    </div>

                                @endforeach
                            </div>
                        </div><!-- /.form-group tim_audit -->

                        <div class="row form-group">
                            <label for="relevant_document" class="col-3 col-form-label">Dokumentasi Relevan</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom wire:model="relevant_document" id="relevant_document"
                                                            placeholder="Dokumentasi Relevan"
                                                            error="relevant_document"/>
                            </div>
                        </div><!-- /.form-group doc_relevan -->

                        <div class="row form-group">
                            <label for="facility" class="col-3 col-form-label">Fasilitas</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom wire:model="facility" id="facility" placeholder="Fasilitas"
                                                            error="facility"/>
                            </div>
                        </div><!-- /.form-group fasilitas -->

                        <div class="row form-group">
                            <label for="reporting_distribution" class="col-3 col-form-label">Distribusi Laporan</label>
                            <div class="col-9">
                                <x-inputs.texteditor-custom wire:model="reporting_distribution"
                                                            id="reporting_distribution"
                                                            placeholder="Distriusi Laporan"
                                                            error="reporting_distribution"/>
                            </div>
                        </div><!-- /.form-group distribusi_laporan -->

                    </div><!-- /.content-form -->
                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                        <div>Progress : {{$progress}} %</div>
                            <!-- <button type="button" class="btn btn-outline-secondary">Cancel</button> -->
                            <button type="submit"
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">
                                Simpan
                            </button>
                        </div>
                    </div>

                </form><!-- /.form -->

            </div><!-- ./col-sm-8 -->
        </div><!-- /.row -->
    </div><!--/.container-->

</div><!--innner-content-->
@once
    @push('styles')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    @endpush
@endonce

@once
    @push('scripts')
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function () {
            $('.select2-multiple').select2({
                theme: 'bootstrap-5',
            });

            $(document).on('change', '.select2-multiple', function (e) {
                var data = $(this).select2("val");
                let elementName = $(this).attr('id');
                @this.
                set(elementName, data);
            });
        })
    </script>
@endpush

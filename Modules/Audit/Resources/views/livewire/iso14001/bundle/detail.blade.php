<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar-iso14001',['id'=>$audit->id])
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>'ISO14001 List','url'=>route('audit::iso14001.index')],
            ['name'=>'ISO14001 Detail'],
        ]
    ])
    @include('audit::livewire.iso14001.bundle.modal_team')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <form wire:submit.prevent='store' id="form-audit-init" class="py-4 d-flex flex-column gap-5">
                    <div class="title-form text-center mb-3">
                        <h4>{{$audit->audit_number}}</h4>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>General Information</h6>
                        <div class="row form-group">
                            <label for="title" class="col col-form-label">Judul</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="title"
                                    error="title"
                                    disabled
                                    wire:model='audit.title'
                                    placeholder="Judul"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="company_id" class="col col-form-label">Nama Perusahaan</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="company_id"
                                    error="company_id"
                                    disabled
                                    wire:model='audit.company.company_name'
                                    placeholder="Nama perusahaan"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audit_type" class="col col-form-label">Jenis Audit</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="audit_type"
                                    error="audit_type"
                                    disabled
                                    wire:model='audit.audit_type'
                                    placeholder="Jenis Audit"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audit_type" class="col col-form-label">Periode Audit</label>
                            <div class="col-8">
                                <input type="text"
                                       class="form-control"
                                    id="audit_time"
                                    error="audit_time"
                                    disabled
                                    value="{{Carbon\Carbon::parse($audit->start_at)->format('d F Y') ." - ".Carbon\Carbon::parse($audit->end_at)->format('d F Y')}}"
                                    placeholder="Jenis Audit"></input>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="status" class="col col-form-label">Status Audit</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="status"
                                    error="status"
                                    disabled
                                    value="{{$audit->status}}"
                                    placeholder="Jenis Audit"></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>Tim Audit</h6>
                        <div class="loop-element d-flex flex-column gap-5">
                            @foreach($audit->auditors as $auditor)
                                <div class="items-loop row">
                                    <div class="col-12 d-flex flex-column gap-3">
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Role</label>
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->role->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="button" class="btn btn-danger btn-small"
                                                                wire:click="deleteTeam('{{$auditor->id}}')">&times;
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nama</label>
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->name}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <label for="title" class="col col-form-label">Nomor Registrasi</label>
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <x-inputs.text id="role[{{$loop->index}}]" disabled error=""
                                                                       value="{{$auditor->registration_number}}"></x-inputs.text>
                                                    </div>
                                                    <div class="col-2">

                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block" data-bs-toggle="modal"
                                        data-bs-target="#modalFormTeam">+ Add Team
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>Evaluator Dokumen Audit</h6>
                        <div class="row form-group">
                            <label for="evaluator_ids" class="col col-form-label">Evaluator</label>
                            <div class="col-8" wire:ignore>
                                <select data-placeholder="" id="evaluator_ids"
                                        class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                    <option></option>
                                    @foreach($users as $user)
                                        <option
                                            value="{{$user->id}}" {{in_array($user->id,$evaluator_ids)?'selected':''}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <div>Progress : {{$progress}} %</div>
                            <div class="form-group d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary" wire:loading.remove
                                        wire:target='saveStatus'
                                        wire:click="saveStatus('{{Modules\Audit\Enums\BundleStatusEnum::DRAFT}}')">Save
                                    as Draft
                                </button>
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    wire:loading.remove wire:target='saveStatus'
                                    type="button"
                                    wire:click="saveStatus('{{Modules\Audit\Enums\BundleStatusEnum::ON_GOING}}')">
                                    Submit
                                </button>
                                <x-button-spinner
                                    target="saveStatus"
                                    :text="trans('global.processing')"></x-button-spinner>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('.modal').modal('hide');
        });
        window.addEventListener('openTeamModal', event => {
            $('#modalFormTeam').modal('show');
        });
    </script>
@endpush
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

<x-slot name="sidebar">
    @livewire('audit::layouts.sidebar')
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
         'trees'=>[
            ['name'=>'ISO14001 List','url'=>route('audit::iso14001.index')],
            ['name'=>'Baru'],
        ]
  ])
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <form wire:submit.prevent='store' id="form-audit-init" class="py-4 d-flex flex-column gap-5">
                    <div class="title-form text-center mb-3">
                        <h3>AUDIT ISO14001</h3>
                    </div><!-- /.title-form -->

                    <div class="content-form d-flex flex-column gap-3">
                        <h6>Informasi Umum </h6>
                        <div class="row form-group">
                            <label for="title" class="col col-form-label">Judul</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="title"
                                    error="title"
                                    wire:model='title'
                                    placeholder="Judul"></x-inputs.text>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="company_id" class="col col-form-label">Nama Perusahaan</label>
                            <div class="col-8">
                                <x-inputs.select2
                                    id="company_id"
                                    error="company_id"
                                    wire:model='company_id'
                                    style="width: 100%"
                                >
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">
                                            {{ $company->company_name }}
                                        </option>
                                    @endforeach
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audit_type" class="col col-form-label">Jenis Audit</label>
                            <div class="col-8">
                                <x-inputs.select2
                                    id="audit_type"
                                    error="audit_type"
                                    wire:model='audit_type'
                                    style="width: 100%"
                                    placeholder="Jenis Audit">
                                    @foreach(\Modules\Audit\Enums\AuditType::asArray() as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                    @endforeach
                                </x-inputs.select2>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="audit_type" class="col col-form-label">Periode Audit</label>
                            <div class="col-8">
                                <x-inputs.text
                                    id="audit_time"
                                    error="audit_time"
                                    wire:model='audit_time'
                                    placeholder="Periode Audit"></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="footer-action mb-2 p-3">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                            <div class="form-group d-flex justify-content-end gap-2">
                                <a href="{{route('audit::iso14001.index')}}" class="btn btn-outline-secondary">Batal
                                </a>
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    wire:loading.remove wire:target='store'
                                    type="button"
                                    wire:click="store">
                                    Simpan
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
@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#audit_time').daterangepicker({
                "autoUpdateInput": false,
                "startDate": moment(),
                "endDate": moment(),
                "opens": "center",
                "drops": "up"
            }, function(start, end, label) {
                @this.set('start_date', start.format('YYYY-MM-DD').toString())
                @this.set('end_date', end.format('YYYY-MM-DD').toString())
                @this.set('audit_time', start.format('YYYY-MM-DD').toString() + ' - ' + end.format('YYYY-MM-DD').toString());
            });
        });
    </script>
@endpush

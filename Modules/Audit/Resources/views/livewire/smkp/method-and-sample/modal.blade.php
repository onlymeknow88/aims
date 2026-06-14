<div>
    <div class="modal fade" wire:ignore.self id="modalFormSampel" tabindex="-1" aria-labelledby="modalFormSampel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="save" wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Metode dan Sampel Audit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="audit_method_id">Metode</label>
                                        <x-inputs.select2
                                            id="audit_method_id"
                                            error="audit_method_id"
                                            wire:model="audit_method_id">
                                            @foreach($availableMethods as $method)
                                                <option value="{{$method->id}}">{{$method->name}}</option>
                                            @endforeach
                                        </x-inputs.select2>
                                    </div>
                                    <div class="row form-group">
                                        <label for="sample" class="col col-form-label d-flex flex-column">Sampel</label>
                                        <x-inputs.texteditor-custom
                                            wire:model="sample"
                                            id="sample"
                                            placeholder="Sampel Audit"
                                            error="sample"/>
                                    </div><!-- /.form-group keterangan -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel
                            </button>
                            <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                    wire:loading.remove wire:target='save'
                                    type="submit">
                                @lang('global.save')
                            </button>
                            <x-button-spinner
                                target="save"
                                :text="trans('global.processing')"></x-button-spinner>
                        </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

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

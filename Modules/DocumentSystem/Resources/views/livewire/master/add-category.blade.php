<div>
    <div class="modal fade" wire:ignore.self id="modalForm" tabindex="-1" aria-labelledby="modalForm"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveData' wire:ignore.self id="form-category"  x-on:submit="
        document.getElementById('btn-save-spinner').classList.remove('d-none');
        document.getElementById('btn-save-label').classList.add('d-none');
        document.getElementById('btn-save-category').disabled = true;
    ">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">@lang('global.add_category')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="module_id" class="form-label">@lang('global.module')</label>
                            <x-document-system-select-2-custom wire:model="module_id" wire:key="select2-module-id"
                                error="module_id" id="module_id" parent="modalForm"
                                placeholder="{{ trans('global.select_module') }}">

                                @foreach ($modules as $key => $module)
                                    <option value="{{ $module['id'] }}">{{ $module['index'] }}. {{ $module['name'] }}
                                    </option>
                                @endforeach

                            </x-document-system-select-2-custom>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Index</label>
                            <x-inputs.text wire:model="category_index" :id="'category_index'" :error="'category_index'"
                                placeholder="Index"></x-inputs.text>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">@lang('global.name')</label>
                            <x-inputs.text wire:model="name" :id="'name'" :error="'name'"
                                placeholder="{{ __('global.insert_name') }}"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="footer-action mb-2">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                              <button
    class="btn btn-outline-default bg-green d-flex justify-content-center align-items-center gap-2 text-white position-relative px-4"
    id="btn-save-category"
    type="submit">
    <span id="btn-save-spinner" class="d-none d-flex align-items-center gap-2">
        <span class="spinner-border spinner-border-sm text-white" role="status"></span>
        @lang('global.processing')
    </span>
    <span id="btn-save-label">
        @lang('global.save')
    </span>
</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

<div>
    <div class="modal fade" wire:ignore.self id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveData' wire:ignore.self id="form-module">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">@lang('global.add_module')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="name" class="form-label">Index</label>
                            <x-inputs.text wire:model="module_index" :id="'module_index'" :error="'module_index'"
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
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    wire:loading.remove wire:target='saveData' type="submit">
                                    @lang('global.save')
                                </button>
                                <x-button-spinner target="saveData" :text="trans('global.processing')"></x-button-spinner>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

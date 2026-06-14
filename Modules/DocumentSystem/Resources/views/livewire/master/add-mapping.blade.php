<div>
    <div class="modal fade" wire:ignore.self id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveData' wire:ignore.self id="form-mapping">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">@lang('global.add_category')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">@lang('global.category')</label>
                            <x-document-system-select-2 wire:model="category_id" error="category_id" id="category_id"
                                parent="modalForm" placeholder="{{ trans('global.select_category') }}">

                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category['id'] }}">{{ $category['index'] }}.
                                        {{ $category['name'] }} -
                                        {{ $category->module->name }}</option>
                                @endforeach

                            </x-document-system-select-2>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Index</label>
                            <x-inputs.text wire:model="mapping_index" :id="'mapping_index'" :error="'mapping_index'"
                                placeholder="Insert Index"></x-inputs.text>
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

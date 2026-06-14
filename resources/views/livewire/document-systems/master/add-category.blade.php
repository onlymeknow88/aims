<div>
    <div class="modal fade" wire:ignore.self id="modalForm" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveData' wire:ignore.self id="form-category">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">@lang('global.add_category')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="module_id" class="form-label">@lang('global.module')</label>
                            <x-inputs.select2 wire:model="module_id" error="module_id" id="module_id" parent="modalForm" placeholder="{{ trans('global.select_module') }}">

                                @foreach ($modules as $key => $module)
                                <option value="{{ $module['id'] }}">{{$module['name']}}</option>
                                @endforeach

                            </x-inputs.select2>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-label">@lang('global.name')</label>
                            <x-inputs.text wire:model="name"
                                :id="'name'"
                                :error="'name'"
                                placeholder="{{ __('global.insert_name') }}"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-basic-green text-white"
                            wire:loading.remove
                            wire:target='saveData'
                            type="submit">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveData"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

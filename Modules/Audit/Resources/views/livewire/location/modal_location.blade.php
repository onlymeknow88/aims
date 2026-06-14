<div>
    <div class="modal fade" wire:ignore.self id="modalFormLocation" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveLocation' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Lokasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-3">
                            <label for="location">Nama Lokasi</label>
                            <x-inputs.text id="location" wire:model="location" autocomplete="off" error="location"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveLocation'
                                type="button" wire:click="saveLocation">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveLocation"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

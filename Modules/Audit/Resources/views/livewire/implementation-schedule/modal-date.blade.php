<div>
    <div class="modal fade" wire:ignore.self id="modalDate" tabindex="-1" aria-labelledby="modalDate"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveScheduleDate' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Implementation Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <x-inputs.datepicker id="date" wire:model="date" error="date">

                            </x-inputs.datepicker>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveScheduleDate'
                                type="button" wire:click="saveScheduleDate">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveScheduleDate"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

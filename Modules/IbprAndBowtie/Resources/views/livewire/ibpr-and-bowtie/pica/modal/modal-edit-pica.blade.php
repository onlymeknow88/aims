


<!-- Modal PICA-->
<div wire:ignore.self class="modal fade" id="modal_pica_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_pica_editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <div class="modal-title" id="modal_pica_editLabel">PICA</div>
        <button class="" data-bs-dismiss="modal" onclick="closeModalPica()" aria-label="Close">X</button>
        </div>
        <div class="modal-body px-4">
            <div class="grid grid-cols-1 gap-y-4">

                <div class="mb-3 row form-group">
                    <label for="plan" class="col-sm-4 col-form-label flex">Rencana

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text wire:model="plan"
                            wire:model="plan"
                            id="plan"
                            :error="'plan'"
                            placeholder="Rencana"/>
                    </div>
                </div>

                <div class="mb-3 row form-group ">
                    <label for="review_date" class="col-sm-4 col-form-label flex">Tanggal Direview

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.datepicker
                            placeholder="Tanggal diajukan"
                            wire:model="review_date"
                            id="review_date"
                            :error="'review_date'"/>
                    </div>
                </div>

                <div class="mb-3 row form-group ">
                    <label for="target_date" class="col-sm-4 col-form-label flex">Tanggal Target

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.datepicker
                            placeholder="Tanggal Target"
                            wire:model="target_date"
                            id="target_date"
                            :error="'target_date'"/>
                    </div>
                </div>

                <div class="mb-3 row form-group ">
                     <label for="review_date" class="col-sm-4 col-form-label flex">Lampiran

                    </label>
                    <div class="col-sm-8">
                    <div class="grid grid-cols-1 gap-y-2 w-[full items-start" >
                        <label>
                            <div class="w-full !border !border-[#ced4da] rounded-md h-[40px] px-3 flex items-center cursor-pointer">
                                <p class="text-gray-500 text-sm">
                                    <!--  -->
                                </p>
                            </div>
                            <input type="file" wire:model="attachment" id="attachment" placeholder="Lampiran" class="hidden">
                        </label>
                    </div>
                    </div>
                </div>

                <div class="mb-3 row form-group ">
                    <label for="review_date" class="col-sm-4 col-form-label flex">Status
                       <span class="ml-2">
                           <img src="{{ asset('./images/icons/info.png') }}" alt="info">
                       </span>
                   </label>
                   <div class="col-sm-8">
                        <select
                                wire:model="status"
                                class="form-select w-100"
                                id="status"
                                placeholder="Status"
                                :error="'status'"

                                >
                                <option>Select</option>
                                <option value="Open">Open</option>
                                <option value="Outstanding">Outstanding</option>
                                <option value="Close">Close</option>
                        </select>
                    </div>
                </div>

            <br />
            </div>
        <hr />
        <br />
        <div class="modal-footer footer-action">
            <div class="flex w-full justify-end gap-3">
                <button onclick="closeModalPica()" type="button" class="btn btn-outline-secondary">
                    Cancel
                </button>

                <button type="button" wire:click="submit_edit" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                    Save
                </button>
            </div>
        </div>
    </div>
    </div>
</div>
</div>


@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        function closeModalPica() {
            $('#modal_pica_edit').modal('hide');
        }

        Livewire.on('openModalPica', () => {
            $('#modal_pica_edit').modal('show');
        });

        Livewire.on('closeModalPica', () => {
            $('#modal_pica_edit').modal('hide');
        });
    </script>
@endpush

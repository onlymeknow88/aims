@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div>

<!-- Modal LossCallculation Standard-->
<div wire:ignore.self class="modal fade" id="modal_loss_calculation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_loss_calculationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <div class="modal-title" id="modal_loss_calculationLabel">Loss Callculation</div>
        <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body px-4">
            <div class="flex">
                <div class="w-[20%] items-start">
                <div class="flex items-center">
                        <p class="text-sm font-[400]">Event</p>
                        <span class="text-red-600">*</span>
                </div>
                </div>
                <div class="grid grid-cols-1 gap-y-2 w-[80%] items-start" >
                    <x-ibprandbowtie-select-2
                            id="event_id"
                            placeholder="Pilih Event"
                            :error="'event_id'"
                            wire:model="event_id">
                            @foreach ($event as $index => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </x-ibprandbowtie-select-2>
                </div>
            </div>
            <!-- <div class="mb-3">
                <p wire:click="add_detail" class="cursor-pointer text-xs font-semibold text-blue-700 mt-4 duration-500 hover:text-sm">Tambah Detail</p>
            </div> -->

            <br>
            <hr />
            <div>
                @foreach($details as $index => $detail)
                    <div class="flex py-3">
                        <div class="w-[20%] flex items-center">
                            <p class="text-sm font-[400]">Detail {{ $index + 1 }}</p>
                        </div>
                        <div class="w-[70%] flex gap-5">
                            <div class="w-full items-start" >
                               <input type="text" class="form-control" value="{{ $detail['name'] }}" placeholder="Nama Detail" onchange="changeDetailName(this.value, {{ $index }})">
                            </div>
                            <div class="w-full items-start" >
                                <input type="number" class="form-control currency-input" value="{{ $detail['amount'] }}"  placeholder="Jumlah IDR" onchange="changeDetailAmount(this.value, {{ $index }})"/>
                            </div>
                            <div class="w-full items-start" >
                                <input type="text" readonly class="form-control currency-input" value="{{  number_format($detail['amount'] / 14000, 2)}}"  placeholder="Jumlah USD"/>
                            </div>
                        </div>
                        <div class="flex justify-end w-[10%]">
                            <button wire:click="remove_detail({{$index}})" type="btnbutton" class="h-8 bg-red-500 rounded-md w-10">X</button>
                        </div>
                    </div>
                @endForeach
            </div>

            <div class="add_loop">
                <button type="button" class="btn btn-outline-success d-block" wire:click="add_detail">+ Add
                </button>
            </div>
            <br />
        <hr />
        <br />
        <div class="modal-footer">
            <div class="flex w-full justify-end gap-3">
                <button onclick="closeModalLossCallculation()" type="button" class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                    Cancel
                </button>

                @if($is_edit === false)
                <button type="button" wire:click="submit" wire:loading.remove class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                    Add
                </button>
                @else
                <button type="button" wire:click="submit_edit" wire:loading.remove class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                    Save
                </button>
                @endif
            </div>
        </div>
    </div>
    </div>
</div>
</div>


@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>

        function changeDetailAmount(value, index) {
            Livewire.emit('change_detail_amount', Number(value), index);
        }

        function changeDetailName(value, index) {
            Livewire.emit('change_detail_name', value, index);
        }

        $('#modal_loss_calculation').on('show.bs.modal', function (e) {
            Livewire.emit('check_event_loss_callculation');
        });

   
        function openModalLossCallculation() {
            $('#modal_loss_calculation').modal('show');
        }

        function closeModalLossCallculation() {
            $('#modal_loss_calculation').modal('hide');
        }

        function openModalEditLostCallculation(id){
            Livewire.emit('click_edit_lost_callculation', id)
        }

        Livewire.on('openModalLossCallculation', () => {
            $('#modal_loss_calculation').modal('show');
        });

        Livewire.on('closeModalLossCallculation', () => {
            $('#modal_loss_calculation').modal('hide');
        });

    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div>

    <!-- Modal CCA-->
    <div wire:ignore.self class="modal fade" id="modal_cca" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modal_ccaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal_ccaLabel">CCA</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body px-4">
                    <div class="grid grid-cols-1 gap-y-4">

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tujuan pengendalian</p>
                                    <span class="text-red-600">*</span>

                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.select2 wire:model="control_objectives" class="form-select w-100"
                                    id="control_objectives" {{-- placeholder="Tujuan pengendalian" --}} :error="'control_objectives'">
                                    {{-- <option>Select</option> --}}
                                    <option value="Pencegahan">Pencegahan</option>
                                    <option value="Mitigasi">Mitigasi</option>
                                </x-inputs.select2>
                            </div>
                        </div>


                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Hubungan dengan Kejadian Risiko</p>
                                    {{-- modif JSON --}}
                                    <span class="text-red-600">*</span>

                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                {{-- slect nya jadi multiple --}}
                                {{-- <textarea wire:model="event_id"></textarea> --}}
                                <x-inputs.select2_multiple wire:model="event_id" class="form-select w-100"
                                    id="event_id" {{-- placeholder="Hubungan dengan Kejadian Risiko" --}} :error="'event_id'">
                                    @foreach ($event as $index => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </x-inputs.select2_multiple>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Penjelasan Pengendalian</p>
                                    {{-- diganti select, mengambil data dari tabel pengendalian/mitigasu nya --}}
                                    <span class="text-red-600">*</span>

                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.select2 wire:model="control_explanation" class="form-select w-100"
                                    id="control_explanation" {{-- placeholder="Penjelasan Pengendalian" --}} :error="'control_explanation'">

                                    @foreach ($this->EventControlExplanation as $index => $item)
                                        <option
                                            value="{{ $item->critical_control ? $item->critical_control : $item->mitigation_critical }}">
                                            {{-- <option value="{{ $item->id }}"> --}}
                                            {{-- {{ $item->name }} : --}}
                                            {{ $item->critical_control ? $item->critical_control : $item->mitigation_critical }}
                                        </option>
                                    @endforeach
                                </x-inputs.select2>

                                {{-- <x-inputs.textarea wire:model.defer="control_explanation" id="control_explanation"
                                    rows="3" error="'control_explanation'" placeholder="Penjelasan Pengendalian">
                                </x-inputs.textarea> --}}
                            </div>
                        </div>

                        <br />
                        <hr />

                        <div>
                            <p class="text-lg">Proses Penilaian Pengendilan Kritis (Critical Control Assessment Process)
                            </p>
                        </div>
                        <br />

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 1: Apakah pengendalian mencegah, mendeteksi
                                        atau mitigasi risiko kritis?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_one" class="form-select w-100" id="step_one"
                                    placeholder="Person In Control" :error="'step_one'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 2: Apakah mencegah terjadinya insiden?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_two" class="form-select w-100" id="step_two"
                                    placeholder="Person In Control" :error="'step_two'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 3: Apakah pengendalian mendeteksi atau
                                        mencegah eskalasi kejadian?</p>

                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_three" class="form-select w-100" id="step_three"
                                    placeholder="Person In Control" :error="'step_three'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 4: Apakah pengendalian adalah penghalang untuk
                                        mencegah terjadinya insiden?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_four" class="form-select w-100" id="step_four"
                                    placeholder="Person In Control" :error="'step_four'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 5: Apakah pengendalian digunakan untuk
                                        mencegah, mendeteksi, atau mitigasi terhadapa beberapa ancaman/ dampak?</p>

                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_five" class="form-select w-100" id="step_five"
                                    placeholder="Person In Control" :error="'step_five'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        <div class="flex">
                            <div class="w-[80%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Langkah 6: Apakah pengendalian tidak tergantung dari
                                        pengendalian lain?</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                <select wire:model="step_six" class="form-select w-100" id="step_six"
                                    placeholder="Person In Control" :error="'step_six'">
                                    <option>Select</option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>

                        </div>

                        {{-- @if ($step_four == 'Ya' || $step_five == 'Ya' || $step_six == 'Ya')
                            <div class="flex">
                                <div class="w-[80%] items-start">
                                    <div class="flex items-center">
                                        <p class="text-sm font-[400]">Apakah pengendalian adalah Pengendalian Kritis?
                                        </p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                    <select wire:model="step_seven" class="form-select w-100" id="step_seven"
                                        placeholder="Person In Control" :error="'step_seven'">
                                        <option>Select</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                        <option value="N/A">N/A</option>
                                    </select>
                                </div>

                            </div>
                        @endif --}}
                        <br />

                        @if ($step_four == 'Ya' || $step_five == 'Ya' || $step_six == 'Ya')

                            <hr />

                            <div>
                                <p class="text-lg">Risk control data base</p>
                            </div>
                            <br />

                            <div class="flex">
                                <div class="w-[80%] items-start">
                                    <div class="flex items-center">
                                        <p class="text-sm font-[400]">Regulasi Pengendalian</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[20%] items-start">
                                    <select wire:model="control_regulation" class="form-select w-100"
                                        id="control_regulation" placeholder="Person In Control"
                                        :error="'control_regulation'">
                                        <option>Select</option>
                                        @foreach ($hirarkis as $hirarki)
                                            <option value="{{ $hirarki->name }}">{{ $hirarki->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        @endif

                        <div class="flex">
                            <div class="w-[60%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Nomor Identitas Pengendalian </p>
                                </div>
                            </div>
                            <div class="flex justify-end gap-y-2 w-[40%] items-start">
                                <p class="text-right w-full text-sm font-bold">{{ $number }}</p>
                            </div>

                        </div>

                        <br />
                    </div>
                    <hr />
                    <br />
                    <div class="modal-footer">
                        <div class="flex w-full justify-end gap-3">
                            <button onclick="closeModalCca()" type="button"
                                class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                                Cancel
                            </button>

                            @if ($is_edit === false)
                                <button type="button" wire:click="submit" wire:loading.remove
                                    class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                                    Add
                                </button>
                            @else
                                <button type="button" wire:click="submit_edit" wire:loading.remove
                                    class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
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
            $('#modal_cca').on('show.bs.modal', function(e) {
                let val = $('#document_no').val();
                Livewire.emit('check_event_on_cca', val);
            });

            function closeModalCca() {
                $('#modal_cca').modal('hide');
            }

            Livewire.on('openModalCca', () => {
                $('#modal_cca').modal('show');
            });

            Livewire.on('closeModalCCa', () => {
                $('#modal_cca').modal('hide');
            });
            window.addEventListener('updateSelect2', event => {
                $('#event_id').val(event.detail.event_id);
                $('#event_id').trigger('change');
            })
        </script>
    @endpush

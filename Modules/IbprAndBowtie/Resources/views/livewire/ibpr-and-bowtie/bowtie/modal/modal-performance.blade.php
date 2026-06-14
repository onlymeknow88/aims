@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

<div>

<!-- Modal Performance Standard-->
<div wire:ignore.self class="modal fade" id="modal_performance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_performanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <div class="modal-title" id="modal_performanceLabel">Performance Standard</div>
        <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body px-4">
            <div class="grid grid-cols-1 gap-y-4">

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">No ID</p>

                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <p class="font-bold text-sm">{{ $number }}</p>
                    </div>
                </div>

                <br />

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Bowtie CCA</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                            <x-ibprandbowtie-select-2
                                id="cca_id"
                                placeholder="Pilih CCA"
                                :error="'cca_id'"
                                wire:model="cca_id">
                                @foreach ($cca as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->number }}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Penjelasan Pengendalian</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.text
                            wire:model.defer="name"
                            id="name"
                            error="'name'"
                            placeholder="Penjelasan Pengendalian"
                        />
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Penanggung Jawab Pengendalian </p><span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.text
                            wire:model.defer="responsible_person"
                            id="responsible_person"
                            error="'responsible_person'"
                            placeholder="Penanggung Jawab Pengendalian"
                        />
                    </div>
                </div>

                <!-- <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Department</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-ibprandbowtie-select-2
                                id="department_id"
                                placeholder="Pilih Department"
                                :error="'department_id'"
                                wire:model="department_id">
                                @foreach ($departments as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </x-ibprandbowtie-select-2>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Section</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-ibprandbowtie-select-2
                                id="section_id"
                                placeholder="Section"
                                :error="'section_id'"
                                wire:model="section_id">
                                    @foreach ($sections as $index => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                            </x-ibprandbowtie-select-2>
                    </div>
                </div> -->

                <!-- <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Explanation</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.textarea
                            wire:model.defer="description"
                            id="description"
                            rows="3"
                            error="'description'"
                            placeholder="Description">
                        </x-inputs.textarea>
                    </div>
                </div> -->

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Tujuan Pengendalian</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.text
                            wire:model.defer="purpose"
                            id="purpose"
                            error="'purpose'"
                            placeholder="Tujuan Pengendalian"
                        />
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Standar Kinerja Pengendalian Risiko Utama</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.textarea
                            wire:model.defer="design_standard"
                            id="design_standard"
                            rows="3"
                            error="'design_standard'"
                            placeholder="Standar Kinerja Pengendalian Risiko Utama">
                        </x-inputs.textarea>
                    </div>
                </div>

                <!-- <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Operational Standard</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.textarea
                            wire:model.defer="operation_standard"
                            id="operation_standard"
                            rows="3"
                            error="'operation_standard'"
                            placeholder="Operational Standard">
                        </x-inputs.textarea>
                    </div>
                </div> -->

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Kegiatan Verifikasi</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.textarea
                            wire:model.defer="ospek"
                            id="ospek"
                            rows="3"
                            error="'ospek'"
                            placeholder="Operation Activity (OSPEK)">
                        </x-inputs.textarea>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Bukti Verifikasi</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <label>
                            <div class="w-full !border !border-[#ced4da] rounded-md h-[40px] px-3 flex items-center cursor-pointer">
                                <p class="text-gray-500 text-sm">
                                    @if(isset($obesrvation_file) && !is_string($obesrvation_file))
                                        {{ $obesrvation_file->getClientOriginalName() }}
                                     @elseif(isset($obesrvation_file) && is_string($obesrvation_file))
                                        {{ $obesrvation_file_name }}
                                    @else
                                        Input file
                                    @endif
                                </p>
                            </div>
                            <input type="file" wire:model="obesrvation_file" id="obesrvation_file" placeholder="Operation Activity (OSPEK)" class="hidden">
                            @error('obesrvation_file')
                                <div style="color:red" class="">
                                    {{ $message }}
                                </div>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Pelaksanaan Verifikasi </p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-ibprandbowtie-select-2
                                id="obesrvation"
                                placeholder=""
                                {{-- placeholder="Section" --}}
                                :error="'obesrvation'"
                                wire:model="obesrvation">
                                    {{-- <option value="Harian">Harian</option> --}}
                                    <option value="Mingguan">Mingguan</option>
                                    <option value="Bulanan">Bulanan</option>
                                    <option value="3 Bulanan">3 Bulanan</option>
                                </x-ibprandbowtie-select-2>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Kegiatan pengetesan efektivitas</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-inputs.text
                            wire:model.defer="effectiveness_testing_activities"
                            id="effectiveness_testing_activities"
                            error="'effectiveness_testing_activities'"
                            placeholder="Kegiatan pengetesan efektivitas"
                        />
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Pengetesan efektifitas pengendalian kritis</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        {{-- <x-inputs.upload-files :docs="$test_efectivity_file" id="test_efectivity_file" :error="'test_efectivity_file'" /> --}}
                        <label>
                            <div class="w-full !border !border-[#ced4da] rounded-md h-[40px] px-3 flex items-center cursor-pointer">
                                <p class="text-gray-500 text-sm">
                                    @if(isset($test_efectivity_file) && !is_string($test_efectivity_file))
                                        {{ $test_efectivity_file->getClientOriginalName() ?? '-' }}
                                    @elseif(isset($test_efectivity_file) && is_string($test_efectivity_file))
                                        {{ $test_efectivity_file_name }}
                                    @else
                                        Input file
                                    @endif
                                </p>
                            </div>
                            <input type="file" wire:model="test_efectivity_file" id="test_efectivity_file" placeholder="Operation Activity (OSPEK)" class="hidden">
                            @error('test_efectivity_file')
                                <div style="color:red" class="">
                                    {{ $message }}
                                </div>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="flex">
                    <div class="w-[35%] items-start">
                    <div class="flex items-center">
                            <p class="text-sm font-[400]">Pelaksanaan Pengetesan Efektifitas Pengendalian</p>
                            <span class="text-red-600">*</span>
                    </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start" >
                        <x-ibprandbowtie-select-2
                                id="implementation_test_efectivity"
                                placeholder=""
                                {{-- placeholder="Section" --}}
                                :error="'implementation_test_efectivity'"
                                wire:model="implementation_test_efectivity">
                                    {{-- <option value="Harian">Harian</option> --}}
                                    <option value="Mingguan">Mingguan</option>
                                    <option value="Bulanan">Bulanan</option>
                                    <option value="3 Bulanan">3 Bulanan</option>
                                </x-ibprandbowtie-select-2>
                    </div>
                </div>
        <br />
        </div>
        <hr />
        <br />
        <div class="modal-footer">
            <div class="flex w-full justify-end gap-3">
                <button onclick="closeModalPerformance()" type="button" class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
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

        function openModalPerformance() {
            $('#modal_performance').modal('show');
        }

        function closeModalPerformance() {
            $('#modal_performance').modal('hide');
        }

        Livewire.on('openModalPerformance', () => {
            $('#modal_performance').modal('show');
        });

        Livewire.on('closeModalPerformance', () => {
            $('#modal_performance').modal('hide');
        });


        $('#modal_performance').on('show.bs.modal', function (e) {
            Livewire.emit('check_document_number');
            Livewire.emit('check_cca');
        });

    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.sent', (message, component) => {

                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0],
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0] + ' Success',
                        timer: 2000,
                    });
                }

            })

        });

    </script>
@endpush

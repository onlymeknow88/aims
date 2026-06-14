@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.tailwindcss.com"></script>
@endpush
<div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="staticBackdropLabel">New BOWTIE Event</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="grid grid-cols-1 gap-y-5">
                            <!-- <div class="flex">
                        <div class="w-[35%] items-center">
                            <p class="font-[700] text-sm">Nama Form</p>
                        </div>
                        <div class="w-[65%] items-center">
                            <p class="font-[700] text-sm">EVENT 1</p>
                        </div>
                    </div> -->
                            <div class="flex">
                                <div class="w-[35%] items-start">
                                    <div class="flex items-center">
                                        <p class="text-sm font-[400]">Penjelasan</p>
                                        <span class="text-red-600">*</span>

                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    {{-- <div>
                                <x-inputs.text
                                    wire:model.defer="risk_title"
                                    id="risk_title"
                                    error="'risk_title'"
                                    placeholder="Main of Risk"
                                />
                            </div> --}}
                                    <div>
                                        <x-inputs.textarea wire:model.defer="description" id="description"
                                            rows="3" error="'description'" placeholder="Description">
                                        </x-inputs.textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- <span class="mb-0 mt-0 text-[12px] font-bold text-blue-700 cursor-pointer duration-500 hover:scale-105 hover:ml-4" wire:click="addReasons()">Tambah Reason</span> -->
                            <div class="flex -mt-3">
                                <div class="w-[35%] items-start">
                                    <div class="flex items-center">
                                        <p class="text-sm font-[400]">Penyebab</p>
                                        {{-- berefek pada jumlah form tindakan pencegahan, penyebab 3 form tipe dampak juga 3 dst --}}
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    @foreach ($reasons as $index => $reason)
                                        <div class="row">

                                            <div class="col-10">
                                                <input type="text" class="form-control" value="{{ $reason['name'] }}"
                                                    placeholder="Penyebab"
                                                    onchange="changeReason(this.value, {{ $index }})">
                                            </div>
                                            <div class="col-2">
                                                @if ($index > 0)
                                                    <a style="
                                                    align: center;"
                                                        href="#" wire:click="remove_reason({{ $index }})"
                                                        class="action-icon m-1">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="add_loop">
                                <button type="button" class="btn btn-outline-success d-block"
                                    wire:click="addReasons()">+ Tambah Penyebab
                                </button>
                            </div>

                            <div>
                                <p class="text-sm font-semibold">Tipe Dampak</p>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Keselamatan Dan Kesehatan Kerja (K3)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="impact_k3" id="impact_k3" error="'impact_k3'"
                                        placeholder="Keselamatan Dan Kesehatan Kerja (K3)" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">Lingkungan Hidup (LH)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="impact_lh" id="impact_lh" error="'impact_lh'"
                                        placeholder="Lingkungan Hidup (LH)" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">Komunitas Sosial Lokal (KSL)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="impact_ksl" id="impact_ksl" error="'impact_ksl'"
                                        placeholder="Komunitas Sosial Lokal (KSL)" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Kepatuhan Terhadap Peraturan (KP)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="impact_kp" id="impact_kp" error="'impact_kp'"
                                        placeholder="Kepatuhan Terhadap Peraturan (KP)" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Kerugian Keuangan (KK)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="impact_kk" id="impact_kk" error="'impact_kk'"
                                        placeholder="Kerugian Keuangan (KK)" />
                                </div>
                            </div>

                            <hr />

                            <div>
                                <p class="font-semibold text-lg">Tindakan Pencegahan</p>
                            </div>

                            <div class="loop-element d-flex flex-column gap-5">

                                @foreach ($control_measure_form as $index => $cms)
                                    <div class="items-loop row">
                                        <div>
                                            <p class="font-semibold">{{ $reasons[$index]['name'] }}</p>
                                        </div>
                                        <div class="col-12 d-flex flex-column gap-3">
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tindakan Kendali
                                                    Pencegahan</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $cms['control_measures'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <!-- <button type="button" class="btn btn-danger btn-small"
                                                            wire:click="remove_cms({{ $index }})">&times;
                                                    </button> -->
                                                            {{-- <a href="#"
                                                                wire:click="remove_cms({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-trash"></i>
                                                            </a> --}}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Kaitan dengan
                                                    penyebab</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $cms['associated_with_cause'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <a href="#"
                                                                wire:click="edit_cms({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Kendali
                                                    Kritikal</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $cms['critical_control'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Penanggung Jawab
                                                    Kendali</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $cms['person_in_control'] ?? '-' }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="add_loop">
                            <button type="button" class="btn btn-outline-success d-block" onclick="openCmfModal()">+ Add
                            </button>
                        </div> --}}


                                {{-- @foreach ($control_measure_form as $index => $cms)
                        <div class="p-2 rounded-md bg-blue-500 w-full relative mb-2">
                            <button type="button" wire:click="remove_cms({{$index}})" class="absolute top-0 right-0 pt-1 pr-2 duration-300 hover:scale-105 text-gray-200 text-xl">
                                X
                            </button>
                            <div>
                                <p class="text-white font-semibold">{{ $cms['associated_with_cause'] }} - {{ $cms['critical_control'] }}</p>
                            </div>
                        </div>

                        @endForeach
                        <button type="button" onclick="openCmfModal()" class="rounded-sm border-2 !border-dashed !border-blue-500 w-full flex items-center justify-center">
                            <p class="text-blue-500 font-bold text-3xl">+</p>
                        </button> --}}

                            </div>

                            <div>
                                <p class="font-semibold text-lg">Tugas Perbaikan</p>
                            </div>
                            {{-- ketika tindakan pencegahan dan mitigasu sudah dibuat, form tugas perbaikan juga otomatis dibuat tapi kosong dan bisa diedit --}}
                            <div class="loop-element d-flex flex-column gap-5">
                                @foreach ($repair_tasks as $index => $rt)
                                    <div class="items-loop row">
                                        <div>
                                            <p class="font-semibold">{{ $reasons[$index]['name'] }}</p>
                                        </div>
                                        <div class="col-12 d-flex flex-column gap-3">
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tugas
                                                    Perbaikan</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['repair_task'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <!-- <button type="button" class="btn btn-danger btn-small"
                                                            wire:click="remove_repair_task({{ $index }})">&times;
                                                    </button> -->
                                                            {{-- <a href="#"
                                                                wire:click="remove_repair_task({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-trash"></i>
                                                            </a> --}}
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tgl. Tempo</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['due_date'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <a href="#"
                                                                wire:click="edit_repair_task({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Penanggung
                                                    Jawab</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['person_responsible'] ?? '-' }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tgl. Selesai</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['completion_date'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="add_loop">
                            <button type="button" class="btn btn-outline-success d-block" onclick="openRepairTaskModal()">+ Add
                            </button>
                        </div> --}}

                                {{-- @foreach ($repair_tasks as $index => $rt)
                        <div class="p-2 rounded-md bg-blue-500 w-full relative mb-2">
                            <button type="button" wire:click="remove_cms({{$index}})" class="absolute top-0 right-0 pt-1 pr-2 duration-300 hover:scale-105 text-gray-200 text-xl">
                                X
                            </button>
                            <div>
                                <p class="text-white font-semibold mb-2">{{ $rt['repair_task'] }} - {{ $rt['due_date'] }}</p>
                            </div>
                        </div>
                        @endForeach
                        <button type="button" onclick="openRepairTaskModal()" class="rounded-sm border-2 !border-dashed !border-blue-500 w-full flex items-center justify-center">
                            <p class="text-blue-500 font-bold text-3xl">+</p>
                        </button> --}}

                            </div>

                            <hr />

                            <div>
                                <p class="font-semibold text-lg">Tindakan Mitigasi Dampak Yang ada Saat Ini</p>
                            </div>

                            <div class="loop-element d-flex flex-column gap-5">
                                @foreach ($impact_mitigation_memasure as $index => $imm)
                                    <div class="items-loop row">
                                        {{-- <div>
                                            <p class="font-semibold">{{ $reasons[$index]['name'] }}</p>
                                        </div> --}}
                                        <div class="col-12 d-flex flex-column gap-3">
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tindakan Mitigasi
                                                    Dampak</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $imm['mitigation_measures'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <!-- <button type="button" class="btn btn-danger btn-small"
                                                            wire:click="remove_imm({{ $index }})">&times;
                                                    </button> -->
                                                            <a href="#"
                                                                wire:click="remove_imm({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Kaitan dengan
                                                    penyebab</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $imm['mitigation_associated_with_cause'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <a href="#"
                                                                wire:click="edit_imm({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Kendali
                                                    Kritikal</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $imm['mitigation_critical'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Penanggung
                                                    Jawab</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $imm['mitigation_person_in_control'] ?? '-' }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="add_loop">
                                    <button type="button" class="btn btn-outline-success d-block"
                                        onclick="openImmModal()">+ Add
                                    </button>
                                </div>

                                {{-- @foreach ($impact_mitigation_memasure as $index => $imm)
                        <div class="p-2 rounded-md bg-[#810DA8] w-full relative mb-2">
                            <button type="button" wire:click="remove_imm({{$index}})" class="absolute top-0 right-0 pt-1 pr-2 duration-300 hover:scale-105 text-gray-200 text-xl">
                                X
                            </button>
                            <div>
                                <p class="text-white font-semibold mb-2">{{ $imm['mitigation_associated_with_cause'] }} - {{ $imm['mitigation_critical'] }}</p>
                            </div>
                        </div>
                        @endForeach
                        <button type="button" onclick="openImmModal()" class="rounded-sm border-2 !border-dashed !border-[#810DA8] w-full flex items-center justify-center">
                            <p class="text-[#810DA8] font-bold text-3xl">+</p>
                        </button> --}}

                            </div>

                            <div>
                                <p class="font-semibold text-lg">Tugas Perbaikan</p>
                            </div>

                            <div class="loop-element d-flex flex-column gap-5">

                                @foreach ($mitigation_repair_tasks as $index => $rt)
                                    <div class="items-loop row">
                                        {{-- <div>
                                            <p class="font-semibold">{{ $reasons[$index]['name'] }}</p>
                                        </div> --}}
                                        <div class="col-12 d-flex flex-column gap-3">
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tugas
                                                    Perbaikan</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['repair_task'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <!-- <button type="button" class="btn btn-danger btn-small"
                                                            wire:click="remove_mitigation_repair_task({{ $index }})">&times;
                                                    </button> -->
                                                            <a href="#"
                                                                wire:click="remove_mitigation_repair_task({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tgl. Tempo</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['due_date'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">
                                                            <a href="#"
                                                                wire:click="edit_mitigation_repair_task({{ $index }})"
                                                                class="action-icon m-1">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Penanggung
                                                    Jawab</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['person_responsible'] ?? '-' }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="title" class="col col-form-label">Tgl. Selesai</label>
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <x-inputs.text id="role[{{ $loop->index }}]" disabled
                                                                error=""
                                                                value="{{ $rt['completion_date'] }}"></x-inputs.text>
                                                        </div>
                                                        <div class="col-2">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="add_loop">
                                    <button type="button" class="btn btn-outline-success d-block"
                                        onclick="openMitigationRepairTaskModal()">+ Add
                                    </button>
                                </div>

                                {{-- @foreach ($mitigation_repair_tasks as $index => $rt)
                        <div class="p-2 rounded-md bg-[#810DA8] w-full relative mb-2">
                            <button type="button" wire:click="remove_mitigation_repair_task({{$index}})" class="absolute top-0 right-0 pt-1 pr-2 duration-300 hover:scale-105 text-gray-200 text-xl">
                                X
                            </button>
                            <div>
                                <p class="text-white font-semibold mb-2">{{ $rt['repair_task'] }} - {{ $rt['due_date'] }}</p>
                            </div>
                        </div>
                        @endForeach
                        <button type="button" onclick="openMitigationRepairTaskModal()" class="rounded-sm border-2 !border-dashed !border-[#810DA8] w-full flex items-center justify-center">
                            <p class="text-[#810DA8] font-bold text-3xl">+</p>
                        </button> --}}

                            </div>

                            <div>
                                <p class="text-sm font-semibold">Kerugian Maksimal Semua Kendali Tidak Efektif</p>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Keselamatan Dan Kesehatan Kerja (K3)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-2 w-[65%] items-start gap-3">
                                    <x-inputs.text type="number" wire:model.defer="k3_severity" id="k3_severity"
                                        :error="'k3_severity'" placeholder="Keparahan" />
                                    <x-inputs.text wire:model.defer="k3_max_loss" id="k3_max_loss"
                                        error="'k3_max_loss'" placeholder="Kerugian Maximal" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">Lingkungan Hidup (LH)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text type="number" wire:model.defer="lh_severity" id="lh_severity"
                                        :error="'lh_severity'" placeholder="Keparahan" />
                                    <x-inputs.text wire:model.defer="lh_max_loss" id="lh_max_loss"
                                        error="'lh_max_loss'" placeholder="Kerugian Maximal" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">Komunitas Sosial Lokal (KSL)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text type="number" wire:model.defer="ksl_severity" id="ksl_severity"
                                        :error="'ksl_severity'" placeholder="Keparahan" />
                                    <x-inputs.text wire:model.defer="ksl_max_loss" id="ksl_max_loss"
                                        error="'ksl_max_loss'" placeholder="Kerugian Maximal" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Kepatuhan Terhadap Peraturan (KP)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text type="number" wire:model.defer="kp_severity" id="kp_severity"
                                        :error="'kp_severity'" placeholder="Keparahan" />
                                    <x-inputs.text wire:model.defer="kp_max_loss" id="kp_max_loss" :error="'kp_max_loss'"
                                        placeholder="Kerugian Maximal" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Kerugian Keuangan (KK)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text type="number" wire:model.defer="kk_severity" id="kk_severity"
                                        :error="'kk_severity'" placeholder="Keparahan" />
                                    <x-inputs.text wire:model.defer="kk_max_loss" id="kk_max_loss"
                                        error="'kk_max_loss'" placeholder="Kerugian Maximal" />
                                </div>
                            </div>

                            <div>
                                <p class="text-sm font-semibold">Tingkat Risiko Sisa Setelah Pengendalian</p>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-start w-[80%]">
                                        <p class="text-sm font-[400]">Keparahan (K)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-y-2 w-[65%] items-start gap-3">
                                    <x-inputs.text type="number" wire:model.defer="severity_factor"
                                        id="severity_factor" :error="'severity_factor'" placeholder="Faktor" />
                                    <x-inputs.text wire:model.defer="severity_explain" id="severity_explain"
                                        error="'severity_explain'" placeholder="Penjelasan" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">Kemungkinan (P)</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="likelihood_factor" id="likelihood_factor"
                                        :error="'likelihood_factor'" placeholder="Faktor" />
                                    <x-inputs.text wire:model.defer="likelihood_explain" id="likelihood_explain"
                                        error="'likelihood_explain'" placeholder="Penjelasan" />
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-[35%] items-center">
                                    <div class="flex items-center w-[80%]">
                                        <p class="text-sm font-[400]">TRR</p>
                                        <span class="text-red-600">*</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3 gap-y-2 w-[65%] items-start">
                                    <x-inputs.text wire:model.defer="trr_factor" id="trr_factor" :error="'trr_factor'"
                                        placeholder="Faktor" />
                                    <x-inputs.text wire:model.defer="trr_explanation" id="trr_explanation"
                                        error="'trr_explanation'" placeholder="Penjelasan" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <hr class="mt-4" />
                <div class="modal-footer">
                    <div class="w-full flex items-center justify-end gap-2">
                        <button type="button" onclick="closeModalPrimary()" class="btn btn-outline-secondary">
                            Batalkan
                        </button>
                        @if ($is_edit === false)
                            <button type="button" wire:click="submit" wire:loading.remove
                                class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                                Tambah
                            </button>
                        @else
                            <button type="button" wire:click="submit_edit" wire:loading.remove
                                class="flex cursor-pointer py-2 px-4 bg-[#088E52] text-white rounded-md duration-300 hover:scale-105">
                                Simpan
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal FCM -->
    <div wire:ignore.self class="modal fade" id="cmf" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="cmfLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="cmfLabel">Tindakan Pengendalian Form</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 gap-y-4">
                        <!-- <div class="flex mb-2">
                    <div class="w-[35%] items-center">
                        <p class="font-[700] text-sm">Nama</p>
                    </div>
                    <div class="w-[65%] items-center">
                        <p class="font-[700] text-sm">Tindakan Pengendalian {{ count($control_measure_form) + 1 }}</p>
                    </div>
                </div> -->

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tindakan Kendali Pencegahan <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="control_measures" id="control_measures" :error="'control_measures'"
                                    placeholder="Tindakan Kendali Pencegahan" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Kaitan dengan penyebab <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="associated_with_cause" id="associated_with_cause"
                                    :error="'associated_with_cause'" placeholder="Kaitan dengan penyebab" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Kendali Kritikal <span class="text-red-600">*</span>
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="critical_control" id="critical_control" :error="'critical_control'"
                                    placeholder="Kendali Kritikal" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Penanggung Jawab Kendali <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="person_in_control" id="person_in_control"
                                    :error="'person_in_control'" placeholder="Penanggung Jawab Kendali" />
                                <!-- <select
                                class="form-select w-100"
                                wire:ignore
                                id="person_in_control"
                                wire:model.defer="person_in_control"
                                placeholder="Person In Control"
                                :error="'person_in_control'"
                                >
                                <option>Select</option>
                                @foreach ($users as $key => $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
                        </select> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex w-full justify-end gap-3">
                        <button type="button" wire:loading.attr="disabled" onclick="closeCmfModal()"
                            class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                            Cancel
                        </button>
                        <button type="button" wire:loading.remove wire:click="add_cms()"
                            class="!border bg-[#088E52] rounded-md py-2 px-4 text-[13px] text-white duration-300 hover:scale-105">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Repair Task -->
    <div wire:ignore.self class="modal fade" id="repairTask" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="repairTaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="repairTaskLabel">Tugas Perbaikan Tindakan Pengendalian</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 gap-y-4">
                        <!-- <div class="flex mb-2">
                    <div class="w-[35%] items-center">
                        <p class="font-[700] text-sm">Name</p>
                    </div>
                    <div class="w-[65%] items-center">
                        <p class="font-[700] text-sm">Tugas Perbaikan Tindakan Pengendalian {{ count($repair_tasks) + 1 }}</p>
                    </div>
                </div> -->

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tugas Perbaikan</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="repair_task" id="repair_task" :error="'repair_task'"
                                    placeholder="Tugas Perbaikan" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tgl. Tempo</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                {{-- <x-inputs.date
                            wire:model="due_date"
                            id="due_date"
                            :error="'due_date'"
                            placeholder="Due Date"
                        /> --}}
                                <input type="date" class="form-control" id="due_date" wire:model="due_date"
                                    placeholder="Due Date" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Penanggung Jawab</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="person_responsible" id="person_responsible"
                                    :error="'person_responsible'" placeholder="Penanggung Jawab" />
                                <!-- <select
                                class="form-select w-100"
                                wire:ignore
                                id="person_responsible"
                                wire:model.defer="person_responsible"
                                placeholder="Person In Control"
                                :error="'person_responsible'"
                                >
                                <option>Select</option>
                                @foreach ($users as $key => $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
                        </select> -->
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tgl. Selesai</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                {{-- <x-inputs.date
                            wire:model="completion_date"
                            id="completion_date"
                            :error="'completion_date'"
                            placeholder="Completion Date"
                        /> --}}
                                <input type="date" class="form-control" id="completion_date"
                                    wire:model="completion_date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex w-full justify-end gap-3">
                        <button type="button" wire:loading.attr="disabled"
                            onclick="mitigationCloseRepairTaskModal()"
                            class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                            Cancel
                        </button>
                        <button type="button" wire:loading.remove wire:click="add_repairTask()"
                            class="!border bg-[#088E52] rounded-md py-2 px-4 text-[13px] text-white duration-300 hover:scale-105">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal IMM -->
    <div wire:ignore.self class="modal fade" id="imm" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="immLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="immLabel">Tindakan Mitigasi Dampak Yang ada Saat Ini</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 gap-y-4">
                        <!-- <div class="flex mb-2">
                    <div class="w-[35%] items-center">
                        <p class="font-[700] text-sm">Name</p>
                    </div>
                    <div class="w-[65%] items-center">
                        <p class="font-[700] text-sm">Impact Mitigation Measure {{ count($impact_mitigation_memasure) + 1 }}</p>
                    </div>
                </div> -->

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tindakan Mitigasi Dampak <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="mitigation_measures" id="mitigation_measures"
                                    :error="'mitigation_measures'" placeholder="Tindakan Mitigasi Dampak" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Kaitan dengan penyebab <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="mitigation_associated_with_cause"
                                    id="mitigation_associated_with_cause" :error="'mitigation_associated_with_cause'"
                                    placeholder="Kaitan dengan penyebab" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">MITIGASI KRITIKAL <span
                                            class="text-red-600">*</span></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="mitigation_critical" id="mitigation_critical"
                                    :error="'mitigation_critical'" placeholder="Kendali Kritikal" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Penanggung Jawab <span class="text-red-600">*</span>
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="mitigation_person_in_control"
                                    id="mitigation_person_in_control" :error="'mitigation_person_in_control'"
                                    placeholder="Penanggung Jawab" />
                                <!-- <select
                                class="form-select w-100"
                                wire:ignore
                                id="mitigation_person_in_control"
                                wire:model.defer="mitigation_person_in_control"
                                placeholder="Person In Control"
                                :error="'mitigation_person_in_control'"
                                >
                                <option>Select</option>
                                @foreach ($users as $key => $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
                        </select> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex w-full justify-end gap-3">
                        <button type="button" wire:loading.attr="disabled" onclick="closeImmModal()"
                            class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                            Cancel
                        </button>
                        <button type="button" wire:loading.remove wire:click="add_imm()"
                            class="!border bg-[#088E52] rounded-md py-2 px-4 text-[13px] text-white duration-300 hover:scale-105">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Repair Task -->
    <div wire:ignore.self class="modal fade" id="mitigation_repairTask" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="mitigation_repairTaskLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="mitigation_repairTaskLabel">Tugas Perbaikan</div>
                    <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="grid grid-cols-1 gap-y-4">
                        <!-- <div class="flex mb-2">
                    <div class="w-[35%] items-center">
                        <p class="font-[700] text-sm">Name</p>
                    </div>
                    <div class="w-[65%] items-center">
                        <p class="font-[700] text-sm">Impact Mitigation Repair Task {{ count($mitigation_repair_tasks) + 1 }}</p>
                    </div>
                </div> -->

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Tugas Perbaikan</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="repair_task" id="repair_task" :error="'repair_task'"
                                    placeholder="Tugas Perbaikan" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Due Date</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                {{-- <x-inputs.date
                            wire:model="due_date"
                            id="due_date"
                            :error="'due_date'"
                            placeholder="Due Date"
                        /> --}}
                                <input type="date" class="form-control" id="due_date" wire:model="due_date"
                                    placeholder="Due Date" />
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Penanggung Jawab</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <x-inputs.text wire:model="person_responsible" id="person_responsible"
                                    :error="'person_responsible'" placeholder="Penanggung Jawab" />
                                <!-- <select
                                class="form-select w-100"
                                wire:ignore
                                id="person_responsible"
                                wire:model.defer="person_responsible"
                                placeholder="Person In Control"
                                :error="'person_responsible'"
                                >
                                <option>Select</option>
                                @foreach ($users as $key => $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
                        </select> -->
                            </div>
                        </div>

                        <div class="flex">
                            <div class="w-[35%] items-start">
                                <div class="flex items-center">
                                    <p class="text-sm font-[400]">Completion Date</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-y-2 w-[65%] items-start">
                                <input type="date" class="form-control" id="completion_date"
                                    wire:model="completion_date" placeholder="Completion Date" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex w-full justify-end gap-3" wire:loading.attr="disabled">
                        <button type="button" wire:loading.attr="disabled"
                            onclick="mitigationCloseRepairTaskModal()"
                            class="!border rounded-md py-2 px-4 text-[13px] duration-300 hover:scale-105">
                            Cancel
                        </button>
                        <button type="button" wire:loading.remove wire:click="add_mitigation_repairTask()"
                            class="!border bg-[#088E52] rounded-md py-2 px-4 text-[13px] text-white duration-300 hover:scale-105">
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
        // window.addEventListener('edit', event => {
        //     $('#FLAgencyAuthorityModal').modal('show');
        //     if (event.detail.id) {
        //         @this.set('name', event.detail.name);
        //         @this.set('idAgencyAuthority', event.detail.id);
        //     }
        // });

        // window.addEventListener('closeModal', event => {
        //     $('#FLAgencyAuthorityModal').modal('hide');
        //     @this.set('name', null);
        //     @this.set('idAgencyAuthority', null);
        // });

        function closeCmfModal() {
            @if (isset($cmf_id))
                @this.set('cmf_id', null);
            @endif
            $("#cmf").modal("hide");
        }

        function closeImmModal() {
            @if (isset($imm_id))
                @this.set('imm_id', null);
            @endif
            $("#imm").modal("hide");
        }

        function closeRepairTaskModal() {
            @if (isset($repair_task_id))
                @this.set('repair_task_id', null);
            @endif
            $("#repairTask").modal("hide");
        }

        function mitigationCloseRepairTaskModal() {
            @if (isset($mitigation_repair_task_id))
                @this.set('mitigation_repair_task_id', null);
            @endif
            $("#mitigation_repairTask").modal("hide");
        }

        Livewire.on('closeModal', () => {
            $('#staticBackdrop').modal('hide');
        });


        window.addEventListener('refresh-page', event => {
            window.location.reload(false);
        })

        function closeModalPrimary() {
            $('#staticBackdrop').modal('hide');
        }

        function openCmfModal() {
            $("#cmf").modal("show");
        }

        function openImmModal() {
            $("#imm").modal("show");
        }

        function openRepairTaskModal() {
            $("#repairTask").modal("show");
        }

        function openMitigationRepairTaskModal() {
            $("#mitigation_repairTask").modal("show");
        }

        Livewire.on('closeModalCms', () => {
            closeCmfModal();
        });

        Livewire.on('closeModalMitigationRepairTask', () => {
            mitigationCloseRepairTaskModal();
        });

        Livewire.on('closeModalRepairTask', () => {
            closeRepairTaskModal();
        });

        Livewire.on('closeModalImm', () => {
            closeImmModal();
        });


        Livewire.on('openCmfModal', () => {
            openCmfModal();
        });
        Livewire.on('openImmModal', () => {
            openImmModal();
        });
        Livewire.on('openRepairTaskModal', () => {
            openRepairTaskModal();
        });
        Livewire.on('openMitigationRepairTaskModal', () => {
            openMitigationRepairTaskModal();
        });

        $('#cmf').on('show.bs.modal', function(e) {
            $('#staticBackdrop').modal('hide');
        });

        $('#cmf').on('hide.bs.modal', function(e) {
            $('#staticBackdrop').modal('show');
        });

        $('#repairTask').on('show.bs.modal', function(e) {
            $('#staticBackdrop').modal('hide');
        });

        $('#repairTask').on('hide.bs.modal', function(e) {
            $('#staticBackdrop').modal('show');
        });

        $('#imm').on('show.bs.modal', function(e) {
            $('#staticBackdrop').modal('hide');
        });

        $('#imm').on('hide.bs.modal', function(e) {
            $('#staticBackdrop').modal('show');
        });

        $('#mitigation_repairTask').on('show.bs.modal', function(e) {
            $('#staticBackdrop').modal('hide');
        });

        $('#mitigation_repairTask').on('hide.bs.modal', function(e) {
            $('#staticBackdrop').modal('show');
        });

        function clickEditModalFromList(id) {
            Livewire.emit('click_edit_event', id);
        }

        function onModalClose() {
            Livewire.emit('close_modal_edit');
        }

        Livewire.on('openModal', () => {
            $('#staticBackdrop').modal('show');
        });

        function changeReason(value, index) {
            Livewire.emit('change_reason', value, index);
        }
    </script>
@endpush

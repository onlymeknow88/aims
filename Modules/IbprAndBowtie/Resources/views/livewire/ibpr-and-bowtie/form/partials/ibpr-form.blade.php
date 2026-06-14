<div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="staticBackdropLabel"></div>
                <button class="" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row form-group">
                    <label for="activity" class="col-sm-4 col-form-label flex">Aktfitas
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            id="activity"
                            error="activity"
                            wire:model.defer="activity"
                            placeholder="Activity"/>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="sub_activity" class="col-sm-4 col-form-label flex">Sub Aktifitas
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="sub_activity"
                            id="sub_activity"
                            error="sub_activity"
                            placeholder="Sub Activity"
                        />
                    </div>
                </div>
                <div class="mb-3 row form-group ">
                    <label for="kondition" class="col-sm-4 col-form-label">Tipe Aktifitas <span
                            class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <select
                            id="kondition"
                            placeholder="Select"
                            class="form form-control"
                            :error="'kondition'"
                            wire:model.defer="kondition"
                        >
                            <option>Select</option>
                            <option value="Rutin">Rutin</option>
                            <option value="Tidak Rutin">Tidak Rutin</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row form-group ">
                    <label for="safety" class="col-sm-4 col-form-label flex">Bahaya Keselamatan
                        <span class="text-red-600">*</span>
                    </label>
                    <div class="col-sm-8">
                        <select
                            id="safety"
                            placeholder="Select"
                            class="form form-control"
                            :error="'safety'"
                            wire:model.defer="safety"
                        >
                            <option>Select</option>
                            @foreach($ibprBahaya as $bahaya)
                                <option value="{{$bahaya->name}}">{{$bahaya->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="incident_risk" class="col-sm-4 col-form-label">Risiko Kejadian <span
                            class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model.defer="incident_risk"
                            id="incident_risk"
                            error="incident_risk"
                            placeholder="Incident Risk"/>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="relevant_legislation" class="col-sm-4 col-form-label">Peraturan Terkait <span
                            class="text-red-600">*</span></label>
                    <div class="col-sm-8">
                        <x-inputs.textarea
                            wire:model.defer="relevant_legislation"
                            id="relevant_legislation"
                            error="relevant_legislation"
                            placeholder="Relevant Legislation">
                        </x-inputs.textarea>
                    </div>
                </div>
                <br/>
                <div class="col-md-6">
                    <h5 class="font-semibold">Penilaian Risiko Awal</h5>
                </div>
                <img src="{{ asset('images/ibpr-and-bowtie/matrix-ibpr.jpg') }}" alt="" width="100%">
                <br/>
                <div class="row mb-3">
                    <div class="col-sm-4 flex items-center">
                        <label for="preliminary_frequence" class="col-form-label flex">Konsekuensi Maksimal
                            <span class="text-red-600">*</span>

                        </label>
                    </div>
                    <div class="col-sm-8 flex">
                        <div class="mb-3 col-md form-group relative">
                            <div class="flex items-center">
                                <div class="cursor-pointer duration-500 hover:scale-105">
                                    <button id="btn-togle-k3" type="button"
                                            class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                        !
                                    </button>
                                </div>
                                <label for="title" class="col-sm-4 col-form-label">K3</label>
                            </div>
                            <div id="tooltip_k3"
                                 class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(null, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Select
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Terpapar PAK yang tidak dapat pulih/ sembuh
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(4, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (4)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(4, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                            terpapar di atas 10 orang
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (4)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan terjadinya Cidera ringan dan dapat bekerja di pekerjaan
                                            semula lebih dari satu hari
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                            terpapar antara 5 sampai dengan 10 orang
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(2, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan terjadinya Cidera ringan dan dapat bekerja di pekerjaan
                                            semula pada hari berikutnya
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (2)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(2, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                            terpapar di bawah 5 orang
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (2)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan terjadinya Cidera ringan dan masih dapat bekerja di
                                            pekerjaan semula (termasuk first aid case)
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_k3')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Tidak terkait dengan PAK/ tidak ada potensi PAK
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <x-inputs.number
                                    disabled
                                    wire:model.defer="preliminary_consequence_k3"
                                    id="preliminary_consequence_k3"
                                    error="preliminary_consequence_k3"
                                    placeholder="K3"></x-inputs.number>
                            </div>
                        </div>
                        <div class="mb-3 col-md form-group relative">
                            <div class="flex items-center">
                                <div class="cursor-pointer duration-500 hover:scale-105">
                                    <button id="btn-togle-kp" type="button"
                                            class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                        !
                                    </button>
                                </div>
                                <label for="title" class="col-sm-4 col-form-label">KP</label>
                            </div>
                            <div id="tooltip_kp"
                                 class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                <div wire:click="change_consequences(null, 'preliminary_consequence_kp')"
                                     class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                    <div class="py-3 px-4">
                                        Select
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_kp')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Pelanggaran serius terhadap peraturan perundang-undangan yang dapat
                                            dihentikannya operasi/ dicabutnya izin oleh pemerintah
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_kp')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Adanya Pelanggaran terhadap peraturan perundang-undangan yang
                                            mengakibatkan adanya teguran/sangsi dari pemerintah
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_kp')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Pelanggaran minor terhadap peraturan perundang-undangan
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <x-inputs.number
                                    disabled
                                    wire:model.defer="preliminary_consequence_kp"
                                    id="preliminary_consequence_kp"
                                    error="preliminary_consequence_kp"
                                    placeholder="KP"></x-inputs.number>
                            </div>
                        </div>
                        <div class="mb-3 col-md form-group relative">
                            <div class="flex items-center">
                                <div class="cursor-pointer duration-500 hover:scale-105">
                                    <button id="btn-togle-ksl" type="button"
                                            class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                        !
                                    </button>
                                </div>
                                <label for="title" class="col-sm-4 col-form-label">KSL</label>
                            </div>
                            <div id="tooltip_ksl"
                                 class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                <div wire:click="change_consequences(null, 'preliminary_consequence_ksl')"
                                     class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                    <div class="py-3 px-4">
                                        Select
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Dampak yang dirasakan sangat serius oleh komunitas sosial lokal dan
                                            berakibat pada demonstrasi baik mengakibatkan operasi berhenti atau
                                            tidak
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Adanya isu yang meluas sampai media internasional / nasional
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Dampak yang dirasakan oleh komunitas lokal / pihak yang berkepentingan
                                            (stakeholder) dan berakibat terjadinya keluhan, baik secara formal
                                            maupun informal
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Adanya isu yang meluas sampai media lokal
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Tidak mengakibatkan terjadinya keluhan komunitas sosial lokal.
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Tidak terekspos sampai ke media
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <x-inputs.number
                                    disabled
                                    wire:model.defer="preliminary_consequence_ksl"
                                    id="preliminary_consequence_ksl"
                                    error="preliminary_consequence_ksl"
                                    placeholder="KSL"/>
                            </div>
                        </div>
                        <div class="mb-3 col-md form-group relative">
                            <div class="flex items-center">
                                <div class="cursor-pointer duration-500 hover:scale-105">
                                    <button id="btn-togle-kk" type="button"
                                            class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                        !
                                    </button>
                                </div>
                                <label for="title" class="col-sm-4 col-form-label">KK</label>
                            </div>
                            <div id="tooltip_kk"
                                 class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                <div wire:click="change_consequences(null, 'preliminary_consequence_kk')"
                                     class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                    <div class="py-3 px-4">
                                        Select
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div wire:click="change_consequences(5, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            > 20% dari total nilai aset
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (5)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(4, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            > 10% - < 20% dari total nilai aset
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (4)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(4, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (4)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(3, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            > 2.5% - < 10% dari total nilai aset
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (3)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(2, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            < 1% - < 2.5% dari total nilai aset
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (2)
                                            </div>
                                        </div>
                                    </div>
                                    <div wire:click="change_consequences(1, 'preliminary_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            < 1% dari total nilai aset
                                            <div class="mt-2 text-sm text-blue-500 font-bold">
                                                Konsekuensi (1)
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <x-inputs.number
                                    disabled
                                    wire:model.defer="preliminary_consequence_kk"
                                    id="preliminary_consequence_kk"
                                    error="preliminary_consequence_kk"
                                    placeholder="KK"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row form-group" style="z-index: 9">
                    <label for="preliminary_frequence" class="col-sm-4 col-form-label flex">Frekuensi
                        <span class="text-red-600">*</span>
                        {{--<span class="ml-2 relative">
                            <img class="cursor-pointer duration-500 hover:scale-125" onmouseover="show_preliminary_frequence_info()" onmouseout="show_preliminary_frequence_info()" src="{{ asset('./images/icons/info.png') }}" alt="info">--}}
                        {{-- <span id="preliminary_frequence_info" class="bg-white w-[600px] border rounded absolute p-3 transition-all z-10">
                            <div class="bg-white grid grid-cols-1 w-full">
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">A</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Terjadi dalam banyak keadaan (mulai dari tiap saat/hari hingga 1x/ minggu)</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">B</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi dalam tiap bulan</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">C</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi beberapa kali dalam 1 tahun</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">D</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi lebih dari 1 tahun</p>
                                </div>
                                <div class="flex w-full">
                                    <p class="w-5 font-[500] text-[13px]">E</p>
                                    <p class="w-3 font-[500] text-[13px]">:</p>
                                    <p class="font-[500] text-[13px]">Kemungkinan terjadi tetapi dalam situasi yang luar biasa</p>
                                </div>
                            </div>
                        </span> --}}
                        </span>
                    </label>
                    <div class="col-sm-8">
                        <select
                            class="form-control"
                            id="preliminary_frequence"
                            placeholder="Select Frequence"
                            :error="'preliminary_frequence'"
                            wire:model.defer="preliminary_frequence"
                        >
                            <option>Select Frekuensi</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="preliminary_level_of_risk" class="col-sm-4 col-form-label flex">Tingkat Risiko
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            disabled
                            wire:model.defer="preliminary_level_of_risk_label"
                            id="preliminary_level_of_risk_label"
                            error="preliminary_level_of_risk"
                            placeholder="Level of Risk"/>
                    </div>
                </div>
                <div class="mb-3 row form-group">
                    <label for="preliminary_main_risk" class="col-sm-4 col-form-label flex">Risiko Utama
                        <span class="text-red-600">*</span>

                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            disabled
                            wire:model.defer="preliminary_main_risk"
                            id="preliminary_main_risk"
                            error="preliminary_main_risk"
                            placeholder="Main Risk"/>
                    </div>
                </div>
                <br/>
                <div class="col-md-6">
                    <h5 class="font-semibold">Pengendalian Saat Ini</h5>
                </div>
                <br/>
                <div id="sembunyi" class="mb-3 row form-group">
                    <label for="modal_of_current" class="col-sm-4 col-form-label truncate">Model Tindakan
                        kendali</label>
                    <div class="col-sm-8 custom grid grid-cols-1 gap-y-3">
                        @foreach($risk_titles as $index_risk => $val)
                            @if($preliminary_level_of_risk === 'M' || $preliminary_level_of_risk === 'L')
                                <input type="text" 
                                    class="form form-control mb-3"
                                    wire:change="onSelect({{$index_risk}}, $event.target.value)"
                                    error="modal_of_current"
                                    placeholder="Model Tindakan Kendali"
                                    value="{{$val['name']}}" />
                            @else
                            <select
                                placeholder="Select"
                                :error="'modal_of_current'"
                                class="form form-control mb-1"
                                wire:change="onSelect({{$index_risk}}, $event.target.value)"
                            >
                                <option>Select</option>
                                @if($preliminary_level_of_risk === 'H')
                                    @php($columnName = array_column($risk_titles, 'name'))
                                    @foreach($ibprHirarki as $hirarki)
                                        <option @if(in_array($hirarki->name, $columnName)) disabled
                                                @endif @if($val['name'] === $hirarki->name) selected
                                                @endif value="{{$hirarki->name}}">{{$hirarki->name}}</option>
                                    @endforeach
                                @elseif($preliminary_level_of_risk === 'C')
                                    @foreach($bowtie as $index => $bowtieDetail)
                                        @php($names = array_column($risk_titles, 'name'))
                                        @if(!in_array($bowtieDetail->risk_title, $names))
                                            <option @if($val['name'] === $bowtieDetail->risk_title) selected
                                                    @endif value="{{ $bowtieDetail->risk_title }}">{{ $bowtieDetail->document_no }}
                                                - {{ $bowtieDetail->risk_title }}</option>
                                        @else
                                            <option disabled
                                                    @if($val['name'] === $bowtieDetail->risk_title) selected
                                                    @endif value="{{ $bowtieDetail->risk_title }}">{{ $bowtieDetail->document_no }}
                                                - {{ $bowtieDetail->risk_title }}</option>
                                        @endif
                                    @endforeach()
                                @endif
                            </select>
                            @endif
                            @if($preliminary_level_of_risk === 'H')
                            <input type="text" 
                                class="form form-control mb-3"
                                wire:model="notes.{{$index_risk}}"
                                error="modal_of_current"
                                placeholder="Note"/>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- <div class="mb-3 row form-group ">
                    <label for="effective_control" class="col-sm-4 col-form-label flex">
                        Note
                    </label>
                    <div class="col-sm-8">
                        <x-inputs.text
                            wire:model="note"
                            id="note"
                            error="note"
                            placeholder="Note"/>
                    </div>
                </div> -->
                
                <div class="{{ $this->preliminary_main_risk != 'Ya' ? '' : 'hidden' }}">
                    <div class="mb-3 row form-group ">
                        <label for="effective_control" class="col-sm-4 col-form-label flex">Kendali Efektif (Y/N)
                            <span class="text-red-600">*</span>

                        </label>
                        <div class="col-sm-8">
                            <x-ibprandbowtie-select-2
                                id="effective_control"
                                placeholder="Select"
                                :error="'effective_control'"
                                wire:model.defer="effective_control"
                            >

                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </x-ibprandbowtie-select-2>
                        </div>
                    </div>
                    <br/>
                    <div class="col-md-6">
                        <h5 class="font-semibold">Penilaian Risiko Sisa</h5>
                    </div>
                    <img src="{{ asset('images/ibpr-and-bowtie/matrix-ibpr.jpg') }}" alt="" width="100%">
                    <br/>
                    <div class="row mb-3">
                        <div class="col-sm-4 flex items-center">
                            <label for="residual_frequence" class="col-form-label flex">Konsekuensi Maksimal
                                <span class="text-red-600"></span>

                            </label>
                        </div>
                        <div class="col-sm-8 flex">
                            <div class="mb-3 col-md form-group relative">
                                <div class="flex items-center">
                                    <div class="cursor-pointer duration-500 hover:scale-105">
                                        <button id="btn-togle-k3-v2" type="button"
                                                class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                            !
                                        </button>
                                    </div>
                                    <label for="title" class="col-sm-4 col-form-label">K3</label>
                                </div>
                                <div id="tooltip_k3-v2"
                                     class="tooltip_custom border hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                    <div class="grid grid-cols-1">
                                        <div wire:click="change_consequences(null, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Select
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(3, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan terjadinya Cidera ringan dan dapat bekerja di pekerjaan
                                                semula lebih dari satu hari
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (3)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(3, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar antara 5 sampai dengan 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (3)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(2, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan terjadinya Cidera ringan dan dapat bekerja di pekerjaan
                                                semula pada hari berikutnya
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (2)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(2, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di bawah 5 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (2)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(1, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan terjadinya Cidera ringan dan masih dapat bekerja di
                                                pekerjaan semula (termasuk first aid case)
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (1)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(1, 'residual_consequence_k3')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Tidak terkait dengan PAK/ tidak ada potensi PAK
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (1)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <x-inputs.number
                                        disabled
                                        wire:model.defer="residual_consequence_k3"
                                        id="residual_consequence_k3"
                                        error="residual_consequence_k3"
                                        placeholder="K3"/>
                                </div>
                            </div>

                            <div class="mb-3 col-md form-group relative">
                                <div class="flex items-center">
                                    <div class="cursor-pointer duration-500 hover:scale-105">
                                        <button id="btn-togle-kp-v2" type="button"
                                                class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                            !
                                        </button>
                                    </div>
                                    <label for="title" class="col-sm-4 col-form-label">KP</label>
                                </div>
                                <div id="tooltip_kp-v2"
                                     class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                    <div wire:click="change_consequences(null, 'residual_consequence_kp')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Select
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kp')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <x-inputs.number
                                        disabled
                                        wire:model.defer="residual_consequence_kp"
                                        id="residual_consequence_kp"
                                        error="residual_consequence_kp"
                                        placeholder="KP"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md form-group relative">
                                <div class="flex items-center">
                                    <div class="cursor-pointer duration-500 hover:scale-105">
                                        <button id="btn-togle-ksl-v2" type="button"
                                                class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                            !
                                        </button>
                                    </div>
                                    <label for="title" class="col-sm-4 col-form-label">KSL</label>
                                </div>
                                <div id="tooltip_ksl-v2"
                                     class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                    <div wire:click="change_consequences(null, 'residual_consequence_ksl')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Select
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_ksl')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <x-inputs.number
                                        disabled
                                        wire:model.defer="residual_consequence_ksl"
                                        id="residual_consequence_ksl"
                                        error="residual_consequence_ksl"
                                        placeholder="KSL"/>
                                </div>
                            </div>
                            <div class="mb-3 col-md form-group relative">
                                <div class="flex items-center">
                                    <div class="cursor-pointer duration-500 hover:scale-105">
                                        <button id="btn-togle-kk-v2" type="button"
                                                class="flex text-xs text-gray-500 mr-2 items-center justify-center border rounded-full h-5 w-5">
                                            !
                                        </button>
                                    </div>
                                    <label for="title" class="col-sm-4 col-form-label">KK</label>
                                </div>
                                <div id="tooltip_kk-v2"
                                     class="border tooltip_custom hidden w-96 bg-white shadow-sm rounded-md absolute z-10 h-[500px] overflow-scroll">
                                    <div wire:click="change_consequences(null, 'residual_consequence_kk')"
                                         class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                        <div class="py-3 px-4">
                                            Select
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan Cidera berat dikarenakan kecelakaan kerja
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(4, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan munculnya PAK yang dapat pulih dengan jumlah karyawan
                                                terpapar di atas 10 orang
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (4)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Mengakibatkan kematian dikarenakan kecelakaan kerja / cacat permanen
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                        <div wire:click="change_consequences(5, 'residual_consequence_kk')"
                                             class="border-b duration-700 hover:bg-gray-200 cursor-pointer">
                                            <div class="py-3 px-4">
                                                Terpapar PAK yang tidak dapat pulih/ sembuh
                                                <div class="mt-2 text-sm text-blue-500 font-bold">
                                                    Konsekuensi (5)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <x-inputs.number
                                        disabled
                                        wire:model.defer="residual_consequence_kk"
                                        id="residual_consequence_kk"
                                        error="residual_consequence_kk"
                                        placeholder="KK"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row form-group" style="z-index: 9">
                        <label for="residual_frequence" class="col-sm-4 col-form-label flex">Frekuensi
                            <span class="text-red-600"></span>
                            {{--<span class="ml-2">
                                <img  class="cursor-pointer duration-500 hover:scale-125" onmouseover="show_residual_frequence_info()" onmouseout="show_residual_frequence_info()" src="{{ asset('./images/icons/info.png') }}" alt="info">
                                 <span id="residual_frequence_info" class="bg-white w-[600px] border rounded absolute p-3 transition-all z-10">
                                    <div class="bg-white grid grid-cols-1 w-full">
                                        <div class="flex w-full">
                                            <p class="w-5 font-[500] text-[13px]">A</p>
                                            <p class="w-3 font-[500] text-[13px]">:</p>
                                            <p class="font-[500] text-[13px]">Terjadi dalam banyak keadaan (mulai dari tiap saat/hari hingga 1x/ minggu)</p>
                                        </div>
                                        <div class="flex w-full">
                                            <p class="w-5 font-[500] text-[13px]">B</p>
                                            <p class="w-3 font-[500] text-[13px]">:</p>
                                            <p class="font-[500] text-[13px]">Kemungkinan terjadi dalam tiap bulan</p>
                                        </div>
                                        <div class="flex w-full">
                                            <p class="w-5 font-[500] text-[13px]">C</p>
                                            <p class="w-3 font-[500] text-[13px]">:</p>
                                            <p class="font-[500] text-[13px]">Kemungkinan terjadi beberapa kali dalam 1 tahun</p>
                                        </div>
                                        <div class="flex w-full">
                                            <p class="w-5 font-[500] text-[13px]">D</p>
                                            <p class="w-3 font-[500] text-[13px]">:</p>
                                            <p class="font-[500] text-[13px]">Kemungkinan terjadi lebih dari 1 tahun</p>
                                        </div>
                                        <div class="flex w-full">
                                            <p class="w-5 font-[500] text-[13px]">E</p>
                                            <p class="w-3 font-[500] text-[13px]">:</p>
                                            <p class="font-[500] text-[13px]">Kemungkinan terjadi tetapi dalam situasi yang luar biasa</p>
                                        </div>
                                    </div>
                                </span>
                            </span>--}}
                        </label>
                        <div class="col-sm-8">
                            <select
                                class="form-control"
                                id="residual_frequence"
                                placeholder="Select Frequence"
                                :error="'residual_frequence'"
                                wire:model.defer="residual_frequence"
                            >
                                <option>Select Frekuensi</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="residual_level_of_risk" class="col-sm-4 col-form-label flex">Tingkat Rasio Sisa
                            <span class="text-red-600"></span>

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.text wire:model.defer="residual_level_of_risk_label"
                                           disabled
                                           id="residual_level_of_risk_label"
                                           error="residual_level_of_risk"
                                           placeholder="Maximum Consequences"/>
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="residual_main_risk" class="col-sm-4 col-form-label flex">Risiko Utama
                            <span class="text-red-600"></span>

                        </label>
                        <div class="col-sm-8">
                            <x-inputs.text
                                wire:model.defer="residual_main_risk"
                                disabled
                                id="residual_main_risk"
                                error="residual_main_risk"
                                placeholder="Main of Risk"/>
                        </div>
                    </div>
                    <div class="mb-3 row form-group">
                        <label for="follow_risk" class="col-sm-4 col-form-label truncate">Tindakan Pengendalian</label>
                        <div class="col-sm-8">
                            <x-inputs.text wire:model.defer="follow_risk"
                                           id="follow_risk"
                                           error="follow_risk"
                                           placeholder="Tindakan Pengendalian Resiko lanjutan (jika ada)"/>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer w-full flex justify-end footer-action">
                {{-- <div wire:click.stop="push_form" class="bg-[#F5FAF8] cursor-pointer w-full p-3 border_add_modal flex justify-center items-center rounded-md">
                  <p class="text-green-700">+ @if(!is_null($index_edit)) Change @else Add @endif form</p>
                </div> --}}
                <div>
                    <button type="button" onclick="closeModal()" class="btn btn-outline-secondary">Cancel</button>
                </div>
                <div>
                    <button type="button" wire:click.stop="push_form"
                            class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">
                        Save activity
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
        let teams = [];
        $(document).ready(function () {

            $('#tags-input').on('keydown', function (event) {
                if (event.keyCode === 13) { // 13 is the keycode for the Enter key
                    var team = $(this).val().trim();
                    teams.push(team);
                    if (team !== '') {
                        $('#tags-list').before('<div class="tag bg-gray-100 px-3 flex items-center mr-2 ml-2 rounded-md my-1">' + team + '<button type="button" class="close ml-2 border rounded-full h-3 w-3 flex items-center justify-center p-2 border-black" data-name="' + team + '" aria-label="Close"><span aria-hidden="true">x</span></button></div>');
                        $(this).val('');
                    }

                @this.set('teams', teams);
                }
            });

            $('body').on('click', '.close', function () {
                console.log('tes')
                var name = $(this).data('name');

                let newValue = teams.filter(e => e !== name)
                teams = newValue;

                $(this).parent().remove();
            @this.set('teams', newValue);
            });
        });

        function toggle_dropdown_submit() {
            $('#dropdown_submit').toggle();
        }

        function close_dropdown_submit() {
            console.log('tes')
            // $('#dropdown_submit').toggle();
        }

        $(document).ready(function () {
            $('#menu_dropdown').blur(function () {
                alert('The input field lost focus');
            });
        });

        $('#preliminary_frequence_info').addClass('hidden');

        function show_preliminary_frequence_info() {
            $('#preliminary_frequence_info').toggleClass('hidden');
        }

        $('#residual_frequence_info').addClass('hidden');

        function show_residual_frequence_info() {
            $('#residual_frequence_info').toggleClass('hidden');
        }

        $('#btn-togle-k3').click(function () {
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_k3').toggleClass('hidden');
        });

        $('#btn-togle-lh').click(function () {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_lh').toggleClass('hidden');
        });

        $('#btn-togle-kp').click(function () {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').toggleClass('hidden');
        });

        $('#btn-togle-ksl').click(function () {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').toggleClass('hidden');
        });

        $('#btn-togle-kk').click(function () {
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').toggleClass('hidden');
        });


        $('#btn-togle-k3-v2').click(function () {
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3-v2').toggleClass('hidden');
        });

        $('#btn-togle-lh-v2').click(function () {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_lh-v2').toggleClass('hidden');
        });

        $('#btn-togle-kp-v2').click(function () {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').toggleClass('hidden');
        });

        $('#btn-togle-ksl-v2').click(function () {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').toggleClass('hidden');
        });

        $('#btn-togle-kk-v2').click(function () {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').toggleClass('hidden');
        });


        Livewire.on('openModal', (e) => {
            let preliminary_main_risk = $('#preliminary_main_risk').val();
            chooseModaelOfCurrent(preliminary_main_risk);

            $("#staticBackdrop").modal("show");
        });

        function tryToOpenModal() {
            let doc = $('#document_no').val();
            $('#staticBackdropLabel').text(doc);
            $("#staticBackdrop").modal("show");
        }


        function closeModal() {
            $("#staticBackdrop").modal("hide");
        }

        Livewire.on('closeModal', () => {
            $("#staticBackdrop").modal("hide");
        });

        Livewire.on('closeAllToooltip', () => {
            closeAllToooltip();
        });

        function closeAllToooltip() {
            $('#tooltip_k3-v2').addClass('hidden');
            $('#tooltip_lh-v2').addClass('hidden');
            $('#tooltip_kp-v2').addClass('hidden');
            $('#tooltip_ksl-v2').addClass('hidden');
            $('#tooltip_kk-v2').addClass('hidden');
            $('#tooltip_k3').addClass('hidden');
            $('#tooltip_lh').addClass('hidden');
            $('#tooltip_kp').addClass('hidden');
            $('#tooltip_ksl').addClass('hidden');
            $('#tooltip_kk').addClass('hidden');
        }


        $('#preliminary_frequence').on('input', function () {
            // Call your function here
            let preliminary_frequence = $('#preliminary_frequence').val();
            Livewire.emit('event_formula_level_of_risk', preliminary_frequence);
        });

        $('#residual_frequence').on('input', function () {
            // Call your function here
            let residual_frequence = $('#residual_frequence').val();
            Livewire.emit('event_formula_level_of_risk_residual', residual_frequence);
        });

        $(document).ready(function () {
            // Attach a change event handler to the form
            $('#document_no').change(function () {
                // Code to execute when the form value changes
                let val = $('#document_no').val();
                $('#staticBackdropLabel').text(val);
            });
        });

        Livewire.on('chooseModaelOfCurrent', (preliminary_main_risk) => {
            $('#preliminary_frequence_info').addClass('hidden');
            $('#residual_frequence_info').addClass('hidden');
            chooseModaelOfCurrent(preliminary_main_risk);
        });

        $('#staticBackdrop').on('hide.bs.modal', function () {
            Livewire.emit('event_unset_index_edit');
        });

        $('#staticBackdrop').on('show.bs.modal', function () {
            $('#preliminary_frequence_info').addClass('hidden');
            $('#residual_frequence_info').addClass('hidden');
        });

        function chooseModaelOfCurrent(preliminary_main_risk) {
            // if(preliminary_main_risk === 'Ya') {
            //     let options = `
            //         <option value="Interaksi kendaraan">Interaksi kendaraan</option>
            //         <option value="Pengangkatan">Pengangkatan</option>
            //         <option value="Penanganan ban">Penanganan ban</option>
            //         <option value="Bekerja dekat Air">Bekerja dekat Air</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);
            // }

            // if(preliminary_main_risk === 'Tidak') {
            //     let options = `
            //         <option value="ELIMINASI">ELIMINASI</option>
            //         <option value="SUBSTITUSI">SUBSTITUSI</option>
            //         <option value="TEKNIK REKAYASA">TEKNIK REKAYASA</option>
            //         <option value="ADMINISTRASI">ADMINISTRASI</option>
            //         <option value="ALAT PELINDUNG DIRI">ALAT PELINDUNG DIRI</option>
            //     `
            //     $('#modal_of_current').empty();
            //     $('#modal_of_current').append(options);

            // }
            return true;
        }
    </script>
@endpush
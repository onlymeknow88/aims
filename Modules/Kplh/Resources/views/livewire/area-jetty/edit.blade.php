<div class="inner-content">

    <div
        class="header-content-inspeksi-area-maintank h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Inspeksi Area Jetty</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-area-maintank -->

    <div class="content-inspeksi-area-maintank">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-8">

                    <form class="py-4 d-flex flex-column gap-5" action="#" action="post"
                        wire:submit.prevent='save'>

                        <div class="title-form text-center my-3">
                            <h4>Inspeksi Area Jetty</h4>
                        </div><!-- /.title-form -->

                        <div id="label" class="section-label" x-data="{ accordionOpen: true }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">Label</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="label"
                                x-bind:style="accordionOpen ? 'max-height: ' + $refs.label.scrollHeight + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row mb-3 form-group">
                                        <label for="date" class="col col-form-label">Tanggal
                                            Inspeksi</label>
                                        <div class="col-8">
                                            <x-kplh-datepicker-30d wire:model="date" id="date"
                                                placeholder="Tanggal Inspeksi" :error="'date'" />
                                        </div>
                                    </div><!-- /.form-group date -->

                                    <div class="row mb-3 form-group">
                                        <label for="ccow_id" class="col col-form-label">CCOW</label>
                                        <div class="col-8">

                                            <x-inputs.select2 id="ccow_id" placeholder="CCOW" :error="'ccow_id'"
                                                wire:model.defer="ccow_id">
                                                @foreach ($this->ccows as $index => $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->company_name }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select2>

                                        </div>
                                    </div><!-- /.form-group ccow -->

                                    <div class="row mb-3 form-group">
                                        <label for="companyId" class="col col-form-label">Nama
                                            Perusahaan</label>
                                        <div class="col-8">
                                            <x-inputs.select2 wire:model="companyId" id="companyId" class="form-select"
                                                placeholder="Nama Perusahaan">
                                                @foreach ($this->companies as $index => $c)
                                                    <option value="{{ $c->id }}">{{ $c->company_name }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select2>
                                        </div>
                                    </div><!-- /.form-group companyId -->

                                    <div class="row mb-3 form-group">
                                        <label for="departmentId" class="col col-form-label">Departemen</label>
                                        <div class="col-8">

                                            @if ($ccow_id)
                                                <x-inputs.select2 wire:model="departmentId" id="departmentId"
                                                    class="form-select" placeholder="Departemen">
                                                    @foreach ($this->departments as $index => $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="departmentId" id="departmentId"
                                                    class="form-select" placeholder="Departemen" disabled>
                                                </x-inputs.select2>
                                            @endif

                                        </div>
                                    </div><!-- /.form-group departmentId -->

                                    <div class="row mb-3 form-group">
                                        <label for="sectionId" class="col col-form-label">Section</label>
                                        <div class="col-8">
                                            @if ($departmentId)
                                                <x-inputs.select2 wire:model="sectionId" id="sectionId"
                                                    class="form-select" placeholder="Departemen">
                                                    @foreach ($this->sections as $index => $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="sectionId" id="sectionId"
                                                    class="form-select" placeholder="Departemen" disabled>
                                                </x-inputs.select2>
                                            @endif
                                        </div>
                                    </div><!-- /.form-group sectionId -->

                                    <div class="row mb-3 form-group">
                                        <label for="area_location_id" class="col col-form-label">Lokasi</label>
                                        <div class="col-8">

                                            @if ($sectionId)
                                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                                    data-child="area_location_id" class="form-select"
                                                    placeholder="Area Lokasi">
                                                    @foreach ($this->areaLocations as $key => $location)
                                                        <option value="{{ $location->id }}">{{ $location->name }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="area_location_id" id="area_location_id"
                                                    class="form-select" placeholder="Area Lokasi" disabled>
                                                </x-inputs.select2>
                                            @endif

                                        </div>
                                    </div><!-- /.form-group location -->

                                    <div class="row mb-3 form-group">
                                        <label for="detail_location" class="col col-form-label">Detail
                                            Lokasi</label>
                                        <div class="col-8">
                                            <x-inputs.text wire:model="detail_location" id="detail_location"
                                                placeholder="Detail Lokasi" :error="'detail_location'" />
                                        </div>
                                    </div><!-- /.form-group detail_location -->

                                    <div class="row mb-3 form-group">
                                        <label for="kttId" class="col-lg-4 col-md-12 col-form-label">KTT/PJO</label>
                                        <div class="col-lg-8 col-md-12">
                                            <select wire:model="kttId" id="kttId" class="form-control"
                                                placeholder="KTT" disabled>
                                                @if ($companyId)
                                                    <option value="{{ $kttId ?? null }}" selected>
                                                        {{ $company->user->name ?? null }}
                                                    </option>
                                                @endif

                                            </select>
                                        </div>
                                    </div><!-- /.form-group kttId -->

                                    <div class="row mb-3 form-group">
                                        <label for="pjaId" class="col-lg-4 col-md-12 col-form-label">PJA</label>
                                        <div class="col-lg-8 col-md-12">
                                            @if ($sectionId)
                                                <x-inputs.select2 wire:model="pjaId" id="pjaId"
                                                    class="form-select" placeholder="PJA">
                                                    @foreach ($this->areaManagers as $key => $areaManager)
                                                        <option value="{{ $areaManager->id }}">
                                                            {{ $areaManager->user->employee->name ?? null }}
                                                        </option>
                                                    @endforeach
                                                </x-inputs.select2>
                                            @else
                                                <x-inputs.select2 wire:model="pjaId" id="pjaId"
                                                    class="form-select" placeholder="PJA" disabled>
                                                </x-inputs.select2>
                                            @endif
                                        </div>
                                    </div><!-- /.form-group pjaId -->

                                    <div class="row mb-3 form-group mb-4">
                                        <label for="inspectionOfficer"
                                            class="col-lg-4 col-md-12 col-form-label">Petugas
                                            Inspeksi</label>
                                        <div class="col-lg-8 col-md-12">

                                            <div class="wrapper_inspectionOfficer d-flex flex-column gap-3">

                                                {{-- @if ($ccow_id) --}}
                                                <x-kplh-select2 wire:model="inspectionOfficer" id="inspectionOfficer"
                                                    class="form-select" placeholder="Petugas Inspeksi"
                                                    :error="'inspectionOfficer'">
                                                    @foreach ($this->employees as $index => $emp)
                                                        <option value="{{ $emp->id }}">
                                                            {{ $emp->name }}
                                                        </option>
                                                    @endforeach
                                                </x-kplh-select2>
                                                {{-- @else
                                                    <select class="form-control" disabled></select>
                                                @endif --}}

                                            </div><!-- /.wrapper_petugas -->
                                        </div>
                                    </div><!-- /.form-group inspectionOfficer -->

                                </div><!-- ./content-label -->
                            </div>
                        </div><!-- /.label -->

                        <div id="jetty_1" class="section-jetty_1" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">1. JALUR PIPA, HOSE, & FILTER</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="jetty_1" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">A. Pipa</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_a_label" class="col-lg-4 col-md-12 col-form-label">1.
                                            Pastikan tidak ada rembesan atau retakan pada pipa
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_a d-flex flex-column gap-3"
                                                x-data="{ jetty_1_a_value: @entangle('jetty_1_a_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_a_value" id="jetty_1_a_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_a_value === 'Tidak' || jetty_1_a_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_a_note"
                                                            id="jetty_1_a_note" placeholder="Keterangan"
                                                            :error="'jetty_1_a_note'" />
                                                    </div>
                                                    @if ($jetty_1_a_file && !Illuminate\Support\Str::contains($jetty_1_a_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_a_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_a_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_a_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_a_file"
                                                                id="jetty_1_a_file" placeholder="File"
                                                                :error="'jetty_1_a_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_a -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">B. Sambungan antar Pipa</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_b_1_label" class="col-lg-4 col-md-12 col-form-label">1.
                                            Pastikan terdapat packing/ gasket
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_b_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_b_1_value: @entangle('jetty_1_b_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_b_1_value"
                                                    id="jetty_1_b_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_b_1_value === 'Tidak' || jetty_1_b_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_b_1_note"
                                                            id="jetty_1_b_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_b_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_b_1_file && !Illuminate\Support\Str::contains($jetty_1_b_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_b_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_b_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_b_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_b_1_file"
                                                                id="jetty_1_b_1_file" placeholder="File"
                                                                :error="'jetty_1_b_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_b_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_b_2_label" class="col-lg-4 col-md-12 col-form-label">2.
                                            Pastikan sambungan antar pipa fully bolted dan seragam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_b_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_b_2_value: @entangle('jetty_1_b_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_b_2_value"
                                                    id="jetty_1_b_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_b_2_value === 'Tidak' || jetty_1_b_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_b_2_note"
                                                            id="jetty_1_b_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_b_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_b_2_file && !Illuminate\Support\Str::contains($jetty_1_b_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_b_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_b_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_b_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_b_2_file"
                                                                id="jetty_1_b_2_file" placeholder="File"
                                                                :error="'jetty_1_b_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_b_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_b_3_label" class="col-lg-4 col-md-12 col-form-label">3.
                                            Pastikan tidak ada rembesan pada sambungan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_b_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_b_3_value: @entangle('jetty_1_b_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_b_3_value"
                                                    id="jetty_1_b_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_b_3_value === 'Tidak' || jetty_1_b_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_b_3_note"
                                                            id="jetty_1_b_3_note" placeholder="Keterangan"
                                                            :error="'jetty_1_b_3_note'" />
                                                    </div>
                                                    @if ($jetty_1_b_3_file && !Illuminate\Support\Str::contains($jetty_1_b_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_b_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_b_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_b_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_b_3_file"
                                                                id="jetty_1_b_3_file" placeholder="File"
                                                                :error="'jetty_1_b_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_b_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">C. Gate Valve</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_c_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan handle valve dapat
                                            dibuka tutup dengan bebas
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_c_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_c_1_value: @entangle('jetty_1_c_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_c_1_value"
                                                    id="jetty_1_c_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_c_1_value === 'Tidak' || jetty_1_c_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_c_1_note"
                                                            id="jetty_1_c_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_c_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_c_1_file && !Illuminate\Support\Str::contains($jetty_1_c_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_c_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_c_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_c_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_c_1_file"
                                                                id="jetty_1_c_1_file" placeholder="File"
                                                                :error="'jetty_1_c_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_c_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_c_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan gate valve telah
                                            dilumuri grease
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_c_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_c_2_value: @entangle('jetty_1_c_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_c_2_value"
                                                    id="jetty_1_c_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_c_2_value === 'Tidak' || jetty_1_c_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_c_2_note"
                                                            id="jetty_1_c_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_c_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_c_2_file && !Illuminate\Support\Str::contains($jetty_1_c_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_c_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_c_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_c_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_c_2_file"
                                                                id="jetty_1_c_2_file" placeholder="File"
                                                                :error="'jetty_1_c_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_c_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_c_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan pada
                                            gate valve
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_c_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_c_3_value: @entangle('jetty_1_c_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_c_3_value"
                                                    id="jetty_1_c_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_c_3_value === 'Tidak' || jetty_1_c_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_c_3_note"
                                                            id="jetty_1_c_3_note" placeholder="Keterangan"
                                                            :error="'jetty_1_c_3_note'" />
                                                    </div>
                                                    @if ($jetty_1_c_3_file && !Illuminate\Support\Str::contains($jetty_1_c_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_c_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_c_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_c_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_c_3_file"
                                                                id="jetty_1_c_3_file" placeholder="File"
                                                                :error="'jetty_1_c_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_c_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">D. Fleksible Hose</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_d_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan terdapat packing /
                                            gasket
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_d_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_d_1_value: @entangle('jetty_1_d_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_d_1_value"
                                                    id="jetty_1_d_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_d_1_value === 'Tidak' || jetty_1_d_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_d_1_note"
                                                            id="jetty_1_d_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_d_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_d_1_file && !Illuminate\Support\Str::contains($jetty_1_d_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_d_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_d_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_d_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_d_1_file"
                                                                id="jetty_1_d_1_file" placeholder="File"
                                                                :error="'jetty_1_d_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_d_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_d_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan hose dengan
                                            pipa fully bolted dan seragam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_d_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_d_2_value: @entangle('jetty_1_d_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_d_2_value"
                                                    id="jetty_1_d_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_d_2_value === 'Tidak' || jetty_1_d_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_d_2_note"
                                                            id="jetty_1_d_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_d_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_d_2_file && !Illuminate\Support\Str::contains($jetty_1_d_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_d_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_d_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_d_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_d_2_file"
                                                                id="jetty_1_d_2_file" placeholder="File"
                                                                :error="'jetty_1_d_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_d_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_d_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan pada
                                            sambungan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_d_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_d_3_value: @entangle('jetty_1_d_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_d_3_value"
                                                    id="jetty_1_d_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_d_3_value === 'Tidak' || jetty_1_d_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_d_3_note"
                                                            id="jetty_1_d_3_note" placeholder="Keterangan"
                                                            :error="'jetty_1_d_3_note'" />
                                                    </div>
                                                    @if ($jetty_1_d_3_file && !Illuminate\Support\Str::contains($jetty_1_d_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_d_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_d_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_d_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_d_3_file"
                                                                id="jetty_1_d_3_file" placeholder="File"
                                                                :error="'jetty_1_d_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_d_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_d_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan lekukan fleksible hose
                                            tidak terlalu bengkok ketika digunakan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_d_4 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_d_4_value: @entangle('jetty_1_d_4_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_d_4_value"
                                                    id="jetty_1_d_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_d_4_value === 'Tidak' || jetty_1_d_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_d_4_note"
                                                            id="jetty_1_d_4_note" placeholder="Keterangan"
                                                            :error="'jetty_1_d_4_note'" />
                                                    </div>
                                                    @if ($jetty_1_d_4_file && !Illuminate\Support\Str::contains($jetty_1_d_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_d_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_d_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_d_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_d_4_file"
                                                                id="jetty_1_d_4_file" placeholder="File"
                                                                :error="'jetty_1_d_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_d_4 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">E. Filter / streiner</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_e_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan kondisi body tidak
                                            penyok atau menggembung
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_e d-flex flex-column gap-3"
                                                x-data="{ jetty_1_e_value: @entangle('jetty_1_e_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_e_value" id="jetty_1_e_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_e_value === 'Tidak' || jetty_1_e_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_e_note"
                                                            id="jetty_1_e_note" placeholder="Keterangan"
                                                            :error="'jetty_1_e_note'" />
                                                    </div>
                                                    @if ($jetty_1_e_file && !Illuminate\Support\Str::contains($jetty_1_e_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_e_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_e_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_e_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_e_file"
                                                                id="jetty_1_e_file" placeholder="File"
                                                                :error="'jetty_1_e_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_e -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">F. Penutup streiner</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_f_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan penutup filter / treiner
                                            fully bolted
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_f_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_f_1_value: @entangle('jetty_1_f_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_f_1_value"
                                                    id="jetty_1_f_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_f_1_value === 'Tidak' || jetty_1_f_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_f_1_note"
                                                            id="jetty_1_f_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_f_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_f_1_file && !Illuminate\Support\Str::contains($jetty_1_f_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_f_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_f_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_f_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_f_1_file"
                                                                id="jetty_1_f_1_file" placeholder="File"
                                                                :error="'jetty_1_f_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_f_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_f_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan
                                            minyak pada penutup filter / streiner
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_f_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_f_2_value: @entangle('jetty_1_f_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_f_2_value"
                                                    id="jetty_1_f_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_f_2_value === 'Tidak' || jetty_1_f_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_f_2_note"
                                                            id="jetty_1_f_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_f_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_f_2_file && !Illuminate\Support\Str::contains($jetty_1_f_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_f_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_f_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_f_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_f_2_file"
                                                                id="jetty_1_f_2_file" placeholder="File"
                                                                :error="'jetty_1_f_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_f_2 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">G. Keran( Drain Strainer)</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_g_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan keran dalam keadaan
                                            close saat filter sedang dialiri fuel dari kapal
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_g_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_g_1_value: @entangle('jetty_1_g_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_g_1_value"
                                                    id="jetty_1_g_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_g_1_value === 'Tidak' || jetty_1_g_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_g_1_note"
                                                            id="jetty_1_g_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_g_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_g_1_file && !Illuminate\Support\Str::contains($jetty_1_g_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_g_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_g_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_g_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_g_1_file"
                                                                id="jetty_1_g_1_file" placeholder="File"
                                                                :error="'jetty_1_g_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_g_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_g_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan keran dalam keadaan
                                            close dan disegel saat filter sedang tidak digunakan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_g_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_g_2_value: @entangle('jetty_1_g_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_g_2_value"
                                                    id="jetty_1_g_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_g_2_value === 'Tidak' || jetty_1_g_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_g_2_note"
                                                            id="jetty_1_g_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_g_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_g_2_file && !Illuminate\Support\Str::contains($jetty_1_g_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_g_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_g_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_g_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_g_2_file"
                                                                id="jetty_1_g_2_file" placeholder="File"
                                                                :error="'jetty_1_g_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_g_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_g_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan
                                            minyak pada keran filter / streiner
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_g_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_g_3_value: @entangle('jetty_1_g_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_g_3_value"
                                                    id="jetty_1_g_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_g_3_value === 'Tidak' || jetty_1_g_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_g_3_note"
                                                            id="jetty_1_g_3_note" placeholder="Keterangan"
                                                            :error="'jetty_1_g_3_note'" />
                                                    </div>
                                                    @if ($jetty_1_g_3_file && !Illuminate\Support\Str::contains($jetty_1_g_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_g_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_g_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_g_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_g_3_file"
                                                                id="jetty_1_g_3_file" placeholder="File"
                                                                :error="'jetty_1_g_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_g_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">H. Pengangga filter / streiner
                                        </h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_h_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan penyangga filter kuat
                                            dan tegak
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_h d-flex flex-column gap-3"
                                                x-data="{ jetty_1_h_value: @entangle('jetty_1_h_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_h_value" id="jetty_1_h_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_h_value === 'Tidak' || jetty_1_h_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_h_note"
                                                            id="jetty_1_h_note" placeholder="Keterangan"
                                                            :error="'jetty_1_h_note'" />
                                                    </div>
                                                    @if ($jetty_1_h_file && !Illuminate\Support\Str::contains($jetty_1_h_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_h_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_h_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_h_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_h_file"
                                                                id="jetty_1_h_file" placeholder="File"
                                                                :error="'jetty_1_h_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_h -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">I. Pressure Indikator</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_i_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan pressure indikator
                                            berfungsi dengan baik
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_i d-flex flex-column gap-3"
                                                x-data="{ jetty_1_i_value: @entangle('jetty_1_i_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_i_value" id="jetty_1_i_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_i_value === 'Tidak' || jetty_1_i_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_i_note"
                                                            id="jetty_1_i_note" placeholder="Keterangan"
                                                            :error="'jetty_1_i_note'" />
                                                    </div>
                                                    @if ($jetty_1_i_file && !Illuminate\Support\Str::contains($jetty_1_i_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_i_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_i_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_i_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_i_file"
                                                                id="jetty_1_i_file" placeholder="File"
                                                                :error="'jetty_1_i_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_i -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">J. Blank Flange</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_j_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan terdapat packing /
                                            gasket
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_j_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_j_1_value: @entangle('jetty_1_j_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_j_1_value"
                                                    id="jetty_1_j_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_j_1_value === 'Tidak' || jetty_1_j_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_j_1_note"
                                                            id="jetty_1_j_1_note" placeholder="Keterangan"
                                                            :error="'jetty_1_j_1_note'" />
                                                    </div>
                                                    @if ($jetty_1_j_1_file && !Illuminate\Support\Str::contains($jetty_1_j_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_j_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_j_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_j_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_j_1_file"
                                                                id="jetty_1_j_1_file" placeholder="File"
                                                                :error="'jetty_1_j_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_j_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_j_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan sambungan antar pipa
                                            fully bolted dan seragam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_j_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_j_2_value: @entangle('jetty_1_j_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_j_2_value"
                                                    id="jetty_1_j_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_j_2_value === 'Tidak' || jetty_1_j_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_j_2_note"
                                                            id="jetty_1_j_2_note" placeholder="Keterangan"
                                                            :error="'jetty_1_j_2_note'" />
                                                    </div>
                                                    @if ($jetty_1_j_2_file && !Illuminate\Support\Str::contains($jetty_1_j_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_j_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_j_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_j_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_j_2_file"
                                                                id="jetty_1_j_2_file" placeholder="File"
                                                                :error="'jetty_1_j_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_j_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_1_j_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak ada rembesan pada
                                            blank flange
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_1_j_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_1_j_3_value: @entangle('jetty_1_j_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_1_j_3_value"
                                                    id="jetty_1_j_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_1_j_3_value === 'Tidak' || jetty_1_j_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_1_j_3_note"
                                                            id="jetty_1_j_3_note" placeholder="Keterangan"
                                                            :error="'jetty_1_j_3_note'" />
                                                    </div>
                                                    @if ($jetty_1_j_3_file && !Illuminate\Support\Str::contains($jetty_1_j_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_1_j_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_1_j_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_1_j_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_1_j_3_file"
                                                                id="jetty_1_j_3_file" placeholder="File"
                                                                :error="'jetty_1_j_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_1_j_3 -->

                                </div><!-- ./content-jetty_1 -->

                            </div>
                        </div><!-- /.jetty_1 -->

                        <div id="jetty_2" class="section-jetty_2" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">2. AREAL JETTY</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="jetty_2" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">A. Bollard Mooring</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_a_1_label" class="col-lg-4 col-md-12 col-form-label">1.
                                            Pastikan Bollard Mooring tidak dalam kondisi tenggelam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_a_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_a_1_value: @entangle('jetty_2_a_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_a_1_value"
                                                    id="jetty_2_a_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_a_1_value === 'Tidak' || jetty_2_a_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_a_1_note"
                                                            id="jetty_2_a_1_note" placeholder="Keterangan"
                                                            :error="'jetty_2_a_1_note'" />
                                                    </div>
                                                    @if ($jetty_2_a_1_file && !Illuminate\Support\Str::contains($jetty_2_a_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_a_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_a_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_a_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_a_1_file"
                                                                id="jetty_2_a_1_file" placeholder="File"
                                                                :error="'jetty_2_a_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_a_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_a_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan struktur bollard tidak
                                            retak dan penyok
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_a_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_a_2_value: @entangle('jetty_2_a_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_a_2_value"
                                                    id="jetty_2_a_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_a_2_value === 'Tidak' || jetty_2_a_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_a_2_note"
                                                            id="jetty_2_a_2_note" placeholder="Keterangan"
                                                            :error="'jetty_2_a_2_note'" />
                                                    </div>
                                                    @if ($jetty_2_a_2_file && !Illuminate\Support\Str::contains($jetty_2_a_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_a_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_a_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_a_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_a_2_file"
                                                                id="jetty_2_a_2_file" placeholder="File"
                                                                :error="'jetty_2_a_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_a_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_a_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan strukturnya tegak dan
                                            kuat,
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_a_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_a_3_value: @entangle('jetty_2_a_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_a_3_value"
                                                    id="jetty_2_a_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_a_3_value === 'Tidak' || jetty_2_a_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_a_3_note"
                                                            id="jetty_2_a_3_note" placeholder="Keterangan"
                                                            :error="'jetty_2_a_3_note'" />
                                                    </div>
                                                    @if ($jetty_2_a_3_file && !Illuminate\Support\Str::contains($jetty_2_a_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_a_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_a_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_a_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_a_3_file"
                                                                id="jetty_2_a_3_file" placeholder="File"
                                                                :error="'jetty_2_a_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_a_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">B. Jembatan Ponton</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_b_label" class="col-lg-4 col-md-12 col-form-label">1.
                                            Pastikan terdapat packing/ gasket
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_b d-flex flex-column gap-3"
                                                x-data="{ jetty_2_b_value: @entangle('jetty_2_b_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_b_value" id="jetty_2_b_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_b_value === 'Tidak' || jetty_2_b_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_b_note"
                                                            id="jetty_2_b_note" placeholder="Keterangan"
                                                            :error="'jetty_2_b_note'" />
                                                    </div>
                                                    @if ($jetty_2_b_file && !Illuminate\Support\Str::contains($jetty_2_b_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_b_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_b_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_b_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_b_file"
                                                                id="jetty_2_b_file" placeholder="File"
                                                                :error="'jetty_2_b_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_b -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">C. Lantai Jembatan Ponton</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_c_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan tidak berlubang dan
                                            tidak retak
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_c_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_c_1_value: @entangle('jetty_2_c_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_c_1_value"
                                                    id="jetty_2_c_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_c_1_value === 'Tidak' || jetty_2_c_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_c_1_note"
                                                            id="jetty_2_c_1_note" placeholder="Keterangan"
                                                            :error="'jetty_2_c_1_note'" />
                                                    </div>
                                                    @if ($jetty_2_c_1_file && !Illuminate\Support\Str::contains($jetty_2_c_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_c_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_c_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_c_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_c_1_file"
                                                                id="jetty_2_c_1_file" placeholder="File"
                                                                :error="'jetty_2_c_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_c_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_c_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan lantai ponton tidak
                                            penyok dan harus rata
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_c_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_c_2_value: @entangle('jetty_2_c_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_c_2_value"
                                                    id="jetty_2_c_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_c_2_value === 'Tidak' || jetty_2_c_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_c_2_note"
                                                            id="jetty_2_c_2_note" placeholder="Keterangan"
                                                            :error="'jetty_2_c_2_note'" />
                                                    </div>
                                                    @if ($jetty_2_c_2_file && !Illuminate\Support\Str::contains($jetty_2_c_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_c_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_c_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_c_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_c_2_file"
                                                                id="jetty_2_c_2_file" placeholder="File"
                                                                :error="'jetty_2_c_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_c_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_c_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan jembatan ponton rata
                                            dan
                                            stabil
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_c_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_c_3_value: @entangle('jetty_2_c_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_c_3_value"
                                                    id="jetty_2_c_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_c_3_value === 'Tidak' || jetty_2_c_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_c_3_note"
                                                            id="jetty_2_c_3_note" placeholder="Keterangan"
                                                            :error="'jetty_2_c_3_note'" />
                                                    </div>
                                                    @if ($jetty_2_c_3_file && !Illuminate\Support\Str::contains($jetty_2_c_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_c_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_c_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_c_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_c_3_file"
                                                                id="jetty_2_c_3_file" placeholder="File"
                                                                :error="'jetty_2_c_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_c_3 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_c_4_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan lantai jembatan tidak
                                            licin
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_c_4 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_c_4_value: @entangle('jetty_2_c_4_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_c_4_value"
                                                    id="jetty_2_c_4_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_c_4_value === 'Tidak' || jetty_2_c_4_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_c_4_note"
                                                            id="jetty_2_c_4_note" placeholder="Keterangan"
                                                            :error="'jetty_2_c_4_note'" />
                                                    </div>
                                                    @if ($jetty_2_c_4_file && !Illuminate\Support\Str::contains($jetty_2_c_4_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_c_4_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_c_4_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_c_4_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_c_4_file"
                                                                id="jetty_2_c_4_file" placeholder="File"
                                                                :error="'jetty_2_c_4_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_c_4 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">D. Drum Penyangga Ponton</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_d_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan drum tidak penyok dan
                                            tidak bocor
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_d_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_d_1_value: @entangle('jetty_2_d_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_d_1_value"
                                                    id="jetty_2_d_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_d_1_value === 'Tidak' || jetty_2_d_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_d_1_note"
                                                            id="jetty_2_d_1_note" placeholder="Keterangan"
                                                            :error="'jetty_2_d_1_note'" />
                                                    </div>
                                                    @if ($jetty_2_d_1_file && !Illuminate\Support\Str::contains($jetty_2_d_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_d_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_d_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_d_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_d_1_file"
                                                                id="jetty_2_d_1_file" placeholder="File"
                                                                :error="'jetty_2_d_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_d_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_d_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan drum penyangga ponton
                                            tidak tenggelam.
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_d_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_d_2_value: @entangle('jetty_2_d_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_d_2_value"
                                                    id="jetty_2_d_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_d_2_value === 'Tidak' || jetty_2_d_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_d_2_note"
                                                            id="jetty_2_d_2_note" placeholder="Keterangan"
                                                            :error="'jetty_2_d_2_note'" />
                                                    </div>
                                                    @if ($jetty_2_d_2_file && !Illuminate\Support\Str::contains($jetty_2_d_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_d_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_d_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_d_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_d_2_file"
                                                                id="jetty_2_d_2_file" placeholder="File"
                                                                :error="'jetty_2_d_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_d_2 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">E. Jembatan Penghubung antara
                                            Ponton dengan bundwall</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_e_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan jembatan penghubung
                                            antara ponton dan bundwall tidak tergenang air
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_e_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_e_1_value: @entangle('jetty_2_e_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_e_1_value"
                                                    id="jetty_2_e_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_e_1_value === 'Tidak' || jetty_2_e_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_e_1_note"
                                                            id="jetty_2_e_1_note" placeholder="Keterangan"
                                                            :error="'jetty_2_e_1_note'" />
                                                    </div>
                                                    @if ($jetty_2_e_1_file && !Illuminate\Support\Str::contains($jetty_2_e_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_e_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_e_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_e_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_e_1_file"
                                                                id="jetty_2_e_1_file" placeholder="File"
                                                                :error="'jetty_2_e_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_e_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_e_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan jembatan penghubung
                                            antara ponton dan bundwall stabil dan kuat
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_e_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_e_2_value: @entangle('jetty_2_e_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_e_2_value"
                                                    id="jetty_2_e_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_e_2_value === 'Tidak' || jetty_2_e_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_e_2_note"
                                                            id="jetty_2_e_2_note" placeholder="Keterangan"
                                                            :error="'jetty_2_e_2_note'" />
                                                    </div>
                                                    @if ($jetty_2_e_2_file && !Illuminate\Support\Str::contains($jetty_2_e_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_e_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_e_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_e_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_e_2_file"
                                                                id="jetty_2_e_2_file" placeholder="File"
                                                                :error="'jetty_2_e_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_e_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_e_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan lantai jembatan tidak
                                            licin
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_e_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_e_3_value: @entangle('jetty_2_e_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_e_3_value"
                                                    id="jetty_2_e_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_e_3_value === 'Tidak' || jetty_2_e_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_e_3_note"
                                                            id="jetty_2_e_3_note" placeholder="Keterangan"
                                                            :error="'jetty_2_e_3_note'" />
                                                    </div>
                                                    @if ($jetty_2_e_3_file && !Illuminate\Support\Str::contains($jetty_2_e_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_e_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_e_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_e_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_e_3_file"
                                                                id="jetty_2_e_3_file" placeholder="File"
                                                                :error="'jetty_2_e_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_e_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">F. Kebersihan</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_f_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan di jembatan ponton
                                            tidak
                                            ada sampah
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_f d-flex flex-column gap-3"
                                                x-data="{ jetty_2_f_value: @entangle('jetty_2_f_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_f_value" id="jetty_2_f_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_f_value === 'Tidak' || jetty_2_f_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_f_note"
                                                            id="jetty_2_f_note" placeholder="Keterangan"
                                                            :error="'jetty_2_f_note'" />
                                                    </div>
                                                    @if ($jetty_2_f_file && !Illuminate\Support\Str::contains($jetty_2_f_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_f_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_f_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_f_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_f_file"
                                                                id="jetty_2_f_file" placeholder="File"
                                                                :error="'jetty_2_f_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_f -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">G. Apar</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_g_label" class="col-lg-4 col-md-12 col-form-label">APAR
                                            dalam keadaan layak operasi ditandai dengan kartu checklist (cek secara
                                            periodik pada tgl 1 sd 10 setiap bulannya) dan jarum menunjukkan warna hijau
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_g d-flex flex-column gap-3"
                                                x-data="{ jetty_2_g_value: @entangle('jetty_2_g_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_g_value" id="jetty_2_g_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_g_value === 'Tidak' || jetty_2_g_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_g_note"
                                                            id="jetty_2_g_note" placeholder="Keterangan"
                                                            :error="'jetty_2_g_note'" />
                                                    </div>
                                                    @if ($jetty_2_g_file && !Illuminate\Support\Str::contains($jetty_2_g_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_g_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_g_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_g_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_g_file"
                                                                id="jetty_2_g_file" placeholder="File"
                                                                :error="'jetty_2_g_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_g -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">H. Kondisi sungai</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_h_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan permukaan air sungai
                                            tidak menunjukkan adanya cemaran minyak yang di tandai warna pelangi di
                                            permukaan air sungai
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_h d-flex flex-column gap-3"
                                                x-data="{ jetty_2_h_value: @entangle('jetty_2_h_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_h_value" id="jetty_2_h_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_h_value === 'Tidak' || jetty_2_h_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_h_note"
                                                            id="jetty_2_h_note" placeholder="Keterangan"
                                                            :error="'jetty_2_h_note'" />
                                                    </div>
                                                    @if ($jetty_2_h_file && !Illuminate\Support\Str::contains($jetty_2_h_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_h_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_h_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_h_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_h_file"
                                                                id="jetty_2_h_file" placeholder="File"
                                                                :error="'jetty_2_h_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_h -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">I. Oil spill boom</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_i_1_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan oil spill boom dalam
                                            kondisi tidak robek
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_i_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_i_1_value: @entangle('jetty_2_i_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_i_1_value"
                                                    id="jetty_2_i_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_i_1_value === 'Tidak' || jetty_2_i_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_i_1_note"
                                                            id="jetty_2_i_1_note" placeholder="Keterangan"
                                                            :error="'jetty_2_i_1_note'" />
                                                    </div>
                                                    @if ($jetty_2_i_1_file && !Illuminate\Support\Str::contains($jetty_2_i_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_i_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_i_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_i_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_i_1_file"
                                                                id="jetty_2_i_1_file" placeholder="File"
                                                                :error="'jetty_2_i_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_i_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_i_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan oil spill boom tidak
                                            ada bagian yang tenggelam
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_i_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_i_2_value: @entangle('jetty_2_i_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_i_2_value"
                                                    id="jetty_2_i_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_i_2_value === 'Tidak' || jetty_2_i_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_i_2_note"
                                                            id="jetty_2_i_2_note" placeholder="Keterangan"
                                                            :error="'jetty_2_i_2_note'" />
                                                    </div>
                                                    @if ($jetty_2_i_2_file && !Illuminate\Support\Str::contains($jetty_2_i_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_i_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_i_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_i_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_i_2_file"
                                                                id="jetty_2_i_2_file" placeholder="File"
                                                                :error="'jetty_2_i_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_i_2 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_i_3_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan oil spill boom terikat
                                            kuat dan terpasang dengan benar
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_i_3 d-flex flex-column gap-3"
                                                x-data="{ jetty_2_i_3_value: @entangle('jetty_2_i_3_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_i_3_value"
                                                    id="jetty_2_i_3_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_i_3_value === 'Tidak' || jetty_2_i_3_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_i_3_note"
                                                            id="jetty_2_i_3_note" placeholder="Keterangan"
                                                            :error="'jetty_2_i_3_note'" />
                                                    </div>
                                                    @if ($jetty_2_i_3_file && !Illuminate\Support\Str::contains($jetty_2_i_3_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_i_3_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_i_3_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_i_3_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_i_3_file"
                                                                id="jetty_2_i_3_file" placeholder="File"
                                                                :error="'jetty_2_i_3_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_i_3 -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">J. Rambu - Rambu</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_j_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan Rambu-rambu tidak rusak
                                            dan dapat terbaca
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_j d-flex flex-column gap-3"
                                                x-data="{ jetty_2_j_value: @entangle('jetty_2_j_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_j_value" id="jetty_2_j_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_j_value === 'Tidak' || jetty_2_j_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_j_note"
                                                            id="jetty_2_j_note" placeholder="Keterangan"
                                                            :error="'jetty_2_j_note'" />
                                                    </div>
                                                    @if ($jetty_2_j_file && !Illuminate\Support\Str::contains($jetty_2_j_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_j_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_j_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_j_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_j_file"
                                                                id="jetty_2_j_file" placeholder="File"
                                                                :error="'jetty_2_j_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_j -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">K. Oil Dispersan</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_k_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan terdapat oil dispersan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_k d-flex flex-column gap-3"
                                                x-data="{ jetty_2_k_value: @entangle('jetty_2_k_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_k_value" id="jetty_2_k_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_k_value === 'Tidak' || jetty_2_k_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_k_note"
                                                            id="jetty_2_k_note" placeholder="Keterangan"
                                                            :error="'jetty_2_k_note'" />
                                                    </div>
                                                    @if ($jetty_2_k_file && !Illuminate\Support\Str::contains($jetty_2_k_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_k_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_k_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_k_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_k_file"
                                                                id="jetty_2_k_file" placeholder="File"
                                                                :error="'jetty_2_k_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_k -->

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">L. Lampu Sorot</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_2_l_label"
                                            class="col-lg-4 col-md-12 col-form-label">Pastikan Lampu Sorot dapat
                                            menyala
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_2_l d-flex flex-column gap-3"
                                                x-data="{ jetty_2_l_value: @entangle('jetty_2_l_value') }">
                                                <x-inputs.select2 wire:model="jetty_2_l_value" id="jetty_2_l_value"
                                                    class="form-select" placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_2_l_value === 'Tidak' || jetty_2_l_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_2_l_note"
                                                            id="jetty_2_l_note" placeholder="Keterangan"
                                                            :error="'jetty_2_l_note'" />
                                                    </div>
                                                    @if ($jetty_2_l_file && !Illuminate\Support\Str::contains($jetty_2_l_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_2_l_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_2_l_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_2_l_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_2_l_file"
                                                                id="jetty_2_l_file" placeholder="File"
                                                                :error="'jetty_2_l_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_2_l -->

                                </div><!-- ./content-jetty_2 -->

                            </div>
                        </div><!-- /.jetty_2 -->

                        <div id="jetty_3" class="section-jetty_3" x-data="{ accordionOpen: false }">
                            <button
                                class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
                                @click.prevent="accordionOpen = ! accordionOpen">
                                <h6 class="mb-0 fw-normal title-accordion">3. PERAWATAN DAN PERBAIKAN</h6>
                                <span x-bind:class="accordionOpen ? 'open' : ''"><img
                                        src="{{ asset('/images/icons/angle-down.png') }}" alt="" /></span>
                            </button>
                            <div class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
                                x-ref="jetty_3" x-bind:style="accordionOpen ? 'max-height: ' + 20000 + 'px' : ''"
                                x-transition.delay.5000ms>

                                <div class="content-section p-4" wire:ignore.self>

                                    <div class="row form-group mb-4">
                                        <h4 class="col-lg-12 col-md-12 col-form-label">A. Perawatan dan Perbaikan</h4>
                                    </div>

                                    <div class="row form-group mb-4">
                                        <label for="jetty_3_a_1_label" class="col-lg-4 col-md-12 col-form-label">1.
                                            P2H Peralatan
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_3_a_1 d-flex flex-column gap-3"
                                                x-data="{ jetty_3_a_1_value: @entangle('jetty_3_a_1_value') }">
                                                <x-inputs.select2 wire:model="jetty_3_a_1_value"
                                                    id="jetty_3_a_1_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_3_a_1_value === 'Tidak' || jetty_3_a_1_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_3_a_1_note"
                                                            id="jetty_3_a_1_note" placeholder="Keterangan"
                                                            :error="'jetty_3_a_1_note'" />
                                                    </div>
                                                    @if ($jetty_3_a_1_file && !Illuminate\Support\Str::contains($jetty_3_a_1_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_3_a_1_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_3_a_1_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_3_a_1_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_3_a_1_file"
                                                                id="jetty_3_a_1_file" placeholder="File"
                                                                :error="'jetty_3_a_1_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_3_a_1 -->

                                    <div class="row form-group mb-4">
                                        <label for="jetty_3_a_2_label"
                                            class="col-lg-4 col-md-12 col-form-label">Perawatan drainase dan oil trap
                                            sesuai jadwal
                                        </label>
                                        <div class="col-lg-8 col-md-12">
                                            <div class="wrapper_jetty_3_a_2 d-flex flex-column gap-3"
                                                x-data="{ jetty_3_a_2_value: @entangle('jetty_3_a_2_value') }">
                                                <x-inputs.select2 wire:model="jetty_3_a_2_value"
                                                    id="jetty_3_a_2_value" class="form-select"
                                                    placeholder="Pemenuhan">
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                    <option value="N/A">N/A</option>
                                                </x-inputs.select2>

                                                <div x-cloak
                                                    x-show="jetty_3_a_2_value === 'Tidak' || jetty_3_a_2_value === '5' ">
                                                    <div>
                                                        <x-kplh-texteditor wire:model="jetty_3_a_2_note"
                                                            id="jetty_3_a_2_note" placeholder="Keterangan"
                                                            :error="'jetty_3_a_2_note'" />
                                                    </div>
                                                    @if ($jetty_3_a_2_file && !Illuminate\Support\Str::contains($jetty_3_a_2_file, 'private/var/folders/'))
                                                        <div class="row mt-3">
                                                            <div class="col-md-3"><button type="button"
                                                                    class="btn btn-outline-secondary"
                                                                    wire:click="setFileNull('jetty_3_a_2_file')"><i
                                                                        class="fa fa-edit"></i> Ubah
                                                                    File</button></div>
                                                            <div class="col-md-9">
                                                                <a class="btn btn-outline-secondary"
                                                                    href="{{ route('kplh::download-file', ['jetty', $jetty_3_a_2_file]) }}"
                                                                    target="_blank"><i class="fa fa-file"></i>
                                                                    {{ Illuminate\Support\Str::limit($jetty_3_a_2_file, 30) }}</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mt-3">
                                                            <x-kplh-file wire:model="jetty_3_a_2_file"
                                                                id="jetty_3_a_2_file" placeholder="File"
                                                                :error="'jetty_3_a_2_file'" />
                                                        </div>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- /.form-group jetty_3_a_2 -->

                                </div><!-- ./content-jetty_3 -->

                            </div>
                        </div><!-- /.jetty_3 -->

                        <hr>
                        <div class="row form-group">
                            <label for="tanggal_service" class="col col-form-label">Ringkasan Hasil Inspeksi</label>
                            <div class="col-8">
                                <x-kplh-texteditor wire:model="summary" id="summary"
                                    placeholder="Ringkasan Hasil Inspeksi" :error="'summary'" />
                            </div>
                        </div><!-- /.form-group tanggal_service -->

                        <div class="space">
                            <hr>
                        </div>

                        <div class="footer-action mb-2 p-3">
                            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">

                                <a href="javascript:history.go(-1)" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" wire:click="$set('mode','draft')"
                                    class="btn btn-outline-warning d-flex justify-content-center align-item-center position-relative px-4">Save
                                    Draft</button>
                                <button type="submit" wire:click="$set('mode','save')"
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4">Save</button>

                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div><!-- /.content-inspeksi-area-maintank -->

</div><!-- /.inner-content -->

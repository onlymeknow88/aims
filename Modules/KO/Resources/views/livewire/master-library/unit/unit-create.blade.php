<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="#" onclick="history.back();"
               class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>KO</span>
            </a>
        </div>
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div>
    </div>

    <div class="addnew-maker-content container py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Tambah Unit</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ko_spip_category_id" class="col-sm-4 col-form-label">Kategori SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="ko_spip_category_id" id="ko_spip_category_id" placeholder="Select Kategori SPIP" data-child="ko_spip_type_id,ko_brand_id,ko_spip_unit_id">
                                    @foreach ($ko_spip_categories as $key => $ko_spip_category)
                                        <option
                                            value="{{ $ko_spip_category->id }}">{{$ko_spip_category->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Klasifikasi SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="ko_spip_type_id" id="ko_spip_type_id" placeholder="Select Klasifikasi SPIP" data-child="ko_spip_unit_id" :disabled="empty($ko_spip_category_id)">
                                    @foreach ($ko_spip_types as $key => $spip_type)
                                        <option
                                            value="{{ $spip_type->id }}">{{$spip_type->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Deskripsi SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="ko_spip_unit_id" id="ko_spip_unit_id" placeholder="Select Unit SPIP" :disabled="empty($ko_spip_type_id)">
                                    @foreach ($ko_spip_units as $key => $spip_unit)
                                        <option
                                            value="{{ $spip_unit->id }}">{{$spip_unit->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Call Sign</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="call_sign" id="call_sign" placeholder="Call Sign" :error="'call_sign'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="brand" class="col-sm-4 col-form-label">Nomor STNK/IMB</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="identity_number" id="identity_number" placeholder="Nomor STNK/IMB" :error="'identity_number'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Merk / Brand SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model.defer="ko_brand_id" id="ko_brand_id" placeholder="Select Brand SPIP" :disabled="empty($ko_spip_category_id)">
                                    @foreach ($ko_brands as $key => $ko_brand)
                                        <option
                                            value="{{ $ko_brand->id }}">{{$ko_brand->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Nomor Serial SPIP</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="serial_number" id="serial_number" placeholder="Nomor Serial SPIP" :error="'serial_number'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group">
                            <label for="brand" class="col-sm-4 col-form-label">Model Unit</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="model_unit" id="model_unit" placeholder="Model Unit" :error="'model_unit'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Tahun Pembuatan Unit SPIP</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="number" wire:model.defer="production_year" id="production_year" min="1900" max="2099" step="1" placeholder="Tahun Pembuatan Unit SPIP" :error="'production_year'"></x-inputs.text>
                            </div>
                        </div>
                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="#" onclick="history.back();"
                               class="btn btn-outline-secondary">Cancel</a>
                            <a href="#" wire:click="store()"
                               class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Submit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

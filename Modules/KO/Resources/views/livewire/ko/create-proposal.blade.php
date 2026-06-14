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
                            <h5 class="fw-normal">DATA SARANA, PRASANA, INSTALASI DAN PERALATAN PERTAMBANGAN</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">CCOW</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 :error="'ccow_id'" wire:model.defer="ccow_id" id="ccow_id" placeholder="Select CCOW">
                                    @foreach ($ccows as $key => $ccow)
                                        <option
                                            value="{{ $ccow->id }}">{{$ccow->company_name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Area Kerja</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model.defer="area" id="area" placeholder="Select Area" :error="'area'">
                                    <option value="Lampunut">Lampunut</option>
                                    <option value="Haju">Haju</option>
                                    <option value="Tuhup">Tuhup</option>
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="spip_category_id" class="col-sm-4 col-form-label">Kategori SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="spip_category_id" id="spip_category_id" placeholder="Select Kategori SPIP" :error="'spip_category_id'" data-child="spip_type_id,spip_unit_id,unit_id">
                                    @foreach ($spip_categories as $key => $spip_category)
                                        <option
                                            value="{{ $spip_category->id }}">{{$spip_category->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Klasifikasi SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="spip_type_id" id="spip_type_id" placeholder="Select Klasifikasi SPIP" :error="'spip_type_id'" data-child="spip_unit_id,unit_id" :disabled="empty($spip_category_id)">
                                    @foreach ($spip_types as $key => $spip_type)
                                        <option
                                            value="{{ $spip_type->id }}">{{$spip_type->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Deskripsi SPIP</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="spip_unit_id" id="spip_unit_id" placeholder="Select Unit SPIP" :error="'spip_unit_id'" data-child="unit_id" :disabled="empty($spip_type_id)">
                                    @foreach ($spip_units as $key => $spip_unit)
                                        <option
                                            value="{{ $spip_unit->id }}">{{$spip_unit->name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Call Sign</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="unit_id" id="unit_id" placeholder="Select Call Sign" :error="'unit_id'" :disabled="empty($spip_unit_id)">
                                    @foreach ($units as $key => $unit)
                                        <option
                                            value="{{ $unit->id }}">{{$unit->call_sign}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Nomor STNK/IMB</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="identity_number" id="identity_number" placeholder="Nomor STNK/IMB" :error="'identity_number'" readonly></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Merk / Brand SPIP</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="brand" id="brand" placeholder="Merk / Brand SPIP" :error="'brand'" readonly></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Nomor Serial SPIP</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="serial_number" id="serial_number" placeholder="Nomor Serial SPIP" :error="'serial_number'" readonly></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Tahun Pembuatan Unit SPIP</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="production_year" id="production_year" placeholder="Tahun Pembuatan Unit SPIP" :error="'production_year'" readonly></x-inputs.text>
                            </div>
                        </div>

                        {{--<div class="mb-3 row form-group required">
                            <label for="brand" class="col-sm-4 col-form-label">Tujuan Penggunaan</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model="usage_purpose" id="usage_purpose" placeholder="Tujuan Penggunaan" :error="'usage_purpose'"></x-inputs.text>
                            </div>
                        </div>--}}
                    </div>

                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">DATA PENGGUNA</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Perusahaan</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model="company_id" id="company_id" placeholder="Select Perusahaan" :error="'company_id'" data-child="department_id">
                                    @foreach ($companies as $key => $company)
                                        <option
                                            value="{{ $company->id }}">{{$company->company_name}}</option>
                                    @endforeach
                                </x-ko-select-2>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">Department</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model.defer="department_id" id="department_id" placeholder="Select Department" :error="'department_id'" :disabled="empty($company_id)">
                                    @foreach ($departments as $key => $department)
                                        <option
                                            value="{{ $department->id }}">{{$department->name}}</option>
                                    @endforeach
                                    <option value="other">-- Other --</option>
                                </x-ko-select-2>
                            </div>
                        </div>

                        @if ($department_id === 'other')
                            <div class="mb-3 row form-group required">
                                <label for="applicant_email" class="col-sm-4 col-form-label">Other Department</label>
                                <div class="col-sm-8">
                                    <x-inputs.text type="text" wire:model.defer="other_department" id="other_department" placeholder="Other Department" :error="'other_department'"></x-inputs.text>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3 row form-group required">
                            <label for="applicant_email" class="col-sm-4 col-form-label">Alamat Email Pemohon</label>
                            <div class="col-sm-8">
                                <x-inputs.text type="text" wire:model.defer="applicant_email" id="applicant_email" placeholder="Alamat Email Pemohon" :error="'applicant_email'"></x-inputs.text>
                            </div>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="ccow_id" class="col-sm-4 col-form-label">PJO</label>
                            <div class="col-sm-8">
                                <x-ko-select-2 wire:model.defer="pjo_id" id="pjo_id" placeholder="Select PJO" :error="'pjo_id'">
                                    @foreach ($pjo as $key => $value)
                                        <option
                                            value="{{ $value->id }}">{{$value->name}}</option>
                                    @endforeach                                    
                                </x-ko-select-2>
                            </div>
                        </div>
                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="#" onclick="history.back();"
                               class="btn btn-outline-secondary">Cancel</a>
                            <a href="#" wire:click="store()"
                               class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Next</a>
                            {{--<div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="save(1)" class="dropdown-item"
                                            href="#">
                                            Submit as Draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="save(0)" class="dropdown-item"
                                            href="#">
                                            Submit
                                        </button>
                                    </li>
                                </ul>
                            </div>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

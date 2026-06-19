<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">

        <div class="left-header">
            <a href="{{ route('pica::listing.active-document.index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New PICA</span>
            </a>
        </div><!-- /.left-header -->

        <div class="right-header">
            <div class="text-white">Last update {{ Carbon\Carbon::now()->format('M d, Y . H.i A') }}</div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Informasi Umum</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="title" class="col-sm-4 col-form-label">Source NCAR</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="source" id="source" placeholder="Select Source">
                                    @foreach (App\Enums\PicaSource::asSelectArray() as $key => $item)
                                        <option value="{{ $key }}">{{ $key }}</option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="ccow" class="col-sm-4 col-form-label">Inspection Type</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="type" id="type" placeholder="Select Type">
                                    <option value="Inspeksi Area Kerja Daily">
                                        Inspeksi Area Kerja Daily
                                    </option>
                                    <option value="Inspeksi Area Kerja Weekly">
                                        Inspeksi Area Kerja Weekly
                                    </option>
                                    <option value="Inspeksi Area Kerja Bi-Weekly">
                                        Inspeksi Area Kerja Bi-Weekly
                                    </option>
                                    <option value="Inspeksi Area Kerja Monthly">
                                        Inspeksi Area Kerja Monthly
                                    </option>
                                    <option value="Inspeksi SSMI (Senior Site Management Inspection)">
                                        Inspeksi SSMI (Senior Site Management Inspection)
                                    </option>
                                    <option value="Inspeksi Hydrant">
                                        Inspeksi Hydrant
                                    </option>
                                    <option value="Inspeksi APAR">
                                        Inspeksi APAR
                                    </option>
                                    <option value="Inspeksi Alat Rescue">
                                        Inspeksi Alat Rescue
                                    </option>
                                    <option value="Inspeksi Peralatan Medis">
                                        Inspeksi Peralatan Medis
                                    </option>
                                    <option value="Inspeksi Speed gun">
                                        Inspeksi Speed gun
                                    </option>
                                    <option value="Inspeksi Hygiene">
                                        Inspeksi Hygiene
                                    </option>
                                    <option value="Kotak P3K pada Bangunan">
                                        Kotak P3K pada Bangunan
                                    </option>
                                    <option value="Inspeksi Shower Wash">
                                        Inspeksi Shower Wash
                                    </option>
                                    <option value="Inspeksi Fire Hydrant">
                                        Inspeksi Fire Hydrant
                                    </option>
                                    <option value="Inspeksi Fire Extinguisher">
                                        Inspeksi Fire Extinguisher
                                    </option>
                                    <option value="Inspeksi Eyewash">
                                        Inspeksi Eyewash
                                    </option>
                                    <option value="Planned Task Observation">
                                        Planned Task Observation
                                    </option>
                                    <option value="Take Time Talk">
                                        Take Time Talk
                                    </option>
                                    <option value="Hazard Report">
                                        Hazard Report
                                    </option>
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="title" class="col-sm-4 col-form-label">Date</label>
                            <div class="col-sm-8">
                                <x-inputs.datepicker wire:model="date" id="date" :error="'date'"
                                    placeholder="Select Date" />
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="ccow" class="col-sm-4 col-form-label">CCOW</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="ccow_id" id="ccow_id" placeholder="Select CCOW"
                                    data-child="section_id">
                                    @foreach ($this->ccows as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="company" class="col-sm-4 col-form-label">Perusahaan</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="company_id" id="company_id" placeholder="Select Company"
                                    data-child="pjo_id">
                                    @foreach ($this->companies as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="company" class="col-sm-4 col-form-label">Detail Perusahaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" wire:model="detail_company"
                                    placeholder="Detail Company" disabled />
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="company" class="col-sm-4 col-form-label">Section</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="section_id" id="section_id" placeholder="Select Section"
                                    data-child="area_location_id,pja_id" :disabled="!$ccow_id">
                                    @foreach ($this->sections as $key => $section)
                                        <option value="{{ $section->id }}">{{ $section->department->name }} -
                                            {{ $section->name }}</option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="company" class="col-sm-4 col-form-label">Location</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="area_location_id" id="area_location_id"
                                    placeholder="Select Area Location" :disabled="!$section_id">
                                    @foreach ($this->areaLocations as $key => $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">
                            <label for="company" class="col-sm-4 col-form-label">Detail Location</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="4" wire:model.defer="detail_location" placeholder="Detail Location"></textarea>
                            </div>
                        </div><!-- /.form-group -->

                    </div><!-- /.own-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Verificator</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <label for="title" class="col-sm-4 col-form-label">Initiator/Auditor</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" wire:model.defer="auditor"
                                    placeholder="Initiator/Auditor" />
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">
                            <label for="pj" class="col-sm-4 col-form-label">Penanggung Jawab Area</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="pja_id" id="pja_id" name="pja_id"
                                    placeholder="Select Select PJA" :disabled="!$section_id">
                                    @foreach ($this->areaManagers as $key => $areaManager)
                                        <option value="{{ $areaManager->id }}">
                                            {{ $areaManager->user->name ?? null }} -
                                            {{ $areaManager->user->email ?? null }}
                                        </option>
                                    @endforeach
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">
                            <label for="pj" class="col-sm-4 col-form-label">KTT/PJO</label>
                            <div class="col-sm-8">
                                <x-pica-select2 wire:model="pjo_id" id="pjo_id" name="pjo_id"
                                    placeholder="Select Select PJO/KTT" :disabled="!$company_id">
                                    <option value="{{ $company_type->user_id ?? null }}">
                                        {{ $company_type->user->name ?? null }}
                                    </option>
                                </x-pica-select2>
                            </div>
                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Date</h5>
                        </div>

                        <div class="mb-3 row form-group required">
                            <div class="col-sm-6">
                                <x-inputs.datepicker wire:model="target_date" id="target_date" :error="'target_date'"
                                    placeholder="Select Target Settlement Date" />
                            </div>
                            <div class="col-sm-6">
                                <x-inputs.datepicker wire:model="settlement_date" id="settlement_date"
                                    :error="'settlement_date'" placeholder="Select Settlement Date" />
                            </div>
                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="mb-3 row form-group">
                        <label for="company" class="col-form-label">
                            Description Non Compliance
                        </label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="7" wire:model.defer="non_compliance" placeholder="Non Compliance"></textarea>
                        </div>
                    </div><!-- /.form-group -->

                    <div class="mb-5 row form-group">
                        <label for="company" class="col-form-label">
                            Description Non Compliance Root Cause
                        </label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="7" wire:model.defer="non_compliance_root"
                                placeholder="Non Compliance Root Cause"></textarea>
                        </div>
                    </div><!-- /.form-group -->

                    <div class="mb-5 row form-group">
                        <label for="corrective_action" class="col-form-label">
                            Corrective Action/Agreed prevention
                        </label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="7" wire:model.defer="corrective_action" placeholder="Corrective Action"></textarea>
                        </div>
                    </div><!-- /.form-group -->

                    <div class="mb-5 row form-group">
                        <label for="remarks" class="col-form-label">
                            Remarks
                        </label>
                        <div class="col-sm-12">
                            <textarea class="form-control" rows="7" wire:model.defer="remarks" placeholder="Remarks"></textarea>
                        </div>
                    </div><!-- /.form-group -->

                    <div class="map-info mb-5">
                        <div class="mb-5">
                            <h5 class="fw-normal">
                                Evidance
                            </h5>
                        </div>
                        <div class="row mb-3 form-group required">
                            <div class="col-sm-12">
                                <div class="">
                                    <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                        style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                        type="button">
                                        <span><img src="{{ asset('/images/icons/upload.png') }}"
                                                alt="image upload" /></span>
                                        <span class="text-upload">Drop or <a href="#">Select
                                                File</a></span>
                                        <input type="file" name="" id=""
                                            wire:model="temporaryFile" accept=".pdf, .png, .jpeg, .jpg" multiple />
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="row form-group mb-3 m-1">
                        @foreach ($evidances as $keyFile => $itemFile)
                            {{-- <div class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                <div>
                                    <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                    <span>
                                        {{ $itemFile['name'] }}
                                    </span>
                                </div>
                                <span>
                                    {{ $itemFile['size'] }}
                                </span>
                            </div>
                            <div class="col-sm-1 text-center p-2" wire:click="removeFile({{ $loop->index }})">
                                <button type="button" class="btn btn-light-secondary text-center"
                                    wire:click="removeFile({{ $loop->index }})">
                                    <i class="fa fa-x"></i>
                                </button>
                            </div> --}}
                            <div class="col-md-3 mb-2 bg-white p-2 file-list" style="margin-right: 10px">
                                <div class="review-box">
                                    <div class="header d-flex align-items-center justify-content-between">
                                        <img src="{{ asset('/images/icons/pdf.png') }}" alt="pdf" />
                                        <img class="delete-icon cursor-pointer"
                                            wire:click="removeFile({{ $loop->index }})"
                                            src="{{ asset('images/icons/delete.png') }}" alt="">
                                    </div>
                                    <div class="body mt-4">
                                        <p class="name">{{ $itemFile['name'] }}</p>
                                        <p class="size">{{ $itemFile['size'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="footer-action mb-2">

                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('pica::listing.active-document.index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="saved('Draft')" class="dropdown-item"
                                            href="#">
                                            Submit as draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="saved('Publish')" class="dropdown-item"
                                            href="#">
                                            Submit for review
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="saveDocument" class="dropdown-item"
                                            href="#">
                                            Save Document
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->
</div>

@push('styles')
    <style>
        .btn-light-secondary {
            background-color: #f5f5f5;
            color: #000;
        }

        .btn-light-secondary:hover {
            background-color: #adadad;
            color: #fff;
        }

        .file-list {
            border: 1px solid #cdcdcd;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            //    
        });
    </script>
@endpush

<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('field-leadership::listing.active.index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New Field Leadership</span>
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

                            <label for="title" class="col-sm-4 col-form-label">Tanggal</label>

                            <div class="col-sm-8">
                                <x-field-leadership-datepicker wire:model="date" id="date" :error="'date'" />
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="ccow" class="col-sm-4 col-form-label">CCOW</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="ccow_id" id="ccow_id"
                                    placeholder="Select CCOW" data-child="department_id,section_id,area_location_id,pja_id">

                                    @foreach ($this->ccows as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Perusahaan</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="company_id" id="company_id"
                                    placeholder="Select Company">

                                    @foreach ($this->companies as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Detail Perusahaan</label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control @error('detail_company') is-invalid @enderror"
                                    id="detail_company" wire:model="detail_company" placeholder="Detail Company"
                                    disabled>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="department" class="col-sm-4 col-form-label">Department</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="department_id" id="department_id"
                                    placeholder="Select Department" data-child="section_id,area_location_id,pja_id"
                                    :disabled="empty($ccow_id)">

                                    @foreach ($this->departments as $key => $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Section</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="section_id" id="section_id"
                                    placeholder="Select Section" data-child="area_location_id,pja_id"
                                    :disabled="empty($department_id)">

                                    @foreach ($this->sections as $key => $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="company" class="col-sm-4 col-form-label">Location</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="area_location_id" id="area_location_id"
                                    placeholder="Select Area Location"
                                    :disabled="empty($section_id)">

                                    @foreach ($this->areaLocations as $key => $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="company" class="col-sm-4 col-form-label">Detail Location</label>

                            <div class="col-sm-8">

                                <textarea class="form-control" rows="4" wire:model="detail_location" placeholder="Detail Location"></textarea>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.own-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Penanggung Jawab</h5>
                        </div>

                        <div class="mb-3 row form-group required">

                            <label for="pj" class="col-sm-4 col-form-label">Penanggung Jawab Area</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="pja_id" id="pja_id" name="pja_id"
                                    placeholder="Select Select PJA"
                                    :disabled="empty($section_id)">

                                    @foreach ($this->areaManagers as $key => $areaManager)
                                        <option value="{{ $areaManager->id }}">
                                            {{ $areaManager->user->name ?? null }}
                                        </option>
                                    @endforeach

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="pj" class="col-sm-4 col-form-label">KTT/PJO</label>

                            <div class="col-sm-8">

                                <x-field-leadership-select2 wire:model="pjo_id" id="pjo_id" name="pjo_id"
                                    placeholder="Select Select KTT/PJO">

                                    <option value="{{ $company_type->user_id ?? null }}">
                                        {{ $company_type->user->name ?? null }}
                                    </option>

                                </x-field-leadership-select2>

                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group required">

                            <label for="modules" class="col-sm-4 col-form-label">Jenis Field Leadership</label>

                            <div class="col-sm-8">

                                <x-inputs.type-field-leadership wire:model="type" id="type" :error="'type'" />
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="modules" class="col-sm-4 col-form-label">Tugas / SOP / WI yang diamati
                            </label>

                            <div class="col-sm-8">

                                <textarea class="form-control" rows="4" wire:model="job" placeholder="Tugas / SOP / WI yang diamati"></textarea>
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="modules" class="col-sm-4 col-form-label">Personil Yang Diamati
                            </label>

                            <div class="col-sm-8">

                                <input type="number"
                                    class="form-control @error('personil_on_review') is-invalid @enderror"
                                    id="personil_on_review" wire:model="personil_on_review"
                                    placeholder="Jumlah Personil Yang Diamati" aria-describedby="basic-addon4">
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group">

                            <label for="modules" class="col-sm-4 col-form-label">Nama Personil Yang Diamati
                            </label>

                            <div class="col-sm-8">

                                <input type="text"
                                    class="form-control @error('personil_on_review_name') is-invalid @enderror"
                                    id="personil_on_review_name" wire:model="personil_on_review_name"
                                    autocomplete="off" placeholder="Nama Personel Yang Diamati"
                                    aria-describedby="basic-addon4">
                            </div>

                        </div><!-- /.form-group -->


                        @if ($showQuestion)
                            <div class="mb-5">
                                <h5 class="fw-normal">Pertanyaan</h5>
                            </div>

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 1
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question1 }}
                                            <input type="text" wire:model="question1" hidden>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-field-leadership-select2 wire:model="answer1" id="answer1"
                                                placeholder="Select Answer">
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </x-field-leadership-select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description1" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 2
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question2 }}
                                            <input type="text" wire:model="question2" hidden>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-field-leadership-select2 wire:model="answer2" id="answer2"
                                                placeholder="Select Answer">
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </x-field-leadership-select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description2" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 3
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question3 }}
                                            <input type="text" wire:model="question3" hidden>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description3" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 4
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question4 }}
                                            <input type="text" wire:model="question4" hidden>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-field-leadership-select2 wire:model="answer4" id="answer4"
                                                placeholder="Select Answer">
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </x-field-leadership-select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description4" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 5
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question5 }}
                                            <input type="text" wire:model="question5" hidden>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-field-leadership-select2 wire:model="answer5" id="answer5"
                                                placeholder="Select Answer">
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </x-field-leadership-select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description5" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group required">

                                <label for="modules" class="col-sm-4 col-form-label">Pertanyaan Ke - 6
                                </label>

                                <div class="col-sm-8">
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            {{ $question6 }}
                                            <input type="text" wire:model="question6" hidden>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <x-field-leadership-select2 wire:model="answer6" id="answer6"
                                                placeholder="Select Answer">
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </x-field-leadership-select2>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea type="text" wire:model="description6" class="form-control" rows="2" placeholder="Description"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- /.form-group -->
                        @endif


                    </div><!-- /.map-info -->

                    {{-- <div class="mb-3 row form-group">

                        <label for="company" class="col-sm-4 col-form-label">
                            Non Compliance Root Cause
                        </label>

                        <div class="col-sm-8">

                            <textarea class="form-control" rows="4" wire:model="non_compliance_root"
                                placeholder="Non Compliance Root Cause"></textarea>

                        </div>

                    </div><!-- /.form-group --> --}}

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Anggota Tim</h5>
                        </div>

                        @foreach ($member as $item)
                            <div class="row mb-3 form-group required">

                                <div class="col-sm-4">

                                    <x-field-leadership-select2 wire:model="member.{{ $loop->index }}.type"
                                        id="member.{{ $loop->index }}.type" placeholder="Select Type"
                                        data-child="member.{{ $loop->index }}.employee_id">

                                        @foreach (App\Enums\CompanyType::asSelectArray() as $key => $item)
                                            <option value="{{ $key }}">{{ $key }}</option>
                                        @endforeach

                                    </x-field-leadership-select2>

                                </div>

                                <div class="{{ count($member) == 1 ? 'col-sm-8' : 'col-sm-7' }}">

                                    <x-field-leadership-select2 wire:model="member.{{ $loop->index }}.employee_id"
                                        id="member.{{ $loop->index }}.employee_id" name="employee_id"
                                        placeholder="Select Employee"
                                        :disabled="empty($member[$loop->index]['type'])">

                                        @if ($member[$loop->index]['type'] == App\Enums\CompanyType::Internal)
                                            @foreach ($this->memberInternals as $key => $val)
                                                <option value="{{ $val->id }}">
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                        @if (
                                            $member[$loop->index]['type'] == App\Enums\CompanyType::Contractor ||
                                                $member[$loop->index]['type'] == App\Enums\CompanyType::SubContractor)
                                            @foreach ($this->memberExternals as $key => $val)
                                                <option value="{{ $val->id }}">
                                                    {{ $val->name }}
                                                </option>
                                            @endforeach
                                        @endif

                                    </x-field-leadership-select2>

                                </div>

                                <div class="col-sm-1 text-center {{ count($member) == 1 ? 'd-none' : 'd-block' }}"
                                    wire:click="removeMember({{ $loop->index }})">

                                    <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removeMember({{ $loop->index }})">
                                        <i class="fa fa-x"></i>
                                    </button>

                                </div>

                            </div><!-- /.form-group -->
                        @endforeach
                        <div class="mb-3 row form-group required">

                            <div class="col-sm-4 pb-3">

                                <button type="button" class="btn btn-light-secondary text-center mt-3"
                                    wire:click="addMember" style="width: 100%;"
                                    {{ count($member) == $limit_member ? 'disabled' : '' }}>
                                    <i class="fa fa-plus"></i> Add More Teams
                                </button>

                            </div>
                            <div
                                class="col-sm-8 align-self-center {{ count($member) == $limit_member ? 'd-block' : 'd-none' }}">

                                <span>Maximum {{ $limit_member }} Person</span>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Jumlah Waktu Kunjungan</h5>
                        </div>

                        <div class="mb-3 row form-group required">

                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @error('visit_time') is-invalid @enderror" id="visit_time"
                                        wire:model="visit_time" placeholder="0" aria-describedby="basic-addon4"
                                        style="padding-left: 9px">
                                    <span
                                        class="input-group-text document-prefix @error('visit_time') is-invalid @enderror"
                                        id="basic-addon4" style="right: 0 !important; left: auto">Minute</span>
                                </div>
                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="map-info {{ $hazard_report_label ? 'd-none' : '' }}">

                        <div class="mb-5">
                            <h5 class="fw-normal">
                                {{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Positif Yang Diamati
                            </h5>
                        </div>

                        @foreach ($positive_condition as $item)
                            <div class="mb-3 row form-group required">

                                <div class=" {{ count($positive_condition) == 1 ? 'col-sm-12' : 'col-sm-11' }}">
                                    <textarea type="text" wire:model="positive_condition.{{ $loop->index }}.description" class="form-control"
                                        rows="4" placeholder="Description"></textarea>
                                </div>

                                <div class="col-sm-1 text-center {{ count($positive_condition) == 1 ? 'd-none' : 'd-block' }}"
                                    wire:click="removePositiveCondition({{ $loop->index }})">

                                    <button type="button" class="btn btn-light-secondary text-center"
                                        wire:click="removePositiveCondition({{ $loop->index }})">
                                        <i class="fa fa-x"></i>
                                    </button>

                                </div>

                            </div><!-- /.form-group -->
                        @endforeach

                    </div><!-- /.map-info -->

                    <div class="mb-5 row form-group required {{ $hazard_report_label ? 'd-none' : '' }}">

                        <div class="col-sm-12 pb-3">

                            <button type="button" class="btn btn-light-secondary text-center mt-3"
                                wire:click="addPositiveCondition" style="width: 100%;"
                                {{ count($positive_condition) < $limit_param->max_item_positive_condition ? '' : 'disabled' }}>
                                <i class="fa fa-plus"></i> Add Positive Condition
                            </button>

                        </div>
                        <div
                            class="col-sm-12 align-self-center {{ count($positive_condition) < $limit_param->max_item_positive_condition ? 'd-none' : 'd-block' }}">

                            <span>Maximum {{ $limit_param->max_item_positive_condition }} Positive Condition</span>

                        </div>

                    </div><!-- /.form-group -->

                    <div class="map-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">
                                {{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Beresiko yang Diamati
                            </h5>
                        </div>

                        @foreach ($risk_condition as $key => $item)
                            <div class="mb-3 form-group required activity-item">

                                <div class="row {{ count($risk_condition) == 1 ? 'd-none' : 'd-block' }}">
                                    <div class="col-sm-1 offset-11 text-center"
                                        wire:click="removeRiskCondition({{ $loop->index }})">

                                        <button type="button" class="btn btn-light-secondary text-center"
                                            wire:click="removeRiskCondition({{ $loop->index }})">
                                            <i class="fa fa-x"></i>
                                        </button>

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-3">
                                        <label for="">
                                            {{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }}
                                            Beresiko yang Diamati
                                            <span class="text-danger">*</span>
                                        </label>

                                        <textarea class="form-control" rows="7" wire:model="risk_condition.{{ $loop->index }}.description"
                                            placeholder="{{ $hazard_report_label ? 'Kondisi' : 'Perilaku/Kondisi' }} Beresiko yang Diamati"></textarea>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="">Kategori</label>

                                        @if ($type == 'Hazard Report')
                                            @php
                                                $risk_condition[$loop->index]['category'] = $this->categories->where('name', 'Kondisi Tidak Aman')->first()->id;
                                            @endphp

                                            <input type="text"
                                                class="form-control @error('risk_condition.{{ $loop->index }}.category') is-invalid @enderror"
                                                id="risk_condition.{{ $loop->index }}.category"
                                                value="Kondisi Tidak Aman" placeholder="Detail Company" disabled>
                                        @else
                                            <x-field-leadership-select2
                                                wire:model="risk_condition.{{ $loop->index }}.category"
                                                id="risk_condition.{{ $loop->index }}.category"
                                                name="risk_condition.{{ $loop->index }}.category"
                                                placeholder="Select Category"
                                                data-child="risk_condition.{{ $loop->index }}.type">
                                                @foreach ($this->categories->whereIn('name', ['Kondisi Tidak Aman', 'Tindakan Tidak Aman']) as $key => $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </x-field-leadership-select2>
                                        @endif

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-3 jenis_kondisi">
                                        <label
                                            for="">{{ $hazard_report_label ? 'Jenis Kondisi Tidak Aman' : 'Jenis Kondisi Tidak Aman / Tindakan Tidak Aman' }}</label>

                                        <x-field-leadership-select2
                                            wire:model="risk_condition.{{ $loop->index }}.type"
                                            id="risk_condition.{{ $loop->index }}.type"
                                            name="risk_condition.{{ $loop->index }}.type" placeholder="Select Type"
                                            :disabled="empty($risk_condition[$loop->index]['category'])">

                                            @php
                                                $category = $this->categories->where('id', $risk_condition[$loop->index]['category'])->first();
                                            @endphp

                                            @if (isset($category))
                                                @if ($category->name == 'Kondisi Tidak Aman')
                                                    @foreach ($this->typeKtaTta->where('type', 'KTA') as $key => $typeKtaTta)
                                                        <option value="{{ $typeKtaTta->id }}">{{ $typeKtaTta->code }}
                                                            {{ $typeKtaTta->name }}
                                                        </option>
                                                    @endforeach
                                                @endif

                                                @if ($category->name == 'Tindakan Tidak Aman')
                                                    @foreach ($this->typeKtaTta->where('type', 'TTA') as $key => $typeKtaTta)
                                                        <option value="{{ $typeKtaTta->id }}">{{ $typeKtaTta->code }}
                                                            {{ $typeKtaTta->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif

                                        </x-field-leadership-select2>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="">Tingkat Risiko / Potensi</label>
                                        <x-field-leadership-select2
                                            wire:model="risk_condition.{{ $loop->index }}.level"
                                            id="risk_condition.{{ $loop->index }}.level"
                                            name="risk_condition.{{ $loop->index }}.level"
                                            placeholder="Select Type">

                                            @foreach ($this->potencies as $key => $potency)
                                                <option value="{{ $potency->id }}">{{ $potency->name }}
                                                </option>
                                            @endforeach

                                        </x-field-leadership-select2>
                                    </div>
                                </div>

                                <div
                                    class="row mb-3 form-group required {{ $risk_condition[$loop->index]['repaired'] == true ? '' : 'd-none' }}">

                                    <div class="col-sm-12 mb-3">
                                        <label for="">Lampiran Temuan KTA/TTA</label>
                                        <div class="">
                                            <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                type="button">
                                                <span><img src="{{ asset('/images/icons/upload.png') }}"
                                                        alt="image upload" /></span>
                                                <span class="text-upload">Drop or <a href="#">Select
                                                        File</a></span>
                                                <input type="file" name="" id=""
                                                    wire:model="temporaryFile.{{ $loop->index }}"
                                                    accept=".pdf, .png, .jpeg, .jpg" multiple />

                                            </button>
                                        </div>
                                    </div>

                                </div><!-- /.form-group -->

                                @if ($risk_condition[$loop->index]['repaired'] == true)
                                    @foreach ($item['files'] as $keyFile => $itemFile)
                                        <div class="row form-group mb-3 m-1">
                                            <div
                                                class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
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
                                            <div class="col-sm-1 text-center p-2"
                                                wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                                <button type="button" class="btn btn-light-secondary text-center"
                                                    wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                                    <i class="fa fa-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div
                                    class="row mb-3 form-group required {{ $risk_condition[$loop->index]['repaired'] != true ? '' : 'd-none' }}">

                                    <div class="col-sm-12">
                                        <label for="">Lampiran Temuan KTA/TTA</label>
                                        <div class="">
                                            <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                type="button">
                                                <span><img src="{{ asset('/images/icons/upload.png') }}"
                                                        alt="image upload" /></span>
                                                <span class="text-upload">Drop or <a href="#">Select
                                                        File</a></span>
                                                <input type="file" name="" id=""
                                                    wire:model="temporaryFile.{{ $loop->index }}"
                                                    accept=".pdf, .png, .jpeg, .jpg" multiple />

                                            </button>
                                        </div>
                                    </div>

                                </div><!-- /.form-group -->

                                @if ($risk_condition[$loop->index]['repaired'] != true)
                                    @foreach ($item['files'] as $keyFile => $itemFile)
                                        <div class="row form-group mb-3 m-1">
                                            <div
                                                class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
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
                                            <div class="col-sm-1 text-center p-2"
                                                wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                                <button type="button" class="btn btn-light-secondary text-center"
                                                    wire:click="removeFile({{ $loop->parent->index }}, {{ $loop->index }})">
                                                    <i class="fa fa-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="">
                                            {{ $risk_condition[$loop->index]['repaired'] != true ? 'Tanggal Rencana Pemenuhan Tindakan Perbaikan' : 'Tanggal Tindakan Perbaikan' }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <x-inputs.datepicker wire:model="risk_condition.{{ $loop->index }}.due_date"
                                            id="risk_condition.{{ $loop->index }}.due_date" :error="'risk_condition.{{ $loop->index }}.due_date'"
                                            placeholder="Select Date" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="row mb-3 {{ $type != 'Hazard Report' ? '' : 'd-none' }}">
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <input class="form-check-input @error('repaired') is-invalid @enderror"
                                                type="checkbox"
                                                wire:model="risk_condition.{{ $loop->index }}.repaired"
                                                id="risk_condition.{{ $loop->index }}.repaired"
                                                {{ $risk_condition[$loop->index]['repaired'] == true ? 'checked' : '' }}>
                                            <label class="form-check-label" for="repaired">
                                                Apakah Langsung Dilakukan Perbaikan ?
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @if ($risk_condition[$loop->index]['repaired'] == true)
                                    <div class="row mb-3">
                                        <div class="col-sm-12 mb-3">
                                            <label for="">
                                                Tindakan Perbaikan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" rows="7" wire:model="risk_condition.{{ $loop->index }}.action"
                                                placeholder="Tindakan Perbaikan"></textarea>
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="row mb-3 {{ $risk_condition[$loop->index]['repaired'] == true ? '' : 'd-none' }}">
                                    <div class="col-sm-12 mb-3">
                                        <label for="">Jenis Tindakan Perbaikan</label>
                                        <x-field-leadership-select2
                                            wire:model="risk_condition.{{ $loop->index }}.type_action"
                                            id="risk_condition.{{ $loop->index }}.type_action"
                                            name="risk_condition.{{ $loop->index }}.type_action"
                                            placeholder="Select Type">

                                            <option value="Eliminasi">
                                                Eliminasi
                                            </option>
                                            <option value="Substitusi">
                                                Substitusi
                                            </option>
                                            <option value="Teknik Rekayasa">
                                                Teknik Rekayasa
                                            </option>
                                            <option value="Administrasi">
                                                Administrasi
                                            </option>
                                            <option value="Alat Pelindung Diri">
                                                Alat Pelindung Diri
                                            </option>

                                        </x-field-leadership-select2>
                                    </div>

                                    <div
                                        class="col-sm-12 {{ $risk_condition[$loop->index]['repaired'] == true ? '' : 'd-none' }}">
                                        <label for="">Nama Pengawas</label>
                                        <input type="text"
                                            wire:model="risk_condition.{{ $loop->index }}.supervisor"
                                            class="form-control" placeholder="Masukan Nama Pengawas">
                                    </div>
                                </div>

                                <div
                                    class="row mb-3 form-group required {{ $risk_condition[$loop->index]['repaired'] == true ? '' : 'd-none' }}">

                                    <div class="col-sm-12">
                                        <label for="">Lampiran Tindakan Perbaikan</label>
                                        <div class="">
                                            <button class="btn btn-outline-upload w-100 position-relative h-128px"
                                                style="border: 1px dashed #810DA8; background-color: #810DA80A;"
                                                type="button">
                                                <span><img src="{{ asset('/images/icons/upload.png') }}"
                                                        alt="image upload" /></span>
                                                <span class="text-upload">Drop or <a href="#">Select
                                                        File</a></span>
                                                <input type="file" name="" id=""
                                                    wire:model="temporaryFileCA.{{ $loop->index }}"
                                                    accept=".pdf, .png, .jpeg, .jpg" multiple />

                                            </button>
                                        </div>
                                    </div>

                                </div><!-- /.form-group -->

                                @if ($risk_condition[$loop->index]['repaired'] == true)
                                    {{-- Corrective Action --}}
                                    @foreach ($item['files_ca'] as $keyFile => $itemFile)
                                        <div class="row form-group mb-3 m-1">
                                            <div
                                                class="col-sm-11 bg-white d-flex justify-content-between p-2 file-list">
                                                <div>
                                                    <img src="{{ asset('/images/icons/pdf.png') }}"
                                                        alt="pdf" />
                                                    <span>
                                                        {{ $itemFile['name'] }}
                                                    </span>
                                                </div>
                                                <span>
                                                    {{ $itemFile['size'] }}
                                                </span>
                                            </div>
                                            <div class="col-sm-1 text-center p-2"
                                                wire:click="removeFileCA({{ $loop->parent->index }}, {{ $loop->index }})">
                                                <button type="button" class="btn btn-light-secondary text-center"
                                                    wire:click="removeFileCA({{ $loop->parent->index }}, {{ $loop->index }})">
                                                    <i class="fa fa-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- Corrective Action --}}
                                @endif

                            </div><!-- /.form-group -->
                        @endforeach

                        <div class="mb-3 row form-group required">

                            <div class="col-sm-4 pb-3">

                                <button type="button" class="btn btn-light-secondary text-center mt-3"
                                    wire:click="addRiskCondition" style="width: 100%;">
                                    <i class="fa fa-plus"></i> Add More Condition
                                </button>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.map-info -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('field-leadership::listing.active.index') }}"
                                class="btn btn-outline-secondary" wire:loading.remove wire:target='saved'>
                                Cancel
                            </a>
                            <x-button-spinner target="saved" :text="trans('global.processing')"></x-button-spinner>
                            <div class="button-document" wire:loading.remove wire:target='saved'>
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
                                    <li class="{{ $hazard_report_label ? '' : 'd-none' }}">
                                        <button type="button" wire:click="saved('HR')" class="dropdown-item"
                                            href="#">
                                            Close Action
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

        .document-prefix {
            background-color: transparent !important;
            width: auto !important;
            border: 1px solid #ced4da;
            border-left: none !important;
        }

        .input-group-doc-form input:focus {
            border-color: #ced4da !important;
        }

        .input-group-text.is-invalid {
            border: 1px solid #dc3545;
            border-right: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('body').on('change', '#risk_condition.0.category', function() {
            if ($('#risk_condition.0.category :selected').text() == 'Not Applicable') {
                $('#jenis_kondisi').hide();
            } else {
                $('#jenis_kondisi').show();
            }
        });

        $(document).ready(function() {
            //    
        });

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
                        title: 'Proses Upload File',
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
                        title: 'Proses Upload File Success',
                        timer: 2000,
                    });
                }

            })

        });
    </script>
@endpush

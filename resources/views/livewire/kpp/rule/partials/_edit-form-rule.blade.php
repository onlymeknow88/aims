

    <div class="own-info mb-5">

        <div class="mb-3">
            <h5 class="fw-normal">Information Kepatuhan</h5>
        </div>

        <div class="mb-3 row form-group">
            <label for="sop_number" class="col-sm-4 col-form-label">No Peraturan</label>
            <div class="col-sm-8">
                <x-inputs.text type="text" wire:model="number" class="form-control" id="number"
                    placeholder="XX-XXXX-XXX" :error="'number'"/>
            </div>
        </div>

        <div class="mb-3 row form-group">
            <label for="title" class="col-sm-4 col-form-label">Judul Peraturan</label>
            <div class="col-sm-8">
                <x-inputs.textarea wire:model="title" class="form-control" id="title"
                    placeholder="Title" :error="'title'"></x-inputs.textarea>
            </div>
        </div>
    </div>

    <div class="own-info mb-5">

        <div class="mb-3">
            <h5 class="fw-normal">Otoritas Instansi</h5>
        </div>

        <div class="mb-3 row form-group required">
            <label for="department" class="col-sm-4 col-form-label">Jenis Peraturan</label>
            <div class="col-sm-8">
                <x-inputs.select2 wire:model="type" id="type" data-child="type"
                    placeholder="Select Type" :error="'type'">
                    @foreach ($types as $key => $type)
                        <option value="{{ $type['id'] }}">{{$type['name']}}</option>
                    @endforeach
                </x-inputs.select2>
            </div>
        </div>

        <div class="mb-3 row form-group required">
            <label for="department" class="col-sm-4 col-form-label">Status</label>
            <div class="col-sm-8">
                <x-inputs.select2 wire:model="status" id="status" data-child="status"
                    placeholder="Select Status">
                    @foreach ($statuses as $key => $status)
                        <option value="{{ $status['id'] }}">{{$status['name']}}</option>
                    @endforeach
                </x-inputs.select2>
            </div>
        </div>

        <div class="mb-3 row form-group required">
            <label for="agency_authority" class="col-sm-4 col-form-label">Otoritas</label>
            <div class="col-sm-8">
                <x-inputs.select2 wire:model="agency_authority" id="agency_authority" data-child="agency_authority"
                    placeholder="Select Department">
                    @foreach ($agencyAuthorities as $key => $agencyAuthority)
                        <option value="{{ $agencyAuthority['id'] }}">{{$agencyAuthority['name']}}</option>
                    @endforeach
                </x-inputs.select2>
            </div>
        </div>
    </div>

    <div class="own-info mb-5">

        <div class="mb-3">
            <h5 class="fw-normal">Date</h5>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3 row form-group required">
                    <label for="title" class="col-sm-12 col-form-label">Tanggal Disetujui</label>
                    <div class="col-sm-12">
                        <x-inputs.datepicker wire:model="approved_date" id="approved_date" :error="'approved_date'" />
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3 row form-group required">
                    <label for="title" class="col-sm-12 col-form-label">Tanggal Berlaku</label>
                    <div class="col-sm-12">
                        <x-inputs.datepicker wire:model="effective_date" id="effective_date" :error="'effective_date'" />
                    </div>
                </div>
            </div>
            
            {{--<div class="col-sm-4">
                <div class="mb-3 row form-group required">
                    <label for="title" class="col-sm-12 col-form-label">Tanggal Tidak Berlaku</label>
                    <div class="col-sm-12">
                        <x-inputs.datepicker wire:model="expired_date" id="expired_date" :error="'expired_date'" />
                    </div>
                </div>
            </div>--}}
            
        </div>
    </div>

    <div class="description mb-5">
        <div class="mb-3">
            <h5 class="fw-normal">Description</h5>
        </div>
        <div class="mb-3 row form-group required">
            <div class="col-sm-12">
                <x-inputs.texteditor wire:model.defer="description" id="description"
                    :error="'description'" />
            </div>
        </div>
    </div>

    {{--<div class="attachment mb-5">
        <div class="mb-3">
            <h5 class="fw-normal">Attachment</h5>
        </div>
        <div class="mb-3 row form-group required">
            <div class="col-sm-12">
                <x-inputs.upload-files :docs="$docs" id="docs" :error="'docs'" />
            </div>
        </div>
    </div>--}}

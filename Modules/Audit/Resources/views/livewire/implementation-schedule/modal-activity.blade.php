<div>
    <div class="modal fade" wire:ignore.self id="modalFormSchedule" tabindex="-1" aria-labelledby="modalForm"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent='saveScheduleActivity' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Implementation Schedules</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="start_time">Jam Mulai</label>
                                        <input type="time" name="" id="start_time" wire:model="start_time"
                                            class="form-control @error('start_time') is-invalid @enderror">
                                        @error('start_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="end_time">Jam Berakhir</label>
                                        <input type="time" name="end_time" wire:model="end_time" id="end_time"
                                            class="form-control @error('end_time') is-invalid @enderror">
                                        @error('end_time')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="schedule_activity_type">Tipe Kegiatan</label>
                                <x-inputs.select2 id="schedule_activity_type" error="schedule_activity_type"
                                    wire:model="schedule_activity_type">
                                    @foreach (\Modules\Audit\Enums\ScheduleActivityType::asArray() as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </x-inputs.select2>
                            </div>
                            @if ($schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::FREE_TEXT)
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <x-inputs.texteditor id="description" wire:model="description" error="description">

                                    </x-inputs.texteditor>
                                </div>
                                <div class="form-group">
                                    <label for="methods">Auditor</label>
                                    <div wire:ignore>
                                        <select data-placeholder="" id="auditor_ids"
                                            class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                            <option></option>
                                            @foreach ($teams as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{--
                                <div class="form-group">
                                    <label for="">Auditor</label>
                                    <x-inputs.textarea id="auditor" wire:model="auditor" error="auditor">

                                    </x-inputs.textarea>
                                </div> --}}
                            @endif
                            @if (
                                $schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::OPENING ||
                                    $schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::CLOSING)
                                <div class="form-group">
                                    <label for="location">Location</label>
                                    {{-- <x-inputs.textarea id="location" wire:model="location" error="location">
                                    </x-inputs.textarea> --}}

                                    <x-inputs.select2 id="location" wire:model="location">
                                        @foreach ($this->locations as $location)
                                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                                            {{-- <option value="{{ $location->id }}">{{ $location->location }}</option> --}}
                                        @endforeach
                                    </x-inputs.select2>
                                </div>
                            @endif
                            @if ($schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ACTIVITY)
                                <div class="form-group">
                                    <label for="location">Lokasi</label>
                                    {{-- <x-inputs.text id="location" wire:model="location"
                                        error="location"></x-inputs.text> --}}

                                    <x-inputs.select2 id="location" wire:model="location">
                                        @foreach ($this->locations as $location)
                                            <option value="{{ $location->location }}">{{ $location->location }}</option>
                                            {{-- <option value="{{ $location->id }}">{{ $location->location }}</option> --}}
                                        @endforeach
                                    </x-inputs.select2>
                                </div>
                                <div class="form-group">
                                    <label for="methods">Metode</label>
                                    <div class="col-8" wire:ignore>
                                        <select data-placeholder="" id="methods"
                                            class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                            <option></option>
                                            @foreach ($availableMethods as $type)
                                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="location">Auditee</label>
                                    <x-inputs.text id="auditee" wire:model="auditee" error="auditee"></x-inputs.text>
                                </div>
                                <div class="form-group">
                                    <label for="methods">Cakupan Kegiatan</label>
                                    <div wire:ignore>
                                        <select data-placeholder="" id="selectedCriteria"
                                            class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                            <option></option>
                                            @foreach ($audit_criteria as $id => $value)
                                                <option value="{{ $id }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="methods">Auditor</label>
                                    <div wire:ignore>
                                        <select data-placeholder="" id="auditor_ids"
                                            class="form-select w-100 select2 select2-multiple " multiple="multiple">
                                            <option></option>
                                            @foreach ($teams as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                            wire:loading.remove wire:target='saveScheduleActivity' type="submit">
                            @lang('global.save')
                        </button>
                        <x-button-spinner target="saveScheduleActivity" :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>

@once
    @push('styles')
        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endpush
@endonce

@once
    @push('scripts')
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
@endonce

@if ($schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::ACTIVITY)
    <script>
        $(function() {
            $('.select2-multiple').select2({
                theme: 'bootstrap-5',
            });

            $(document).on('change', '.select2-multiple', function(e) {
                var data = $(this).select2("val");
                let elementName = $(this).attr('id');
                @this.
                set(elementName, data);
            });
        })
    </script>
@endif

@if ($schedule_activity_type == \Modules\Audit\Enums\ScheduleActivityType::FREE_TEXT)
    <script>
        $(function() {
            $('.select2-multiple').select2({
                theme: 'bootstrap-5',
            });

            $(document).on('change', '.select2-multiple', function(e) {
                var data = $(this).select2("val");
                let elementName = $(this).attr('id');
                @this.
                set(elementName, data);
            });
        })
    </script>
@endif

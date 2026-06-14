<div class="inner-content" x-data="{ type: @entangle('type') }">
    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('coe') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>New Event</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->

    </div><!-- /.header-edit-event -->

    <div class="edit-event-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">
                <form action="#" class="form-horizontal" wire:submit.prevent="save">

                    <div class="event-title mb-5">

                        <h5 class="fw-normal">Event Title</h4>

                            <div class="mb-3 row form-group">

                                <div class="col">
                                    <input type="text" wire:model.lazy="event.title" class="form-control"
                                        placeholder="Add Title" />
                                    @error('event.title')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                    </div><!-- /.event-title -->

                    <div class="event-category mb-5">

                        <h5 class="fw-normal">Category</h4>

                            <div class="mb-3 row form-group">
                                <div class="col">
                                    <x-inputs.select2 wire:model="event.category_id" id="category"
                                        placeholder="Select Category">

                                        @foreach ($this->categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach

                                    </x-inputs.select2>
                                    @error('event.category_id')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row form-group">

                                <div class="col">
                                    <div class="form-check">
                                        <input wire:model="event.repeat" class="form-check-input" type="checkbox"
                                            value="true" id="repeat_checkbox">
                                        <label class="form-check-label" for="repeat_checkbox">
                                            Repeat Event
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3 row form-group">

                                @if ($event->repeat)
                                    <div class="input-group mb-3 col">

                                        <label class="input-group-text" for=""><i
                                                class="fa-solid fa-calendar-check"></i></label>

                                        <select wire:model="event.frequency" class="form-select" id="frequency">
                                            <option value="weekly">Mingguan</option>
                                            <option value="monthly">Bulanan</option>
                                        </select>
                                        @error('event.frequency')
                                            <small class="error text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif

                                <div class="col-9">
                                    <div class="d-flex gap-2 align-items-center">
                                        <x-inputs.datepicker wire:model="start_date" id="start_date"
                                            :error="'start_date'" />
                                        <div class="input-group-addon">Sampai</div>
                                        <x-inputs.datepicker wire:model="end_date" id="end_date" :error="'end_date'" />
                                    </div>
                                </div>

                            </div>

                    </div><!-- /.event-title -->

                    <div class="event-person mb-5">

                        <h5 class="fw-normal">Person in Charge</h4>

                            <div class="mb-3 row form-group">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputs.select2 wire:model="department" id="department"
                                                placeholder="Select Department">
                                                @foreach ($this->departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select2>

                                            @error('department')
                                                <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <x-inputs.select2 wire:model="event.section_id" id="section"
                                                placeholder="Select Section">
                                                @foreach ($this->sections as $section)
                                                    <option value="{{ $section->id }}">{{ $section->name }}
                                                    </option>
                                                @endforeach
                                            </x-inputs.select2>

                                            @error('event.section_id')
                                                <small class="error text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div><!-- /.event-person -->

                    <div class="invited-people mb-5">

                        <h5 class="fw-normal">Invited People</h4>

                            <div class="mb-3 row form-group">

                                <div class="col-12">
                                    <div class="position-relative input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input class="form-control" type="email" id="invited_people"
                                            @keydown.enter.prevent="$wire.addInvitedPeople($event.target.value)" />
                                    </div>
                                </div>

                                {{-- <div class="col-sm-12">
                                <div class="position-relative input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input class="form-control" type="email" id="invited_people" @keydown.enter.prevent="$wire.addInvitedPeople($event.target.value)" />
                                </div>
                            </div> --}}

                            </div><!-- /.form-group -->

                            <div class="mb-3 row form-group d-flex gap-3 flex-wrap">

                                <div class="col">

                                    @if ($invitedPeople)
                                        <div class="list-invited mb-3 d-flex flex-wrap gap-2">
                                            @foreach ($invitedPeople as $key => $people)
                                                <div
                                                    class="list-people position-relative px-3 py-2 border rounded w-auto d-flex gap-2 align-items-center">
                                                    <span class="opacity-80">{{ $people }}</span>
                                                    <button class="btn-closed"><img
                                                            src="{{ asset('/images/icons/delete.png') }}"
                                                            wire:click.prevent="removeInvited('{{ $people }}')"
                                                            alt=""></button>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="notif_email"
                                                wire:model='notif_email'
                                                @if ($notif_email) checked @endif>
                                            <label class="form-check-label" for="flexCheckChecked">
                                                Notifikasi via email
                                            </label>
                                        </div>

                                    @endif

                                </div>

                            </div><!-- /.form-group -->


                    </div><!-- /.invited-people -->

                    <div class="description mb-5">

                        <h5 class="fw-normal">Description</h4>

                            <div class="mb-3 row form-group required">

                                <div class="col-sm-12">
                                    <x-inputs.texteditor model="event.description" id="description"
                                        :error="'event.description'" />
                                </div>
                                @error('event.description')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div><!-- /.form-group -->


                    </div><!-- /.description -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('coe') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Create Event</a>
                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div><!-- /.edit-event-content -->

</div>

@push('scripts')
    <script>
        Livewire.on('clearEmailInput', () => {
            $('input#invited_people').val('').focus()
        })
    </script>
@endpush

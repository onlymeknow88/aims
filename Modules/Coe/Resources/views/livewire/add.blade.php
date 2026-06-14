<div class="inner-content" x-data="{ frequency: @entangle('event.frequency'), repeat_day: @entangle('repeat_day') }">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Tambah Event Baru</span>
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

                        <div class="mb-3">
                            <h5 class="fw-normal">Nama Event</h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <div class="col">
                                <input type="text" wire:model.lazy="event.title" class="form-control"
                                    placeholder="" />
                                @error('event.title')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 mt-4 row form-group">

                            <div class="col-4">

                                <div class="input-group">
                                    <label class="input-group-text" for=""><img
                                            src="{{ asset('./images/icons/refresh.png') }}" alt="" /></label>
                                    <select wire:model="event.frequency" class="form-select" id="frequency">
                                        <option value="once">Tidak Berulang</option>
                                        <option value="weekly">Mingguan</option>
                                        <option value="monthly">Bulanan</option>
                                    </select>
                                    @error('event.frequency')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group">
                                    <label class="input-group-text" for=""><img
                                            src="{{ asset('./images/icons/refresh.png') }}" alt="" /></label>
                                    <select wire:model="repeat_day" class="form-select" id="repeat_day">
                                        <option value="once">Sehari</option>
                                        <option value="more_than_once">Lebih dari satu hari</option>
                                    </select>
                                    @error('event.frequency')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <select wire:model="event.category_id" class="form-select" id="category_id">
                                    @foreach ($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('event.category_id')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3 row form-group">

                            <div x-show="frequency == 'once'">
                                <div class="d-flex gap-3 align-items-center">

                                    <div :class="repeat_day != 'once' ? 'col-3' : 'col-6'">
                                        <x-inputs.datepicker wire:model="start_date" id="start_date"
                                            placeholder="Tanggal Mulai" :error="'start_date'" />
                                    </div>

                                    <div :class="repeat_day != 'once' ? 'd-flex' : 'd-none'"
                                        class="gap-3 align-items-center">
                                        <div class="input-group-addon">-</div>
                                        <x-inputs.datepicker wire:model="end_date" id="end_date" :error="'end_date'"
                                            placeholder="Tanggal Akhir" />
                                    </div>

                                </div>
                            </div>

                            <div x-show="frequency != 'once'">

                                <div class="d-flex gap-3 align-items-center">

                                    <div :class="repeat_day != 'once' ? 'col-3' : 'col-6'">
                                        <x-inputs.datepicker wire:model="start_date" id="start_date"
                                            placeholder="Tanggal Mulai" :error="'start_date'" />
                                    </div>

                                    <div :class="repeat_day != 'once' ? 'd-flex' : 'd-none'"
                                        class="gap-3 align-items-center">
                                        <div class="input-group-addon">-</div>
                                        <x-inputs.datepicker wire:model="end_date" id="end_date" :error="'end_date'"
                                            placeholder="Tanggal Akhir" />
                                    </div>

                                </div>

                            </div>

                        </div><!-- /.form-group -->

                    </div><!-- /.event-title -->

                    <div class="invited-people mb-5">

                        <div class="mb-3">
                            <h5 class="fw-normal">Email yang Diundang <span class="icon-tooltip" x-data="{ tooltip: false }"
                                    x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false">
                                    <i class="fa-solid fa-circle-question pt-2 text-info"></i>
                                    <div class="tooltip-content" x-show="tooltip">Masukkan email, lalu tekan enter</div>
                                    </span< /h4>
                        </div>

                        <div class="mb-3 row form-group">

                            <div class="col-sm-12">
                                {{-- <div class="position-relative input-group"> --}}
                                    {{-- <span class="input-group-text"><img src="{{ asset('images/icons/search.png') }}"
                                            alt="" /></span> --}}
                                    {{-- <input class="form-control" type="email" id="invitedPeople"
                                        @keydown.enter.prevent="$wire.addInvitedPeople($event.target.value)" /> --}}

                                    <x-inputs.select2_multiple id="invitedPeople" placeholder="Choose document" wire:model="invitedPeople"
                                        data-placeholder="Pilih Email" class="form-select w-100 select2"
                                        multiple="multiple">
                                        @foreach ($this->EmailLists as $key => $item)
                                            <option value="{{ $item->email }}">
                                                {{ $item->email }}
                                            </option>
                                        @endforeach
                                    </x-inputs.select2_multiple>

                                    @error('invitedPeople')
                                        <small class="error text-danger">{{ $message }}</small>
                                    @enderror
                                {{-- </div> --}}
                            </div>

                        </div><!-- /.form-group -->

                        <div class="mb-3 row form-group d-flex gap-3 flex-wrap">

                            <div class="col">
                                @if ($invitedPeople)

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notif_email"
                                        wire:model='notif_email' @if ($notif_email) checked @endif>
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Notifikasi via email
                                    </label>
                                </div>
                            @endif
                                {{-- @if ($invitedPeople)
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
                                            wire:model='notif_email' @if ($notif_email) checked @endif>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            Notifikasi via email
                                        </label>
                                    </div>

                                @endif --}}

                            </div>

                        </div><!-- /.form-group -->


                    </div><!-- /.invited-people -->

                    <div class="mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">File Lampiran</h4>
                        </div>
                        <div class="mb-3 row form-group required">
                            <div class="col-sm-12">
                                <input type="file" wire:model="file" id="file" class="form-control"
                                    @if (!$event->title) disabled @endif>
                                @error('file')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div><!-- /.form-group file -->

                    <div class="description mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">Deskripsi Event</h4>
                        </div>

                        <div class="mb-3 row form-group required">
                            <div class="col-sm-12">
                                <x-coe-texteditor model="event.description" id="description" :error="'event.description'" />
                            </div>
                            @error('event.description')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div><!-- /.form-group -->

                    </div><!-- /.description -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('coe::callendar') }}" class="btn btn-outline-secondary">Cancel</a>
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
            $('input#invitedPeople').val('').focus()
        })
    </script>
@endpush

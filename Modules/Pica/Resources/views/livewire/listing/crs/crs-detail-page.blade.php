<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="{{ route('pica::listing.active-document.index') }}" class="d-flex align-items-center gap-3 ">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Pica</span>
        </a>
        {{-- <a href="{{ route('pica::listing.active-document.edit', $pica->id) }}" class="btn btn-edit text-white bg-146943">
            <i class="fas fa-pencil"></i> Edit</a> --}}
    </div>

    <div class="detail-maker-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <div class="item-content d-flex gap-2 align-items-center">
                            <span class="profile-image">
                                <!--<img src="{{ asset('images/profile.png') }}" alt="Profile images" srcset="{{ asset('images/profile.png') }}">-->
                                <span
                                    class="text-profile">{{ preg_filter('/[^A-Z]/', '', ucfirst($pica->auditor)) }}</span>
                            </span>
                            <span class="profile-text">{{ ucfirst($pica->auditor) }}</span>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">CCOW</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $pica->ccow->company_name }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Company</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $pica->company->company_name }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Department</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="fw-normal">{{ $pica->section->department->name }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->


                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Created</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            {{-- <span class="opacity-50">by</span>
                            <span>PT. Maruawai</span>
                            <span class="opacity-50">on</span> --}}
                            <span>{{ date('d F Y', strtotime($pica->created_at)) }}</span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                @if ($pica->target_settlement_date)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="pt d-flex flex-column gap-2">
                            <h6 class="fw-normal">Target Settlement</h6>
                            <div class="position-name d-flex flex-column">
                                <span>
                                    {{-- <span class="opacity-50">by</span> user name
                                <span class="opacity-50">on</span> --}}
                                    {{ Carbon\Carbon::parse($pica->target_settlement_date)->format('d F Y') }}</span>
                                </span>
                            </div>
                        </div><!-- /.author -->
                    </div>
                @endif

                @if ($pica->settlement_date)
                    <div class="info-item p-3 border-bottom border-1">

                        <div class="pt d-flex flex-column gap-2">
                            <h6 class="fw-normal">Settlement</h6>
                            <div class="position-name d-flex flex-column">
                                <span>
                                    {{-- <span class="opacity-50">by</span> user name
                                <span class="opacity-50">on</span> --}}
                                    {{ Carbon\Carbon::parse($pica->settlement_date)->format('d F Y') }}</span>
                                </span>
                            </div>
                        </div><!-- /.author -->
                    </div>
                @endif

                {{-- <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">Reviewed by PJA</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/no-profile.png') }}" alt="Author">
                            </div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items --> --}}

                {{-- <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <h6 class="fw-normal">Reviewed by Super User</h6>
                        <div class="item-content d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/no-profile.png') }}" alt="Author">
                            </div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items --> --}}

            </div><!-- /.info -->

        </div><!-- /.detail-left -->

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Inspection Information</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Identity ID</div>
                        <div class="col-8">{{ $pica->identity_id }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Source NCAR</div>
                        <div class="col-8">{{ $pica->source }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Inspection Type</div>
                        <div class="col-8">{{ $pica->type }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Section</div>
                        <div class="col-8">{{ $pica->section->name }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Location</div>
                        <div class="col-8">{{ $pica->areaLocation->name }}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Detail Location</div>
                        <div class="col-8">{{ $pica->detail_company }}</div>
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-description py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Detail Compliance</h5>
                <p>{{ $pica->non_compliance }}</p>

                <br>

                <h5 class="fw-normal">Description Non Compliance Root Cause</h5>
                <p>{{ $pica->non_compliance_root_cause }}</p>

                <br>

                <h5 class="fw-normal">Corrective Action</h5>
                <p>{{ $pica->corrective_action }}</p>

                <br>

                <h5 class="fw-normal">Remarks</h5>
                <p>{{ $pica->remarks }}</p>

            </div><!-- /.section-description -->

            <div class="section-attachment px-2 d-flex flex-column gap-2 mb-5">

                <h5 class="fw-normal">Evidance</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-attachment-items d-flex flex-wrap gap-2">

                        <div class="files-content d-flex gap-2 flex-wrap">

                            @foreach ($pica->picaFiles as $itemFile)
                                @php
                                    $file = explode('/', $itemFile->file);
                                    $file = end($file);

                                    $ext = explode('.', $file);
                                    $ext = $ext[1];
                                @endphp
                                <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="attachment">
                                    <a href="{{ asset('storage/' . $itemFile->file) }}" target="_blank">
                                        <div class="thumb mb-2">
                                            <img src="{{ $ext == 'pdf' ? asset('./images/icons/pdf.png') : asset('./images/activity.png') }}"
                                                alt="{{ $ext }}" />
                                        </div>
                                        <div class="img-name">
                                            {{ Str::limit($file, 10) }}
                                        </div>
                                        <div class="img-size opacity-50"> {{ $itemFile->size }}</div>
                                    </a>
                                </div><!-- image -->
                            @endforeach

                        </div><!-- /.files-content -->

                    </div><!-- /.module-attachment-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-Attachment -->

            @if (auth()->user()->can('Pica - Field Leadership Approve Document'))
                {{-- <div class="footer-action mb-2 {{ $pica->type == 'Hazard Report' ? '' : 'd-none' }}"> --}}
                <div class="footer-action mb-2">
                    <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                        <div class="button-document">
                            <button
                                class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Approval Action
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button type="button" wire:click="action" class="dropdown-item" href="#">
                                        Case Close
                                    </button>
                                </li>
                                <li>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#ReturnWithComment"
                                        class="dropdown-item" href="#">
                                        Return with comment
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- <div class="footer-action mb-2 {{ $pica->type != 'Hazard Report' ? '' : 'd-none' }}">
                    <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                        <div class="button-document">
                            <button
                                class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Checking Action
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <button type="button" wire:click="action" class="dropdown-item">
                                        Approve
                                    </button>
                                </li>
                                <li>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#CorrectiveAction"
                                        class="dropdown-item" href="#">
                                        Corrective Action
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            @endif
        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>

                @foreach ($this->activities as $item)
                    <div class="info-item mb-3">

                        <div class="activity d-flex flex-column gap-2">

                            <div class="item-content d-flex gap-1 align-items-center">

                                <div class="activity-item d-flex flex-column gap-2">

                                    <div
                                        class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>{{ $item->user->employee->name ?? '-' }}</span>
                                                <span
                                                    class="opacity-50">{{ $item->user->employee->name ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="tools">
                                            <a href="#" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalActivity{{ $loop->iteration }}">
                                                <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                            </a>
                                        </div>
                                    </div><!-- /.activity-item -->

                                    <div class="activity-content" x-data="{
                                        contentOpen: true,
                                        height: $refs.containerInner.getBoundingClientRect().height,
                                        buttonShow: false,
                                        init() {
                                            if (this.height > 60) {
                                                this.contentOpen = false;
                                                this.buttonShow = true;
                                            }
                                        }
                                    }">

                                        <div x-ref="containerInner" class="activity-inner d-flex flex-column gap-2"
                                            :class="contentOpen ? 'height-auto' : 'collapse'" x-transition.delay.5s>
                                            <div class="desc">
                                                {{ $item->description }}
                                            </div>

                                            @foreach ($item->files->where('type_file', '!=', 'pdf') as $value)
                                                <div class="images">
                                                    @if ($loop->index == 0)
                                                        <h6 class="fw-normal">Images</h6>
                                                    @endif
                                                    <div
                                                        class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="thumb">
                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                    alt="activity">
                                                            </div>
                                                            <div class="img-name">
                                                                {{ Str::limit(explode('/', $value->file)[4], 15) }}
                                                            </div>
                                                        </div>
                                                        <div class="img-size opacity-50">{{ $value->size }}</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images -->
                                            @endforeach
                                            @foreach ($item->files->where('type_file', 'pdf') as $value)
                                                <div class="images">
                                                    @if ($loop->index == 0)
                                                        <h6 class="fw-normal">Files</h6>
                                                    @endif
                                                    <div
                                                        class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="thumb">
                                                                <img src="{{ asset('./images/icons/pdf.png') }}"
                                                                    alt="excel">
                                                            </div>
                                                            <div class="img-name">
                                                                {{ Str::limit(explode('/', $value->file)[4], 15) }}
                                                            </div>
                                                        </div>
                                                        <div class="img-size opacity-50">{{ $value->size }}</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images -->
                                            @endforeach
                                        </div><!-- /.actifity-inner -->
                                        @if ($item->files->count() > 0)
                                            <div class="button-showless">
                                                <button
                                                    class="d-flex gap-1 justify-content-center w-100 align-items-center py-2"
                                                    type="button" @click="contentOpen = ! contentOpen">
                                                    <span>Show Less</span>
                                                    <span class="icon-btn"><i
                                                            class="fa-solid fa-angle-down"></i></span>
                                                </button>
                                            </div><!-- /.button-showless -->
                                        @endif

                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">{{ $item->created_at->diffForHumans() }}
                                    </div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->

                    <!-- Modal actifity -->
                    <div class="modal fade" id="modalActivity{{ $loop->iteration }}" tabindex="-1"
                        aria-labelledby="modalActivity{{ $loop->iteration }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="#">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Activity</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="activity d-flex flex-column gap-2">

                                            <div class="item-content d-flex gap-1 align-items-center">

                                                <div class="activity-item d-flex flex-column gap-2 w-100">

                                                    <div
                                                        class="activity-header d-flex justify-content-start align-items-center gap-2">
                                                        <div class="thumb">
                                                            <img src="{{ asset('./images/profile.png') }}"
                                                                alt="Profile">
                                                        </div>
                                                        <div class="title d-flex flex-column">
                                                            <span>{{ $item->user->employee->name ?? '-' }}</span>
                                                            <span
                                                                class="opacity-50">{{ $item->user->employee->name ?? '-' }}</span>
                                                        </div>
                                                    </div><!-- /.activity-item -->

                                                    <div class="activity-content">

                                                        <div class="activity-inner d-flex flex-column gap-2">

                                                            <div class="desc">
                                                                {{ $item->description }}
                                                            </div>

                                                            <div class="images">
                                                                @if ($item->files->where('type_file', '!=', 'pdf')->count() > 0)
                                                                    <h6 class="fw-normal">Images</h6>
                                                                @endif
                                                                <div class="images-content d-flex gap-2 flex-wrap">
                                                                    @foreach ($item->files->where('type_file', '!=', 'pdf') as $value)
                                                                        <div
                                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                                            <div class="thumb mb-2">
                                                                                <img src="{{ asset('./images/activity.png') }}"
                                                                                    alt="activity">
                                                                            </div>
                                                                            <div class="img-name">
                                                                                {{ Str::limit(explode('/', $value->file)[4], 10) }}
                                                                            </div>
                                                                            <div class="img-size opacity-50">
                                                                                {{ $value->size }}
                                                                            </div>
                                                                        </div><!-- image -->
                                                                    @endforeach
                                                                </div><!-- /.images-content -->
                                                            </div><!-- /.images -->

                                                            <div class="images">
                                                                @if ($item->files->where('type_file', 'pdf')->count() > 0)
                                                                    <h6 class="fw-normal">Files</h6>
                                                                @endif
                                                                <div class="files-content d-flex gap-2 flex-wrap">
                                                                    @foreach ($item->files->where('type_file', 'pdf') as $value)
                                                                        <div
                                                                            class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                                            <div class="thumb mb-2">
                                                                                <img src="{{ asset('./images/icons/pdf.png') }}"
                                                                                    alt="pdf">
                                                                            </div>
                                                                            <div class="img-name">
                                                                                {{ Str::limit(explode('/', $value->file)[4], 10) }}
                                                                            </div>
                                                                            <div class="img-size opacity-50">
                                                                                {{ $value->size }}
                                                                            </div>
                                                                        </div><!-- image -->
                                                                    @endforeach
                                                                </div><!-- /.files-content -->
                                                            </div><!-- /.images -->

                                                        </div><!-- /.actifity-inner -->

                                                    </div><!-- /.actifity-content -->

                                                    <div class="activity-footer opacity-50">2 days ago</div>

                                                </div><!-- /.activity-item -->

                                            </div>

                                        </div><!-- /.author -->

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- modal activity -->
                @endforeach
            </div><!-- /.detail-left -->

        </div><!-- /.detail-maker -->



    </div>

    <!-- Modal -->
    <div class="modal fade" id="ReturnWithComment" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="ReturnWithCommentLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReturnWithCommentLabel">Return With Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                rows="7"></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <h6>Attach evidence</h6>
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-lg btn-light">
                                <label for="upload">
                                    <i class="fa fa-plus fa-lg"></i>
                                </label>
                                <input type="file" name="" id="upload" wire:model="evidance" hidden
                                    accept=".pdf, .png, .jpeg, .jpg" multiple />
                            </button>
                        </div>
                        @foreach ($activityFile as $item)
                            <div class="col-sm-2">
                                <div
                                    style="border-radius: 0.5rem; background-image: url('{{ $item['extension'] == 'pdf' ? asset('./images/icons/pdf.png') : $item['file']->temporaryUrl() }}'); width: 80%; height: 100%; background-size: cover; background-position: center">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="saved('return')"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="CorrectiveAction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="CorrectiveActionLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CorrectiveActionLabel">Corrective Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                rows="7"></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <h6>Attach evidence</h6>
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-lg btn-light">
                                <label for="upload">
                                    <i class="fa fa-plus fa-lg"></i>
                                </label>
                                <input type="file" name="" id="upload" wire:model="evidance" hidden
                                    accept=".pdf, .png, .jpeg, .jpg" multiple />
                            </button>
                        </div>
                        @foreach ($activityFile as $item)
                            <div class="col-sm-2">
                                <div
                                    style="border-radius: 0.5rem; background-image: url('{{ $item['extension'] == 'pdf' ? asset('./images/icons/pdf.png') : $item['file']->temporaryUrl() }}'); width: 80%; height: 100%; background-size: cover; background-position: center">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="saved('corrective')"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .activity-item .activity-inner {
            height: 30px;
        }
    </style>
@endpush

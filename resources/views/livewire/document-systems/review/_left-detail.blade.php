<div class="detail-left border-end border-1">

    <div class="info bg-white">

        <div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <h6 class="fw-normal">Penanggung Jawab</h6>
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">{{ $document->areaManager->user->name }}</div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="pt d-flex flex-column gap-2">
                <h6 class="fw-normal">{{ $document->department->company->company_name }}</h6>
                <div class="item-content d-flex gap-2 align-items-start">
                    <div class="thumb">
                        <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                    </div>
                    <div class="position-name d-flex flex-column">
                        <span class="opacity-50">Position</span>
                        <span>Manager</span>
                    </div>
                </div>
                <div class="item-content d-flex gap-2 align-items-start">
                    <div class="thumb">
                        <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                    </div>
                    <div class="location-name d-flex flex-column">
                        <span class="opacity-50">Location Detail</span>
                        <span>Area Pit</span>
                    </div>
                </div>
                <div class="item-content d-flex gap-2 align-items-start">
                    <div class="thumb">
                        <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                    </div>
                    <div class="department-name d-flex flex-column">
                        <span class="opacity-50">Department</span>
                        <span>{{ $document->department->name }}</span>
                    </div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="created d-flex flex-column gap-2">

                <h6 class="fw-normal">Created</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50">on</span>
                    <span>
                        {{ \Carbon\Carbon::parse($document->doc_created)->toFormattedDateString() }}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="expired d-flex flex-column gap-2">

                <h6 class="fw-normal">Expired</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50">on</span>
                    <span>
                        {{ \Carbon\Carbon::parse($document->doc_created)->addYear(2)->toFormattedDateString() }}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->
        @if($document->revision)
        <div class="info-item p-3 border-bottom border-1">

            <div class="expired d-flex flex-column gap-2">

                <h6 class="fw-normal">Revisi</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    {{-- <span class="opacity-50">on</span> --}}
                    <span>
                        Revisi {{ $document->revision }}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->
        @endif

        <div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <h6 class="fw-normal">Maker</h6>
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">
                        {{ $document->user->name }}
                    </div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

    </div><!-- /.info -->

</div>
<div class="detail-right border-start border-1">
    <div class="info bg-white px-3">
        <h6 class="fw-normal">Activity</h6>

        @if($document->activities->count()  > 0)
        @foreach($document->activities as $item)
        
        <div class="info-item mb-2">
            <div class="activity d-flex flex-column gap-2">
                <div class="item-content d-flex gap-1 align-items-center">
                    <div class="activity-item d-flex flex-column gap-2">
                        <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="thumb">
                                    <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                </div>
                                <div class="title d-flex flex-column">
                                    <span>{{ $item->user->name }}</span>
                                    @if($item->status_document)
                                    {{-- <span class="opacity-50">
                                        {!! $item->status_activity !!}
                                    </span> --}}
                                    @endif
                                </div>
                            </div>
                            <div class="tools">
                                <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#modalActivity">
                                    <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                </a>
                            </div>
                        </div>

                        <div class="activity-content" x-data="{ contentOpen: false }">
                            <div class=" activity-inner d-flex flex-column gap-2"
                                :class="contentOpen ? 'height-auto' : ''" x-transition.delay.5s>
                                <div class="desc">
                                     {{ $item->status_activity }}
                                </div>
                                <div class="desc">
                                    {{ $item->description }}
                               </div>
                                @if($item->attachments)
                                <div class="images">
                                    <h6 class="fw-normal">Files</h6>
                                    @foreach(json_decode($item->attachments) as $file)
                                    @php
                                    list($path, $fileName) = explode('/', $file);
                                    @endphp
                                    <div
                                        class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                                            </div>
                                            <div class="img-name">{{ $fileName }}</div>
                                        </div>
                                        <div class="img-size opacity-50">3.2 Mb</div>
                                    </div>        
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            @if($item->attachments)
                            <div class="button-showless">
                                <button class="d-flex gap-1 justify-content-center w-100 align-items-center py-2"
                                    type="button" @click="contentOpen =! contentOpen">

                                    <span>Show Less</span>
                                    <span class="icon-btn"><i class="fa-solid fa-angle-down"></i></span>
                                </button>
                            </div>
                            @endif
                        </div>

                        <div class="activity-footer opacity-50">
                            {{ $item->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>

</div>
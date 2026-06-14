@if ($related)
    <div class="info-item p-3 border-bottom border-1">

        <div class="expired d-flex flex-column gap-2">

            <h6 class="fw-normal">@lang('global.current_document')</h6>

            <div class="item-content d-flex gap-1 align-items-center">
                <a
                    href="{{ route('document-systems::jsa.detail', ['id' => $related_id, 'type' => 'active-document']) }}">{{ $related }}</a>
            </div>

        </div><!-- /.author -->

    </div><!-- /.info-items -->
@endif

<div class="info bg-white px-3">


    <h6 class="fw-normal">Activity</h6>

    @if (count($activities) > 0)

        @foreach ($activities as $activity)
            <div class="info-item mb-3">

                <div class="activity d-flex flex-column gap-2">

                    <div class="item-content d-flex gap-1 align-items-center">

                        <div class="activity-item d-flex flex-column gap-2">

                            <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="thumb">
                                        <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                    </div>
                                    <div class="title d-flex flex-column">
                                        <span>{{ $activity->user->name }}</span>
                                        <span
                                            class="opacity-50">{{ $activity->user->department ? $activity->user->department->name : '-' }}</span>
                                    </div>
                                </div>
                                {{-- <div class="tools">
                                    <button type="button" class="bg-transparent border-0"
                                        wire:click.prevent="detailActivity({{ $activity }})">
                                        <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                    </button>
                                </div> --}}
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
                                    <p class="desc">{{ $activity->description }}</p>

                                    {{--                                @include('livewire.document-systems.maker.components.activity-media', [ --}}
                                    {{--                                    'activity' => $activity, --}}
                                    {{--                                    'images' => $images, --}}
                                    {{--                                    'files' => $files, --}}
                                    {{--                                ]) --}}

                                </div><!-- /.actifity-inner -->

                                {{--                            @if (count($activity->attachments) > 2) --}}
                                {{--                                <div class="button-showless"> --}}
                                {{--                                    <button class="d-flex gap-1 justify-content-center w-100 align-items-center py-2" type="button" @click="contentOpen = ! contentOpen"> --}}
                                {{--                                        <span>Show Less</span> --}}
                                {{--                                        <span class="icon-btn"><i class="fa-solid fa-angle-down"></i></span> --}}
                                {{--                                    </button> --}}
                                {{--                                </div><!-- /.button-showless --> --}}
                                {{--                            @endif --}}

                            </div><!-- /.actifity-content -->

                            <div class="activity-footer opacity-50">
                                {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                            </div>

                        </div><!-- /.activity-item -->

                    </div>

                </div><!-- /.author -->

            </div><!-- /.info-items -->
        @endforeach
    @else
        <div class="info-item">

            <div class="activity d-flex flex-column gap-2">

                <div class="item-content d-flex gap-1 align-items-center">

                    <div class="activity-item d-flex align-items-center justify-content-center">

                        <div class="activity-content" x-data="{ contentOpen: false }"">

                            <div class="activity-inner d-flex align-items-center justify-content-center height-auto">
                                <p class="desc text-center">@lang('global.no_activity')</p>

                            </div><!-- /.actifity-inner -->

                        </div><!-- /.actifity-content -->

                    </div><!-- /.activity-item -->

                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

    @endif

</div><!-- /.info -->

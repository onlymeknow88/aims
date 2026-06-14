<div class="detail-right border-start border-1">

    <div class="info bg-white px-3">

        <h6 class="fw-normal">Activity</h6>

        @foreach ((new \App\Helpers\KppHelper)->getActivities() as $item)
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
                                        <span>{{ $item->responsibleUser->name ?? '' }}</span>
                                        <span
                                            class="opacity-50">{{ $item->responsibleUser->department->name ?? '' }}</span>
                                    </div>
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
                                        {{ $item->obedience->rule->number }}<br>
                                        {{ $item->status }}
                                    </div>
                                </div><!-- /.actifity-inner -->

                            </div><!-- /.actifity-content -->

                            <div class="activity-footer opacity-50">{{ $item->created_at->diffForHumans() }}
                            </div>

                        </div><!-- /.activity-item -->

                    </div>

                </div><!-- /.author -->

            </div><!-- /.info-items -->
        @endforeach
    </div><!-- /.detail-left -->

</div><!-- /.detail-maker -->
        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>

                @can('rule-checker')
                    @foreach($inReviewRules as $key => $rule)
                    <div class="info-item py-1">
                        <div class="activity d-flex flex-column gap-2">
                            <div class="item-content d-flex gap-1 align-items-center">
                                <div class="activity-item w-100 flex-column gap-2">
                                    <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">                                        
                                            <div class="title d-flex flex-column">
                                                <a target="blank" href="{{route('kpp::rules.detail', ['id' => $rule->id])}}">{{$rule->number}}</a>
                                                <span class="opacity-50">{{$rule->title}}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="tools">
                                            <a href="#" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalActivity">
                                                <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                            </a>
                                        </div> -->
                                    </div><!-- /.activity-item -->
                                    <div class="activity-content" x-data="{ contentOpen: false }">
                                        <div class="activity-inner h-auto d-flex flex-column gap-2"
                                            :class="contentOpen ? 'height-auto' : ''" x-transition.delay.5s>
                                            <div class="desc">Need to Review</div>
                                        </div><!-- /.actifity-content -->
                                        <div class="activity-footer opacity-50">{{$rule->updated_at->diffForHumans()}}</div>
                                    </div><!-- /.activity-item -->
                                </div>
                            </div><!-- /.author -->
                        </div><!-- /.info-items -->
                    </div><!-- /.info -->
                    @endforeach
                @endcan

                @can('rule-maker')
                    @foreach($returnedRules as $key => $rule)
                    <div class="info-item py-1">
                        <div class="activity d-flex flex-column gap-2">
                            <div class="item-content d-flex gap-1 align-items-center">
                                <div class="activity-item d-flex flex-column gap-2">
                                    <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">                                        
                                            <div class="title d-flex flex-column">
                                                <a target="blank" href="{{route('kpp::rules.detail', ['id' => $rule->id])}}">{{$rule->number}}</a>
                                                <span class="opacity-50">{{$rule->title}}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="tools">
                                            <a href="#" role="button" data-bs-toggle="modal"
                                                data-bs-target="#modalActivity">
                                                <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                                            </a>
                                        </div> -->
                                    </div><!-- /.activity-item -->
                                    <div class="activity-content" x-data="{ contentOpen: false }">
                                        <div class="activity-inner h-auto d-flex flex-column gap-2"
                                            :class="contentOpen ? 'height-auto' : ''" x-transition.delay.5s>
                                            <div class="desc">{{$rule->comment ?? '-'}}</div>
                                        </div><!-- /.actifity-content -->
                                        <div class="activity-footer opacity-50">{{$rule->updated_at->diffForHumans()}}</div>
                                    </div><!-- /.activity-item -->
                                </div>
                            </div><!-- /.author -->
                        </div><!-- /.info-items -->
                    </div><!-- /.info -->
                    @endforeach
                @endcan

            </div><!-- /.detail-left -->

        </div><!-- /.detail-maker -->
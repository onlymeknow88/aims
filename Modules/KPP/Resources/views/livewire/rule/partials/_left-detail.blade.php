<div class="detail-left border-end border-1">

    <div class="info bg-white">

        <div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <h6 class="fw-normal">Pembuat Dokumen</h6>
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">{{$rule->createdBy->name ?? '-'}}</div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

        @if($rule->oldRule)
        <div class="info-item p-3 border-bottom border-1">

            <div class="created d-flex flex-column gap-2">

                <h6 class="fw-normal">Peraturan Lama</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50"></span>
                    <span>
                        <a style="color: green; font-weight: bold" href="{{ route('kpp::rules.detail', ['id' => $rule->oldRule->id]) }}">
                            {{ $rule->oldRule->number }}
                        </a>
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->
        @endif

        <div class="info-item p-3 border-bottom border-1">

            <div class="pt d-flex flex-column gap-2">
                <!-- <h6 class="fw-normal"></h6> -->
                <div class="item-content d-flex gap-2 align-items-start">
                    <div class="thumb">
                        <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                    </div>
                    <div class="location-name d-flex flex-column">
                        <span class="opacity-50">Status</span>
                        <span>{{$rule->status}}</span>
                    </div>
                </div>

                <div class="item-content d-flex gap-2 align-items-start">
                    <div class="thumb">
                        <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                    </div>
                    <div class="location-name d-flex flex-column">
                        <span class="opacity-50">Document Type</span>
                        <span>{{$rule->document_type}}</span>
                    </div>
                </div>
                
            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="created d-flex flex-column gap-2">

                <h6 class="fw-normal">Approved</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span>{{date("d-F-Y", strtotime($rule->approved_date))}}</span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <!--  -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="expired d-flex flex-column gap-2">

                <h6 class="fw-normal">Effective</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50">on</span>
                    <span>
                        {{date("d-F-Y", strtotime($rule->effective_date))}}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="expired d-flex flex-column gap-2">

                <h6 class="fw-normal">Expired</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50">at</span>
                    <span>
                        -
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->
        

        {{--<div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <h6 class="fw-normal">View By</h6>
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">
                        
                    </div>
                </div>
            </div>

        </div>--}}

    </div><!-- /.info -->

</div>
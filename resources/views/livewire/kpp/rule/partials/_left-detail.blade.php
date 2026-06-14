<div class="detail-left border-end border-1">

    <div class="info bg-white">

        <div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">{{Auth::user()->name}}</div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="created d-flex flex-column gap-2">

                <h6 class="fw-normal">Status</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50"></span>
                    <span>
                        {{$rule->status}}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

        <div class="info-item p-3 border-bottom border-1">

            <div class="created d-flex flex-column gap-2">

                <h6 class="fw-normal">Approved</h6>

                <div class="item-content d-flex gap-1 align-items-center">
                    <span class="opacity-50">on</span>
                    <span>
                        {{date("d-F-Y", strtotime($rule->approved_date))}}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->

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
                        {{date("d-F-Y", strtotime($rule->expired_date))}}
                    </span>
                </div>

            </div><!-- /.author -->

        </div><!-- /.info-items -->
        

        <div class="info-item p-3 border-bottom border-1">

            <div class="author d-flex flex-column gap-2">
                <h6 class="fw-normal">View By</h6>
                <div class="item-content d-flex gap-2 align-items-center">
                    <div class="thumb">
                        <img src="{{ asset('./images/author.png') }}" alt="Author">
                    </div>
                    <div class="author-name">
                        
                    </div>
                </div>
            </div><!-- /.author -->

        </div><!-- /.info-items -->

    </div><!-- /.info -->

</div>
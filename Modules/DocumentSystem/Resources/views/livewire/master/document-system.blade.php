@push('styles')
    <style>
        .text-empty {
            font-size: 12px;
        }
    </style>
@endpush
<div class="inner-content">
    <div class="addnew-maker-content container py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="" class="col-form-label col-md-4">
                            @lang('global.cron_schedule')
                        </label>
                        <div class="col-md-8">
                            <button class="btn btn-light w-100 d-flex align-items-center justify-content-center gap-3" type="button">
                                <img src="{{ asset('images/icons/add_.png') }}"
                                     alt=""
                                    style="width: 10px; height: 10px;">
                                Add new
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

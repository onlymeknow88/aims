@section('title')
    Safety Performance @if ($Id)
        Update
    @else
        Create
    @endif
@endsection

<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('safety_performance_index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Safety Performance
                </span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">
                {{-- Validate --}}
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif


                <form action="#" class="form-horizontal" wire:submit.prevent="store">

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Month</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control datepicker" id="datepicker"
                                wire:model="input.month" onchange="inputMonth()">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            @error('input.month')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">AIFR</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" wire:model.lazy="input.aifr" class="form-control"
                                placeholder="" />
                            @error('input.aifr')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">AINFR</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" wire:model.lazy="input.ainfr" class="form-control"
                                placeholder="" />
                            @error('input.ainfr')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">LTI FR</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" wire:model.lazy="input.lti_fr" class="form-control"
                                placeholder="" />
                            @error('input.lti_fr')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">LTI SR</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" wire:model.lazy="input.lti_sr" class="form-control"
                                placeholder="" />
                            @error('input.lti_sr')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div wire:loading wire:target="store,edit" class="spinner" style="z-index:999">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('k3lh_activities_index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success" wire:target="input.file"
                                wire:loading.attr="disabled">
                                @if ($Id)
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                    </div>


                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->
</div>

@push('styles')
    <style>
        .spinner {
            z-index: 1100;
            position: absolute;
            top: 35%;
            right: 50%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        Livewire.on('clearEmailInput', () => {
            $('input#invited_people').val('').focus()
        })
    </script>
@endpush

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    @endpush
@endonce

@once
    @push('scripts')
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $("#datepicker").datepicker({
            format: "M yyyy",
            viewMode: "months",
            minViewMode: "months",
        });

        function inputMonth() {
            var x = document.getElementById("datepicker");
            if (x) {
                @this.set('input.month', x.value);
            }

        }
    </script>
@endpush

@section('title')
    General @if ($Id)
        Update
    @else
        Create
    @endif
@endsection

<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('production_index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Production</span>
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
                                wire:model.lazy="input.month" onchange="inputMonth()" readonly>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>

                            @error('input.month')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>



                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Coal Shiping</label>
                        <div class="col-sm-8">
                            <input type="number" wire:model.lazy="input.coal_shiping" class="form-control"
                                placeholder="" />
                            @error('input.coal_shiping')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Waste Removal</label>
                        <div class="col-sm-8">
                            <input type="number" wire:model.lazy="input.waste_removal" class="form-control"
                                placeholder="" />
                            @error('input.waste_removal')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Coal Mining</label>
                        <div class="col-sm-8">
                            <input type="number" wire:model.lazy="input.coal_mining" class="form-control"
                                placeholder="" />
                            @error('input.coal_mining')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Coal hauling</label>
                        <div class="col-sm-8">
                            <input type="number" wire:model.lazy="input.coal_hauling" class="form-control"
                                placeholder="" />
                            @error('input.coal_hauling')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Coal Barge</label>
                        <div class="col-sm-8">
                            <input type="number" wire:model.lazy="input.coal_barged" class="form-control"
                                placeholder="" />
                            @error('input.coal_barged')
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
                            <a href="{{ route('general_index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">
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

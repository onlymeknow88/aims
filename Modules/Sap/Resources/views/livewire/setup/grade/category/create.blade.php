@section('title')
    Setup Category
    @if ($Id)
        Update
    @else
        Create
    @endif
@endsection

<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('sap-setup-category-index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Setup Category
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
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Year</label>
                        <div class="col-sm-8">
                            <select wire:model="input.name" class="form-control">
                                <option value="">--select--</option>
                                @foreach ($years as $listYear)
                                    <option value="{{ $listYear['year'] }}">{{ $listYear['year'] }}</option>
                                @endforeach
                            </select>

                            @error('input.name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror

                            @error('slug')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <textarea wire:model.lazy="input.description" class="form-control" placeholder=""></textarea>
                            @error('input.description')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Foreman Supervisor & Sec. Head</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.foreman_supervisor_sechead"
                                class="form-control" placeholder="" />
                            @error('input.foreman_supervisor_sechead')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Employee</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.employee" class="form-control"
                                placeholder="" />
                            @error('input.employee')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div wire:loading wire:target="store" class="spinner" style="z-index:999">
                        <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('sap-monthly-category-index') }}"
                                class="btn btn-outline-secondary">Cancel</a>
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




@push('scripts')
    <script>
        Livewire.on('clearEmailInput', () => {
            $('input#invited_people').val('').focus()
        })
    </script>
@endpush

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

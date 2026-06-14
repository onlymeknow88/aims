@section('title')
    Strategic Project @if ($Id)
        Update
    @else
        Create
    @endif
@endsection



<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('strategic_project_index') }}" class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Strategic Project
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

                    <div class="row justify-content-end d-none">
                        <div class="col-sm-8">
                            @if (isset($input['file']))
                                @if ($input['file'])
                                    <img src="{{ $input['file']->temporaryUrl() }}" class="input-img">
                                @endif
                                <div wire:loading wire:target="input.file" class="spinner" style="z-index:999">
                                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            @elseif(isset($input['url']))
                                @if ($input['url'])
                                    <img src="{{ url($input['url']) }}" class="input-img">
                                @endif
                            @else
                                <div class="input-img-none"></div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Image</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" wire:model="input.file" id="formFile">
                            @error('input.file')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="datepicker" wire:model.lazy="input.date"
                                onchange="inputMonth()" readonly>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                            @error('input.date')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Title</label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="input.title" class="form-control" placeholder="" />
                            @error('input.title')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-group row ">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                            <div wire:ignore>
                                <textarea wire:model="input.description" id="input-description" :error="'input.description'" class="form-control"></textarea>
                            </div>
                            @error('input.description')
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
                            <a href="{{ route('news_and_update_index') }}" class="btn btn-outline-secondary">Cancel</a>
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

@push('styles')
    <style>
        .input-img {
            height: 200px;
            border-radius: 8px;
            margin: 10px 0px 10px 0px;
            border: 1px solid gray;
        }

        .input-img-none {
            height: 200px;
            width: 400px;
            border-radius: 8px;
            margin: 10px 0px 10px 0px;
            border: 1px solid gray;
        }
    </style>
@endpush


@push('scripts')
    <script>
        Livewire.on('clearEmailInput', () => {
            $('input#invited_people').val('').focus()
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#input-description').summernote({
                placeholder: '',
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture']],
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        @this.set('input.description', contents);
                    }
                }
            });
        });
    </script>
@endpush


@once
    @push('scripts')
        <!-- summernote -->
        <script src="{{ asset('assets/libs/summernote/summernote.min.js') }}"></script>
    @endpush
@endonce


@once
    @push('styles')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote.min.css') }}">
    @endpush
@endonce


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
            format: "yyyy-m-d",
            autoclose: true,
        });

        function inputMonth() {
            var x = document.getElementById("datepicker");
            if (x) {
                @this.set('input.date', x.value);
            }

        }
    </script>
@endpush

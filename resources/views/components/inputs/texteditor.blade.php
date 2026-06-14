@props(['id', 'error'])

<div wire:ignore>
    <textarea {{ $attributes }} class="form-control summernote @error($error) is-invalid @enderror"
        id="{{ $id }}"></textarea>
    @error($error)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>


@once
    @push('styles')
        <!-- summernote -->
        <!--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">-->
        <link rel="stylesheet" href="{{ asset('assets/libs/summernote/summernote.min.css') }}">
        <style>
            .note-editor .link-dialog .checkbox.sn-checkbox-use-protocol { display: none; }
            .note-icon-caret{display: none;}
            .link-dialog .close{
                display: none;
            }
        </style>
    @endpush
@endonce

@once
    @push('scripts')
        <!-- summernote -->
        <!--<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>-->
        <script src="{{ asset('assets/libs/summernote/summernote.min.js') }}"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function() {
            $('#{{ $id }}').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link']],
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $('#{{ $id }}').val(contents)
                        //@this.set('description', contents);
                    }
                }
            });

            let buttons = $('.note-editor button[data-toggle="dropdown"]');
            buttons.each((key, value) => {
                $(value).removeAttr("data-toggle").attr("data-bs-toggle", "dropdown");
            })
        });
        
    </script>
@endpush

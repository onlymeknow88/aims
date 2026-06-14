@props(['id','error','disabled','name'])

<div wire:ignore>
    <textarea {{ $attributes }} 
              class="form-control {{isset($disabled)?"disabled":""}} summernote @error($error) is-invalid @enderror"
              id="{{ $id }}" disabled>{{$slot}}</textarea>
    @error($error)
    <div class="invalid-feedback">
        {{ $message }}
    </div>

    @enderror
</div>


@once
    @push('styles')
        <!-- summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @endpush
@endonce

@once
    @push('scripts')
        <!-- summernote -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        $(function () {
            $('#{{ $id }}').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        @this.
                        set('{{$name}}', contents);
                    }
                },
            });

            let buttons = $('.note-editor button[data-toggle="dropdown"]');
            buttons.each((key, value) => {
                $(value).removeAttr("data-toggle").attr("data-bs-toggle", "dropdown");
            })

        });
    </script>
@endpush

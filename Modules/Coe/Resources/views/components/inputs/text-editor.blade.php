@props(['id', 'error', 'model' => null, 'default' => null])

<div wire:ignore>
    <textarea {{ $attributes }} input="description" class="form-control summernote" @error($error) is-invalid @enderror" id="{{ $id }}">{{ $default }}</textarea>
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
        $(function() {
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'help']]
                ],
                callbacks: {
                    onBlur: function(contents) {
                        @this.set('{{ $model }}', contents.currentTarget.innerHTML);
                    }
                }
            });
        });
    </script>
@endpush

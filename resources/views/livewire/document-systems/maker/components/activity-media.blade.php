@if (isset($images[$activity->id]))
    <div class="images">
        <h6 class="fw-normal">@lang('global.images')</h6>
        @foreach ($images[$activity->id] as $image)
            <div
                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                <div class="d-flex gap-2 align-items-center" wire:click.prevent="detailItem('{{ $image['id'] }}')">
                    <div class="thumb">
                        <img class="img-preview" src="{{ $image['preview'] }}" alt="activity">
                    </div>
                    <span class="img-name">{{ $image['name'] }}</span>
                    {{-- <span class="img-name">oke</span> --}}
                </div>
                <div class="img-size opacity-50">{{ $image['size'] }} Kb</div>
            </div><!-- image -->
        @endforeach
    </div><!-- /.images -->
@endif

@if (isset($files[$activity->id]))
    <div class="images">
        <h6 class="fw-normal">@lang('global.files')</h6>

        @foreach ($files[$activity->id] as $file)
            <div
                class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                <div class="d-flex gap-2 align-items-center" wire:click.prevent="detailItem('{{ $file['id'] }}')">
                    <div class="thumb">
                        <img src="{{ $file['ext_icon'] }}" class="img-preview" alt="excel">
                    </div>
                    <span class="img-name">{{ $file['name'] }}</span>
                </div>
                <div class="img-size opacity-50">{{ $file['size'] }} Kb</div>
            </div><!-- image -->
        @endforeach
    </div><!-- /.files -->
@endif

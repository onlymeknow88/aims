<button class="btn btn-basic-green text-white"
    wire:loading
    wire:target='{{ $target }}'
    wire:loading.attr='disabled'>
    <div class="spinner-border text-white" role="status" style="width: 1rem; height: 1rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    {{ $text }}
</button>

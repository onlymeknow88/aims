@if ($paginator->hasPages())


    @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)    

    <div class="row-data opacity-80 d-flex gap-1 align-items-center">  
              
        <span class="input-limit w-100px">
            <x-inputs.number wire:model="limit" id="limit" placeholder="0" value="{{$limit}}" :error="'limit'" />
        </span>
        {{-- <span class="font-medium">{{ $paginator->lastItem() }}</span> --}}
        <span>{!! __('of') !!}</span>
        <span class="font-medium">{{ $paginator->total() }}</span>
        <span>{!! __('results') !!}</span>
    </div>

@endif
@push('styles')
    <style>
        .active>.page-link, .page-link.active {
            background-color: #146943;
            border-color: #146943;
            box-shadow: none;
        }
        .page-link{
            color: #146943;
        }
    </style>
@endpush
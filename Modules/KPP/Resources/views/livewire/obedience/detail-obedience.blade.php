<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="{{route('kpp::obediences.index')}}" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Kepatuhan</span>
        </a>

        @can('KPP - Create Ekstraksi')
            @if($obedience->rule->status != 'Tidak Berlaku')
            <a href="{{ route('kpp::obediences.create-extraction', ['obedience' => $obedience->id]) }}" class="btn btn-edit text-white bg-146943"> <i class="fas fa-plus"></i> Add New Extraction</a>
            @endif
        @endcan
        
    </div>

    <div class="detail-approval-content d-flex">
        @include('kpp::livewire.obedience.partials._left-detail')
        @include('kpp::livewire.obedience.partials._center-detail')
        @include('kpp::livewire.obedience.partials._right-detail')

    </div>
</div>
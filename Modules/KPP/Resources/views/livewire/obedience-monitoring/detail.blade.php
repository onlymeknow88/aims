<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="#" onclick="history.back();" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Back</span>
        </a>
    </div>

    <div class="detail-approval-content d-flex">
        @include('kpp::livewire.obedience-monitoring.partials._left-detail')
        @include('kpp::livewire.obedience-monitoring.partials._center-detail')
        @include('kpp::livewire.obedience-monitoring.partials._right-detail')

    </div>
</div>
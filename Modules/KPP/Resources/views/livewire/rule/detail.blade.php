<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="{{ route('kpp::rules.index') }}" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Peraturan</span>
        </a>

        @can('KPP - Edit Peraturan')
        <div class="footer-action">
            <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                <div class="button-document">
                    <button
                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More Action
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{route('kpp::rules.edit', ['id' => $rule->id])}}" class="dropdown-item">Edit</a>
                        </li>
                        <li>
                            <a href="{{route('kpp::rules.replace', ['id' => $rule->id])}}" class="dropdown-item">Ganti Peraturan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endcan
        
    </div>

    <div class="detail-approval-content d-flex">
        @include('kpp::livewire.rule.partials._left-detail')
        @include('kpp::livewire.rule.partials._center-detail')
        @include('kpp::livewire.rule.partials._right-detail')

    </div>
</div>
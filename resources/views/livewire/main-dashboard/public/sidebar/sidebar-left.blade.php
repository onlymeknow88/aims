<div class="content-sidebar">
    <div class="mb-3">
        <div class="sidebar-left-close destop-hide">
            <a href="javascript:void(0)" class="btn border" onclick="closeNavLeft()" style="margin-top:30px"><i
                    class="fas fa-chevron-left"></i></a>
        </div>

        {{-- <div class="logo">
            <img src="{{ asset('./images/logo-login.png') }}" alt="logo" />
        </div> --}}

    @php
        $user = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();

        $sidebarModules = [
            'coe'              => ['url' => 'coe',              'label' => 'Calendar Of Event'],
            'document-system'  => ['url' => 'document-systems', 'label' => 'Document System'],
            'sap'              => ['url' => 'sap',              'label' => 'Safety Accountability Program'],
            'field-leadership' => ['url' => 'field-leadership', 'label' => 'Field Leadership'],
            'kplh'             => ['url' => 'kplh',             'label' => 'Inspection'],
            'audit'            => ['url' => 'audit',            'label' => 'Audit'],
            'ibpr-and-bowtie'  => ['url' => 'ibpr-and-bowtie',  'label' => 'Management Risk'],
            'kpp'              => ['url' => 'kpp',              'label' => 'Compliance Regulation'],
            'mcu'              => ['url' => 'mcu',              'label' => 'Medical Check Up'],
            'csms'             => ['url' => 'csms',             'label' => 'Contractor Safety Management'],
            'ko'               => ['url' => 'ko',               'label' => 'Safety Operation'],
            'pica'             => ['url' => 'pica',             'label' => 'PICA'],
        ];
        $isHomeActive = request()->is('/') || request()->is('home');
    @endphp
    <ul>
        <li class="item-sidebar {{ $isHomeActive ? 'active' : '' }} mx-3">
            <a href="{{ url('/') }}"
                class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">Home</a>
        </li>

        @foreach($sidebarModules as $guard => $info)
            @php
                $hasAccess = ($user && method_exists($user, 'hasAccessToGuard')) ? $user->hasAccessToGuard($guard) : ($user instanceof \App\Models\Admin);
                $isActive = request()->is($info['url']) || request()->is($info['url'] . '/*');
            @endphp
            @if($hasAccess)
                <li class="item-sidebar {{ $isActive ? 'active' : '' }} mx-3">
                    <a href="{{ url($info['url']) }}"
                        class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">{{ $info['label'] }}</a>
                </li>
            @endif
        @endforeach

            <li class="mx-3 mb-3">
                <hr>
                <div class="container-btn-filter">
                    <a href="javascript:void(0)" class="btn btn-sm border" onclick="openNavLeft2()">Filter</a>
                    <div class="icon-btn-filter">
                        <span id="icon-btn-filter">></span>
                    </div>
                </div>
                <hr>
            </li>

        </ul>

        {{-- <div class="help-sidebar position-fixed bottom-0 d-flex mx-3" style="width: 10px">
            <a href="{{ url('') }}"
                class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">Help</a>
        </div> --}}
    </div><!-- /.content-sidebar -->
</div>

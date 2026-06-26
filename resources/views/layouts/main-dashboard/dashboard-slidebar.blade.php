<div class="content-sidebar">
    <div class="sidebar-left-close destop-hide">
        <a href="javascript:void(0)" onclick="closeNavLeft()"><i class="far fa-times-circle"></i></a></a>
    </div>
    <div>

    </div>

    @php
        $user = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();

        $sidebarModules = [
            'coe' => ['url' => 'coe', 'label' => 'Calendar Of Event'],
            'document-system' => ['url' => 'document-systems', 'label' => 'Document System'],
            'sap' => ['url' => 'sap', 'label' => 'Safety Accountability Program'],
            'field-leadership' => ['url' => 'field-leadership', 'label' => 'Field Leadership'],
            'kplh' => ['url' => 'kplh', 'label' => 'Inspection'],
            'audit' => ['url' => 'audit', 'label' => 'Audit'],
            'ibpr-and-bowtie' => ['url' => 'ibpr-and-bowtie', 'label' => 'Management Risk'],
            'kpp' => ['url' => 'kpp', 'label' => 'Compliance Regulation'],
            'mcu' => ['url' => 'mcu', 'label' => 'Medical Check Up'],
            'csms' => ['url' => 'csms', 'label' => 'CMS'],
            'ko' => ['url' => 'ko', 'label' => 'Safety Operation'],
            'pica' => ['url' => 'pica', 'label' => 'PICA'],
        ];
        $isHomeActive = request()->is('/') || request()->is('home');
    @endphp
    <ul>
        <li class="my-1 mx-3">
            <a href="javascript:void(0)" class="btn btn-sm border" onclick="openNavLeft2()">Filter></a>
        </li>

        <li class="item-sidebar {{ $isHomeActive ? 'active' : '' }} my-1 mx-3">
            <a href="{{ url('/') }}"
                class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">Home</a>
        </li>

        @foreach($sidebarModules as $guard => $info)
            @php
                $hasAccess = ($user && method_exists($user, 'hasAccessToGuard')) ? $user->hasAccessToGuard($guard) : ($user instanceof \App\Models\Admin);
                $isActive = request()->is($info['url']) || request()->is($info['url'] . '/*');
            @endphp
            @if($hasAccess)
                <li class="item-sidebar {{ $isActive ? 'active' : '' }} my-1 mx-3">
                    <a href="{{ url($info['url']) }}"
                        class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">{{ $info['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ul>

    <div class="help-sidebar position-fixed bottom-0 d-flex my-1 mx-3" style="width: 10px">
        <a href="{{ url('') }}"
            class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded ">Help</a>
    </div>
</div><!-- /.content-sidebar -->

@push('styles')
    <style>
        .scroll-box::-webkit-scrollbar {
            width: 10px;
        }

        /* Track */
        .scroll-box::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .scroll-box::-webkit-scrollbar-thumb {
            background: #179b52;
        }

        /* Handle on hover */
        .scroll-box::-webkit-scrollbar-thumb:hover {
            background: #105e2c;
        }

        .scroll-box {
            overflow: auto;
            scrollbar-width: thin;
        }
    </style>
@endpush
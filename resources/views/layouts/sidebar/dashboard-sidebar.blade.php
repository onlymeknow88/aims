<div class="content-sidebar h-100">
    <div class="image-adaro d-flex justify-content-center py-2 px-3">
        <img src="{{ asset('images/logo.png') }}" alt="Image Banner" srcset="{{ asset('images/logo.png') }}" />
    </div>
    @php
        $user = Auth::user();
        $sidebarModules = [
            'coe'              => ['route' => 'coe::dashboard',          'label' => 'Calendar Of Event',          'icon' => 'fa-calendar-days'],
            'document-system'  => ['route' => 'document-systems::dashboard', 'label' => 'Document System',        'icon' => 'fa-folder-open'],
            'sap'              => ['route' => 'sap-home-index',          'label' => 'Safety Accountability Program', 'icon' => 'fa-chart-pie'],
            'field-leadership' => ['route' => 'field-leadership::dashboard', 'label' => 'Field Leadership',       'icon' => 'fa-user-tie'],
            'kplh'             => ['route' => 'kplh::dashboard',         'label' => 'Inspection',                 'icon' => 'fa-leaf'],
            'audit'            => ['route' => 'audit::dashboard',        'label' => 'Audit',                      'icon' => 'fa-list-check'],
            'ibpr-and-bowtie'  => ['route' => 'ibpr-and-bowtie::dashboard', 'label' => 'Management Risk',          'icon' => 'fa-bezier-curve'],
            'kpp'              => ['route' => 'kpp::dashboard',          'label' => 'Compliance Regulation',      'icon' => 'fa-file-shield'],
            'mcu'              => ['route' => 'mcu::index',              'label' => 'Medical Check Up',           'icon' => 'fa-heart-pulse'],
            'csms'             => ['route' => 'csms::dashboard',         'label' => 'Contractor Safety Management', 'icon' => 'fa-users-gear'],
            'ko'               => ['route' => 'ko::dashboard',           'label' => 'Safety Operation',           'icon' => 'fa-shield-halved'],
            'pica'             => ['route' => 'pica::dashboard',         'label' => 'PICA',                       'icon' => 'fa-triangle-exclamation'],
        ];
    @endphp
    <ul>
        @auth
            <li class="item-sidebar my-1 mx-3">
                <a href="{{ url('/home') }}" class="d-flex align-items-center justify-content-between fw-bold py-2 px-3 rounded text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); text-decoration: none;">
                    <span><i class="fa-solid fa-gauge me-2"></i> Dashboard AIMS</span>
                </a>
            </li>
        @else
            <li class="item-sidebar my-1 mx-3">
                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-between fw-bold py-2 px-3 rounded text-white" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2); text-decoration: none;">
                    <span><i class="fa-solid fa-right-to-bracket me-2"></i> Login ke AIMS</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </li>
        @endauth

        <li class="item-sidebar my-1 mx-3">
            <a href="{{url('/')}}" class="d-flex align-items-center justify-content-between fw-normal bg-green py-2 px-3 rounded text-white" style="text-decoration: none;">
                <span><i class="fa-solid fa-house me-2"></i> Home</span>
            </a>
        </li>

        @foreach($sidebarModules as $guard => $info)
            @php
                $hasAccess = ($user && method_exists($user, 'hasAccessToGuard')) ? $user->hasAccessToGuard($guard) : ($user instanceof \App\Models\Admin);
                $isActive = false;
                try {
                    $isActive = request()->routeIs($info['route']);
                } catch (\Exception $e) {}
            @endphp
            @if($hasAccess)
                <li class="item-sidebar my-1 mx-3">
                    <a href="{{ route($info['route']) }}" 
                       class="d-flex align-items-center justify-content-between fw-normal bg-green py-2 px-3 rounded text-white {{ $isActive ? 'active-module' : '' }}" 
                       style="text-decoration: none;">
                        <span><i class="fa-solid {{ $info['icon'] }} me-2"></i> {{ $info['label'] }}</span>
                        <i class="fa-solid fa-chevron-right fs-7" style="opacity: 0.7;"></i>
                    </a>
                </li>
            @endif
        @endforeach

        <li class="help-sidebar position-absolute bottom-0 d-flex my-1 mx-3 last">
            <a href="{{url('')}}" class="d-flex align-items-center justify-content-between fw-normal bg-green py-2 px-3 rounded text-white">Help</a>
        </li> 
    </ul> 
    <div class="help-sidebar position-fixed bottom-0 d-flex my-1 mx-3">
        <a href="{{url('')}}" class="d-flex align-items-center justify-content-between fw-normal bg-green py-2 px-3 rounded text-white">Help</a>
    </div> 
</div><!-- /.content-sidebar -->

<div class="content-sidebar">
    @once
        @push('styles')
            <style>
                /* Sidebar Wrapper */
                .content-sidebar {
                    padding: 1.5rem 0.5rem 2rem 0.5rem !important;
                    font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                    background-color: #ffffff !important;
                    display: flex !important;
                    flex-direction: column !important;
                    justify-content: space-between !important;
                    height: 100% !important;
                    min-height: calc(100vh - 3rem) !important;
                }

                /* Sidebar Section Headers */
                .sidebar-section-header {
                    font-size: 0.72rem !important;
                    text-transform: uppercase !important;
                    letter-spacing: 0.08em !important;
                    color: #94a3b8 !important;
                    /* Muted Slate */
                    font-weight: 700 !important;
                    margin: 1.5rem 1rem 0.5rem 1rem !important;
                }

                /* Sidebar Menu List */
                .content-sidebar ul {
                    list-style-type: none !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 0.35rem !important;
                }

                /* Sidebar Item link base styling */
                .content-sidebar .item-sidebar a {
                    color: #475569 !important;
                    /* Cool slate grey */
                    font-weight: 500 !important;
                    text-decoration: none !important;
                    transition: all 0.2s ease-in-out !important;
                    border-radius: 12px !important;
                    font-size: 0.92rem !important;
                    padding: 0.7rem 1rem !important;
                }

                .content-sidebar .item-sidebar a i {
                    font-size: 1.2rem !important;
                    width: 24px !important;
                    text-align: center !important;
                    color: #64748b !important;
                    transition: color 0.2s ease-in-out !important;
                }

                /* Hover style */
                .content-sidebar .item-sidebar a:hover {
                    background-color: #f8fafc !important;
                    /* Very light grey */
                    color: #0f172a !important;
                }

                .content-sidebar .item-sidebar a:hover i {
                    color: #0f172a !important;
                }

                /* Active style: Soft green background and darker green text */
                .content-sidebar .item-sidebar.active a {
                    background-color: #e8f5e9 !important;
                    /* Soft green (#e8f5e9 or #f0fdf4) */
                    color: #16a34a !important;
                    /* Dark green */
                    font-weight: 600 !important;
                }

                .content-sidebar .item-sidebar.active a i {
                    color: #16a34a !important;
                }

                /* Bottom Actions container */
                .sidebar-bottom-container {
                    margin-top: auto !important;
                    padding-top: 1.5rem !important;
                    display: flex !important;
                    flex-direction: column !important;
                    gap: 0.35rem !important;
                }

                /* Danger / Logout styling */
                .content-sidebar .item-sidebar-danger a {
                    color: #dc2626 !important;
                    /* Red */
                    font-weight: 600 !important;
                    text-decoration: none !important;
                    transition: all 0.2s ease-in-out !important;
                    border-radius: 12px !important;
                    font-size: 0.92rem !important;
                    padding: 0.7rem 1rem !important;
                }

                .content-sidebar .item-sidebar-danger a i {
                    font-size: 1.2rem !important;
                    width: 24px !important;
                    text-align: center !important;
                    color: #dc2626 !important;
                    transition: color 0.2s ease-in-out !important;
                }

                .content-sidebar .item-sidebar-danger a:hover {
                    background-color: #fef2f2 !important;
                    /* Soft red hover */
                    color: #b91c1c !important;
                }

                .content-sidebar .item-sidebar-danger a:hover i {
                    color: #b91c1c !important;
                }

                /* Divider */
                .content-sidebar hr {
                    border-top: 1px solid #f1f5f9 !important;
                    margin: 1rem 1rem !important;
                    opacity: 0.8 !important;
                }
            </style>
        @endpush
    @endonce

    <div class="sidebar-top-section">
        <div class="sidebar-left-close destop-hide mb-3">
            <a href="javascript:void(0)" class="btn border" onclick="closeNavLeft()" style="margin-top:30px"><i
                    class="fas fa-chevron-left"></i></a>
        </div>

        @php
            $user = Auth::guard('web')->user() ?: Auth::guard('dashboard')->user();

            $sidebarModules = [
                'coe' => ['url' => 'coe', 'label' => 'Calendar Of Event', 'icon' => 'fa-regular fa-calendar'],
                'document-system' => ['url' => 'document-systems', 'label' => 'Document System', 'icon' => 'fa-regular fa-file-lines'],
                'sap' => ['url' => 'sap', 'label' => 'Safety Accountability Program', 'icon' => 'fa-regular fa-clipboard'],
                'field-leadership' => ['url' => 'field-leadership', 'label' => 'Field Leadership', 'icon' => 'fa-regular fa-address-book'],
                'kplh' => ['url' => 'kplh', 'label' => 'Inspection', 'icon' => 'fa-regular fa-circle-check'],
                'audit' => ['url' => 'audit', 'label' => 'Audit', 'icon' => 'fa-regular fa-chart-bar'],
                'ibpr-and-bowtie' => ['url' => 'ibpr-and-bowtie', 'label' => 'Management Risk', 'icon' => 'fa-regular fa-bell'],
                'kpp' => ['url' => 'kpp', 'label' => 'Compliance Regulation', 'icon' => 'fa-regular fa-handshake'],
                'mcu' => ['url' => 'mcu', 'label' => 'Medical Check Up', 'icon' => 'fa-regular fa-hospital'],
                'csms' => ['url' => 'csms', 'label' => 'Contractor Safety Management', 'icon' => 'fa-regular fa-building'],
                'ko' => ['url' => 'ko', 'label' => 'Safety Operation', 'icon' => 'fa-regular fa-shield-halved'],
                'pica' => ['url' => 'pica', 'label' => 'PICA', 'icon' => 'fa-regular fa-circle-question'],
            ];
            $isHomeActive = request()->is('/') || request()->is('home');
        @endphp

        <ul>
            <li class="item-sidebar {{ $isHomeActive ? 'active' : '' }} mx-2">
                <a href="{{ url('/') }}"
                    class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded">
                    <span class="d-flex align-items-center gap-2">
                        Home
                    </span>
                </a>
            </li>

            @foreach($sidebarModules as $guard => $info)
                @php
                    $hasAccess = ($user && method_exists($user, 'hasAccessToGuard')) ? $user->hasAccessToGuard($guard) : ($user instanceof \App\Models\Admin);
                    $isActive = request()->is($info['url']) || request()->is($info['url'] . '/*');
                @endphp
                @if($hasAccess)
                    <li class="item-sidebar {{ $isActive ? 'active' : '' }} mx-2">
                        <a href="{{ url($info['url']) }}"
                            class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded">
                            <span class="d-flex align-items-center gap-2">
                                <i class="{{ $info['icon'] }}"></i> {{ $info['label'] }}
                            </span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="sidebar-bottom-container">
        <ul>
            <li class="item-sidebar mx-2">
                <a href="javascript:void(0)" onclick="openNavLeft2()"
                    class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded">
                    <span class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-sliders"></i> Filter
                    </span>
                    <span id="icon-btn-filter" style="display: none;">></span>
                </a>
            </li>

            {{-- @if (Auth::guard('web')->check() || Auth::guard('dashboard')->check())
                <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar" class="d-none">
                    @csrf
                </form>
                <li class="item-sidebar-danger mx-2">
                    <a href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();"
                        class="d-flex align-items-center justify-content-between fw-normal py-2 px-3 rounded">
                        <span class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout Account
                        </span>
                    </a>
                </li>
            @endif --}}
        </ul>
    </div>
</div>

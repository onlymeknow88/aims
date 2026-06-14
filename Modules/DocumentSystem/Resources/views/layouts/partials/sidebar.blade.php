    <div class="content-sidebar">
        <ul>
            <li class="item-sidebar">
                <a href="{{ route('dashboard-public') }}"
                    class="link-sidebar text-decoration-none">
                    Home AIMS
                </a>
            </li>
            <li class="item-sidebar">
                <a href="{{ route('document-systems::dashboard') }}" class="link-sidebar text-decoration-none">
                    Dashboard
                </a>
            </li>
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('document-systems::maker.*') || Request::routeIs('document-systems::ongoing.*') || Request::routeIs('document-systems::document-systems.obsolate.*') || Request::routeIs('document-systems::document-systems.draft.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#subSidebarMaster" role="button" aria-expanded="false"
                    aria-controls="subSidebarMaster">
                    @lang('global.document_system')
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('document-systems::maker') || Request::routeIs('document-systems::ongoing') || Request::routeIs('document-systems::document-systems.obsolate') || Request::routeIs('document-systems::document-systems.draft') ? 'show' : '' }}"
                    id="subSidebarMaster">
                    @can('Document System - View Active Document')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::maker') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::maker') ? 'active' : '' }}">
                                @lang('documentsystem::global.active_document')
                            </a>
                        </li>
                    @endcan
                    @can('Document System - View OnGoing Document')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::ongoing') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::ongoing') ? 'active' : '' }}">
                                Document On Review
                            </a>
                        </li>
                    @endcan
                    @can('Document System - View Obsolate Document')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::document-systems.obsolate') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::document-systems.obsolate') ? 'active' : '' }}">
                                Obsolete Document
                            </a>
                        </li>
                    @endcan
                    @can('Document System - View Draft Document')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::document-systems.draft') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::document-systems.draft') ? 'active' : '' }}">
                                @lang('documentsystem::global.draft')
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            {{-- jsa --}}
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('document-systems::jsa.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#jsa-menu" role="button" aria-expanded="false"
                    aria-controls="subSidebarMaster">
                    Job Safety Analysis (JSA)
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('document-systems::jsa.*') ? 'show' : '' }}"
                    id="jsa-menu">
                    @can('Document System - View Active JSA')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::jsa.active') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::jsa.active') ? 'active' : '' }}">
                                @lang('documentsystem::global.active')
                                @lang('documentsystem::global.jsa')
                            </a>
                        </li>
                    @endcan
                    @can('Document System - View Obsolate JSA')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::jsa.obsolate') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::jsa.obsolate') ? 'active' : '' }}">
                                @lang('documentsystem::global.obsolate')
                                @lang('documentsystem::global.jsa')
                            </a>
                        </li>
                    @endcan
                    @can('Document System - View Draft JSA')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::jsa.draft') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::jsa.draft') ? 'active' : '' }}">
                                @lang('documentsystem::global.draft')
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            {{-- end::jsa --}}

            {{-- begin::PTW --}}
            {{-- jsa --}}
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('document-systems::ptw.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#ptw-menu" role="button" aria-expanded="false"
                    aria-controls="subSidebarMaster">
                    Permit To Work (PTW)
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('document-systems::ptw.*') ? 'show' : '' }}"
                    id="ptw-menu">
                    @can('Document System - View Active PTW')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::ptw.active') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::ptw.active') ? 'active' : '' }}">
                                @lang('documentsystem::global.active')
                                @lang('documentsystem::global.ptw')
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            {{-- end::PTW --}}

            {{-- <li class="item-sidebar">
                <a href="/kpp/rules" class="link-sidebar text-decoration-none active">Peraturan</a>
            </li> --}}
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown {{ Request::routeIs('document-systems::master.*') ? '' : 'collapsed' }}"
                    data-bs-toggle="collapse" href="#master-data" role="button" aria-expanded="false"
                    aria-controls="master-data">
                    @lang('documentsystem::global.master_data')
                </a>
                <ul class="collapse sub-menu {{ Request::routeIs('document-systems::master.*') ? 'show' : '' }}"
                    id="master-data">
                    @can('Document System - Master Data')
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::master.index') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::master.index') ? 'active' : '' }}">
                                @lang('documentsystem::global.module')
                            </a>
                        </li>
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::master.categories.index') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::master.categories.index') ? 'active' : '' }}">
                                @lang('documentsystem::global.categories')
                            </a>
                        </li>
                        <li class="item-sidebar">
                            <a href="{{ route('document-systems::master.mapping.index') }}"
                                class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('document-systems::master.mapping.index') ? 'active' : '' }}">
                                @lang('documentsystem::global.mapping')
                            </a>
                        </li>
                    @endcan
                    {{--        <li class="item-sidebar"> --}}
                    {{--            <a href="/master/document-system" --}}
                    {{--                class="link-sidebar text-decoration-none">@lang('global.document_system')</a> --}}
                    {{--        </li> --}}
                </ul>
            </li>

            {{-- <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown "
                    data-bs-toggle="collapse" href="#audit-menu" role="button" aria-expanded="false"
                    aria-controls="master-data">
                    @lang('documentsystem::global.audit')
                </a>
                <ul class="collapse sub-menu" id="audit-menu">
                    <li class="item-sidebar">
                        <a class="link-sidebar text-decoration-none dropdown "
                            data-bs-toggle="collapse" href="#audit-criteria" role="button" aria-expanded="false"
                            aria-controls="audit-criteria">
                            @lang('documentsystem::global.manage_criteria')
                        </a>
                        <ul class="collapse sub-menu" id="audit-criteria">
                            <li class="item-sidebar mt-0 pt-0">
                                <a href="/audit/manage-criteria/criteria"
                                    class="link-sidebar text-decoration-none sub-criteria">@lang('documentsystem::global.audit')
                                    @lang('documentsystem::global.criteria')</a>
                            </li>
                            <li class="item-sidebar mt-0 pt-0">
                                <a href="/audit/manage-criteria/sub-criteria"
                                    class="link-sidebar text-decoration-none sub-criteria">@lang('documentsystem::global.audit')
                                    @lang('documentsystem::global.sub_criteria')</a>
                            </li>
                        </ul>
                    </li>

                    <li class="item-sidebar">
                        <a href="/audit/list" class="link-sidebar text-decoration-none">@lang('documentsystem::global.audit_list')</a>
                    </li>
                </ul>
            </li> --}}

        </ul>
    </div>

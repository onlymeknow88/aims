<div class="content-sidebar">
    <ul>

        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>

        <li class="item-sidebar">
            <a href="{{route('audit::dashboard')}}" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed"
               data-bs-toggle="collapse" href="#smkp" role="button"
               aria-expanded="false"
               aria-controls="subSidebar">SMKP</a>
                <ul class="collapse sub-menu"
                    id="smkp">
                    <li class="item-sidebar">
                        <a href="{{route('audit::smkp.index')}}" class="link-sidebar text-decoration-none">
                            List
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{route('audit::smkp.dashboard')}}" class="link-sidebar text-decoration-none">
                            Dashboard
                        </a>
                    </li>
                    @if (auth()->user()->can('Audit - Master Mandays'))
                    <li class="item-sidebar">
                        <a href="{{route('audit::smkp.mandays.index')}}" class="link-sidebar text-decoration-none">
                            Master Mandays
                        </a>
                    </li>
                    @endif
                </ul>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none  dropdown collapsed"
                data-bs-toggle="collapse" href="#smk3" role="button"
                aria-expanded="false"
                aria-controls="subSidebar">SMK3</a>

                <ul class="collapse sub-menu"
                        id="smk3">
                        <li class="item-sidebar">
                            <a href="{{route('audit::smk3.index')}}" class="link-sidebar text-decoration-none">
                                List
                            </a>
                        </li>
                        <li class="item-sidebar">
                            <a href="{{route('audit::smk3.dashboard')}}" class="link-sidebar text-decoration-none">
                                Dashboard
                        </a>
                    </li>

                </ul>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none  dropdown collapsed"
               data-bs-toggle="collapse" href="#iso45001" role="button"
               aria-expanded="false"
               aria-controls="subSidebar">ISO 45001</a>

               <ul class="collapse sub-menu"
                    id="iso45001">
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso45001.index')}}" class="link-sidebar text-decoration-none">
                            List
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso45001.dashboard')}}" class="link-sidebar text-decoration-none">
                            Dashboard
                        </a>
                    </li>

                </ul>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none  dropdown collapsed"
               data-bs-toggle="collapse" href="#iso9001" role="button"
               aria-expanded="false"
               aria-controls="subSidebar">ISO 9001</a>

               <ul class="collapse sub-menu"
                    id="iso9001">
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso9001.index')}}" class="link-sidebar text-decoration-none">
                            List
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso9001.dashboard')}}" class="link-sidebar text-decoration-none">
                            Dashboard
                        </a>
                    </li>

                </ul>
        </li>
         <li class="item-sidebar">
         <a class="link-sidebar text-decoration-none  dropdown collapsed"
               data-bs-toggle="collapse" href="#iso14001" role="button"
               aria-expanded="false"
               aria-controls="subSidebar">ISO 14001</a>

               <ul class="collapse sub-menu"
                    id="iso14001">
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso14001.index')}}" class="link-sidebar text-decoration-none">
                            List
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="{{route('audit::iso14001.dashboard')}}" class="link-sidebar text-decoration-none">
                            Dashboard
                        </a>
                    </li>

                </ul>
        </li>

        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed"
               data-bs-toggle="collapse" href="#glossary" role="button"
               aria-expanded="false"
               aria-controls="subSidebar">GLOSSARY</a>
            <ul class="collapse sub-menu"
                id="glossary">
                <li class="item-sidebar">
                    <a href="{{route('audit::glossary-smkp')}}" class="link-sidebar text-decoration-none">
                        SMKP
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{route('audit::glossary-smk3')}}" class="link-sidebar text-decoration-none">
                        SMK3
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{route('audit::glossary-iso45001')}}" class="link-sidebar text-decoration-none">
                        ISO45001
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{route('audit::glossary-iso14001')}}" class="link-sidebar text-decoration-none">
                        ISO14001
                    </a>
                </li>
                <li class="item-sidebar">
                    <a href="{{route('audit::glossary-iso9001')}}" class="link-sidebar text-decoration-none">
                        ISO9001
                    </a>
                </li>

            </ul>
        </li>


    </ul>
</div><!-- /.content-sidebar -->

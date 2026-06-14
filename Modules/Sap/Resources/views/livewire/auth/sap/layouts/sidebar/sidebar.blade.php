<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subSidebar" role="button" aria-expanded="false"
                aria-controls="subSidebar">
                Field Leadership
            </a>
            <ul class="collapse sub-menu" id="subSidebar">
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::listing.active.index') }}"
                        class="link-sidebar text-decoration-none active">Active</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::listing.draft.index') }}"
                        class="link-sidebar text-decoration-none ">Draft</a>
                </li>
            </ul>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subSidebarMaster" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Master Library
            </a>
            <ul class="collapse sub-menu" id="subSidebarMaster">
                <li class="item-sidebar">
                    <a href="#"
                        class="link-sidebar text-decoration-none">Limit Parameter</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.type-kta-tta.index') }}"
                        class="link-sidebar text-decoration-none">Jenis KTA/TTA</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.potency-consequence.index') }}"
                        class="link-sidebar text-decoration-none">Potensi Konsekuensi</a>
                </li>
                <li class="item-sidebar">
                    <a href="{{ route('field-leadership::master-library.category.index') }}"
                        class="link-sidebar text-decoration-none">Kategori</a>
                </li>
            </ul>
        </li>
    </ul>
</div><!-- /.content-sidebar -->

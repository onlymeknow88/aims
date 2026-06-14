<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        <li class="item-sidebar">
            <a href="/active-document" class="link-sidebar text-decoration-none active">Active Document</a>
        </li>            
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Review <span class="badge rounded-pill bg-danger">10</span></a>
        </li>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Obsolate</a>
        </li>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Draft</a>
        </li>
        <li class="item-sidebar">
            <a href="" class="link-sidebar text-decoration-none">Recycle</a>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown is-notif" data-bs-toggle="collapse" href="#subSidebar" role="button" aria-expanded="false" aria-controls="subSidebar">Dropdown</a>
            <ul class="collapse sub-menu show" id="subSidebar">
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none">Dashboard</a>
                </li>
                <li class="item-sidebar">
                    <a href="/active-document" class="link-sidebar text-decoration-none">Active Document</a>
                </li>            
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Review <span class="badge rounded-pill bg-danger">10</span></a>
                </li>
            </ul>
        </li>
        @if (request()->is('inspeksi*'))
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown" data-bs-toggle="collapse" href="#subinspeksi" role="button" aria-expanded="false" aria-controls="subinspeksi">Inspeksi Alat K3</a>
            <ul class="collapse sub-menu show" id="subinspeksi">
                <li class="item-sidebar">
                    <a href="#" class="link-sidebar text-decoration-none">Inspeksi Food Hygiene</a>
                </li>            
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi Tempat Kerja - Mingguan</a>
                </li>
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ (request()->is('inspeksi/inspeksi-alat-k3*')) ? 'active' : '' }}">Inspeksi Alat K3</a>
                </li>
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi Area Maintank</a>
                </li>
                <li class="item-sidebar">
                    <a href="" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Inspeksi Area Jetty</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
</div><!-- /.content-sidebar -->
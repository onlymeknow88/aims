<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('kpp::dashboard') }}" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subSidebarMaster" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Master Library
            </a>
            <ul class="collapse sub-menu" id="subSidebarMaster">
                <li class="item-sidebar">
                    <a href="/kpp/master-library/status"
                        class="link-sidebar text-decoration-none">Status Peraturan</a>
                </li>
                <li class="item-sidebar">
                    <a href="/kpp/master-library/agency-authority"
                        class="link-sidebar text-decoration-none">Otoritas Instansi</a>
                </li>
                <li class="item-sidebar">
                    <a href="/kpp/master-library/extraction-status"
                        class="link-sidebar text-decoration-none">Status Ekstraksi</a>
                </li>
                <li class="item-sidebar">
                    <a href="/kpp/master-library/type"
                        class="link-sidebar text-decoration-none">Jenis Peraturan</a>
                </li>
            </ul>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subRule" role="button" aria-expanded="false"
                aria-controls="subSidebarMaster">
                Peraturan
            </a>
            <ul class="collapse sub-menu" id="subRule">
                <li class="item-sidebar">
                    <a href="/kpp/rules?status=active"
                        class="link-sidebar text-decoration-none">Peraturan Aktif</a>
                </li>
                <li class="item-sidebar">
                    <a href="/kpp/rules?status=in-review"
                        class="link-sidebar text-decoration-none">On Going Review</a>
                </li>
                @can('rule-maker')
                <li class="item-sidebar">
                    <a href="/kpp/rules?status=draft"
                        class="link-sidebar text-decoration-none">Draft</a>
                </li>
                @endcan
                <li class="item-sidebar">
                    <a href="/kpp/rules?status=obsolete"
                        class="link-sidebar text-decoration-none">Obsolete</a>
                </li>
            </ul>
        </li>
        <li class="item-sidebar">
            <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#subObedience" role="button" aria-expanded="false"
                aria-controls="subObedience">
                Kepatuhan Peraturan
            </a>
            <ul class="collapse sub-menu" id="subObedience">
                <li class="item-sidebar">
                    <a href="/kpp/obedience"
                        class="link-sidebar text-decoration-none">Kepatuhan</a>
                </li>
                <li class="item-sidebar">
                    <a href="#"
                        class="link-sidebar text-decoration-none">Draft</a>
                </li>
            </ul>
        </li>
    </ul>
</div><!-- /.content-sidebar -->

<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('ibpr-and-bowtie::dashboard') }}" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        @can('Ibpr And Bowtie - Master Library')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#bahaya" role="button" aria-expanded="false"
                    aria-controls="bahaya">
                    Master Library
                </a>
                <ul class="collapse sub-menu" id="bahaya">
                    <li class="item-sidebar">
                        <a href="{{ route('ibpr-and-bowtie::master.master-bahaya') }}"
                            class="link-sidebar text-decoration-none">Bahaya dan Keselamatan</a>
                    </li>
                    <li class="item-sidebar">
                        <a  href="{{ route('ibpr-and-bowtie::master.master-hirarki') }}"
                            class="link-sidebar text-decoration-none">Hirarki Kendali</a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('Ibpr And Bowtie - View BOWTIE')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#subBowtie" role="button" aria-expanded="false"
                    aria-controls="subBowtie">
                    Bowtie
                </a>
                <ul class="collapse sub-menu" id="subBowtie">
                    <li class="item-sidebar">
                        <a href="/ibpr-and-bowtie/bowtie/list?status=DONE"
                            class="link-sidebar text-decoration-none">Active Bowtie
                            <span id="notif_bowtie_done" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                        </a>
                    </li>
                    @can('Ibpr And Bowtie - Approve BOWTIE')
                        <li class="item-sidebar">
                            <a href="/ibpr-and-bowtie/bowtie/list?status=ACTIVE"
                                class="link-sidebar text-decoration-none">On Prgoress Bowtie
                                <span id="notif_bowtie" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                            </a>
                        </li>
                    @endcan
                    <li class="item-sidebar">
                        <a href="/ibpr-and-bowtie/bowtie/list?status=Draft"
                            class="link-sidebar text-decoration-none">Draft Bowtie
                            <span id="notif_bowtie_draft" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                        </a>
                    </li>
                    <li class="item-sidebar">
                        <a href="/ibpr-and-bowtie/bowtie/list?status=Temporary"
                            class="link-sidebar text-decoration-none">Temporary Bowtie
                            <span id="notif_bowtie_temporary" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('Ibpr And Bowtie - Daftar Bowtie')
            <li class="item-sidebar">
                <a href="{{ route('ibpr-and-bowtie::risk-list.risk-list-table-list') }}" class="link-sidebar text-decoration-none">Daftar Bowtie</a>
            </li>
        @endcan
        @can('Ibpr And Bowtie - View IBPR')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#subIbpr" role="button" aria-expanded="true"
                    aria-controls="subIbpr">
                    IBPR
                </a>
                <ul class="collapse sub-menu" id="subIbpr">
                    <li class="item-sidebar">
                        <a href="{{ route('ibpr-and-bowtie::ibpr.active.list-active-ibpr-and-bowtie', ['status' => 'DONE']) }}"
                            class="link-sidebar text-decoration-none">Active IBPR
                        </a>
                    </li>
                    @can('Ibpr And Bowtie - Approve IBPR')
                        <li class="item-sidebar">
                            <a href="{{ route('ibpr-and-bowtie::ibpr.active.list-active-ibpr-and-bowtie', ['status' => 'ACTIVE']) }}"
                                class="link-sidebar text-decoration-none">On Progress IBPR
                                <span id="notif_ibpr" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                            </a>
                        </li>
                    @endcan
                    <li class="item-sidebar">
                        <a href="{{ route('ibpr-and-bowtie::ibpr.draft.list-draft-ibpr-and-bowtie', ['status' => 'DRAFT']) }}"
                            class="link-sidebar text-decoration-none">Draft IBPR
                            <span id="notif_ibpr_draft" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('Ibpr And Bowtie - View IADL')
            <li class="item-sidebar">
                <a class="link-sidebar text-decoration-none dropdown collapsed d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#subIadl" role="button" aria-expanded="false"
                    aria-controls="subIadl">
                    IADL
                </a>
                <ul class="collapse sub-menu" id="subIadl">
                    <li class="item-sidebar">
                        <a href="/ibpr-and-bowtie/iadl/active/list?status=DONE"
                            class="link-sidebar text-decoration-none">Active IADL
                        </a>
                    </li>
                    @can('Ibpr And Bowtie - Approve IADL')
                        <li class="item-sidebar">
                            <a href="/ibpr-and-bowtie/iadl/active/list?status=ACTIVE"
                                class="link-sidebar text-decoration-none">On Progress IADL
                                <span id="notif_iadl" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                            </a>
                        </li>
                    @endcan
                    <li class="item-sidebar">
                        <a href="/ibpr-and-bowtie/iadl/draft/list?status=Draft"
                            class="link-sidebar text-decoration-none">Draft IADL
                            <span id="notif_iadl_draft" class="badge rounded-pill bg-danger text-right" style="position:absolute; right: 10px; margin-top: 10px;"></span>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan
        @can('Ibpr And Bowtie - Daftar Risiko')
            <li class="item-sidebar">
                <a href="{{ route('ibpr-and-bowtie::pica.pica-table-list') }}" class="link-sidebar text-decoration-none">Daftar Pengendalian Resiko Tinggi</a>
            </li>
        @endcan
    </ul>
</div><!-- /.content-sidebar -->

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>

    $.ajax({
        url: "/ibpr-and-bowtie/get-notif", // URL of the defined route in web.php
        type: 'GET', // HTTP method (GET, POST, PUT, DELETE, etc.)
        dataType: 'json', // The expected data type of the response
        success: function(data) {
            // Callback function to handle the successful response
            $('#notif_ibpr').text(data.notif_ibpr);
            $('#notif_ibpr_draft').text(data.notif_ibpr_draft);
            $('#notif_iadl').text(data.notif_iadl);
            $('#notif_iadl_draft').text(data.notif_iadl_draft);
            $('#notif_bowtie').text(data.notif_bowtie);
            $('#notif_bowtie_draft').text(data.notif_bowtie_draft);
            $('#notif_bowtie_temporary').text(data.notif_bowtie_temporary);

            if(data.notif_ibpr == 0) $('#notif_ibpr').addClass('d-none');
            if(data.notif_ibpr_draft == 0) $('#notif_ibpr_draft').addClass('d-none');
            if(data.notif_iadl == 0) $('#notif_iadl').addClass('d-none');
            if(data.notif_iadl_draft == 0) $('#notif_iadl_draft').addClass('d-none');
            if(data.notif_bowtie == 0) $('#notif_bowtie').addClass('d-none');
            if(data.notif_bowtie_draft == 0) $('#notif_bowtie_draft').addClass('d-none');
            if(data.notif_bowtie_temporary == 0) $('#notif_bowtie_temporary').addClass('d-none');
        },
        error: function(xhr, status, error) {
            // Callback function to handle errors in the AJAX request
            console.error('Error: ' + error);
        }
    });

</script>
@endpush

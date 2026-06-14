<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('document-systems::dashboard') }}" class="link-sidebar text-decoration-none">Dashboard</a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('document-systems::active-document') }}" class="link-sidebar text-decoration-none">Active Document</a>
        </li>
        <li class="item-sidebar">
            <a href="/document-systems/review" class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">Review
                @if($notif > 0)
                <span class="badge rounded-pill bg-danger">
                    {{ $notif }}
                </span>
                @endif
            </a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('document-systems::obsolate') }}" class="link-sidebar text-decoration-none">Obsolate</a>
        </li>
        <li class="item-sidebar">
            <a href="{{ route('document-systems::draft') }}" class="link-sidebar text-decoration-none">Draft</a>
        </li>
        <li class="item-sidebar">
            <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Active Document</a>
        </li>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
            </div>
        </div>
    </ul>
</div><!-- /.content-sidebar -->

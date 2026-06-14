<div class="inner-content">

    <div class="header-detail-approval h-60px border d-flex align-items-center px-3">
        <a href="{{ route('document-systems::active-document') }}" class="d-flex align-items-center gap-3 ">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Dokumen Kebijakan</span>
        </a>
        @if ($document->editable)
            <a href="{{ route('document-systems::active-document.edit', ['id' => $document->id]) }}"
                class="btn btn-edit text-white bg-146943 ms-3">
                <i class="fas fa-pencil"></i> Edit Document
            </a>
        @endif
    </div>

    <div class="detail-approval-content d-flex">
        @include('documentsystem::livewire.review._left-detail')
        @include('documentsystem::livewire.active-document._center-detail')
        @include('documentsystem::livewire.review._right-detail')

    </div>
</div>

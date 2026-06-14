<div class="inner-content">

    <div class="header-add-maker h-60px border d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('document-systems::active-document.detail', ['id' => $document->id]) }}"
                class="d-flex align-items-center gap-3 ">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Document System</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div><!-- /.right-header -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">
                {{-- wire:submit.prevent="saveToDocument" --}}
                <form class="form-horizontal" enctype="multipart/form-data">
                    @include('documentsystem::livewire.active-document._form-document')

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="{{ route('document-systems::active-document.detail', ['id' => $document->id]) }}"
                                class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="saveToDraft" class="dropdown-item">
                                            Save as draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="saveToReview" class="dropdown-item">
                                            Submit for review
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <!---/.addnew-maker-content -->

</div>

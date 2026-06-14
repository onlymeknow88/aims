<div class="inner-content">

    <div class="header-add-maker h-60px bg-green d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="#" onclick="history.back();"
                class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Rules</span>
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
                <form class="form-horizontal" enctype="multipart/form-data">
                    @include('livewire.kpp.rule.partials._edit-form-rule')

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="#" onclick="history.back();"
                                class="btn btn-outline-secondary">Cancel</a>
                            <div class="button-document">
                                <button
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button type="button" wire:click="save('Draft')" class="dropdown-item"
                                            href="#">
                                            Submit as Draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:click="save('In Review')" class="dropdown-item"
                                            href="#">
                                            Submit for Review
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
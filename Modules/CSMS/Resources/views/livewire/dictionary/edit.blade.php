<div class="inner-content">

    <div
        class="header-content-inspeksi-food-hygiene h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="javascript:history.go(-1)" class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Create Dictionary</span>
            </a>
        </div><!-- /.left-header -->
    </div><!-- /.header-content-inspeksi-food-hygiene -->

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                <form class="form-horizontal" method="post" enctype="multipart/form-data">

                    <div class="own-info mb-5">

                        <div class="mb-5">
                            <h5 class="fw-normal">Dictionary</h5>
                        </div>

                        <div class="row mb-3 form-group required">
                            <label for="term" class="col col-form-label">
                                Term
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="term" id="term" placeholder="Istilah"
                                    :error="'term'" />
                            </div>
                        </div><!-- /.form-group criteria -->

                        <div class="row mb-3 form-group required">
                            <label for="definition" class="col col-form-label">
                                Definition
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="definition" id="definition" placeholder="Definisi"
                                    :error="'definition'" />
                            </div>
                        </div><!-- /.form-group criteria -->

                        <div class="row mb-3 form-group required">
                            <label for="reference" class="col col-form-label">
                                Reference
                            </label>
                            <div class="col-8">
                                <x-inputs.text wire:model.defer="reference" id="reference" placeholder="Referensi"
                                    :error="'reference'" />
                            </div>
                        </div><!-- /.form-group criteria -->

                    </div><!-- ./content-label -->

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <a href="javascript:history.go(-1)" class="btn btn-outline-secondary" wire:loading.remove
                                wire:target='saved'>
                                Cancel
                            </a>
                            <x-button-spinner target="saved" :text="trans('global.processing')"></x-button-spinner>
                            <div class="button-document" wire:loading.remove wire:target='saved'>
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false"wire:click="store">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div><!-- /.content-inspeksi-food-hygiene -->

</div><!-- /.inner-content -->

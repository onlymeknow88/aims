<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Type</h4>
        </div><!-- /.section-title -->

        <div class="table-maker">

            <livewire:kpp.master-library.type.partials.table-maker />

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->

    <!-- Modal -->
    <div class="modal fade" id="FLTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="FLTypeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FLTypeModalLabel">Type</h5>
                    <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="Name" class="col-sm-3 col-form-label">Name</label>

                        <div class="col-sm-9">
                            <input type="text" wire:model="name"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal()">Close</button>
                    <button type="button" wire:click="saved()"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('edit', event => {
        $('#FLTypeModal').modal('show');
        if (event.detail.id) {
            @this.set('name', event.detail.name);
            @this.set('idType', event.detail.id);
        }
    });

    window.addEventListener('closeModal', event => {
        $('#FLTypeModal').modal('hide');
        @this.set('name', null);
        @this.set('idType', null);
    });
</script>

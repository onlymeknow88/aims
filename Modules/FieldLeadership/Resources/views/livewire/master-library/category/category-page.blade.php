<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Kategori</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

            <livewire:fieldleadership::master-library.category.partials.table-maker />

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->

    <!-- Modal -->
    <div class="modal fade" id="FLCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="FLCategoryModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FLCategoryModalLabel">Kategori</h5>
                    <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="title" class="col-sm-3 col-form-label">Title</label>

                        <div class="col-sm-9 {{ $edit == true ? 'd-block' : 'd-none' }}">
                            <input type="text" wire:model="title"
                                class="form-control @error('title') is-invalid @enderror" id="title"
                                placeholder="Title" />
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-9 {{ $edit == false ? 'd-block' : 'd-none' }}">
                            <label class="col-form-label">{{ $title }}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer {{ $edit == true ? '' : 'd-none' }}">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal()">Close</button>
                    <button type="button" wire:click="$emit('edit-item')"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Save changes
                    </button>
                </div>
                <div class="modal-footer {{ $edit == false ? '' : 'd-none' }}">
                    <button type="button" wire:click="edited()" class="btn btn-light-secondary"
                        style="background-color: #e9ecef">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('edit', event => {
        $('#FLCategoryModal').modal('show');
        if (event.detail.id) {
            @this.set('title', event.detail.name);
            @this.set('idCategory', event.detail.id);
        }
    });

    window.addEventListener('closeModal', event => {
        $('#FLCategoryModal').modal('hide');
        @this.set('title', null);
        @this.set('idCategory', null);
        @this.set('edit', false);
    });

    document.addEventListener('DOMContentLoaded', function() {

        @this.on('edit-item', () => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Yakin akan mengubah data ini?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Ubah'
            }).then((result) => {

                if (result.value) {

                    @this.call('saved')

                }

            });
        });
    });
</script>

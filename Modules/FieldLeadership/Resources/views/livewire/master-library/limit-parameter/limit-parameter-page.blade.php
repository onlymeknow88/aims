<div class="inner-content">

    <div class="section-content">

        <div class="section-title py-3 px-2">
            <h4>Limit Parameter</h4>
        </div><!-- /.section-title -->

        <div class="table-demo position-relative">

            <livewire:fieldleadership::master-library.limit-parameter.partials.table-maker />

        </div><!-- /.table-maker -->

    </div><!-- /.section-content -->

    <div class="section-footer d-flex justify-content-between">
        {{-- <div class="update-on opacity-80">Update on Sep 24, 2022 . 15.00 pm</div>
        <div class="row-data opacity-80">1,000 Document Active</div> --}}
    </div><!-- /.section-footer -->

    <!-- Modal -->
    <div class="modal fade" id="FLParameterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="FLParameterModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="FLParameterModalLabel">Limit Parameter</h5>
                    <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="max_member" class="col-sm-5 col-form-label">Max Item Member</label>

                        <div class="col-sm-7 {{ $edit == true ? 'd-block' : 'd-none' }}">
                            <input type="text" wire:model="max_member"
                                class="form-control @error('max_member') is-invalid @enderror" id="max_member"
                                placeholder="Max Item Member" />
                            @error('max_member')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-7 {{ $edit == false ? 'd-block' : 'd-none' }}">
                            <label class="col-form-label">{{ $max_member }}</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="max_positive" class="col-sm-5 col-form-label">Max Positive Condition</label>

                        <div class="col-sm-7 {{ $edit == true ? 'd-block' : 'd-none' }}">
                            <input type="text" wire:model="max_positive"
                                class="form-control @error('max_positive') is-invalid @enderror" id="max_positive"
                                placeholder="Max Positive Condition" />
                            @error('max_positive')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-7 {{ $edit == false ? 'd-block' : 'd-none' }}">
                            <label class="col-form-label">{{ $max_positive }}</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="max_risk" class="col-sm-5 col-form-label">Max Risk Condition</label>

                        <div class="col-sm-7 {{ $edit == true ? 'd-block' : 'd-none' }}">
                            <input type="text" wire:model="max_risk"
                                class="form-control @error('max_risk') is-invalid @enderror" id="max_risk"
                                placeholder="Max Risk Condition" />
                            @error('max_risk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-7 {{ $edit == false ? 'd-block' : 'd-none' }}">
                            <label class="col-form-label">{{ $max_risk }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="max_corrective" class="col-sm-5 col-form-label">Max Corrective Action</label>

                        <div class="col-sm-7 {{ $edit == true ? 'd-block' : 'd-none' }}">
                            <input type="text" wire:model="max_corrective"
                                class="form-control @error('max_corrective') is-invalid @enderror" id="max_corrective"
                                placeholder="Max Corrective Action" />
                            @error('max_corrective')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-7 {{ $edit == false ? 'd-block' : 'd-none' }}">
                            <label class="col-form-label">{{ $max_corrective }}</label>
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
        console.log('====================================');
        console.log(event.detail);
        console.log('====================================');
        $('#FLParameterModal').modal('show');
        if (event.detail.id) {
            @this.set('max_member', event.detail.max_item_member);
            @this.set('max_positive', event.detail.max_item_positive_condition);
            @this.set('max_risk', event.detail.max_item_risk_condition);
            @this.set('max_corrective', event.detail.max_item_corrective_action);
            @this.set('idParameter', event.detail.id);
        }
    });

    window.addEventListener('closeModal', event => {
        $('#FLParameterModal').modal('hide');
        @this.set('max_member', null);
        @this.set('max_positive', null);
        @this.set('max_risk', null);
        @this.set('max_corrective', null);
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

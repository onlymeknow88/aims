<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <a href="#" onclick="history.back();" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>KO</span>
        </a>
    </div>

    <div class="detail-approval-content d-flex">

        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Category</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$category->name}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div>

        <!-- center -->
        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">
                    Brands
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="button-toolbar align-item-center text-white position-relative m-2 add-new">
                        <i class="fa fa-plus"></i> Add Brand
                    </a>
                    <!-- <a href="{{ route('kpp::rules.create') }}" type="button" class="button-toolbar d-flex gap-2 align-items-center py-2 px-3 add-new">
                        <span class="icon d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                              </svg>                      
                        </span>
                        <span class="text-button">Add New</span>
                    </a> -->
                </h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        
                        <div class="table-responsive position-relative">
                            <div class="table-wrapper overflow-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Brand</th>                              
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $itemIndex => $item)
                                            <tr>
                                                <td class="action-icon" style="color: green; font-weight: bold">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" wire:click="deleteId('{{ $item->id }}')" class="action-icon">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div><!-- /.table-content-->
                        
                    </div><!-- /.module-info-items -->

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

        </div><!-- /.section-content -->

    </div>

    <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="CommentModal" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CommentModal">Tambah Brand</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row form-group">
                        <label for="bidang" class="col-sm-4 col-form-label">Brand</label>
                        <div class="col-sm-8">
                            <x-inputs.text type="text" wire:model="name" id="name" placeholder="Nama Brand" :error="'name'"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal()">Close</button>
                    <button type="button" wire:click="store()"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="CommentModal" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CommentModal">Delete Brand</h5>
                    <button type="button" class="btn-close" wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin untuk menhapus data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal()">Close</button>
                    <button type="button" wire:click="delete()"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#deleteModal').modal('hide');
            $('#addModal').modal('hide');
        });

        window.addEventListener('openModal', event => {
            $('#deleteModal').modal('show');
        });
    </script>
@endpush

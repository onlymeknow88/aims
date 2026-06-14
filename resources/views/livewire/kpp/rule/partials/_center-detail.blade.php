<div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

    <div class="section-info py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Information</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-info-items row">
                <div class="col-4 opacity-50">No Peraturan</div>
                <div class="col-8">{{$rule->number}}</div>
            </div><!-- /.module-info-items -->

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Title</div>
                <div class="col-8">{{$rule->title}}</div>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-info -->

    <div class="section-status py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Otorisasi Instansi</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Jenis</div>
                <div class="col-8">{{$rule->ruleType->name ?? '-'}}</div>
            </div>

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Status</div>
                <div class="col-8">{{$rule->ruleStatus->name ?? '-'}}</div>
            </div>

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Otoritas Instansi</div>
                <div class="col-8">{{$rule->agencyAuthority->name ?? '-'}}</div>
            </div>

        </div>

    </div><!-- /.section-status -->

    <div class="section-description py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Description Document</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-description-items d-flex flex-wrap gap-2">
                <?php echo $rule->description ?>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div>

    <div class="addnew-maker-content container py-5 px-3">

        <div class="row justify-content-center">

            <div class="col-8">

                    <div class="footer-action mb-2">

                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <!-- <a href="{{ route('kpp::rules.edit', ['id' => $rule->id]) }}" class="btn btn-outline-secondary">Ganti Peraturan</a> -->
                            @can('rule-checker')
                                @if($rule->status == 'In Review')
                                <div class="button-document">
                                    <button
                                        class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        More Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" wire:click="approve()" class="dropdown-item"
                                                href="#">
                                                Approve
                                            </button>
                                        </li>
                                        <li>
                                            <button data-bs-toggle="modal" data-bs-target="#CommentModal" type="button" class="dropdown-item"
                                                href="#">
                                                Return with Comment
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            @endcan

                            @can('rule-maker')
                                @if($rule->status == 'Draft' || $rule->status == 'Returned')
                                <a href="{{ route('kpp::rules.edit', ['id' => $rule->id]) }}" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Edit</a>
                                @endif
                            @endcan

                        </div>

                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            
                            <!-- <div class="button-document">
                                <button
                                    class="btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ganti Peraturan
                                </button>
                            </div> -->
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="CommentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="CommentModal" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CommentModal">Return with Comment</h5>
                    <button type="button" class="btn-close "wire:click="closeModal()" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="comment" class="col-sm-3 col-form-label">Comment</label>

                        <div class="col-sm-9">
                            <x-inputs.textarea wire:model="comment" class="form-control" id="comment" placeholder="" :error="'comment'"></x-inputs.textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal()">Close</button>
                    <button type="button" wire:click="returnWithComment()"
                        class="btn btn-outline-success bg-green text-white bg-hover-light-success">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.section-content -->

<script>
    window.addEventListener('edit', event => {
        $('#CommentModal').modal('show');
    });

    window.addEventListener('closeModal', event => {
        $('#CommentModal').modal('hide');
        @this.set('comment', null);
    });
</script>
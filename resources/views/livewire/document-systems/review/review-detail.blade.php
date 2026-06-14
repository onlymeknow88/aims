<div class="inner-content">

    <div class="header-detail-approval h-60px bg-green d-flex align-items-center px-3">
        <a href="{{ route('document-systems::review') }}" class="d-flex align-items-center gap-3 text-white">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Dokumen Kebijakan</span>
        </a>
    </div>

    <div class="detail-approval-content d-flex">

        @include('livewire.document-systems.review._left-detail')
        @include('livewire.document-systems.review._center-detail')
        @include('livewire.document-systems.review._right-detail')

    </div>

    <!-- Modal review -->
    <div class="modal fade" wire:ignore.self id="modalReview" tabindex="-1" aria-labelledby="modalReview" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Review Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model.defer="description"></textarea>
                        </div>
                        <div class="mb-3 upload-images">
                            
                            <div class="upload-images-content d-flex gap-2 flex-wrap">
                                <div class="upload-action">
                                    <input type="file" wire:model.defer="attachs" id="attachs" multiple/>
                                    <button class="btn"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                @if ($attachs)
                                    @foreach ($attachs as $file)
                                    <div class="thumb">
                                        <img src="{{ asset('./images/doc-image.png') }}" alt="Document Image">
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" wire:click="saveToReturn" class="btn btn-success">Submit this comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Approval --}}
    <div class="modal fade" wire:ignore.self id="modalApproved" tabindex="-1" aria-labelledby="modalApproved" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Review Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" wire:model.defer="description"></textarea>
                        </div>
                        <div class="mb-3 upload-images">
                            
                            <div class="upload-images-content d-flex gap-2 flex-wrap">
                                <div class="upload-action">
                                    <input type="file" wire:model.defer="attachs" id="attachs" multiple/>
                                    <button class="btn"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                @if ($attachs)
                                    @foreach ($attachs as $file)
                                    <div class="thumb">
                                        <img src="{{ asset('./images/doc-image.png') }}" alt="Document Image">
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" wire:click="saveToApproved" class="btn btn-success">Submit this comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal actifity -->
    <div class="modal fade" id="modalActivity" tabindex="-1" aria-labelledby="modalActivity" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="activity d-flex flex-column gap-2">                        

                            <div class="item-content d-flex gap-1 align-items-center">
    
                                <div class="activity-item d-flex flex-column gap-2">
    
                                    <div class="activity-header d-flex justify-content-start align-items-center gap-2">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                        </div>
                                        <div class="title d-flex flex-column">
                                            <span>Iqbal Ramadhan</span>
                                            <span class="opacity-50">Departement Name</span>
                                        </div>
                                    </div><!-- /.activity-item -->
    
                                    <div class="activity-content">
    
                                        <div class="activity-inner d-flex flex-column gap-2">
                                            
                                            <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor...</div>
                                            <div class="images">
                                                <h6 class="fw-normal">Files</h6>
                                                <div class="files-content d-flex gap-2 flex-wrap">
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                                                        </div>
                                                        <div class="img-name">Evidence Data</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                                                        </div>
                                                        <div class="img-name">File Name.pdf</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                </div><!-- /.files-content -->
                                            </div><!-- /.images -->

                                            <div class="images">
                                                <h6 class="fw-normal">Images</h6>
                                                <div class="images-content d-flex gap-2 flex-wrap">
                                                    <div 
                                                        class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1"  
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Contoh toolpips dengan nama panjang">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                                        </div>
                                                        <div class="img-name">Nama Panjang ...</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
      
                                                    </div><!-- image -->
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                    <div class="image d-flex flex-column align-items-start justify-content-center bg-white rounded p-3 border border-1">
                                                        <div class="thumb mb-2">
                                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                                        </div>
                                                        <div class="img-name">Image.jpg</div>
                                                        <div class="img-size opacity-50">3.2 Mb</div>
                                                    </div><!-- image -->
                                                </div><!-- /.images-content -->
                                            </div><!-- /.images -->
                                            
                                        </div><!-- /.actifity-inner -->
    
                                    </div><!-- /.actifity-content -->
    
                                    <div class="activity-footer opacity-50">2 days ago</div>
    
                                </div><!-- /.activity-item -->
                                
                            </div>
    
                        </div><!-- /.author -->
     
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal activity -->

</div>


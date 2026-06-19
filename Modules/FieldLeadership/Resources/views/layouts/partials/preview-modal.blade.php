<!-- Modal Preview Attachment -->
<div class="modal fade" id="previewAttachmentModal" tabindex="-1" aria-labelledby="previewAttachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header bg-light py-3 px-4 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #eaeaea;">
                <h5 class="modal-title fw-semibold text-dark d-flex align-items-center gap-2" id="previewAttachmentModalLabel">
                    <i class="fa-solid fa-file-lines text-success"></i>
                    <span id="preview-file-name">File Preview</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-size: 0.8rem;"></button>
            </div>
            <div class="modal-body p-0 bg-secondary-subtle d-flex justify-content-center align-items-center" style="min-height: 550px; background-color: #f8f9fa;">

                <!-- PDF Preview Container -->
                <div id="preview-pdf-container" class="w-100 h-100 d-none">
                    <iframe id="preview-pdf-iframe" src="" style="width: 100%; height: 650px; border: none;"></iframe>
                </div>

                <!-- Image Preview Container -->
                <div id="preview-image-container" class="w-100 text-center p-4 d-none">
                    <img id="preview-image-element" src="" class="img-fluid rounded shadow-sm" style="max-height: 600px; object-fit: contain;" alt="Preview">
                </div>

                <!-- Document Office Preview Container -->
                <div id="preview-office-container" class="w-100 h-100 d-none">
                    <iframe id="preview-office-iframe" src="" style="width: 100%; height: 650px; border: none;"></iframe>
                </div>

                <!-- Fallback Container if preview cannot be rendered -->
                <div id="preview-fallback-container" class="w-100 text-center p-5 d-none">
                    <div class="py-5">
                        <i class="fa-solid fa-circle-exclamation text-warning mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-dark fw-normal">Preview Tidak Tersedia</h4>
                        <p class="text-muted">Berkas ini tidak mendukung live preview secara langsung. Silakan unduh berkas untuk membacanya.</p>
                        <a id="preview-download-btn" href="" target="_blank" class="btn btn-success px-4 py-2 mt-3" style="border-radius: 30px; font-weight: 500;">
                            <i class="fa-solid fa-download me-2"></i> Download File
                        </a>
                    </div>
                </div>

                <!-- Loading Spinner -->
                <div id="preview-loading-spinner" class="position-absolute d-flex flex-column align-items-center justify-content-center bg-white w-100 h-100" style="z-index: 10; top: 0; left: 0;">
                    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="mt-3 text-secondary fw-semibold">Memuat Berkas...</span>
                </div>

            </div>
        </div>
    </div>
</div>

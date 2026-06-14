<div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

    <div class="section-info py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Information</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-info-items row">
                <div class="col-4 opacity-50">No Peraturan</div>
                <div class="col-8">{{$rule->number}}</div>
            </div><!-- /.module-info-items -->

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Judul Peraturan</div>
                <div class="col-8">{{$rule->title}}</div>
            </div><!-- /.module-info-items -->

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Jenis</div>
                <div class="col-8">{{$rule->ruleType->name ?? '-'}}</div>
            </div>

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Otoritas Instansi</div>
                <div class="col-8">{{$rule->agencyAuthority->name ?? '-'}}</div>
            </div>

        </div><!-- /.content-section -->

    </div><!-- /.section-info -->

    <div class="section-description py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Description Document</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-description-items d-flex flex-wrap gap-2">
                <?php echo $rule->description ?>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div>

    <div class="section-attachment py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Attachment</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-attachment-items gap-2">

                <div class="files-content d-flex flex-column gap-2">
                    
                    @foreach ($rule->files as $item)
                    <a target="blank" href="{{asset('storage/'.$item->file)}}">
                        <div class="image d-flex w-100 align-items-center bg-white rounded p-3 border border-1">
                            <div class="thumb mb-2">
                                <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                            </div>
                            <div class="img-name">{{ $item->name }}</div>
                            <div class="img-size opacity-50 ms-auto">{{ $item->size }}</div>
                        </div><!-- image -->
                    </a>
                    @endforeach

                </div><!-- /.files-content -->

            </div><!-- /.module-attachment-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-Attachment -->

</div><!-- /.section-content -->
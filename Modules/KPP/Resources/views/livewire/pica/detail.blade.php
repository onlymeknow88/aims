<div class="inner-content">

    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">

        <a href="{{route('kpp::pica.index')}}" class="d-flex align-items-center gap-3">
            <span><i class="fa-solid fa-arrow-left"></i></span>
            <span>Back</span>
        </a>

        @if($extraction->status == 'Checking' || $extraction->status == 'Tidak Patuh' || $extraction->status == 'Draft')
            <a href="{{route('kpp::pica.edit', ['id' => $extraction->id])}}" class="btn btn-edit text-white bg-146943"> <i class="fas fa-pencil"></i> Edit</a>
        @endif
        
    </div>

    <div class="detail-approval-content d-flex">
        <div class="detail-left border-end border-1">

            <div class="info bg-white">

                <div class="info-item p-3 border-bottom border-1">

                    <div class="author d-flex flex-column gap-2">
                        <div class="item-content d-flex gap-2 align-items-center">
                            <!-- <div class="thumb">
                                <img src="{{ asset('./images/author.png') }}" alt="Author">
                            </div> -->
                            <div class="author-name">{{$extraction->obedience->company->company_name ?? '-'}}</div>
                        </div>
                    </div><!-- /.author -->

                </div><!-- /.info-items -->

                <div class="info-item p-3 border-bottom border-1">

                    <div class="created d-flex flex-column gap-2">

                        <h6 class="fw-normal">Status</h6>

                        <div class="item-content d-flex gap-1 align-items-center">
                            <span class="opacity-50"></span>
                            <span>
                                {{$extraction->status}}
                            </span>
                        </div>

                    </div><!-- /.author -->

                </div><!-- /.info-items -->

            </div><!-- /.info -->

        </div>

        <div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Informasi Peraturan</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">No Peraturan</div>
                        <div class="col-8">{{$extraction->obedience->rule->number}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Judul Peraturan</div>
                        <div class="col-8">{{$extraction->obedience->rule->title}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Jenis</div>
                        <div class="col-8">{{$extraction->obedience->rule->ruleType->name ?? '-'}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Otoritas Instansi</div>
                        <div class="col-8">{{$extraction->obedience->rule->agencyAuthority->name ?? '-'}}</div>
                    </div>

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-info py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Ekstraksi</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Bidang</div>
                        <div class="col-8">{{$extraction->bidang}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-info-items row">
                        <div class="col-4 opacity-50">Sub Bidang</div>
                        <div class="col-8">{{$extraction->sub_bidang}}</div>
                    </div><!-- /.module-info-items -->

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Penanggung Jawab</div>
                        <div class="col-8">{{$extraction->responsibleUser->name ?? '-'}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Section</div>
                        <div class="col-8">{{$extraction->section->name ?? '-'}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Compliance Level</div>
                        <div class="col-8">{{$extraction->compliance_level}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Pasal</div>
                        <div class="col-8">{{$extraction->article->name}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Ayat</div>
                        <div class="col-8">{{$extraction->sub_section}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Lampiran</div>
                        <div class="col-8">{{$extraction->lampiran}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Konten</div>
                        <div class="col-8">{{$extraction->content}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Isi Ketidakpatuhan</div>
                        <div class="col-8">{{$extraction->disobedience}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Konsekuensi</div>
                        <div class="col-8">{{$extraction->consequence}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Tanggal</div>
                        <div class="col-8">{{$extraction->date}}</div>
                    </div>

                    <div class="module-status-items row">
                        <div class="col-4 opacity-50">Comment</div>
                        <div class="col-8">{{$extraction->comment ?? '-'}}</div>
                    </div>

                </div><!-- /.content-section -->

            </div><!-- /.section-info -->

            <div class="section-attachment py-3 px-2 d-flex flex-column gap-2">

                <h5 class="fw-normal">Attachment</h5>

                <div class="content-section d-flex flex-column gap-1">

                    <div class="module-attachment-items gap-2">

                        <div class="files-content d-flex flex-column gap-2">
                            
                            @foreach ($extraction->files as $item)
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

            <div class="addnew-maker-content container py-5 px-3">

                <div class="row justify-content-center">

                    <div class="col-8">

                            <div class="footer-action mb-2">

                                <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                                    @if($extraction->status == 'Tidak Patuh')
                                        <a href="#" wire:click="$emit('submit-reviewer')" class="btn btn-outline-default bg-green align-item-center text-white position-relative px-4">Submit for Review</a>
                                    @endif
                                </div>

                            </div>
                        </form>

                    </div>

                </div>

            </div>

        </div><!-- /.section-content -->

        <div class="detail-right border-start border-1">

            <div class="info bg-white px-3">

                <h6 class="fw-normal">Activity</h6>

                @foreach ((new \App\Helpers\KppHelper)->getActivities() as $item)
                    <div class="info-item mb-3">

                        <div class="activity d-flex flex-column gap-2">

                            <div class="item-content d-flex gap-1 align-items-center">

                                <div class="activity-item d-flex flex-column gap-2">

                                    <div
                                        class="activity-header d-flex justify-content-between align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="thumb">
                                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                                            </div>
                                            <div class="title d-flex flex-column">
                                                <span>{{ $item->responsibleUser->name ?? '' }}</span>
                                                <span
                                                    class="opacity-50">{{ $item->responsibleUser->department->name ?? '' }}</span>
                                            </div>
                                        </div>
                                    </div><!-- /.activity-item -->


                                    <div class="activity-content" x-data="{
                                        contentOpen: true,
                                        height: $refs.containerInner.getBoundingClientRect().height,
                                        buttonShow: false,
                                        init() {
                                            if (this.height > 60) {
                                                this.contentOpen = false;
                                                this.buttonShow = true;
                                            }
                                        }
                                    }">

                                        <div x-ref="containerInner" class="activity-inner d-flex flex-column gap-2"
                                            :class="contentOpen ? 'height-auto' : 'collapse'" x-transition.delay.5s>
                                            <div class="desc">
                                                {{ $item->obedience->rule->number }}<br>
                                                {{ $item->status }}
                                            </div>
                                        </div><!-- /.actifity-inner -->

                                    </div><!-- /.actifity-content -->

                                    <div class="activity-footer opacity-50">{{ $item->created_at->diffForHumans() }}
                                    </div>

                                </div><!-- /.activity-item -->

                            </div>

                        </div><!-- /.author -->

                    </div><!-- /.info-items -->
                @endforeach
            </div><!-- /.detail-left -->

        </div><!-- /.detail-maker -->
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('edit', event => {
            $('#CommentModal').modal('show');
        });

        window.addEventListener('closeModal', event => {
            $('#CommentModal').modal('hide');
            $('#TidakPatuhModal').modal('hide');
            @this.set('comment', null);
        });
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('submit-reviewer', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin untuk submit ke reviewer?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Submit'
                }).then((result) => {

                    if (result.value) {

                        @this.call('submitReviewer')

                    }

                });
            });

        });
    </script>
@endpush
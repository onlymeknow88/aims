<div class="section-content w-100 py-3 px-5 d-flex flex-column gap-3">

    <div class="section-info py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Information</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-info-items row">
                <div class="col-4 opacity-50">No Peraturan</div>
                <div class="col-8">{{$obedience->rule->number}}</div>
            </div><!-- /.module-info-items -->

            <div class="module-info-items row">
                <div class="col-4 opacity-50">Judul Peraturan</div>
                <div class="col-8">{{$obedience->rule->title}}</div>
            </div><!-- /.module-info-items -->

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Jenis</div>
                <div class="col-8">{{$obedience->rule->ruleType->name ?? '-'}}</div>
            </div>

            <div class="module-status-items row">
                <div class="col-4 opacity-50">Otoritas Instansi</div>
                <div class="col-8">{{$obedience->rule->agencyAuthority->name ?? '-'}}</div>
            </div>

        </div><!-- /.content-section -->

    </div><!-- /.section-info -->

    <div class="section-description py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Description Document</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-description-items d-flex flex-wrap gap-2">
                <?php echo $obedience->rule->description ?>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div>

    <div class="section-attachment py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Attachment</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-attachment-items gap-2">

                <div class="files-content d-flex flex-column gap-2">
                    
                    @foreach ($obedience->rule->files as $item)
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

    {{--<div class="section-status py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Status Dokumen</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="module-description-items d-flex flex-wrap gap-2">
                <button type="button" style="pointer-events: none;"
                    class="btn {{ $obedience->status == 'Draft' ? 'btn-secondary' : 'btn-success' }}">
                    {{ $obedience->status }}
                </button>
            </div><!-- /.module-info-items -->

        </div><!-- /.content-section -->

    </div>--}}

    <div class="section-extraction py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Ekstraksi</h5>

        <div class="content-section d-flex flex-column gap-1">

            <div class="table-responsive position-relative">
                <div class="table-wrapper overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pasal</th>
                                <th>Ayat</th>
                                <th>Compliance Level</th>
                                <!-- <th>Date Created</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obedience->extractions as $itemIndex => $items)
                                <tr>
                                    <td>
                                        <a href="#" class="action-icon" style="color: green; font-weight: bold">
                                            {{ $items->article->name }}
                                        </a>
                                    </td>
                                    <td>{{ $items->sub_section }}</td>
                                    <td>{{ $items->compliance_level }}</td>
                                    <!-- <td>{{ Carbon\Carbon::parse($items->created_at)->format('F d, Y') }}</td> -->
                                    <td>
                                        @if($items->status == 'Draft')
                                            <span class="pending">{{ $items->status }}</span>
                                        @elseif($items->status == 'Checking')
                                            <span class="pending">{{ $items->status }}</span>
                                        @elseif($items->status == 'In Review')
                                            <span class="pending">{{ $items->status }}</span>
                                        @elseif($items->status == 'Patuh')
                                            <span class="default">{{ $items->status }}</span>
                                        @elseif($items->status == 'Tidak Patuh')
                                            <span class="cancel">{{ $items->status }}</span>
                                        @elseif($items->status == 'Tidak Berlaku')
                                            <span class="cancel">{{ $items->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div><!-- /.table-content-->

        </div><!-- /.content-section -->

    </div><!-- /.section-Attachment -->

    {{--<div class="section-invited-email py-3 px-2 d-flex flex-column gap-2">

        <h5 class="fw-normal">Invited Email</h5>

        <div class="content-section d-flex flex-column gap-1 h-200px overflow-auto">

            <div class="module-invited-email-items d-flex flex-wrap gap-2 ">
                @foreach($obedience->emails as $user)
                    <div class="btn btn-outline-secondary">{{$user->email}}</div>
                @endforeach
            </div><!-- /.module-invited-items -->

        </div><!-- /.content-section -->

    </div><!-- /.section-invited-email -->--}}

</div><!-- /.section-content -->

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#deleteModal').modal('hide');
        });

        window.addEventListener('openModal', event => {
            $('#deleteModal').modal('show');
        });
    </script>
@endpush
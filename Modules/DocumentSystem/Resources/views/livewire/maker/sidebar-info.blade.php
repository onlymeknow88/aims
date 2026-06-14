<div>

    <div class="info-item p-3 border-bottom border-1">

        <div class="author d-flex flex-column gap-2">
            <h6>Penanggung Jawab</h6>
            <div class="item-content d-flex gap-2 align-items-center">
                <div class="thumb">
                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                </div>
                <div class="author-name">Arli Rahman</div>
            </div>
        </div><!-- /.author -->

    </div><!-- /.info-items -->

    <div class="info-item p-3 border-bottom border-1">

        <div class="created d-flex flex-column gap-2">

            <h6>Created</h6>

            <div class="item-content d-flex gap-1 align-items-center">
                <span class="opacity-50">by</span>
                <span>PT. Maruawai</span>
                <span class="opacity-50">on</span>
                <span>20/01/2023</span>
            </div>

        </div><!-- /.author -->

    </div><!-- /.info-items -->

    <div class="info-item p-3 border-bottom border-1">

        <div class="expired d-flex flex-column gap-2">

            <h6>Expired</h6>

            <div class="item-content d-flex gap-1 align-items-center">
                <span class="opacity-50">by</span>
                <span>System</span>
                <span class="opacity-50">on</span>
                <span>20/01/2023</span>
            </div>

        </div><!-- /.author -->

    </div><!-- /.info-items -->

    <div class="info-item p-3 border-bottom border-1">

        <div class="reviewed d-flex flex-column gap-2">

            <h6>Reviewed by CRS</h6>

            <div class="item-content d-flex gap-1 align-items-center">
                <div class="thumb">
                    <img src="{{ asset('./images/author.png') }}" alt="">
                </div>
                <div class="thumb">
                    <img src="{{ asset('./images/author.png') }}" alt="">
                </div>
                <div class="thumb">
                    <img src="{{ asset('./images/author.png') }}" alt="">
                </div>
                <div class="thumb">
                    <img src="{{ asset('./images/author.png') }}" alt="">
                </div>
                <div
                    class="thumb w-40px h-40px rounded-circle bg-C7FFE6 text-green d-flex justify-content-center align-items-center">
                    <span>6+</span>
                </div>
            </div>

        </div><!-- /.author -->

    </div><!-- /.info-items -->

    <div class="info-item p-3 border-bottom border-1">

        <div class="activity d-flex flex-column gap-2">

            <h6>Activity</h6>

            <div class="item-content d-flex gap-1 align-items-center">

                <div class="activity-item d-flex flex-column gap-2">

                    <div class="activity-header d-flex justify-content-between align-items-center gap-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="thumb">
                                <img src="{{ asset('./images/profile.png') }}" alt="Profile">
                            </div>
                            <div class="title">
                                <span>Iqbal Ramadhan</span>
                                <span class="opacity-50">Departement Name</span>
                            </div>
                        </div>
                        <div class="tools">
                            <img src="{{ asset('./images/icons/menu.png') }}" alt="menu">
                        </div>
                    </div><!-- /.activity-item -->

                    <div class="activity-content" x-data="{ contentOpen: false }">

                        <div class="activity-inner d-flex flex-column gap-2" :class="contentOpen ? 'height-auto' : ''"
                            x-transition.delay.5s>
                            <div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labor...</div>
                            <div class="images">
                                <h6>Images</h6>
                                <div
                                    class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                        </div>
                                        <div class="img-name">Image.jpg</div>
                                    </div>
                                    <div class="img-size opacity-50">3.2 Mb</div>
                                </div><!-- image -->
                                <div
                                    class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/activity.png') }}" alt="activity">
                                        </div>
                                        <div class="img-name">Image.jpg</div>
                                    </div>
                                    <div class="img-size opacity-50">3.2 Mb</div>
                                </div><!-- image -->
                            </div><!-- /.images -->
                            <div class="images">
                                <h6>Files</h6>
                                <div
                                    class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/icons/excel.png') }}" alt="excel">
                                        </div>
                                        <div class="img-name">Evidence Data</div>
                                    </div>
                                    <div class="img-size opacity-50">3.2 Mb</div>
                                </div><!-- image -->
                                <div
                                    class="image d-flex align-items-center justify-content-between bg-white rounded p-2 border border-1 mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="thumb">
                                            <img src="{{ asset('./images/icons/pdf.png') }}" alt="pdf">
                                        </div>
                                        <div class="img-name">File Name.pdf</div>
                                    </div>
                                    <div class="img-size opacity-50">3.2 Mb</div>
                                </div><!-- image -->
                            </div><!-- /.images -->
                        </div><!-- /.actifity-inner -->
                        <div class="button-showless">
                            <button class="d-flex gap-1 justify-content-center w-100 align-items-center py-2"
                                type="button" @click="contentOpen = ! contentOpen">
                                <span>Show Less</span>
                                <span class="icon-btn"><i class="fa-solid fa-angle-down"></i></span>
                            </button>
                        </div><!-- /.button-showless -->

                    </div><!-- /.actifity-content -->

                    <div class="activity-footer opacity-50">2 days ago</div>

                </div><!-- /.activity-item -->

            </div>

        </div><!-- /.author -->

    </div><!-- /.info-items -->

</div>

<div class="inner-content">

    <div class="header-content-csms-add-new-bidding h-60px bg-white shadow-sm d-flex gap-2 align-items-center justify-content-between px-3">
        <div class="left-header">
            <a href="{{ route('rekam-medis') }}" class="d-flex align-items-center gap-3 text-white">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>Update Rekam Medis</span>
            </a>
        </div><!-- /.left-header -->
        <div class="right-header">
        </div><!-- /.right-header -->

    </div><!-- /.header-edit-event -->

    <div class="container-fluid g-0 position-relative">

        <div class="row g-0">

            <div class="detail-left col-3">

                <div class="position-sticky top-0 bg-white pb-4">

                    <div class="info-item py-3 px-4 border-bottom border-1" x-data="{dataOpen: false, dataClose:true}">

                        <div class="author d-flex justify-content-between align-items-center gap-2">
                            <div class="item-content d-flex gap-2 align-items-center">
                                <div class="thumb">
                                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                                </div>
                                <div class="author-name">Arli Rahman</div>
                            </div>
                            <button
                                class="view-data-rekam btn bg-green justify-content-center align-items-center rounded-circle"
                                @click.prevent="dataOpen = true, dataClose = false"
                            >
                                <img src="{{asset('./images/icons/data-rekam.png')}}" alt="Data Rekam">
                            </button>
                        </div><!-- /.author -->

                        <div
                            x-cloak
                            class="content-data-rekam-medis w-100 position-absolute top-0 start-0 bg-white vh-100 z-index-3"
                            x-show="dataOpen"
                            :class="{ 'animate__animated animate__slideInLeft animate': dataOpen, 'animate__animated animate__slideOutLeft': dataClose }"
                        >
                            <div class="header-data-rekam-medis py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-medium mb-0">Data Rekam</h6>
                                <button
                                    class="close-data-rekam btn bg-white justify-content-center align-items-center rounded-circle"
                                    @click.prevent="dataClose = !dataClose"
                                >
                                    <img src="{{asset('./images/icons/delete.png')}}" alt="Data Rekam">
                                </button>

                            </div><!-- /.header-data-rekam-medis -->

                            <div class="history-rekam-medis-item border-1 border-bottom p-4 d-flex flex-column gap-2">

                                <div class="header-history fw-semibold">RM-01</div>
                                <div class="content-history">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor...</div>
                                <div class="date opacity-50">6 month ago</div>

                            </div><!-- /.history-rekam-medis-item -->

                            <div class="history-rekam-medis-item border-1 border-bottom p-4 d-flex flex-column gap-2">

                                <div class="header-history fw-semibold">RM-01</div>
                                <div class="content-history">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor...</div>
                                <div class="date opacity-50">6 month ago</div>

                            </div><!-- /.history-rekam-medis-item -->

                            <div class="history-rekam-medis-item border-1 border-bottom p-4 d-flex flex-column gap-2">

                                <div class="header-history fw-semibold">RM-01</div>
                                <div class="content-history">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor...</div>
                                <div class="date opacity-50">6 month ago</div>

                            </div><!-- /.history-rekam-medis-item -->

                            <div class="history-rekam-medis-item border-1 border-bottom p-4 d-flex flex-column gap-2">

                                <div class="header-history fw-semibold">RM-01</div>
                                <div class="content-history">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labor...</div>
                                <div class="date opacity-50">6 month ago</div>

                            </div><!-- /.history-rekam-medis-item -->

                        </div><!-- /.content-data-rekam-medis -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="pt d-flex flex-column">
                            <h6>PT Lahai Coal</h6>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/position.png') }}" alt="Position">
                                </div>
                                <div class="position-name d-flex flex-column">
                                    <span class="opacity-50">Position</span>
                                    <span>Manager</span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img src="{{ asset('./images/icons/map.png') }}" alt="Location">
                                </div>
                                <div class="location-name d-flex flex-column">
                                    <span class="opacity-50">Location Detail</span>
                                    <span>Area Pit</span>
                                </div>
                            </div>
                            <div class="item-content d-flex gap-2 align-items-start">
                                <div class="thumb">
                                    <img class="w-18px" src="{{ asset('./images/icons/blank.png') }}" alt="Blank">
                                </div>
                                <div class="department-name d-flex flex-column">
                                    <span class="opacity-50">Department</span>
                                    <span>Mining & Engineering</span>
                                </div>
                            </div>
                        </div><!-- /.pt -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="nip d-flex flex-column">

                            <h6>NIP/NIK</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">17030019 / 6205041607770000</span>
                            </div>

                        </div><!-- /.nip -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="ttl d-flex flex-column">

                            <h6>Tanggal Lahir</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">18 Maret 1973</span>
                            </div>

                        </div><!-- /.ttl -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="jk d-flex flex-column">

                            <h6>Jenis Kelamin</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-80">Laki-laki</span>
                            </div>

                        </div><!-- /.jk -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="created d-flex flex-column">

                            <h6>MCU Date</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-50">by</span>
                                <span>PT. Maruawai</span>
                                <span class="opacity-50">on</span>
                                <span>20/01/2023</span>
                            </div>

                        </div><!-- /.created -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="expired d-flex flex-column">

                            <h6>Expiration Date</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-50">by</span>
                                <span>System</span>
                                <span class="opacity-50">on</span>
                                <span>20/01/2023</span>
                            </div>

                        </div><!-- /.expired -->

                    </div><!-- /.info-items -->

                    <div class="info-item py-3 px-4 border-bottom border-1">

                        <div class="review d-flex flex-column">

                            <h6>Reviewing date</h6>

                            <div class="item-content d-flex gap-1 align-items-center">
                                <span class="opacity-50">by</span>
                                <span>System</span>
                                <span class="opacity-50">on</span>
                                <span>20/01/2023</span>
                            </div>

                        </div><!-- /.review -->

                    </div><!-- /.info-items -->

                    {{-- <div class="info-item p-3 border-bottom border-1">

                        <div class="author d-flex flex-column gap-2">
                            <h6>Maker</h6>
                            <div class="item-content d-flex gap-2 align-items-center">
                                <div class="thumb">
                                    <img src="{{ asset('./images/author.png') }}" alt="Author">
                                </div>
                                <div class="author-name">Arli Rahman</div>
                            </div>
                        </div><!-- /.author -->

                    </div><!-- /.info-items --> --}}

                </div><!-- /.info -->

            </div><!-- /.detail-left -->

            <div class="col pb-7 border-end border-start border-1">

                <div id="karyawan" class="section-karyawan border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal">Karyawan</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Type of medical exam...</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Type of medical description</div>
                                </div>

                            </div><!-- /.mcu-detail-item Type of medical -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Provider</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Provider description</div>
                                </div>

                            </div><!-- /.mcu-detail-item Provider -->

                        </div><!-- ./content-karyawan -->

                    </div>

                </div><!-- /.karyawan -->

                <!-- Anamnesis dan Riwayat Kesehatan -->
                <div id="anamnesis" class="section-anamnesis border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-3">
                        <h6 class="mb-0 fw-normal title-accordion">Anamnesis dan Riwayat Kesehatan</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Penyakit</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Keluhan</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ada</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Keluhan -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Riwayat Penyakit Dahulu</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Demam berulang/ kronis, Rinitis Alergi, Anemia, Masalah kulit kronis</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Riwayat Penyakit Dahulu -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Riwayat Penyakit Keluarga</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Diabetes</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Riwayat Penyakit Keluarga -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Alergi</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ada</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Alergi -->

                            </div><!-- /.inner-section penyakit -->

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Gaya Hidup</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Merokok</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Merokok</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Merokok -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Jumlah batang/hari</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">2 Batang/Hari</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Jumlah batang/hari -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Olahraga</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ya</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Olahraga -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Frekuensi</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">2x Seminggu</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Frekuensi -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Jenis</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Berenang, Running, Weight Lifting</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Jenis -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Alkohol</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Tidak</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Alkohol -->

                            </div><!-- /.inner-section Gaya Hidup -->

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Menstruasi</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kondisi menstruasi</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Deskripsi kondisi menstruasi</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kondisi menstruasi -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kondisi keteraturan siklus</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ya</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kondisi keteraturan siklus -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kondisi keteraturan siklus</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ya</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kondisi keteraturan siklus -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kondisi lama haid</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">6 Hari</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kondisi lama haid -->

                            </div><!-- /.inner-section Menstruasi -->

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Kehamilan dan Persalinan</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Riwayat Hamil</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Deskripsi kondisi Kehamilan dan Persalinan</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Riwayat Hamil -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Spontan</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ya</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Spontan -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Bantuan / Operasi</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Ya</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Bantuan / Operasi -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Keguguran</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">6 Hari</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Keguguran -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Jenis kontrasepsi</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Jenis kontrasepsi</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Jenis kontrasepsi -->

                            </div><!-- /.inner-section Kehamilan dan Persalinan -->

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Riwayat Pekerjaan</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Pekerjaan sebelumnya</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Pekerjaan sebelumnya -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Detail pekerjaan saat ini</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Detail pekerjaan saat ini -->

                            </div><!-- /.inner-section Riwayat Pekerjaan -->

                            <div class="inner-section mb-5 mx-n">

                                <h6 class="mb-3 fw-normal title-accordion">Riwayat Vaksinasi Food handler</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Hep A - 1st</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Hep A - 1st -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Hep A - 2nd</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Hep A - 2nd -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Hep A - 3 years </label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Hep A - 3 years  -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Typhoid - 1st</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Typhoid - 1st -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Typhoid - 3 years</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Typhoid - 3 years -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Albendandazole 400 mg </label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Value</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Albendandazole 400 mg -->

                            </div><!-- /.inner-section Riwayat Vaksinasi Food handler -->

                        </div><!-- ./content-karyawan -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.Anamnesis dan Riwayat Kesehatan -->

                <!-- tanda vital Accordion -->
                <div id="tanda-vital" class="section-anamnesis_2 border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Tanda-tanda Vital dan Antropometri</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">TB</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">177 cm</div>
                                </div>

                            </div><!-- /.mcu-detail-item TB -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">BB</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">80 kg</div>
                                </div>

                            </div><!-- /.mcu-detail-item BB -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">BMI</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">77 kg/m2</div>
                                </div>

                            </div><!-- /.mcu-detail-item BMI -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">STATUS GIZI</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">12</div>
                                </div>

                            </div><!-- /.mcu-detail-item STATUS GIZI -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">BB SEHAT TERENDAH</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">22</div>
                                </div>

                            </div><!-- /.mcu-detail-item BB SEHAT TERRENDAH -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">BB SEHAT TERTINGGI</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">21</div>
                                </div>

                            </div><!-- /.mcu-detail-item BB SEHAT TERTINGGI -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Tekanan Darah Sistolik</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">120 mmHg</div>
                                </div>

                            </div><!-- /.mcu-detail-item Tekanan Darah Sistolik -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Tekanan Darah Diastolik</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">80 mmHg</div>
                                </div>

                            </div><!-- /.mcu-detail-item Tekanan Darah Diastolik -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Nadi x/m</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">77 x/m</div>
                                </div>

                            </div><!-- /.mcu-detail-item Nadi x/m -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">RR x/m</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">44 x/m</div>
                                </div>

                            </div><!-- /.mcu-detail-item RR x/m -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Suhu tubuh</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">25 C</div>
                                </div>

                            </div><!-- /.mcu-detail-item Suhu tubuh  -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Blood pressure status</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">120</div>
                                </div>

                            </div><!-- /.mcu-detail-item Blood pressure status -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.anamnesis_2 -->

                <!-- Pemeriksaan Generalisata Accordion -->
                <div id="generalisata" class="section-generalisata border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Pemerikasaan Generalisata</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">HEENT</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item HEENT -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">ORODENTAL</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item ORODENTAL -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">SISTEM KARDIOVASKULER</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Gangren Radix</div>
                                </div>

                            </div><!-- /.mcu-detail-item SISTEM KARDIOVASKULER -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">SISTEM RESPIRATORIUS</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item SISTEM RESPIRATORIUS -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">SISTEM DIGESTIVUS</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item SISTEM DIGESTIVUS -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">SISTEM GENITOURINARIUS+KULIT</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item SISTEM GENITOURINARIUS+KULIT -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">SISTEM NEUROMUSKULAR</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item SISTEM NEUROMUSKULAR -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Lain-lain</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Baik</div>
                                </div>

                            </div><!-- /.mcu-detail-item Lain-lain -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.generalisata -->

                <!-- Pemeriksaan Virus Accordion -->
                <div id="virus" class="section-virus border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Pemerikasaan Virus</h6>
                    </div>
                    <div class="wrapper-content-accordion overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="inner-section mb-5">

                                <div class="mb-3 mcu-detail-item row">
                                    <div class="col-4">Virus</div>
                                    <div class="col-2">Non koreksi</div>
                                    <div class="col-2">koreksi</div>
                                </div><!-- header virus -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">Visus jauh OD</label>
                                    <div class="col-2">1/6</div>
                                    <div class="col-2">1/6</div>
                                </div><!-- Visus jauh OD -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">Visus jauh OS</label>
                                    <div class="col-2">1/6</div>
                                    <div class="col-2">1/6</div>
                                </div><!-- Visus jauh OS -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">Visus jauh ODS</label>
                                    <div class="col-2">1/6</div>
                                    <div class="col-2">1/6</div>
                                </div><!-- Visus jauh ODS -->

                            </div><!-- /.inner-section Virus -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesan Visus Jauh</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Kesan virus</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesan Visus Jauh -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">READING TEST / Visus Dekat / Jaeger Test</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Hypermetropia</div>
                                </div>

                            </div><!-- /.mcu-detail-item READING TEST / Visus Dekat / Jaeger Test -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Buta Warna</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Parsial</div>
                                </div>

                            </div><!-- /.mcu-detail-item Buta Warna -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Lapangan Pandang</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item Lapangan Pandang -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Catatan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item Catatan -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.virus -->

                <!-- Audiometri Accordion -->
                <div id="audiometri" class="section-audiometri border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Audiometri</h6>
                    </div>
                    <div class="wrapper-content-accordion overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="inner-section mb-5">

                                <div class="mb-3 mcu-detail-item row">
                                    <div class="col-4">Air conduction</div>
                                    <div class="col-2">Kanan</div>
                                    <div class="col-2">Kiri</div>
                                </div><!-- header Air conduction -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">500</label>
                                    <div class="col-2">25</div>
                                    <div class="col-2">15</div>
                                </div><!-- Visus 500 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">1000</label>
                                    <div class="col-2">45</div>
                                    <div class="col-2">25</div>
                                </div><!-- Visus 1000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">2000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">10</div>
                                </div><!-- Visus 2000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">3000</label>
                                    <div class="col-2">30</div>
                                    <div class="col-2">30</div>
                                </div><!-- Visus 3000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">4000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">35</div>
                                </div><!-- Visus 4000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">6000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">35</div>
                                </div><!-- Visus 6000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">8000</label>
                                    <div class="col-2">45</div>
                                    <div class="col-2">25</div>
                                </div><!-- Visus 8000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">HTL</label>
                                    <div class="col-2">26.25</div>
                                </div><!-- Visus HTL -->

                            </div><!-- /.inner-section Air conduction -->

                            <div class="inner-section mb-5">

                                <div class="mb-3 mcu-detail-item row">
                                    <div class="col-4">Bone conduction</div>
                                    <div class="col-2">Kanan</div>
                                    <div class="col-2">Kiri</div>
                                </div><!-- header Bone conduction -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">500</label>
                                    <div class="col-2">25</div>
                                    <div class="col-2">15</div>
                                </div><!-- Visus 500 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">1000</label>
                                    <div class="col-2">45</div>
                                    <div class="col-2">25</div>
                                </div><!-- Visus 1000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">2000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">10</div>
                                </div><!-- Visus 2000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">3000</label>
                                    <div class="col-2">30</div>
                                    <div class="col-2">30</div>
                                </div><!-- Visus 3000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">4000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">35</div>
                                </div><!-- Visus 4000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">6000</label>
                                    <div class="col-2">35</div>
                                    <div class="col-2">35</div>
                                </div><!-- Visus 6000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">8000</label>
                                    <div class="col-2">45</div>
                                    <div class="col-2">25</div>
                                </div><!-- Visus 8000 -->

                                <div class="mb-3 mcu-detail-item row">
                                    <label class="col-4 opacity-50">HTL</label>
                                    <div class="col-2">26.25</div>
                                    <div class="col-2">21.25</div>
                                </div><!-- Visus HTL -->

                            </div><!-- /.inner-section Bone conduction -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesimpulan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesimpulan -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesimpulan -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.audiometri -->

                <!-- Spirometri Accordion -->
                <div id="spirometri" class="section-spirometri border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Spirometri</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">FVC</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">25 %</div>
                                </div>

                            </div><!-- /.mcu-detail-item FVC -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">FEV1</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">45 %</div>
                                </div>

                            </div><!-- /.mcu-detail-item FEV1 -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">35</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesan -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.spirometri -->

                <!-- Pemeriksaan Penunjang Accordion -->
                <div id="penunjang" class="section-penunjang border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Pemeriksaan Penunjang</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">X-RAY THORAX</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Normal, Cardiomegali, Bronkopneumoni</div>
                                </div>

                            </div><!-- /.mcu-detail-item X-RAY THORAX -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">EKG</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Sinus Ritme, Sinus Aritmia</div>
                                </div>

                            </div><!-- /.mcu-detail-item EKG -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">TREADMILL</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Negative Ischemic Response</div>
                                </div>

                            </div><!-- /.mcu-detail-item TREADMILL -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">ECHOCARDIOGRAPHY</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item ECHOCARDIOGRAPHY -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Additional Diagnosis (post Cardiologist evaluation)</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item Additional Diagnosis (post Cardiologist evaluation) -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.penunjang -->

                <!-- Laboratorium Accordion -->
                <div id="lab" class="section-lab border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Laboratorium</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Complete Blood Count</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Hb</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">13</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Hb -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Ht</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">40</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Ht -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Leukosit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">5000</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Leukosit -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Thrombosit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">1.500</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Thrombosit -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Eritrosit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">4.7</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Eritrosit -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">LED</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">10</div>
                                    </div>

                                </div><!-- /.mcu-detail-item LED -->

                            </div><!-- /.inner-section Complete Blood Count -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Blood Group</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Golongan Darah</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">B</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Golongan Darah -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Rhesus</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Rhesus -->

                            </div><!-- /.inner-section Blood Group -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Fungsi Hati</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">SGOT</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">40</div>
                                    </div>

                                </div><!-- /.mcu-detail-item SGOT -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">SGPT</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">41</div>
                                    </div>

                                </div><!-- /.mcu-detail-item SGPT -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Gamma GT</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">10</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Gamma GT -->

                            </div><!-- /.inner-section Fungsi Hati -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Profil Lipid</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">KOLESTEROL TOTAL</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">70</div>
                                    </div>

                                </div><!-- /.mcu-detail-item KOLESTEROL TOTAL -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">HDL</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">55</div>
                                    </div>

                                </div><!-- /.mcu-detail-item HDL -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">LDL</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">88</div>
                                    </div>

                                </div><!-- /.mcu-detail-item LDL -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">TGA</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">120</div>
                                    </div>

                                </div><!-- /.mcu-detail-item TGA -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Billirubin Total</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">110</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Billirubin Total -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Billirubin direk</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">0.2</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Billirubin direk -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Billirubin indirek</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">1</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Billirubin indirek -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Status Dislipidemia</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Yes</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Status Dislipidemia -->

                            </div><!-- /.inner-section Profil Lipid -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Glukosa Darah</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">GDP</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">70</div>
                                    </div>

                                </div><!-- /.mcu-detail-item GDP -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">G2PP</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">110</div>
                                    </div>

                                </div><!-- /.mcu-detail-item G2PP -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">STATUS HIPERGLIKEMIA</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet</div>
                                    </div>

                                </div><!-- /.mcu-detail-item STATUS HIPERGLIKEMIA -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">HbA1C</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet</div>
                                    </div>

                                </div><!-- /.mcu-detail-item HbA1C -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Status DM</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Status DM -->

                            </div><!-- /.inner-section Glukosa Darah -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Jakarta Cardiovaskular</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Score</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">10</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Score -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Risk</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Rendah</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Risk -->

                            </div><!-- /.inner-section Jakarta Cardiovaskular -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Framingham Risk</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Score</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">10</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Score -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Risk</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Rendah</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Risk -->

                            </div><!-- /.inner-section Framingham Risk -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Fungsi Ginjal</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Ureum</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">12</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Ureum -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">BUN</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">22</div>
                                    </div>

                                </div><!-- /.mcu-detail-item BUN -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Creatinin</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">0.9</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Creatinin -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Asam urat</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">6.1</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Asam urat -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">eGFR</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">107</div>
                                    </div>

                                </div><!-- /.mcu-detail-item eGFR -->

                            </div><!-- /.inner-section Fungsi Ginjal -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Imunoserologi</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">HBs-Ag</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Reaktif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item HBs-Ag -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Anti HBs</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Reaktif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Anti HBs -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Anti HAV IgM</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Reaktif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Anti HAV IgM -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Widal</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Positif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Widal -->

                            </div><!-- /.inner-section Imunoserologi -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Malaria</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Malaria</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Malaria -->

                            </div><!-- /.inner-section Malaria -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Urinalisis Makroskopis</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Warna</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Kuning</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Warna -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kejernihan</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Jernih</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kejernihan -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">pH</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">6</div>
                                    </div>

                                </div><!-- /.mcu-detail-item pH -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Berat Jenis</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">1015</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Berat Jenis -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Protein</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Protein -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Glukosa</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Glukosa -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Bilirubin</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Bilirubin -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Urobilinogen/Urobilin</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Normal</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Bilirubin -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Keton</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Keton -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Darah</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Darah -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Lekositesterase</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Lekositesterase -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Nitrit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Nitrit -->

                            </div><!-- /.inner-section Urinalisis Makroskopis -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Urinalisis Mikroskopis</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Sedimen Leukosit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">1-4</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Sedimen Leukosit -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Eritrosit</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">0-1</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Eritrosit -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Epitel</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Positif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Epitel -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Silinder</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Silinder -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kristal</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kristal -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Bakteri</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Bakteri -->

                            </div><!-- /.inner-section Urinalisis Mikroskopis -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Urinalisis</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Lainnya</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididtunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Lainnya -->

                            </div><!-- /.inner-section Urinalisis -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Urinalisis Drug Test</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">AMP</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item AMP -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">MET</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item MET -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">BDZ</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item BDZ -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">COC</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item COC -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">OPI</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item OPI -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">THC</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Negatif</div>
                                    </div>

                                </div><!-- /.mcu-detail-item THC -->

                            </div><!-- /.inner-section Urinalisis Drug Test -->

                            <div class="inner-section mb-5">

                                <h6 class="mb-3 fw-normal title-accordion">Analisis Feses</h6>

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Analisis Feses</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Norma Result, Darah positf </div>
                                    </div>

                                </div><!-- /.mcu-detail-item Analisis Feses -->

                                <div class="mb-3 mcu-detail-item row">

                                    <label class="col-4 opacity-50">Kultur Feses</label>

                                    <div class="col-8 content-mcu-detail">
                                        <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                    </div>

                                </div><!-- /.mcu-detail-item Kultur Feses -->

                            </div><!-- /.inner-sectionAnalisis Feses -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.Laboratorium -->

                <!-- Temuan Accordion -->
                <div id="temuan" class="section-temuan border-1 border-bottom p-5">

                    <div class="header-section d-flex justify-content-between w-100 border-0 bg-white my-3 mx-4">
                        <h6 class="mb-0 fw-normal title-accordion">Temuan</h6>
                    </div>
                    <div class="wrapper-content-section overflow-hidden position-relative transition-all duration-700">

                        <div class="content-section m-4">

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Hasil Temuan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                </div>

                            </div><!-- /.mcu-detail-item Hasil Temuan -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesesuaian Matrix</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Sesuai</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesesuaian Matrix -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Status Hasil Peninjauan</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">UNFIT</div>
                                </div>

                            </div><!-- /.mcu-detail-item Status Hasil Peninjauan -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Kesesuaian Matrix</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">Sesuai</div>
                                </div>

                            </div><!-- /.mcu-detail-item Kesesuaian Matrix -->

                            <div class="mb-3 mcu-detail-item row">

                                <label class="col-4 opacity-50">Dokter Spesialis</label>

                                <div class="col-8 content-mcu-detail">
                                    <div class="content">dr. Ade Indrisari Sp. A, M. Kes</div>
                                </div>

                            </div><!-- /.mcu-detail-item Dokter Spesialis -->

                        </div><!-- /.content-section -->

                    </div><!-- /.wrapper-content-accordion -->

                </div><!-- /.temuan -->

            </div><!-- col center -->

            <div class="col-3">
                <div class="section-sidebar-nav position-sticky top-0 py-4">
                    <ul>
                        <li><a href="#" @click.prevent="document.getElementById('karyawan').scrollIntoView()">Karyawan</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('anamnesis').scrollIntoView()">Riwayat</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('tanda-vital').scrollIntoView()">Tanda Vital</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('generalisata').scrollIntoView()">Pemeriksaan Generalisata</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('virus').scrollIntoView()">Pemeriksaan Virus</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('audiometri').scrollIntoView()">Audiometri</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('spirometri').scrollIntoView()">Spirometri</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('penunjang').scrollIntoView()">Pemeriksaan Penunjang</a></li>
                        <li><a href="#" @click.prevent="document.getElementById('lab').scrollIntoView()">Laboratorium</a></li>
                    </ul>
                </div><!-- /.section-sidebar-nav -->
            </div>

        </div><!-- /.row -->
    </div><!-- /.container -->


</div>

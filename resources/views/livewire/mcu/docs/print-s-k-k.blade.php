<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #section-to-print,
        #section-to-print * {
            visibility: visible;
        }

        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
<div class="container section-to-print" id="section-to-print" onload="window.print()">
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <span><img src="{{ asset('./images/logo-login.png') }}" alt=""></span>

                        </div>
                        <div class="col-md-5 text-center">
                            <h5>SERTIFIKAT KESEHATAN KERJA (SKK) SEMENTARA /
                                TEMPORARY OCCUPATIONAL HEALTH CERTIFICATE
                            </h5>
                        </div>
                        <div class="col-md-4 text-left">
                            <div class="row">
                                <div class="col-5">
                                    <h6>No. Dokumen</h6>
                                    <h6>No. revisi</h6>
                                    <h6>Tanggal</h6>
                                </div>
                                <div class="col-7">
                                    <h6>: {{ $data['doctor_certificate_number'] }}</h6>
                                    {{-- <h6>: F-MAC-IHH-02-008</h6> --}}
                                    <h6>: 0.0</h6>
                                    <h6>: {{ \Carbon\Carbon::parse($data['mcu_review_date'])->format('d-m-Y') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>NOMOR SKKs : SKKs/015/I/2023 ?</h6>
                    <div class="row mt-5">
                        <div class="col-4">
                            <h6>Nama</h6>
                        </div>
                        <div class="col-8">
                            <h6>: {{ $data['employee']['name'] }}</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Tanggal Lahir/Umur</h6>
                        </div>
                        <div class="col-8">
                            <h6>: {{ \Carbon\Carbon::parse($data['employee']['date_of_birth'])->format('d M Y') }}</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: {{ $data['employee']['company'] }}</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: F-MAC-IHH-02-008</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: F-MAC-IHH-02-008</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: F-MAC-IHH-02-008</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: F-MAC-IHH-02-008</h6>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-4">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-8">
                            <h6>: F-MAC-IHH-02-008</h6>
                        </div>
                    </div>
                    <hr>

                </div>
            </div>
        </div>
    </div>

</div>

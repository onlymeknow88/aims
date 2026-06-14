<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            .page-break {
                page-break-after: always;
            }
            @page {
                margin: 90px 25px 90px 25px;
            }
            p{
                margin: 0;
                margin-bottom: 5px;
            }
            header {
                position: fixed;
                font-size: 16px !important;
                color: black;
                text-align: center;
                top: -70px;
                /* top: 0; */
                font-weight: 700;
                left: 0;
                right: 0;
            }
            table{
                border-collapse: collapse;
                width: 100%;
            }
            table td{
                padding: 2px;
                vertical-align: top;
                white-space: unset;
            }
            header table tbody tr td{
                border: 1px solid black;
                padding: 5px;
                position: relative;
            }
            header table tbody tr td:nth-child(1){
                width: 20%;
            }
            header table tbody tr td:nth-child(2){
                width: 50%;
                text-align: center;
                vertical-align: middle;
            }
            header table tbody tr td:nth-child(3){
                text-align: left;
                font-weight: 400;
                font-size: 12px;
                width: 30%;
            }
            header table tbody tr td div span:first-child{
                width: 40%;
                display: inline-block;
            }
            footer {
                position: fixed;
                bottom: -70px;
                color: black;
                left: 0;
                right: 0;
                font-size: 14px;
            }
            main{
                position: relative;
            }
            main:before{
                content: " ";
                width: 100%;
                height: 100%;
                position: absolute;
                background-image: url("{{public_path('images/bg-print.png')}}");
                background-position: center;
                background-repeat: no-repeat;
                background-size: 60%;
                opacity: .2;
            }
            .main-header{
                position: relative;
            }
            .main-header:before{
                content: " ";
                position: absolute;
                background-image: url("{{public_path('images/shape-print.png')}}");
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
                right: 0;
                width: 100px;
                height: 100px;
            }
            .main-header h3{
                display: inline-block;
                /* background-color: #FEF2CD; */
            }
            .main-header table td:first-child{
                width: 30%;
            }
            .main-header table td:nth-child(2){
                width: 16px;
            }
            .main-header table td:nth-child(3){
                width: 10%;
            }
            .data-perusahaan{
                position: relative;
            }

            .data-perusahaan table tr td:first-child{
                width: 30%;
            }
            .data-perusahaan table tr td:nth-child(2){
                width: 16px;
            }
            .data-perusahaan table tr td:nth-child(3){
                width: 30%;
            }
            .ttd{
                width: 25%;
                text-align: center;
            }
            .ttd .nama-perusahaan{
                font-weight: 700;
            }
            .ttd .nama{
                font-weight: 700;
                text-decoration: underline;
            }

        </style>
    </head>
    <body>
        <header>
            <table border=0 width="100%" >
                <tr>
                    <td><img width="100" src="{{public_path('images/adaro-mineral.png')}}" alt="" /></td>
                    {{-- <td><img width="100" src="{{asset   ('images/adaro-mineral.png')}}" alt="" /></td> --}}
                    <td>SERTIFIKAT PEMENUHAN CSMS</td>
                    <td>
                        <div>
                            <span>No. Dokumen</span>
                            <span>: {{ $data['document_number'] }}</span>
                        </div>
                        <div>
                            <span>No. Revisi</span>
                            <span>: {{ $data['document_revision'] }}</span>
                        </div>
                        <div>
                            <span>Tanggal</span>
                            <span>: {{ $data['document_date'] }}</span>
                        </div>

                    </td>
                </tr>
            </table>
        </header>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="main-header">
                <h3>{{ $data['ccow'] }}</h3>
                <div class="data-detail">
                    <table>
                        <tbody>
                            <tr>
                                <td>Nomor</td>
                                <td>:</td>
                                <td colspan="2">{{ $data['document_number'] }}</td>
                                {{-- <td></td> --}}
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td colspan="2">{{ $data['document_date'] }}</td>
                                {{-- <td></td> --}}
                            </tr>
                            <tr>
                                <td>Berlaku s/d tanggal</td>
                                <td>:</td>
                                <td colspan="2">{{ $data['document_date_end'] }}</td>
                                {{-- <td></td> --}}
                            </tr>
                        </tbody>
                    </table>
                    <table>
                        <tbody>
                            <tr>
                                <td>Memperhatikan</td>
                                <td>:</td>
                                <td colspan="2">{{ $data['company_name'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Tanggal</td>
                                <td>: {{ $data['document_date'] }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2">Tentang Permohonan Pemenuhan CSMS</td>
                            </tr>
                            <tr>
                                <td>Mengingat</td>
                                <td>:</td>
                                <td colspan="2">Prosedur No. MAC-IMS-08 tentang Pengelolaan KPLH Kontraktor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="data-perusahaan">
                <h3>Memutuskan</h3>
                <table>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>1.</td>
                            <td>Nama Perusahaan</td>
                            <td>: {{ $data['company_name'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Alamat</td>
                            <td>: {{ $data['company_address'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>2.</td>
                            <td>Bidang Usaha Mitra Kerja</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Keterangan Bidang</td>
                            <td>: {{ $data['company_business_entity'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Usaha Mitra Kerja</td>
                            <td>: {{ $data['company_business_entity'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>No. Ijin Usaha</td>
                            <td>: {{ $data['company_license_number'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tanggal Terbit</td>
                            <td>: {{ $data['company_license_date_start'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tanggal Berakhir</td>
                            <td>: {{ $data['company_license_date_end'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>3.</td>
                            <td>Kegiatan Mitra Kerja Sesuai dengan Kontrak Kerja</td>
                            <td>: {{ $data['company_license_suitability'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Jenis Kegiatan</td>
                            <td>: {{ $data['company_service_criteria'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>4.</td>
                            <td>Nama PJO</td>
                            <td>: {{ $data['company_pjo_name'] }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Nomor Telepon PJO</td>
                            <td>: {{ $data['company_pjo_phone'] }}</td>
                        </tr>
                        <tr>
                            <td>Pertama</td>
                            <td>:</td>
                            <td colspan="2">Memberikan Izin Untuk Bekerja di Lokasi Kerja PKP2B PT. Maruwai Coal</td>
                        </tr>
                        <tr>
                            <td>Kedua</td>
                            <td>:</td>
                            <td colspan="2">Sertifikat Pemenuhan CSMS berlaku selama 2 (dua) tahun terhitung sejak tanggal diterbitkan</td>
                        </tr>
                        <tr>
                            <td>Ketiga</td>
                            <td>:</td>
                            <td colspan="2">Apabila ternyata terdapat kekeliruan dalam pemberian Surat Pemenuhan CSMS ini dikemudian hari, akan diadakan peninjauan dan/atau pembetulan sebagaimana mestinya.</td>
                         </tr>
                    </tbody>
                </table>
            </div>

            <div class="ttd">
                <div class="nama-perusahaan">PT MARUWAI COAL</div>
                <div class="qrcode">
                    <img src="{{ $data['qrcode'] }}" style="height: 150px; width: 150px; padding:5%;" alt="qrcode" />
                    {{-- <img src="https://chart.googleapis.com/chart?cht=qr&chl=http%3A%2F%2Farchivescode.com&chs=180x180&choe=UTF-8&chld=L|2"> --}}
                </div>
                <div>
                    <div class="nama">M. Safrudin Sulaiman</div>
                    <div class="jabatan">Kepala Teknik Tambang</div>
                </div>
            </div>

        </main>

        <footer class="footer">Dokumen ini sah, diterbitkan secara elektronik oleh Dept. OHS PT. Maruwai Coal.</footer>
    </body>
</html>

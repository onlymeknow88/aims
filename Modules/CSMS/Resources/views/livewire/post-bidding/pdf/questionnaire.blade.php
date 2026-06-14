<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            .page-break {
                page-break-after: always;
            }
            @page {
                margin: 100px 25px 25px 25px;
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
                padding: 5px;
                vertical-align: top;
                border: 1px solid black;
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
                width:100%;
            }
            /* main{
                margin: 120px 25px;
            } */
            .main-header{
                text-align: center;
            }
            .data-perusahaan table tr td div{

            }
            .data-perusahaan table tr td:first-child{
                width: 40%;
            }
            .data-perusahaan table tr td div span:first-child{
                width: 40%;
                display: inline-block;
            }
            .data-perusahaan table tr td table{
                border:none;
            }
            .data-perusahaan table tr td table tr td{
                border-width: 0 0 1px 0;
            }
            .data-perusahaan table tr.dilengkapi td:nth-child(2){
                padding: 5px 0;
            }
            .data-perusahaan table tr td table tr td:nth-child(1){
                width: 30%;
            }
            .data-perusahaan table tr td table tr td:nth-child(2){
                width: 40%;
            }
            .data-perusahaan table tr td table tr td:nth-child(3){
                width: 30%;
                vertical-align: bottom;
                text-align: center;
                border: none;
            }
        </style>
    </head>
    <body>
        <header>
            <table border=0 width="100%" >
                <tr>
                    <td><img width="100" src="{{public_path('images/adaro-mineral.png')}}" alt="" /></td>
                    {{-- <td><img width="100" src="{{asset   ('images/adaro-mineral.png')}}" alt="" /></td> --}}
                    <td>KUESIONER CSMS</td>
                    <td>
                        <div>
                            <span>No. Dokumen</span>
                            <span>: {{ $data['document_number'] }}</span>
                        </div>
                        <div>
                            <span>No. Revisi</span>
                            <span>: {{ $data['document_rev'] }}</span>
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
                <h3>1. DATA PERUSAHAAN</h3>
            </div>
            <div class="data-perusahaan">
                <table>
                    <tbody>
                        <tr>
                            <td>Kriteria CSMS</td>
                            <td>{{ $data['criteria'] }}</td>
                        </tr>
                        <tr>
                            <td>CCOW</td>
                            <td>{{ $data['ccow'] }}</td>
                        </tr>
                        <tr>
                            <td>Nama Perusahaan Kontraktor</td>
                            <td>{{ $data['company_name'] }}</td>
                        </tr>
                        <tr>
                            <td>Singkatan Nama Perusahaan (Maks 5 huruf)</td>
                            <td>{{ $data['company_nickname'] }}</td>
                        </tr>
                        <tr>
                            <td>Kriteria Jasa Perusahaan</td>
                            <td>{{ $data['business_entity'] }}</td>
                        </tr>
                        <tr>
                            <td>Perusahaan Induk</td>
                            <td>{{ $data['company_parent'] }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Perusahaan</td>
                            <td>{{ $data['address'] }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Ijin Usaha Jasa (Sesuai Surat Ijin Dari Instansi Terkait)</td>
                            <td>{{ $data['license_number'] }}</td>
                        </tr>
                        <tr>
                            <td>Bidang Jasa / Pekerjaan (yang dilakukan di site Adaro - Sesuai Kontrak dan Bisnis Proses)</td>
                            <td>{{ $data['service_criteria'] }}</td>
                        </tr>
                        <tr>
                            <td>Lingkup Usaha/Jasa (Sesuai Surat Ijin Dari Instansi Terkait)</td>
                            <td>{{ $data['scope_of_business'] }}</td>
                        </tr>
                        <tr>
                            <td>Periode Kontrak</td>
                            <td>{{ $data['date_contract_period_start'] }} - {{ $data['date_contract_period_end']  }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Pekerja yang bekerja di Adaro</td>
                            <td>{{ $data['number_of_workers'] }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Pengawas yang Berkompetensi</td>
                            <td>
                                <div>
                                    <span>POP</span><span>: {{ $data['number_of_spv_pop'] }}</span>
                                </div>
                                <div>
                                    <span>POM</span><span>: {{ $data['number_of_spv_pom'] }}</span>
                                </div>
                                <div>
                                    <span>POU</span><span>: {{ $data['number_of_spv_pou'] }}</span>
                                </div>
                                <div>
                                    <span>Implementasi SMKP</span><span>: {{ $data['number_of_spv_imp_smkp'] }}</span>
                                </div>
                                <div>
                                    <span>Auditor SMKP</span><span>: {{ $data['number_of_spv_auditor_smkp'] }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="dilengkapi">
                            <td>Dilengkapi oleh</td>
                            <td>
                                <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td>: {{ $data['equipped_name'] }}</td>
                                        <td rowspan="4">(Tanda Tangan)</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>: {{ $data['equipped_position'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Telepon</td>
                                        <td>: {{ $data['equipped_telephone'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat email</td>
                                        <td>: {{ $data['equipped_email'] }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengumpulan</td>
                            <td>{{ $data['date'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">PT Maruwai Coal tidak akan me-riview dokumen ini dan kontraktor tidak akan diundang untuk mengikuti proses selanjutnya apabila tidak ditandatangani oleh Direktur/Manajer Perusahaan Dengan menandatangani formulir ini maka Kontraktor mengizinkan PT Maruwai Coal untuk melakukan verifikasi data dan dokumen yang diberikan. Lampirkan riwayat hidup (pengalaman kerja) dari para pekerja utama termasuk Pengawas di Lapangan, Manajer Proyek, dan Perwakilan K3LH dan Perwakilan Manajemen Perusahaan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </body>
</html>

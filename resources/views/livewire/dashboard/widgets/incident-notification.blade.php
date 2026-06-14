<div class="table-incident-notification bg-green-op rounded-3 p-3">

    <div class="coe-list-title py-1 text-center text-white">
        <h6>Incident Notification</h6>
    </div><!-- /.coe-list-title -->

    <div class="table-wrapper">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Case</th>
                    <th scope="col">Category</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Piring jatuh dari meja makan</td>
                    <td>PD</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Tangan tergores kertas</td>
                    <td>FAI</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Nyaris terpeleset ditangga</td>
                    <td>NM</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Meja risak saat diangkat di ruang office</td>
                    <td>PD</td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>Pot pecah tersenggol karyawan yang melintas</td>
                    <td>PD</td>
                </tr>
            </tbody>
        </table>

    </div><!-- /.table-wrapper -->
    
</div>

@push('styles')
    <style>
        .table-incident-notification table tr{
            border-left: 1px solid #ffffff;
            border-right: 1px solid #ffffff;
        }
        .table-incident-notification table tr th,
        .table-incident-notification table tr td{
            font-size: 14px;
            color: #ffffff;
            padding: 0.5rem !important;
        }
        .table-incident-notification table tr th{
            color: #000000;
        }
    </style>
@endpush

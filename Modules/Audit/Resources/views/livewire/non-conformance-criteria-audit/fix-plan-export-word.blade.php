<div style="font-family: Arial, sans-serif; color: #333;">
    <p style="font-weight: bold; font-size: 16px; text-align: center">FORMULIR RENCANA TINDAK LANJUT KETIDAKSESUAIAN AUDIT PENERAPAN {{strtoupper($audit_category)}}</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 16px;">
        <tr>
            <td style="width:40%">Nama Perusahaan</td>
            <td style="width:5%">:</td>
            <td style="width:45%">{{$audit->company->company_name}}</td>
        </tr>
        <tr>
            <td style="width:40%">Tanggal Audit</td>
            <td style="width:5%">:</td>
            <td style="width:45%">{{date('d-m-Y',strtotime($audit->start_at))}}</td>
        </tr>
    </table>

    <table style="width: 100%; margin: 20px auto; border: 1px solid black; font-size: 16px; border-collapse: separate;
           border-spacing: 2px;">
        <tr style="font-weight: bold; vertical-align: middle;">
            <td style="width: 5%; text-align: center;">No</td>
            <td style="width: 15%; text-align: center;">Nomor</td>
            <td style="width: 20%; text-align: center;">Deskripsi Ketidaksesuaian</td>
            <td style="width: 15%; text-align: center;">Akar Permasalahan</td>
            <td style="width: 20%; text-align: center;">Tindakan Koreksi</td>
            <td style="width: 15%; text-align: center;">PJ</td>
            <td style="width: 10%; text-align: center;">Batas Waktu</td>
        </tr>

        @forelse($non_confirmances as $confirmance)
        <tr>
            <td style="width: 5%; text-align: center;">{{++$startNumber}}</td>
            <td style="width: 15%; text-align: center;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{$confirmance->non_confirmance_number}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{strip_tags($confirmance->problem_description)}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="0px; width: 15%; margin-left: 10px"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{strip_tags($confirmance->root_cause_investigation)}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{strip_tags($confirmance->fix_action)}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{$confirmance->auditee}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify;">{{date('d-m-Y',strtotime($confirmance->due_date))}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach
    </table>

    <table style="width: 100%; border: 1px solid black; font-size: 16px;">
        <tr>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Nama Auditor</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{$audit->auditors[0]->name ?? '-'}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Tanda Tangan</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 15%;"></td>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Tanggal</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{date('d-m-Y')}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Nama Auditi</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"></td>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Tanda Tangan</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 15%;"></td>
            <td style="width: 15%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">Tanggal</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 20%;"><table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; text-align:justify; vertical-align: middle;">{{date('d-m-Y')}}</td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
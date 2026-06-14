<div style="font-size: 15px; font-family: Arial, sans-serif; color: #333; margin: 20px;">
    <p style="font-weight: bold; font-size: 15px; text-align: center">FORMULIR BERITA ACARA HASIL PELAKSANAAN TAHAPAN AWAL AUDIT INTERNAL SISTEM MANAJEMEN KESELAMATAN PERTAMBANGAN</p>

    <p style="font-weight: bold;">I. INFORMASI PELAKSANAAN AUDIT SMKP</p><p style="font-weight: bold;">A. Data Perusahaan Auditi</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse;">
        
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">Perusahaan Auditee</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">: {{$detail->company->company_name ?? ''}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">Jenis Perizinan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">: {{$detail->permission_type ?? ''}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">Jenis Komoditas</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">: {{$detail->commodity_type ?? ''}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">Alamat Perusahaan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">: {{$audit->audit_plan->detail->address ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">Periode Audit</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 50%;">: {{(Carbon\Carbon::parse($audit->start_at)->format('d F Y') ." - ".Carbon\Carbon::parse($audit->end_at)->format('d F Y')) ?? '-'}}</td>
        </tr>
    </table>

    <p style="font-weight: bold;">Data Kinerja Keselamatan Pertambangan pada Periode Audit</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse;">
        @foreach($detail->safety_performances as $key =>$value)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 80%;">{{$value->title ?? '-'}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%;">: {{$detail->safety_performances[$key]->pivot->value ?? '-'}}</td>
        </tr>
        @endforeach
    </table>

    <p style="font-weight: bold;">Dasar Faktor Penyesuaian</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 70%; text-align: center; vertical-align: middle; line-height: 1; margin: 0; padding: 0;">Kondisi</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 20%; text-align: center; vertical-align: middle;">Ya/Tidak</th>
        </tr>
        @foreach($detail->adjustment_factors as $key => $value)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">{{$value->title}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->adjustment_factors[$key]->pivot->value == 1 ? 'Ya' : 'Tidak'}}</td>
        </tr>
        @endforeach
    </table>

    <p style="font-weight: bold;">B. Perhitungan Hari Kerja Audit dan Jumlah Auditor</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Jumlah Pekerja Auditi (Manpower)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->man_power}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Kelas Resiko</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{\Modules\Audit\Entities\AuditRiskSeverity::find($detail->audit_risk_severity_id)->name ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Nomor Kategori</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->audit_man_days_id}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Jumlah Auditor</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$total_auditor}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Mandays</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->man_days}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Faktor Penyesuaian</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$adjustment}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Total Mandays</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->total_man_days}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Alokasi Mandays untuk Tahap I Audit (Maksimal 10% dari Total)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->first_step_total_man_days}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%;">Alokasi Mandays untuk Tahap II Audit (Maksimal 90% dari Total)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%;">: {{$detail->second_step_total_man_days}}</td>
        </tr>
    </table>

    <p style="font-weight: bold;">II. HASIL PERMULAAN AUDIT DAN PENINJAUAN DOKUMEN</p><p style="font-weight: bold;">A. Penetapan Tim Audit Tahap I</p><p style="text-align:justify;">Kepala Teknik Tambang {{$detail->headCcompany->company_name ?? '-'}}. melalui Surat Pengangkatan Tim Audit nomor {{$detail->appointment_letter_number ?? '-'}} tanggal {{$detail->letter_date ?? '-'}}. telah menugaskan Tim Audit untuk Tahap Pertama Audit Internal Sistem Manajemen Keselamatan Pertambangan (Permulaan Audit, Peninjauan Dokumen, Persiapan   Audit   Lapangan) di {{$detail->auditedCompany->company_name ?? '-'}}, sebagai berikut.</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Nama</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Jabatan</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 35%; text-align: center; vertical-align: middle;">Nomor Registrasi Auditor</th>
        </tr>
        @foreach($auditors_1 as $key => $auditor)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$auditor->name}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$auditor->role->name}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 35%; vertical-align: middle;">{{$auditor->registration_number}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">B. Pelaksanaan Kontak Awal dengan Auditi</p><p style="text-align:justify;">Kontak awal dengan auditi telah dilakukan secara formal/informal dengan rincian sebagai berikut:</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse;">
        
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%;">Hari / Tanggal</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 60%;">: {{$detail->initial_contact_date ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%;">Media</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 60%;">: {{$detail->media ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%;">Perwakilan Auditi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 60%;">: {{$detail->auditi_delegation ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%;">Jabatan Perwakilan Auditi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 60%;">: {{$detail->auditi_delegation_position ?? '-'}}</td>
        </tr>
    </table>

    <p style="font-weight: bold;">C. Penentuan Kelayakan Audit</p><p style="text-align:justify;">Penentuan Kelayakan Audit Internal Sistem Manajemen Keselamatan Pertambangan dilakukan pada tanggal {{$detail->determination_of_eligibility_date ?? '-'}}, dengan hasil sebagai berikut:</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 70%; text-align: center; vertical-align: middle;">Indikator Kelayakan Audit</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 20%; text-align: center; vertical-align: middle;">Hasil Evaluasi</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">1</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Informasi untuk Pengembangan Program Audit: Profil Organisasi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->organizational_profile ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">2</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Informasi untuk Pengembangan Program Audit: Profil Risiko</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->risk_profile ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">3</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Informasi untuk Pengembangan Program Audit: Data Kinerja Keselamatan Pertambangan pada Periode Audit</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->safety_performance_data ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">4</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Kerjasama dari Auditi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->auditi_collaboration ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">5</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Ketersediaan Waktu</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->time_availability ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">6</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Ketersediaan Sumberdaya lainnya</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->other_resources_availability ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">7</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Pemenuhan Persyaratan Keselamatan dan Keamanan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->fulfillment_of_safety ?? '-'}}</td>
        </tr>

    </table>

    <p style="text-align:justify;">Dengan mempertimbangkan ketersediaan faktor-faktor tersebut di atas, maka pelaksanaan Audit Internal Sistem Manajemen Keselamatan Pertambangan di {{(in_array('Tidak Laik', [$detail->fulfillment_of_safety, $detail->other_resources_availability, $detail->time_availability, $detail->auditi_collaboration, $detail->safety_performance_data, $detail->risk_profile, $detail->organizational_profile])) ? 'Tidak Laik' : 'Laik'}} untuk dilaksanakan.</p>

    <p style="font-weight: bold;">D. Penentuan Kecukupan Dokumentasi</p><p style="text-align:justify;">Peninjauan dokumentasi Sistem Manajemen Keselamatan Pertambangan mencakup dokumen dan rekaman milik {{$detail->adequacyCompany->company_name ?? '-'}} pada periode audit, dengan memperhatikan ukuran, sifat dan kompleksitas organisasi, serta tujuan dan ruang lingkup audit terhadap 7 (tujuh) elemen Sistem Manajemen Keselamatan Pertambangan sesuai Lampiran II Keputusan Direktur Jenderal Mineral dan Batubara Nomor 185.K/37.04/DJB/2019.</p><p>Hasil peninjauan dokumen Sistem Manajemen Keselamatan Pertambangan {{$detail->adequacyCompany->company_name ?? '-'}} sebagai berikut:</p>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 70%; text-align: center; vertical-align: middle;">Peninjauan Dokumentasi</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 20%; text-align: center; vertical-align: middle;">Hasil Evaluasi</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">1</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen I Kebijakan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_1 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">2</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen II Perencanaan</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_2 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">3</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen III Organisasi dan Personel</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_3 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">4</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen IV Implementasi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_4 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">5</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen V Pemantauan, Evaluasi, dan Tindak Lanjut</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_5 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">6</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen VI Dokumentasi</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_6 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 10%; text-align: center; vertical-align: middle;">7</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 70%; vertical-align: middle;">Elemen VII Tinjauan Manajemen dan Peningkatan Kinerja</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 20%; vertical-align: middle; text-align: center;">{{$detail->element_7 ?? '-'}}</td>
        </tr>

    </table>

    <p style="text-align: justify;">Berdasarkan hasil evaluasi tersebut di atas, maka pelaksanaan Audit Internal Sistem Manajemen Keselamatan Pertambangan di {{$detail->adequacyCompany->company_name ?? '-'}} {{(in_array('Tidak Cukup', [$detail->element_1, $detail->element_2, $detail->element_3, $detail->element_4, $detail->element_5, $detail->element_6, $detail->element_7])) ? 'belum dapat dilanjutkan*) ke tahap berikutnya hingga Auditi melengkapi dokumen berikut:' : 'dapat dilanjutkan*) ke tahap berikutnya'}} belum dapat dilanjutkan*) ke tahap berikutnya hingga Auditi melengkapi dokumen berikut:</p>
    @if((in_array('Tidak Cukup', [$detail->element_1, $detail->element_2, $detail->element_3, $detail->element_4, $detail->element_5, $detail->element_6, $detail->element_7])))<ol type="1">@foreach($complementary_documents as $complementary_document)<li>{{$complementary_document->document}}</li>@endforeach</ol>
    @endif

    <p style="font-weight: bold;">III. PERSIAPAN AUDIT LAPANGAN</p><p style="font-weight: bold;">A. Penetapan Tim Audit Tahap II</p><p style="text-align:justify;">Kepala Teknik Tambang {{$detail->audited2Company->company_name ?? '-'}}. melalui Surat Pengangkatan Tim Audit nomor {{$detail->appointment_letter_number ?? '-'}} tanggal {{$detail->letter_date ?? '-'}}. telah menugaskan Tim Audit untuk Tahap Kedua Audit Internal Sistem Manajemen Keselamatan Pertambangan (Pelaksanaan Rapat Pembukaan, Pengumpulan dan Verifikasi Informasi, Perumusan Temuan Audit, Penyiapan Kesimpulan Audit, Pelaksanaan Rapat Penutupan), sebagai berikut:</p>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Nama</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Jabatan</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 35%; text-align: center; vertical-align: middle;">Nomor Registrasi Auditor</th>
        </tr>

        @foreach($auditors_2 as $key => $auditor)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$auditor->name}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$auditor->role->name}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 35%; vertical-align: middle;">{{$auditor->registration_number}}</td>
        </tr>
        @endforeach

    </table>

    <p style="text-align:justify;">Penugasan tersebut telah mempertimbangkan tujuan, ruang lingkup, kriteria dan perkiraan waktu audit, kompetensi tim audit secara keseluruhan yang diperlukan untuk mencapai tujuan audit, peraturan perundang-undangan yang berlaku, kebutuhan untuk menjamin keindependenan tim audit dari kegiatan yang diaudit dan untuk menghindarkan konflik kepentingan kemampuan anggota tim audit untuk berinteraksi secara efektif dengan auditi dan untuk bekerja bersama dalam tim, dan bahasa yang digunakan dalam audit, dan pemahaman terhadap karakteristik sosial dan budaya tertentu dari auditi. Seluruh auditor internal yang diangkat memiliki komitmen untuk menjaga integritas dan perilaku yang profesional, independen, jujur, dan objektif dalam pelaksanaan tugas, yang dibuktikan dengan {{$detail->proven_by ?? '-'}}</p><p>Auditor yang ditugaskan juga telah memperhatikan persyaratan yang ditetapkan pada Lampiran II Keputusan Direktur Jenderal Mineral dan Batubara nomor 185.K/37.04/DJB/2019 tentang Petunjuk Teknis Pelaksanaan Keselamatan Pertambangan dan Pelaksanaan, Penilaian, dan Pelaporan Sistem Manajemen Keselamatan Pertambangan dan Surat Edaran Direktur Teknik dan Lingkungan Mineral dan Batubara/Kepala Inspektur Tambang nomor B-7/MB.07/DBT.KP/2022 tanggal 3 Januari 2022 perihal Auditor Internal Sistem Manajemen Keselamatan Pertambangan.</p><p>Penetapan tanggung jawab Auditor ditetapkan sesuai Prosedur Audit Internal Sistem Manajemen Keselamatan Pertambangan {{$detail->audited2Company->company_name ?? '-'}} dan Surat Pengangkatan Auditor nomor {{$detail->company_form_number ?? '-'}}. tanggal {{$detail->risk_of_present_year ?? '-'}}.</p>

    <p style="font-weight: bold;">B. Penyiapan Rencana Audit</p><p style="text-align:justify;">Rencana Audit Internal Sistem Manajemen Keselamatan Pertambangan menjadi dasar kesepakatan antara klien audit, tim audit dan auditi terkait dengan pelaksanaan Audit Internal Sistem Manajemen Keselamatan Pertambangan Tahap II di {{$detail->audited2Company->company_name ?? '-'}}, yang meliputi kegiatan:</p><ol type="1"><li>Pelaksanaan Rapat Pembukaan</li><li>Pengumpulan dan Verifikasi Informasi</li><li>Perumusan Temuan Audit</li><li>Penyiapan Kesimpulan Audit</li><li>Pelaksanaan Rapat Penutupan</li></ol><p>Rencana Audit Internal Sistem Manajemen Keselamatan Pertambangan Tahap II mencakup:</p><ol type="1"><li>Penetapan Tujuan Audit</li><li>Penetapan Kriteria Audit</li><li>Penetapan Ruang Lingkup Audit</li><li>Penetapan Tanggal Pelaksanaan Audit</li><li>Penetapan Susunan Kegiatan Audit</li><li>Pembagian Tugas dan Tanggung Jawab Anggota Tim Audit</li><li>Penetapan Alokasi Sumberdaya terkait</li><li>Penetapan Metode dan Sampel Audit</li><li>Pengesahan Rencana Audit dari Kepala Teknik Tambang, Penanggung Jawab Operasional (untuk auditi yang merupakan perusahaan jasa pertambangan) dan Ketua Tim Audit</li>
    </ol><p>Rencana Audit yang memuat informasi angka nomor 1 (satu) s.d. 9 (sembilan) tersebut di atas ditetapkan secara lengkap pada Formulir Rencana Audit {{$detail->audited2Company->company_name ?? '-'}}. nomor {{$detail->company_form_number ?? '-'}}</p><p>Mempertimbangkan bahwa program Audit Internal Sistem Manajemen Keselamatan Pertambangan wajib didasarkan pada hasil penilaian risiko pada kegiatan operasional dan hasil penilaian kinerja Keselamatan Pertambangan dari Auditi, dan berikut informasi terkait dari {{$detail->audited2Company->company_name ?? '-'}} yang wajib dipertimbangkan Auditor dalam penetapan metode dan sampel khususnya sebagai critical point untuk jenis pembuktian primer:</p>
    <p style="font-weight: bold;">Data Top Risks aspek Keselamatan Pertambangan: Periode Audit {{$detail->risk_of_present_year ?? '-'}} (Risk of Present)</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Kegiatan</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Risiko</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 35%; text-align: center; vertical-align: middle;">Nilai Risiko</th>
        </tr>

        @foreach($risk_of_presents as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->activity}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->risk}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 35%; vertical-align: middle;">{{$data->risk_value}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Top Risks aspek Keselamatan Pertambangan: Rencana Kegiatan {{$detail->risk_of_future_year ?? '-'}} (Risk of Future)</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Kegiatan</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Risiko</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 35%; text-align: center; vertical-align: middle;">Nilai Risiko</th>
        </tr>

        @foreach($risk_of_futures as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->activity}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->risk}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 35%; vertical-align: middle;">{{$data->risk_value}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Faktor Penyebab Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_factor_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Faktor Penyebab Dominan</th>
        </tr>

        @foreach($trend_factors as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->factor}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Lokasi Terjadinya Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_location_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Lokasi</th>
        </tr>

        @foreach($trend_locations as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->location}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Jenis Kegiatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_activity_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Jenis Kegiatan</th>
        </tr>

        @foreach($trend_activitys as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->activity}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Jenis Jabatan terkait Kejadian Near Miss, Property Damage, Kejadian Berbahaya, dan/atau Kecelakaan di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_position_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Jenis Jabatan</th>
        </tr>

        @foreach($trend_positions as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->position}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Deviasi Keselamatan Pertambangan berdasarkan Hasil Temuan Inspeksi di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_deviation_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Deviasi Penerapan Keselamatan Pertambangan Hasil Inspeksi</th>
        </tr>

        @foreach($trend_deviations as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->deviation}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Trend Faktor Penyebab Kejadian Akibat Penyakit Tenaga Kerja dan/atau Penyakit Akibat Kerja di {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->trend_factors_causing_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Faktor Penyebab Dominan</th>
        </tr>

        @foreach($trend_factors_causings as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->causing}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Unjuk Kerja Peralatan Pertambangan {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->mining_equipment_work_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 35%; text-align: center; vertical-align: middle;">Jenis Peralatan</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Physical Availability</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 30%; text-align: center; vertical-align: middle;">Mechanical Availability</th>
        </tr>

        @foreach($mining_equipment_works as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 35%; vertical-align: middle;">{{$data->equipment}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->physical_availability}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 30%; vertical-align: middle;">{{$data->mechanical_availability}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Capaian Key Leading Indicator {{$detail->audited2Company->company_name ?? '-'}} pada Periode Audit {{$detail->key_leading_indicator_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 55%; text-align: center; vertical-align: middle;">Key Leading Indicator</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 40%; text-align: center; vertical-align: middle;">Status</th>
        </tr>

        @foreach($key_leading_indicators as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">{{$data->key_leading_indicator}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$data->status}}</td>
        </tr>
        @endforeach

    </table>

    <p style="font-weight: bold;">Data Audit Internal SMKP {{$detail->audited2Company->company_name ?? '-'}} Tahun {{$detail->internal_audit_year ?? '-'}}</p>
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 55%; text-align: center; vertical-align: middle;">Data Audit Internal {{$detail->internal_audit_year ?? '-'}}</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 40%; text-align: center; vertical-align: middle;">Keterangan</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">1</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">Capaian Nilai Audit</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$detail->data_audit_1 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">2</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Kritikal</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$detail->data_audit_2 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">3</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Mayor</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$detail->data_audit_3 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">4</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">Status Penyelesaian Tindak Lanjut Audit untuk Ketidaksesuaian Kategori Minor</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$detail->data_audit_4 ?? '-'}}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">5</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 55%; vertical-align: middle;">Catatan Hasil Evaluasi dari Instansi Pembina Sektor</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 40%; vertical-align: middle;">{{$detail->data_audit_5 ?? '-'}}</td>
        </tr>
    </table>

    <p style="font-weight: bold;">Daftar Masukan Pemangku Kepentingan terkait Audit Internal SMKP berdasarkan Komunikasi dan Konsultasi Risiko yang dilakukan {{$detail->audited2Company->company_name ?? '-'}} Tahun {{$detail->previous_period_year ?? '-'}}</p><p>Masukan dari Pemangku Kepentingan yang perlu diperhatikan, antara lain namun tidak terbatas kepada :</p>
    <ol>
        <li>Perintah, Larangan, Petunjuk dari Inspektur Tambang yang dituliskan di Buku Tambang</li><li>Masukan dari Kegiatan Pembinaan dari Direktorat Teknik dan Lingkungan Mineral dan Batubara, seperti Verifikasi Audit Internal SMKP {{$detail->internal_audit_verification_year ?? '-'}}, Verifikasi Penilaian Prestasi Pengelolaan Keselamatan Pertambangan {{$detail->achievement_assessment_verification_year ?? '-'}}, dan lainnya</li><li>Masukan dari Komite Keselamatan Pertambangan</li><li>Masukan dari pemegang IUP selaku pemberi kerja (bagi pemegang IUJP)</li><li>Masukan dari Serikat Pekerja</li><li>Evaluasi terhadap Trend Pengaduan dari Masyarakat</li>
    </ol>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">No</th>
            <th style="font-weight: bold; border: 1px solid #ddd; padding: 10px; width: 95%; text-align: center; vertical-align: middle;">Masukan dari Pemangku Kepentingan</th>
        </tr>

        @foreach($stakeholders as $key => $data)
        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 5%; text-align: center; vertical-align: middle;">{{$key+1}}</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 95%; vertical-align: middle;">{{$data->stakeholder_input}}</td>
        </tr>
        @endforeach
        
    </table>

    <p>Selain mempertimbangkan bahwa hasil penilaian risiko pada kegiatan operasional dan hasil penilaian kinerja Keselamatan Pertambangan dari Auditi, penetapan metode dan sampel juga wajib memperhatikan lesson learned dari kinerja Keselamatan Pertambangan Nasional yang disampaikan oleh instansi pembina sektor.</p>

    <p style="font-weight: bold;">C. Penyiapan Dokumen Kerja</p>
    <p>Tim Audit Internal Sistem Manajemen Keselamatan Pertambangan menyiapkan dokumen kerja yang diperlukan untuk rujukan dan untuk merekam pelaksanaan audit internal.</p><p>Dokumen kerja tersebut mencakup hal-hal sebagai berikut:</p><ol type="1"><li>Rencana Sampling yang dimuat pada Formulir Rencana Audit {{$detail->audited2Company->company_name ?? '-'}} nomor {{$detail->sampling_plan_number ?? '-'}}</li><li>Kriteria Audit yaitu Lampiran II Keputusan Direktur Jenderal Mineral dan Batubara Nomor 185.K/37.04/DJB/2019</li><li>Perangkat Penunjang Pengambilan Data sesuai kebutuhan audit seperti: Daftar Pertanyaan Wawancara Terstruktur, Daftar Periksa Observasi Objek Audit, Kuesioner Audit</li><li>Formulir Pendokumentasian Hasil Audit, antara lain:<ol type="a"><li>Formulir Kesesuaian Audit (Formulir nomor {{$detail->audit_conformity_number ?? '-'}})</li><li>Formulir Ketidaksesuaian dan Tindak Lanjut Ketidaksesuaian Audit (Formulir nomor {{$detail->audit_non_conformity_number ?? '-'}})</li><li>Formulir Rekapitulasi Ketidaksesuaian (Formulir nomor {{$detail->non_conformity_recapitulation_number ?? '-'}})</li><li>Formulir Rencana Tindak Lanjut Audit (Formulir nomor {{$detail->follow_up_plan_number ?? '-'}})</li><li>Formulir Rekomendasi dan Peluang untuk Perbaikan (Formulir nomor {{$detail->recommendation_number ?? '-'}})</li></ol></li><li>Formulir Rekaman Rapat nomor {{$detail->meeting_recording_number ?? '-'}}</li></ol>

    <p style="font-weight: bold;">IV. PENUTUP</p>
    <p>Berita Acara Hasil Pelaksanaan Tahapan Awal Audit Internal Sistem Manajemen Keselamatan Pertambangan ini dibuat pada tanggal {{$detail->initial_implementation_date ?? '-'}}, dan diketahui oleh klien audit, tim audit, serta auditor</p>

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th colspan="3" style="font-weight: bold; border: 1px solid #ddd; padding: 0px; width: 100%; text-align: center; vertical-align: middle;">Ketua Tim Audit</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 34%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Nama)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Tanda Tangan)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 34%; text-align: center; vertical-align: bottom;">(Tanggal)</td>
        </tr>
        
    </table>

    @if(isset($audit->company->type))
    @if($audit->company->type != 'INTERNAL')
    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th colspan="3" style="font-weight: bold; border: 1px solid #ddd; padding: 0px; width: 100%; text-align: center; vertical-align: middle;">Penanggung Jawab Operasional dari Auditi</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 34%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Nama)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Tanda Tangan)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 34%; text-align: center; vertical-align: bottom;">(Tanggal)</td>
        </tr>
        
    </table>
    @endif
    @endif

    <table style="width: 100%; margin: 20px auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th colspan="3" style="font-weight: bold; border: 1px solid #ddd; padding: 0px; width: 100%; text-align: center; vertical-align: middle;">Kepala Teknik Tambang</th>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 33%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
            <td style="border: 1px solid #ddd; width: 34%; text-align: center; vertical-align: bottom; height: 100px; font-size: 50px; color: white;">S</td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Nama)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 33%; text-align: center; vertical-align: bottom;">(Tanda Tangan)</td>
            <td style="border: 1px solid #ddd; padding: 10px; width: 34%; text-align: center; vertical-align: bottom;">(Tanggal)</td>
        </tr>
        
    </table>
</div>
    
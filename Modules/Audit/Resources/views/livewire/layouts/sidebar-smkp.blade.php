<div class="content-sidebar">
    <ul class="list-unstyled d-flex flex-column" style="border-color: #0b2e13!important;">
       {{-- @if (auth()->user()->can('Audit - Detail SMKP Dashboard'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.dashboard',['id'=>$id])}}"
               class="link-sidebar {{$smkpDetail??""}} text-decoration-none p-3 d-flex">Dashboard</a>
        </li>
        @endif --}}
        @if (auth()->user()->can('Audit - Detail SMKP'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.index',['id'=>$id])}}"
               class="link-sidebar {{$smkpDetail??""}} text-decoration-none p-3 d-flex">Informasi Umum</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Notice Letter'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.notice-letter.index',['id'=>$id])}}"
               class="link-sidebar {{$noticeLetter??""}} text-decoration-none p-3 d-flex">1. Surat Pemberitahuan Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Audit Plan'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.audit-plan',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">2. Rencana Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Implementation Schedule'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.implementation-schedule.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">3. Susunan Kegiatan Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Implementation Report'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.implementation-report.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">4. Berita Acara Hasil Pelaksanaan Tahapan Awal Audit
                Internal SMKP</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Method and Sample'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.method-and-sample.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">5. Metode dan Sample Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Criteria Audit'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.criteria-audit.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">6. Kriteria Audit SMKP</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Criteria Audit Confirmance'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.criteria-audit-confirmance.index',['id'=>$id])}}"
            class="link-sidebar text-decoration-none p-3 d-flex">7. Kesesuaian Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Criteria Audit Non Confirmance'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.criteria-audit-non-conformance.index',['id'=>$id])}}" class="link-sidebar text-decoration-none p-3 d-flex">8. Rekapitulasi Ketidaksesuaian Audit</a>
        </li>
        @endif
        <!-- <li class="item-sidebar border-bottom">
            <a href="" class="link-sidebar text-decoration-none p-3 d-flex">Ketidaksesuaian dan Tindak Lanjut
                Audit</a>
        </li> -->
        @if (auth()->user()->can('Audit - Detail SMKP Criteria Audit Non Confirmance Fix Plan'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.criteria-audit-non-conformance.fix-plan',['id'=>$id])}}" class="link-sidebar text-decoration-none p-3 d-flex">9. Rencana Tindak Lanjut
                Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Audit Fix Recomendation'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.fix-recommendation-audit.index',['id'=>$id])}}"
            class="link-sidebar text-decoration-none p-3 d-flex">10. Formulir Rekomendasi dan OFI</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Opening Attendance'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.opening-attendance.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">11. Daftar Hadir Pertemuan Pembukaan Audit</a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Closing Attendance'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.closing-attendance.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">
                12. Daftar Hadir Pertemuan Penutupan Audit
            </a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Audit Response'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.response-audit.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">
                13. Respon Terhadap Pelaksanaan Audit
            </a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Report Result'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.report-result.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">
                14. Laporan Hasil Audit SMKP
            </a>
        </li>
        @endif
        @if (auth()->user()->can('Audit - Detail SMKP Another Attachment'))
        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.another-attachment.index',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">
                15. Lampiran Lainnya
            </a>
        </li>
        @endif

        <li class="item-sidebar border-bottom">
            <a href="{{route('audit::smkp.detail.master-location',['id'=>$id])}}"
               class="link-sidebar text-decoration-none p-3 d-flex">
                Master Lokasi
            </a>
        </li>
    </ul>
    <br><br>
</div><!-- /.content-sidebar -->

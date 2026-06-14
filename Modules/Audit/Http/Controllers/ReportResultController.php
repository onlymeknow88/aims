<?php

namespace Modules\Audit\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audit\Entities\AuditClosingAttendance;
use Modules\Audit\Entities\AuditReportResult;

class ReportResultController extends Controller
{
    public function download($id,$noticeID)
    {
        $noticeLetter = AuditReportResult::where('audit_id',$id)->findOrFail($noticeID);
        return \Storage::download($noticeLetter->url);
    }
}

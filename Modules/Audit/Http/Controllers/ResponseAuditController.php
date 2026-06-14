<?php

namespace Modules\Audit\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audit\Entities\AuditResponseAudit;

class ResponseAuditController extends Controller
{
    public function download($id,$noticeID)
    {
        $noticeLetter = AuditResponseAudit::where('audit_id',$id)->findOrFail($noticeID);
        return \Storage::download($noticeLetter->url);
    }
}

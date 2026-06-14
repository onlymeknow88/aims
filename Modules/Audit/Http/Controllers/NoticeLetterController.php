<?php

namespace Modules\Audit\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Audit\Entities\AuditNoticeLetter;

class NoticeLetterController extends Controller
{
    public function download($id,$noticeID)
    {
        $noticeLetter = AuditNoticeLetter::where('audit_id',$id)->findOrFail($noticeID);
        return \Storage::download($noticeLetter->url);
    }
}

<?php

namespace Modules\Audit\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Audit\Entities\AuditResponseAudit;
use PDF;


class TestController extends Controller
{

    public function info(){

        // return "INFO TEST CONTROLLER";
        return view('audit::livewire.iso45001.criteria-audit.index'); 
    }

    public function pdf(){

        // $pdf = PDF::loadview('audit::form_pdf',[]);
    	// return $pdf->download('test-form-pdf.pdf');

        // return "TEST GENERATE PDF";

        return view('audit::form_pdf',[])->layout('audit::livewire.layouts.app');
    }

    public function download($id,$noticeID)
    {
        $noticeLetter = AuditResponseAudit::where('audit_smkp_id',$id)->findOrFail($noticeID);
        return \Storage::download($noticeLetter->url);
    }
}
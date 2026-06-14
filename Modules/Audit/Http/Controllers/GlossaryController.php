<?php

namespace Modules\Audit\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\Audit\Entities\AuditGlossary;

class GlossaryController extends Controller
{
    public function download($id)
    {
        $glossary = AuditGlossary::findOrFail($id);
        return \Storage::download($glossary->url);
    }
}

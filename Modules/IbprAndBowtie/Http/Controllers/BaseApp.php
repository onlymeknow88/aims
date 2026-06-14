<?php

namespace Modules\IbprAndBowtie\Http\Controllers;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\Iadl;
use App\Models\IbprBowty\Ibpr;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BaseApp extends Controller
{
    public $info_ibpr = 0;

    public function getNotifInfo(Request $request) {
        $notif_ibpr = Ibpr::where('status', '!=', 'Disetujui')
                            ->where('ccow_id', '!=', null)
                            ->where('status', '!=', 'DRAFT')
                            ->count();
        $notif_ibpr_draft = Ibpr::where('status', '=', 'DRAFT')
                            ->where('ccow_id', '!=', null)->count();
        $notif_iadl = Iadl::where('status', '!=', 'Disetujui')
                            ->where('ccow_id', '!=', null)
                            ->where('status', '!=', 'DRAFT')
                            ->count();
        $notif_iadl_draft = Iadl::where('status', '=', 'DRAFT')
                            ->where('ccow_id', '!=', null)->count();

        $notif_bowtie_done = Bowtie::where('status', 'Disetujui')->count();
        $notif_bowtie = Bowtie::where('status', '!=', 'Disetujui')
                            ->where('ccow_id', '!=', null)
                            ->where('status', '!=', 'Draft')
                            ->where('status', '!=', 'Temporary')
                            ->count();
        $notif_bowtie_draft = Bowtie::where('status', '=', 'Draft')
                            ->where('ccow_id', '!=', null)->count();
        $notif_bowtie_temporary = Bowtie::where('status', '=', 'Temporary')->count();
        $data = [
            'notif_ibpr' => $notif_ibpr,
            'notif_ibpr_draft' => $notif_ibpr_draft,
            'notif_iadl' => $notif_iadl,
            'notif_iadl_draft' => $notif_iadl_draft,
            'notif_bowtie' => $notif_bowtie,
            'notif_bowtie_draft' => $notif_bowtie_draft,
            'notif_bowtie_temporary' => $notif_bowtie_temporary
        ];

        return response()->json($data);
    }
}

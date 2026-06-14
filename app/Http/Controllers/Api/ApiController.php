<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MainDashboard\NewsAndUpdate;
use App\Models\MainDashboard\Attachment;

class ApiController extends Controller
{
    public function AttachmentIndex()
    {
        $attc =  Attachment::selectRaw("
            name,
            url,
            created_at")
            ->get()
            ->map(function ($item, $index) {
                return [
                    'name' => $item->name,
                    'url' => $item->url,
                    'created_at' => date('Y-m-d H:i:s', strtotime($item->created_at))
                ];
            });
        return $attc;
    }

    public function tes()
    {
        //
    }
}

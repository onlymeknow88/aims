<?php

namespace App\Http\Controllers;

use App\Models\DocumentSystem\Document;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function invitedPeopleList(Request $request)
    {
        $data = Cache::get('peoples');
        if ($data) {
            $data = collect($data)->map(function ($item) {
                return [
                    'id' => $item->id,
                    'label' => $item->email,
                ];
            })->toArray();
        } else {
            $department_id = $request->department_id;
            if ($department_id) {

            }
            $peoples = User::select('id', 'email')
                ->where('department_id', $department_id)
                ->get();
            $data = Cache::remember('peoples', 600, function () use ($peoples) {
                return collect($peoples)->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'label' => $item->email,
                    ];
                })->all();
            });
        }

        return response()->json($data);
    }

    public function saveFile(Request $request)
    {
        return response()->json($request->file);
    }

    public function email()
    {
        $document = Document::with([
                'peoples:document_id,email',
                'attachments:document_id,path',
                'user:id,name'
            ])
            ->latest()->first();

        $peoples = $document->peoples;
        $documents = $document->attachments;
        $payload = [
            'type' => 'new_document',
            'receiver' => collect($peoples)->pluck('email')->all(),
            'title' => $document->title,
            'pic' => $document->user->name,
            'has_attachments' => true,
            'files' => collect($documents)->pluck('path')->all(),
        ];

        $email = new EmailService();
        $send = $email->sendEmail($payload);

        return $send;
    }
}

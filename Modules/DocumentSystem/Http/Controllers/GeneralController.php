<?php

namespace Modules\DocumentSystem\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentCode;
use App\Models\User;
use Modules\DocumentSystem\Entities\ActivityAttachment;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\DocumentSystem\Entities\Document;

class GeneralController extends Controller
{
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
            $peoples = User::select('id', 'email')
                ->where('department_id', $request->input('department_id'))
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

    public function autocompleteSop(Request $request)
    {
        $department = DepartmentCode::find($request->input('department_id'));
        $dept_code = $department->code;
        $search = $request->term;
        $prefix = $department->department->company->document_code . '-' . $dept_code . '-';

        $documents = Document::where('department_id', $department->department_id)
            ->where('status', Document::ACTIVE)
            ->where('prefix_code', $prefix)
            ->where('sop_number', $search)
            ->where('parent_document', null)
            ->get();

        $documents = collect($documents)->map(function ($item) {
            return [
                'id' => $item->id,
                'label' => $item->prefix_code . $item->sop_number,
            ];
        })->all();
        $documents = array_map("unserialize", array_unique(array_map("serialize", $documents)));
        return response()->json($documents);
    }

    public function getAttachmentSasUri($id, Request $request)
    {
        try {
            $type = $request->query('type', 'document'); // document, jsa, ptw, activity
            
            if ($type === 'activity') {
                $attachment = ActivityAttachment::with(['activity:id,document_id', 'activity.document:id'])->find($id);
            } elseif ($type === 'jsa') {
                $attachment = \Modules\DocumentSystem\Entities\JsaDocumentAttachment::find($id);
            } elseif ($type === 'ptw') {
                $attachment = \Modules\DocumentSystem\Entities\PtwDocumentAttachment::find($id);
            } else {
                $attachment = \Modules\DocumentSystem\Entities\Attachment::find($id);
            }

            if (!$attachment) {
                return response()->json(['error' => 'Attachment not found'], 404);
            }

            $url = $attachment->blob_url ?? $attachment->path ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        // Normalize double slashes and decode %20/URL-encoding so Azure can match the actual filename
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));
                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }
            } else {
                // If it is local storage file path, return asset URL
                if ($type === 'activity') {
                    $docId = $attachment->activity->document->id ?? null;
                    $url = asset('storage/document_systems/' . $docId . '/revision/' . $attachment->name);
                } elseif ($type === 'ptw') {
                    $url = asset('storage/ptw/' . $attachment->document_id . '/' . $attachment->file_name);
                } else {
                    $url = asset('storage/document_systems/' . $attachment->document_id . '/' . $attachment->file_name);
                }
            }

            $fileName = $type === 'activity' ? $attachment->name : $attachment->file_name;

            return response()->json([
                'url' => $url,
                'file_name' => $fileName,
                'extension' => strtolower(pathinfo($fileName, PATHINFO_EXTENSION))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function previewAttachment($id, Request $request)
    {
        try {
            $type = $request->query('type', 'document'); // document, jsa, ptw, activity
            
            if ($type === 'activity') {
                $attachment = ActivityAttachment::with(['activity:id,document_id', 'activity.document:id'])->find($id);
            } elseif ($type === 'jsa') {
                $attachment = \Modules\DocumentSystem\Entities\JsaDocumentAttachment::find($id);
            } elseif ($type === 'ptw') {
                $attachment = \Modules\DocumentSystem\Entities\PtwDocumentAttachment::find($id);
            } else {
                $attachment = \Modules\DocumentSystem\Entities\Attachment::find($id);
            }

            if (!$attachment) {
                abort(404, 'Attachment not found');
            }

            $url = $attachment->blob_url ?? $attachment->path ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        // Normalize double slashes and decode %20/URL-encoding so Azure can match the actual filename
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        \Illuminate\Support\Facades\Log::debug('previewAttachment: calling GetBlobSasUri', [
                            'container' => $container,
                            'filePath'  => $filePath,
                        ]);

                        $sasResult = GetBlobSasUri($container, $filePath, 15);

                        \Illuminate\Support\Facades\Log::debug('previewAttachment: GetBlobSasUri result', [
                            'sasResult' => $sasResult,
                        ]);

                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        } else {
                            \Illuminate\Support\Facades\Log::warning('previewAttachment: SAS URI kosong/null, fallback ke plain blob URL', [
                                'blob_url'  => $attachment->blob_url,
                                'sasResult' => $sasResult,
                            ]);
                        }
                    }
                }
            } else {
                // Local fallback
                if ($type === 'activity') {
                    $docId = $attachment->activity->document->id ?? null;
                    $clean_path = 'document_systems/' . $docId . '/revision/' . $attachment->name;
                } elseif ($type === 'ptw') {
                    $clean_path = 'ptw/' . $attachment->document_id . '/' . $attachment->file_name;
                } else {
                    $clean_path = 'document_systems/' . $attachment->document_id . '/' . $attachment->file_name;
                }
                
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($clean_path)) {
                    $mime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($clean_path);
                    return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($clean_path), [
                        'Content-Type' => $mime,
                        'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
                    ]);
                }
                abort(404, 'Local file not found');
            }

            // Stream from remote URL
            $client = new \GuzzleHttp\Client;
            $response = $client->request('GET', $url, [
                'stream' => true,
            ]);

            $body = $response->getBody();
            $contentType = $response->getHeaderLine('Content-Type');

            // Force PDF / Image content type if needed
            $fileName = $type === 'activity' ? $attachment->name : $attachment->file_name;
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                $contentType = 'application/pdf';
            } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $contentType = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);
            }

            return response()->stream(function () use ($body) {
                while (!$body->eof()) {
                    echo $body->read(1024 * 8);
                    flush();
                }
            }, 200, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Preview error: ' . $e->getMessage());
            abort(500, 'Failed to preview file');
        }
    }
}


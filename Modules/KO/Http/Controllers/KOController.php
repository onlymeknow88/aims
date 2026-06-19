<?php

namespace Modules\KO\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KOController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('ko::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ko::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('ko::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ko::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function getAttachmentSasUri(Request $request)
    {
        try {
            $path = $request->query('path');
            if (!$path) {
                return response()->json(['error' => 'Path not provided'], 400);
            }

            $storageUrl = asset('storage/');
            if (strpos($path, $storageUrl) === 0) {
                $path = substr($path, strlen($storageUrl));
            }
            $path = ltrim($path, '/');

            $url = $path;
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $attachmentRecord = \Modules\KO\Entities\KoIssueReportAttachment::where('attachment', $path)->first()
                    ?? \Modules\KO\Entities\KoQrRequestFiles::where('attachment', $path)->first();

                if ($attachmentRecord && $attachmentRecord->blob_url) {
                    $url = $attachmentRecord->blob_url;
                } else {
                    $fields = ['stnk', 'nota_pajak', 'surat_pengantar', 're_manufacture', 'oem', 'dokumen_sertifikat', 'inspeksi_p3k', 'kir', 'uji_pjit', 'pra_komisioning', 'setting_radio', 'slo', 'komisioning_internal', 'com'];
                    $query = \Modules\KO\Entities\KoAttachment::query();
                    foreach ($fields as $field) {
                        $query->orWhere($field, $path);
                    }
                    $koAttachment = $query->first();
                    if ($koAttachment) {
                        foreach ($fields as $field) {
                            if ($koAttachment->$field === $path || (filter_var($koAttachment->$field, FILTER_VALIDATE_URL) && strpos($koAttachment->$field, $path) !== false)) {
                                $url = $koAttachment->$field;
                                break;
                            }
                        }
                    }
                }
            }

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $urlPath = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $urlPath, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));
                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }
            } else {
                $url = asset('storage/' . $url);
            }

            $fileName = basename($path);

            return response()->json([
                'url' => $url,
                'file_name' => $fileName,
                'extension' => strtolower(pathinfo($fileName, PATHINFO_EXTENSION))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function previewAttachment(Request $request)
    {
        try {
            $path = $request->query('path');
            if (!$path) {
                abort(400, 'Path not provided');
            }

            $storageUrl = asset('storage/');
            if (strpos($path, $storageUrl) === 0) {
                $path = substr($path, strlen($storageUrl));
            }
            $path = ltrim($path, '/');

            $url = $path;
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $attachmentRecord = \Modules\KO\Entities\KoIssueReportAttachment::where('attachment', $path)->first()
                    ?? \Modules\KO\Entities\KoQrRequestFiles::where('attachment', $path)->first();

                if ($attachmentRecord && $attachmentRecord->blob_url) {
                    $url = $attachmentRecord->blob_url;
                } else {
                    $fields = ['stnk', 'nota_pajak', 'surat_pengantar', 're_manufacture', 'oem', 'dokumen_sertifikat', 'inspeksi_p3k', 'kir', 'uji_pjit', 'pra_komisioning', 'setting_radio', 'slo', 'komisioning_internal', 'com'];
                    $query = \Modules\KO\Entities\KoAttachment::query();
                    foreach ($fields as $field) {
                        $query->orWhere($field, $path);
                    }
                    $koAttachment = $query->first();
                    if ($koAttachment) {
                        foreach ($fields as $field) {
                            if ($koAttachment->$field === $path || (filter_var($koAttachment->$field, FILTER_VALIDATE_URL) && strpos($koAttachment->$field, $path) !== false)) {
                                $url = $koAttachment->$field;
                                break;
                            }
                        }
                    }
                }
            }

            $fileName = basename($path);

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $urlPath = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $urlPath, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));
                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }

                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $client = new \GuzzleHttp\Client;
                $response = $client->request('GET', $url, ['stream' => true]);
                $body = $response->getBody();
                $contentType = $response->getHeaderLine('Content-Type');

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
                    'Content-Type'        => $contentType,
                    'Content-Disposition' => 'inline; filename="' . $fileName . '"',
                    'Cache-Control'       => 'no-cache, no-store, must-revalidate',
                ]);
            }

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                $mime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($path);
                return response()->file(\Illuminate\Support\Facades\Storage::disk('public')->path($path), [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                ]);
            }

            abort(404, 'File not found locally');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('previewAttachment error: ' . $e->getMessage());
            abort(500, 'Failed to preview file');
        }
    }
}

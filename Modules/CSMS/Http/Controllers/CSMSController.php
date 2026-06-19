<?php

namespace Modules\CSMS\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\CSMS\Entities\CsmsChecklistAttacment;
use Modules\CSMS\Entities\CsmsPjoFile;
use Modules\CSMS\Entities\CsmsMemoKttFile;
use Modules\CSMS\Entities\CsmsLetterFile;

class CSMSController extends Controller
{
    public function previewFile($id, Request $request)
    {
        try {
            $type = $request->query('type', 'checklist');
            $attachment = null;

            if ($id && $id != 0) {
                if ($type === 'pjo') {
                    $attachment = CsmsPjoFile::find($id);
                } elseif ($type === 'memo') {
                    $attachment = CsmsMemoKttFile::find($id);
                } elseif ($type === 'letter') {
                    $attachment = CsmsLetterFile::find($id);
                } else {
                    $attachment = CsmsChecklistAttacment::find($id);
                }
            }

            if (!$attachment) {
                $pathParam = $request->query('path');
                if ($pathParam) {
                    $storageUrl = asset('storage/');
                    if (strpos($pathParam, $storageUrl) === 0) {
                        $pathParam = substr($pathParam, strlen($storageUrl));
                    }
                    $pathParam = ltrim($pathParam, '/');
                    $decodedPath = urldecode($pathParam);

                    if ($type === 'pjo') {
                        $attachment = CsmsPjoFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } elseif ($type === 'memo') {
                        $attachment = CsmsMemoKttFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } elseif ($type === 'letter') {
                        $attachment = CsmsLetterFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } else {
                        $attachment = CsmsChecklistAttacment::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    }
                }
            }

            if (!$attachment) {
                abort(404, 'Attachment not found');
            }

            $url = $attachment->blob_url ?? $attachment->file ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }

                $fileName = basename($attachment->file);
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

            $clean_path = $attachment->file;
            if (Storage::disk('public')->exists($clean_path)) {
                $mime = Storage::disk('public')->mimeType($clean_path);
                return response()->file(Storage::disk('public')->path($clean_path), [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
                ]);
            }

            abort(404, 'File not found locally');

        } catch (\Exception $e) {
            Log::error('previewFile error: ' . $e->getMessage());
            abort(500, 'Failed to preview file');
        }
    }

    public function getFileSasUri($id, Request $request)
    {
        try {
            $type = $request->query('type', 'checklist');
            $attachment = null;

            if ($id && $id != 0) {
                if ($type === 'pjo') {
                    $attachment = CsmsPjoFile::find($id);
                } elseif ($type === 'memo') {
                    $attachment = CsmsMemoKttFile::find($id);
                } elseif ($type === 'letter') {
                    $attachment = CsmsLetterFile::find($id);
                } else {
                    $attachment = CsmsChecklistAttacment::find($id);
                }
            }

            if (!$attachment) {
                $pathParam = $request->query('path');
                if ($pathParam) {
                    $storageUrl = asset('storage/');
                    if (strpos($pathParam, $storageUrl) === 0) {
                        $pathParam = substr($pathParam, strlen($storageUrl));
                    }
                    $pathParam = ltrim($pathParam, '/');
                    $decodedPath = urldecode($pathParam);

                    if ($type === 'pjo') {
                        $attachment = CsmsPjoFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } elseif ($type === 'memo') {
                        $attachment = CsmsMemoKttFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } elseif ($type === 'letter') {
                        $attachment = CsmsLetterFile::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    } else {
                        $attachment = CsmsChecklistAttacment::where('file', $pathParam)
                            ->orWhere('file', $decodedPath)
                            ->orWhere('blob_url', $pathParam)
                            ->orWhere('blob_url', urldecode($pathParam))
                            ->first();
                    }
                }
            }

            if (!$attachment) {
                return response()->json(['error' => 'Attachment not found'], 404);
            }

            $url = $attachment->blob_url ?? $attachment->file ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
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
                $url = asset('storage/' . $attachment->file);
            }

            $fileName = basename($attachment->file);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            return response()->json([
                'url'       => $url,
                'extension' => $ext,
                'fileName'  => $fileName,
            ]);

        } catch (\Exception $e) {
            Log::error('getFileSasUri error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate SAS URI'], 500);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('csms::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('csms::create');
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
        return view('csms::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('csms::edit');
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
}

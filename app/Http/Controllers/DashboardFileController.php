<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\MainDashboard\Slideshow;
use App\Models\MainDashboard\Banner;
use App\Models\MainDashboard\Attachment;
use App\Models\MainDashboard\NewsAndUpdate;
use App\Models\MainDashboard\IncidentNotification;
use App\Models\MainDashboard\StrategicProject;
use App\Models\MainDashboard\K3lhActivities;

class DashboardFileController extends Controller
{
    private function getModel($id, $type)
    {
        switch ($type) {
            case 'slideshow':
                return Slideshow::find($id);
            case 'banner':
                return Banner::find($id);
            case 'attachment':
                return Attachment::find($id);
            case 'news':
            case 'news_and_update':
                return NewsAndUpdate::find($id);
            case 'incident':
            case 'incident_notification':
                return IncidentNotification::find($id);
            case 'strategic_project':
                return StrategicProject::find($id);
            case 'activities':
            case 'k3lh_activities':
                return K3lhActivities::find($id);
            default:
                return null;
        }
    }

    public function streamFile(Request $request)
    {
        try {
            $id = $request->query('id');
            $type = $request->query('type');

            if (!$id || !$type) {
                abort(400, 'Missing id or type parameters');
            }

            $model = $this->getModel($id, $type);
            if (!$model) {
                abort(404, 'Dashboard record not found');
            }

            $url = $model->blob_url ?? $model->url ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        Log::debug('streamFile (Dashboard): calling GetBlobSasUri', [
                            'container' => $container,
                            'filePath'  => $filePath,
                        ]);

                        $sasResult = GetBlobSasUri($container, $filePath, 15);
                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        }
                    }
                }

                $fileName = basename(parse_url($url, PHP_URL_PATH));
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $client = new \GuzzleHttp\Client;
                $response = $client->request('GET', $url, ['stream' => true]);
                $body = $response->getBody();
                $contentType = $response->getHeaderLine('Content-Type');

                // Force Content-Type based on extension to allow inline rendering
                if ($ext === 'pdf') {
                    $contentType = 'application/pdf';
                } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                    $contentType = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);
                } elseif (in_array($ext, ['mp4', 'mov', 'ogg', 'qt', 'webm'])) {
                    $contentType = $ext === 'mov' || $ext === 'qt' ? 'video/quicktime' : 'video/' . $ext;
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

            // Fallback to local storage
            $clean_path = $model->attc ?? $model->url;
            if ($clean_path) {
                // If it starts with /storage/ or storage/, clean it up
                if (strpos($clean_path, 'storage/') === 0) {
                    $clean_path = substr($clean_path, 8);
                } elseif (strpos($clean_path, '/storage/') === 0) {
                    $clean_path = substr($clean_path, 9);
                }
                
                if (Storage::disk('public')->exists($clean_path)) {
                    $mime = Storage::disk('public')->mimeType($clean_path);
                    return response()->file(Storage::disk('public')->path($clean_path), [
                        'Content-Type'        => $mime,
                        'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
                    ]);
                }
            }

            abort(404, 'File not found locally');

        } catch (\Exception $e) {
            Log::error('streamFile (Dashboard) error: ' . $e->getMessage());
            abort(500, 'Failed to stream file');
        }
    }
}

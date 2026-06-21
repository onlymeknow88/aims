<?php

namespace Modules\Audit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Audit\Entities\AuditNoticeLetter;
use Modules\Audit\Entities\AuditOpeningAttendance;
use Modules\Audit\Entities\AuditClosingAttendance;
use Modules\Audit\Entities\AuditResponseAudit;
use Modules\Audit\Entities\AuditReportResult;
use Modules\Audit\Entities\AuditAnotherAttachment;
use Modules\Audit\Entities\AuditGlossary;

class AuditFileController extends Controller
{
    private function getAttachmentModel($id, $type)
    {
        switch ($type) {
            case 'notice-letter':
            case 'notice_letter':
                return AuditNoticeLetter::find($id);
            case 'opening-attendance':
            case 'opening_attendance':
                return AuditOpeningAttendance::find($id);
            case 'closing-attendance':
            case 'closing_attendance':
                return AuditClosingAttendance::find($id);
            case 'response-audit':
            case 'response_audit':
                return AuditResponseAudit::find($id);
            case 'report-result':
            case 'report_result':
                return AuditReportResult::find($id);
            case 'another-attachment':
            case 'another_attachment':
                return AuditAnotherAttachment::find($id);
            case 'glossary':
                return AuditGlossary::find($id);
            default:
                return null;
        }
    }

    private function findAttachmentByPath($pathParam, $type)
    {
        $storageUrl = asset('storage/');
        if (strpos($pathParam, $storageUrl) === 0) {
            $pathParam = substr($pathParam, strlen($storageUrl));
        }
        $pathParam = ltrim($pathParam, '/');
        $decodedPath = urldecode($pathParam);

        $query = null;
        switch ($type) {
            case 'notice-letter':
            case 'notice_letter':
                $query = AuditNoticeLetter::query();
                break;
            case 'opening-attendance':
            case 'opening_attendance':
                $query = AuditOpeningAttendance::query();
                break;
            case 'closing-attendance':
            case 'closing_attendance':
                $query = AuditClosingAttendance::query();
                break;
            case 'response-audit':
            case 'response_audit':
                $query = AuditResponseAudit::query();
                break;
            case 'report-result':
            case 'report_result':
                $query = AuditReportResult::query();
                break;
            case 'another-attachment':
            case 'another_attachment':
                $query = AuditAnotherAttachment::query();
                break;
            case 'glossary':
                $query = AuditGlossary::query();
                break;
        }

        if ($query) {
            return $query->where('url', $pathParam)
                ->orWhere('url', $decodedPath)
                ->orWhere('blob_url', $pathParam)
                ->orWhere('blob_url', urldecode($pathParam))
                ->first();
        }

        return null;
    }

    public function previewFile($id, Request $request)
    {
        try {
            $type = $request->query('type', 'notice-letter');
            $attachment = null;

            if ($id && $id != 0) {
                $attachment = $this->getAttachmentModel($id, $type);
            }

            if (!$attachment) {
                $pathParam = $request->query('path');
                if ($pathParam) {
                    $attachment = $this->findAttachmentByPath($pathParam, $type);
                }
            }

            if (!$attachment) {
                abort(404, 'Attachment not found');
            }

            $url = $attachment->blob_url ?? $attachment->url ?? '';

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'blob.core.windows.net') !== false) {
                    $parsedUrl = parse_url($url);
                    $path = ltrim($parsedUrl['path'] ?? '', '/');
                    $parts = explode('/', $path, 2);
                    if (count($parts) === 2) {
                        $container = $parts[0];
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        Log::debug('previewFile (Audit): calling GetBlobSasUri', [
                            'container' => $container,
                            'filePath'  => $filePath,
                        ]);

                        $sasResult = GetBlobSasUri($container, $filePath, 15);

                        Log::debug('previewFile (Audit): GetBlobSasUri result', [
                            'sasResult' => $sasResult,
                        ]);

                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        } else {
                            Log::warning('previewFile (Audit): SAS URI kosong/null, fallback ke plain blob URL', [
                                'blob_url'  => $attachment->blob_url,
                                'sasResult' => $sasResult,
                            ]);
                        }
                    }
                }

                // Stream from remote URL using GuzzleHttp (chunked, no buffering)
                $fileName = $attachment->original_name ?? basename($attachment->url);
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $client = new \GuzzleHttp\Client;
                $response = $client->request('GET', $url, ['stream' => true]);
                $body = $response->getBody();
                $contentType = $response->getHeaderLine('Content-Type');

                // Force Content-Type based on extension so browser can render inline
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

            // Local storage fallback using Storage::disk
            $clean_path = $attachment->url;
            if (Storage::disk('public')->exists($clean_path)) {
                $mime = Storage::disk('public')->mimeType($clean_path);
                return response()->file(Storage::disk('public')->path($clean_path), [
                    'Content-Type'        => $mime,
                    'Content-Disposition' => 'inline; filename="' . basename($clean_path) . '"',
                ]);
            }

            abort(404, 'File not found locally');

        } catch (\Exception $e) {
            Log::error('previewFile (Audit) error: ' . $e->getMessage());
            abort(500, 'Failed to preview file');
        }
    }

    public function getFileSasUri($id, Request $request)
    {
        try {
            $type = $request->query('type', 'notice-letter');
            $attachment = null;

            if ($id && $id != 0) {
                $attachment = $this->getAttachmentModel($id, $type);
            }

            if (!$attachment) {
                $pathParam = $request->query('path');
                if ($pathParam) {
                    $attachment = $this->findAttachmentByPath($pathParam, $type);
                }
            }

            if (!$attachment) {
                return response()->json(['error' => 'Attachment not found'], 404);
            }

            $url = $attachment->blob_url ?? $attachment->url ?? '';

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
                // If local storage path, return asset URL
                $url = asset('storage/' . $attachment->url);
            }

            $fileName = $attachment->original_name ?? basename($attachment->url);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            return response()->json([
                'url'       => $url,
                'extension' => $ext,
                'fileName'  => $fileName,
            ]);

        } catch (\Exception $e) {
            Log::error('getFileSasUri (Audit) error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate SAS URI'], 500);
        }
    }
}

<?php

namespace Modules\FieldLeadership\Http\Controllers\General;

use App\Enums\CompanyType;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\FieldLeadership\Transformers\General\AreaLocationResource;
use Modules\FieldLeadership\Transformers\General\AreaManagerResource;
use Modules\FieldLeadership\Transformers\General\CompanyResource;
use Modules\FieldLeadership\Transformers\General\DepartmentResource;
use Modules\FieldLeadership\Transformers\General\EmployeeResource;
use Modules\FieldLeadership\Transformers\General\SectionResource;

class GeneralController extends Controller
{
    public function getCcows(): AnonymousResourceCollection
    {
        $ccows = Company::where('type', CompanyType::Internal)->get();

        return CompanyResource::collection($ccows);
    }

    public function getCompanies(): AnonymousResourceCollection
    {
        $company = Company::all();

        return CompanyResource::collection($company);
    }

    public function getDepartments($id): AnonymousResourceCollection
    {
        $department = Department::where('company_id', $id)->get();

        return DepartmentResource::collection($department);
    }

    public function getSections($id): AnonymousResourceCollection
    {
        $section = Section::where('department_id', $id)->get();

        return SectionResource::collection($section);
    }

    public function getAreaLocations($id): AnonymousResourceCollection
    {
        $area_location = AreaLocation::where('section_id', $id)->get();

        return AreaLocationResource::collection($area_location);
    }

    public function getAreaManagers($id): AnonymousResourceCollection
    {
        $area_manager =  AreaManager::where('section_id', $id)->get();

        return AreaManagerResource::collection($area_manager);
    }

    public function getEmployees($id, $type): AnonymousResourceCollection
    {
        $employee = Employee::whereHas('user', function ($sql) use ($id, $type) {
            $sql->whereHas('department', function ($query) use ($id, $type) {
                $query->where('company_id', $id)
                    ->whereHas('company', function ($q) use ($type) {
                        $q->where('type', $type ?? null);
                    });
            });
        })->get();

        return EmployeeResource::collection($employee);
    }

    public function getMembers($type): AnonymousResourceCollection
    {
        $employee = Employee::whereHas('user', function ($sql) use ($type) {
            $sql->whereHas('department', function ($query) use ($type) {
                $query->whereHas('company', function ($q) use ($type) {
                    $q->where('type', $type);
                });
            });
        })
            ->get();

        return EmployeeResource::collection($employee);
    }

    public function getDetailCompany()
    {
        $type = CompanyType::asSelectArray();

        $data = [];
        foreach ($type as $key => $value) {
            $data[] = [
                'type' => $key
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function uploadFile()
    {
        $file = request()->file('file');
        $file_name = $file->getClientOriginalName();
        $file_size = $this->changeByte($file->getSize());
        $file_ext = $file->getClientOriginalExtension();

        $name = explode(' ', $file_name);
        $name = implode('_', $name);

        $path = Storage::disk('public')->putFileAs('temp-field-leadership/attachment', $file, $name);

        return response()->json([
            'status' => 'success',
            'data' =>
            [
                'path' => $path,
                'file_name' => $name,
                'file_size' => $file_size,
                'file_ext' => $file_ext,
            ]
        ]);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function previewFile($id, Request $request)
    {
        try {
            $type = $request->query('type', 'risk');
            if ($type === 'activity') {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipActivityFile::find($id);
            } elseif (in_array($type, ['risk', 'field-leadership'])) {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipRiskFile::find($id);
            } else {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipRiskFile::find($id);
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
                        // Normalize double slashes and decode %20/URL-encoding so Azure can match the actual filename
                        $filePath = urldecode(preg_replace('/\/+/', '/', $parts[1]));

                        Log::debug('previewFile: calling GetBlobSasUri', [
                            'container' => $container,
                            'filePath'  => $filePath,
                        ]);

                        $sasResult = GetBlobSasUri($container, $filePath, 15);

                        Log::debug('previewFile: GetBlobSasUri result', [
                            'sasResult' => $sasResult,
                        ]);

                        if ($sasResult && !empty($sasResult['blobUriSas'])) {
                            $url = $sasResult['blobUriSas'];
                        } else {
                            Log::warning('previewFile: SAS URI kosong/null, fallback ke plain blob URL', [
                                'blob_url'  => $attachment->blob_url,
                                'sasResult' => $sasResult,
                            ]);
                        }
                    }
                }

                // Stream from remote URL using GuzzleHttp (chunked, no buffering)
                $fileName = basename($attachment->file);
                $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $client = new \GuzzleHttp\Client;
                $response = $client->request('GET', $url, ['stream' => true]);
                $body = $response->getBody();
                $contentType = $response->getHeaderLine('Content-Type');

                // Force Content-Type berdasarkan ekstensi agar browser bisa render inline
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

            // Local storage fallback menggunakan Storage::disk (konsisten dengan DocumentSystem)
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
            $type = $request->query('type', 'risk');
            if ($type === 'activity') {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipActivityFile::find($id);
            } elseif (in_array($type, ['risk', 'field-leadership'])) {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipRiskFile::find($id);
            } else {
                $attachment = \Modules\FieldLeadership\Entities\FieldLeadershipRiskFile::find($id);
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
                $url = asset('storage/' . $attachment->file);
            }

            $fileName = basename($attachment->file);

            return response()->json([
                'url' => $url,
                'file_name' => $fileName,
                'extension' => strtolower(pathinfo($fileName, PATHINFO_EXTENSION))
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Access;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Cache;

class ApiModules
{

    static function uri()
    {
        $base_uri =  url('/'); //'http://209.97.166.176';
        return [
            'coe' =>  $base_uri . '/api/coe/dashboard', //ok
            'document_system' =>  $base_uri . '/api/document-system/main-dashboard',
            'safety_accountability_program' =>  $base_uri . '/api/sap/dashboard', //ok
            'field_leadership' => $base_uri . '/api/field-leadership/main-dashboard', //ok
            'field_leadership-user-status' => $base_uri . '/api/field-leadership/sap', //ok
            'inspection' =>  $base_uri . '/api/kplh/dashboard',
            'inspection-user-status' => $base_uri . '/api/kplh/user-stats',
            'audit' =>  $base_uri . '/api/audit/dashboard',
            'safety_operation' =>  $base_uri . '/api/ko/dashboard', //ok
            'management_resiko' =>  $base_uri . '/api/ibpr-and-bowtie/dashboard', //ok
            'compliance_regulation' =>  $base_uri . '/api/kpp/dashboard', //ok
            'mcu' =>  $base_uri . '/api/mcu/dashboard', //ok
            'contractor_safety_management_system' =>  $base_uri . '/api/kpp/dashboard',
        ];
    }

    static function module($module_name, $query = null)
    {
        try {
            $response = Http::get(static::uri()[$module_name] . '?' . $query);
            $response = json_decode($response, true);

            $seconds = 60; //update cache
            $result = Cache::remember($module_name, $seconds, function () use ($response) {
                return $response;
            });

            if (is_string($result)) {
                $result = json_decode(json_encode($result), true);
            }

            if (isset($result['data'])) {
                $result['status'] = 'true';
                return $result;
            } else {
                return [
                    'status' => 'true',
                    'data' => $result
                ];
            }
        } catch (\Throwable $e) {
            //handle arror
            report($e);

            return [
                'status' => 'false'
            ];
        }
    }
}

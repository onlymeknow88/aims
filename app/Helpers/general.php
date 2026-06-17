<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

function number2roman($num, $isUpper = true)
{
    $n = intval($num);
    $res = '';

    /*** roman_numerals array ***/
    $roman_numerals = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );

    foreach ($roman_numerals as $roman => $number) {

        $matches = intval($n / $number);


        $res .= str_repeat($roman, $matches);


        $n = $n % $number;
    }

    if ($isUpper) return $res;
    else return strtolower($res);
}

function getLastWord($sentence,$separator = " "): string
{
    $split = explode($separator, $sentence);
    return $split[count($split)-1];
}

function formProgress($ref,$data){
    $score = 0;
    $progress = 0;
    foreach ($ref as  $value) {
        if(!empty($data[$value])){
            $score++;
        }
    }

    $ref_num = count($ref);

    if($ref_num > 0){

        $progress = round(($score/$ref_num)*100,2);
    }

    return $progress;

}

if (! function_exists('setting')) {
    function setting($key)
    {
        return DB::table('app_settings')->where('id', $key)->value('val');
    }
}

if (! function_exists('uploadToBlobStorage')) {
    function uploadToBlobStorage($filename, $filePathTemp, $directPath)
    {
        try {
            $client = new Client;

            $urlBlobApiLogin = setting('blob_api_login_url');

            $responseLogin = $client->request('POST', $urlBlobApiLogin, [
                'json' => [
                    'username' => setting('blob_api_login_username'),
                    'password' => setting('blob_api_login_password'),
                ],
            ]);

            $token = json_decode($responseLogin->getBody(), true)['token'] ?? null;
            if (! $token) {
                return [
                    'fileBlobUrl' => null,
                    'fileBlobPathName' => null,
                    'blobResponse' => null,
                ];
            }

            $urlBlobApi = setting('blob_api_upload_url');

            // rtrim trailing slash to prevent double slash in blob URL (e.g. uuid//filename.pdf)
            $DirectoryPath = config('app.env') === 'local'
                ? 'test/' . rtrim($directPath, '/')
                : 'complianceCMS/' . rtrim($directPath, '/');

            $response = $client->request('POST', $urlBlobApi, [
                'multipart' => [
                    [
                        'name' => 'Files',
                        'contents' => fopen($filePathTemp, 'r'),
                        'filename' => $filename,
                    ],
                    [
                        'name' => 'ContainerName',
                        'contents' => 'aims-cntr',
                    ],
                    [
                        'name' => 'DirectoryPath',
                        'contents' => $DirectoryPath,
                    ],
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                ],
            ]);



            if ($response->getStatusCode() === 200) {
                $body = json_decode($response->getBody(), true);

                Log::info($body);

                return [
                    'fileBlobUrl' => $body[0]['blobUri'] ?? null,
                    'fileBlobPathName' => $body[0]['fileName'] ?? null,
                    'blobResponse' => [
                        'blobResponse' => $body,
                    ],
                ];
            }
        } catch (Exception $e) {
            Log::error('uploadToBlobStorage error: '.$e->getMessage());
        }

        return [
            'fileBlobUrl' => null,
            'fileBlobPathName' => null,
            'blobResponse' => null,
        ];
    }
}

if (! function_exists('GetBlobSasUri')) {
    function GetBlobSasUri($container, $filePath, $expSasLimit = 5)
    {
        try {
            $client = new Client;

            $urlBlobApiLogin = setting('blob_api_login_url');

            $responseLogin = $client->request('POST', $urlBlobApiLogin, [
                'json' => [
                    'username' => setting('blob_api_login_username'),
                    'password' => setting('blob_api_login_password'),
                ],
            ]);

            $token = json_decode($responseLogin->getBody(), true)['token'] ?? null;
            if (! $token) {
                return null;
            }

            $urlBlobApi = setting('blob_api_get_blob_url_sas');

            $response = $client->request('POST', $urlBlobApi, [
                'json' => [
                    'container' => $container,
                    'filePath' => $filePath,
                    'expSasLimit' => (int) $expSasLimit,
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (\Exception $e) {
            Log::error('GetBlobSasUri error: '.$e->getMessage());
        }

        return null;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ViewController extends Controller
{
    public function FileShow(request $request)
    {
        $input = $request->get('loc');
        return Storage::get($input);
    }
}

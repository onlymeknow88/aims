<?php

namespace App\Http\Controllers\Admin\Company;

use App\Http\Controllers\Controller;
use App\Imports\Admin\Company\ImportCompanies;
use Illuminate\Http\Request;

class ImportCompanyController extends Controller
{
    public function import(Request $request)
    {
        dd('AAA');
//        (new ImportCompanies())->toArray();
    }
}

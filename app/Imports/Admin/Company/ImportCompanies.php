<?php

namespace App\Imports\Admin\Company;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCompanies implements ToModel
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Company([
            //
        ]);
    }

    public function rules(): array
    {

    }
}

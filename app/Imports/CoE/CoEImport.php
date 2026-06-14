<?php

namespace App\Imports\CoE;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CoE as CoE;

class CoEImport implements WithCalculatedFormulas, ToModel
{
     /**
     * @param array $row
     *
     * @return  CoE|null
     */
    public function model(array $row)
    {
        return new  CoE([
           '1'     => $row[0],
           '2'    => $row[1],
        ]);

    }
}

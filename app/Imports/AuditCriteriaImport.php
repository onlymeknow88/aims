<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CoE as CoE;

class AuditCriteriaImport implements ToModel
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
           '3'    => $row[2],
           '4'    => $row[3],
           '5'    => $row[4],
        ]);

    }
}
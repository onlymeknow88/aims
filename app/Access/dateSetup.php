<?php

namespace App\Access;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\MainDashboard\RunningDate;

class dateSetup
{


    public static function month($year = null, $limit = null)
    {
        $year = $year ? $year : date('Y');
        $limit = $limit ? $limit : 12;
        $month = [];
        $i = 1;
        do {
            $date = '1-' . $i . '-' . $year;
            $month2 = strtolower(date('M', strtotime($date)));
            $dayCount = Carbon::parse($date)->daysInMonth;
            $month_name = strtolower(date('F', strtotime($date)));
            $month_name = strtolower($month_name);
            $month[] = [
                'year' => $year,
                'month_name' => $month_name,
                'month' => $i,
                'month2' => $month2,
                'day' =>  $dayCount,
                'checked' => null
            ];

            $i++;
        } while ($i <= $limit);

        return $month;
    }

    public static function days_in_year($year = null)
    {
        $year = $year ? $year : date('Y');
        $data = static::month($year);
        $dayInYear = 0;
        foreach ($data as $index => $list) {
            $nomor = ++$index;
            $dayCount = Carbon::parse('1-' . $nomor . '-' . $year)->daysInMonth;
            if ($nomor < date('m')) {
                $dayInYear += $dayCount;
            }
        }
        $dayInYear = $dayInYear + date('d');
        return  $dayInYear;
    }

    public static function bulan()
    {
        return [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'DESENBER'
        ];
    }

    public static function year($limit = null)
    {
        $yearNow = date('Y');
        $years = RunningDate::groupBy('year')
            ->selectRaw("
                year,
                CASE
                    WHEN running_date.year = '$yearNow' THEN true
                    ELSE false
                END as checked
            ")
            ->take($limit)
            ->get();
        return json_decode($years, true);
    }

    public static function yearPlus($limit = null)
    {
        $yearNow = date('Y');
        $yearNow = date('Y');
        $years = RunningDate::groupBy('year')
            ->orderby('year', 'ASC')
            ->selectRaw("
                year,
                CASE
                    WHEN running_date.year = '$yearNow' THEN true
                    ELSE false
                END as checked
            ")
            ->get();
        $years = json_decode($years, true);

        //empty database  = year Now
        if (count($years) ==  0) {
            $years[] = ['year' => $yearNow,  "checked" => false];
        }

        //add last year + 1
        $LastYears = RunningDate::orderby('year', 'DESC')
            ->selectRaw("
                year,
                CASE
                    WHEN running_date.year = '$yearNow' THEN true
                    ELSE false
                END as checked
            ")
            ->first();
        $LastYears =  $LastYears ? $LastYears->year : null;
        if ($LastYears) {
            $years[] = ['year' => $LastYears + 1, "checked" => false];
        }

        $sorted = collect($years)->sortBy('year');
        $sorted = $sorted->values()->all();
        return $sorted;
    }

    //simpan tahun berjalan
    public static function setYear()
    {
        $data =  RunningDate::updateOrCreate(
            [
                'month' => date('m', strtotime(now()))
            ],
            [
                'month_name' => date('M', strtotime(now())),
                'year' => date('Y', strtotime(now()))
            ]
        );

        return $data;
    }
}

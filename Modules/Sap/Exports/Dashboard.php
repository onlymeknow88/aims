<?php

namespace Modules\Sap\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; //autosize
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart as ChartChart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Worksheet\Chart;

class Dashboard implements FromView, WithTitle, WithStyles, ShouldAutoSize, WithCharts
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return Builder
     */

    public function styles(Worksheet $sheet)
    {
    }

    public function view(): View
    {
        $data = $this->data;
        return view('sap::livewire.home.exports.table_dashboard', [
            'data_all' => $data
        ]);
    }

    public function charts()
    {
        $data_all = $this->data;

        $YearPosition = 3;
        $MonthPosition = 23;

        $YearChartPosition = 9;
        $MonthChartPosition = 29;

        $color_target = '#FFC0CB';
        $color_actual = '#FF00FF';


        $chart_all = [];
        foreach ($data_all as $data) {

            $data = $data['data'];
            $yearly = $data['yearly'];
            $monthly = $data['monthly'];

            $countData = count($yearly);

            $letter = [];
            for ($i = 'A'; $i < 'ZZ'; $i++) {
                $letter[] = $i;
            }

            $colEnd = ($countData) > 0 ? $letter[$countData] : "B";
            $colEnd =  $colEnd < "F" ? "F" : $colEnd;
            /** GRAFIK 1  (YEARLY)*/

            //BATANG 1
            $labelChart1Bar1      = [new DataSeriesValues('String', 'ALL!$A$' . ($YearPosition + 1), null, 2)];
            $categoriesChart1 = [new DataSeriesValues('String', 'ALL!$B$' . ($YearPosition) . ':$' . $colEnd . '$' . ($YearPosition), null, 200)];
            $valuesChart1Bar1     = [new DataSeriesValues('Number', 'ALL!$B$' . ($YearPosition + 1) . ':$' . $colEnd . '$' . ($YearPosition + 1), null, 200)];
            $seriesChart1Bar1 = new DataSeries(
                DataSeries::TYPE_BARCHART,
                DataSeries::GROUPING_STANDARD,
                range(0, \count($valuesChart1Bar1) - 1),
                $labelChart1Bar1,
                $categoriesChart1,
                $valuesChart1Bar1,
            );

            //BATANG 2
            $labelChart1Bar2      = [new DataSeriesValues('String', 'ALL!$A$' . ($YearPosition + 2), null, 2)];
            $valuesChart1Bar2     = [new DataSeriesValues('Number', 'ALL!$B$' . ($YearPosition + 2) . ':$' . $colEnd . '$' . ($YearPosition + 2), null, 200)];
            $seriesChart1Bar2 = new DataSeries(
                DataSeries::TYPE_BARCHART,
                DataSeries::GROUPING_STANDARD,
                range(0, \count($valuesChart1Bar2) - 1),
                $labelChart1Bar2,
                $categoriesChart1,
                $valuesChart1Bar2
            );
            $plotChart1   = new PlotArea(null, [$seriesChart1Bar1, $seriesChart1Bar2]);

            $legend = new Legend();
            $title = new Title('TARGET VS AKTUAL');
            $chart  = new ChartChart('chart name', $title, $legend, $plotChart1);
            //lokasi
            $chart->setTopLeftPosition('B' . $YearChartPosition);
            $chart->setBottomRightPosition($colEnd . ($YearChartPosition + 9));
            $YearPosition += 20;
            $YearChartPosition += 20;






            //GRAFIK 2 (MONTHLY)
            $labelChart2Bar1      = [new DataSeriesValues('String', 'ALL!$A$' . ($MonthPosition + 1), null, 2)];
            $categoriesChart2 = [new DataSeriesValues('String', 'ALL!$B$' . ($MonthPosition) . ':$' . $colEnd . '$' . ($MonthPosition), null, 200)];
            $valuesChart2Bar1     = [new DataSeriesValues('Number', 'ALL!$B$' . ($MonthPosition + 1) . ':$' . $colEnd . '$' . ($MonthPosition + 1), null, 200)];
            $seriesChart2Bar1 = new DataSeries(
                DataSeries::TYPE_BARCHART,
                DataSeries::GROUPING_STANDARD,
                range(0, \count($valuesChart2Bar1) - 1),
                $labelChart2Bar1,
                $categoriesChart2,
                $valuesChart2Bar1
            );

            $labelChart2Bar2      = [new DataSeriesValues('String', 'ALL!$A$' . $MonthPosition, null, 2)];
            $valuesChart2Bar2     = [new DataSeriesValues('Number', 'ALL!$B$' . ($MonthPosition + 2) . ':$' . $colEnd . '$' . ($MonthPosition + 2), null, 200)];
            $seriesChart2Bar2 = new DataSeries(
                DataSeries::TYPE_BARCHART,
                DataSeries::GROUPING_STANDARD,
                range(0, \count($valuesChart2Bar2) - 1),
                $labelChart2Bar2,
                $categoriesChart2,
                $valuesChart2Bar2
            );
            $plotChart2   = new PlotArea(null, [$seriesChart2Bar1, $seriesChart2Bar2]);

            $title2 = new Title('TARGET VS AKTUAL');
            $chart2  = new ChartChart('chart name', $title2, $legend, $plotChart2);
            //lokasi
            $chart2->setTopLeftPosition('B' . $MonthChartPosition);
            $chart2->setBottomRightPosition($colEnd . ($MonthChartPosition + 9));
            $MonthPosition += 20;
            $MonthChartPosition += 20;

            $chart_all[] = $chart;
            $chart_all[] = $chart2;
        }

        /* show */
        return $chart_all;
    }


    /**
     * @return string
     */
    public function title(): string
    {
        return 'ALL';
    }
}

<?php

namespace Modules\Pica\Http\Livewire\Dashboard;

use App\Enums\PicaSource;
use Livewire\Component;
use Modules\Pica\Entities\PicaDocument;

class DashboardPage extends Component
{
    public function getFieldLeadershipChartProperty()
    {
        $label = ['Open', 'Closed', 'Overdue'];
        $open = PicaDocument::where('source', PicaSource::FieldLeadership)->where('status', 'Open')->count();
        $closed = PicaDocument::where('source', PicaSource::FieldLeadership)->where('status', 'Closed')->count();
        $overdue = PicaDocument::where('source', PicaSource::FieldLeadership)->where('status', 'Overdue')->count();

        $chart = [
            'idChart'   =>  'pieChartFL',
            'width'     => 300,
            'height'    => 300,
            'labels'    =>  $label,
            'datasets'  =>  [[
                'label' => 'Field Leadership',
                'data'  =>  [$open, $closed, $overdue],
                'backgroundColor' => [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                ],
            ]],
            'legend'    => true,
            'labelX'    => [
                'display'       => false,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        return $chart;
    }

    public function getKplhChartProperty()
    {
        $label = ['Open', 'Closed', 'Overdue'];
        $open = PicaDocument::where('source', PicaSource::InspeksiKPLH)->where('status', 'Open')->count();
        $closed = PicaDocument::where('source', PicaSource::InspeksiKPLH)->where('status', 'Closed')->count();
        $overdue = PicaDocument::where('source', PicaSource::InspeksiKPLH)->where('status', 'Overdue')->count();

        $chart = [
            'idChart'   =>  'pieChartKplh',
            'width'     => 300,
            'height'    => 300,
            'labels'    =>  $label,
            'datasets'  =>  [[
                'label' => 'Field Leadership',
                'data'  =>  [$open, $closed, $overdue],
                'backgroundColor' => [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                ],
            ]],
            'legend'    => true,
            'labelX'    => [
                'display'       => false,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        return $chart;
    }

    public function getAuditChartProperty()
    {
        $label = ['Open', 'Closed', 'Overdue'];
        $open = PicaDocument::where('source', PicaSource::Audit)->where('status', 'Open')->count();
        $closed = PicaDocument::where('source', PicaSource::Audit)->where('status', 'Closed')->count();
        $overdue = PicaDocument::where('source', PicaSource::Audit)->where('status', 'Overdue')->count();

        $chart = [
            'idChart'   =>  'pieChartAudit',
            'width'     => 300,
            'height'    => 300,
            'labels'    =>  $label,
            'datasets'  =>  [[
                'label' => 'Field Leadership',
                'data'  =>  [$open, $closed, $overdue],
                'backgroundColor' => [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                ],
            ]],
            'legend'    => true,
            'labelX'    => [
                'display'       => false,
                'color'         => 'rgba(0,0,0,0.8)',
                'beginAtZero'   => true
            ]
        ];

        return $chart;
    }

    public function render()
    {
        return view('pica::livewire.dashboard.dashboard-page')->layout('pica::layouts.app');
    }
}

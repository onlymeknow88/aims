<?php

namespace Modules\Sap\Http\Livewire\Home\Widgets;

use Livewire\Component;

use Modules\Sap\Http\Controllers\Api\ApiController;
use App\Access\dateSetup;

class YearlyTable extends Component
{

    public $data = [];
    public $weekly = [];
    public $monthly = [];
    public $months = [];
    public $years = [];
    public $countWeeks = 0;
    public $monthNow = null;
    public $filter = [
        'year' => null,
        'month' => null
    ];
    public $bulan = [
        'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'NOVEMBER', 'DESENBER'
    ];


    public function filter()
    {
        $this->getData();
    }

    public function mount($category_id = null, $id = null)
    {
        $this->filter['year'] = date('Y');
        $this->setDate();
        $this->getData();
    }

    public function setDate()
    {
        $this->months = dateSetup::month();
        $this->years = dateSetup::yearPlus();
    }

    public function getData()
    {
        $filter = $this->filter;
        $this->emit('filter', $filter);
        $this->emit('filterYearlySAP', http_build_query($filter));

        $request = [];
        $request['year'] = isset($filter['year']) ? $filter['year'] : null;
        $request['month'] = isset($filter['month']) ? $filter['month'] : null;

        $data = (new ApiController)->dataSapChart($request);
        $this->data = $data;
    }


    public function render()
    {
        return view('sap::livewire.home.widgets.yearly-table');
    }
}

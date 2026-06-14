<?php

namespace Modules\IbprAndBowtie\Http\Livewire\RiskList;

use App\Models\IbprBowty\Bowtie;
use Livewire\Component;

class Listing extends Component
{

    public $limit;
    public $countData;
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $columns = ['Nomor Dokument', 'Judul Risiko', 'Dokument Bowtie'];
    public $selectedColumns = [];
    public $search;
    public $latestUpdate;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public $sortSelected = [];
    public $sortFieldSelected;

    public $bowtie = [];

    public function mount(){
        $this->bowtie = Bowtie::whereIn('status', ['Disetujui','Temporary'])->get();
    }

    public function onSelectedItem($id)
    {

        if (in_array($id, $this->itemSelected)) {
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            //array_merge($this->itemSelected, array($this->itemSelected[$key]));
            $this->countSelected--;
        } else {
            $this->itemSelected[] = $id;
            ///array_push($this->itemSelected, $id);
            $this->countSelected++;
        }
    }

    public function activedInfo()
    {
        $this->info = !$this->info;
    }

    public function removeSeleced()
    {
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.risk-list.listing')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }

}

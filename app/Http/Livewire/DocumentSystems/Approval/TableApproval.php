<?php

namespace App\Http\Livewire\DocumentSystems\Approval;

use Livewire\Component;

class TableApproval extends Component
{
    public $dataTables = array(
        array(
            'id'                => '1',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-danger">Return</span>'
        ),
        array(
            'id'                => '2',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '3',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '4',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '5',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '6',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '7',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '8',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '9',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '10',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-danger">Return</span>'
        ),
        array(
            'id'                => '11',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '12',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '13',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-warning">Waiting Review</span>'
        ),
        array(
            'id'                => '14',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '15',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '16',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '17',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        ),
        array(
            'id'                => '18',
            'title'             => 'Document Title',
            'Created'           => 'January 22, 2023',
            'status'            => '<span class="badge bg-success">Routing Approval</span>'
        )
    );

    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;


    public function render()
    {
        return view('livewire.document-systems.approval.table-approval');
    }

    public function onSelectedItem($id){

        if(in_array($id, $this->itemSelected)){
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        }else{
            $this->itemSelected[] = $id;
            $this->countSelected++;
        }        
        
    }

    public function activedInfo(){
        $this->info = !$this->info;
    }

    public function removeSeleced(){
        $this->itemSelected = [];
        $this->countSelected = 0;
    }
}

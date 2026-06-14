<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Pica\Listing;

use App\Models\DocumentSystem\Document;


use App\Models\IbprBowty\Pica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PicaList extends Component
{
    protected $listeners = [
        'check_pica' => 'handle_check_pica',
    ];

    public $data = [];
    public $title;
    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $availableCompany = [];
    public $availableDepartment = [];
    public $availablePics = [];
    public $availableModules = [];
    public $countSelected = 0;
    public $info = false;

    public function mount(Request $request)
    {
        // $this->availableData();
        $status = Document::availableStatus();
        $statuses = [];
        foreach ($status as $key => $s) {
            $statuses[] = [
                'id' => $key,
                'name' => $s,
            ];
        }
        $this->columns = [
            trans('Company') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Departement') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Aktifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Sub Aktifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Risiko Kejadian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Bahaya Keselamatan') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Konsekuensi Saat Ini') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Frekuensi') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Tingkat Risiko') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Action Plan') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('PIC') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Tgl. Review') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Kontrol Efektifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Lampiran Kontrol Efektifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Target Waktu') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Status Daftar Risiko') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }

    public function onSelectedItem($id)
    {
        if(in_array($id, $this->itemSelected)){
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        }else{
            $this->itemSelected[] = $id;
             $this->countSelected++;
        }

    }

    public function removeSeleced(){
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    public function downloadFile($url)
    {
       try {
            $filePath = storage_path('app/' .$url);
            return response()->download($filePath);
       }
       catch (\Throwable $th) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }


    public function handle_check_pica() {
        $query = Pica::select()->with([
            'form',
            'form.ibpr',
            'form.risks',
            'formIadl',
            'formIadl.iadl',
            'formIadl.risks'
        ]);

        $this->data = $query->get();
    }

    public function render()
    {
        $query = Pica::select()->with([
            'form',
            'form.ibpr',
            'form.risks',
            'formIadl',
            'formIadl.iadl',
            'formIadl.risks'
        ]);

        $this->data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.pica.list.list')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }

    public function listing(Request $request){
        $perPage = $request->input('per_page', 10);
        $data = Pica::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'data retrieved successfully',
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage()
            ]
        ]);
    }
}

<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Modal;

use App\Models\Department;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalPerformance extends Component
{
    protected $listeners = [
        'check_document_number' => 'handle_check_document_number',
        'click_edit_performance' => 'handle_click_edit_performance',
        'clear_performance_modal' => 'handle_clear_performance_modal',
        'check_cca' => 'handle_check_cca'
    ];

    use WithFileUploads;

    public $tmp = [];

    public $departments = [];
    public $sections = [];

    public $cca = [];
    public $ohs_id;
    public $pja_id;
    public $event_id;
    public $bowtie;
    public $number;
    public $ccow_id;
    public $contractor_id;
    public $sub_contractor_id;
    public $bowtie_id;
    public $name;
    public $control_explanation;
    public $department_id;
    public $section_id;
    public $description;
    public $purpose;
    public $effectiveness_testing_activities;
    public $design_standard;
    public $operation_standard;
    public $ospek;
    public $obesrvation_file;
    public $obesrvation_file_name;
    public $obesrvation;
    public $test_efectivity_file;
    public $test_efectivity_file_name;
    public $implementation_test_efectivity;

    public $perpormance_id;
    public $is_edit = false;
    public $cca_id;
    public $responsible_person;


    public $testings = [[
        'name' => ''
    ]];

    public function mount($bowtie_id) {
        $this->bowtie_id = $bowtie_id;
        $this->bowtie = Bowtie::find($bowtie_id);

        $count_perpormance = BowtiePerformanceStandard::where('bowtie_id', $bowtie_id)->count();


        $this->number =  $this->bowtie->document_no . '-' . str_pad($count_perpormance + 1, 3, '0', STR_PAD_LEFT);
        $this->departments = Department::get();
        $this->sections = Section::get();

        $cca_selected = BowtiePerformanceStandard::where('bowtie_id', $bowtie_id)->pluck('cca_id');
        $this->cca = BowtieCca::where('bowtie_id', $this->bowtie_id)->whereNotIn('id', $cca_selected)->get();
    }

    public function getEventsProperty(){
        return BowtieEvent::where('bowtie_id', $this->bowtie_id)->get();

    }

    public function getCcasProperty(){
        return BowtieCca::where('bowtie_id', $this->bowtie_id)->get();

    }

    public function addTestings() {
        $this->testings[] = [
            'name' => ''
        ];
    }

    public function handle_check_document_number() {
        $count_perpormance = BowtiePerformanceStandard::where('bowtie_id', $this->bowtie_id)->count();
        $this->number =  $this->bowtie->document_no . '-' . str_pad($count_perpormance + 1, 3, '0', STR_PAD_LEFT);
    }

    public function handle_check_cca() {
        $this->cca = BowtieCca::where('bowtie_id', $this->bowtie_id)->get();
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatedCcaId()
    {
        $cca = BowtieCca::find($this->cca_id);
        $this->name = $cca->control_explanation;
    }

    public function handle_click_edit_performance($id) {
        $this->is_edit = true;
        $this->perpormance_id = $id;

        $perpormance = BowtiePerformanceStandard::find($id);
        $this->bowtie_id = $perpormance->bowtie_id;
        $this->name = $perpormance->name;
        $this->cca_id = $perpormance->cca_id;
        $this->department_id = $perpormance->department_id;
        $this->section_id = $perpormance->section_id;
        $this->description = $perpormance->description;
        $this->purpose = $perpormance->purpose;
        $this->effectiveness_testing_activities = $perpormance->effectiveness_testing_activities;
        $this->design_standard = $perpormance->design_standard;
        $this->operation_standard = $perpormance->operation_standard;
        $this->ospek = $perpormance->ospek;
        $this->obesrvation_file = $perpormance->obesrvation_file;
        $this->obesrvation_file_name = $perpormance->obesrvation_file_name;
        $this->obesrvation = $perpormance->obesrvation;
        $this->test_efectivity_file = $perpormance->test_efectivity_file;
        $this->test_efectivity_file_name = $perpormance->test_efectivity_file_name;
        $this->implementation_test_efectivity = $perpormance->implementation_test_efectivity;
        $this->responsible_person = $perpormance->responsible_person;

        $this->emit('openModalPerformance');
    }

    public function handle_clear_performance_modal() {
        $this->is_edit = false;
        $this->perpormance_id = null;
        $this->cca_id = null;

        $this->name = null;
        $this->department_id = null;
        $this->section_id = null;
        $this->description = null;
        $this->purpose = null;
        $this->effectiveness_testing_activities = null;
        $this->design_standard = null;
        $this->operation_standard = null;
        $this->ospek = null;
        $this->obesrvation_file = null;
        $this->obesrvation = null;
        $this->test_efectivity_file = null;
        $this->implementation_test_efectivity = null;
        $this->responsible_person = null;
    }

    public function submit() {

        $this->validate([
            //'bowtie_id' => 'required',
            'name' => 'required',
            'number' => 'required',
            //'department_id' => 'required',
            //'section_id' => 'required',
//            'description' => 'required',
//            'purpose' => 'required',
            'design_standard' => 'required',
//            'operation_standard' => 'required',
            'ospek' => 'required',
            'obesrvation_file' => 'required|mimes:pdf',
            //'obesrvation_file_name' => 'required',
            'obesrvation' => 'required',
            'test_efectivity_file' => 'required|mimes:pdf',
            //'test_efectivity_file_name' => 'required',
            'implementation_test_efectivity' => 'required',
            'responsible_person' => 'required'
        ]);
        DB::beginTransaction();
        try {

            $directory = 'bowtie/performance';

            if (!File::exists(storage_path('app/' . $directory))) {
                Storage::makeDirectory($directory);
            }

            $obesrvation_file = Storage::disk('public')->put($directory, $this->obesrvation_file);

            $test_efectivity_file = Storage::disk('public')->put($directory, $this->test_efectivity_file);

            BowtiePerformanceStandard::create([
                'bowtie_id' => $this->bowtie_id,
                'cca_id' => $this->cca_id,
                'name' => $this->name,
                'number' => $this->number,
                //'department_id' => $this->department_id,
                //'section_id' => $this->section_id,
                //'description' => $this->description,
                'effectiveness_testing_activities' => $this->effectiveness_testing_activities,
                'purpose' => $this->purpose,
                'design_standard' => $this->design_standard,
//                'operation_standard' => $this->operation_standard,
                'ospek' => $this->ospek,
                'obesrvation_file' => $obesrvation_file,
                'obesrvation_file_name' => $this->obesrvation_file->getClientOriginalName(),
                'obesrvation' => $this->obesrvation,
                'test_efectivity_file' => $obesrvation_file,
                'test_efectivity_file_name' => $this->test_efectivity_file->getClientOriginalName(),
                'implementation_test_efectivity' => $this->implementation_test_efectivity,
                'responsible_person' => $this->responsible_person
            ]);

            DB::commit();

            $this->emit('closeModalPerformance');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function submit_edit(Request $request) {
        $this->validate([
            //'bowtie_id' => 'required',
            'name' => 'required',
            'number' => 'required',
            //'department_id' => 'required',
            //'section_id' => 'required',
            //'description' => 'required',
            'purpose' => 'required',
            'design_standard' => 'required',
//            'operation_standard' => 'required',
            'ospek' => 'required',
            'obesrvation_file' => 'required',
            //'obesrvation_file_name' => 'required',
            'obesrvation' => 'required',
            'test_efectivity_file' => 'required',
            //'test_efectivity_file_name' => 'required',
            'implementation_test_efectivity' => 'required',
            'responsible_person' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $directory = 'public/document_systems';

            if (!File::exists(storage_path('app/' . $directory))) {
                Storage::makeDirectory($directory);
            }

            $perpormance_standard = BowtiePerformanceStandard::find($this->perpormance_id);

            if ($this->obesrvation_file && !is_string($this->obesrvation_file)) {
                $obesrvation_file = Storage::disk('public')->put($directory, $this->obesrvation_file);
                $obesrvation_file_name =  $this->obesrvation_file->getClientOriginalName();
            } else {
                $obesrvation_file = $this->obesrvation_file;
                $obesrvation_file_name = $this->obesrvation_file_name;
            }

            if ($this->test_efectivity_file && !is_string($this->test_efectivity_file)) {
                $test_efectivity_file = Storage::disk('public')->put($directory, $this->test_efectivity_file);
                $test_efectivity_file_name =  $this->test_efectivity_file->getClientOriginalName();
            } else {
                $test_efectivity_file = $this->test_efectivity_file;
                $test_efectivity_file_name = $this->test_efectivity_file_name;
            }

            $perpormance_standard->update([
                'bowtie_id' => $this->bowtie_id,
                'cca_id' => $this->cca_id,
                'name' => $this->name,
                //'department_id' => $this->department_id,
                //'section_id' => $this->section_id,
                //'description' => $this->description,
                'effectiveness_testing_activities' => $this->effectiveness_testing_activities,
                'purpose' => $this->purpose,
                'design_standard' => $this->design_standard,
//                'operation_standard' => $this->operation_standard,
                'ospek' => $this->ospek,
                'obesrvation_file' => $obesrvation_file,
                'obesrvation_file_name' => $obesrvation_file_name,
                'obesrvation' => $this->obesrvation,
                'test_efectivity_file' => $test_efectivity_file,
                'test_efectivity_file_name' => $test_efectivity_file_name,
                'implementation_test_efectivity' => $this->implementation_test_efectivity,
            ]);

            DB::commit();

            $this->emit('closeModalPerformance');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.modal.modal-performance');
    }
}

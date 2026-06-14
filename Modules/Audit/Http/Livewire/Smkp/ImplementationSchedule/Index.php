<?php

namespace Modules\Audit\Http\Livewire\Smkp\ImplementationSchedule;


use Carbon\Carbon;
use Livewire\Component;
use Modules\Audit\Entities\AuditCriteriaConfirmance;
use Modules\Audit\Entities\AuditImplementationActivity;
use Modules\Audit\Entities\AuditImplementationActivityDetailSchedule;
use Modules\Audit\Entities\AuditMethod;
use Modules\Audit\Entities\AuditLocation;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Enums\ScheduleActivityType;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Index extends Component
{

    public Audit|null $audit;
    public AuditImplementationActivity|null $implementationActivity;
    public string $date = "";
    public string $schedule_activity_type = "";
    public ?string $description = null;
    public ?string $auditor = null;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public ?string $auditee = null;
    public $methods = [];
    public $availableMethods = [];
    public $auditor_ids = [];
    public ?string $location = null;
    public ?string $title = null;
    public $teams = [];
    public $audit_criteria = [];
    public $selectedCriteria = [];

    public ?string $selectedDateId = null;
    public ?string $audit_implementation_activity_detail_id = null;

    protected $listeners = ['MethodsPopulateSelect2Multiple'];


    public function mount($id)
    {
        $this->getAudit($id);
    }

    public function getLocationsProperty()
    {
        return AuditLocation::with('sub_sub_criteria_location')->where('audit_id', $this->audit->id)->get();
    }

    protected function getAudit($id): void
    {
        $this->clearFormModal();
        $this->audit = Audit::with('auditors')->findOrFail($id);
        $this->teams = $this->audit->auditors;
        $this->availableMethods = AuditMethod::all();
        $this->implementationActivity = $this->audit->implementation_activity()->with('details.schedules.auditors')->firstOrCreate([]);
        $moduleCriteria = $this->audit->criteria_module()->with('criteria.sub_criteria.children')->first();

        $selectArrays = [];

        foreach ($moduleCriteria->criteria as $keyCriteria => $criterion):
            foreach ($criterion->sub_criteria as $keySubCriteria => $sub_criterion):
                if ($sub_criterion->has_point && !$sub_criterion->excluded) {
                    $selectArrays[$sub_criterion->id] = $sub_criterion->title;
                }
                foreach ($sub_criterion->children as $keyChildren => $child):
                    if ($child->has_point && !$child->excluded) {
                        $selectArrays[$child->id] =  $child->title;
                    }
                endforeach;
            endforeach;

        endforeach;
        $this->audit_criteria = $selectArrays;
        // dd($this->criteria);
    }

    public function setDateId($id)
    {
        $this->selectedDateId = $id;
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    function updated($name, $val)
    {

    }

    public function deleteDate($id)
    {
        $this->audit->implementation_activity->details()->where('id', $id)->delete();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Berhasil menghapus jadwal'
        ]);
        $this->getAudit($this->audit->id);
        $this->dispatchBrowserEvent('closeModal');
    }

    public function deleteSchedule($id)
    {
        $schedule = AuditImplementationActivityDetailSchedule::where('id', $id)->whereHas('detail', function ($detail) {
            $detail->whereHas('activity', function ($a) {
                $a->where('audit_id', $this->audit->id);
            });
        })->first();
        if (!$schedule) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'danger',
                'text' => 'data tidak ditemukan'
            ]);
            $this->dispatchBrowserEvent('closeModal');
            return;
        }
        $schedule->delete();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Berhasil menghapus jadwal'
        ]);
        $this->getAudit($this->audit->id);
        $this->dispatchBrowserEvent('closeModal');
    }

    public function saveScheduleDate(): void
    {
        $this->validate([
            'date' => 'required',
        ]);


        try {
            \DB::beginTransaction();
            if (!$this->selectedDateId) {
                $detail = $this->implementationActivity->details()->where('date', Carbon::parse($this->date)->toDateString())->first();
                if ($detail) {
                    $this->dispatchBrowserEvent('swal', [
                        'title' => 'Whoops',
                        'icon' => 'danger',
                        'text' => 'tanggal tersebut sudah ada di jadwal'
                    ]);
                    $this->dispatchBrowserEvent('closeModal');
                    return;
                }
                $detail = $this->implementationActivity->details()->create();
            } else {
                $detail = $this->implementationActivity->details()->where('id', $this->selectedDateId)->first();
                if (!$detail) {
                    $this->dispatchBrowserEvent('swal', [
                        'title' => 'Whoops',
                        'icon' => 'danger',
                        'text' => 'data tidak ditemukan'
                    ]);
                    $this->dispatchBrowserEvent('closeModal');
                    return;
                }
            }
            $detail->update([
                'date' => Carbon::parse($this->date)->toDateString()
            ]);
            \DB::commit();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            $this->dispatchBrowserEvent('closeModal');
            $this->getAudit($this->audit->id);
            $this->reset("date");
            if ($this->selectedDateId) {
                $this->reset("selectedDateId");
            }
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'danger',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');

        }
    }

    public function saveScheduleActivity(): void
    {
        $this->validate([
            'schedule_activity_type' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i'
        ]);
        if ($this->schedule_activity_type == ScheduleActivityType::ISOMA) {
            $this->auditor = null;
            $this->description = null;
            $this->location = null;
            $this->methods = [];
            $this->auditee = null;
            $this->title = "ISOMA";
            $this->saveDefault();
        }

        if ($this->schedule_activity_type == ScheduleActivityType::OPENING) {
            $this->validate([
                'location' => 'required'
            ]);
            $this->auditor = "Semua Auditor dan Auditee";
            $this->title = "Pelaksanaan Rapat Pembukaan";
            $this->methods = [];
            $this->description = null;
            $this->auditee = null;
            $this->saveDefault();
            return;
        }

        if ($this->schedule_activity_type == ScheduleActivityType::CLOSING) {
            $this->validate([
                'location' => 'required'
            ]);
            $this->auditor = "Semua Auditor dan Auditee";
            $this->title = "Rapat penutupan Audit";
            $this->methods = [];
            $this->description = null;
            $this->auditee = null;
            $this->saveDefault();
            return;
        }
        if ($this->schedule_activity_type == ScheduleActivityType::FREE_TEXT) {
            $this->validate([
                'description' => 'required',
                'auditor' => 'nullable'
            ]);
            $this->title = null;
            $this->methods = [];
            $this->auditee = null;
            $this->location = null;

            $this->saveDefault();
            return;
        }

        if ($this->schedule_activity_type == ScheduleActivityType::ACTIVITY) {

            $this->validate([
                'auditor_ids' => 'nullable|array|min:0',
                'location' => 'required',
                'methods' => 'required|array'
            ]);
            $this->title = null;
            $this->description = null;
            $this->saveActivity();
            return;
        }

    }

    public function clearFormModal(): void
    {
        $this->title = null;
        $this->methods = [];
        $this->auditee = null;
        $this->location = null;
        $this->description = null;
        $this->auditor = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->schedule_activity_type = "";

    }

    private function saveActivity()
    {
        try {
            \DB::beginTransaction();
            $detail = $this->implementationActivity->details()->where('id', $this->selectedDateId)->first();
            $schedule = $detail->schedules()->create([
                'schedule_activity_type' => $this->schedule_activity_type,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'description' => $this->description,
                'location' => $this->location,
                'auditee' => $this->auditee,
                'method' => collect($this->methods)->implode(', ')
            ]);
            $schedule->auditors()->sync($this->auditor_ids);
            $schedule->sub_criteria()->detach();
            $schedule->sub_criteria()->sync($this->selectedCriteria);
            \DB::commit();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            $this->dispatchBrowserEvent('closeModal');
            $this->getAudit($this->audit->id);
        } catch (\Exception $exception) {
            \DB::rollBack();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => 'Data gagal disimpan',
                'err' => $exception->getMessage()
            ]);
        }


    }

    private function saveDefault()
    {
        $detail = $this->implementationActivity->details()->where('id', $this->selectedDateId)->first();
        $detail->schedules()->create([
            'schedule_activity_type' => $this->schedule_activity_type,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'auditor' => $this->auditor
        ]);
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah disimpan'
        ]);
        $this->dispatchBrowserEvent('closeModal');
        $this->getAudit($this->audit->id);
    }

    public function generateWord($id)
    {
        $this->audit = Audit::with('company','auditors')->find($id);
        $this->implementationActivity = $this->audit->implementation_activity()->with('details.schedules.auditors')->firstOrCreate([]);

        $viewContent = view('audit::livewire.implementation-schedule.export-word', [
            'audit_category' => 'SMKP',
            'audit' => $this->audit,
            'implementationActivity' => $this->implementationActivity
        ])->render();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $viewContent);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/'.$this->audit->title.'-implementation-schedule.docx'));

        return response()->download(storage_path('app/public/'.$this->audit->title.'-implementation-schedule.docx'))->deleteFileAfterSend(true);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        if (\Auth::user()->hasPermissionTo( 'Audit - Detail SMKP Implementation Schedule')) {
            return view('audit::livewire.implementation-schedule.index',[
                "category"=>"smkp"
            ])->layout('audit::livewire.layouts.app');
        } else {
            return abort(404);
        }

    }
}

<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Detail;

use App\Exports\IbprAndBowtie\BowtieExport;
use App\Models\Department;
use App\Models\IbprBowty\BowtieActivity;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtieLossCalculation;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use App\Services\EmailService;
use Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\IbprBowty\Bowtie;
use App\Models\User;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetailBowtie extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'check_event' => 'check_event',
        'send_approval' => 'send_approval'
    ];

    public $user;
    public $field;
    public $events = [];
    public $reject_reason;
    public $cca = [];
    public $performance = [];
    public $lost_callculation = [];

    public function mount($id){
        $this->user = User::with(['employee', 'department'])->find(Auth::user()->id);
        $this->field = Bowtie::find($id);

        $this->cca = BowtieCca::where('bowtie_id', $id)->get();
        $this->performance = BowtiePerformanceStandard::where('bowtie_id', $id)->get();
        $this->lost_callculation = BowtieLossCalculation::where('bowtie_id', $id)->get();
    }

    public function check_event(){
        $this->field = Bowtie::find($this->field->id);
        $this->cca = BowtieCca::where('bowtie_id', $this->field->id)->get();
        $this->performance = BowtiePerformanceStandard::where('bowtie_id', $this->field->id)->get();
        $this->lost_callculation = BowtieLossCalculation::where('bowtie_id', $this->field->id)->get();
    }

    public function changeStatus()
    {
        $text = 'Yakin untuk melanjutkan?';

        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => $text,
            'onConfirmed' => 'send_approval',
            'inputAttributes' => [
                'value' => $this->field->status
            ],
        ]);
    }

    public function send_approval(){
        $user = User::find(Auth::user()->id);

        if($this->field->status === 'Draft' || $this->field->status === 'Temporary' || $this->field->status === 'Di Reject') {
            $description = $user->name . ' telah melakukan pengajuan BOWTIE kepada DH/OHS';
            $status = 'Pengajuan Kepada DH/OHS';

//            $ohsdept = Department::where('code', 'OHS')->with(['users'])->get()->toArray();
//            $receiptEmail = array_column($ohsdept[0]['users'], 'email');
//            $receiptName = 'Departemen OHS';
        }

        if($this->field->status === 'Pengajuan Kepada DH/OHS') {
            $description = $user->name . ' telah melakukan pengajuan BOWTIE kepada KTT';
            $status = 'Pengajuan Kepada KTT';

            //$ohsdept = Department::where('code', 'KTT')->with(['users'])->get()->toArray();
            //$receiptEmail = array_column($ohsdept[0]['users'], 'email');
            //$receiptName = 'Departemen KTT';
        }

        if($this->field->status === 'Pengajuan Kepada KTT') {
            $description = $user->name . ' telah melakukan persetujuan BOWTIE';
            $status = 'Disetujui';
        }

        if($status === 'Disetujui') {
            $this->field->update([
                'status' => $status,
                'approve_at' => date('Y-m-d'),
            ]);
        }else {
            $this->field->update([
                'status' => $status,
            ]);
        }

//        $email = new EmailService();
//        $payload = [
//            'type' => 'notif_approval',
//            'receiver' => $receiptEmail,
//            'has_attachments' => false,
//            'name' => $receiptName,
//            'module' => 'BOWTIE',
//            'url' => env('APP_URL') . '/ibpr-and-bowtie/bowtie/detail/' . $this->field->id,
//        ];
//
//        $email->sendEmail($payload);

        $activity = [
            'bowtie_id' => $this->field->id,
            'title' => $this->field->status,
            'user_name' => $user->name,
            'description' => $description,
        ];

        BowtieActivity::create($activity);

        $this->field = Bowtie::find($this->field->id);
        $this->alert('success', 'Data berhasil diupdate!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function submit_reject() {
        $user = User::find(Auth::user()->id);

        $this->field->update([
            'status' => 'Di Reject',
            'reject_reason' => $this->reject_reason,
        ]);

        $activity = [
            'bowtie_id' => $this->field->id,
            'title' => $this->field->status,
            'user_name' => $user->name,
            'description' => $user->name . ' telah melakukan reject dengan alasan '. $this->reject_reason,
        ];

        BowtieActivity::create($activity);

        //$this->emit('successReject');
        $this->emit('closeModal');
        $this->alert('success', 'Data berhasil diupdate!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render(){
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.detail.detail')->extends('ibprandbowtie::layouts.no-header');
    }

    public function goto_list_event(Request $request) {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/' . $this->field->id);

        return redirect()->route('ibpr-and-bowtie::bowtie.event-list', [$this->field->id]);
    }


    public function goto_list_cca(Request $request) {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/' . $this->field->id);

        return redirect()->route('ibpr-and-bowtie::bowtie.cca-list', [$this->field->id]);
    }

    public function goto_list_performance(Request $request) {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/' . $this->field->id);

        return redirect()->route('ibpr-and-bowtie::bowtie.perpormnace-standard-list', [$this->field->id]);
    }

    public function goto_list_lost_callculation(Request $request) {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/' . $this->field->id);

        return redirect()->route('ibpr-and-bowtie::bowtie.lost-callculation-list', [$this->field->id]);
    }

    public function export($id)
    {
        $bowtie = Bowtie::find($id);

        return Excel::download(new BowtieExport($bowtie), 'bowtie-export.xlsx');
    }
}

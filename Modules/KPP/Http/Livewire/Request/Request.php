<?php

namespace Modules\KPP\Http\Livewire\Request;

use App\Enums\KPP\ObedienceStatus;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\KPP\Entities\KppObedience;
use Modules\KPP\Entities\KppObedienceEmail;
use Modules\KPP\Entities\KppObedienceRequest;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Jobs\NewObedienceNotificationJob;

class Request extends Component
{
    use LivewireAlert;

    public $dataTables = [];
    public $itemSelected = [];
    public $countSelected = 0;
    public $info = false;
    public $selectAll = false;
    public $comment = '';

    public $invitedPeople = [];
    public $inputInvited = '';

    public $notify_to = 'none';

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function mount()
    {
        $this->dataTables = KppObedienceRequest::where('status', 'Requested')->latest()->get();
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
            //dd($this->countSelected);
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectAll = false;
        } else {
            $this->selectAll = true;
        }

        if (!$this->selectAll) {
            // Deselect all items
            $this->itemSelected = [];
            $this->selectAll = false;
            $this->countSelected = 0;
        } else {
            // Select all items
            $this->itemSelected = $this->dataTables->pluck('id')->map(fn ($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->dataTables->count();

            $this->itemSelected = $this->itemSelected->toArray();
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

    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal');
    }

    public function addInvitedPeople()
    {
        if (in_array($this->inputInvited, $this->invitedPeople)) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon' => 'success',
                'text' => 'Email sudah ada'
            ]);
        } else {
            $this->invitedPeople[] = $this->inputInvited;
            $this->inputInvited = '';
        }
    }

    public function removeInvited($email)
    {
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);
    }

    public function storeObedience()
    {
        try {
            DB::beginTransaction();

            foreach ($this->itemSelected as $item) {
                $request = KppObedienceRequest::find($item);
                $rule = KppRule::find($request->rule_id);

                $existObedience = KppObedience::where('company_id', $request->company_id)
                    ->where('rule_id', $rule->id)
                    ->first();

                if (!$existObedience) {
                    $obedience = KppObedience::create([
                        'rule_id' => $rule->id,
                        'status' => ObedienceStatus::Draft()->value,
                        'company_id' => $request->company_id,
                        'comment' => $this->comment
                    ]);

                    foreach ($this->invitedPeople as $email) {
                        KppObedienceEmail::create([
                            'obedience_id' => $obedience->id,
                            'email' => $email
                        ]);
                    }

                    $user_emails = [];
                    if ($this->notify_to == 'user') {
                        $user_emails = $this->invitedPeople;
                    } elseif ($this->notify_to == 'company') {
                        $company = Company::find($request->company_id);

                        NewObedienceNotificationJob::dispatch('company', $company->email, $obedience);
                    } elseif ($this->notify_to == 'both') {
                        $user_emails = $this->invitedPeople;
                        $company = Company::find($request->company_id);
                        NewObedienceNotificationJob::dispatch('company', $company->email, $obedience);
                    }
                }

                $request->update([
                    'status' => 'Approved'
                ]);

                if (!empty($user_emails)) {
                    NewObedienceNotificationJob::dispatch('user', $user_emails, $rule);
                }
            }

            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('kpp::requests.index');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function render()
    {
        return view('kpp::livewire.request.request')
            ->layout('kpp::layouts.app');
    }
}

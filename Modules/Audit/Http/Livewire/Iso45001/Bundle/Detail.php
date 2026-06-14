<?php

namespace Modules\Audit\Http\Livewire\Iso45001\Bundle;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditTeam;
use Modules\Audit\Entities\AuditTeamRole;
use Modules\Audit\Enums\BundleStatusEnum;

class Detail extends Component
{

    public ?Audit $audit;
    public $progress;

    /**
     * @var User[]
     */
    public mixed $users;

    /**
     * @var AuditTeamRole[]
     */
    public mixed $team_roles;

    public string $name;
    public string $registration_number = "";
    public string $role_id;
    public $evaluator_ids = [];
    public ?string $teamId;

    protected array $rules = [
        'audit.title' => 'required',
        'audit.audit_type' => 'required',
        'audit.company.company_name' => 'required',
        'role_id' => 'required'
    ];

    public function mount($id): void
    {
        $this->getAudit($id);
        $this->users = User::all();
        $this->team_roles = AuditTeamRole::all();
    }

    protected function getAudit($id)
    {
        $this->audit = Audit::with('company', 'auditors', 'evaluators')->find($id);

        $this->progress = formProgress([
            "company_id",
            "audit_type",
            "title",
            "start_at",
            "end_at",
            "auditors",
            "evaluators"
        ],$this->audit->toArray());

        $this->evaluator_ids = $this->audit->evaluators->pluck('user_id')->toArray();

    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    protected function resetTeam(): void
    {
        $this->registration_number = "";
        $this->role_id = "";
        $this->name = "";
        $this->teamId = null;
    }

    public function editTeam($id): void
    {
        $auditor = $this->audit->auditors()->where('id', $id)->first();
        $this->teamId = $id;
        $this->name = $auditor->name;
        $this->role_id = $auditor->audit_team_role_id;
        $this->registration_number = $auditor->registration_number;
        $this->dispatchBrowserEvent('openTeamModal');
    }

    public function saveTeam(): void
    {
        $this->validate([
            'role_id' => 'required|exists:audit_team_roles,id',
            'name' => 'required|max:191',
            // 'registration_number' => 'required|max:191'
        ]);
        try {
            \DB::beginTransaction();
            if (isset($this->teamId)) {
                AuditTeam::where('id', $this->teamId)->update([
                    'name' => $this->name,
                    'audit_id' => $this->audit->id,
                    'audit_team_role_id' => $this->role_id,
                    'registration_number' => $this->registration_number
                ]);
            } else {
                AuditTeam::create([
                    'name' => $this->name,
                    'audit_id' => $this->audit->id,
                    'audit_team_role_id' => $this->role_id,
                    'registration_number' => $this->registration_number
                ]);
            }
            \DB::commit();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            $this->dispatchBrowserEvent('closeModal');
            $this->getAudit($this->audit->id);
            $this->resetTeam();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteTeam($id): void
    {
        AuditTeam::where('id', $id)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->getAudit($this->audit->id);
        $this->resetTeam();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah dihapus'
        ]);
    }


    public function saveStatus($status): void
    {
        
        try {

            $this->validate([
                'evaluator_ids' => 'required|array|min:1',
                'evaluator_ids.*' => 'required|exists:users,id'
            ]);
            \DB::beginTransaction();
            foreach ($this->evaluator_ids as $evaluator_id) {
                $this->audit->evaluators()->firstOrCreate([
                    'user_id' => $evaluator_id
                ]);
            }
            $this->audit->evaluators()->whereNotIn('user_id', $this->evaluator_ids)->delete();
            $this->audit->update(['status' => $status]);
            $this->getAudit($this->audit->id);
            \DB::commit();
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data telah disimpan'
            ]);
            if ($status == BundleStatusEnum::ON_GOING):
                // TODO buat blast notif ke evaluator
            endif;

        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
        }

    }

    public function render(): Factory|View|Application
    {
        // if (\Auth::user()->hasPermissionTo('Audit - Detail ISO45001')) {
            return view('audit::livewire.bundle.detail',
            [
                'category'=>'iso45001'
            ])->layout('audit::livewire.layouts.app');
        // } else {
            return abort(404);
        // }
        
    }

    
}

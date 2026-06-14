<?php

namespace Modules\Audit\Http\Livewire\Iso9001\Location;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\Audit\Entities\Audit;
use Modules\Audit\Entities\AuditLocation;

class Index extends Component
{
    use LivewireAlert;

    public ?Audit $audit;

    public string $location;

    public ?string $locationId;

    protected $listeners = [
        'deleteLocation' => 'deleteLocation'
    ];

    public function mount($id): void
    {
        $this->getAudit($id);
    }

    protected function getAudit($id)
    {
        $this->audit = Audit::with('company', 'auditors', 'evaluators')->find($id);
    }

    public function hydrate(): void
    {
        $this->emit('select2');
    }

    protected function resetLocation(): void
    {
        $this->location = "";
        $this->locationId = null;
    }

    public function editLocation($id): void
    {
        $location = $this->audit->locations()->where('id', $id)->first();
        $this->locationId = $id;
        $this->location = $location->location;
        $this->dispatchBrowserEvent('openLocationModal');
    }

    public function saveLocation(): void
    {
        $this->validate([
            'location' => 'required|max:191',
        ]);
        try {
            \DB::beginTransaction();
            if (isset($this->locationId)) {
                AuditLocation::where('id', $this->locationId)->update([
                    'location' => $this->location,
                    'audit_id' => $this->audit->id,
                ]);
            } else {
                AuditLocation::create([
                    'location' => $this->location,
                    'audit_id' => $this->audit->id,
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
            $this->resetLocation();
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Whoops',
                'icon' => 'error',
                'text' => $exception->getMessage()
            ]);
            $this->dispatchBrowserEvent('closeModal');
        }

    }

    public function deleteConfirmation($id)
    {
        $this->locationId = $id;
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
            'onConfirmed' => 'deleteLocation',
        ]);
    }

    public function deleteLocation(): void
    {
        AuditLocation::where('id', $this->locationId)->delete();
        $this->dispatchBrowserEvent('closeModal');
        $this->getAudit($this->audit->id);
        $this->resetLocation();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data telah dihapus'
        ]);
    }

    public function render()
    {
        return view('audit::livewire.location.index',
            [
                'category'=>'smkp'
            ])->layout('audit::livewire.layouts.app');
    }
}

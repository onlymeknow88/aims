<?php

namespace Modules\CSMS\Http\Livewire\Pjo\Active;

use App\Enums\CSMS\CsmsStatus;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\CSMS\Entities\CsmsPjo;

class Detail extends Component
{
    use LivewireAlert;

    public $pjo;
    public $files = [];

    public function mount($id)
    {
        $this->pjo = CsmsPjo::find($id);

        $this->files = $this->pjo->files->groupBy('type')->toArray();
    }

    public function approve($status, $requested)
    {
        try {

            DB::beginTransaction();

            $this->pjo->update([
                'status' => $status,
                'requested' => $requested,
                'date_approved' => Carbon::now(),
            ]);

            if ($status == CsmsStatus::Approved) {
                $company = Company::where('company_name', $this->pjo->company->company_name)->first();

                if (!empty($company)) {
                    $checkUser = User::where('email', $this->pjo->email)->first();

                    if (empty($checkUser)) {
                        $user = User::create([
                            'name' => $this->pjo->name,
                            'email' => $this->pjo->email,
                            'password' => bcrypt('123123123'),
                        ]);
                    } else {
                        $this->alert('error', 'Email PJO sudah terdaftar!', [
                            'position' => 'top-end',
                            'timer' => 3000,
                            'toast' => true,
                        ]);

                        return false;
                    }


                    $cc = $company->update([
                        'user_id' => $user->id,
                    ]);
                }
            }

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::pjo.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function render()
    {
        return view('csms::livewire.pjo.active.detail')->extends('csms::layouts.no-header');
    }
}

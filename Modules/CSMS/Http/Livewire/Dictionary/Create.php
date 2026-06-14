<?php

namespace Modules\CSMS\Http\Livewire\Dictionary;

use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\CSMS\Entities\CsmsDictionary;

class Create extends Component
{
    use LivewireAlert;

    public $term;
    public $definition;
    public $reference;

    protected $rules = [
        'term' => 'required',
        'definition' => 'required',
        'reference' => 'required',
    ];

    public function store()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $dictionary = CsmsDictionary::create([
                'term' => $this->term,
                'definition' => $this->definition,
                'reference' => $this->reference,
            ]);


            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::dictionary.index');
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
        return view('csms::livewire.dictionary.create')->extends('csms::layouts.no-header');
    }
}

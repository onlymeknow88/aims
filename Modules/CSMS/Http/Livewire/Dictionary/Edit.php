<?php

namespace Modules\CSMS\Http\Livewire\Dictionary;

use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Modules\CSMS\Entities\CsmsDictionary;

class Edit extends Component
{
    use LivewireAlert;

    public $dictionary;
    public $term;
    public $definition;
    public $reference;

    public function mount($id)
    {
        $this->dictionary = CsmsDictionary::find($id);

        $this->term = $this->dictionary->term;
        $this->definition = $this->dictionary->definition;
        $this->reference = $this->dictionary->reference;
    }

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

            $this->dictionary->update([
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
        return view('csms::livewire.dictionary.edit')->extends('csms::layouts.no-header');
    }
}

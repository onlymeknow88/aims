<?php

namespace App\Http\Livewire\MainDashboard\General;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\MainDashboard\General;

class Create extends Component
{
    public $input, $Id;

    protected $rules = [
        'input.month' => 'required',
        'input.project_to_date' => 'required|numeric',
        'input.manhours' => 'required|numeric',
        'input.day_after_last_lti' => 'required|numeric',
        'input.manpower' => 'required|numeric'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($id = null)
    {
        //show last data
        if ($id) {
            $this->Id = $id;
            $getLast = General::where('id', $id)->first();
            $getLast->month = date('M Y', strtotime($getLast->month));
            $this->input = json_decode($getLast, true);
        }
    }

    public function store()
    {
        General::where('visible', 'true')->update(['visible' => 'false']);

        //input
        $new = $this->input;
        $new['month'] = date('Y-m-d', strtotime($new['month'] . '-1'));
        $new['visible'] =  'true';
        //validate
        $validation = [
            'input.month' => 'required',
            'input.project_to_date' => 'required|numeric',
            'input.manhours' => 'required|numeric',
            'input.day_after_last_lti' => 'required|numeric',
            'input.manpower' => 'required|numeric'
        ];

        $this->validate($validation);


        $newProjectToDate = $new['project_to_date'];
        $newManhours = $new['manhours'];
        $newDayAfterLastLti = $new['day_after_last_lti'];
        $newManpower = $new['manpower'];

        //before
        if (empty($this->Id)) {
            //terakhir
            $before =  General::orderBy('created_at', 'desc')->first();
        } else {
            //1 tingkat dibawahnya
            $before =  General::where('id', '<', $this->Id)->orderBy('created_at', 'desc')->first();
        }

        if ($before) {
            $beforeProjectToDate = $before->project_to_date;
            $beforeProjectToDateMark = $before->project_to_date_mark;
            $beforeManhours = $before->manhours;
            $beforeManhoursMark = $before->manhours_mark;
            $beforeDayAfterLastLti = $before->day_after_last_lti;
            $beforeDayAfterLastLtiMark = $before->day_after_last_lti_mark;
            $beforeManpower = $before->manpower;
            $beforeManpowerMark = $before->manpower_mark;

            //compare new and before
            $new['project_to_date_mark'] = $newProjectToDate > $beforeProjectToDate ? "UP" : ($newProjectToDate < $beforeProjectToDate  ? "DOWN" : $beforeProjectToDateMark);
            $new['manhours_mark'] = $newManhours > $beforeManhours  ? "UP" : ($newManhours < $beforeManhours ? "DOWN" :  $beforeManhoursMark);
            $new['day_after_last_lti_mark'] = $newDayAfterLastLti > $beforeDayAfterLastLti ? "UP" : ($newDayAfterLastLti < $beforeDayAfterLastLti ? "DOWN" : $beforeDayAfterLastLtiMark);
            $new['manpower_mark'] = $newManpower > $beforeManpower ? "UP" : ($newManpower < $beforeManpower ? "DOWN" : $beforeManpowerMark);
        }

        //create new
        $new['user_id'] = Auth::id();
        unset($new['id']);
        General::updateOrCreate(['id' => $this->Id], $new);

        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');
        return redirect()->route('general_index');
    }

    public function render()
    {
        return view('livewire.main-dashboard.general.create')
        ->extends('layouts.no-header');
    }
}

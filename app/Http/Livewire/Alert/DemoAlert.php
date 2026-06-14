<?php

namespace App\Http\Livewire\Alert;

use Livewire\Component;

class DemoAlert extends Component
{
    public function render()
    {
        return view('livewire.alert.demo-alert');
    }

    public function success(){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'=>'success',
            'text'  => 'Data berhasil di simpan'
        ]);
    }

    public function info(){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Data Salah',
            'icon'=>'info',
            'text'  => 'Data Yang di simpan salah'
        ]);
    }

    public function danger(){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Gagal Menyimpan',
            'icon'=>'error',
            'text'  => 'Data gagal di simpan'
        ]);
    }

    public function warning(){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Awas',
            'icon'=>'warning',
            'text'  => 'Awas ada kucing galak'
        ]);
    }

    public function destroy($id){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'=>'success',
            'text'  => 'Data ' .$id. ' berhasil di hapus'
        ]);
    }

    public function timer(){
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'  =>'success',
            'text'  => 'Popup ini akan hilang sendiri',
            'timer' => 1500
        ]);
    }
}

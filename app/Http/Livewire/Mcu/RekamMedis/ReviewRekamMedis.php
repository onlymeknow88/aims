<?php

namespace App\Http\Livewire\Mcu\RekamMedis;

use Livewire\Component;
use PDF;

class ReviewRekamMedis extends Component
{
    public $status;
    public $dokter;
    public $saran;

    // digunakan untuk select2 initialize options
    public function hydrate()
    {
        $this->emit('select2');
    }
    
    public function render()
    {
        return view('livewire.mcu.rekam-medis.review-rekam-medis')->extends('layouts.no-header');
    }

    protected $rules = [
        'status' => 'required',
        'dokter' => 'required',
        'saran' => 'required',
    ];

    public function saveReview(){
        $validatedData = $this->validate();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'=>'success',
            'text'  => 'Data berhasil di simpan'
        ]);

    }

    public function cetakSertifikat(){
        $data = [
            'no_doc' => 'F-MAC-IHH-02-008',
            'revisi'    => '0.0',
            'tgl_doc'   => '01-10-2020',
            'no_skks'   => 'SKKs/015/I/2023',
            'nama'      => 'Sasongko Wisnu Prabowo',
            'tgl_lahir' => '40 Tahun',
            'perusahaan'    => 'PT. Saptaindra Sejati',
            'jabatan'       => 'Project Control',
            'dokter_peninjau'   => 'Dr AHLIZAR',
            'tgl_mcu'           => '01/11/2022',
            'tempat_mcu'        => 'Tirta Medical Center',
            'pendamping'        => '-',
            'dept_pendamping'   => '-',
            'berlaku_dari'      => '20 February 2023',
            'berlaku_sampai'    => '16 April 2023'
        ];
        $pdfContent = PDF::loadView('livewire.mcu.rekam-medis.sertifikat', $data)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "filename.pdf"
        );
    }
}

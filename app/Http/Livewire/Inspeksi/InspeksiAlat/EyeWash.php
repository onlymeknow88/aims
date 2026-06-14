<?php

namespace App\Http\Livewire\Inspeksi\InspeksiAlat;

use Livewire\Component;

class EyeWash extends Component
{
    public $nomor_identitas;
    public $kriteria_inspeksi;
    public $tanggal;
    public $ccow;
    public $nama_perusahaan;
    public $departemen;
    public $section;
    public $lokasi;
    public $detail_lokasi;
    public $ktt;
    public $pja;
    public $petugas_inspeksi_1;
    public $petugas_inspeksi_2;
    public $petugas_inspeksi_3;
    public $id_eye_wash;

    public $merk_eye_wash;
    public $file_merk_eye_wash;
    public $komentar_merk_eye_wash;

    public $type_eye_wash;
    public $file_type_eye_wash;
    public $komentar_type_eye_wash;

    public $versi_tangki;
    public $kondisi_tangki;
    public $file_kondisi_tangki;
    public $komentar_kondisi_tangki;

    public $versi_air;
    public $kondisi_air;
    public $file_kondisi_air;
    public $komentar_kondisi_air;

    public $versi_pancuran_air;
    public $kondisi_pancuran_air;
    public $file_pancuran_air;
    public $komentar_pancuran_air;    

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-alat.eye-wash')->extends('layouts.no-header');
    }
}

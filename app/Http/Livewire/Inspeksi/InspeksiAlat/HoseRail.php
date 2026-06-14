<?php

namespace App\Http\Livewire\Inspeksi\InspeksiAlat;

use Livewire\Component;

class HoseRail extends Component
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
    public $id_hose_rail;
    public $tanggal_service;

    public $type_hose_rail;
    public $file_type_hose_rail;
    public $komentar_type_hose_rail;

    public $ukuran_coupling;
    public $versi_coupling;
    public $kondisi_ukuran_coupling;
    public $file_ukuran_coupling;
    public $komentar_ukuran_coupling;

    public $outer_pilar;
    public $file_outer_pilar;
    public $komentar_outer_pilar;

    public $jenis_hose_rail;
    public $kondisi_jenis_hose_rail;
    public $versi_hose;
    public $file_jenis_hose_rail;
    public $komentar_jenis_hose_rail;

    public $ukuran_hose;
    public $file_ukuran_hose;
    public $komentar_ukuran_hose;

    public $type_nozzle;
    public $versi_nozzle;
    public $kondisi_type_nozzle;
    public $file_type_nozzle;
    public $komentar_type_nozzle;

    public $box_hose_rail;
    public $kondisi_box_hose_rail;
    public $file_box_hose_rail;
    public $komentar_box_hose_rail;

    public $penempatan;
    public $file_penempatan;
    public $komentar_penempatan;

    public $kip;
    public $kondisi_kip;
    public $file_kip;
    public $komentar_kip;

    public $label_penanda;
    public $file_label_penanda;
    public $komentar_label_penanda;

    public $demarkasi;
    public $file_demarkasi;
    public $komentar_demarkasi;

    public $velve_pipa;
    public $kondisi_velve_pipa;
    public $file_velve_pipa;
    public $komentar_velve_pipa;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function render()
    {
        return view('livewire.inspeksi.inspeksi-alat.hose-rail')->extends('layouts.no-header');
    }
}

<?php

namespace App\Http\Livewire\Inspeksi\InspeksiAlat;

use Livewire\Component;

class Apar extends Component
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
    public $id_apar;
    public $tanggal_service;
    public $isi_apar;
    public $file_isi;
    public $komentar_isi;
    public $gol_apar;
    public $kapasitas_apar;
    public $file_kapasitas;
    public $komentar_kapasitas;
    public $tuas_apar;
    public $kondisi_tuas_apar;
    public $file_tuas;
    public $komentar_tuas;
    public $handle_apar;
    public $kondisi_handle_apar;
    public $file_handle_apar;
    public $komentar_handle_apar;

    public $pressure_gauge;
    public $kondisi_pressure_gauge;
    public $file_pressure_gauge;
    public $komentar_pressure_gauge;

    public $pin_apar;
    public $kondisi_pin_apar;
    public $file_pin_apar;
    public $komentar_pin_apar;

    public $hose_apar;
    public $kondisi_hose_apar;
    public $file_hose_apar;
    public $komentar_hose_apar;

    public $nozzle_apar;
    public $kondisi_nozzle_apar;
    public $file_nozzle_apar;
    public $komentar_nozzle_apar;

    public $kondisi_tabung;
    public $kondisi_kondisi_tabung;
    public $file_kondisi_tabung;
    public $komentar_kondisi_tabung;

    public $cat_tabung;
    public $kondisi_cat_tabung;
    public $file_cat_tabung;
    public $komentar_cat_tabung;
    
    public $powder;
    public $kondisi_powder;
    public $file_powder;
    public $komentar_powder;

    public $kip;
    public $kondisi_kip;
    public $file_kip;
    public $komentar_kip;

    public $bracket;
    public $kondisi_bracket;
    public $file_bracket;
    public $komentar_bracket;

    public $label_penanda;
    public $file_label_penanda;
    public $komentar_label_penanda;

    public $demarkasi;
    public $file_demarkasi;
    public $komentar_demarkasi;

    public $kain_pelindung;
    public $file_kain_pelindung;
    public $komentar_kain_pelindung;

    public $kondisi_kain;
    public $file_kondisi_kain;
    public $komentar_kondisi_kain;

    public $penempatan;
    public $kondisi_penempatan;
    public $file_penempatan;
    public $komentar_penempatan;

    public function hydrate()
    {
        $this->emit('select2');
    }
    
    public function render()
    {
        return view('livewire.inspeksi.inspeksi-alat.apar')->extends('layouts.no-header');
    }
}

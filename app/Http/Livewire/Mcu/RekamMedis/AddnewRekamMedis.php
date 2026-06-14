<?php

namespace App\Http\Livewire\Mcu\RekamMedis;

use Livewire\Component;
use Carbon\Carbon;

class AddnewRekamMedis extends Component
{
    public $nama_perusahaan;
    public $status;
    public $department;
    public $position;
    public $nip;
    public $no_ktp;
    public $tgl_lahir;
    public $umur = 0;
    public $jk = 'l';
    public $medical_type;
    public $provider;
    public $mcu_date;
    public $mcu_exp_date;
    public $mcu_review_date;
    public $keluhan = 'ada';
    public $r_penyakit = [];
    public $r_penyakit_keluarga = [];
    public $alergi = [];
    public $merokok = 'ya';
    public $rokok = 0;
    public $olahraga = 'ya';
    public $f_olahraga;
    public $j_olahraga;
    public $m_alkohol = 'ya';
    public $k_menstruasi;
    public $lama_haid;
    public $siklus_m_1 = 'ya';
    public $siklus_m_2 = 'ya';
    public $r_hamil;
    public $spontan;
    public $bantuan;
    public $keguguran;
    public $kontrasepsi = 'ya';
    public $j_kontrasepsi;
    public $pekerjaan_sekarang;
    public $pekerjaan_sebelumnya;
    public $hep_1;
    public $hep_2;
    public $hep_3;
    public $typhoid_1;
    public $typhoid_3;
    public $albendandazole;
    public $tinggi = 0;
    public $berat = 0;
    public $body_mass = 0;
    public $gizi;
    public $bb_terendah;
    public $bb_tertinggi;
    public $sistolik = 0;
    public $diastolik = 0;
    public $nadi = 0;
    public $respiratory = 0;
    public $suhu = 0;
    public $tekanan_darah;
    public $heent;
    public $orodental;
    public $kardiovaskuler;
    public $digestivus;
    public $genitourinarius;
    public $neuromuskular;
    public $hep_A_1;
    public $non_koreksi_od;
    public $non_koreksi_os;
    public $non_koreksi_ods;
    public $koreksi_od;
    public $koreksi_os;
    public $koreksi_ods;
    public $kesan_visus_jauh;
    public $reading_test;
    public $buta_warna = 'normal';
    public $catatan;
    public $ac_kanan_500 = 0;
    public $ac_kanan_1000 = 0;
    public $ac_kanan_2000 = 0;
    public $ac_kanan_3000 = 0;
    public $ac_kanan_4000 = 0;
    public $ac_kanan_6000 = 0;
    public $ac_kanan_8000 = 0;
    public $ac_kanan_htl = 0;
    public $bc_kanan_500 = 0;
    public $bc_kanan_1000 = 0;
    public $bc_kanan_2000 = 0;
    public $bc_kanan_3000 = 0;
    public $bc_kanan_4000 = 0;
    public $bc_kanan_6000 = 0;
    public $bc_kanan_8000 = 0;
    public $bc_kanan_htl = 0;
    public $ac_kiri_500 = 0;
    public $ac_kiri_1000 = 0;
    public $ac_kiri_2000 = 0;
    public $ac_kiri_3000 = 0;
    public $ac_kiri_4000 = 0;
    public $ac_kiri_6000 = 0;
    public $ac_kiri_8000 = 0;
    public $ac_kiri_htl = 0;
    public $bc_kiri_500 = 0;
    public $bc_kiri_1000 = 0;
    public $bc_kiri_2000 = 0;
    public $bc_kiri_3000 = 0;
    public $bc_kiri_4000 = 0;
    public $bc_kiri_6000 = 0;
    public $bc_kiri_8000 = 0;
    public $bc_kiri_htl = 0;
    public $kesimpulan;
    public $kesan_audiometri;
    public $fvc = 0.0;
    public $fev1 = 0.0;
    public $kesan_spirometri;
    public $xray_thorax;
    public $ekg;
    public $treadmill;
    public $echocardiography;
    public $additional_diagnosis;
    public $hb = 0.0;
    public $ht = 0.0;
    public $leukosit = 0;
    public $thrombosit = 0;
    public $eritrosit = 0.0;
    public $led = 0;
    public $gol_darah;
    public $rhesus;
    public $sgot = 0;
    public $sgpt = 0;
    public $gamma_gt = 0;
    public $kolesterol = 0;
    public $hdl = 0;
    public $ldl = 0;
    public $tga = 0;
    public $billirubin_total = 0;
    public $billirubin_direk = 0;
    public $billirubin_indirek = 0;
    public $dislipidemia = 0;
    public $gdpt = 0;
    public $g2pp = 0;
    public $hiperglikemia;
    public $hba1c = 0;
    public $dm;
    public $risk_score;
    public $risk_level = 0;
    public $ureum = 0;
    public $bun = 0;
    public $creatinin = 0;
    public $asam_urat = 0;
    public $egfr = 0;
    public $hbs_ag;
    public $anti_hbs;
    public $anti_hav;
    public $malaria;
    public $warna_urine;
    public $kejernihan_urine;
    public $ph_urine = 0.0;
    public $berat_jenis_urine = 0.0;
    public $protein_urine;
    public $glukosa_urine;
    public $bilirubin_urine;
    public $urobilin_urine;
    public $keton_urine;
    public $darah_urine;
    public $lekositesterase_urine;
    public $nitrit_urine;
    public $sedimen_urine = 0;
    public $eritrosit_urine = 0;
    public $epitel_urine = 0;
    public $silinder_urine;
    public $kristal_urine;
    public $bakteri;
    public $lainnya_urine;
    public $amp;
    public $met;
    public $bdz;
    public $coc;
    public $opi;
    public $thc;
    public $analisa_feses;
    public $kultur_feses;
    public $hasil_temuan = 'Tidak di lakukan pemeriksaan Audiometri,Prehipertemtion, Tidak dilakukan pemeriksaan rektal, Gigi : terdapat plaque, Dislipidemia (Cholestrol 226 mg/dl, Trigliserid 172 mg/dl), Hasil EKG: SR+LVH, hasil Treadmil : Treadmill Stress test:Positive, Cardiopulmonary fitness Classification: good. Positive Ischaemic Response';
    public $matrix = 'Sesuai';

    // digunakan untuk select2 initialize options
    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount(){
        $this->tgl_lahir = Carbon::now()->format('d F Y');
    }

    public function render()
    {
        return view('livewire.mcu.rekam-medis.addnew')->extends('layouts.no-header');
    }

    protected $rules = [
        'catatan' => 'required',
    ];

    public function save(){
        $validatedData = $this->validate();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon'=>'success',
            'text'  => 'Data berhasil di simpan'
        ]);
    }
}

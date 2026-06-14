<?php

namespace Modules\Mcu\Imports;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\ValidationException;
use Modules\Mcu\Entities\FormulaBloodPressure;
use Modules\Mcu\Entities\FormulaDislipidemia;
use Modules\Mcu\Entities\MedicalHistory;
use Modules\Mcu\Entities\Provider;

class MedicalHistoryImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    public $medical_ex_type_opt = array("office-group", "field-officer", "general-housekeeping", "food-handler");
    public $medical_type_opt = array("pre-employment", "periodic", "pre-retirement");

    public function rules(): array
    {
        return [
            '*.nik' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('NIK tidak boleh kosong !');
                }
            },
            '*.posisi' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Posisi tidak boleh kosong !');
                }
            },
            '*.email' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    //     $count = User::where('email', $value)->count();
                    //     if ($count > 0) {
                    //         $onFailure('Email sudah terdaftar di sistem !');
                    //     }
                    // } else {
                    $onFailure('Email Tidak boleh kosong !');
                }
            },
            '*.nama_pasien' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Nama Pasien Tidak boleh kosong !');
                }
            },
            '*.jenis_kelamin' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Jenis Kelamin Tidak boleh kosong !');
                }
            },
            '*.departemen' => function ($attribute, $value, $onFailure) {
                if ($value) {
                    $count = Department::where('name', $value)->count();
                    if ($count < 1) {
                        $onFailure('Departemen tidak terdaftar di sistem !');
                    }
                } else {
                    $onFailure('Departemen tidak boleh kosong !');
                }
            },
            '*.penyedia_jasa_pemeriksaan' => function ($attribute, $value, $onFailure) {
                if ($value) {
                    $count = Provider::where('name', $value)->count();
                    if ($count < 1) {
                        $onFailure('Penyedia Jasa Pemeriksaan tidak terdaftar di sistem !');
                    }
                } else {
                    $onFailure('Penyedia Jasa Pemeriksaan tidak boleh kosong !');
                }
            },
            '*.tanggal_lahir' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Tanggal Lahir Tidak boleh kosong !');
                }
            },
            '*.program' => function ($attribute, $value, $onFailure) {
                if ($value) {
                    if (!in_array($value, $this->medical_ex_type_opt)) {
                        $onFailure('Program tidak sesuai format !');
                    }
                } else {
                    $onFailure('Program Tidak boleh kosong !');
                }
            },
            '*.jenis_pemeriksaan_kesehatan' => function ($attribute, $value, $onFailure) {
                if ($value) {
                    if (!in_array($value, $this->medical_type_opt)) {
                        $onFailure('Jenis Pemeriksaan Kesehatan tidak sesuai format !');
                    }
                } else {
                    $onFailure('Jenis Pemeriksaan Kesehatan Tidak boleh kosong !');
                }
            },

            '*.tanggal_mcu' => 'required',
            '*.height' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Tinggi badan (height) Tidak boleh kosong !');
                }
            },
            '*.weight' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Berat badan (weight) Tidak boleh kosong !');
                }
            },
            '*.systolic_blood_pressure' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Tekanan Darah Sistolik (systolic_blood_pressure) Tidak boleh kosong !');
                }
            },
            '*.diastolic_blood_pressure' => function ($attribute, $value, $onFailure) {
                if (!$value) {
                    $onFailure('Tekanan Darah Diastolik (diastolic_blood_pressure) Tidak boleh kosong !');
                }
            },
        ];

    }

    public function treadmill($value)
    {
        if ($employee_age > 40) {
            $treadmill = $row['treadmill'];
            if (!$treadmill) {
                throw ValidationException::withMessages(['team' => 'Team does not exist']);
                dd('Treadmill Tidak boleh kosong !');
            }

            $echocardiography = $row['echocardiography'];
            $additional_diagnosis = $row['additional_diagnosis'];
        } else {
            $treadmill = null;
            $echocardiography = null;
            $additional_diagnosis = null;
        }
    }

    public function customValidationMessages()
    {
        return [
            '*.tanggal_mcu' => 'Tanggal MCU Tidak boleh kosong !',
        ];
    }

    public function model(array $row)
    {
        try {
            $id_number = $row['nik'];
            $provider_id = Provider::where('name', $row['penyedia_jasa_pemeriksaan'])->first()->id;
            $employee = Employee::where('id_number', $id_number)->first();

            DB::beginTransaction();

            if ($employee) {
                $this->employeeId = $employee->id;
                if ($row['alamat']) {
                    Employee::where('id_number', $id_number)->update(['address' => $row['alamat']]);
                }
            } else {
                $dept = Department::where('name', $row['departemen'])->first();

                $count_user = User::where('email', $row['email'])->count();
                if ($count_user > 0) {
                    $onFailure('Email sudah terdaftar di sistem !');
                }

                $user = new User;
                $user->name = $row['nama_pasien'];
                $user->email = $row['email'];
                $user->password = '$2y$10$wGUIAj.AT56sxspLjGgTq.mhGey4RvSPvswDIiIqVeWSlxIHUg2rG';
                $user->department()->associate($dept->id);
                $user->save();

                $employee = new Employee;
                $employee->user_id = $user->id;
                $employee->id_number = $row['nik'];
                $employee->number = $row['nip'];
                $employee->name = $row['nama_pasien'];
                $employee->gender = $row['jenis_kelamin'];
                $employee->blood_type = $row['golongan_darah'];
                $employee->position = $row['posisi'];
                $employee->department_id = $dept->id;
                $employee->date_of_birth = Carbon::createFromFormat('d m Y', $row['tanggal_lahir']);
                $employee->address = $row['alamat'] ? $row['alamat'] : '';
                $employee->save();
            }

            $employee_age = Carbon::parse($employee->date_of_birth)->age;

            $FormulaBloodPressure = FormulaBloodPressure::where('status', 'active')->first();
            $formula_blood_pressure_id = $FormulaBloodPressure->id;

            $FormulaDislipidemia = FormulaDislipidemia::where('status', 'active')->first();
            $formula_dislipidemia_id = $FormulaDislipidemia->id;

            $medical_type = $row['jenis_pemeriksaan_kesehatan'];
            $medical_ex_type = $row['program'];

            // Date Parsing
            $mcu_date = Carbon::createFromFormat('d m Y', $row['tanggal_mcu']);
            $mcu_exp_date = $mcu_date->addYear();

            if ($medical_ex_type == 'food-handler') {
                $vaccination_hep_a1 = ($row['hep_a_1st']) ? Carbon::parse($row['hep_a_1st']) : null ;
                $vaccination_hep_a2 = $row['hep_a_2nd'] ? Carbon::parse($row['hep_a_2nd']) : null;
                $vaccination_hep_a3 = $row['hep_a_3_years'] ? Carbon::parse($row['hep_a_3_years']) : null;
                $vaccination_typhoid_1 = $row['typhoid_1st'] ? Carbon::parse($row['typhoid_1st']) : null;
                $vaccination_typhoid_3 = $row['typhoid_3_years'] ? Carbon::parse($row['typhoid_3_years']) : null;
                $vaccination_albendandazole = $row['albendandazole_400mg'] ? Carbon::parse($row['albendandazole_400mg']) : null;
            } else {
                $vaccination_hep_a1 = null;
                $vaccination_hep_a2 = null;
                $vaccination_hep_a3 = null;
                $vaccination_typhoid_1 = null;
                $vaccination_typhoid_3 = null;
                $vaccination_albendandazole = null;
            }

            // Rumus
            $height = $row['tinggi_badan'];
            $weight = $row['berat_badan'];

            $gender = $employee->gender;

            $bmi = imt_ideal($height, $weight);

            // Temuan bmi
            $findings = [];

            if ($bmi >= 35) {
                $findings['bmi'] = 'Index massa tubuh : ' . $bmi . ' kg/m2';
                $status = 'Curently Unfit';
            }

            $bmi_lower = imt_ideal_limit($gender, $height, 'low');
            $bmi_upper = imt_ideal_limit($gender, $height, 'up');
            $nutritional_status = nutritional_status($bmi);

            $systolic_blood_pressure = $row['tekanan_darah_sistolik_mmhg'];
            $diastolic_blood_pressure = $row['tekanan_darah_diastolik_mmhg'];

            $formula = FormulaBloodPressure::where('status', 'active')->first();
            $blood_pressure_status = blood_pressure_status($systolic_blood_pressure, $diastolic_blood_pressure, $formula);

            if ($blood_pressure_status == 'Pre - Hipertensi') {
                $findings['blood_pressure_status'] = 'Pre - Hipertensi';
                $findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $systolic_blood_pressure . ' mmHg';
                $findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $diastolic_blood_pressure . ' mmHg';
            } elseif ($blood_pressure_status == 'Hipertensi Tingkat 1') {
                $findings['blood_pressure_status'] = 'Hipertensi Tingkat 1';
                $findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $systolic_blood_pressure . ' mmHg';
                $findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $diastolic_blood_pressure . ' mmHg';
            } elseif ($blood_pressure_status == 'Hipertensi Tingkat 2') {
                $findings['blood_pressure_status'] = 'Hipertensi Tingkat 2';
                $findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $systolic_blood_pressure . ' mmHg';
                $findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $diastolic_blood_pressure . ' mmHg';
            } else {
                $findings['blood_pressure_status'] = 'Hipertensi Tingkat 2';
                $findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $systolic_blood_pressure . ' mmHg';
                $findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $diastolic_blood_pressure . ' mmHg';
            }

            if ($employee->gender == 'male') {
                $menstrual_menarche = null;
                $menstrual_cycle = null;
                $menstrual_pain = null;
                $menstrual_period = null;
                $pregnant_period = null;
                $pregnant_spontan = null;
                $pregnant_surgery = null;
                $pregnant_abortion = null;
                $contraception = null;
                $contraception_type = null;
            } else {
                $menstrual_menarche = $row['menarche'];
                $menstrual_cycle = $row['keteraturan_siklus'];
                $menstrual_pain = $row['nyeri_haid'];
                $menstrual_period = $row['lama_haid_hari'];
                $pregnant_period = $row['hamil_frekuensi'];
                $pregnant_spontan = $row['spontan_frekuensi'];
                $pregnant_surgery = $row['bantuan_operasi_frekuensi'];
                $pregnant_abortion = $row['keguguran_frekuensi'];
                $contraception = $row['kontrasepsi'];
                $contraception_type = $row['jenis_kontrasepsi'];
            }

            if ($employee_age <= 55) {
                $visus_non_correction_od = $row['visus_jauh_od_non_koreksi'];
                $visus_non_correction_os = $row['visus_jauh_os_non_koreksi'];
                $visus_non_correction_ods = $row['visus_jauh_ods_non_koreksi'];
                $visus_correction_od = $row['visus_jauh_od_koreksi'];
                $visus_correction_os = $row['visus_jauh_os_koreksi'];
                $visus_correction_ods = $row['visus_jauh_ods_koreksi'];
                $visus_impression = $row['kesan_visus_jauh'];
                $visus_reading_test = $row['reading_test_visus_dekat_jaeger_test'];
                $visus_color_blind = $row['buta_warna'];
                $visus_field_of_view = $row['lapangan_pandang'];
                $visus_notes = $row['lain_lain_catatan'];

                $laboratory_hbsag = $row['laboratory_hbsag'];
                $laboratory_anti_hbs = $row['laboratory_anti_hbs'];

                $laboratory_malary = $row['laboratory_malary'];

                $laboratory_urinalysis_amp = $row['amp'];
                $laboratory_urinalysis_met = $row['met'];
                $laboratory_urinalysis_bdz = $row['bdz'];
                $laboratory_urinalysis_coc = $row['coc'];
                $laboratory_urinalysis_opi = $row['opi'];
                $laboratory_urinalysis_thc = $row['thc'];

                if (($medical_ex_type == 'food-handler' && $medical_type != 'pre-retirement') || ($medical_ex_type == 'general-housekeeping' && $medical_type != 'pre-retirement')) {
                    $laboratory_anti_havlgm = $row['laboratory_anti_havlgm'];

                    $laboratory_urinalysis_feces_analysis = $row['analisis_feses'];
                    $laboratory_urinalysis_feces_culture = $row['kultur_feses'];
                    $cholinesterase = $row['cholinesterase'];
                } else {
                    $laboratory_anti_havlgm = null;

                    $laboratory_urinalysis_feces_analysis = null;
                    $laboratory_urinalysis_feces_culture = null;
                    $cholinesterase = $row['cholinesterase'];
                }

                if ($medical_ex_type == 'food-handler') {
                    $laboratory_widal = $row['laboratory_widal'];
                } else {
                    $laboratory_widal = null;
                }

            } else {
                $visus_non_correction_od = null;
                $visus_non_correction_os = null;
                $visus_non_correction_ods = null;
                $visus_correction_od = null;
                $visus_correction_os = null;
                $visus_correction_ods = null;
                $visus_impression = null;
                $visus_reading_test = null;
                $visus_color_blind = null;
                $visus_field_of_view = null;
                $visus_notes = null;

                $laboratory_hbsag = null;
                $laboratory_anti_hbs = null;
                $laboratory_malary = null;

                $laboratory_urinalysis_amp = null;
                $laboratory_urinalysis_met = null;
                $laboratory_urinalysis_bdz = null;
                $laboratory_urinalysis_coc = null;
                $laboratory_urinalysis_opi = null;
                $laboratory_urinalysis_thc = null;
                $laboratory_anti_havlgm = null;
                $laboratory_urinalysis_feces_analysis = null;
                $laboratory_urinalysis_feces_culture = null;
                    $cholinesterase = null;
                    $laboratory_widal = null;

            }

            if (($medical_ex_type != 'office-group' || $medical_ex_type != 'food-handler') && $medical_type != 'periodic') {
                $audiometry_right_air_conduction_500 = $row['audiometry_right_air_conduction_500'];
                $audiometry_right_air_conduction_1000 = $row['audiometry_right_air_conduction_1000'];
                $audiometry_right_air_conduction_2000 = $row['audiometry_right_air_conduction_2000'];
                $audiometry_right_air_conduction_3000 = $row['audiometry_right_air_conduction_3000'];
                $audiometry_right_air_conduction_4000 = $row['audiometry_right_air_conduction_4000'];
                $audiometry_right_air_conduction_6000 = $row['audiometry_right_air_conduction_6000'];
                $audiometry_right_air_conduction_8000 = $row['audiometry_right_air_conduction_8000'];
                $audiometry_right_air_conduction_htl = $row['audiometry_right_air_conduction_htl'];
                $audiometry_right_bone_conduction_500 = $row['audiometry_right_bone_conduction_500'];
                $audiometry_right_bone_conduction_1000 = $row['audiometry_right_bone_conduction_1000'];
                $audiometry_right_bone_conduction_2000 = $row['audiometry_right_bone_conduction_2000'];
                $audiometry_right_bone_conduction_3000 = $row['audiometry_right_bone_conduction_3000'];
                $audiometry_right_bone_conduction_4000 = $row['audiometry_right_bone_conduction_4000'];
                $audiometry_right_bone_conduction_6000 = $row['audiometry_right_bone_conduction_6000'];
                $audiometry_right_bone_conduction_8000 = $row['audiometry_right_bone_conduction_8000'];
                $audiometry_right_bone_conduction_htl = $row['audiometry_right_bone_conduction_htl'];

                $audiometry_left_air_conduction_500 = $row['audiometry_left_air_conduction_500'];
                $audiometry_left_air_conduction_1000 = $row['audiometry_left_air_conduction_1000'];
                $audiometry_left_air_conduction_2000 = $row['audiometry_left_air_conduction_2000'];
                $audiometry_left_air_conduction_3000 = $row['audiometry_left_air_conduction_3000'];
                $audiometry_left_air_conduction_4000 = $row['audiometry_left_air_conduction_4000'];
                $audiometry_left_air_conduction_6000 = $row['audiometry_left_air_conduction_6000'];
                $audiometry_left_air_conduction_8000 = $row['audiometry_left_air_conduction_8000'];
                $audiometry_left_air_conduction_htl = $row['audiometry_left_air_conduction_htl'];
                $audiometry_left_bone_conduction_500 = $row['audiometry_left_bone_conduction_500'];
                $audiometry_left_bone_conduction_1000 = $row['audiometry_left_bone_conduction_1000'];
                $audiometry_left_bone_conduction_2000 = $row['audiometry_left_bone_conduction_2000'];
                $audiometry_left_bone_conduction_3000 = $row['audiometry_left_bone_conduction_3000'];
                $audiometry_left_bone_conduction_4000 = $row['audiometry_left_bone_conduction_4000'];
                $audiometry_left_bone_conduction_6000 = $row['audiometry_left_bone_conduction_6000'];
                $audiometry_left_bone_conduction_8000 = $row['audiometry_left_bone_conduction_8000'];
                $audiometry_left_bone_conduction_htl = $row['audiometry_left_bone_conduction_htl'];
                $audiometry_conclusion = $row['audiometry_conclusion'];
                $audiometry_impression = $row['audiometry_impression'];

                $spirometry_fvc = $row['spirometry_fvc'];
                $spirometry_fev1 = $row['spirometry_fev1'];
                $spirometry_impression = $row['spirometry_impression'];
            } else {
                $audiometry_right_air_conduction_500 = null;
                $audiometry_right_air_conduction_1000 = null;
                $audiometry_right_air_conduction_2000 = null;
                $audiometry_right_air_conduction_3000 = null;
                $audiometry_right_air_conduction_4000 = null;
                $audiometry_right_air_conduction_6000 = null;
                $audiometry_right_air_conduction_8000 = null;
                $audiometry_right_air_conduction_htl = null;
                $audiometry_right_bone_conduction_500 = null;
                $audiometry_right_bone_conduction_1000 = null;
                $audiometry_right_bone_conduction_2000 = null;
                $audiometry_right_bone_conduction_3000 = null;
                $audiometry_right_bone_conduction_4000 = null;
                $audiometry_right_bone_conduction_6000 = null;
                $audiometry_right_bone_conduction_8000 = null;
                $audiometry_right_bone_conduction_htl = null;

                $audiometry_left_air_conduction_500 = null;
                $audiometry_left_air_conduction_1000 = null;
                $audiometry_left_air_conduction_2000 = null;
                $audiometry_left_air_conduction_3000 = null;
                $audiometry_left_air_conduction_4000 = null;
                $audiometry_left_air_conduction_6000 = null;
                $audiometry_left_air_conduction_8000 = null;
                $audiometry_left_air_conduction_htl = null;
                $audiometry_left_bone_conduction_500 = null;
                $audiometry_left_bone_conduction_1000 = null;
                $audiometry_left_bone_conduction_2000 = null;
                $audiometry_left_bone_conduction_3000 = null;
                $audiometry_left_bone_conduction_4000 = null;
                $audiometry_left_bone_conduction_6000 = null;
                $audiometry_left_bone_conduction_8000 = null;
                $audiometry_left_bone_conduction_htl = null;
                $audiometry_conclusion = null;
                $audiometry_impression = null;

                $spirometry_fvc = null;
                $spirometry_fev1 = null;
                $spirometry_impression = null;
            }

            if ($employee_age > 40) {
                $treadmill = $row['treadmill'];
                if (!$treadmill) {
                    dd('Usia >40 readmill tidak boleh kosong');
                    $this->dispatchBrowserEvent('swal', [
                        'title' => 'Berhasil',
                        'icon' => 'error',
                        'text' => 'Usia >40 readmill tidak boleh kosong',
                    ]);
                }

                $echocardiography = $row['echocardiography'];
                $additional_diagnosis = $row['additional_diagnosis'];
            } else {
                $treadmill = null;
                $echocardiography = null;
                $additional_diagnosis = null;
            }

            // $amc_matrix_compliance = $row['amc_matrix_compliance'];

            DB::commit();

            return new MedicalHistory([
                'id' => Str::orderedUuid(),
                'employee_id' => $employee->id,
                'staff_id' => auth()->user()->employee->id,
                'formula_blood_pressure_id' => $formula_blood_pressure_id,
                'formula_dislipidemia_id' => $formula_dislipidemia_id,
                'provider_id' => $provider_id,

                'medical_type' => $medical_type,
                'medical_ex_type' => $medical_ex_type,
                'mcu_date' => $mcu_date,
                'mcu_exp_date' => $mcu_exp_date,

                'complaint' => $row['keluhan'],
                'previous_disease_history' => $row['riwayat_penyakit_dahulu'],
                'family_disease_history' => $row['riwayat_penyakit_keluarga'],
                'alergy' => $row['alergi'],
                'smoking' => $row['merokok'],
                'smoking_per_day' => $row['jumlah_batanghari'],
                'sports' => $row['olahraga'],
                'sports_per_week' => $row['frekuensi_xminggu'],
                'sports_type' => $row['jenis_olahraga'],
                'alcohol' => $row['alkohol'],

                'menstrual_menarche' => $menstrual_menarche,
                'menstrual_cycle' => $menstrual_cycle,
                'menstrual_pain' => $menstrual_pain,
                'menstrual_period' => $menstrual_period,
                'pregnant_period' => $pregnant_period,
                'pregnant_spontan' => $pregnant_spontan,
                'pregnant_surgery' => $pregnant_surgery,
                'pregnant_abortion' => $pregnant_abortion,
                'contraception' => $contraception,
                'contraception_type' => $contraception_type,

                'current_job' => $row['pekerjaan_saat_ini'],
                'previous_job' => $row['pekerjaan_sebelumnya'],
                'current_job_details' => $row['detail_pekerjaan_saat_ini'],

                'vaccination_hep_a1' => $vaccination_hep_a1,
                'vaccination_hep_a2' => $vaccination_hep_a2,
                'vaccination_hep_a3' => $vaccination_hep_a3,
                'vaccination_typhoid_1' => $vaccination_typhoid_1,
                'vaccination_typhoid_3' => $vaccination_typhoid_3,
                'vaccination_albendandazole' => $vaccination_albendandazole,

                'height' => $row['tinggi_badan'],
                'weight' => $row['berat_badan'],
                'bmi' => $bmi,
                'nutritional_status' => $nutritional_status,
                'bmi_lower' => $bmi_lower,
                'bmi_upper' => $bmi_upper,
                'systolic_blood_pressure' => $systolic_blood_pressure,
                'diastolic_blood_pressure' => $diastolic_blood_pressure,
                'arteries' => $row['nadi_xm'],
                'rr' => $row['rr_xm'],
                'body_temperature' => $row['suhu_tubuh_c'],
                'blood_pressure_status' => $blood_pressure_status,

                'heent' => $row['heent'],
                'orodental_caries' => $row['orodental'],
                'orodental_gangren_radix' => $row['orodental_gangren_radix'],
                'cardiovascular_system' => $row['sistem_kardiovaskuler'],
                'respiratorus_system' => $row['sistem_respiratorius'],
                'digestivus_system' => $row['sistem_digestivus'],
                'genitounrinarius_system' => $row['sistem_genitourinariuskulit'],
                'neuromuscular_system' => $row['sistem_neuromuskular'],
                'fitness_test' => $row['lain_lain_fitness_test_harvard_test'],

                'visus_non_correction_od' => $visus_non_correction_od,
                'visus_non_correction_os' => $visus_non_correction_os,
                'visus_non_correction_ods' => $visus_non_correction_ods,
                'visus_correction_od' => $visus_correction_od,
                'visus_correction_os' => $visus_correction_os,
                'visus_correction_ods' => $visus_correction_ods,
                'visus_impression' => $visus_impression,
                'visus_reading_test' => $visus_reading_test,
                'visus_color_blind' => $visus_color_blind,
                'visus_field_of_view' => $visus_field_of_view,
                'visus_notes' => $visus_notes,

                'audiometry_right_air_conduction_500' => $audiometry_right_air_conduction_500,
                'audiometry_right_air_conduction_1000' => $audiometry_right_air_conduction_1000,
                'audiometry_right_air_conduction_2000' => $audiometry_right_air_conduction_2000,
                'audiometry_right_air_conduction_3000' => $audiometry_right_air_conduction_3000,
                'audiometry_right_air_conduction_4000' => $audiometry_right_air_conduction_4000,
                'audiometry_right_air_conduction_6000' => $audiometry_right_air_conduction_6000,
                'audiometry_right_air_conduction_8000' => $audiometry_right_air_conduction_8000,
                'audiometry_right_air_conduction_htl' => $audiometry_right_air_conduction_htl,
                'audiometry_right_bone_conduction_500' => $audiometry_right_bone_conduction_500,
                'audiometry_right_bone_conduction_1000' => $audiometry_right_bone_conduction_1000,
                'audiometry_right_bone_conduction_2000' => $audiometry_right_bone_conduction_2000,
                'audiometry_right_bone_conduction_3000' => $audiometry_right_bone_conduction_3000,
                'audiometry_right_bone_conduction_4000' => $audiometry_right_bone_conduction_4000,
                'audiometry_right_bone_conduction_6000' => $audiometry_right_bone_conduction_6000,
                'audiometry_right_bone_conduction_8000' => $audiometry_right_bone_conduction_8000,
                'audiometry_right_bone_conduction_htl' => $audiometry_right_bone_conduction_htl,

                'audiometry_left_air_conduction_500' => $audiometry_left_air_conduction_500,
                'audiometry_left_air_conduction_1000' => $audiometry_left_air_conduction_1000,
                'audiometry_left_air_conduction_2000' => $audiometry_left_air_conduction_2000,
                'audiometry_left_air_conduction_3000' => $audiometry_left_air_conduction_3000,
                'audiometry_left_air_conduction_4000' => $audiometry_left_air_conduction_4000,
                'audiometry_left_air_conduction_6000' => $audiometry_left_air_conduction_6000,
                'audiometry_left_air_conduction_8000' => $audiometry_left_air_conduction_8000,
                'audiometry_left_air_conduction_htl' => $audiometry_left_air_conduction_htl,
                'audiometry_left_bone_conduction_500' => $audiometry_left_bone_conduction_500,
                'audiometry_left_bone_conduction_1000' => $audiometry_left_bone_conduction_1000,
                'audiometry_left_bone_conduction_2000' => $audiometry_left_bone_conduction_2000,
                'audiometry_left_bone_conduction_3000' => $audiometry_left_bone_conduction_3000,
                'audiometry_left_bone_conduction_4000' => $audiometry_left_bone_conduction_4000,
                'audiometry_left_bone_conduction_6000' => $audiometry_left_bone_conduction_6000,
                'audiometry_left_bone_conduction_8000' => $audiometry_left_bone_conduction_8000,
                'audiometry_left_bone_conduction_htl' => $audiometry_left_bone_conduction_htl,
                'audiometry_conclusion' => $audiometry_conclusion,
                'audiometry_impression' => $audiometry_impression,

                'spirometry_fvc' => $spirometry_fvc,
                'spirometry_fev1' => $spirometry_fev1,
                'spirometry_impression' => $spirometry_impression,

                'xray_thorax' => $row['xray_thorax'],
                'ekg' => $row['ekg'],

                'treadmill' => $treadmill,
                'echocardiography' => $echocardiography,
                'additional_diagnosis' => $additional_diagnosis,

                'blood_hb' => $row['blood_hb'],
                'blood_ht' => $row['blood_ht'],
                'blood_leukosit' => $row['blood_leukosit'],
                'blood_thrombosit' => $row['blood_thrombosit'],
                'blood_eritrosit' => $row['blood_eritrosit'],
                'blood_led' => $row['blood_led'],
                'blood_type' => $row['blood_type'],
                'blood_rhesus' => $row['blood_rhesus'],
                'blood_sgot' => $row['blood_sgot'],
                'blood_sgpt' => $row['blood_sgpt'],
                'blood_gamma_gt' => $row['blood_gamma_gt'],
                'blood_cholesterol_total' => $row['blood_cholesterol_total'],
                'blood_hdl' => $row['blood_hdl'],
                'blood_ldl' => $row['blood_ldl'],
                'blood_tga' => $row['blood_tga'],
                'blood_billirubin_total' => $row['blood_billirubin_total'],
                'blood_billirubin_direk' => $row['blood_billirubin_direk'],
                'blood_billirubin_indirek' => $row['blood_billirubin_indirek'],
                'blood_dislipidemia' => $row['blood_dislipidemia'],
                'blood_gdpt' => $row['blood_gdpt'],
                'blood_g2pp' => $row['blood_g2pp'],
                'blood_hyperglycemic' => $row['blood_hyperglycemic'],
                'blood_hba1c' => $row['blood_hba1c'],
                'blood_dm_status' => $row['blood_dm_status'],

                // 'jakarta_cardiovascular_score' => $row['jakarta_cardiovascular_score'],
                // 'jakarta_cardiovascular_risk_level' => $row['jakarta_cardiovascular_risk_level'],
                // 'framingham_score' => $row['framingham_score'],
                // 'frammingham_risk_level' => $row['frammingham_risk_level'],

                'laboratory_ureum' => $row['laboratory_ureum'],
                'laboratory_bun' => $row['laboratory_bun'],
                'laboratory_creatinin' => $row['laboratory_creatinin'],
                'laboratory_uric_acid' => $row['laboratory_uric_acid'],
                'laboratory_uric_egfr' => $row['laboratory_uric_egfr'],

                'laboratory_hbsag' => $laboratory_hbsag,
                'laboratory_anti_hbs' => $laboratory_anti_hbs,
                'laboratory_anti_havlgm' => $laboratory_anti_havlgm,
                'laboratory_widal' => $laboratory_widal,
                'laboratory_malary' => $laboratory_malary,

                'laboratory_urinalysis_color' => $row['laboratory_urinalysis_color'],
                'laboratory_urinalysis_clarity' => $row['laboratory_urinalysis_clarity'],
                'laboratory_urinalysis_ph' => $row['laboratory_urinalysis_ph'],
                'laboratory_urinalysis_density' => $row['laboratory_urinalysis_density'],
                'laboratory_urinalysis_protein' => $row['laboratory_urinalysis_protein'],
                'laboratory_urinalysis_glucose' => $row['laboratory_urinalysis_glucose'],
                'laboratory_urinalysis_billirubin' => $row['laboratory_urinalysis_billirubin'],
                'laboratory_urinalysis_urobillin' => $row['laboratory_urinalysis_urobillin'],
                'laboratory_urinalysis_keton' => $row['laboratory_urinalysis_keton'],
                'laboratory_urinalysis_blood' => $row['laboratory_urinalysis_blood'],
                'laboratory_urinalysis_lekositesterase' => $row['laboratory_urinalysis_lekositesterase'],
                'laboratory_urinalysis_nitrit' => $row['laboratory_urinalysis_nitrit'],
                'laboratory_urinalysis_leukocyte_sediment' => $row['laboratory_urinalysis_leukocyte_sediment'],
                'laboratory_urinalysis_erythrocyte' => $row['laboratory_urinalysis_erythrocyte'],
                'laboratory_urinalysis_epitel' => $row['laboratory_urinalysis_epitel'],
                'laboratory_urinalysis_cylinder' => $row['laboratory_urinalysis_cylinder'],
                'laboratory_urinalysis_crystal' => $row['laboratory_urinalysis_crystal'],
                'laboratory_urinalysis_bacteria' => $row['laboratory_urinalysis_bacteria'],
                'laboratory_urinalysis_etc' => $row['laboratory_urinalysis_etc'],

                'laboratory_urinalysis_amp' => $laboratory_urinalysis_amp,
                'laboratory_urinalysis_met' => $laboratory_urinalysis_met,
                'laboratory_urinalysis_bdz' => $laboratory_urinalysis_bdz,
                'laboratory_urinalysis_coc' => $laboratory_urinalysis_coc,
                'laboratory_urinalysis_opi' => $laboratory_urinalysis_opi,
                'laboratory_urinalysis_thc' => $laboratory_urinalysis_thc,
                'laboratory_urinalysis_feces_analysis' => $laboratory_urinalysis_feces_analysis,
                'laboratory_urinalysis_feces_culture' => $laboratory_urinalysis_feces_culture,
                'cholinesterase' => $row['cholinesterase'],

                'additional_exam' => $row['additional_exam_eg_rdt_covid_cholineesterase_n_5320_12920'],
                'findings' => $findings,
                // 'amc_matrix_compliance' => $amc_matrix_compliance,

                'doctor_status_review' => 'draft',
            ]);

        } catch (ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            // $this->dispatchBrowserEvent('swal', [
            //     'title' => 'Error',
            //     'icon' => 'error',
            //     'text' => $th->getMessage(),
            // ]);
        }

    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }

}

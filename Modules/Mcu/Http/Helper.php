<?php

// use Carbon\Carbon;
// use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Schema;

// FRAMINGHAM SCORE
function risk_factor_framingham_score($gender, $age)
{
    if ($age <= 35) {
        $gender == 'male' ? $score = -1 : $score = -9;
    } elseif ($age > 35 && $age <= 39) {
        $gender == 'male' ? $score = 0 : $score = -4;
    } elseif ($age > 39 && $age <= 44) {
        $gender == 'male' ? $score = 1 : $score = 0;
    } elseif ($age > 44 && $age <= 49) {
        $gender == 'male' ? $score = 2 : $score = 3;
    } elseif ($age > 49 && $age <= 54) {
        $gender == 'male' ? $score = 3 : $score = 6;
    } elseif ($age > 54 && $age <= 59) {
        $gender == 'male' ? $score = 4 : $score = 7;
    } elseif ($age > 59 && $age <= 64) {
        $gender == 'male' ? $score = 5 : $score = 8;
    } elseif ($age > 64 && $age <= 69) {
        $gender == 'male' ? $score = 6 : $score = 8;
    } elseif ($age > 69 && $age <= 74) {
        $gender == 'male' ? $score = 7 : $score = 8;
    } else {
        $score = 0;
    }

    return $score;
}

function total_colesterol_framingham_score($val, $gender)
{
    if ($val < 160) {
        $gender == 'male' ? $score = -3 : $score = -2;
    } elseif ($val > 169 && $val <= 199) { // #dipertanyakan : antara 160 - 169 nggak diitung?
        $gender == 'male' ? $score = 0 : $score = 0;
    } elseif ($val > 199 && $val <= 239) {
        $gender == 'male' ? $score = 1 : $score = 1;
    } elseif ($val > 239 && $val <= 279) {
        $gender == 'male' ? $score = 2 : $score = 2;
    } elseif ($val > 279) {
        $gender == 'male' ? $score = 3 : $score = 3;
    } else {
        $score = 0;
    }

    return $score;
}

function hdl_colesterol_framingham_score($val, $gender)
{
    if ($val >= 60) {
        $gender = 'male' ? $score = -2 : $score = -3;
    } elseif ($val >= 50 && $val < 60) {
        $gender = 'male' ? $score = 0 : $score = 0;
    } elseif ($val >= 45 && $val < 50) {
        $gender = 'male' ? $score = 0 : $score = 1;
    } elseif ($val >= 35 && $val < 45) {
        $gender = 'male' ? $score = 1 : $score = 2;
    } elseif ($val < 35) {
        $gender = 'male' ? $score = 2 : $score = 5;
    } else {
        $score = 0;
    }

    return $score;
}

function systolic_blood_framingham_score($val)
{
    if ($val < 120) {
        $gender = 'male' ? $score = 0 : $score = -3;
    } elseif ($val >= 120 && $val < 130) {
        $gender = 'male' ? $score = 0 : $score = 0;
    } elseif ($val >= 130 && $val < 140) {
        $gender = 'male' ? $score = 1 : $score = 1;
    } elseif ($val >= 140 && $val < 160) {
        $gender = 'male' ? $score = 2 : $score = 2;
    } elseif ($val >= 160) {
        $gender = 'male' ? $score = 3 : $score = 3;
    } else {
        $score = 0;
    }

    return $score;
}

function diabetes_melitus_framingham_score($val, $gender)
{
    if ($val == 'no') {
        $gender = 'male' ? $score = 0 : $score = 0;
    } elseif ($val == 'yes') {
        $gender = 'male' ? $score = 2 : $score = 4;
    } else {
        $score = 0;
    }

    return $score;
}

function smoking_framingham_score($gender, $val)
{
    if ($val == 'no') {
        $gender = 'male' ? $score = 0 : $score = 0;
    } elseif ($val == 'yes') {
        $gender = 'male' ? $score = 2 : $score = 2;
    } else {
        $score = 0;
    }

    return $score;
}

function frammingham_risk_level($val)
{
    if ($val < 1) {
        $score = 'Resiko Rendah';
    } elseif ($val >= 1 && $val <= 10) {
        $score = 'Resiko Sedang';
    } elseif ($val > 10 && $val <= 20) {
        $score = 'Resiko Tinggi';
    } elseif ($val > 20) {
        $score = 'Resiko Sangat Tinggi';
    }

    return $score;
}
// END FRAMINGHAM SCORE ^

// JAKARTA CARDIOVASCULAR SCORE
// #dipertanyakan : butuh penjelasan cara perhitungan !
function risk_by_sex_jc_score($val)
{
    if ($val == 'male') {
        $sex_jc_score = 0;
    } elseif ($val == 'female') {
        $sex_jc_score = 1;
    }

    return $sex_jc_score;
}

function risk_by_age_jc_score($age)
{
    if ($age >= 25 && $age <= 34) {
        $score = -4;
    } elseif ($age > 34 && $age <= 39) {
        $score = -3;
    } elseif ($age > 39 && $age <= 44) {
        $score = -2;
    } elseif ($age > 44 && $age <= 49) {
        $score = 0;
    } elseif ($age > 49 && $age <= 54) {
        $score = 1;
    } elseif ($age > 54 && $age <= 59) {
        $score = 2;
    } elseif ($age > 59 && $age <= 64) {
        $score = 3;
    } else {
        $score = 0;
    }

    return $score;
}

function risk_by_blood_pressure_jc_score($val)
{
    if ($val == 'Normal') {
        $score = 0;
    } elseif ($val == 'High Normal') {
        $score = 1;
    } elseif ($val == 'Grade 1 Hypertension') {
        $score = 2;
    } elseif ($val == 'Grade 2 Hypertension') {
        $score = 3;
    } elseif ($val == 'Grade 3 Hypertension') {
        $score = 4;
    } else {
        $score = 0;
    }

    return $score;
}

function risk_by_bmi_jc_score($val)
{
    if ($val >= 13.79 && $val < 26) {
        $score = 0;
    } elseif ($val >= 26 && $val < 30) {
        $score = 1;
    } elseif ($val >= 30 && $val < 36) {
        $score = 2;
    } else {
        $score = 0;
    }

    return $score;
}

function risk_by_smoking_jc_score($val)
{
    if ($val == 'Never') {
        $score = 0;
    } elseif ($val == 'Ex_smoker') {
        $score = 3;
    } elseif ($val == 'Smoker') {
        $score = 4;
    } else {
        $score = 0;
    }

    return $score;
}

function risk_by_diabetes_melitus_jc_score($val)
{
    if ($val == 'no') {
        $score = 0;
    } elseif ($val == 'yes') {
        $score = 2;
    } else {
        $score = 0;
    }

    return $score;
}

function risk_by_activity_jc_score($val)
{
    if ($val == 'no') {
        $score = 2;
    } elseif ($val == 'low') {
        $score = 1;
    } elseif ($val == 'medium') {
        $score = 0;
    } elseif ($val == 'high') {
        $score = -3;
    } else {
        $score = 0;
    }

    return $score;
}

function jc_risk_level($val)
{
    if ($val <= 1) {
        $score = 'Rendah';
    } elseif ($val > 1 && $val <= 4) {
        $score = 'Sedang';
    } elseif ($val > 4) {
        $score = 'Tinggi';
    }

    return $score;
}
// END JAKARTA CARDIOVASCULAR SCORE ^

// Berat Badan Ideal / IMT
function bmi($gender, $height)
{
    if ($gender == 'male') {
        $ideal = round(($height - 100) - (($height - 100) * (10 / 100)), 2);
    } else { // female
        $ideal = round(($height - 100) - (($height - 100) * (15 / 100)), 2);
    }

    return $ideal;
}

function imt_ideal($height, $weight)
{
    return $ideal = round($weight / pow(($height / 100), 2));
}

function imt_ideal_limit($gender, $height, $x)
{
    $ideal = bmi($gender, $height);
    $limit = $ideal * (10 / 100);

    if ($x == 'low') {
        $lower = $ideal - $limit;
    } else {
        $lower = $ideal + $limit;
    }

    return $lower;
}

// function imt_score($gender, $height)
// {
//     if ($gender == 'male') {
//         $ideal = ($height - 100) - (($height - 100) * (10 / 100));
//         $imt_score = [($ideal - ($ideal * (10 / 100))), ($ideal + ($ideal * (10 / 100)))];
//     } else { // female
//         $ideal = ($height - 100) - (($height - 100) * (15 / 100));
//         $imt_score = [($ideal - ($ideal * (10 / 100))), ($ideal + ($ideal * (10 / 100)))];
//     }

//     return $imt_score;
// }
// END Berat Badan Ideal / IMT ^

// NUTRITIONAL STATUS
function nutritional_status($val)
{
    if ($val < 18.5) {
        $nutritional_status = 'Underweight';
    } elseif ($val >= 18.5 && $val < 25) {
        $nutritional_status = 'Normal / Ideal';
    } elseif ($val >= 25 && $val < 30) {
        $nutritional_status = 'Overweight';
    } elseif ($val >= 30 && $val < 35) {
        $nutritional_status = 'Obesity Class 1';
    } elseif ($val >= 35) {
        $nutritional_status = 'Obesity Class 2';
    } else {
        //
    }

    return $nutritional_status;
}
// END NUTRITIONAL STATUS ^

// BLOOD PRESSURE STATUS
function blood_pressure_status($sistolik, $diastolik, $f)
{

    if ($sistolik < $f->normal_a && $diastolik < $f->normal_b) {
        $blood_pressure_status = 'Normal';
    } elseif (($sistolik >= $f->pre_a_1 && $sistolik < $f->pre_b_1) || ($diastolik >= $f->pre_a_2 && $diastolik < $f->pre_b_2)) {
        $blood_pressure_status = 'Pre - Hipertensi';
    } elseif (($sistolik >= $f->ht1_a_1 && $sistolik < $f->ht1_b_1) || ($diastolik >= $f->ht1_a_2 && $diastolik < $f->ht1_b_2)) {
        $blood_pressure_status = 'Hipertensi Tingkat 1';
    } elseif ($sistolik > $f->ht2_a || $diastolik > $f->ht2_b) {
        $blood_pressure_status = 'Hipertensi Tingkat 2';
    } else {
        $blood_pressure_status = 'Hipertensi Tingkat 2';
    }

    // if ($sistolik < 120 && $diastolik < 80) {
    //     $blood_pressure_status = 'Normal';
    // } elseif (($sistolik >= 120 && $sistolik < 140) || ($diastolik >= 80 && $diastolik < 90)) {
    //     $blood_pressure_status = 'Pre - Hipertensi';
    // } elseif (($sistolik >= 140 && $sistolik < 160) || ($diastolik >= 90 && $diastolik < 99)) {
    //     $blood_pressure_status = 'Hipertensi Tingkat 1';
    // } elseif ($sistolik > 160 || $diastolik > 100) {
    //     $blood_pressure_status = 'Hipertensi Tingkat 2';
    // } else {
    //     $blood_pressure_status = 'Hipertensi Tingkat 2';
    // }

    return $blood_pressure_status;
}
// BLOOD PRESSURE SCORE ^

// eGFR SCORE
function egfr_score($gender, $age, $weight, $creatinin)
{
    if ($gender == 'male') {
        $egfr_score = round((140 - $age) * ($weight / (72 * $creatinin)), 2);
    } else { // female
        $egfr_score = round((140 - $age) * (($weight * 0.85) / (72 * $creatinin)), 2);
    }

    return $egfr_score;
}
// eGFR SCORE ^

function dislipidemia_status($col_total, $ldl, $tga, $f)
// function dislipidemia_status($hdl, $ldl, $tga, $f)
{
    // $col_total = $hdl + $ldl + (1/5 * $tga);
    if (($col_total > $f->col_total) || ($ldl > 100) || ($tga > $f->tga)) {
        $status = 'Yes/Positif';
    } else {
        $status = 'No/Negatif';
    }

    return $status;
}

function hiperglikemia_status($blood_gdpt = 0, $blood_g2pp = 0)
{
    if (($blood_gdpt > 125) || ($blood_g2pp > 140)) {
        $status = 'Yes/Positif';
    } else {
        $status = 'No/Negatif';
    }

    return $status;
}

function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function doctor_status_review($medical_type, $medical_ex_type, $findings)
{
    // Fit
    // Unfit
    // Fit With Recomendation
    // Curently Unfit
    if ($medical_type == 'pre-employment') {
        if ($medical_ex_type == 'office-group') {
            $doctor_status_review = ($findings) ? 'Unfit' : 'Fit';
        } elseif ($medical_ex_type == 'field-officer') {
            $doctor_status_review = ($findings) ? 'Unfit' : 'Fit';
        } elseif ($medical_ex_type == 'general-housekeeping') {
            $doctor_status_review = ($findings['']) ? 'Unfit' : 'Fit';
        } elseif ($medical_ex_type == 'food-handler') {
            $doctor_status_review = ($findings) ? 'Unfit' : 'Fit';
        }
    } elseif ($medical_type == 'periodic') {
        $doctor_status_review = ($findings) ? 'Unfit' : 'Unfit';
    } elseif ($medical_type == 'pre-retirement') {
        $doctor_status_review = ($findings) ? 'Unfit' : 'Unfit';
    } else {
        $doctor_status_review = ($findings) ? 'Unfit' : 'Unfit';
    }
    return $doctor_status_review;
}

function generateInitialName(string $name): string
{
    $words = explode(' ', $name);
    // if (count($words) >= 2) {
    return mb_strtoupper(
        mb_substr($words[0], 0, 1, 'UTF-8') .
            mb_substr(end($words), 0, 1, 'UTF-8'),
        'UTF-8'
    );
    // }
}

function changeByte($size)
{
    $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

<?php

function number2roman($num, $isUpper = true)
{
    $n = intval($num);
    $res = '';

    /*** roman_numerals array ***/
    $roman_numerals = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );

    foreach ($roman_numerals as $roman => $number) {

        $matches = intval($n / $number);


        $res .= str_repeat($roman, $matches);


        $n = $n % $number;
    }

    if ($isUpper) return $res;
    else return strtolower($res);
}

function getLastWord($sentence,$separator = " "): string
{
    $split = explode($separator, $sentence);
    return $split[count($split)-1];
}

function formProgress($ref,$data){
    $score = 0;
    $progress = 0;
    foreach ($ref as  $value) {
        if(!empty($data[$value])){
            $score++;
        }
    }

    $ref_num = count($ref);

    if($ref_num > 0){

        $progress = round(($score/$ref_num)*100,2);
    }

    return $progress;
    
}

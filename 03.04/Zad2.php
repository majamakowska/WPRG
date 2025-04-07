<?php

echo "5210: " . numbers(5210)."\n";
echo "-5210: " . numbers(-5210)."\n";
echo "5210.5: " . numbers(5210.5)."\n";
echo "numbers: " . numbers("numbers")."\n";
function numbers ($number) {
    if (!is_numeric($number)) {
        return "Parameter must be numeric!";
    }
    $suma = 0;
    $number_str = (string) $number;
    if (is_float($number)) {
        $number_str = str_replace('.', '', $number_str);
    }
    for ($i = 0; $i < strlen($number_str); $i++) {
        $suma += (int)$number_str[$i];
    }
    if ($suma >= 10) {
       $suma = numbers($suma);
    }
    return $suma;
}

?>
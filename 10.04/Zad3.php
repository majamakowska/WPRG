<?php
function abcd($a, $b, $c, $d)
{
    if ($a > $b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
    if ($c > $b) {
        $temp = $c;
        $c = $b;
        $b = $temp;
    }
    $tablica = [];
    $value = $c;
    for ($i = $a; $i < $b; $i++) {
        $tablica[$i] = $value;
        $value++;
        if ($value > $d) {
            $value = $value%$d + $c;
        }
    }
    return $tablica;
}
print_r(abcd(10, 20, 6, 12));
?>

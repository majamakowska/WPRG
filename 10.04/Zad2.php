<?php
function powiekszTablice(array $tablica, $n) {
    if (!is_numeric($n) || $n < 0) {
        echo "BLAD";
        return null;
    } else {
        array_splice($tablica, $n, 0, "$");
    }
    return $tablica;
}

$tablica = array(1, 2, 3, 4, 5);

print_r($tablica);
print_r(powiekszTablice($tablica, 0));
print_r(powiekszTablice($tablica, 2));
print_r(powiekszTablice($tablica, 5));

?>
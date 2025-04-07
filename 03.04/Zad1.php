<?php

print_primes(5,10);
print_primes(10,5);
print_primes(5.5,10);
print_primes(-5,10);
print_primes("prime",10);
function print_primes($a,$b) {
    echo $a . ", " . $b . ": ";
    if (!is_numeric($a) || !is_numeric($b)) {
        echo "Start and stop must be numeric!\n";
        return;
    }
    if ($a < 0 || $b < 0) {
        echo "Start and stop must be positive numbers! Given " . $a . ", " . $b . "!\n";
        return;
    }
    if ($a > $b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }
    $primes = array();
    for ($i = ceil($a); $i <= $b; $i++) {
        if ($i < 2) {
            continue;
        }
        $is_prime = true;
        for ($j = 2; $j <= sqrt($i); $j++) {
            if ($i % $j == 0) {
                $is_prime = false;
                break;
            }
        }
        if ($is_prime) {
            $primes[] = $i;
        }
    }
    foreach ($primes as $prime) {
        echo $prime . " ";
    }
    echo "\n";
}

?>

<?php

sequences_n(5, 2, 10);
sequences_n(5, -2, 10);
sequences_n(-5, 2, 10);
sequences_n(5, 2.5, 10);
sequences_n(5, 2.5, -10);
sequences_n("start", 2, 10);

function sequences_n ($start, $r_q , $n)
{
    echo $start . ", " . $r_q . ", " . $n . ": ";
    if (!is_numeric($start) || !is_numeric($r_q) || !is_numeric($n)) {
        echo "Parameter must be numeric!\n";
        return;
    }
    if ($n < 0) {
        echo "N must be a positive number!\n";
        return;
    }
    $sequence_a[0] = $start;
    $sequence_g[0] = $start;
    for ($i = 1; $i < $n; $i++) {
        $sequence_a[$i] = $sequence_a[$i - 1] + $r_q;
    }
    for ($i = 1; $i < $n; $i++) {
        $sequence_g[$i] = $sequence_g[$i - 1] * $r_q;
    }
    echo "\nArithmetic: ";
    for ($i = 0; $i < count($sequence_a); $i++) {
        echo $sequence_a[$i];
        if ($i < count($sequence_a) - 1) {
            echo ", ";
        }
    }
    echo "\nGeometric: ";
    for ($i = 0; $i < count($sequence_g); $i++) {
        echo $sequence_g[$i];
        if ($i < count($sequence_g) - 1) {
            echo ", ";
        }
    }
    echo "\n";
}

?>

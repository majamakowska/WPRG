<?php

$A = array(
    array(1, 1),
    array(8, 5),
    array(9, 4)
);
$B = array(
    array(0, 2, 3),
    array(4, 6, 2),
    array(7, 8, 5)
);
echo "A*B: ";
$AB = multiply_arrays($A, $B);
if ($AB !== null) {
    echo "\n";
    foreach ($AB as $row) {
        echo implode(" ", $row) . "\n";
    }
}
echo "B*A: ";
$BA = multiply_arrays($B, $A);
if ($BA !== null) {
    echo "\n";
    foreach ($BA as $row) {
        echo implode(" ", $row) . "\n";
    }
}

function multiply_arrays (array $matrix1, array $matrix2) {
    $m1 = count($matrix1);
    $n1 = count($matrix1[0]);
    $m2 = count($matrix2);
    $n2 = count($matrix2[0]);
    if ($n1 !== $m2) {
        echo "Matrix multiplication is not possible.\n";
        return null;
    }
    $result = array();
    for ($i = 0; $i < $m1; $i++) {
        for ($j = 0; $j < $n2; $j++) {
            $result[$i][$j] = 0;
            for ($k = 0; $k < $n1; $k++) {
                $result[$i][$j] += $matrix1[$i][$k] * $matrix2[$k][$j];
            }
        }
    }
    return $result;
}

?>

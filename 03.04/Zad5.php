<?php

is_pangram("The quick brown fox jumps over the lazy dog.");
is_pangram("Ala ma kota.");

function is_pangram($s) {
    echo "'" . $s . "'" . " -> ";
    $s = strtolower($s);
    for ($i = 97; $i <= 122; $i++) {
        if (str_contains($s, chr($i)) === false) {
            echo "false\n";
            return;
        }
    }
    echo "true\n";
}

?>
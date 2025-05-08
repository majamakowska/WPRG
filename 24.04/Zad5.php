<?php
$userIP = $_SERVER["REMOTE_ADDR"];
$selectedIPs = [];
if ($fd = fopen("./selectedIPs.txt", "r")) {
    while(!feof($fd)) {
        $IP = fgets($fd);
        if ($IP !== false) {
            $selectedIPs[] = trim($IP);
        }
    }
    fclose($fd);
}
if (in_array($userIP, $selectedIPs)) {
    include("Zad5_special.html");
} else {
    include("Zad5_standard.html");
}
?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$endpoint = "maru-moodle-db.cluster-crkc8w28olh1.ap-southeast-2.rds.amazonaws.com";
$user     = "moodleadmin";
$pass     = "m00dleMARU2026";
$db       = "moodle";

// 1. Resolve Endpoint to Private IPv4
$ip = gethostbyname($endpoint);
echo "Resolved DB IP: " . $ip . "<br>";

// 2. Attempt Connection with 5-Second Timeout
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

if (@$mysqli->real_connect($ip, $user, $pass, $db, 3306)) {
    echo "<strong style='color:green;'>Successfully connected to Aurora MySQL!</strong>";
} else {
    echo "<strong style='color:red;'>Connection Failed (Error " . mysqli_connect_errno() . "):</strong> " . mysqli_connect_error();
}
?>

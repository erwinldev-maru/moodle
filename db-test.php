<?php
$mysqli = new mysqli("maru-moodle-db.cluster-crkc8w28olh1.ap-southeast-2.rds.amazonaws.com", "moodleadmin", "m00dleMARU2026", "moodle");
if ($mysqli->connect_error) { 
    die("Connection failed: " . $mysqli->connect_error); 
}
echo "Connected successfully to Aurora!";
?>

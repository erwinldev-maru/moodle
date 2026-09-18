<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h3>1. Testing RDS Connection</h3>";

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

echo "<h3>2. Testing Redis Connection</h3>";
$redis_endpoint = "maru-moodle-redis.trutt8.0001.apse2.cache.amazonaws.com"; 

try {
    if (class_exists('Redis')) {
        $redis = new Redis();
        // 5-second timeout for the connection attempt
        if (@$redis->connect($redis_endpoint, 6379, 5)) {
            echo "<strong style='color:green;'>Successfully connected to Redis!</strong><br>";
            $redis->close();
        } else {
            echo "<strong style='color:red;'>Failed to connect to Redis.</strong> (Timeout or network block)<br>";
        }
    } else {
        echo "<strong style='color:red;'>Redis PHP extension is not installed.</strong> Check .ebextensions.<br>";
    }
} catch (Exception $e) {
    echo "<strong style='color:red;'>Redis Error: </strong>" . $e->getMessage() . "<br>";
}

echo "<h3>3. Testing EFS Mount Permissions</h3>";
$efs_path = '/mnt/moodledata';

if (is_dir($efs_path)) {
    if (is_writable($efs_path)) {
        $test_file = $efs_path . '/test_write.txt';
        if (@file_put_contents($test_file, "EFS Write Test")) {
            echo "<strong style='color:green;'>Successfully wrote to EFS! Permissions are correct.</strong><br>";
            unlink($test_file); 
        } else {
            echo "<strong style='color:red;'>Failed to write file despite directory being writable.</strong><br>";
        }
    } else {
        $owner_id = fileowner($efs_path);
        $owner_info = function_exists('posix_getpwuid') ? posix_getpwuid($owner_id)['name'] : $owner_id;
        echo "<strong style='color:red;'>Directory is NOT writable.</strong> Current owner: " . $owner_info . "<br>";
    }
} else {
    echo "<strong style='color:red;'>Directory $efs_path does NOT exist.</strong><br>";
}
?>

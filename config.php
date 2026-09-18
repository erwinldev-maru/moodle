<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// 1. Database Connection (Aurora Serverless)
$CFG->dbtype    = 'auroramysql';
$CFG->dblibrary = 'native';
//$CFG->dbhost    = 'maru-moodle-db-instance.crkc8w28olh1.ap-southeast-2.rds.amazonaws.com';
$CFG->dbhost    = 'maru-moodle-db.cluster-crkc8w28olh1.ap-southeast-2.rds.amazonaws.com'
$CFG->dbname    = 'moodle'; 
$CFG->dbuser    = 'moodleadmin';
$CFG->dbpass    = 'm00dleMARU2026';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 3306,
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
  'ssl' => true,
);

// 2. Web and File Settings
$CFG->wwwroot   = 'http://marumoodle-prod-v2.eba-fw7dypck.ap-southeast-2.elasticbeanstalk.com/'; 
$CFG->dataroot  = '/mnt/moodledata';
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;

// 3. Redis Session Caching
$CFG->session_handler_class = '\core\session\redis';
$CFG->session_redis_host = 'maru-moodle-redis.trutt8.0001.apse2.cache.amazonaws.com';
$CFG->session_redis_port = 6379;

// 4. SSL and ALB Reverse Proxy Settings
$CFG->sslproxy = true;
$CFG->reverseproxy = true;

// Enable Moodle On-Screen Debugging
@error_reporting(E_ALL | E_STRICT);
@ini_set('display_errors', '1');
$CFG->debug = 32767; // Equivalent to DEBUG_DEVELOPER
$CFG->debugdisplay = 1;
// END

require_once(__DIR__ . '/lib/setup.php');

<?php
define('DBSERVER', 'localhost'); // Database server
define('DBUSERNAME', 'root'); // Database username
define('DBPASSWORD', ''); // Database password
define('DBNAME', 'websystem'); // Database name




/* using constants for path */
DEFINE ('HOME_DIR', dirname( realpath(__FILE__)) );
DEFINE ('BASE_DIR', basename(HOME_DIR));


/* connect to MySQL database */
$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

// Check db connection
if($db === false){
    die("Error: connection error. " . mysqli_connect_error());
}
?>

<?php

if(!file_exists('config.php'))
{
	die("<h1>Please rename config.sample.php to config.php and edit MYSQL server information appropriately.</h1>");
}

include('config.php');

mysql_connect($mysql_server_address,$mysql_server_username,$mysql_server_password) or die("<h1>Coud not connect to MYSQL server. Please ensure server details in config.php are correct.</h1>");

?>

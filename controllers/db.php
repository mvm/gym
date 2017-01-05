<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "root";
$db_name = "gda";

mysql_connect($db_host, $db_user, $db_pass) or die (print "Error conectándose a la base de datos");
mysql_select_db($db_name) or die (print mysql_error());
?>
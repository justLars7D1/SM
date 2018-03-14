<?php

	$dbhost = "rdbms.strato.de";
	$dbuser = "U3298278";
	$dbpass = "Lars15102001";
	$dbname = "DB3298278";

	/*$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "sm";*/

$connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Couldn't find/connect (to) the database!");

?>

<?php 
session_start();
if (!isset($_SESSION['id'])) {
	header("Location: ../login.php");
}

$location = $_POST['to'];
$actualLocation = './profile.php?user='.$location.'';
echo '<script type="text/javascript">window.location.href = "'.$actualLocation.'";</script>';


?>
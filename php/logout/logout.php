<?php 
session_start();

if (!empty($_SESSION['id'])) {

	session_destroy();

	echo "<script type='text/javascript'>
	location.reload();
	</script>";	

} else {

	header('Location: ../../login.php');

}

?>
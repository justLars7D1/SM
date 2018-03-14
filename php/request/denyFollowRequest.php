<?php 
session_start();
include '../connect.php';

if (isset($_POST['id_follow_request'])) {
	
	$by_user_id = $_POST['id_follow_request'];
	$to_user_id = $_SESSION['id'];

	$sql1 = "DELETE FROM follow_requests WHERE by_user_id='".$by_user_id."' AND to_user_id='".$to_user_id."'";
	if(mysqli_query($connect, $sql1)) {

		$sql2 = "SELECT * FROM users WHERE user_id='".$by_user_id."'";
		$query2 = mysqli_query($connect, $sql2);
		$row2 = mysqli_fetch_assoc($query2);

		echo "<h2>".$row2['user_uid']."'s following request has been denied!</h2>";

	}

} else {

	echo '<h1>Cheater!</h1>';

}

?>
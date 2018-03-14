<?php 
session_start();
include '../connect.php';
if (!isset($_SESSION['id'])) {
	header('Location: ../../login.php');
} elseif ($_POST['lastPage'] !== "/SM/index.php") {
	header('Location: ../../index.php');
}

$by_user_id = $_SESSION['id'];
$to_user_id = $_POST['to'];

$sql = "SELECT * FROM user_preferences WHERE user_id='".$to_user_id."'";
$query = mysqli_query($connect, $sql);

$sql1 = "SELECT * FROM follow_requests WHERE by_user_id='".$by_user_id."' AND to_user_id='".$to_user_id."'";
$query1 = mysqli_query($connect, $sql1);

if (mysqli_num_rows($query1) == 0) {
	
	while ($row = mysqli_fetch_assoc($query)) {
		
		if ($row['profile_type'] == "private") {

			$insert = "INSERT INTO follow_requests (by_user_id, to_user_id) VALUES (".$by_user_id.", ".$to_user_id.")";
			mysqli_query($connect, $insert);

		} elseif ($row['profile_type'] == "public") {

			$insert = "INSERT INTO user_following (follower_id, following_id) VALUES (".$by_user_id.", ".$to_user_id.")";
			mysqli_query($connect, $insert);

		}

	}

} else {

 echo 'A request has already been sent to this user!';

}





?>
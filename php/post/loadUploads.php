<?php 
session_start();
include '../connect.php';
$rand = uniqid('', true);

if ($_POST['lastPage'] == "/SM/index.php" || $_POST['lastPage'] == "/SM/php/search/searchBar.php") {

	$sql2 = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['id']."'";
	$query2 = mysqli_query($connect, $sql2);

	while ($row2 = mysqli_fetch_assoc($query2)) {
		
		$sql = "SELECT * FROM uploads WHERE user_id='".$row2['following_id']."' ORDER BY upload_id DESC";
		$query = mysqli_query($connect, $sql);

		while ($row = mysqli_fetch_assoc($query)) {

			$sql4 = "UPDATE `uploads` SET `upload_viewability`='".$rand."' WHERE `upload_id`='".$row['upload_id']."' AND `user_id`='".$row['user_id']."' AND `upload_name`='".$row['upload_name']."'";

			mysqli_query($connect, $sql4);

		}		

	}


	$sql3 = "SELECT * FROM uploads WHERE upload_viewability='".$rand."' ORDER BY upload_id DESC";
	$query3 = mysqli_query($connect, $sql3);

	while ($row3 = mysqli_fetch_assoc($query3)) {

		$sql1 = "SELECT * FROM users WHERE user_id='".$row3['user_id']."'";
		$query1 = mysqli_query($connect, $sql1);

		while ($row1 = mysqli_fetch_assoc($query1)) {

			echo '<div class="uploadDiv">';
				echo "<span>".$row1['user_uid']." | ".$row1['user_tag']."</span><br>";
				echo "<img onclick='modalUpload()' src='./uploads/".$row3['upload_name']."' class='uploads'>";
			echo '</div>';		

		}

	}

}

?>
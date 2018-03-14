<?php 
session_start();
include '../connect.php';
$rand = uniqid('', true);
$followingUsers = array();

foreach ($_POST['allUsers'] as $id) {

	$testIfFollowing = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['id']."' AND following_id='".$id."'";
	$queryTest = mysqli_query($connect, $testIfFollowing);
	$rowsTest = mysqli_num_rows($queryTest);
	$fetchTest = mysqli_fetch_assoc($queryTest);
	if ($rowsTest > 0) {

		array_push($followingUsers, $fetchTest['following_id']);

	}

}

$stringUsers = implode(",", $followingUsers);

if ($_POST['lastPage'] == "/SM/php/search/searchBar.php") {

	if (!empty($stringUsers)) {
		
		$sql = "SELECT * FROM uploads WHERE user_id IN (".$stringUsers.") ORDER BY upload_id DESC";
		$query = mysqli_query($connect, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			
			echo '<div class="uploadDiv">';
			$sql1 = "SELECT * FROM users WHERE user_id='".$row['user_id']."'";
			$query1 = mysqli_query($connect, $sql1);
			while ($row1 = mysqli_fetch_assoc($query1)) {	
				echo "<span>".$row1['user_uid']." | ".$row1['user_tag']."</span><br>";
			}
			echo "<img src='./uploads/".$row['upload_name']."' class='uploads'>";
			echo '</div>';			

		}

	}



}

?>
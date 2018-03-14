<?php 
session_start();
$value = strtolower($_POST['searchBox']);
$removeSpacing = str_replace(' ', '', $value);
$allUsers = array();

if ($removeSpacing !== "") {

	include '../connect.php';
	$users = array();

	$selectUsers = "SELECT * FROM users";
	$queryUsers = mysqli_query($connect, $selectUsers);

	while ($rowUsers = mysqli_fetch_assoc($queryUsers)) { 

			array_push($users, $rowUsers['user_uid']);

	}

	$result = array_filter($users);

	if ($value !== "") {
		
		foreach ($result as $user) {

			$lowerCaseUid = strtolower($user);
			$stringLength = strlen($value);	

			if (substr($lowerCaseUid, 0, $stringLength) === $value) {

				$sql = "SELECT * FROM users WHERE user_uid='".$user."'";
				$query = mysqli_query($connect, $sql);
				while ($row = mysqli_fetch_assoc($query)) {

					array_push($allUsers, $row['user_id']);

					$sql1 = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['id']."' AND following_id='".$row['user_id']."'";
					$sql2 = "SELECT * FROM follow_requests WHERE by_user_id='".$_SESSION['id']."' AND to_user_id='".$row['user_id']."'";
					$query1 = mysqli_query($connect, $sql1);
					$query2 = mysqli_query($connect, $sql2);
					$rows1 = mysqli_num_rows($query1);
					$rows2 = mysqli_num_rows($query2);
					
					echo '<div class="searchResult" onclick="profilePage()" id="'.$row['user_uid'].'">';
					echo '<img src="./uploads/profile_images/'.$row['user_profile_image'].'" class="resultImg" id="'.$row['user_uid'].'">';
					echo '<h3 id="'.$row['user_uid'].'"><span class="goodPlace" id="'.$row['user_uid'].'">'.$row['user_uid'].'</span></h3>';
					if ($row['user_uid'] == $_SESSION['uid']) {
						echo '<p class="followStatus">Logged in</p></span>';					
					} elseif ($rows1 > 0) {
						echo '<p class="followStatus">Following</p></span>';
					} elseif ($rows2 > 0) {
						echo '<p class="followStatus">Request sent</p></span>';
					} else {
						echo '<p class="followStatus" onclick="requestUser()" id="'.$row['user_id'].'">Follow +</span></p>';
					}
					
					echo '</div>';

				}
				
			}

		}

	}

	if ($allUsers) {

	    echo	"<script type='text/javascript'>

			var lastPage = '".$_SERVER['PHP_SELF']."';

			$.post('./php/post/loadCustomUploads.php', {lastPage: lastPage, allUsers: [";

			foreach ($allUsers as $usersInArray) {

				echo $usersInArray.',';

			}

		echo "]}, function(data) {
			$('#displayImages').html(data);
			});	

			</script>";

	} else {

	echo "<script type='text/javascript'>

			$('#displayImages').html('');

		 </script>";	
		
	}

} else {

	echo "<script type='text/javascript'>

			var lastPage = '".$_SERVER['PHP_SELF']."';

			$.post('./php/post/loadUploads.php', {lastPage, lastPage}, function(data) {
			$('#displayImages').html(data);
			});	

		</script>";		

}

				echo 
				'<style type="text/css">

					.searchResult {

						width: 200px
						border: 1px solid black;

					}


					.resultImg {

						position: absolute;
						left: 47.5px;
						width: 60px;
						height: 60px;
						border-radius: 100%;
						border: 2px solid black;
						margin-right: 20px;

					}

					.goodPlace {

						margin: 0;

					}

					.followStatus {

						position: relative;
						top: -35px;
						left: -5px;
						border: 2px solid black;
						display: inline-block;
						border-radius: 10px;
						padding: 2.5px;
						background-color: #40b8bc;	
						opacity: 0.85;			

					}

				</style>';

?>
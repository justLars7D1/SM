<?php 
session_start();
include './php/connect.php';

if (!isset($_SESSION['id'])) {
	
	header('Location: ./login.php');
	exit;

} else {

	if (empty($_GET['user'])) {

	header('Location: ./index.php?errMsg='.urlencode('1'));
	exit;

	} else {

		$sql = "SELECT * FROM users WHERE user_uid='".$_GET['user']."'";
		$query = mysqli_query($connect, $sql);

		if (mysqli_num_rows($query) == 0) {
			
			header('Location: ./index.php?errMsg='.urlencode('1'));
			exit;

		}

	}

}
?>
<!DOCTYPE html>
<html>
<head>

	<title><?php echo $_GET['user']; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/profile.css">
	<!-- | JQUERY & AJAX LIBRARY | -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<div id="navbar">
	<span id='navHome'><a href='./index.php'>Home</a></span>
	<?php
	echo '<span id="navProfile"><a href="./profile.php?user='.$_SESSION['uid'].'">Profile</a></span>';
	?>
	<span id='navLogout' onclick="logoutUser()">Logout</span>
</div>
<div id='backSlider'></div>
<div id="profileSlider">	

		<?php 

		$selectUid = "SELECT * FROM users WHERE user_uid='".$_GET['user']."'";
		$queryUid = mysqli_query($connect, $selectUid);

		while ($rowUid = mysqli_fetch_assoc($queryUid)) {

			echo '<img src="./uploads/profile_images/'.$rowUid['user_profile_image'].'" class="profileImg">';

			echo '<h1 id="profileName">'.$rowUid['user_uid'].'</h1>';

			echo '<h4 id="tagBox">'.$rowUid['user_tag'].'</h4>';

			$selectFollowers = "SELECT * FROM user_following WHERE following_id='".$rowUid['user_id']."'";
			$selectFollowing = "SELECT * FROM user_following WHERE follower_id='".$rowUid['user_id']."'";
			$queryFollowers = mysqli_query($connect, $selectFollowers);
			$queryFollowing = mysqli_query($connect, $selectFollowing);
			$ammountFollowers = mysqli_num_rows($queryFollowers) - 1;
			$ammountFollowing = mysqli_num_rows($queryFollowing) - 1;

				echo '<h4 id="followProfile">';
				echo $ammountFollowers.' Followers';
				echo ' | ';
				echo $ammountFollowing.' Following';
				echo '</h4>';
				echo '<p id="profileDesc">'.$rowUid['user_profile_description'].'</p>';

		
				if ($_SESSION['uid'] == $_GET['user']) {

					echo '<h3 id="profileSettings">Profile [Advanced]</h3>';

				}


	?>
</div>
<div id='uploads'>
	<div class='padding'>
		<?php
				$selectType = "SELECT * FROM user_preferences WHERE user_id='".$rowUid['user_id']."'";
				$queryType = mysqli_query($connect, $selectType);

				while ($rowType = mysqli_fetch_assoc($queryType)) {

					if ($rowType['profile_type'] == "public") {

							$selectUploads = "SELECT * FROM uploads WHERE user_id='".$rowUid['user_id']."'";
							$queryUploads = mysqli_query($connect, $selectUploads);

							while ($rowUploads = mysqli_fetch_assoc($queryUploads)) {

								echo '<img src="./uploads/'.$rowUploads['upload_name'].'" class="upload">';

						}

					} elseif ($rowType['profile_type'] == "private") {

					$testFollowing = "SELECT * FROM user_following WHERE follower_id='".$_SESSION['id']."' AND following_id='".$rowUid['user_id']."'";
					$queryFollowing = mysqli_query($connect, $testFollowing);

					if (mysqli_num_rows($queryFollowing) > 0) {

							$selectUploads = "SELECT * FROM uploads WHERE user_id='".$rowUid['user_id']."'";
							$queryUploads = mysqli_query($connect, $selectUploads);

							while ($rowUploads = mysqli_fetch_assoc($queryUploads)) {

								echo '<img src="./uploads/'.$rowUploads['upload_name'].'" class="upload">';

						}

					} else {

						echo "<h1><span style='color:orange;'>".$rowUid['user_uid']."</span> currently has a private profile. In order to view their images, you must follow him!</h1>";

					}

				}

			}

		}


		?>
	</div>
</div>
<?php 

if ($_SESSION['uid'] == $_GET['user']) {

	echo '
	<div id="settingsDiv">
		<span id="settingsProfile" class="margin">Profile Settings</span>
		<span id="followRequests" class="margin">Follow Requests</span>	
		<span class="margin">Challenge History</span>
		<span class="margin">Achievements</span>
		<span class="margin">Support</span>
	</div>

	<div id="viewDiv">';

	$selectForChange = "SELECT * FROM users WHERE user_uid='".$_GET['user']."'";
	$queryForChange = mysqli_query($connect, $selectForChange);
	while ($rowForChange = mysqli_fetch_assoc($queryForChange)) {
		
		echo '
			<!--<span>Leveling / Coins +</span><br>-->
			<span id="settingsBgImg">Profile Picture+</span><br>
			<div id="settingsBgImg1">
			<h4>Current Profile Picture:</h4>';

			echo '<img width="200px" height="200px" src="./uploads/profile_images/'.$rowForChange['user_profile_image'].'">';


		echo '</div>
			<span>Username: <b>'.$rowForChange['user_uid'].'</b></span><br>
			<span>Email: <b>'.$rowForChange['user_email'].'</b></span><br>
			<span>Tag Selection+</span><br>
			<span>Profile Description+</span><br>
			<span>Password+</span><br>
			<span>Permission Level: <b>'.$rowForChange['user_permissions'].'</b></span><br>
		';

		$selectPrefs = "SELECT * FROM user_preferences WHERE user_id='".$rowForChange['user_id']."'";
		$queryPrefs = mysqli_query($connect, $selectPrefs);
		while ($rowPrefs = mysqli_fetch_assoc($queryPrefs)) {
			echo '<span>Profile Type: <b>'.$rowPrefs['profile_type'].'</b></span><br>';
		}

	}

	echo '</div>';

	echo '<style type="text/css">

		#settingsDiv {

			border-top-right-radius: 20px;
			border-top-left-radius: 20px;

		}

		#viewDiv {

			border-bottom-right-radius: 20px;
			border-bottom-left-radius: 20px;
			padding: 15px 0 15px 0;			

		}

		#viewDiv span {

			text-decoration: underline;

		}

		#settingsBgImg1 {

			display: none;

		}

	</style>';

}

?>

<script type="text/javascript">
	
$('#settingsBgImg').on('click', function() {
	$('#settingsBgImg1').slideToggle();
});

$('#followRequests').on('click', function() {
	$.post('./php/toLoad/followRequests.php', {}, function(data) {
		$('#viewDiv').html(data);
	});
});

</script>

<script type="text/javascript">

	$('#viewDiv').hide();
	$('#settingsDiv').hide();

	var profileSlider = function(event) {

		if (event.target.id !== "profileSettings") {

			$('#profileSlider').off('dblclick');
			$('#profileSlider').fadeOut(500, function() {
				$('#navbar').animate({left: '-=27.6%'}, 500);
				$('#uploads').animate({left: '-=22.6%', width: '+=22.6%'}, 500, function() {
					$('#backSlider').show();
				});
			});

		}

	}

		var profileSettings = function(event) {

			if (event.target.id == "profileSettings") {

				$('#profileSettings').off('dblclick');
				$('#profileSlider').fadeOut(500);
				$('#uploads').fadeOut(500);
				$('#navbar').animate({left: '-=27.6%'}, 500);
				$('#settingsDiv').show();
				$('#viewDiv').show();
				$('#settingsDiv').css({"border": "1px solid black", "width": "90%", "position": "relative", "top": "100px", "left": "100px"});
				$('#settingsProfile').css({"font-weight": "bold"});
				$('.margin').css({"margin-left": "20px", "font-size": "150%"});		
				$('#viewDiv').css({"position": "relative", "top": "100px", "left": "100px", "border": "1px solid black", "width": "90%"})

		}

	}

	$('#profileSlider').on('dblclick', profileSlider);
	$('#profileSettings').on('dblclick', profileSettings);	

	var backSlider = function() {

		$(this).hide();
		$('#navbar').animate({left: '+=27.6%'}, 500);
		$('#uploads').animate({left: '+=22.6%', width: '-=22.6%'}, 500, function() {
			$('#profileSlider').fadeIn(500, function() {
				$('#profileSlider').on('dblclick', profileSlider);
			});
		});

	}

	$('#backSlider').on('click', backSlider);

	function logoutUser() {

		<?php echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'"'?>


		$.post('./php/logout/logout.php', {lastPage, lastPage}, function(data) {
		location.reload();
		});	

	}

</script>
</body>
</html>
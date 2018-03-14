<?php 
session_start();
if (empty($_SESSION['id'])) {
	header('Location: ./login.php');
}
include './php/connect.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Challenges</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/challenges.css">
	<!-- | JQUERY & AJAX LIBRARY | -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="navbar">
	<span id='navHome'>Home</span>
	<span id="navChallenges" onclick='reload()'>Challenges</span>
	<?php
	echo '<span id="navProfile"><a href="./profile.php?user='.$_SESSION['uid'].'">Profile</a></span>';
	?>
	<span id='navLogout'>Logout</span>
</div>

<div id=""></div>

<div id="progressDisplay">
	<h2 id="progressText">Challenge Progress</h2>
	<input type="text" id="searchProgress" placeholder="Challenge Name">
	<div id="challengeContainer">
		<?php
		$sql = "SELECT * FROM challenge_members WHERE user_id='".$_SESSION['id']."'";
		$query = mysqli_query($connect, $sql);
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)) {
				$sql2 = "SELECT * FROM challenges WHERE challenge_id='".$row['challenge_id']."'";
				$query2 = mysqli_query($connect, $sql2);
				$row2 = mysqli_fetch_assoc($query2);
				$sql3 = "SELECT * FROM users WHERE user_id='".$row2['challenge_creator_id']."'";
				$query3 = mysqli_query($connect, $sql3);
				$row3 = mysqli_fetch_assoc($query3);	
				$sql4 = "SELECT * FROM challenge_members WHERE challenge_id='".$row['challenge_id']."'";
				$query4 = mysqli_query($connect, $sql4);
				$participants = mysqli_num_rows($query4);
				echo '
				<div class="searchChallenge">
					<h3 class="challengeName">'.$row2['challenge_name'].'</h3>
					<h4 class="challengeCreator">By '.$row3['user_uid'].'</h4>
					<hr class="challengeHr">
					<p class="challengeDesc">'.$row2['challenge_description'].'</p>
					<div class="challengeFollowersDiv"><h4 class="challengeFollowers">'.$participants.' Participants</h4></div>
				</div>
				';
			}
		}

		?>
	</div>
</div>

<script type="text/javascript">
// JS of Navbar
$('#navHome').on('click', function() {
	window.location.href='./index.php';
});

$('#navLogout').on('click', function() {
	window.location.href='./php/logout/logout.php';
});

</script>
</body>
</html>
<?php 
session_start();
include '../connect.php';
$sql = "SELECT * FROM follow_requests WHERE to_user_id='".$_SESSION['id']."' ORDER BY request_id DESC";
$query = mysqli_query($connect, $sql);
if (mysqli_num_rows($query) > 0) {

	if (mysqli_num_rows($query) == 1) {

		echo '<h3 class="followers">You currently have 1 follow request.</h3><br>';	

	} else {

		$totalRequests = mysqli_num_rows($query);
		echo '<h3 class="followers">You currently have '.$totalRequests.' follow requests.</h3><br>';

	}

	while ($row = mysqli_fetch_assoc($query)) {

		$sql1 = "SELECT * FROM users WHERE user_id='".$row['by_user_id']."'";
		$query1 = mysqli_query($connect, $sql1);
		$row1 = mysqli_fetch_assoc($query1);

		echo '<div id="updateLog"></div>';
		echo '<div class="followRequestDiv" id="'.$row1['user_id'].'">';
			echo '<img src="./uploads/profile_images/'.$row1['user_profile_image'].'" class="resultImg">';
			echo '<h3 class="goodPlaceUid">'.$row1['user_uid'].'</h3>';
			echo '<h3 class="goodPlacePerms">'.$row1['user_permissions'].'</h3>';
			echo '<button type="button" class="acceptFollowRequest" id="'.$row1['user_id'].'">Accept</button><br>';
			echo '<button type="button" class="denyFollowRequest" id="'.$row1['user_id'].'">Deny</button>';		
		echo '</div>';

		echo 
		'<style type="text/css">

			.followRequestDiv {

				margin: 0 0 -175px 0;

			}

			.resultImg {

				margin: 0 0 20px 20px;;
				width: 60px;
				height: 60px;
				border-radius: 100%;
				border: 2px solid black;

			}

			.goodPlaceUid {

				position: relative;
				top: -110px;
				left: 95px;

			}

			.goodPlacePerms {

				position: relative;
				top: -120px;
				left: 95px;

			}

			.acceptFollowRequest {

				border-radius: 25px;
				background-color: #6dff74;
				border: 2px solid #088400;
				width: 75px;
				height: 35px;
				position: relative;
				top: -210px;
				left: 200px;
				font-size: 15px;

			}

			.denyFollowRequest {

				border-radius: 25px;
				background-color: #ff7f7f;
				border: 2px solid #9e0000;
				width: 75px;
				height: 35px;
				position: relative;
				top: -205px;
				left: 200px;
				font-size: 15px;

			}


		</style>';		

	}


} else {

	echo '<h3 class="followers">You currently have 0 follow requests.</h3><br>';	

}

?>

<style type="text/css">
	
	.followers {

		margin: 0 0 0 20px;
		text-decoration: underline;

	}

</style>

<script type="text/javascript">
	
$('.acceptFollowRequest').on('click', function(event) {

	var id_follow_request = event.target.id;

	$.post('./php/request/acceptFollowRequest.php', {id_follow_request: id_follow_request}, function(data) {
		$('#' + id_follow_request).remove();
		$('#updateLog').html(data);
		var actualFilter = /\d+/g;		
		var currentRequestsString = $('.followers').html();
		var filterString = currentRequestsString.match(actualFilter);
		var actualRequests = filterString - 1;
		if (actualRequests !== 1) {
			$('.followers').html('You currently have ' + actualRequests + ' follow requests.');
		} else {
			$('.followers').html('You currently have ' + actualRequests + ' follow request.');			
		}	
	});

});

$('.denyFollowRequest').on('click', function(event) {

	var id_follow_request = event.target.id;

	$.post('./php/request/denyFollowRequest.php', {id_follow_request: id_follow_request}, function(data) {
		$('#' + id_follow_request).remove();
		$('#updateLog').html(data);
		var actualFilter = /\d+/g;		
		var currentRequestsString = $('.followers').html();
		var filterString = currentRequestsString.match(actualFilter);
		var actualRequests = filterString - 1;
		if (actualRequests !== 1) {
			$('.followers').html('You currently have ' + actualRequests + ' follow requests.');
		} else {
			$('.followers').html('You currently have ' + actualRequests + ' follow request.');			
		}	
	});

});

</script>
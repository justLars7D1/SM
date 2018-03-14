<?php 
session_start();

if (!isset($_SESSION['id'])) {
	
	header('Location: ./login.php');

}
?>

<!DOCTYPE html>
<html>
<head>

	<title>SM | Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./css/index.css">
	<!-- | JQUERY & AJAX LIBRARY | -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">

  	$(document).ready(function() {

	<?php echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'"'?>

	$.post('./php/post/loadUploads.php', {lastPage, lastPage}, function(data) {
	$('#displayImages').html(data);
	});



		function updateImages() {

			<?php echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'"';?>

			$.post('./php/post/loadUploads.php', {lastPage, lastPage}, function(data) {
			$('#displayImages').html(data);
			});	

		}

		$('#searchSlider').on('mouseover', function() {
			$('.h1').css('color', 'white');
			$('#searchSlider').css('opacity', '0.9');
		});

		$('#searchSlider').on('mouseleave', function() {
			$('.h1').css('color', '#9e9e9e');
			$('#searchSlider').css('opacity', '0.85');
		});

  	  	$("#searchBox").keyup(function() {

  	  		var searchBox = $("#searchBox").val();

  	  		$.post("./php/search/searchBar.php", {
  	  			searchBox: searchBox
  	  		}, function(data, status) {
  	  			$("#searchResult").html(data);
  	  		});
  	  	});

  	  	$('#searchSlider').on('dblclick', hideSlider);
		$('#backSlider').on('click', showSlider); 

  	  	function showSlider() {

				$('#backSlider').hide();			
				$('#navbar').animate({left: '+=17.5%'}, 500);
				$('.uploadDiv').animate({width: '470px', height: '500px', margin: '0 30px 20px 0'}, 500);
				$('#setPosition').animate({left: '+=17.5%', width: '-=400px'}, 500, function() {
					$('#searchSlider').fadeIn(500, function() {
						$('#searchSlider').on('dblclick', hideSlider);							
					});
				});

  	  	}

  	  	function hideSlider() {

			$('#searchSlider').off('dblclick'); 
			$('#searchSlider').fadeOut(500, function() {
				$('#navbar').animate({left: '-=17.5%'}, 500);
				$('#setPosition').animate({left: '-=17.5%', width: '+=400px'}, 500);
				$('.uploadDiv').animate({width: '770px', height: '775px', margin: '0 0 100px 100px'}, 500, function() {
					$('#backSlider').show();				
				});

			});				  		

  	  	}

	});

			function logoutUser() {

			<?php echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'"'?>


			$.post('./php/logout/logout.php', {lastPage: lastPage}, function(data) {
			location.reload();
			});	

		}

		function reload() {

			location.reload();

		}

	</script>

</head>
<body>
<div id="navbar">
	<span id='navHome' onclick='reload()'>Home</span>
	<span id="navChallenges">Challenges</span>
	<?php
	echo '<span id="navProfile"><a href="./profile.php?user='.$_SESSION['uid'].'">Profile</a></span>';
	?>
	<span id='navLogout' onclick="logoutUser()">Logout</span>
</div>

<div id="errMsg">

<?php 

if (!empty($_GET['errMsg'])) {
	
	if ($_GET['errMsg'] == 1) {
		
		echo "<h4>The profile page you were looking for doesn't exist</h4>";

	}

}

?>

</div>

<div id='searchSlider'>
	<h1 class='h1'>Search for user</h1>
	<input id='searchBox' placeholder='Username'>
	<div id='searchResult'></div>
	<!--<form action="./php/post/postData.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
		<button type="submit" name="submitUpload">Upload Image</button>
	</form>-->
</div>

<div id='backSlider'></div>

<div id='setPosition'>
	<div id="displayImages"></div>
</div>

<div id='log'></div>
<script type="text/javascript">

	function requestUser() {

		$("body").click(function(event) {

			var to = event.target.id;

 			if($(event.target).attr('class') == "followStatus") {

				<?php echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'"'?>

				$.post('./php/request/followRequest.php', {lastPage: lastPage, to: to}, function(data) {
				location.reload();
				});

 			}

		});	

  	}  

	function profilePage() {

		$("body").click(function(event) {

		  	var to = event.target.id;

			if($(event.target).attr('class') !== "followStatus") {


				$.post('./php/goodProfile.php', {to: to}, function(data) {
					$('body').html(data);
				});

			}

		});	

  	}  
  	

	$('#navChallenges').on('click', function() {
		window.location.href='./challenges.php';
	});

</script>
</body>
</html>
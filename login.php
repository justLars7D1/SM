<?php 
session_start();
if (isset($_SESSION['id'])) {
	
	header('Location: ./index.php');

}
?>
<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- | JQUERY & AJAX LIBRARY | -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<title>SM</title>

	<script type="text/javascript">
		
	function loginUser() {

		var uid = $('#uid').val();
		var pwd = $('#password').val();
		<?php 
		echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'";';
		?>

	    $.post('./php/login/login.php', {uid: uid, pwd: pwd, lastPage: lastPage}, function(data) {
	    $('#outcomeDisplay').html(data);
	    });

	}

	function forgotPassword() {

	    $.post('./forgotPwd.php', {}, function(data) {
	    $('body').html(data);
	    });		

	}

	function submitRecEMail() {

		var email = $('#emailAcc').val();
		<?php
		echo 'var lastPage = "'.$_SERVER['PHP_SELF'].'";';
		?>

	    $.post('./php/forgot/recoverPwd.php', {email: email, lastPage: lastPage}, function(data) {
	    //location.reload();
	    $('#outcomeDisplay').html(data);
	    });

	}

	</script>

</head>
<body>

	<div id="outcomeDisplay"></div>
	<input type="text" id="uid" placeholder="username">
	<input type="password" id="password" placeholder="password">
	<button type="submit" id="loginButton" onclick="loginUser()">Login</button>
	<button type='submit' id='forgotPassword' onclick='forgotPassword()'>Forgot Password</button>

</body>
</html>
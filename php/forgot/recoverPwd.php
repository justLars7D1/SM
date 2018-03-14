<?php 
session_start();
include '../connect.php';
$lastPage = mysqli_real_escape_string($connect, $_POST['lastPage']);
$email = mysqli_real_escape_string($connect, $_POST['email']);

if ($lastPage == "/SM/login.php") {
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		$sql = "SELECT * FROM users WHERE  user_email='".$email."'";
		$query = mysqli_query($connect, $sql);

		if (mysqli_num_rows($query) > 0) {

			while ($row = mysqli_fetch_assoc($query)) {
				
				$subject = "Password Reset SM";
				$resetlink = "www.test.com";
				$content = "Hello ".$row['user_uid'].",\n\n
				You (or someone else) has requested a password reset for your Meet account.\n
				Use the link below to create a new password, please note that this link is only valid for 24 hours:\n
				".$resetlink."
				";
				$content = "test";

				if(mail($email, $subject, $content)) {

					echo 'The password reset email has been sent to your inbox!';

				} else {

					echo "The email hasn't been sent. Try again later...";

				}

			}

		} else {

			header('Location: ../../index.php');

		}

	} else {

		header('Location: ../../index.php');

	}

} else {

	header('Location: ../../index.php');

}

?>
<?php 
session_start();

//Test if form was sent
if (!empty($_POST['lastPage'])) {
	
	//Test if last page was index
	if ($_POST['lastPage'] == "/SM/login.php") {

		//Include Database connection
		include '../connect.php';

		$uid = mysqli_real_escape_string($connect, $_POST['uid']);
		$pwd = mysqli_real_escape_string($connect, $_POST['pwd']);

		//Select and query data from Database
		$sql = "SELECT * FROM users WHERE user_uid='".$uid."' AND user_pwd='".$pwd."'";
		$query = mysqli_query($connect, $sql);

		//Test if data exists
		if (mysqli_num_rows($query) > 0) {
			
			while ($row = mysqli_fetch_assoc($query)) {
				
				$_SESSION['id'] = $row['user_id'];
				$_SESSION['uid'] = $row['user_uid'];
				$_SESSION['email'] = $row['user_email'];
				$_SESSION['pwd'] = $row['user_pwd'];
				$_SESSION['permissions'] = $row['user_permissions'];

				echo "<script type='text/javascript'>
				location.reload();
				</script>";	

			}

		} else {

			echo 'Wrong username or password...';

		}

	} else {

		header("Location: ../../index.php");

	}

} else {

	header("Location: ../../index.php");

}

?>
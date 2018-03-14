<?php 
session_start();
include '../connect.php';
$view = 'a';

if (isset($_POST['submitUpload'])) {

	$file = $_FILES['file'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];
	$fileType = $file['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg', 'jpeg', 'pdn', 'png', 'bmp');

	if (in_array($fileActualExt, $allowed)) {
		
		if ($fileError === 0) {
			
			if ($fileSize < 1000000) {
				
				$fileNameNew = uniqid('', true).".".$fileActualExt;
				$fileDestination = '../../uploads/'.$fileNameNew;

				$sql = "INSERT INTO uploads (upload_viewability, user_id, upload_name) VALUES (?, ?, ?)";

				if($statement = $connect->prepare($sql)) {

			        $statement->bind_param(
			        "sis",
			        $view,
			        $_SESSION['id'],
			        $fileNameNew
			        );		

			        if ($statement->execute()) {
			        	
			        	move_uploaded_file($fileTmpName, $fileDestination);

			        	header('Location: ../../index.php?success');
						
			        } else {

			        	echo "Error, the file couldn't be uploaded... Try again later.";

			        }		

				} else {

			        	echo "Couldn't connect to the database... Try again later.";

			        }
				

			} else {

				echo "Your file is too big!";

			}

		} else {

			echo 'There was an error while uploading your file: ';
			echo $fileError;

		}

	} else {

		echo "This file type isn't supported.. Suported file types are: jpg, jpeg, pdn, png and bmp!";

	}

}
?>
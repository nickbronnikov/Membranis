<?php
require '../includes/change_files.php';
$allowed = array('png', 'jpg', 'gif','fb2','pdf');
if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
	if(move_uploaded_file($_FILES['upl']['tmp_name'], '../users_files/'.rus2translit($_FILES['upl']['name']))){
		echo '{"status":"success"}';
		exit;
	}
}
?>
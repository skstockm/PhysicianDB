<?php
	session_start();
	if(!isset($_SESSION["id"])){ // if "user" not set,
		session_destroy();
		header('Location: login.php');     // go to login page
		exit;
	}
$id = null;
if ( !empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

ini_set('file-uploads', true);
if($_FILES['file1']['size']>0 && $_FILES['file1']['size'] < 2000000){
	
	$tempname = $_FILES['file1']['tmp_name'];
	$fp = fopen($tempname, 'rb');
	$content = fread($fp, filesize($tempname));
	fclose($fp);
	
	include 'database.php';
	$pdo = Database::connect();
	$sql = "UPDATE patient set picture = ? WHERE id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($content,$id));
	Database::disconnect();
	header('Location: updatePatient.php?id=' . $id);
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Stockmeyer Modern Business" />
		<meta name="author" content="Staci Stockmeyer" />

		<title>Physician Appointments</title>
		<!--favricon-->
		<link rel="icon" href="Medicine Stethoscope.png" type="image/png" />
		<!-- Bootstrap Core CSS -->
		<link href="startbootstrap-modern-business-1.0.5/startbootstrap-modern-business-1.0.5/css/bootstrap.min.css" rel="stylesheet" />
		<!-- Custom CSS -->
		<link href="startbootstrap-modern-business-1.0.5/startbootstrap-modern-business-1.0.5/css/modern-business.css" rel="stylesheet" />
		<!-- Custom Fonts -->
		<link href="startbootstrap-modern-business-1.0.5/startbootstrap-modern-business-1.0.5/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

		<style type="text/css">
			body, #buttons {
				background-color: #aaadb7;
			}
			.logoutLblPos{

				position:fixed;
				right:10px;
				top:50px;
			}
		</style>
</head>
<form action='image.php?id=<?php echo $id?>' enctype='multipart/form-data' method='post'>
	Choose File:
	<input type='file' name='file1' id='file1'>
	<br/>
	<input type='submit' />
</form>
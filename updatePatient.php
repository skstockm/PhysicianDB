<?php 
	session_start();
	if(!isset($_SESSION["id"])){ // if "user" not set,
		session_destroy();
		header('Location: login.php');     // go to login page
		exit;
	}
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$phoneError = null;
		$insuranceError = null;
		$addressNumError = null;
		$streetError = null;
		$patientCityError = null;
		$zipCodeError = null;
		$stateError = null;
		
		// keep track post values
		$name = $_POST['patient_name'];
		$phone = $_POST['patient_phone'];
		$insurance = $_POST['patient_insurance'];
		$addressNum = $_POST['patient_addressNum'];
		$street = $_POST['patient_street'];
		$patientCity = $_POST['patient_city'];
		$zipCode = $_POST['patient_zip'];
		$state = $_POST['patient_state'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		//makes sure name is in the right format		
		if(!preg_match("/^[a-zA-Z]+$/", $name)){
			$nameError = 'Please enter Name NO NUMBERS!!';
			$valid = false;
		}
		
		if (empty($phone)) {
			$phoneError = 'Please enter Phone Number';
			$valid = false;
		}
		
	    //makes sure phone is in right format
		if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $phone)) {
			// $phone is valid
			$phoneError = 'Please write phone number with format 000-000-0000';
			$valid = false;
		}
		
		if (empty($insurance)) {
			$insuranceError = 'Please enter Insurance Information';
			$valid = false;
		}
		
	    if (empty($addressNum)) {
			$addressNumError = 'Please enter Address Number';
			$valid = false;
		}
		
		//makes sure the address num is in the right format
		if(!preg_replace("/[^0-9]/", '', $addressNum)){
			$addressNumError = 'Please enter Address NUMBERS!!';
			$valid = false;
		}
				
		if (empty($street)) {
			$streetError = 'Please enter Street';
			$valid = false;
		}
		if (empty($patientCity)) {
			$patientCityError = 'Please enter City';
			$valid = false;
		}
		
		//makes sure patientCity is in the right format		
		if(!preg_match("/^[a-zA-Z]+$/", $patientCity)){
			$patientCityError = 'Please enter City NO NUMBERS!!';
			$valid = false;
		}
		
		if (empty($zipCode)) {
			$zipCodeError = 'Please enter Zip Code';
			$valid = false;
		}
		
		//makes sure the zip code is in the right format
		if(!preg_replace("/[^0-9]/", '', $zipCode)){
			$zipCodeError = 'Please enter Zip Code NUMBERS!!';
			$valid = false;
		}
		
		if (empty($state)) {
			$stateError = 'Please enter State';
			$valid = false;
		}
		//makes sure state is in the right format		
		if(!preg_match("/^[a-zA-Z]+$/", $state)){
			$stateError = 'Please enter State NO NUMBERS!!';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE patient set patient_name = ?, patient_phone = ?, patient_insurance = ?, patient_addressNum = ?, patient_street = ?, patient_city = ?, patient_zip = ?, patient_state = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$phone,$insurance,$addressNum,$street,$patientCity,$zipCode,$state,$id));
				Database::disconnect();
				header("Location: existingPatient.php");
			} 
			catch (Exception $e) {
				echo "Exception: " , $e->getMessage() , "\n";
			}
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM patient where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['patient_name'];
		$phone = $data['patient_phone'];
		$insurance = $data['patient_insurance'];
		$addressNum = $data['patient_addressNum'];
		$street = $data['patient_street'];
		$patientCity = $data['patient_city'];
		$zipCode = $data['patient_zip'];
		$state = $data['patient_state'];
		Database::disconnect();
	}
?>
<!DOCTYPE html>
<!-- ------------------------------------------------------------------------
filename  : StockmeyerProgram04.html
author    : Staci Stockmeyer
date      : 2016-06-21
email     : skstockm@svsu.edu
course    : CIS-255
link      : csis.svsu.edu/~skstockm/cis255/skstockm/StockmeyerProgram04.html
backup    : github.com/cis255/cis255
purpose   : This file serves as Program4 that uses widgets,  
			at Saginaw Valley State University (SVSU) if they are planning on
			majoring in CS or CIS
copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
program structure : 
	<head> metadata, links, script
	<body> The sections of the program: 
		navbar, carousel, My Modern Business Stuff, my portfolio, modern business features, contact
		
external code used in this file: 
	template from: http://startbootstrap.com/template-overviews/modern-business/
	widgets from: http://www.jqwidgets.com/jquery-widgets-demo/
---------------------------------------------------------------------------------->
<html lang="en">

	<head>

		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Stockmeyer Modern Business" />
		<meta name="author" content="Staci Stockmeyer" />

		<title>Stockmeyer Business</title>

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

	<body>

		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Physician Appointments</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="index.php">Home</a>
						</li>
						<li>
							<a href="createPatient.php">Create Patient</a>
							
						</li>
						<li>
							<a href="createAppointment.php">Create Appointment</a>
						</li>
						<li>
							<a href="existingPatient.php">Existing Patients</a>
						</li>
						<li>
							<a href="appointments.php">Appointment List</a>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->
		</nav>

		<!-- Page Content -->
		<div class="container">
			<div class="span10 offset1">
			<div class="row">
				<h3>Update a Patient</h3>
			</div>
			<form class="form-horizontal" action="updatePatient.php?id=<?php echo $id?>" method="post">
			  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
				<label class="control-label">Name:</label>
				<div class="controls">
					<input name="patient_name" type="text"  placeholder="Patient Name" value="<?php echo !empty($name)?$name:'';?>">
					<?php if (!empty($nameError)): ?>
						<span class="help-inline"><?php echo $nameError;?></span>
					<?php endif; ?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
				<label class="control-label">Phone Number:</label>
				<div class="controls">
					<input name="patient_phone" type="text" placeholder="000-000-0000 (include dashes!)" value="<?php echo !empty($phone)?$phone:'';?>">
					<?php if (!empty($phoneError)): ?>
						<span class="help-inline"><?php echo $phoneError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($addressNumError)?'error':'';?>">
				<label class="control-label">Address Number:</label>
				<div class="controls">
					<input name="patient_addressNum" type="text" placeholder="Address Number" value="<?php echo !empty($addressNum)?$addressNum:'';?>">
					<?php if (!empty($addressNumError)): ?>
						<span class="help-inline"><?php echo $addressNumError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($streetError)?'error':'';?>">
				<label class="control-label">Street Name:</label>
				<div class="controls">
					<input name="patient_street" type="text"  placeholder="Street Name" value="<?php echo !empty($street)?$street:'';?>">
					<?php if (!empty($streetError)): ?>
						<span class="help-inline"><?php echo $streetError;?></span>
					<?php endif; ?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($patientCityError)?'error':'';?>">
				<label class="control-label">City:</label>
				<div class="controls">
					<input name="patient_city" type="text"  placeholder="City" value="<?php echo !empty($patientCity)?$patientCity:'';?>">
					<?php if (!empty($patientCityError)): ?>
						<span class="help-inline"><?php echo $patientCityError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($stateError)?'error':'';?>">
				<label class="control-label">State:</label>
				<div class="controls">
					<input name="patient_state" type="text"  placeholder="State" value="<?php echo !empty($state)?$state:'';?>">
					<?php if (!empty($stateError)): ?>
						<span class="help-inline"><?php echo $stateError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($zipCodeError)?'error':'';?>">
				<label class="control-label">Zip Code:</label>
				<div class="controls">
					<input name="patient_zip" type="text"  placeholder="Zip Code" value="<?php echo !empty($zipCode)?$zipCode:'';?>">
					<?php if (!empty($zipCodeError)): ?>
						<span class="help-inline"><?php echo $zipCodeError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($insuranceError)?'error':'';?>">
				<label class="control-label">Insurance:</label>
				<div class="controls">
					<input name="patient_insurance" type="text"  placeholder="Insurance" value="<?php echo !empty($insurance)?$insurance:'';?>">
					<?php if (!empty($insuranceError)): ?>
						<span class="help-inline"><?php echo $insuranceError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="form-actions" id = "buttons">
				  <button type="submit" class="btn btn-success">Update</button>
				  <a class="btn btn-default" href="existingPatient.php">Back</a>
				  <a href="logout.php" class="logoutLblPos">Logout</a>
				  
				</div>
			</form>
			</div>
			<!-- Footer -->
			<footer>
				<div class="row">
					<div class="col-lg-12">
						<p>Copyright &copy; and Designed with <i class="fa fa-heart"></i> by Staci Stockmeyer 2017</p>
					</div>
				</div>
			</footer>

		</div>
		<!-- /.container -->

		<!-- jQuery -->
		<script src="startbootstrap-modern-business-1.0.5/startbootstrap-modern-business-1.0.5/js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="startbootstrap-modern-business-1.0.5/startbootstrap-modern-business-1.0.5/js/bootstrap.min.js"></script>

		<!-- JQUERY -->
		<!-- load jquery before bootstrap -->
		<!-- from: https://code.jquery.com/ -->
		<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
		<!--<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.js"></script>-->

		<!--<script src="StockmeyerProgram04.js"></script>-->

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	</body>

</html>

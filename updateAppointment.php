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
		$patientError = null;
		$physicianError = null;
		$apptTimeError = null;
		$apptDateError = null;
		$apptLocationError = null;
		$apptPurposeError = null;
		
		// keep track post values
		$patient = $_POST['patient_id'];
		$physician = $_POST['physician_id'];
		$apptTime = $_POST['appt_time'];
		$apptDate = $_POST['appt_date'];
		$apptLocation = $_POST['appt_location'];
		$apptPurpose = $_POST['appt_purpose'];
		
		// validate input
		$valid = true;
		if (empty($patient)) {
			$patientError = 'Please select Patient';
			$valid = false;
		}
		
		if (empty($physician)) {
			$physicianError = 'Please select Physician';
			$valid = false;
		}
		
		if (empty($apptTime)) {
			$apptTimeError = 'Please enter Appointment Time';
			$valid = false;
		}		
		//makes sure apptTime is in the right format		
		if(!preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $apptTime)){
			$apptTimeError = 'Please enter time (in 24 hr clock HH:MM)';
			$valid = false;
		}
		
		if (empty($apptDate)) {
			$apptDateError = 'Please enter Appointment Date';
			$valid = false;
		}
		//makes sure date is in the right format		
		if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$apptDate)){
			$apptDateError = 'Please enter date (YYYY-MM-DD)';
			$valid = false;
		}
		
		if (empty($apptLocation)) {
			$apptLocationError = 'Please enter Location';
			$valid = false;
		}		
		
		if (empty($apptPurpose)) {
			$apptPurposeError = 'Please enter Purpose';
			$valid = false;
		}
				
		// update data
		if ($valid) {
			try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE appointments set patient_id = ?, physician_id = ?, appt_time = ?, appt_date = ?, 
						appt_location = ?, appt_purpose = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($patient,$physician,$apptTime,$apptDate,$apptLocation,$apptPurpose,$id));
				Database::disconnect();
				header("Location: appointments.php");
			} 
			catch (Exception $e) {
				echo "Exception: " , $e->getMessage() , "\n";
			}
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM appointments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$patient = $data['patient_id'];
		$physician = $data['physician_id'];
		$apptTime = $data['appt_time'];
		$apptDate = $data['appt_date'];
		$apptLocation = $data['appt_location'];
		$apptPurpose = $data['appt_purpose'];
		Database::disconnect();
	}
?>
<!DOCTYPE html>
<html lang="en">

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
				<h3>Update an Appointment</h3>
			</div>
			<form class="form-horizontal" action="updateAppointment.php?id=<?php echo $id?>" method="post">
			  <div class="control-group <?php echo !empty($patientError)?'error':'';?>">
				<label class="control-label">Patient:</label>
				<div class="controls">
					<?php
						$pdo = Database::connect();
						$sql = 'SELECT * FROM patient ORDER BY patient_name ASC';
						echo "<select class='form-control' name='patient_id' id='patient_id'>";
						foreach ($pdo->query($sql) as $row) {
							echo "<option value='" . $row['id'] . " '> " . $row['patient_name'] . "</option>";
						}
						echo "</select>";
						Database::disconnect();
					?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($physicianError)?'error':'';?>">
				<label class="control-label">Physician:</label>
				<div class="controls">
					<?php
						$pdo = Database::connect();
						$sql = 'SELECT * FROM physician ORDER BY name ASC';
						echo "<select class='form-control' name='physician_id' id='physician_id'>";
						foreach ($pdo->query($sql) as $row) {
							echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
						}
						echo "</select>";
						Database::disconnect();
					?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($apptDateError)?'error':'';?>">
				<label class="control-label">Appointment Date: (YYYY-MM-DD)</label>
				<div class="controls">
					<input name="appt_date" type="text"  placeholder="Date" value="<?php echo !empty($apptDate)?$apptDate:'';?>">
					<?php if (!empty($apptDateError)): ?>
						<span class="help-inline"><?php echo $apptDateError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($apptTimeError)?'error':'';?>">
				<label class="control-label">Appointment Time:  (HH:MM)</label>
				<div class="controls">
					<input name="appt_time" type="text" placeholder="Time" value="<?php echo !empty($apptTime)?$apptTime:'';?>">
					<?php if (!empty($apptTimeError)): ?>
						<span class="help-inline"><?php echo $apptTimeError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($apptLocationError)?'error':'';?>">
				<label class="control-label">Appointment Location:</label>
				<div class="controls">
					<input name="appt_location" type="text"  placeholder="Location" value="<?php echo !empty($apptLocation)?$apptLocation:'';?>">
					<?php if (!empty($apptLocationError)): ?>
						<span class="help-inline"><?php echo $apptLocationError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="control-group <?php echo !empty($apptPurposeError)?'error':'';?>">
				<label class="control-label">Appointment Purpose:</label>
				<div class="controls">
					<input name="appt_purpose" type="text"  placeholder="Purpose" value="<?php echo !empty($apptPurpose)?$apptPurpose:'';?>">
					<?php if (!empty($apptPurposeError)): ?>
						<span class="help-inline"><?php echo $apptPurposeError;?></span>
					<?php endif;?>
				</div>
			  </div>
			  <div class="form-actions" id = "buttons">
				  <button type="submit" class="btn btn-success">Update</button>
				  <a class="btn btn-default" href="appointments.php">Back</a>
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

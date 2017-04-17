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
		header("Location: appointments.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		# get appointments details
		$sql = "SELECT * FROM appointments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

		# get volunteer details
		$sql = "SELECT * FROM patient where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($data['patient_id']));
		$patientdata = $q->fetch(PDO::FETCH_ASSOC);

		# get event details
		$sql = "SELECT * FROM physician where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($data['physician_id'])); 
		$physiciandata = $q->fetch(PDO::FETCH_ASSOC);

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
			#readinfo{
				color:blue;
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
				<h3>Read an Appointment</h3>
			</div>
			
			<div class="form-horizontal" >
			  <div class="control-group">
				<label class="control-label">Physician Name:</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $physiciandata['name'];?>
					</label>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Patient Name:</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $patientdata['patient_name'];?>
					</label>
				</div>
			  </div>
			  
			  <div class="control-group">
				<label class="control-label">Appointment Date: (YYYY-MM-DD)</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $data['appt_date'];?>
					</label>
				</div>
			  </div>					  
			  <div class="control-group">
				<label class="control-label">Appointment Time: (HH:MM:SS)</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $data['appt_time'];?>
					</label>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Appointment Location:</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $data['appt_location'];?>
					</label>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Appointment Purpose:</label>
				<div class="controls">
					<label id="readinfo" class="checkbox">
						<?php echo $data['appt_purpose'];?>
					</label>
				</div>
			  </div>
			   <div class="form-actions" id= "buttons">
				  <a class="btn btn-default" href="appointments.php">Back</a>
				  <a href="logout.php" class="logoutLblPos">Logout</a>
			   </div>
			</div>
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

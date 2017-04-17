<?php
	session_start();
	if(!isset($_SESSION["id"])){ // if "user" not set,
		session_destroy();
		header('Location: login.php');     // go to login page
		exit;
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
		<div class="row">
			<h3>Appointments</h3>
		</div>
			<!--Icons Section -->
		<div class="row">
			<table class="table table-striped table-bordered" id="table">
			  <thead>
				<tr>
				  <th>Physician's Name</th>
				  <th>Patient's Name</th>
				  <th>Appointment Date</th>
				  <th>Appointment Time</th>
				  <th>Appointment Location</th>
				  <th>Appointment Purpose</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php 
			   include 'database.php';
			   $pdo = Database::connect();
			   $sql = 'SELECT * FROM appointments 
					   LEFT JOIN patient ON patient.id = appointments.patient_id 
					   LEFT JOIN physician ON physician.id = appointments.physician_id
					   ORDER BY appt_date ASC, appt_time ASC, name ASC, patient_name ASC, appt_time ASC;';
			   foreach ($pdo->query($sql) as $row) {
					echo '<tr>';
					echo '<td>'. $row['name'] . '</td>';
					echo '<td>'. $row['patient_name'] . '</td>';
					echo '<td>'. $row['appt_date'] . '</td>';
					echo '<td>'. $row['appt_time'] . '</td>';
					echo '<td>'. $row['appt_location'] . '</td>';
					echo '<td>'. $row['appt_purpose'] . '</td>';
					echo '<td width=250>';
					# use $row[0] because there are 3 fields called "id"!!!!! very important otherwise it breaks!!!
					echo '<a class="btn btn-default" href="readAppointment.php?id='.$row[0].'">Read</a>';
					echo '&nbsp;';
					echo '<a class="btn btn-success" href="updateAppointment.php?id='.$row[0].'">Update</a>';
					echo '&nbsp;';
					echo '<a class="btn btn-danger" href="deleteAppointment.php?id='.$row[0].'">Delete</a>';
					echo '</td>';
					echo '</tr>';
			   }
			   
			   Database::disconnect();
			  ?>
			  </tbody>
			  <div class="form-actions" id = "buttons">
				  <a class="btn btn-default" href="index.php">Back</a>
				  <a href="createAppointment.php" class="btn btn-success">Create New Appointment</a>
				  <a href="logout.php" class="logoutLblPos">Logout</a>
			  </div>
			</table>
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

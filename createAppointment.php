<?php 
	
	require 'database.php';

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
		
		if (empty($apptDate)) {
			$apptDateError = 'Please enter Appointment Date';
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
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO appointments (patient_id,physician_id,appt_time,appt_date,appt_location,appt_purpose) values(?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($patient,$physician,$apptTime,$apptDate,$apptLocation,$apptPurpose));
			Database::disconnect();
			header("Location: appointments.php");
		}
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create an Appointment</h3>
		    		</div>
	    			<form class="form-horizontal" action="createAppointment.php" method="post">
					  <div class="control-group <?php echo !empty($patientError)?'error':'';?>">
					    <label class="control-label">Patient</label>
					    <div class="controls">
					      	<?php
								$pdo = Database::connect();
								$sql = 'SELECT * FROM patient ORDER BY id DESC';
								echo "<select class='form-control' name='patient_id' id='id'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . $row['patient_name'] . "</option>";
								}
								echo "</select>";
								Database::disconnect();
							?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($physicianError)?'error':'';?>">
					    <label class="control-label">Physician</label>
					    <div class="controls">
					      	<?php
								$pdo = Database::connect();
								$sql = 'SELECT * FROM physician ORDER BY id DESC';
								echo "<select class='form-control' name='physician_id' id='id'>";
								foreach ($pdo->query($sql) as $row) {
									echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
								}
								echo "</select>";
								Database::disconnect();
							?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($apptTimeError)?'error':'';?>">
					    <label class="control-label">Appointment Time</label>
					    <div class="controls">
					      	<input name="appt_time" type="text"  placeholder="Time" value="<?php echo !empty($apptTime)?$apptTime:'';?>">
					      	<?php if (!empty($apptTimeError)): ?>
					      		<span class="help-inline"><?php echo $apptTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>					  
					  <div class="control-group <?php echo !empty($apptDateError)?'error':'';?>">
					    <label class="control-label">Appointment Date (YYYY-MM-DD)</label>
					    <div class="controls">
					      	<input name="appt_date" type="text"  placeholder="Date" value="<?php echo !empty($apptDate)?$apptDate:'';?>">
					      	<?php if (!empty($apptDateError)): ?>
					      		<span class="help-inline"><?php echo $apptDateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($apptLocationError)?'error':'';?>">
					    <label class="control-label">Appointment Location</label>
					    <div class="controls">
					      	<input name="appt_location" type="text"  placeholder="Location" value="<?php echo !empty($apptLocation)?$apptLocation:'';?>">
					      	<?php if (!empty($apptLocationError)): ?>
					      		<span class="help-inline"><?php echo $apptLocationError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($apptPurposeError)?'error':'';?>">
					    <label class="control-label">Appointment Purpose</label>
					    <div class="controls">
					      	<input name="appt_purpose" type="text"  placeholder="Purpose" value="<?php echo !empty($apptPurpose)?$apptPurpose:'';?>">
					      	<?php if (!empty($apptPurposeError)): ?>
					      		<span class="help-inline"><?php echo $apptPurposeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="appointments.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
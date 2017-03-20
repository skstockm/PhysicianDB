<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		// keep track validation errors
		$patientError = null;
		$physicianError = null;
		$apptTimeError = null;
		$apptLocationError = null;
		$apptPurposeError = null;
		
		// keep track post values
		$patient = $_POST['patient_id'];
		$physician = $_POST['physician_id'];
		$apptTime = $_POST['appt_time'];
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
			$sql = "INSERT INTO events (event_date,event_time,event_location,event_description) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($date,$time,$location,$description));
			Database::disconnect();
			header("Location: events.php");
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
		    			<h3>Create an Event</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="event_create.php" method="post">
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="event_date" type="text"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="event_time" type="text" placeholder="Time" value="<?php echo !empty($time)?$time:'';?>">
					      	<?php if (!empty($timeError)): ?>
					      		<span class="help-inline"><?php echo $timeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
					    <label class="control-label">Location</label>
					    <div class="controls">
					      	<input name="event_location" type="text"  placeholder="Location" value="<?php echo !empty($location)?$location:'';?>">
					      	<?php if (!empty($locationError)): ?>
					      		<span class="help-inline"><?php echo $locationError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="event_description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="events.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php 
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
		$sql = "SELECT * FROM appointments where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
	//show_source(__FILE__)
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
		    			<h3>Read an Appointment</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Physician ID</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['physician_id'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Patient ID</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['patient_id'];?>
						    </label>
					    </div>
					  </div>					  
					  <div class="control-group">
					    <label class="control-label">Appointment Time (HH:MM:SS)</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['appt_time'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Appointment Date (YYYY-MM-DD)</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['appt_date'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Appointment Location</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['appt_location'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Appointment Purpose</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['appt_purpose'];?>
						    </label>
					    </div>
					  </div>
					   <div class="form-actions">
						  <a class="btn" href="appointments.php">Back</a>
					   </div>
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
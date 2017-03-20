<?php 
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: readPatient.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM patient where id = ?";
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
		    			<h3>Read a Patient</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $data['patient_name'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Phone Number</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['patient_phone'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">City</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['patient_city'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">State</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['patient_state'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Zip Code</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['patient_zip'];?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Insurance</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['patient_insurance'];?>
						    </label>
					    </div>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="existingPatient.php">Back</a>
					   </div>
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
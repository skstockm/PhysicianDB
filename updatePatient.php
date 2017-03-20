<?php 
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
		$patientCityError = null;
		$zipCodeError = null;
		$stateError = null;
		
		// keep track post values
		$name = $_POST['patient_name'];
		$phone = $_POST['patient_phone'];
		$insurance = $_POST['patient_insurance'];
		$addressNum = $_POST['patient_addressNum'];
		$patientCity = $_POST['patient_city'];
		$zipCode = $_POST['patient_zip'];
		$state = $_POST['patient_state'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($phone)) {
			$phoneError = 'Please enter Phone Number';
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
		
		if (empty($patientCity)) {
			$patientCityError = 'Please enter City';
			$valid = false;
		}
		
		if (empty($zipCode)) {
			$zipCodeError = 'Please enter Zip Code';
			$valid = false;
		}
		
		if (empty($state)) {
			$stateError = 'Please enter State';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE patient set patient_name = ?, patient_phone = ?, patient_insurance = ?, patient_addressNum = ?, patient_city = ?, patient_zip = ?, patient_state = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$phone,$insurance,$addressNum,$patientCity,$zipCode,$state,$id));
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
		$patientCity = $data['patient_city'];
		$zipCode = $data['patient_zip'];
		$state = $data['patient_state'];
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
		    			<h3>Update a Patient</h3>
		    		</div>
	    			<form class="form-horizontal" action="updatePatient.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="patient_name" type="text"  placeholder="Patient Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
					    <label class="control-label">Phone Number</label>
					    <div class="controls">
					      	<input name="patient_phone" type="text" placeholder="Phone Number" value="<?php echo !empty($phone)?$phone:'';?>">
					      	<?php if (!empty($phoneError)): ?>
					      		<span class="help-inline"><?php echo $phoneError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($addressNumError)?'error':'';?>">
					    <label class="control-label">Address Number</label>
					    <div class="controls">
					      	<input name="patient_addressNum" type="text" placeholder="Address Number" value="<?php echo !empty($addressNum)?$addressNum:'';?>">
					      	<?php if (!empty($addressNumError)): ?>
					      		<span class="help-inline"><?php echo $addressNumError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($patientCityError)?'error':'';?>">
					    <label class="control-label">City</label>
					    <div class="controls">
					      	<input name="patient_city" type="text"  placeholder="City" value="<?php echo !empty($patientCity)?$patientCity:'';?>">
					      	<?php if (!empty($patientCityError)): ?>
					      		<span class="help-inline"><?php echo $patientCityError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($stateError)?'error':'';?>">
					    <label class="control-label">State</label>
					    <div class="controls">
					      	<input name="patient_state" type="text"  placeholder="State" value="<?php echo !empty($state)?$state:'';?>">
					      	<?php if (!empty($stateError)): ?>
					      		<span class="help-inline"><?php echo $stateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($zipCodeError)?'error':'';?>">
					    <label class="control-label">Zip Code</label>
					    <div class="controls">
					      	<input name="patient_zip" type="text"  placeholder="Zip Code" value="<?php echo !empty($zipCode)?$zipCode:'';?>">
					      	<?php if (!empty($zipCodeError)): ?>
					      		<span class="help-inline"><?php echo $zipCodeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($insuranceError)?'error':'';?>">
					    <label class="control-label">Insurance</label>
					    <div class="controls">
					      	<input name="patient_insurance" type="text"  placeholder="Insurance" value="<?php echo !empty($insurance)?$insurance:'';?>">
					      	<?php if (!empty($insuranceError)): ?>
					      		<span class="help-inline"><?php echo $insuranceError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="existingPatient.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
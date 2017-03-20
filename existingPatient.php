<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Existing Patients</h3>
    		</div>
			<div class="row">
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Patient Name</th>
						  <th>Phone Number</th>
					      <!--<th>City</th>-->
						  <th>State</th>
						  <!--<th>Zip Code</th>-->
						  <!--<th>Insurance</th>-->
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM patient ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['patient_name'] . '</td>';
							   	echo '<td>'. $row['patient_phone'] . '</td>';
							   	// echo '<td>'. $row['patient_city'] . '</td>';
							   	echo '<td>'. $row['patient_state'] . '</td>';
							   	// echo '<td>'. $row['patient_zip'] . '</td>';
							   	// echo '<td>'. $row['patient_insurance'] . '</td>';
								
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="readPatient.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="updatePatient.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="deletePatient.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					   //show_source(__FILE__)
					  ?>
				      </tbody>
					  <div class="form-actions">
						  <a class="btn" href="index.php">Back</a>
					  </div>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
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
    			<h3>Existing Appointments</h3>
    		</div>
			<div class="row">
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
					      <th>Physician's ID</th>
		                  <th>Patient ID</th>
						  <th>Appointment Time</th>
						  <th>Appointment Date</th>
						  <th>Appointment Location</th>
						  <th>Appointment Purpose</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM appointments ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
								echo '<td>'. $row['physician_id'] . '</td>';
							   	echo '<td>'. $row['patient_id'] . '</td>';
							   	echo '<td>'. $row['appt_time'] . '</td>';
							   	echo '<td>'. $row['appt_date'] . '</td>';
							   	echo '<td>'. $row['appt_location'] . '</td>';
							   	echo '<td>'. $row['appt_purpose'] . '</td>';
							    echo '<td width=250>';
							   	echo '<a class="btn" href="readAppointment.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="updateAppointment.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="deleteAppointment.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					   //show_source(__FILE__)
					  ?>
				      </tbody>
					  <div class="form-actions">
						  <a class="btn" href="index.php">Back</a>
						  <a href="createAppointment.php" class="btn btn-success">Create New Appointment</a>
					  </div>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
<?php
/* ---------------------------------------------------------------------------
 * filename    : api.php
 * author      : Staci Stockmeyer, skstockm@svsu.edu
 * description : This program returns all the names in the physician file OR 
 *				 if id param is set then only that person's name AS A JSON OBJECT
 * ---------------------------------------------------------------------------
 */
	include 'database.php';
	
	$pdo = Database::connect();
	if($_GET['id']) 
		$sql = "SELECT * from physician WHERE id=" . $_GET['id']; 
	else
		$sql = "SELECT * from physician";

	$arr = array();
	foreach ($pdo->query($sql) as $row) {
	
		array_push($arr, $row['name']);
		
	}
	Database::disconnect();
	//print_r($arr);
	echo '{"Physician Names":' . json_encode($arr) . '}';
?>
<?php
/* ---------------------------------------------------------------------------
 * filename    : login.php
 * author      : skstockm, skstockm@svsu.edu
 * description : This program logs the user in by setting $_SESSION variable
 * ---------------------------------------------------------------------------
 */

// Start or resume session, and create: $_SESSION[] array
session_start(); 

require 'database.php';

if ( !empty($_POST)) { // if $_POST filled then process the form
	// initialize $_POST variables
	$username = $_POST['username']; // username is email address
	$password = $_POST['password'];
	
	// verify the username/password
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM physician_office_admin WHERE username = ? AND password = ? LIMIT 1";
	$q = $pdo->prepare($sql);
	$q->execute(array($username,$password));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	if($data) { // if successful login set session variables
		echo "success!";
		$_SESSION['id'] = $data['id'];
		$sessionid = $data['id'];
		Database::disconnect();
		//echo $sessionid;
		//var_dump($data);
		//exit();
		header("Location: index.php?id=$sessionid ");
	}
	else { // otherwise go to login error page
		Database::disconnect();
		header("Location: login_error.html");
	}
} 
// if $_POST NOT filled then display login form, below.

?>
<!DOCTYPE html>
<!-- ------------------------------------------------------------------------
filename  : StockmeyerProgram04.html
author    : Staci Stockmeyer
date      : 2016-06-21
email     : skstockm@svsu.edu
course    : CIS-255
link      : csis.svsu.edu/~skstockm/cis255/skstockm/StockmeyerProgram04.html
backup    : github.com/cis255/cis255
purpose   : This file serves as Program4 that uses widgets,  
			at Saginaw Valley State University (SVSU) if they are planning on
			majoring in CS or CIS
copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
program structure : 
	<head> metadata, links, script
	<body> The sections of the program: 
		navbar, carousel, My Modern Business Stuff, my portfolio, modern business features, contact
		
external code used in this file: 
	template from: http://startbootstrap.com/template-overviews/modern-business/
	widgets from: http://www.jqwidgets.com/jquery-widgets-demo/
---------------------------------------------------------------------------------->
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
				top:5px;
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
			</div>
			<!-- /.container -->
		</nav>

		<!-- Page Content -->
		<div class="container">
			<div class="span10 offset1">
		
				<div class="row">
					<h3><b>Login</b></h3>
				</div>
		
				<form class="form-horizontal" action="login.php" method="post">
									  
					<div class="control-group">
						<label class="control-label">Username</label>
						<div class="controls">
							<input name="username" type="text"  placeholder="username" required>
						</div>	<!-- end div: class="controls" -->
					</div> <!-- end div class="control-group" -->
					
					<div class="control-group">
						<label class="control-label">Password</label>
						<div class="controls">
							<input name="password" type="password" placeholder="password" required>
						</div>	
					</div> 

					<div class="form-actions" id = "buttons">
						<button type="submit" class="btn btn-success">Sign in</button>
						&nbsp; &nbsp;
					</div>
					
				</form>
				
			</div> <!-- end div: class="span10 offset1" -->
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

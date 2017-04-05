<?php
/* ---------------------------------------------------------------------------
 * filename    : logout.php
 * author      : skstockm, skstockm@svsu.edu
 * description : This program logs the user out by destroying the session
 * ---------------------------------------------------------------------------
 */
session_start();
session_destroy(); 
header("Location: login.php");
?>
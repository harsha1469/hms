<?php

// Inialize session
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['userid'])) {
header('Location: login.php');
}

if ($_SESSION['type'] != "rep") {
	// $link  = $_SESSION['type'] . "_home.php";
	$redir  = "Location: " . $_SESSION['type'] . "_home.php";
    header($redir);
}

include('includes/config.inc');
include('includes/functions.php');
$username = get_username($_SESSION['userid'], $con);

?>

<?php
    if(isset($_GET['status']))
    {
    	$status = $_GET['status'];
       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
	}
?>

<html>
	<head>
		<title>Receptionist Home Page</title>
	</head>
	<body>
		<p> Hello <?php echo $_SESSION['type'] ?></p>
		<p>This is secured page with session: <b> <?php echo $username; ?></b>
		<br>You can put your restricted information here.</p>

		<p><a href="reg_patient.php" >Register patient</a></p>
		<p><a href="edit_patient.php" >Edit patient Details</a></p>
		<p><a href="rep_home.php" target="_blank">Book Apointment</a></p>
		<p><a href="rep_home.php" target="_blank">Send Ambulence</a></p>
		<p><a href="rep_home.php" target="_blank">Clean a room</a></p>
		<!-- <p><a href="rep_home.php" target="_blank">Check Doctor slot</a></p> -->
		<p><a href="rep_home.php" target="_blank">Bill payment</a></p>

		<p><a href="includes/logout.php">Logout</a></p>


	</body>
</html>
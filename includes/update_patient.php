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

	$errors = "";
	$is_error = 0;
	$patient_id=$_POST['patient_id_2'];
	echo patient_id;

	if (isset($_POST['username']) && !empty($_POST["username"]))
	{
		// echo $_POST['username'];
	    $_POST["username"] = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	    if ($_POST["username"] == "")
	    {
	        $errors .= 'Please enter a valid name.<br/>';
	        $is_error = 1;
	    }
	    else
	    	$name = $_POST["username"];
	} else {
	    $errors .= 'Please enter your name.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['dob']) && !empty($_POST["dob"]))
	{
		$cur_date = date("Y-m-d");
		// echo $cur_date . "<br/>";
		if($cur_date < $_POST['dob'] ){
			// echo "error...";
			$is_error = 1;
			$errors .= 'Please enter a valid date. <br/>';
		}
		else
			$dob = $_POST['dob'];

	}  else {
	    $errors .= 'Please enter your Date of Birth.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['address']) && !empty($_POST["address"]))
	{
		$_POST["address"] = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
	    if ($_POST["address"] == "")
	    {
	        $errors .= 'Please enter a valid address.<br/>';
	        $is_error = 1;
	    }
	    else
			$address=$_POST['address'];
	}  else {
	    $errors .= 'Please a address.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['phone_no']) && !empty($_POST["phone_no"]))
		$phone_no=$_POST['phone_no'];
	else {
	    $errors .= 'Please enter your phone number.<br/>';
	    $is_error = 1;
	}

	if (isset($_POST['sex']) && !empty($_POST["sex"]))
	{
		$sex=$_POST['sex'];
	}  else {
	    $errors .= 'Please enter your gender.<br/>';
	    $is_error = 1;
	}

	if($is_error == 1 || $errors != "")
	{
		$msg=$errors;
	    header('Location: ../edit_patient.php?error='.urlencode($msg));
	    echo $errors;
	}

	// select database and setup connection

	$con=mysql_connect('localhost','root','');
	if (!$con) {
    	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('hospital');

	$query = "UPDATE patient SET `patient_name`='$name', `address`='$address', `contact`='$phone_no', `sex`='$sex', `dob`='$dob' WHERE `patient_id`='$patient_id';" ;

	// echo $query;
	if(mysql_query($query))
	{
		// echo 'inerted';
		$patient_id = mysql_insert_id();
		$status = "Patient record updated successfull.";
		header('Location: ../rep_home.php?status='.urlencode($status));
	}
	mysql_close($con);
?>
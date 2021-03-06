<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
		header('Location: login.php');
	}

	if ($_SESSION['type'] != "doctor") {
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}
?>

</body>
</html>	

<html>
    <head>
    <title>Prescription</title>
        <style type="text/css">
 
            body {font-family:Arial, Sans-Serif;}
 
            #container {width:300px; margin:0 auto;}
 
            /* Nicely lines up the labels. */
            form label {display:inline-block; width:140px;}
 
            /* You could add a class to all the input boxes instead, if you like. That would be safer, and more backwards-compatible */
            form input[type="text"]
 
            form .line {clear:both;}
            form .line.submit {text-align:left;}
 
        </style>
    </head>
    <body>
	<?php
	    if(isset($_GET['error']))
	    {
	        $error = $_GET['error'];
	        // echo $error . "<br/>" ;
	        echo "<p style='color:red'> ".$error." </p>" ;
	    }
	?>

	<?php
	    if(isset($_GET['status']))
	    {
	    	$status = $_GET['status'];
	       	echo '<script type="text/javascript"> alert("' .  $status .'"); </script>';
		}
	?>
        <div id="container">
            <form action="includes/write_prex.php"  method="POST" id="prex_from" >
                <h1>Write Prescription</h1>

                <div class="line">Patient Medical Registration Number:
                <input type="number" name="patient_id" id="patient_id">
                </div>

                <?php
					// Creating query to fetch state information from mysql database table.
					mysql_connect("localhost","root","");
					mysql_select_db("hospital");
					$query = "select DISTINCT med_name from medicine where stock > 0;";
					$result = mysql_query($query);

					echo "Medicine:<br/>";
					echo '<select name="med_name" id="med_name" form="prex_from"> ';
					echo '<option value=""> </option>';
					while ($row = mysql_fetch_array($result) )
					{
					   	echo '<option value="' .$row["med_name"]. '">'.$row["med_name"].'</option>';
					}
					echo "</select>";

				?>

                <div class="line">Number of days:<br/>
                <input type="number" name="no_days" id="no_days" min="1">
                </div>

                <input type="checkbox" name="morning" value="1">Morning
				<input type="checkbox" name="afternoon" value="1">Afternoon
				<input type="checkbox" name="night" value="1">night<br/>


                <div class="line submit"><input type="submit" value="Submit" /></div>
 
            </form>
        <form action= "give_prex.php" >
            <div class="line submit"><input type="submit" value="Continue Prescription" /></div>
        </form>
        <form action= "doctor_home.php" >
            <div class="line submit"><input type="submit" value="Back to home page" /></div>
        </form>
        </div>
    </body>
</html>
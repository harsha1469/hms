<?php

	// Inialize session
	session_start();

	// Check, if username session is NOT set then this page will jump to login page
	if (!isset($_SESSION['userid'])) {
		header('Location: login.php');
	}

	if ($_SESSION['type'] != "lab_teck") {
		$redir  = "Location: " . $_SESSION['type'] . "_home.php";
	    header($redir);
	}
?>
<html>
<head>
<title>View Tests</title>
<h1>View Tests</h1>
    <?php
        if(isset($_GET['error']))
        {
            $error = $_GET['error'];
            echo $error . "<br/>" ;
            echo "<p style='color:red'>".$error."</p>" ;
        }
    ?>

    <?php
        $lt_id = $_SESSION['userid'];
        // $app_date = $_POST['app_date'];

        mysql_connect("localhost","root","");
        mysql_select_db("hospital");
        // $query = "select test_id, test_date from test_transaction where lt_id=$lt_id and result is null;";
        $query = "select t2.test_tx_id, t1.test_name from tests_info as t1, test_transaction as t2 where t1.test_id =t2.test_id and t2.test_date is null and t1.test_id in (select test_id from test_transaction where test_date is null );";
        echo $query . "<br/>";

        $result = mysql_query($query);

        echo '<table border="1">';
        echo '<tr><th>Test_tx_id</th><th>Test_name</th></tr>';
        while($row = mysql_fetch_assoc($result))
        {
            echo '<tr>';
            echo '<td>'.$row['test_tx_id'].'</td>';
            echo '<td>'.$row['test_name'].'</td>';
            // echo '<td>'.$row['test_date'].'</td>';
            echo '</tr>';
        }
        echo '</table> <br />';
    ?>
        <form action= "home.php" >
            <div class="line submit"><input type="submit" value="Back to home page" /></div>
        </form>

    <form action="includes/do_test.php" id="amb_service" method="POST">
    
        <div class="line">Test Transaction Number:
            <input type="number" name="test_tx_id" id = "test_tx_id">
            <div class="line">Result Date<input type="date" id="test_date" name='test_date'></div>
        </div>
    <div class="line submit"><input type="submit" value="Perform" /></div>
    </form>

    </body>
</html>
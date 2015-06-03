<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>




<?php
	if(isset($_POST['voice']) && !empty( $_POST['voice'] )){
		global $connection;
		// Process the form
		// Form values in $_POST
		//Perform update
		$id = $_POST["id"];
		$task = $_GET["task"];
		$approve = $_POST['approve_value'];
		$depend = $_GET["depend"];
		$url = $_POST["voice"];

		//2.  Perform database query
		$query 	= "UPDATE sweden_lessons SET ";
		$query .= "{$task}={$approve}, en_voice_url='{$url}' ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
	
	}elseif (isset($_POST['approve']) && !empty( $_POST['approve'] )){
		global $connection;
		// Process the form
		// Form values in $_POST
		//Perform update
		$id = $_POST["id"];
		$task = $_GET["task"];
		$approve = $_POST['approve_value'];
		$depend = $_GET["depend"];

		//2.  Perform database query
		$query 	= "UPDATE sweden_lessons SET ";
		$query .= "{$task} = {$approve} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
	} elseif (isset($_POST['unapprove']) && !empty( $_POST['unapprove'] )){
		global $connection;
		// Process the form
		// Form values in $_POST
		//Perform update
		$id = $_POST["id"];
		$task = $_GET["task"];
		$approve = $_POST['approve_value'];
		$depend = $_GET["depend"];

		//2.  Perform database query
		$query 	= "UPDATE sweden_lessons SET ";
		$query .= "{$depend} = {$approve} ";
		$query .= "WHERE id = {$id} ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
	}
?>






<?php include("../includes/layouts/header.php"); ?>
<?php include("../includes/layouts/left_column.php"); ?>
<?php include("../includes/layouts/filter_top.php"); ?>


		
	
		
		




		
		
		
		
		<?php 
	
	
		
		if ( isset( $_GET['db'] ) && !empty( $_GET['db'] )){
			echo item_list();
		} else {
			print "Please select a task";
		}
		?>
		
	
		
		

	
		
		
		
		
		
		
		
		
<?php include("../includes/layouts/right_column.php"); ?>	
<?php include("../includes/layouts/footer.php"); ?>		
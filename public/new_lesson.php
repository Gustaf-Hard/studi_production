<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>






<?php include("../includes/layouts/header.php"); ?>
<?php include("../includes/layouts/left_column.php"); ?>

<div id="new_lesson">	
<?php
$db = $_GET["db"];

if($db == "sweden_lessons") {	
	
	
	echo "<h2>Add a new lesson to Sweden Tasks</h2>";
	
		
}

?>	
<?php
	
	
	if (isset($_POST['button_submit'])) {
		$video_id_set = check_if_videoid_exists($_POST["video_id"], $db);
		$video_id_db= mysqli_fetch_assoc($video_id_set);
		
		$video_id = mysql_prep($_POST['video_id']);
		$lesson_name = mysql_prep($_POST['lesson_name']);
		$en_man_url = mysql_prep($_POST['en_manuscript_url']);
		$en_trans = (int) $_POST['en_manuscript_translation'];
		$en_proof = (int) $_POST['en_manuscript_proofread'];
		
		if ($video_id_db["video_id"] == $video_id){
		     echo "Video ID already exists";
		    } else {
		     	// Process the form

				// Form values in $_POST
				//2.  Perform database query
				$query = "INSERT INTO sweden_lessons (video_id, lesson_name, en_manuscript_url, en_manuscript_translation, en_manuscript_proofread)
						VALUES ('$video_id', '$lesson_name', '$en_man_url', '$en_trans', '$en_proof')";

				$result = mysqli_query($connection, $query);
				// Test if there was a query error
				if ($result) {
					// Success
					echo "Subject created";


				} else {
					// Failure
					echo "Subject creation failed";
				}
		    }	
	} else {
		// Thi s is probaby a GET request
		echo "the query did not run";
	}
	
?>	
	
	
	<form class="approve" action ="new_lesson.php?db=<?php echo $db; ?>" method="post">
		<br>
		Video ID:<br>
		<input type="text" name="video_id" value=""> <br><br>
		
		Lesson name:<br>
		<input type="text" name="lesson_name" value=""><br> <br>
		
		En/Se Manuscript URL:<br>
		<input type="text" name="en_manuscript_url" value=""><br> <br>
		
		En translation done? <br>
			Yes: <input type="radio" name="en_manuscript_translation" value="1"/> 
			No: <input type="radio" name="en_manuscript_translation" value="0"/><br><br>
		
		En proofread done? <br>
			Yes: <input type="radio" name="en_manuscript_proofread" value="1"/> 
			No: <input type="radio" name="en_manuscript_proofread" value="0"/><br><br>
		
		<input type="submit" name="button_submit" value="Add new lesson"> <br>
	</form>

</div>	
		




		
		
		
		

	
		
		

	
		
		
		
		
		
		
		
		
<?php include("../includes/layouts/right_column.php"); ?>	
<?php include("../includes/layouts/footer.php"); ?>		
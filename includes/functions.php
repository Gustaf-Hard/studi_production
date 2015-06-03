<?php

	// Builds upp the left navigation
	function navigation_item($db, $task, $label_name, $depend, $depend2 = null){
		if ( isset( $_GET['task'] ) && !empty( $_GET['task'] )){
			if ($task == $_GET['task']) {
				$style = "menu_item_selected";
			} else {$style = "menu_item";}
		} else {$style = "menu_item";}
		
		if(!is_null($depend2))
			$depend2_url = "&depend2=".$depend2;
		else
			$depend2_url = ""; 
			
		$output = "<a href=\"index.php?db={$db}&task={$task}&depend={$depend}{$depend2_url}\"><div id=\"{$style}\">{$label_name}</div></a>";
		return $output;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
	
	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	// Add new lesson
	
	
	// Finds all lesson items where task is NULL. Task is set in the URL
	function find_all_lessons() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM {$_GET["db"]} ";
		$query .= "WHERE {$_GET["task"]} IS NULL";
		$item_set = mysqli_query($connection, $query);
		confirm_query($item_set);
		return $item_set;
	}
	
	// Builds upp the task list with items from the find_all_lessons() query
	function item_list() {
		if (isset($_GET["task"])){
			$item_set = find_all_lessons();
		}
		$output = "";
		
		
		while($item = mysqli_fetch_assoc($item_set)) {
			if ( isset( $_GET['depend'] ) && !empty( $_GET['depend'] )){	
				
				if (
					isset($item[$_GET["depend"]])
					&& !empty( $item[$_GET["depend"]])
					&& (
								(
									isset($_GET["depend2"]) 
									&& !is_null($item[$_GET["depend2"]])
								) 
								OR !isset($_GET["depend2"])
					   ) 
					)
					{
							if(isset($depend2))
								$depend2_url = "&depend2=".$_GET["depend2"];
							else
								$depend2_url = "";
								
					$output .= "<a href=\"";
					$output .= "index.php?db={$_GET["db"]}&task={$_GET["task"]}&depend={$_GET["depend"]}{$depend2_url}&video_id={$item["video_id"]}&id={$item["id"]}";
					$output .= "\">";
					$output .= "<div id=\"";
					if ( isset( $_GET['video_id'] ) && !empty( $_GET['video_id'] )){
						if ($item["video_id"] == $_GET["video_id"]) {$output .= "item_selected";} else {$output .= "item"; }
					} else {$output .= "item"; }
					$output .= "\">";
					$output .= "<div id=\"item_id\">";
					$output .= htmlentities($item["video_id"]);
					$output .= "</div>";
					$output .= "<div id=\"item_name\">";
					$output .= htmlentities($item["lesson_name"]);
					$output .= "</div>";
					$output .= "<div id=\"item_approve\">";
					$output .= "<form> <input type=\"submit\" name=\"approve\" value=\"Aprrove\" /> </form>";
					$output .= "</div>";
					$output .= "<div id=\"item_region\">Manuscript</div>";
					$output .= "<div id=\"item_clear\"></div>";
					$output .= "</div>";
					$output .= "</a>";
				}
			}
		}
		mysqli_free_result($item_set);
		return $output;
	}

	// Runs DB query to find all content about one ID
	// Gets ID from the URL _GET
	function find_lesson_by_id ($id){
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM {$_GET["db"]} ";
		$query .= "WHERE id = \"$id\" ";
		$query .= "LIMIT 1";
		$id_set = mysqli_query($connection, $query);
		confirm_query($id_set);
		return $id_set;
	}
	
	function check_if_videoid_exists($video_id, $db){
		global $connection;

		$query  = "SELECT video_id, id ";
		$query .= "FROM {$db} ";
		$query .= "WHERE video_id='".$video_id."' ";
		$query .= "LIMIT 1";
		$video_id_set = mysqli_query($connection, $query);
		confirm_query($video_id_set);
		
		return $video_id_set;
	
}
		
	
	
	// SHOW COORRECT LINKS AND CONTENT ACCORDING TO TASK IN RIGHT COLUMN
	function task_specific_details() {
		$simple_task = find_simplified_task();
		$simple_depend = find_simplified_depend();
		$id_set = find_lesson_by_id ($_GET["id"]);
		$id_content = mysqli_fetch_assoc($id_set);
		$url = $id_content["en_manuscript_url"];
		$db = $_GET["db"];
		$depend = $_GET["depend"];
		$task = $_GET["task"];
		$id = $_GET["id"];
		
		// CONTENT FOR TRANSLATION
		if (strpos($_GET["task"],'translation') !== false) {
			$output = "<br>";
			$output .= "Task:";
			$output .= "<a target=\"bank\" href=\"{$url}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/write.svg\" width=\"20%\">";
			$output .= "<h3>Translate {$id_content["video_id"]}</h3>";
			$output .= "<h4>Click here to translate</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			$output .= "<form class=\"approve\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"1\"/> ";
			$output .= "<input type=\"submit\" name=\"approve\" value=\"Approve {$simple_depend}\"/> ";
			$output .= "</form>";
		} 
		// CONTENT FOR PROOFREADER
		elseif (strpos($_GET["task"],'proofread') !== false) {
			$output = "<br>";
			$output .= "Proofread the following manuscript:";
			$output .= "<a target=\"bank\" href=\"{$url}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/proofread.svg\" width=\"20%\">";
			$output .= "<h3>Manuscript</h3>";
			$output .= "<h4>Click here to proofread</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			$output .= "<form class=\"approve\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"1\"/> ";
			$output .= "<input type=\"submit\" name=\"approve\" value=\"Approve {$simple_depend}\"/> ";
			$output .= "</form>";
			$output .= "<form class=\"unapprove\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"NULL\"/> ";
			$output .= "<input type=\"submit\" name=\"unapprove\" value=\"Send back for {$simple_depend}\"/> ";
			$output .= "</form>";
		} 
		//CONTENT FOR VOICE ACTOR
		elseif (strpos($_GET["task"],'en_voice') !== false) {
			$output = "<br>";
			$output .= "Record {$id_content["video_id"]} as a regular record";
			$output .= "<a target=\"bank\" href=\"{$url}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/voice.svg\" width=\"20%\">";
			$output .= "<h3>Record {$id_content["video_id"]}</h3>";
			$output .= "<h4>Click here to view manuscript</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			$output .= "<a target=\"bank\" href=\"https://script.google.com/macros/s/AKfycbwiFLu-uL2LBJCJVny39St610Cp7Z7DKUT8IulTEjaPTmIPgY8z/exec\">";
			$output .= "<div id=\"task_spec\" class=\"upload_task\"> ";
			$output .= "<h3>1. Click here to upload voicefile</h3>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			$output .= "<form class=\"approve\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"1\"/> ";
			$output .= "<br>Paste the URL from the upload here:";
			$output .= "<input type=\"text\" name=\"voice\" value=\"2. Paste the URL to audio here\"/> ";
			$output .= "<input type=\"submit\" name=\"send\" value=\"OK. Audio uploaded and ready\"/> ";
			$output .= "</form>";
			$output .= "<form class=\"unapprove\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"NULL\"/> ";
			$output .= "<input type=\"submit\" name=\"unapprove\" value=\"Send back for {$simple_depend}\"/> ";
			$output .= "</form>";
		} 
		// CONTENT FOR VIDOE DETAILS
		elseif (strpos($_GET["task"],'video_details') !== false) {
			$output = "<br>";
			$output .= "Upload all illustrations and documentations for {$id_content["video_id"]}";
			$output .= "<a target=\"bank\" href=\"{$url}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/prepare.svg\" width=\"20%\">";
			$output .= "<h3>View {$id_content["video_id"]}</h3>";
			$output .= "<h4>Click here to view manuscript</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			$output .= "<form class=\"approve\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"1\"/> ";
			$output .= "<br>Paste the URL from the upload here:";
			$output .= "<input type=\"text\" name=\"voice\" value=\"Paste the folder-URL here\"/> ";
			$output .= "<input type=\"submit\" name=\"send\" value=\"OK. URL pasted\"/> ";
			$output .= "</form>";
		} 	
		// CONTENT FOR VIDEO EDITING
		elseif (strpos($_GET["task"],'video') !== false) {
			$output = "<br>";
			$output .= "Animate {$id_content["video_id"]} with provided information: ";
			$output .= "<a target=\"bank\" href=\"{$id_content["en_manuscript_url"]}\">";
			
			// Manuscript Url
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/proofread.svg\">";
			$output .= "<h3>Manuscript</h3>";
			$output .= "<h4>Click here to view manuscript</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			
			// En_Voice Url
			$output .= "<a target=\"bank\" href=\"{$id_content["en_voice_url"]}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/voice.svg\">";
			$output .= "<h3>Voice</h3>";
			$output .= "<h4>Click here to view voice files</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			
			// Details Url
			$output .= "<a target=\"bank\" href=\"{$id_content["video_details_url"]}\">";
			$output .= "<div id=\"task_spec\"> ";
		    $output .= "<img src=\"../assets/prepare.svg\">";
			$output .= "<h3>Details</h3>";
			$output .= "<h4>Click here to view folder</h4>";
			$output .= "<div style=\"clear: both;\"> </div>";
			$output .= "</div>";
			$output .= "</a>";
			
			// The approve button
			$output .= "<form class=\"approve\" action =\"";
			$output .= "index.php?db={$db}&task={$task}&depend={$depend}";
			$output .= "\" method=\"post\">";
			$output .= "<input type=\"hidden\" name=\"id\" value=\"{$id}\"/> ";
			$output .= "<input type=\"hidden\" name=\"approve_value\" value=\"1\"/> ";
			$output .= "<br>Paste the URL from the upload here:";
			$output .= "<input type=\"text\" name=\"voice\" value=\"2. Paste the URL to audio here\"/> ";
			$output .= "<input type=\"submit\" name=\"send\" value=\"OK. Audio uploaded and ready\"/> ";
			$output .= "</form>";
			}
		return $output;
	}	

	//  Extract simplified task from task eg. en_manuscript_translation = Translation
	function find_simplified_task() {
		if (strpos($_GET["task"],'translation') !== false) {
		    return 'Translation';
		} elseif (strpos($_GET["task"],'proofread') !== false) {
			return 'Proofread';
		} elseif (strpos($_GET["task"],'voice') !== false) {
			return 'Voice';
		} elseif (strpos($_GET["task"],'video') !== false) {
			return 'Video';
		}
	}
	
	//  Extract simplified depend from depend eg. en_manuscript_Proofread = Proofread
	function find_simplified_depend() {
		if (strpos($_GET["depend"],'translation') !== false) {
		    return 'Translation';
		} elseif (strpos($_GET["depend"],'proofread') !== false) {
			return 'Proofread';
		} elseif (strpos($_GET["depend"],'voice') !== false) {
			return 'Voice';
		} elseif (strpos($_GET["depend"],'video') !== false) {
			return 'Video';
		}
	}
	
	// Builds up the right column
	function video_id_details (){
		if ( isset( $_GET['video_id'] ) && !empty( $_GET['video_id'] )){
			
			$id_set = find_lesson_by_id ($_GET["id"]);
			$lesson = mysqli_fetch_assoc($id_set);
			$simple_task = find_simplified_task();
			$simple_depend = find_simplified_depend();
			
			$db = $_GET["db"];
			$depend = $_GET["depend"];
			$task = $_GET["task"];
			$id = $_GET["id"];
			
			//Starting the outpot
			$output  = "<h4>Referral id: {$lesson["video_id"]}</h4>";
			$output .= "<h2>";
			
				// Finds the subject name from Video ID
				if (strpos($_GET["video_id"],'MAH') !== false) 
					$output .= "Mathematics <br><br>";
				elseif (strpos($_GET["video_id"],'FYH') !== false) 
					$output .= "Physics <br><br>";
			
			$output .="{$lesson["lesson_name"]}</h2>";
			$output .= task_specific_details();
			
		} else {$output = "Select an item in the list"; }
		
		return $output;
	}
	
?>
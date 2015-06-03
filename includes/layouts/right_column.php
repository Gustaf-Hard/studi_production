<span style="color: #fff;">		 ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ </span>
		
	
</div>





<div id="right_column">
		
		<h4 class="lesson_info">LESSON INFO</h4>
		<hr>
		

		
		<?php echo video_id_details () ?>
		
		<?php
		if ( isset( $_GET['depend'] ) && !empty( $_GET['depend'] )){
			$simple_depend = find_simplified_depend();
		}
		
		if ( isset( $_POST['approve'] ) && !empty( $_POST['approve'] )){
			print "<h3>The task was approved</h3>";	
		} elseif ( isset( $_POST['unapprove'] ) && !empty( $_POST['unapprove'] )){
			print "<h3> The item has gone back to {$simple_depend}</h3>";
		}
		?>
		
		
	    
</div>

</div>
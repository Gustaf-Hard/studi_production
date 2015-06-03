<div id="left_column">	
		<h4 class="lesson_info">Sweden tasks</h4>
		<div id="add_content">
			<a href="new_lesson.php?db=sweden_lessons">+ Add new lesson</a><br>	
	
		</div>
		<?php $db = "sweden_lessons"; ?>
		
		
		<?php
		
		
		//English language
			//English translation
			echo navigation_item($db, "en_manuscript_translation", "English translation", "en_manuscript_url");
			//English proofread
			echo navigation_item($db, "en_manuscript_proofread", "English proofread", "en_manuscript_translation");
			//English voice
			echo navigation_item($db, "en_voice", "English voice", "en_manuscript_proofread");
			//English video
			echo navigation_item($db, "en_video", "English video", "en_voice", "video_details_url");
			//English subtitles
			echo navigation_item($db, "en_subtitle", "English subtitle", "en_video");
			
		//Swedish language -->
			//English translation
			echo navigation_item($db, "se_manuscript_translation", "Swedish translation", "en_manuscript_url");
			//English proofread
			echo navigation_item($db, "se_manuscript_proofread", "Swedish proofread", "se_manuscript_translation");
			//English voice
			echo navigation_item($db, "se_voice", "Swedish voice", "se_manuscript_proofread");
			//English video
			echo navigation_item($db, "se_video", "Swedish video", "se_voice", "video_details_url");
			//English subtitles
				//Not added to db yet
		
		//Arabic language -->
			//Arabic translation
			echo navigation_item($db, "ar_manuscript_translation", "Arabic translation", "ar_manuscript_url");
			//Arabic proofread
			echo navigation_item($db, "ar_manuscript_proofread", "Arabic proofread", "ar_manuscript_translation");
			//Arabic voice
			echo navigation_item($db, "ar_voice", "Arabic voice", "ar_manuscript_proofread");
			//Arabic video
			echo navigation_item($db, "ar_video", "Arabic video", "ar_voice", "video_details_url");
			//Arabic subtitles
				//Not added to db yet
		
		//Somali language -->
			//Somali translation
			echo navigation_item($db, "so_manuscript_translation", "Somali translation", "so_manuscript_url");
			//Somali proofread
			echo navigation_item($db, "so_manuscript_proofread", "Somali proofread", "so_manuscript_translation");
			//Somali voice
			echo navigation_item($db, "so_voice", "Somali voice", "so_manuscript_proofread");
			//Somali video
			echo navigation_item($db, "so_video", "Somali video", "so_voice", "video_details_url");
			//Somali subtitles
				//Not added to db yet
		
		
		//Dari language -->
			//Dari translation
			echo navigation_item($db, "da_manuscript_translation", "Dari translation", "da_manuscript_url");
			//Dari proofread
			echo navigation_item($db, "da_manuscript_proofread", "Dari proofread", "da_manuscript_translation");
			//Dari voice
			echo navigation_item($db, "da_voice", "Dari voice", "da_manuscript_proofread");
			//Dari video
			echo navigation_item($db, "da_video", "Dari video", "da_voice", "video_details_url");
			//Dari subtitles
				//Not added to db yet
		
		
		//Other things language -->
			echo navigation_item($db, "ar_manuscript_url", "(A) Prepare foreign trans", "en_manuscript_proofread");
			echo navigation_item($db, "video_details_url", "(A) Video prepare", "en_manuscript_url");
		
		
		?>
		
	
		
		
	</div>
	<div id="middle_column">
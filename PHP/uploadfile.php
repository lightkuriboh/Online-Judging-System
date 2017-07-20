<html>
	<body>
		<div onload = 'change()'>
			<?php 
				include("class_directory.php"); 
				include($directory_of_classes.'connect_problems.php'); 
				include($directory_of_classes."session.php");
			?>
			<?php
				if(isset($_REQUEST['CCode']) && isset($_FILES['code'])) {
					$maxFileSize = 1024 * 1024;
					if($_FILES['code']['size'] <= $maxFileSize)
						$path = $main_directory."PHP/data/";
						$qrID = "SELECT max(Submission_ID) AS mxx FROM submition";
						$mx = mysqli_query($con, $qrID);
						$mx_row = $mx->fetch_object();
						
						if (strlen($mx_row->mxx) == 0) $mx_row->mxx = -1;
						$new_name = "[".($mx_row->mxx + 1)."][".$_REQUEST['pro']."]";
						$cur_name = $_FILES['code']['name'];
						$extend = "";
						for ($i = 0; $i < strlen($cur_name); $i++) 
						{
							if ($cur_name[$i] == '.')
							{
								for ($j = $i; $j < strlen($cur_name); $j++) $extend .= $cur_name[$j];
								break;
							}
						}
						if ($extend == ".cpp" || $extend == ".pas") {
							$info = move_uploaded_file(
									$_FILES['code']['tmp_name'],$main_directory."PHP/data/".
									$new_name.$extend);
							copy($main_directory."PHP/data/".$new_name.$extend, 
							$main_directory."PHP/source/".($mx_row->mxx + 1).$extend);
							$result = "Judging...";
							$date = gmdate("Y-m-d H:i:s");	
							$language = "C++";
							if ($extend == ".pas")
								$language = "Pascal";
							$insertqr = "insert into submition 
								(Submission_ID, Problems_ID, Problems_Name, User_Name, Language, Score, Submit_Time)
									values
									('".($mx_row->mxx + 1)."', '".$_REQUEST['pro']."', '".
									$_REQUEST['pros_name']."', '".$_SESSION['UserName']."', '".$language
									."', '".$result."', '".$date.  "')
							";
							mysqli_query($con, $insertqr);
						}
				} 
				else echo 'Not submited!<br>';
			?>
		</div>
		<script>
			setTimeout(function change() {				
				window.location.replace('submission.php?page=1');
			}, 000);	
		</script>
	</body>
</html>
<!DOCTYPE html>
<html>
	<title>
		Kuriboh Kute
	</title>
	<head>
		<?php
			include("header.php");
		?>
	</head>
	<body>
		<div class = "session_classes">
			<?php
				include("session.php");
			?>
		</div>
		<div id = "main_block">
			<div id= "header">
				<?php
					include("logo.php");
				?>		
			</div>
			<?php
				include ("Origin.php");
			?>			
			<div id = "main">
				<div id = "section" style = "text-align:center;">	
					<p>					
						Solved
					</p>
					<?php
						if (isset($_REQUEST['username'])) {
							include($directory_of_classes."connect_problems.php"); 							
							$query = "select * from Highest_score";
							$returned_result = mysqli_query($con, $query);
							$fields = array();
							while ($field = mysqli_fetch_field($returned_result)) {
								$fields[] = $field->name;
							}
							$query = "select * from Highest_score where User = '".$_REQUEST['username']."'";
							$returned_result = mysqli_query($con, $query);
							$none_accept_pros = array();	
							while ($row = mysqli_fetch_array($returned_result)) {
								foreach ($fields as $field) {
									if ($row[$field] == "100") 
										echo "<a href = 'submission.php?Pro=".$field."&User=".$_REQUEST['username'].
												"'>".$field. "</a> | ";
									else
										if ($field != 'User' && $row[$field] != null)
											$none_accept_pros[] = $field;
								}
							}
						}
					?>
					<hr style = 'border-width:5px;'/>
					<p style = 'color:red;'> Not solved </p>
					<?php
						if (isset($_REQUEST["username"]))
							foreach ($none_accept_pros as $name) 
								echo "<a href = 'submission.php?Pro=".$name."&User=".$_REQUEST['username']."'>".
									$name. "</a> | ";													
					?>
					<hr style = 'border-width:5px;'>
					<?php
						if (isset($_REQUEST['username']))
							echo "
							<a href = 'submission.php?User=".$_REQUEST['username']."'>".
								"Recent submissions". 
							"</a>";
						else
						if (!(Not_logged_in()))
							echo "
							<a href = 'submission.php?User=".$_SESSION['UserName']."'>".
								"Recent submissions". 
							"</a>";
					?>					    
				</div>	
			</div>			
		</div>
		<div id = "script">
			<?php
				include ("script.php");
			?>
		</div>
		
	</body>
</html>

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
			<?php 
				require($directory_of_classes.'connect_problems.php'); 
			?>
			<div id = "main">
				<div id = "section">	
					<table id = "table_list" border = '0' cellpadding = '7px' cellspacing = '2px'>	
						<?php
							if (isset($_REQUEST['User'])) 
								echo "
								<tr>
									<th colspan = '6', 
										style = 'text-align:center;font-size:200%;color:red'>".
										$_REQUEST['User'].": Submissions
									</th>
								</tr>";					
						?>
						<tr>
							<th>
								<p id = "list"> Submit ID </p>
							</th>					
							<th>
								<p id = 'list'> Problem's ID </p>
							</th>
							<th>
								<p id = 'list'> User's Name </p>
							</th>
							<th>
								<p id = 'list'> Language </p>
							</th>
							<th>
								<p id = 'list'> Score </p>
							</th>
							<th>
								<p id = 'list'> Submit time (GMT) </p>
							</th>			
						</tr>			
						
					</table>					    			
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






























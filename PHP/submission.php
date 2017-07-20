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
				<div id = "section">							
					<table id = "table_list" cellpadding = '7px' cellspacing = '2px'>				
						<tr>
							<th  colspan = "6", style = "text-align:center; color:red; font-size:200%;cellpadding:5px;">
								Submissions listing
							</th>
						</tr>
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
						<?php
							if (isset($_REQUEST['User']) || isset($_REQUEST['Pro'])) 
								include($directory_of_classes.'specific_require_in_listing_submissions.php');
							else
								include($directory_of_classes.'Listing_submissions.php');
						?>	
					</table>
		
					<ul class = 'pagination'>
						<?php
							include($directory_of_classes.'Listing_pages_submission.php');
						?>
					</ul>								    
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

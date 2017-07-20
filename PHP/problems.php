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
					<?php  
						if (!isset($_REQUEST['code']))
						{							
							include('Problems_list.php');
						}
						else
						{
							include($directory_of_classes.'pros_data.php');
						}
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

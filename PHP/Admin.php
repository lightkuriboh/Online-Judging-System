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
				<?php
					if (Not_logged_in() || (!isset($_SESSION['IsAdmin'])) || 
						$_SESSION['IsAdmin'] != 'Boss' || $_SESSION['IsAdmin'] == 'Admin')
						{
							echo "You don't have permission to access this content! <br/>
								Please come back to ";
							exit ("<a href = 'index.php'> Home </a> before loging in again!!");
							
						}
				?>
				<ul>
					<li>
						<a href = "Admin.php?Action=addpro"/> Add new Problem </a>
						<?php						
							echo "<form enctype = 'multipart/form-data' id = 'add_pro_form'>";
							if (isset($_REQUEST["Action"]) && $_REQUEST["Action"] == "addpro") {
								include($directory_of_form."add_problem_form.php");						
							}
							echo "</form>";
						?>
					</li>
					<li>
						<a href = "register.php"/> Add account </a>
					</li>
					<li>
						<a href = "Admin.php?Action=reset_password"> Reset Password </a>
						<?php
							echo "<form id = 'reset_form'>";
							if (isset($_REQUEST["Action"]) && $_REQUEST["Action"] == "reset_password") {
								echo "<input name = 'un' placeholder = 'UserName'>";
								echo "<input name = 'OK' id = 'btn_reset_pass' type = 'submit' value = 'reset'>";
							}
							echo "</form>";
						?>
					</li>
				</ul>
				
			</div>			
		</div>	
		<div id = "script">
			<?php
				include ("script.php");
			?>
		</div>		
		<script type="text/javascript">
			$('#btn_ul_pros').click( function() {								  											
				$.ajax({					
					type: "POST",
					url: "/classes/session_add_pro.php",
					data: $('#add_pro_form').serialize(),					
					success: function(resp) {
						setTimeout(function() {
							alert(resp);
						}, 2000);						
					},
					error: function () {
						setTimeout(function() {
							alert('failure');
						}, 2000);	
					},					
				});				
			});
			$('#btn_reset_pass').click( function () {								
				$.ajax({
					type: "POST",
					url: "/classes/reset_pass.php",
					data: $('#reset_form').serialize(),
					success: function(resp) {
						setTimeout(function() {
							alert(resp);
						}, 2000);						
					},
					error: function () {
						setTimeout(function() {
							alert('failure');
						}, 2000);	
					},
				});
			});
			
		</script>
		
	</body>
</html>

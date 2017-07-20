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
				<p> Register Form </p>

				<form id = 'reg_form' style = 'font-size:100%;color:blue;background-color:white;'>
					<input id = 'un' type = 'text' name = 'username' size = '30' placeholder = 'UserName(*)(Limit: 6 - 20 chars)' > <br>
					<input id = 'pw' type = 'password' name = 'password' size = '30' placeholder = 'Password(*)(Limit: 6 - 20 chars)'><br>
					<input id = 'rpw' type = 'password' name = 'rePassword' size = '30' placeholder = '(Re)Password(*)'><br>
					<input id = 'nm' type = 'text' name = 'name' size = '30' placeholder = 'Your Name(*)'><br>
					<input id = 'sc' type = 'text' name = 'school' size = '30' placeholder = 'Your School(*)'> <br>
					<input id='btn_reg' type = 'submit' name = 'ok' value='Submit' style='color:red;background-color:yellow;'>
				</form>

			</div>			
		</div>
		<div id = "script">
			<?php
				include ("script.php");
			?>
		</div>
		<script type="text/javascript">
			$("#btn_reg").click(function () {								
				$.ajax({
					type: "POST",
					url: "/classes/session_register.php",
					data: $('#reg_form').serialize(),
					success: function(resp) {
						alert(resp);												
					},
				});
			});
		</script>
	</body>
</html>

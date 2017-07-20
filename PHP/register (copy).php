		
		<div id = 'section'>		
			<div class = "panel panel-primary" style = "width:970px">
				<div class = "panel-heading">
					<p> Register Form </p>
				</div>
				<div class = "panel-body">
					<form id = 'reg_form' style = 'font-size:100%;color:blue;background-color:white;'>
						<input id = 'un' type = 'text' name = 'username' size = '30' placeholder = 'UserName(*)(Limit: 6 - 20 chars)' > <br>
						<input id = 'pw' type = 'password' name = 'password' size = '30' placeholder = 'Password(*)(Limit: 6 - 20 chars)'><br>
						<input id = 'rpw' type = 'password' name = 'rePassword' size = '30' placeholder = '(Re)Password(*)'><br>
						<input id = 'nm' type = 'text' name = 'name' size = '30' placeholder = 'Your Name(*)'><br>
						<input id = 'sc' type = 'text' name = 'school' size = '30' placeholder = 'Your School(*)'> <br>
					</form>
				</div>
				<div class = "panel-footer">
					<input id='btn_reg' type = 'submit' name = 'ok' value='Submit' style='color:red;background-color:yellow;'>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$("#btn_reg").click(function () {								
				$.ajax({
					type: "POST",
					url: "/classes/session_register.php",
					data: $('#reg_form').serialize(),
					success: function(resp) {
						alert(resp);						
						if (resp == 'ivalid_username') {	
							$.notify({
								message: 'Your username can contain only alphabel letters, number and '+'_ letters'+', please try again'
							}, {
								type: 'warning'
							});
						}
						else
						if (resp == 'username_len_ivalid') {
							$.notify({
								message: 'Your username is too long or too short (Limit: 6 - 20 chars)'
							}, {
								type: 'warning'
							});
						}
						else
						if (resp == 'password_len_ivalid') {
							$.notify({
								message: 'Your password is too long or too short (Limit: 6 - 20 chars)'
							}, {
								type: 'warning'
							});
						}
						else
						if (resp == 'ivalid_password') {
							$.notify({
								message: 'Your password can contain only alphabel letters and number, please try again'
							}, {
								type: 'warning'
							});
						}
						else
						if (resp == 'ivalid_repeat_password') {
							$.notify({
								message: 'Password is not repeated correctly, please try again'
							}, {
								type: 'warning'
							});
						}	
						else
						if (resp == 'duplicate') {
							$.notify({
								message: 'This username has existed already, please try again'
							}, {
								type: 'warning'
							});
						}
						else {
							$.notify({
								message: 'Signed up successfully <3 Sign in and enjoy!'
							}, {
								type: 'warning'
							});
							setTimeout(function() {
								window.location.replace("index.php");
							}, 2000);					
						}
					},
				});
			});
		</script>
	</body>
</html>

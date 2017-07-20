				<div id= "nav">
					<hr style = "border-width:10px;">
					<ul id = "menu">
						<li> 
							<a href = "index.php" > Home
							</a> 
						</li>		
						<li> 
							<a href = "problems.php" > Problems Set
							</a> 
						</li>
						<li> 
							<a href = "contests.php" > Contests
							</a> 
						</li>		
						<li> 
							<a href = "submission.php?page=1"  > Submissions
							</a> 
						</li>		
						<li>
							<?php
								if (!Not_logged_in())
									echo "<a href = 'profile.php?username=".$_SESSION['UserName'].
									"'> See my profile </a>";
							?>
						</li>	
						<li>
							<?php
								if (!Not_logged_in() && isset($_SESSION['IsAdmin']) && 
									($_SESSION['IsAdmin'] == 'Boss' || $_SESSION['IsAdmin'] == 'Admin'))
									echo "<a href = 'Admin.php'> For Admin </a>";
							?>
						</li>	
					</ul>
					<hr style = "border-width:10px;">
				</div>	
						
				<div id = "aside">
					<div class = "panel panel-primary">	
						<div class = "panel-heading ">
							<?php
								if (Not_logged_in()) 
									echo "<p> You haven't logged in! </p>";
								else echo "<p> Welcome! ".$_SESSION['UserName']. "</p>";
							?>
						</div>
						<div class = "panel-body">
							<div id = 'change_to_reg'>
								<?php
									if (Not_logged_in()) 
										include($directory_of_form."login_form.php");
									else 
									{
										include($directory_of_classes."connect_user.php");
										$query = "select * from User_infomation where UserName = '".
													$_SESSION['UserName']."'";
										$returned_info = mysqli_query($con, $query);
										$row = mysqli_fetch_array($returned_info);
									}							
								?>	
								<p style = "font-size:100%;text-align:left;">
									<?php 
										if (!Not_logged_in()) {
											echo "Name: ".$row['Name']."<br>"; 
											echo "School: ".$row['School']."<br>";
										}
									?>
								</p>
							</div>
						</div>
						<div class = "panel-footer">
							<?php
								if (!Not_logged_in())
									echo "<form>
									<button onclick = '' id = 'btn_logout'> LogOut </button></form>";									
								//else echo "<a href = 'register.php'> Register </a>";
							?>
						</div>
					</div>
				</div>
				
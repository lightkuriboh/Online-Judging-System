<?php include('connect_problems.php');  ?>
<?php
	$query = "select * from Problems_info where ID = '".$_REQUEST['code']."'";
	$query_info = mysqli_query($con, $query);
	$row = mysqli_fetch_array($query_info);							
?>
<div id = "main2">
	<div id = "section2">
		<div class = "panel panel-primary">
			<div class = "panel-heading">					
				<p style = "font-size:120%;">
					<?php
						echo $row['Name']."<br>";
					?>
				</p>
			</div>
			<div class = "panel-body" style = 'color:green;'>
				<?php
					echo "Score type: ".$row['Type']."<br>";
					echo "Time Limit: ".$row['TimeLimit']."<br>";
					echo "Memory Limit: ".$row['MemoryLimit']."<br>";
					echo "Input: ".$row['INPUT']."<br>";
					echo "Output: ".$row['OUTPUT']."<br>";
					echo "<hr>";
					echo "ID: ".$row['ID']."<br>";
					echo "Tags: ".$row['Tags']."<br>";
					echo "Setter: ".$row['Setter']."<br>";
					echo "Source: ".$row['Source']."<br>";
				?>
			</div>
			<div class = "panel-footer">
				<h5 style = 'color:red;'> Your Best Score: </h5>
				<?php						
					if (!Not_logged_in()) {
						$query = "select ".$_REQUEST['code']." from Highest_score WHERE User = '".$_SESSION['UserName']."'";
						$answer = mysqli_query($con, $query);						
						$YourBestScore = mysqli_fetch_array($answer);
						$YourBestScore = $YourBestScore[$_REQUEST['code']];
						if ($YourBestScore == null) $YourBestScore = "You haven't submited solution for this problems!";
						echo $YourBestScore;
					}
					else echo 'You have to log in to see your score!';							
				?>
				<hr style = "border-width:10px;">
				<?php 
					echo "<form id = 'ulform' action = 'uploadfile.php?pro=".$_REQUEST['code'].
					"&pros_name=".$row['Name']."' method = 'POST' enctype = 'multipart/form-data'>"; ?>
					<input type = "file" name = "code" style = "max-width:200px;">   <br>
					<?php
						if (!Not_logged_in())
						{
							echo "<button id = 'ul_btn' type = 'submit' name = 'CCode' > submit</button><br>";
						}
						else
							echo "You have to log in to submit the solotion!";
					echo "</form>";
				?>
				
			</div>
		</div>
	</div>
	<div id = "aside2">
		<?php 
			echo "<a href = 'submission.php?Pro=".$_REQUEST['code']."'> Status </a>"; 
		?>
		<h2 style = 'text-align:center;'>
			<?php echo $row['Name']; ?>
		</h2>			
		<?php
			if($fi = fopen($row['Location'], "r"))
			{
				while (!feof($fi))
					echo fgets($fi)."<br>";
				fclose($fi);
			} else echo "File loi";
		?>		
	</div>
</div>	

















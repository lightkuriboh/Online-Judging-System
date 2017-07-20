<?php
	include('connect_problems.php');
	include ("class_directory.php");
?>
<?php
		$queryy = 'select * from submition';
		$pros = mysqli_query($con, $queryy);
		$num_rows = mysqli_num_rows($pros);
		$lim = (int)($num_rows / 20) + ($num_rows % 20 > 0);
		global $page;
		if (!isset($_REQUEST['page'])) $page = '1';
		else $page = $_REQUEST['page'];
		$page = (int)$page;
		$mod = 20;
		if ($page == $lim) {
			$mod = $num_rows % 20;
			if ($mod == 0) $mod = 20;
		} else $mod = 20;
		
		$query = "select * from submition LIMIT ".(max(0, $num_rows - $page * 20 + 1)).", ".$mod;
		$submit_info = mysqli_query($con, $query);
		$result = array();
		while ($row = mysqli_fetch_array($submit_info)) $result[] = $row;
		$result = array_reverse($result);
		foreach ($result as $row)
		{
			if ($row['Score'] == "Judging...") {		
				if (file_exists ($main_directory."PHP/result/".($row['Submission_ID']).".txt")) {
					$fi = fopen($main_directory."PHP/result/".($row['Submission_ID']).".txt", "r");
					$row['Score'] = "";
					$cnt = 0;
					while (!feof($fi)) {
						if ($cnt != 0) $row['Score'] .= fgets($fi); else $row['Score'] .= fgets($fi);
						$cnt++;
					}
					fclose($fi);
					mysqli_query($con, "update submition set Score = '".$row['Score']."' where Submission_ID = '".
																	$row['Submission_ID']."'");
		//update highest score					
					$myscorenow	= (double)$row['Score'];					
					$query = "select ".$row['Problems_ID']." from Highest_score WHERE User = '".
																$row['User_Name']."'";
					$answer = mysqli_query($con, $query);						
					$myscore = mysqli_fetch_array($answer);
					$myHighestscoreNow = $myscore[$row['Problems_ID']];
					if ($myHighestscoreNow == null || (double)$myscorenow > (double)$myHighestscoreNow) {
						$query = "update Highest_score set ".$row['Problems_ID']." = '".$myscorenow.
								  "' where User = '".$row['User_Name']."'";								
						mysqli_query($con, $query);
					}		
//--------------------------------------
				}				
			}			
			if (strlen($row['Score']) > 2 && $row['Score'][0].$row['Score'][1].$row['Score'][2] == "100")
				echo "<tr style = 'color:green;'> <td>";
			else
			if ($row['Score'][0] == "0" || $row['Score'][0] == 'C')
				echo "<tr style = 'color:red;'> <td>";
			else
			if ($row['Score'][0] == 'J')
				echo "<tr style = 'color:#4f0707;'> <td>";
			else
				echo "<tr style = 'color:#e58c39;'> <td>";
			if (isset($_SESSION['UserName']) && ($row['User_Name'] == $_SESSION['UserName'] || 
					$_SESSION['IsAdmin'] == 'Boss' || $_SESSION['IsAdmin'] == 'Admin'))
				{
					$extended = $row['Language'];
					if ($extended == "C++") $extend = ".cpp";
					else
					if ($extended == "Pascal") $extend = ".pas";
					echo 
					"<a href = '/source/".$row['Submission_ID'].$extend."' download>".$row['Submission_ID']
					.
					"</a>";
				}
			else
				echo $row['Submission_ID'];
			echo "</td> <td>";
			echo "<a href = 'problems.php?code=".$row['Problems_ID']."'>".$row['Problems_ID']."</a>";
			echo "</td><td>";
			echo "<a href = 'profile.php?username=".$row['User_Name']."'>".$row['User_Name']."</a>";
			echo "</td> <td>";
			echo $row['Language'];
			echo "</td> <td>";
			echo $row['Score'];
			echo "</td> <td>";
			echo $row['Submit_Time'];
			echo "</td></tr>";
		}
	?>

<?php
	$myscorenow = "";
	for ($i = 0; $i < strlen($result); $i++)
		if ($result[$i] == 'S' && $result[$i + 4] == 'e') {
			for ($j = $i + 8; $j < strlen($result); $j++)
				if ($result[$j] >= '0' && $result[$j] <= '9')
					$myscorenow .= $result[$j]; else break; 															
			break;
		}		
	$myscorenow	= (int)$myscorenow;

	$query = "select ".$_REQUEST['pro']." from Highest_score WHERE User = '".$_SESSION['UserName']."'";
	$answer = mysqli_query($con, $query);						
	$myscore = mysqli_fetch_array($answer);
	$myHighestscoreNow = $myscore[$_REQUEST['pro']];
	if ($myHighestscoreNow == null || $myscorenow > (int)$myHighestscoreNow) {
		$query = "update Highest_score set ".$_REQUEST['pro']." = '".$myscorenow."' where User = '".
					$_SESSION['UserName']."'";								
		mysqli_query($con, $query);
	}		
?>

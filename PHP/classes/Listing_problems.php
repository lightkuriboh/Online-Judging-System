<?php
	global $page;
	if (!isset($_REQUEST['page'])) $page = '1';
	else $page = $_REQUEST['page'];
	$page = (int)$page; $page--;
	include('connect_problems.php');
	$query = 'select * from Problems_info LIMIT '.($page * 20).', 20';
	$Pros_info = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($Pros_info)) if ($row['Visible'] == 1)
	{					
		echo "<tr>";		
		echo "<td>";
		echo "<a href ='problems.php?code=".$row['ID']."';> ".$row['ID']." </a>";
		echo "</td>";
		echo "<td>";
		echo $row['Name'];
		echo "</td>";
		echo "<td>";
		echo "<p> ".$row['Type']." </p>";
		echo "</td></tr>";
	}
?>

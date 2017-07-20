<?php 
	if (isset($_REQUEST['page']) && $_REQUEST['page'] > 1) 
		echo "<li> <a href = 'problems.php?page=".($_REQUEST['page'] - 1)."'> Prev </a> </li>"; 
?>
<?php
	$query = 'select * from Problems_info';
	$pros = mysqli_query($con, $query);
	$num_rows = mysqli_num_rows($pros);
	$lim = round($num_rows / 20) + ($num_rows % 20 > 0);
	for ($i = 1; $i <= $lim; $i++)
		echo "<li><a href = 'problems.php?page=".$i."'> ".$i." </a> </li>";
?>
<?php 
	if (isset($_REQUEST['page']) && $_REQUEST['page'] < $lim) 
		echo "<li> <a href = 'problems.php?page=".($_REQUEST['page'] + 1)."'> Next </a> </li>"; 
?>

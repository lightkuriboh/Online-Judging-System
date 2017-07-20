<?php 
	global $more;
	if (isset($_REQUEST['page']) && $_REQUEST['page'] > 1) {		
		if (isset($_REQUEST['User']) && isset($_REQUEST['Pro']))
			$more = "&Pro=".$_REQUEST['Pro']."&User=".$_REQUEST['User'];
		else
			if (isset($_REQUEST['User']))
				$more = "&User=".$_REQUEST['User'];
		else
			if (isset($_REQUEST['Pro']))
				$more = "&Pro=".$_REQUEST['Pro'];
		if (isset($_REQUEST['User']) || isset($_REQUEST['Pro']))
			echo
				"<li> 
					<a href = 'submission.php?page=".($_REQUEST['page'] - 1).$more."'> 
						Prev 
					</a> 
				</li>";
		else
			echo 
				"<li> 
					<a href = 'submission.php?page=".($_REQUEST['page'] - 1)."'> 
						Prev 
					</a> 
				</li>";
	}
?>
<?php
	$query;	
	if (isset($_REQUEST['User']) || isset($_REQUEST['Pro'])) {
		if (isset($_REQUEST['User']) && isset($_REQUEST['Pro'])) {
			$query = "select * from submition where User_Name = '".
						$_REQUEST['User']."' and Problems_ID='".
				$_REQUEST['Pro']."' ";
			$more = "&Pro=".$_REQUEST['Pro']."&User=".$_REQUEST['User'];
		}
		else
			if (isset($_REQUEST['User'])) {
				$query = "select * from submition where User_Name = '".$_REQUEST['User']."' ";
				$more = "&User=".$_REQUEST['User'];
			}
		else 
			if (isset($_REQUEST['Pro'])) {
				$query = "select * from submition where Problems_ID = '".$_REQUEST['Pro']."' ";
				$more = "&Pro=".$_REQUEST['Pro'];
			}
	} 
	else
		$query = 'select * from submition';
	$pros = mysqli_query($con, $query);
	$num_rows = mysqli_num_rows($pros);
	$lim = (int)($num_rows / 20) + ($num_rows % 20 > 0);	
	for ($i = 1; $i <= $lim; $i++)
		echo "<li><a href = 'submission.php?page=".$i.$more."'> ".($i)." </a> </li>";
?>
<?php 
	if ((isset($_REQUEST['page']) && (int)$_REQUEST['page'] < $lim)
		|| (!isset($_REQUEST['page']) && $lim > 1) ) {
		$pages = 1;
		if (isset($_REQUEST['page'])) $page = $_REQUEST['page'];
		if (isset($_REQUEST['User']) && isset($_REQUEST['Pro']))
			$more = "&Pro=".$_REQUEST['Pro']."&User=".$_REQUEST['User'];
		else
			if (isset($_REQUEST['User']))
				$more = "&User=".$_REQUEST['User'];
		else
			if (isset($_REQUEST['Pro']))
				$more = "&Pro=".$_REQUEST['Pro'];		
		if ((int)$pages < $lim) {
			if (isset($_REQUEST['User']) || isset($_REQUEST['Pro']))
				echo
					"<li> 
						<a href = 'submission.php?page=".((int)$pages + 1).$more."'> 
							Next 
						</a> 
					</li>";
			else
				echo 
					"<li> 
						<a href = 'submission.php?page=".((int)$pages + 1)."'> 
							Next 
						</a> 
					</li>"; 
		}
	}
?>

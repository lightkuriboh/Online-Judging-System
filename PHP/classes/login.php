<?php
	function query_in_server()
	{
		$con = mysqli_connect('localhost', 'root', '');
		mysqli_select_db($con, 'Local_user');
		$query = "SELECT * FROM User_infomation WHERE UserName = '".$_REQUEST['username']."'";
		$user_info = mysqli_query($con, $query);
		$md5ps = md5($_REQUEST['password']);		
		while ($row = mysqli_fetch_array($user_info))
			if ($row['Password'] == $md5ps) {
				session_start();
				$_SESSION['UserName'] = $username;
				$_SESSION['IsAdmin'] = $row['Power'];
				$_SESSION['NickName'] = $row['Name'];
				return true;
			}
		return false;
	}
	//----------------------------------------------------------------------------------------------
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	if (query_in_server()) 
	{
		//session_start();
		$_SESSION['UserName'] = $username;
		exit('true');
	}
	else 
	{
		exit('false');
	}
?>


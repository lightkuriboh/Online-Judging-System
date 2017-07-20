<?php
	include ("connect_user.php");
?>
<?php
	function check_letters_in_username() {
		$un = $_REQUEST['username'];
		if (strlen($un) > 30 || strlen($un) < 6) die('username_len_ivalid');
		for ($i = 0; $i < strlen($un); $i++) {
			$id = ord($un[$i]);
			if ((47 < $id && $id < 58) || (64 < $id && $id < 91) || (96 < $id && $id < 123) || $un[$i] == "_") continue;
			else die('ivalid_username');
		}
		return true;
	}
	function check_letters_in_password() {
		$pw = $_REQUEST['password'];
		if (strlen($pw) > 30 || strlen($pw) < 6) die('password_len_ivalid');
		for ($i = 0; $i < strlen($pw); $i++) {
			$id = ord($pw[$i]);
			if ((47 < $id && $id < 58) || (64 < $id && $id < 91) || (96 < $id && $id < 123)) continue; 
			else die('ivalid_password');
		}
		return true;
	}
	function samePassword() {
		if ($_REQUEST['password'] == $_REQUEST['rePassword']) return true;
		die('ivalid_repeat_password');
	}
	function check_all() { return check_letters_in_username() && check_letters_in_password() && samePassword() ; }
	function duplicate_username() {	die('duplicate');}
	function query_in_server() {
		$con = mysqli_connect('localhost', 'root', '');
		mysqli_select_db($con, 'Local_user');
		$query = "SELECT * FROM User_infomation";
		$user_info = mysqli_query($con, $query);
		while ($row = mysqli_fetch_array($user_info))
			if ($row['UserName'] == $_REQUEST['username'])
			{
				duplicate_username();
				return false;
			}
		$qrID = "SELECT max(ID) AS mxx FROM User_infomation";
		$mx = mysqli_query($con, $qrID);
		$mx_row = $mx->fetch_object();
		$md5pass = md5($_REQUEST['password']);
		$qr_insert = "
				INSERT INTO User_infomation
					(UserName, Password, Name, School, ID, Power)
				VALUES 
					('".
						$_REQUEST['username']."', '".$md5pass."', '".
						$_REQUEST['name']."', '".$_REQUEST['school']."', '".($mx_row->mxx + 1)."', '"."Citizen".
					"')";
		$add = mysqli_query($con, $qr_insert);					
	}	
	function add_rows_to_highest_score() {
		$con = mysqli_connect('localhost', 'root', '');
		mysqli_select_db($con, 'Problems_Tasks');
		$query_insert_row = "
				INSERT INTO Highest_score 
					(User) 
				VALUES
					('".
						$_REQUEST['username'].
					"')";
		$cur = mysqli_query($con, $query_insert_row);
	}
	//----------------------------------------------------------------------------------------------------------------------------------
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];	
	check_all();
	query_in_server();
	add_rows_to_highest_score();
	//session_start();
	//$_SESSION['UserName'] = $username;
	//die('true');
?>

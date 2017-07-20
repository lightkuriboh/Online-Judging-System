<?php
	include ("class_directory.php");
?>
<?php			
	function Success() {			
		include('connect_problems.php');
		
		$query_check_dup = "SELECT from Problems_info where ID = '".$_REQUEST['ID']."'";
		$Problems_ID_list = mysqli_query($con, $query_check_dup);
		while ($row = mysqli_fetch_array($Problems_ID_list)) {
			if ($row['ID'] == $_REQUEST['ID'])
				return false;
		}
		
		$path = $main_directory."PHP/Problems/";			
		//move_uploaded_file($_FILES['txt']['tmp_name'], $path.$_FILES['txt']['name']);			
		
		$query = "
				INSERT INTO Problems_info 
					(ID, Name, Type, Location, TimeLimit, MemoryLimit, Tags, Setter, INPUT, OUTPUT, Source, Visible) 
				VALUES 
					('".
						$_REQUEST['PI']."', '".$_REQUEST['PN']."', '".$_REQUEST['PT']."', '".
						$path.$_REQUEST['PI'].".txt".
						"', '".$_REQUEST['TL']."', '".$_REQUEST['ML']."', '".$_REQUEST['T']."', '".$_REQUEST['PS'].
						"', 'input.inp', 'output.out', '".$_REQUEST['S']."', '"."1".
				"')";

		mysqli_query($con, $query);
		
		$query = "ALTER TABLE Highest_score ADD COLUMN ".$_REQUEST['PI']." DOUBLE";
		mysqli_query($con,  $query);
		
		return true;			
	}
	if (Success()) die('Success');
	else die ("Duplicated Problem's ID");
?>


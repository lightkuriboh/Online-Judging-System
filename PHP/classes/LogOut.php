<?php 
	if( isset($_REQUEST['argument']) && $_REQUEST['argument'] == 'logOut') {
		session_destroy();
		exit('true');
	}
?>

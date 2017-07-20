<?php 
		session_start();
		if (session_destroy()) exit('true'); else exit('false');
?>

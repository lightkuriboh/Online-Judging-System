<?php
    include ("connect_user.php");
    $newPass = "123456789";
    $newPass = md5($newPass);    
    $query = "UPDATE User_infomation SET Password = '".
                $newPass."' where UserName = '".$_REQUEST['un']."'";
    if (mysqli_query ($con, $query)) echo "Success"; else echo "Failure";    
?>
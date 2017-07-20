<?php
	include('connect_problems.php');
?>
<?php
    if (isset($_REQUEST['User']) && isset($_REQUEST['Pro']))
        $queryy = "select * from submition where User_Name = '".
                    $_REQUEST['User']."' and Problems_ID='".
            $_REQUEST['Pro']."' ";
    else
        if (isset($_REQUEST['User']))
            $queryy = "select * from submition where User_Name = '".$_REQUEST['User']."' ";
    else
        if (isset($_REQUEST['Pro']))
            $queryy = "select * from submition where Problems_ID = '".$_REQUEST['Pro']."' ";
    if (isset($_REQUEST['User']) || isset($_REQUEST['Pro'])) {								
        $pros = mysqli_query($con, $queryy);
        $num_rows = mysqli_num_rows($pros);
        $lim = (int)($num_rows / 20) + ($num_rows % 20 > 0);
        global $page;
        if (!isset($_REQUEST['page'])) $page = '1';
        else $page = $_REQUEST['page'];
        $page = (int)$page;
        $mod = 20;
        if ($page == $lim) {
            $mod = $num_rows % 20;
            if ($mod == 0) $mod = 20;
        } else $mod = 20;	
        $extend = "";
        if (isset($_REQUEST['User']) && isset($_REQUEST['Pro']))
            $extend = "where User_Name = '".$_REQUEST['User']."'and Problems_ID='".
            $_REQUEST['Pro']."' ";
        else
        if (isset($_REQUEST['User']))
            $extend = "where User_Name = '".$_REQUEST['User']."' ";
        else
        if (isset($_REQUEST['Pro']))
            $extend = "where Problems_ID = '".$_REQUEST['Pro']."' ";
        $query = "select * from submition ".$extend." LIMIT ".
                    (max(0, $num_rows - $page * 20 + 1)).", ".$mod;
        $submit_info = mysqli_query($con, $query);
        $result = array();
        while ($row = mysqli_fetch_array($submit_info)) $result[] = $row;
        $result = array_reverse($result);
        foreach ($result as $row) {
            if (strlen($row['Score']) > 2 && 
                    $row['Score'][0].$row['Score'][1].$row['Score'][2] == "100")
                echo "<tr style = 'color:green;'> <td>";
            else
            if ($row['Score'][0] == "0" || $row['Score'][0] == 'C')
                echo "<tr style = 'color:red;'> <td>";
            else
            if ($row['Score'][0] == 'J')
                echo "<tr style = 'color:#4f0707;'> <td>";
            else
                echo "<tr style = 'color:#e58c39;'> <td>";
            if (isset($_SESSION['UserName']) && ($row['User_Name'] == $_SESSION['UserName'] || 
                    $_SESSION['IsAdmin'] == 'Boss' || $_SESSION['IsAdmin'] == 'Admin'))
                echo "<a href = '/source/".$row['Submission_ID'].
                        ".cpp' download>".$row['Submission_ID']."</a>";
            else
                echo $row['Submission_ID'];
            echo "</td> <td>";
            echo "<a href = 'problems.php?code=".$row['Problems_ID']."'>".$row['Problems_ID']."</a>";
            echo "</td><td>";
            echo "<a href = 'profile.php?username=".$row['User_Name']."'>".$row['User_Name']."</a>";
            echo "</td> <td>";
            echo $row['Language'];
            echo "</td> <td>";
            echo $row['Score'];
            echo "</td> <td>";
            echo $row['Submit_Time'];
            echo "</td></tr>";
        }
    }
?>
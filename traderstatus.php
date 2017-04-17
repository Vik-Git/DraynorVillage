<?php
require('connect.php');
session_start();

if (isset($_SESSION['username'])) {

$username = $_SESSION['username'];
$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $rights = $row["Rights"];
      }

	      if($rights >= 1 && isset($_POST["status"])){
		  $status = $_POST["status"];
		  if(mysql_query("UPDATE global SET Status='$status'")){
		  }
		}

	$query = mysql_query("select Status from global");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $currentstat = $row["Status"];
      }

      if($currentstat =="Online"){
      	 echo '<span class="reached">'.$currentstat.'</span>';
      }else{
      	echo '<span class="notreached">'.$currentstat.'</span>';
      }
}
?>
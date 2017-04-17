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

	     if($rights >= 1){
			$file    = 'requests/'.$_POST['filename'];
			unlink($file);
		}
}
?>
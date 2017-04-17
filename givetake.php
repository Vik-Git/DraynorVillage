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

	      if($rights >= 1 && isset($_POST["mode"]) && isset($_POST["amount"]) && isset($_POST["name"]) && isset($_POST["file"])){
	      	$name = mysql_real_escape_string($_POST["name"]);
	      	$amount = $_POST["amount"];
	      	$mode = $_POST["mode"];
			$query = mysql_query("select * from users where Username='$name'");
		    $rows = mysql_num_rows($query);
		    while($row = mysql_fetch_array($query)){
		        $balance = $row["Tokens"];
		    }
		    if ($mode=="give") {
		    	$newBalance = $balance+$amount;
		    	 $fn = "requests/".$_POST['file'];
				    if(is_writable($fn)){
				      $fp = fopen($fn, 'a');
				      $mesagge = "<div id='messagebubble'><img class='avatar' src='assets/img/avatar/server.png'/><span class='adminmsg'><p class='username'>".$name."</p>
				      <p>".$amount." Tokens have been added to your balance.</p></span></div>\n";
				      fwrite($fp,$mesagge);
				      fclose($fp);
				  }
		    }
		    if($mode=="take"){
		    	$newBalance = $balance-$amount;
		    	 $fn = "requests/".$_POST['file'];
				    if(is_writable($fn)){
				      $fp = fopen($fn, 'a');
				      $mesagge = "<div id='messagebubble'><img class='avatar' src='assets/img/avatar/server.png'/><span class='adminmsg'><p class='username'>".$name."</p>
				      <p>".$amount." Tokens have been taken from your balance.</p></span></div>\n";
				      fwrite($fp,$mesagge);
				      fclose($fp);
				  }
		    }
		    if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$name'")){
		    	echo "balance updated";
         	}else{
         		echo "SQL error";
         	}
         	
		}
}
?>

<?php
require("connect.php");
if(!empty($_POST["username"])) {
	$filtered = mysql_real_escape_string($_POST["username"]);
	$result = mysql_query("SELECT count(*) FROM users WHERE Username='" . $filtered . "'");
	$row = mysql_fetch_row($result);
	$user_count = $row[0];
	if($user_count>0) 
	echo "<span class='status-not-available'> Username Not Available.</span>";
	else echo "<span class='status-available'> Username Available.</span>";
}
?>
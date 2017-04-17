<?php
require('connect.php');
session_start();

if (isset($_SESSION['username']) && isset($_POST["amount"]) &&  isset($_POST["type"]) &&  isset($_POST["game"])){

$username = $_SESSION['username'];

$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $balance = $row["Tokens"];
      }
      if ($_POST["amount"] > $balance && $_POST["type"] =="widthdraw") {
      	echo "not enough tokens";
      }else{
      	$name="requests/".$_SESSION['username'].$_POST["game"].$_POST["type"].$_POST["amount"];
      	$myfile = fopen($name, "w");
		echo '<div id="traderchat">
			  </div>
			    <form id="pmchat" name="pmchat" method="post">
		        <input name="userpm" type="text" id="userpm" size="" />
		        <input name="submitpm" type="submit"  id="submitpm" value="Send" />
    			</form>

		';
      }
}
?>
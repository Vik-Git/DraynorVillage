<?php
require ('connect.php');
session_start();
if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	$query = mysql_query("select * from users where Username='$username'");
    $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $balance = $row["Tokens"];
        $points = $row["Points"];
        $biggestwin = $row["BiggestWin"];
      }

      $balanceformat = number_format($balance, 0, '.', ',');
      $biggestformat = number_format($biggestwin, 0, '.', ',');

      echo '
		  <h1>'.$_SESSION["username"].'</h1>
          <button type="button" class="shopbutton" data-toggle="modal" data-target="#avatarModal">Select Avatar</button> 
	      <p>Balance:'.$balanceformat.' </p>
	      <p>Biggest Win:'.$biggestformat.'</p>
	      <p>Points:'.$points.'</p>
	      <br />
          <button type="button" class="guidebutton">How to get started</button>';
}
?>
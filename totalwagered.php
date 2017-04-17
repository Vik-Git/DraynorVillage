<?php
require('connect.php');

	$query = mysql_query("select TotalWagered from global");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $currentTotal = $row["TotalWagered"];
      }

      $currentTotal = round($currentTotal/1000000);
 	
      $formated =number_format($currentTotal, 0, '.', ',');

 	echo "Total Amount Bet: <span class='totalwager'>$formated</span> Million GP";
?>
<?php
require("connect.php");
session_start();

if (isset($_SESSION['username']) && isset($_POST["type"])) {
	$username = mysql_real_escape_string($_SESSION['username']);
	$type = mysql_real_escape_string($_POST['type']);

			$query = mysql_query("select * from users where Username='$username'");
			$rows = mysql_num_rows($query);
		      while($row = mysql_fetch_array($query)){
		        $points = $row["Points"];
		        $balance = $row["Tokens"];
		    }


 function calcSmall(){
    	$rng = rand(0,100);

    	if ($rng < 20) {
    		return 50000;
    	}

    	if($rng < 50 && $rng >=20){
    		return 75000;
    	}

    	if($rng <= 99 && $rng >=50){
    		return 100000;
    	}
    	if ($rng == 100) {
    		return 500000;
    	}

    }

    function calcMedium(){
    	$rng = rand(0,100);

    	if ($rng < 20) {
    		return 500000;
    	}

    	if($rng < 50 && $rng >=20){
    		return 750000;
    	}

    	if($rng <= 99 && $rng >=50){
    		return 1000000;
    	}
    	if ($rng == 100) {
    		return 10000000;
    	}

    }

    function calcLarge(){
    	$rng = rand(0,100);

    	if ($rng < 20) {
    		return 5000000;
    	}

    	if($rng < 50 && $rng >=20){
    		return 7500000;
    	}

    	if($rng <= 99 && $rng >=50){
    		return 10000000;
    	}
    	if ($rng == 100) {
    		return 100000000;
    	}

    }

    switch ($type) {
    	case 'small':
    		if($points >= 1000){
    			$amount = calcSmall();
    			$newPoints = $points - 1000;
    			$newBalance = $balance + $amount;
    			if(mysql_query("UPDATE users SET Points='$newPoints' WHERE Username='$username'")){
	  			}
	  			if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
	  			}
    			echo "you find ".$amount." GP in the chest";
    		}
    		break;
    	
    	case 'medium':
    		if($points >= 10000){
    			$amount = calcMedium();
    			$newPoints = $points - 10000;
    			$newBalance = $balance + $amount;
    			if(mysql_query("UPDATE users SET Points='$newPoints' WHERE Username='$username'")){
	  			}
	  			if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
	  			}
    			echo "you find ".$amount." GP in the chest";
    		}
    		break;

    	case 'large':
    		if($points >= 100000){
    			$amount = calcLarge();
    			$newPoints = $points - 100000;
    			$newBalance = $balance + $amount;
    			if(mysql_query("UPDATE users SET Points='$newPoints' WHERE Username='$username'")){
	  			}
	  			if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
	  			}
	  			echo "you find ".$amount." GP in the chest";
    		}
    		break;

    	default:
    		# code...
    		break;
    }
   


}



?>
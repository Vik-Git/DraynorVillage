<?php 
session_start();
require_once('connect.php');
if(!empty($_POST["clientseed"]) && !empty($_POST["serverseed"]) && !empty($_POST["wager"]) && !empty($_POST["target"]) && isset($_SESSION['username'])) {
	$username = mysql_real_escape_string($_SESSION['username']);
	$query = mysql_query("select * from users where Username='$username'");
	$rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $serverseed = $row["ServerSeed"];
        $balance = $row["Tokens"];
      }
      if($serverseed !=  $_POST["serverseed"]){
      	echo "Invalid server seed";
      }else if ($balance < $_POST["wager"]) {
      	echo "Not enough tokens in balance.";
      }else if($serverseed ==  $_POST["serverseed"] && $balance >= $_POST["wager"]){
      	$clientseed =mysql_real_escape_string($_POST["clientseed"]);
      	if(mysql_query("UPDATE users SET clientSeed='$clientseed' WHERE Username='$username'")){
	      	if(!empty($_POST["wager"]) && is_numeric($_POST["wager"]) && 0 < $_POST["wager"] && $serverseed ==  $_POST["serverseed"]){
			  calcRoll();
	      	}else{
	      		echo "No valid wager";
	      	}
		}
	}
}else{
	echo "Invalid input.";
}


function calcRoll(){
	$result;
	$username = mysql_real_escape_string($_SESSION['username']);
	date_default_timezone_set("Europe/Brussels");
	$day= date("Y-m-d");

	$query = mysql_query("select * from users where Username='$username'");
	$rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $serverseed = $row["ServerSeed"];
        $clientseed = $row["ClientSeed"];
      }

      $query = mysql_query("select * from secrets where Day='$day'");
	  $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $secretseed = $row["SecretSeed"];
      }

      if($serverseed == $_POST["serverseed"]){
      $generatedsha = hash('sha256',$secretseed.$serverseed.$clientseed);
      $shortsha = substr($generatedsha, 0,8);
      $shortDec = hexdec($shortsha);
      $finalRoll = round(($shortDec/42949672.95),2);
  	  }

  	  if(mysql_query("UPDATE users SET ServerSeed='' WHERE Username='$username'")){
	  }

	  $username = mysql_real_escape_string($_SESSION['username']);
	  $query = mysql_query("select * from users where Username='$username'");
	  $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $balance = $row["Tokens"];
      }
      $query = mysql_query("select TotalWagered from global");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $currentTotal = $row["TotalWagered"];
      }

      $newTotal = mysql_real_escape_string($currentTotal + $_POST["wager"]);
      if(mysql_query("UPDATE global SET TotalWagered='$newTotal'")){
      }
      
      $newBalance = mysql_real_escape_string($balance - $_POST["wager"]);
      if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
      }
      if(targetReached($finalRoll)){

      	echo 'You have rolled: <span class="reached">'.$finalRoll.'</span>';
      	$balance2Add =0;
      	$points2Add = 0;

      	if($_POST["overtarget"] =="true"){
	      	$newMult = 92/(100-$_POST['target']);
	      	$balance2Add = round($_POST["wager"]*$newMult);
	      	$points2Add = round($_POST["wager"]/10000);
	     }
	   	if ($_POST["overtarget"] == "false") {
	    	$newMult = 92/$_POST['target'];
	    	$balance2Add = round($_POST["wager"]*$newMult);
	    	$points2Add = round($_POST["wager"]/10000);
	    }
	    if($newMult > 1000){
	    	$newMult =1000;
	    }		
	    	  $username = mysql_real_escape_string($_SESSION['username']);
			  $query = mysql_query("select * from users where Username='$username'");
			  $rows = mysql_num_rows($query);
		      while($row = mysql_fetch_array($query)){
		        $balance = $row["Tokens"];
		        $points = $row["Points"];
		        $biggestwin = $row["BiggestWin"];
		      }

		if($biggestwin < $balance2Add){
			$newbiggestwin = mysql_real_escape_string($balance2Add);
			if(mysql_query("UPDATE users SET BiggestWin='$newbiggestwin' WHERE Username='$username'")){
         	}
		}

      	 $newBalance = mysql_real_escape_string(($balance +$balance2Add));
         if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
         }

         $newPoints = mysql_real_escape_string(($points +$points2Add));
         if(mysql_query("UPDATE users SET Points='$newPoints' WHERE Username='$username'")){
         }


         if ($balance2Add > 1000000) {
         	$Winshort = round(($balance2Add/1000000),2);
	          if(is_writable("log.html")){
			    $fp = fopen("log.html", 'a');
			    $mesagge = 
			    "<div id='messagebubble'><img class='avatar' src='assets/img/avatar/server.png'/><span class='adminmsg'><p class='username'>".$_SESSION['username']."</p> <p>has won ".$Winshort."M rolling ".$finalRoll."</p></span></div>\n";
			    fwrite($fp,$mesagge);
			    fclose($fp);
			}
		}
      }else{
      	echo 'You have rolled: <span class="notreached">'.$finalRoll.'</span>';
      }
}


function targetReached($roll){

	if(isset($_POST["target"]) && is_numeric($_POST["target"]) && $_POST["target"] < 100){
		$targetReq = $_POST["target"];
		if($_POST["overtarget"] =="true"&& $_POST["target"] >= 10.9){
			if($roll >= $targetReq){
				return true;
			}
		}
		if($_POST["overtarget"] == "false" && $_POST["target"] <= 89.9){
			if($roll < $targetReq){
				return true;
			}
		}
	}
		return false;
}

?>
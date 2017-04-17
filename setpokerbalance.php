<?php
require('connect.php');
include('API.php');
session_start();



if(isset($_SESSION['username']) && isset($_POST['type']) && isset($_POST['amount'])){

 	$username = mysql_real_escape_string($_SESSION['username']);
 	$amount = mysql_real_escape_string($_POST['amount']);

 	$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $tokens = $row["Tokens"];
      }

      $params = array("Command" => "AccountsGet", "Player" => "$username", "Balance");
		$api = Poker_API($params);
		$chips=  $api -> Balance;

	if($_POST['type'] == "withdraw" &&  $chips >= $amount){
		$params = array("Command" => "AccountsDecBalance", "Player" => "$username", "Amount" => "$amount");
		$api = Poker_API($params);


		$newBalance = ($amount*1000)+$tokens;
		if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
        }

		if ($api -> Result == "Ok") echo "Your poker balance is now " . $api -> Balance;
		else echo "Error: " . $api -> Error;
	}else if($_POST['type'] == "withdraw" &&  $chips < $amount){
		echo "Not enough chips in poker balance";
	}

	if($_POST['type'] == "deposit" && $tokens >= ($amount*1000)){
		$newBalance =$tokens -($amount*1000);
		echo $newBalance;
		if(mysql_query("UPDATE users SET Tokens='$newBalance' WHERE Username='$username'")){
        }

         $query = mysql_query("select TotalWagered from global");
	      $rows = mysql_num_rows($query);
	      while($row = mysql_fetch_array($query)){
	        $currentTotal = $row["TotalWagered"];
	      }

	      $newTotal = mysql_real_escape_string($currentTotal + ($amount*1000));
	      if(mysql_query("UPDATE global SET TotalWagered='$newTotal'")){
	      }

		$params = array("Command" => "AccountsIncBalance", "Player" => "$username", "Amount" => "$amount");
		$api = Poker_API($params);

		if ($api -> Result == "Ok") echo "Your poker balance is now " . $api -> Balance;
		else echo "Error: " . $api -> Error;
	}else if($_POST['type'] == "deposit" && $tokens < ($amount*1000)){
		echo "Not enough tokens in balance";
	}

}



?>
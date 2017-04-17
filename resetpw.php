<?php
require_once('connect.php');
include('API.php');

if(!empty($_POST["username"]) && validate()==true){

	$username = mysql_real_escape_string($_POST["username"]);
	$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $mail = $row["Email"];
      }

      $rng = rand(0,100);
      $generatedsha = hash('sha256',$username.$rng);
      $shortsha = substr($generatedsha, 0,8);

      $to      = $mail;
	  $subject = 'Draynor Village Password Reset';
	  $message = 'A password reset was requested your new password is:'.$shortsha;
	  $headers = 'From: noreply@daynorvillage.com' . "\r\n";
	  mail($to, $subject, $message, $headers);

	 	$hash = password_hash($shortsha, PASSWORD_BCRYPT);

	 	
		$params = array("Command" => "AccountsEdit", "Player" => "$username", "PW" => "$shortsha");
		$api = Poker_API($params);

		if(mysql_query("UPDATE users SET Password='$hash' WHERE Username='$username'")){
      	}

	  echo "A new password has been requested.";

}else{
	echo "error";
}



function validate(){
	if(strlen($_POST["username"]) >11 || preg_match("/[^A-Za-z0-9]/ ", $_POST["username"])){
		echo "Invalid username";
		return false;
	}
	return true;
}
?>
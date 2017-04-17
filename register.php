<?php
require('connect.php');
include "API.php";
if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])){


   if(validate() == true){

		$username  = mysql_real_escape_string($_POST["username"]);
		$password =  mysql_real_escape_string($_POST["password"]);
		$email =  mysql_real_escape_string($_POST["email"]);
		$date = date("Y-m-d H:i:s");
		$hash = password_hash($password, PASSWORD_BCRYPT);
		$avatar = "assets/img/avatar/dice.png";

		if(mysql_query("INSERT INTO users(Username,Password,Email,RegisterDate,Avatar) VALUES('$username','$hash','$email','$date','$avatar')")){
			echo "succes";
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			if(isset($_SESSION['username'])){
				$avatarurl = "https://poker.draynorvillage.com:8087/Image?Name=Avatars";
				 $Player = $username;
			     $RealName = " ";
			     $Gender = " ";
			     $Location = "Draynor Village";
			     $Password1 = $password;
			     $Password2 = $password;
			     $Email = $email;
			     $Avatar = "0";
			     $file = "C:/Users/Administrator/Desktop/avatars/32_dice.png";

			     if ($Password1 <> $Password2) die("Password mismatch. Click Back Button to correct.");
			     $params = array("Command"  => "AccountsAdd",
			                      "Player"   => $Player,
			                      "RealName" => $RealName,
			                      "PW"       => $Password1,
			                      "Location" => $Location,
			                      "Email"    => $Email,
			                      "Avatar"   => $Avatar,
			                      "AvatarFile" => $file,
			                      "Gender"   => $Gender,
			                      "Chat"     => "Yes",
			                      "Note"     => "Account created via API");

					$api = Poker_API($params);
			      if ($api -> Result == "Ok") echo "Account successfully created for $Player";
			      else echo "Error: " . $api -> Error . "<br>Click Back Button to correct.";


					header('Location: foyer.php');
			}
		}else{
			echo "Database error";
		}

		echo $hash;
	}

}else{
  echo "something went wrong";
}

function validate(){
	if(strlen($_POST["username"]) >11 || preg_match("/[^A-Za-z0-9_ -]/", $_POST["username"])){
		echo "Plz learn to hack. 1";
		return false;
	}
	if(strlen($_POST["email"]) < 6 || preg_match("/[^A-Za-z0-9\@\.\_\-]/", $_POST["email"])){
		echo "Plz learn to hack. 2";
		return false;
	}
	if($_POST["password"] != strip_tags($_POST["password"]) || strlen($_POST["password"]) < 1 ) {
     echo "*Script kiddie alert.";
     return false;
	}
	if(strlen($_POST["password"]) < 1){
		echo "No just no.";
		return false;
	}
	if(strlen($_POST["password"] )> 500 || strlen($_POST["email"]) > 250){
		echo "Sorry your password or email are to long. Anti Dos measure.";
		return false;
	}
	$tmp = mysql_real_escape_string($_POST["username"]);
	$result = mysql_query("SELECT count(*) FROM users WHERE Username='" . $tmp . "'");
	$row = mysql_fetch_row($result);
	$user_count = $row[0];
	if($user_count>0) {
		echo "Username is already used.";
		return false;
	}


	return true;
}


?>
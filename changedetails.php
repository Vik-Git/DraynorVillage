<?php
require("connect.php");
include('API.php');
session_start();

if (isset($_SESSION['username']) && isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])){
	echo $_SESSION['username'].$_POST['email'].$_POST['pass1'].$_POST['pass2'];
	if (validate() == true) {
		$username = mysql_real_escape_string($_SESSION['username']);
		$email = mysql_real_escape_string($_POST['email']);
		$pass = mysql_real_escape_string($_POST['pass1']);
		$hash = password_hash($pass, PASSWORD_BCRYPT);


		$params = array("Command" => "AccountsEdit", "Player" => "$username", "PW" => "$pass");
		$api = Poker_API($params);

		if(mysql_query("UPDATE users SET Password='$hash' WHERE Username='$username'")){
      	}
      	if(mysql_query("UPDATE users SET Email='$email' WHERE Username='$username'")){
      	}
      	echo "Email & password have been updated.";
	}
}


function validate(){
	if(strlen($_POST["email"]) < 6 || preg_match("/[^A-Za-z0-9\@\.\_\-]/", $_POST["email"])){
		echo "Invalid email";
		return false;
	}
	if($_POST["pass1"] != strip_tags($_POST["pass1"]) || strlen($_POST["pass1"]) < 1 ) {
     echo "Invalid password";
     return false;
	}
	if(strlen($_POST["pass1"]) < 1){
		echo "Password is too short";
		return false;
	}
	if(strlen($_POST["pass1"] )> 500 || strlen($_POST["email"]) > 250){
		echo "Sorry your password or email are to long. Anti Dos measure.";
		return false;
	}
	if($_POST["pass1"] != $_POST["pass2"]){
		echo "Password don't match".$_POST["pass1"].$_POST["pass2"];
		return false;
	}
	return true;
}
?>
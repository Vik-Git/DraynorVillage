<?php
require("connect.php");
include("API.php");
session_start();

if (isset($_SESSION['username']) && isset($_POST["avatar"])){

	$username =$_SESSION['username'];
	$newAvatarURL;

	switch ($_POST["avatar"]) {
		case 'dice':
			$newAvatarURL = "assets/img/avatar/dice.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_dice.png");
			$api = Poker_API($params);
			break;

		case 'gril':
			$newAvatarURL = "assets/img/avatar/gril.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_girl.png");
			$api = Poker_API($params);
		break;

		case '420':
			$newAvatarURL = "assets/img/avatar/420.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_420.png");
			$api = Poker_API($params);
			break;
		case 'wiseold':
			$newAvatarURL = "assets/img/avatar/wiseold.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_wiseold.png");
			$api = Poker_API($params);
			break;
		case 'fish':
			$newAvatarURL = "assets/img/avatar/fish.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_fish.png");
			$api = Poker_API($params);
		break;
		case 'actuallyginger':
			$newAvatarURL = "assets/img/avatar/actuallyginger.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_actuallyginger.png");
			$api = Poker_API($params);
		break;
		case 'greenmask':
			$username = mysql_real_escape_string($_SESSION['username']);
			$query = mysql_query("select * from users where Username='$username'");
			$rows = mysql_num_rows($query);
		      while($row = mysql_fetch_array($query)){
		        $biggestwin = $row["BiggestWin"];
		    }
		    if($biggestwin >= 100000000){
			$newAvatarURL = "assets/img/avatar/greenmask.png";
			$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_greenmask.png");
			$api = Poker_API($params);
			}else{
				$newAvatarURL = "assets/img/avatar/newb.png";
				$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_newb.png");
				$api = Poker_API($params);
			}
		break;
		case 'bluemask':
			$username = mysql_real_escape_string($_SESSION['username']);
			$query = mysql_query("select * from users where Username='$username'");
			$rows = mysql_num_rows($query);
		      while($row = mysql_fetch_array($query)){
		        $biggestwin = $row["BiggestWin"];
		    }
		    if($biggestwin >= 250000000){
				$newAvatarURL = "assets/img/avatar/bluemask.png";
				$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_bluemask.png");
				$api = Poker_API($params);
			}else{
				$newAvatarURL = "assets/img/avatar/newb.png";
				$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_newb.png");
				$api = Poker_API($params);
			}
		break;
		case 'redmask':
			$username = mysql_real_escape_string($_SESSION['username']);
			$query = mysql_query("select * from users where Username='$username'");
			$rows = mysql_num_rows($query);
		      while($row = mysql_fetch_array($query)){
		        $biggestwin = $row["BiggestWin"];
		    }
		    if($biggestwin >= 500000000){
				$newAvatarURL = "assets/img/avatar/redmask.png";
				$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_redmask.png");
				$api = Poker_API($params);
			}else{
				$newAvatarURL = "assets/img/avatar/newb.png";
				$params = array("Command" => "AccountsEdit", "Player" => "$username", "AvatarFile" => "C:/Users/Administrator/Desktop/avatars/32_newb.png");
				$api = Poker_API($params);
			}
		break;
		
		default:
		$newAvatarURL = "assets/img/avatar/dice.png";
			break;
	}
	$newAvatarURL = mysql_real_escape_string($newAvatarURL);
	if(mysql_query("UPDATE users SET Avatar='$newAvatarURL' WHERE Username='$username'")){
    }
    echo "avatar updated";
}

?>
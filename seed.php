<?php
require_once('connect.php');
session_start();
if(!empty($_POST["seedtype"]) && $_POST["seedtype"] =="server" && isset($_SESSION['username'])) {
	$randomseed = requestRandomSeed();
	$randomseed =  mysql_real_escape_string($randomseed);
	$user = $_SESSION['username'];

	if(mysql_query("UPDATE users SET ServerSeed='$randomseed' WHERE Username='$user'")){
		echo $randomseed;
	}
}
if(!empty($_POST["seedtype"]) && $_POST["seedtype"] =="client" && isset($_SESSION['username'])) {
	$randomseed = requestRandomSeed();
	$randomseed =  mysql_real_escape_string($randomseed);
	$user = $_SESSION['username'];

	if(mysql_query("UPDATE users SET ClientSeed='$randomseed' WHERE Username='$user'")){
		echo $randomseed;
	}
}

function requestRandomSeed() {
			$randomstring ="";
	    for ($i=0; $i <20 ; $i++) { 
		$rng = rand(0,36);
		switch ($rng) {
			case '0':
				$randomstring .= (string)$rng;
			break;
			case '1':
				$randomstring .= (string)$rng;
			break;
			case '2':
				$randomstring .= (string)$rng;
			break;
			case '3':
				$randomstring .= (string)$rng;
			break;
			case '4':
				$randomstring .= (string)$rng;
			break;
			case '5':
				$randomstring .= (string)$rng;
			break;
			case '6':
				$randomstring .= (string)$rng;
			break;
			case '7':
				$randomstring .= (string)$rng;
			break;
			case '9':
				$randomstring .= (string)$rng;
			break;
			case '10':
				$randomstring .= "a";
			break;
			case '11':
				$randomstring .= "b";
			break;
			case '12':
				$randomstring .= "c";
			break;
			case '13':
				$randomstring .= "d";
			break;
			case '14':
				$randomstring .= "e";
			break;
			case '15':
				$randomstring .= "f";
			break;
			case '16':
				$randomstring .= "g";
			break;
			case '17':
				$randomstring .= "h";
			break;
			case '18':
				$randomstring .= "i";
			break;
			case '19':
				$randomstring .= "j";
			break;
			case '20':
				$randomstring .= "k";
			break;
			case '21':
				$randomstring .= "l";
			break;
			case '22':
				$randomstring .= "m";
			break;
			case '23':
				$randomstring .= "n";
			break;
			case '24':
				$randomstring .= "o";
			break;
			case '25':
				$randomstring .= "o";
			break;
			case '26':
				$randomstring .= "p";
			break;
			case '27':
				$randomstring .= "q";
			break;
			case '28':
				$randomstring .= "r";
			break;
			case '29':
				$randomstring .= "s";
			break;
			case '30':
				$randomstring .= "t";
			break;
			case '31':
				$randomstring .= "u";
			break;
			case '32':
				$randomstring .= "v";
			break;
			case '33':
				$randomstring .= "w";
			break;
			case '34':
				$randomstring .= "x";
			break;
			case '35':
				$randomstring .= "y";
			break;
			case '36':
				$randomstring .= "z";
			break;	
			default:
				break;
		}
	}

	return $randomstring;
}


?>
<?php
require('connect.php');

if(!empty($_POST["username"]) && !empty($_POST["password"])){

   if(validate() == true){

			$username  = mysql_real_escape_string($_POST["username"]);
			$password =  mysql_real_escape_string($_POST["password"]);
			$query = mysql_query("select * from users where Username='$username'");
			$rows = mysql_num_rows($query);
			while($row = mysql_fetch_array($query)){
				$username = $row["Username"];
				$hash = $row["Password"];
			}
			if(mysql_num_rows($query) != 0){
				if (password_verify($password, $hash)) {
					session_start();
					$_SESSION['username']= $username;
					$_SESSION['password'] = $password;
					echo "test";
					header('Location: foyer.php');
				}else{
					session_start();
					session_destroy();
					header('Location: index.html');
				}
			}else{
				header('Location: index.html');
			}
	}

}else{
 header('Location: index.html');
}


function validate(){
	if(strlen($_POST["username"]) >11 || preg_match("/[^A-Za-z0-9]/ ", $_POST["username"])){
		echo "Plz learn to hack";
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
	if(strlen($_POST["password"] )> 500){
		echo "Sorry your password or email are to long. Anti Dos measure.";
		return false;
	}

	return true;
}


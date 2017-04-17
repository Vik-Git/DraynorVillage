<?php
require("connect.php");
session_start();
if(isset($_SESSION['username']) && isset($_POST["amount"]) &&  isset($_POST["type"]) &&  isset($_POST["game"])){
    $text = $_POST['text'];
    $username = mysql_real_escape_string($_SESSION['username']);
    $query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $avatar =$row["Avatar"];
      }
   	$filtered = xss_clean($text);
    $name = "requests/".$_SESSION['username'].$_POST["game"].$_POST["type"].$_POST["amount"];
    if(is_writable($name)){
	    $fp = fopen($name, 'a');
	    $mesagge = "<div id='messagebubble'><img class='avatar' src=".$avatar."><p class='username'>".$_SESSION['username'] .":</p> <p>". $filtered ."</p></div>\n";
	    fwrite($fp,$mesagge);
	    fclose($fp);
	}
}
if(isset($_SESSION['username']) && isset($_POST["file"])){
    $text = $_POST['text'];
    $username = mysql_real_escape_string($_SESSION['username']);
    $query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $avatar =$row["Avatar"];
      }
    $filtered = xss_clean($text);
    $name = "requests/".$_POST['file'];
    if(is_writable($name)){
      $fp = fopen($name, 'a');
      $mesagge = "<div id='messagebubble'><img class='avatar' src=".$avatar."><p class='username'>".$_SESSION['username'] .":</p> <p>". $filtered ."</p></div>\n";
      fwrite($fp,$mesagge);
      fclose($fp);
  }
}

function xss_clean($data)
{
// Fix &entity\n;
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

do
{
	$old_data = $data;
	$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);

return $data;
}
?>
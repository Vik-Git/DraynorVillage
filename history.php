

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Draynor Village | Runescape Gambling</title>
    <link rel="stylesheet" href="assets/css/reset.css"/>
    <link rel="stylesheet" href="assets/bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>

	<div id ="historybox">
		<img src="assets/img/logo.png">

    <div id="historycont">
    <h1>Released Secrets</h1>
    <?php
    require("connect.php");
    date_default_timezone_set("Europe/Brussels");
    $today = date("Y-m-d 00:00:00");

      $query = mysql_query("select * from secrets ORDER BY Day DESC");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $day = $row["Day"];
        $secret = $row["SecretSeed"];

        if (strtotime($day) < strtotime($today)){
             echo "<p>"."<span class='day'>".$day."</span>"."-".$secret."</p>";
        }
      }
    ?>
    </div>
     
</div>




</body>
</html>
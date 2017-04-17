<?php
require('connect.php');
include('API.php');
session_start();
if (isset($_SESSION['username'])) {

$username = $_SESSION['username'];

$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $balance = $row["Tokens"];
        $points = $row["Points"];
        $biggestwin = $row["BiggestWin"];
        $avatar =$row["Avatar"];
      }
    $server = "https://poker.draynorvillage.com:8087";
    $player = $_SESSION['username'];
    $password = $_SESSION['password'];
    $params = array("Command" => "AccountsPassword", "Player" => $player, "PW" => $password);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Go to the homepage to try again.");
    if ($api -> Verified != "Yes") die("Password is incorrect. Go to the homepage to try again.");
    $params = array("Command" => "AccountsSessionKey", "Player" => $player);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Go to the homepage to try again.");
    $key = $api -> SessionKey;
    $src = $server . "/?LoginName=" . $player . "&amp;SessionKey=" . $key;

echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Draynor Village | Runescape Gambling</title>
    <link rel="stylesheet" href="assets/css/reset.css"/>
    <link rel="stylesheet" href="assets/bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/foyerstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet" type="text/css">
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <link rel="icon" type="image/png" href="assets/img/favicon.png">
      <style type="text/css">
  iframe { position:absolute; width: 100%; height: 100%; padding-top:80px; border: none;}
</style>
</head>
<body>

<script>
  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

  ga("create", "UA-77946865-1", "auto");
  ga("send", "pageview");

</script>

';


echo"<div id='top'><iframe class='pokerframe' src='$src'></iframe></div>";
echo'
<div class="box">
<header class="row header">
  <img class="logoimg" src="assets/img/minlogo.png"/>
  <button class="cashierbtn" type="button" data-toggle="modal" data-target="#cashierModal">Cashier</button>
  <label class="totalwagered">Total Amount Bet: </label>';
  echo '<div id="usermenu">'.'<img class="avatar" src='.$avatar.'>'.'<p class="username">'.$_SESSION["username"].'</p>'.'

    <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Menu
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><a href="#" data-toggle="modal" data-target="#FAQModal">FAQ</a></li>
        <li><a href="history.php" target="_blank">History</a></li>
        <li><a href="#" data-toggle="modal" data-target="#becometraderModal">Become a trader</a></li>
        <li><a href="#" data-toggle="modal" data-target="#changedetailsModal">Change pass & email</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </div>
  </div>';
  echo'

</header>';



  echo'<div id="gamepanel">
   <ul>
   <img src="assets/img/diceico.png"/>
   <li class="dice">Solo Dice</li>
   <img src="assets/img/pokerico.png"/>
   <li class="poker">Poker</li>
   </ul>
   <form class="diceform">
     <label>Wager Amount</label>
     <input type="number" class="wagerbox" name="wageramount">
     <button type="button" class="times2">x2</button>
     <label class="targetlabel">Target</label>
     <input type="number" class="target" name="target" value="54">
     <label class="multlabel">Multiplier</label>
     <input type="number" class="mult" name="target" value="2.00">
      <button type="button" class="overunder">OVER</button>
    

      <label>Server Seed</label>
    <input type="text" class="serverseed" name="serverseed" value="" disabled>
    <button type="button" class="newSseed">New</button>
    <label>Client Seed</label>
    <input type="text"class="clientseed" name="clientseed" value="DraynorVillage.com">
    <button type="button" class="newCseed">New</button>
    <button class="roll" type="button"><img src="assets/img/diceico.png"/>&nbsp&nbsp&nbsp&nbspROLL THE DICE</button>
    <p class="rollresult">Result</p>
   </form>

   <form class="pokerform">
   <label>1k chips = 1m tokens</label>
   <label>Enter chip amount:</label>
   <input type="number" class="pokeramount" name="pokeramount">
   <button type="button" class="pokerdeposit">Deposit</button>
   <button type="button" class="pokerwithdraw">Withdraw</button>
   </form>

  </div>
  <aside class="row content">
  <div id="paneltrigger">
  </div>
    <nav>
    <ul>
    <li><a class="chat" href="#"> </a></li>
    <li><a class="profile" href="#"> </a></li>
    <li><a class="free" href="#"> </a></li>
    </ul>
    </nav>
    <div id="chatcontainer">
      <div id="chat">';
          if(file_exists("log.html") && filesize("log.html") > 0){
              $handle = fopen("log.html", "r");
              $contents = fread($handle, filesize("log.html"));
              fclose($handle);
              echo $contents;
          }
       echo'
      </div>
  <form name="message" method="post" action="">
        <input name="usermsg" type="text" id="usermsg" maxlength="100" size="" />
        <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
    </form>

    </div>

    <div id="profilecontainer">

    </div>

    <div id="shopcontainer">
    <h1>Point Shop</h1>
    <label>Loot Chests</label>
    <ul class="shoplist">
    <li><img src="assets/img/casketico.png"/>&nbspScarce loot chest - <span class="totalwager">1000</span> Points <button class="smallchest" type="button">Buy</button></li>
    <li><img src="assets/img/casketico.png"/>&nbspMedium loot chest - <span class="totalwager">10,000</span> Points <button class="mediumchest" type="button">Buy</button></li>
    <li><img src="assets/img/casketico.png"/>&nbspBig loot chest - <span class="totalwager">100,000</span> Points <button class="largechest" type="button">Buy</button></li>
    </ul>

    <h1>Biggest Win Achievements</h1>
    <label>Avatars</label>
    <ul class="achievlist">
    <li><img src="assets/img/maskico.png"/>&nbspGreen Mask - <span class="totalwager">100M</span> GP <button type="button" class="greenmask">Set</button></li>
    <li><img src="assets/img/maskico3.png"/>&nbspBlue Mask - <span class="totalwager">250M</span> GP <button type="button" class="bluemask">Set</button></li>
    <li><img src="assets/img/maskico2.png"/>&nbspRed Mask - <span class="totalwager">500M</span> GP <button type="button" class="redmask">Set</button></li>
    </ul>
    </div>

  </aside>
        <!-- AvatarModal -->
        <div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Select Avatar</h4>
              </div>
              <div class="modal-body">
                 <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td id="dice"><img class="avatar" src="assets/img/avatar/dice.png"/></td></a>
                      <td id="wiseold"><img class="avatar" src="assets/img/avatar/wiseold.png"/></td>
                    </tr>
                    <tr>
                      <td id="fish"><img class="avatar" src="assets/img/avatar/fish.png"/></td>
                      <td id="gril"><img class="avatar" src="assets/img/avatar/gril.png"/></td>
                    </tr>
                    <tr>
                      <td id="420"><img class="avatar" src="assets/img/avatar/420.png"/></td>
                      <td id="actuallyginger"><img class="avatar" src="assets/img/avatar/actuallyginger.png"/></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!-- cashier -->
        <div class="modal fade" id="cashierModal" tabindex="-1" role="dialog" aria-labelledby="cashierModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cashier</h4>
              </div>
              <div class="modal-body" id="requestchat">
                <form class="cashier">
                  <p class="tstatus">Trader</p>
                  <button class="deposit" type="button">Deposit</button>
                  <button class="widthdraw" type="button">Withdraw</button>
                  <br />
                  <button class="rs3" type="button">Runescape 3</button>
                  <button class="os" type="button">Oldschool runescape</button>
                  <br />
                  <label>Amount:</label>
                  <input class="gold" type="text"required/>
                  <label>Tokens:</label>
                  <input  class="tokens" type="text"required disabled/>
                  <br />
                  <input name="submitcashier" type="submit"  id="submitcashier" value="Start Chat" />
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


         <!-- FAQ -->
        <div class="modal fade" id="FAQModal" tabindex="-1" role="dialog" aria-labelledby="FAQModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Frequently Asked Questions</h4>
              </div>
              <div class="modal-body">
                 <h4>Can I trust this website?</h4>
                 <p>Yes you can. Our dice system is based on provably fair system. This means
                 that we can prove that every roll on this website is random and impossible to be tempered with.
                 For more details check out the question below: <b>How can I verify my roll?</b>
                 </p>

                 <h4>Why should I use Draynor Village instead of...?</h4>
                 <p>Draynor Village will encrypt all your data and makes sure there is a secure connection.
                 This means that you can sign in from public networks like universities without people having acces to your credentials.
                 Alot of websites do not force this encryption.</p>

                 <h4>How do I withdraw/deposit funds?</h4>
                 <p>Click on the <b>Cashier</b> button in the header of the page, select the option, fill in the amount and request a 
                 chat with a trader.</p>

                 <h4>How can I verify my roll?</h4>
                 <p>Before you roll copy paste the server seed & client seed in a text document. When our secret is released
                 on the history page(can be found in the top left menu) take the seed in sha256 format and place it in front of the
                 server & client seed so you have the following format: secretseedserverseedclientseed.<br/>
                 Next convert this long line of text with a sha256 converter into one sha256 line of text.<br/>
                 Take the first 8 digits of this line and covert it from Hex to Decimal.<br/>
                 Divide this number by <b>42949672.95</b> and the result will be your roll.
                 </p>

                 <h4>Can I store my tokens on Draynor Village forever?</h4>
                 <p>Yes you can.</p>

                 <h4>Who owns this website?</h4>
                 <p>DraynorVillage.com is owned by two belgians: Belgam and Anxiety.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>



         <!-- Become Trader -->
        <div class="modal fade" id="becometraderModal" tabindex="-1" role="dialog" aria-labelledby="becometraderModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Become a trader!</h4>
              </div>
              <div class="modal-body">
                 <h4>Requirements</h4>
                 <p>We require a one time 1B RS3 GP RSGP or 200M 07 GP payment for your status.</p>
                 <h4>The Perks</h4>
                 <ul>
                 <li>10M GP per hour.</li>
                 <li>Weekly Bonuses.(Dependig on trade volume)</li>
                 <li>Free bonds.</li>
                 </ul>
                 <br />
                 <p>Contact Anxiety or Belgam in the chat.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>


        <!-- changepassmail -->
        <div class="modal fade" id="changedetailsModal" tabindex="-1" role="dialog" aria-labelledby="changedetailsModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change password & email</h4>
              </div>
              <div class="modal-body">
                <form class="changedetails">
                  <label>New email</label>
                  <input class="mail" type="email"required/>
                  <label>New password</label>
                  <input  class="pass1" type="password"required/>
                  <label>Confirm new password</label>
                  <input  class="pass2" type="password"required/>
                  <br />
                  <input name="submitdetails" type="submit"  id="submitdetails" value="Save Credentials" />
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>



</div>

</body>
</html>';
}else{
  header('Location: index.html');
}
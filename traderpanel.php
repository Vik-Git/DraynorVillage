<?php
require('connect.php');
session_start();

if (isset($_SESSION['username'])) {

$username = $_SESSION['username'];

$query = mysql_query("select * from users where Username='$username'");
      $rows = mysql_num_rows($query);
      while($row = mysql_fetch_array($query)){
        $rights = $row["Rights"];
      }

      if($rights >= 1){
      	echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DV Trader Panel</title>
    <link rel="stylesheet" href="assets/css/reset.css"/>
    <link rel="stylesheet" href="assets/bootstrap-3.3.6-dist/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>

<div id="tradercont">
<h1>Trader Panel</h1>
<button class="seton">Set Online</button>
<button class="setoff">Set offline</button>
<div id="requestlist">
<script>

$(".seton").click(function(event) {
          jQuery.ajax({
          url: "traderstatus.php",
          data:{status:"Online"},
          type: "POST",
          success:function(data){
             alert(data);
          },
          error:function (){
          }
        });
      });

$(".setoff").click(function(event) {
          jQuery.ajax({
          url: "traderstatus.php",
          data:{status:"Offline"},
          type: "POST",
          success:function(data){
             alert(data);
          },
          error:function (){
          }
        });
      });

var loadinterval = setInterval (loadrequests, 600);
var olddata="";
function loadrequests(){
  jQuery.ajax({
      url: "updatepms.php",
      data:{},
      type: "POST",
      success:function(data){
          if(olddata != data){
            alert("requests updated");
            olddata = data;
        }
      },
      error:function (){
      }
    });
}
</script>';
$dir    = 'requests/';
    $files = scandir($dir);
    $i = 0;
    foreach ($files as &$file) {
      $i++;
        if($i > 2){
          echo '<p>'.$file.'<button type="button" class="deletechat">Delete Chat</button><button class="openchat" type="button" data-toggle="modal" data-target="#tradechatModal">Open Chat </button></p>';
        }
    }
echo'</div>
</div>

 <!-- tradechat -->
        <div class="modal fade" id="tradechatModal" tabindex="-1" role="dialog" aria-labelledby="tradechatModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Trade Chat</h4>
              </div>
              <div class="modal-body" id="requestchat">
               <div id="traderchat2">
                </div>
                  <form id="pmchat2" name="pmchat" method="post">
                    <input name="userpm" type="text" id="userpm2" size="" />
                    <input name="submitpm" type="submit"  id="submitpm2" value="Send" />
                  </form>
              </div>
              <div class="modal-footer">
              <input name="updatename" type="text" id="updateuser" size="" />
               <input name="update" type="number" id="updateamount" size="" />
               <input name="submitgive" type="button"  id="submitgive" value="give" />
               <input name="submittake" type="button"  id="submittake" value="take" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <script>
                var name;
                var amount;
                var mode;
                var file;
                  $("#submitgive").click(function(event) {
                      mode="give";
                      amount = $("#updateamount").val();
                      name = $("#updateuser").val();
                      file ="'.$file.'";
                      requestGiveTake();
                  });

                  $("#submittake").click(function(event) {
                     mode="take";
                     amount = $("#updateamount").val();
                     name = $("#updateuser").val();
                     file ="'.$file.'";
                     requestGiveTake();
                  });

                  function requestGiveTake(){
                        jQuery.ajax({
                          url: "givetake.php",
                          data:{mode:mode,amount:amount,name:name,file:file},
                          type: "POST",
                          success:function(data){
                            alert(data);
                          },
                          error:function (){
                            alert("fail");
                          }
                        });
                  }

                </script>
              </div>
            </div>
          </div>
        </div>


</body>
</html>';
      }else{
      	echo "you're not a trader";
      }
}
?>
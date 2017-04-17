String.prototype.contains = function(it) { return this.indexOf(it) != -1; };

$( document ).ready(function() {
    inputCheck();
    setInterval (loadLog, 1000);
    $( "#gamepanel" ).draggable({ containment: "parent" });

    $.get('totalwagered.php', function(data) { $(".totalwagered").html(data);});

      
});

var scrollClicked = false;
var over = true;
function inputCheck(){
	$(".pokerdeposit").click(function(event) {
		var amount = $(".pokeramount").val();
		jQuery.ajax({
				url: "setpokerbalance.php",
				data:{type:"deposit",amount:amount},
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
	});


var aside= false;
$("#paneltrigger").click(function(event) {
	if(aside == false){
	$("aside").css({
		visibility:"hidden"
	});

	$("#paneltrigger").css({
		visibility:"visible",
		"margin-left":"370px",
		"background-image":'url("assets/img/plus.png")'
	});
	}

	if(aside == true){
	$("aside").css({
		visibility:"visible"
	});

	$("#paneltrigger").css({
		"margin-left":"-50px",
		"background-image":'url("assets/img/min.png")'
	});


	}
	
	aside = !aside;
});

$(".pokerwithdraw").click(function(event) {
		var amount = $(".pokeramount").val();
		jQuery.ajax({
				url: "setpokerbalance.php",
				data:{type:"withdraw",amount:amount},
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
	});


	$("#forgotbutton").click(function(event) {
		jQuery.ajax({
				url: "resetpw.php",
				data:'username='+$(".recoveruser").val(),
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
	});

	$('.poker').click(function(event) {
		$("iframe").css({
			visibility: 'visible',
		});

		$(".diceform").css({
			visibility: 'hidden',
		});


		$(".pokerform").css({
			visibility: 'visible',
		});

		$("#gamepanel").css({
			width: '400px',
			height:'200px'
		});

	});

	$('.dice').click(function(event) {
		$("iframe").css({
			visibility: 'hidden',
		});

		$(".pokerform").css({
			visibility: 'hidden',
		});

		$(".diceform").css({
			visibility: 'visible',
		});

		$("#gamepanel").css({
			width: '400px',
			height:'530px'
		});
	});


	$("#gamepanel").children('ul').children('li').hover(function() {
		$(this).css({
			cursor: 'pointer'
		});
	}, function() {
		/* Stuff to do when the mouse leaves the element */
	});

	$(".signup").children(("[name='set']")).click(function(event) {
		fillUsername();
		checkAvailability();
	});
    $("#registerform").children(("[name='username']")).blur(function(event) {
    	checkAvailability();
    });

	 $("#registerbutton").click(function(event) {
		 if(registerValidation() == true){
		 	$("#registerform").submit();
		 }
	 });
	 $("#loginbutton").click(function(event) {
		 	$("#loginform").submit();
	 });

	 $("#submitmsg").click(function(event){	
	 	event.preventDefault();
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});
		$("#usermsg").val("");	
	});
	 $("#submitpm").click(function(event) {
	 	return false;
	 });

	 $(".profile").click(function(event) {
	 	$("#chatcontainer").slideUp();
	 	$("#shopcontainer").slideUp();
	 	$("#profilecontainer").slideDown();
	 	$("#profilecontainer").css("display", "block");
	 	$.ajax({
			url: "balanceref.php",
			cache: false,
			success: function(html){		
				$("#profilecontainer").html(html);				
		  	},
		});
	 });

	 $(".chat").click(function(event) {
	 	$("#profilecontainer").slideUp();
	 	$("#shopcontainer").slideUp();
	 	$("#chatcontainer").slideDown();
	 });
	 $(".free").click(function(event) {
	 	$("#profilecontainer").slideUp();
	 	$("#chatcontainer").slideUp();
	 	$("#shopcontainer").slideDown();
	 });

	 $(".newSseed").click(function(event) {
	 	 requestSeed("server");
	 });
	 $(".newCseed").click(function(event) {
	 	 requestSeed("client");
	 });
	 $(".roll").click(function(event) {
	 	 requestRoll();
	 });
	  $(".overunder").click(function(event) {
	  		if(over){
	  			if($(".target").val() > 89.1){
					$(".target").val(89.1);
				}
	  			$(".overunder").text("UNDER");
	  			var newMult =92/$(".target").val();
				$(".mult").val(newMult.toFixed(2));
	  		}else{
	  			if($(".target").val() < 10.9){
					$(".target").val(10.9);
				}
	  			$(".overunder").text("OVER");
	  			var newMult =92/(100-$(".target").val());
				$(".mult").val(newMult.toFixed(2));
	  		}
	 	 over =!over;
	 });
	  $(".times2").click(function(event) {
	  		$('.wagerbox').val($('.wagerbox').val()*2);
	  });
		$(".mult").change(function(event) {
			if ($(".mult").val()>1000) {
				$(".mult").val(1000);
			}
			if(over){
				var newTarget = 100-(92/$(".mult").val());
				$(".target").val(newTarget.toFixed(2));
			}else{
				var newTarget = 92/$(".mult").val();
				$(".target").val(newTarget.toFixed(2));
			}

		});
		$(".target").change(function(event) {
			if(over){
				if($(".target").val() < 10.9){
					$(".target").val(10.9);
				}
				var newMult =92/(100-$(".target").val());

				if(newMult > 1000){
					newMult = 1000;
				}
				$(".mult").val(Math.floor(newMult* 100)/100);
			}else{
				if($(".target").val() > 89.1){
					$(".target").val(89.1);
				}
				var newMult =92/$(".target").val();
				if(newMult > 1000){
					newMult = 1000;
				}
				$(".mult").val(Math.floor(newMult* 100)/100);
			}
		});


		$('td').mouseenter(function(){
		  $( this ).css( "background-color", "#0069b4" );
		});
		$('td').mouseleave(function(){
			if (this != select) {
				$( this ).css( "background-color", "white" );
			}
		});

		$("td").click(function(event) {
			select =this;
			$( "td" ).each(function() {
			$( this ).css( "background-color", "white" );
			});
        	$( this ).css( "background-color", "#0069b4" );
	        	jQuery.ajax({
				url: "updateavatar.php",
				data:'avatar='+select.id,
				type: "POST",
				success:function(data){
				},
				error:function (){}
				});
				var arl = select.id;
	        $("#usermenu").children('.avatar').attr("src", "assets/img/avatar/"+arl+".png");

    	});

    	$(".greenmask").click(function(event) {
    		      	jQuery.ajax({
				url: "updateavatar.php",
				data:'avatar='+"greenmask",
				type: "POST",
				success:function(data){
				},
				error:function (){}
				});
	        $("#usermenu").children('.avatar').attr("src", "assets/img/avatar/"+"greenmask"+".png");
    	});

    	$(".bluemask").click(function(event) {
    		      	jQuery.ajax({
				url: "updateavatar.php",
				data:'avatar='+"bluemask",
				type: "POST",
				success:function(data){
				},
				error:function (){}
				});
	        $("#usermenu").children('.avatar').attr("src", "assets/img/avatar/"+"bluemask"+".png");
    	});

    	$(".redmask").click(function(event) {
    		      	jQuery.ajax({
				url: "updateavatar.php",
				data:'avatar='+"redmask",
				type: "POST",
				success:function(data){
				},
				error:function (){}
				});
	        $("#usermenu").children('.avatar').attr("src", "assets/img/avatar/"+"redmask"+".png");
    	});


    	$(".smallchest").click(function(event) {
    		jQuery.ajax({
				url: "purchase.php",
				data:'type='+"small",
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
    	});
    	$(".mediumchest").click(function(event) {
    		jQuery.ajax({
				url: "purchase.php",
				data:'type='+"medium",
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
    	});
    	$(".largechest").click(function(event) {
    		jQuery.ajax({
				url: "purchase.php",
				data:'type='+"large",
				type: "POST",
				success:function(data){
					alert(data);
				},
				error:function (){}
				});
    	});


    	$(".deposit").ready(function() {
    		$(".deposit").css( "background-color", "#004779" );
    		cashierselect="deposit";
    	});

    	$(".widthdraw").click(function(event) {
    		$(".widthdraw").css( "background-color", "#004779" );
    		$(".deposit").css( "background-color", "#0069b4" );
    		cashierselect="widthdraw";
    	});

    	$(".deposit").click(function(event) {
    		$(".deposit").css( "background-color", "#004779" );
    		$(".widthdraw").css( "background-color", "#0069b4" );
    		cashierselect="deposit";
    	});

    	$(".deposit").mouseenter(function(event) {
    		$(".deposit").css( "background-color", "#004779" );
    	});

    	$(".widthdraw").mouseenter(function(event) {
    		$(".widthdraw").css( "background-color", "#004779" );
    	});

    	$(".deposit").mouseleave(function(event) {
    		if(cashierselect != "deposit"){
    			$(".deposit").css( "background-color", "#0069b4" );
    		}
    	});

    	$(".widthdraw").mouseleave(function(event) {
    		if(cashierselect != "widthdraw"){
    			$(".widthdraw").css( "background-color", "#0069b4" );
    		}
    	});

    	$(".rs3").ready(function() {
    		$(".rs3").css( "background-color", "#004779" );
    		gameselect="rs3";
    	});

    	$(".os").click(function(event) {
    		$(".os").css( "background-color", "#004779" );
    		$(".rs3").css( "background-color", "#0069b4" );
    		gameselect="os";
    		var gold = $(".gold").val();
			var mult = 1;
    		if(gold.contains('k')){
    			mult = 1000;
    			gold = gold.replace('k','');
    		}

    		if(gold.contains('m')){
    			mult = 1000000;
    			gold = gold.replace('m','');
    		}
    		if(gameselect =="os"){
    			gold = gold * 5;
    		}
    			$(".tokens").val(gold*mult);
    			amount= (gold*mult);
    	});

    	$(".rs3").click(function(event) {
    		$(".rs3").css( "background-color", "#004779" );
    		$(".os").css( "background-color", "#0069b4" );
    		gameselect="rs3";
    		var gold = $(".gold").val();
			var mult = 1;
    		if(gold.contains('k')){
    			mult = 1000;
    			gold = gold.replace('k','');
    		}

    		if(gold.contains('m')){
    			mult = 1000000;
    			gold = gold.replace('m','');
    		}
    		if(gameselect =="os"){
    			gold = gold * 5;
    		}
    			$(".tokens").val(gold*mult);
    			amount= (gold*mult);
    	});

    	$(".rs3").mouseenter(function(event) {
    		$(".rs3").css( "background-color", "#004779" );
    	});

    	$(".os").mouseenter(function(event) {
    		$(".os").css( "background-color", "#004779" );
    	});

    	$(".rs3").mouseleave(function(event) {
    		if(gameselect != "rs3"){
    			$(".rs3").css( "background-color", "#0069b4" );
    		}
    	});

    	$(".os").mouseleave(function(event) {
    		if(gameselect != "os"){
    			$(".os").css( "background-color","#0069b4");
    		}
    	});

    	$(".gold").keyup(function(event) {
    		var gold = $(".gold").val();
			var mult = 1;
    		if(gold.contains('k')){
    			mult = 1000;
    			gold = gold.replace('k','');
    		}

    		if(gold.contains('m')){
    			mult = 1000000;
    			gold = gold.replace('m','');
    		}
    		if(gameselect =="os"){
    			gold = gold * 5;
    		}
    			$(".tokens").val(gold*mult);
    			amount= (gold*mult);
    	});

    	$(".openchat").click(function(event) {
    		pmfile = $(this).parent().text();
    		pmfile =pmfile.replace('Delete ChatOpen Chat ','');
    		alert(pmfile);
    		pmInterval = setInterval (loadpmLog, 600);
    		
    	});

    	$(".deletechat").click(function(event) {
    		DeleteFile = $(this).parent().text();
    		DeleteFile =DeleteFile.replace('Delete ChatOpen Chat ','');
    		deletePM();
    	});

    	$(".cashier").submit(function(event) {
    		    		getchat();
    		return false;
    	});

    	$(".changedetails").submit(function(event) {
    		event.preventDefault;
    		requestchange();
    		return false;
    	});

    	
    	$(".cashierbtn").click(function(event) {
    		$.get('traderstatus.php', function(data) {
			  $(".cashier").children('p').html('Trader ' + data);
			});	
    	});
}

var pmInterval;
var DeleteFile;
var pmfile;
var select;
var cashierselect;
var gameselect;
var amount;




function deletePM(){
	jQuery.ajax({
			url: "deleterequest.php",
			data:{filename:DeleteFile},
			type: "POST",
			success:function(data){
			  alert("request deleted: " + DeleteFile);
			},
			error:function (){
				alert('fail');
			}
		});
}

function loadpmLog(){
	 $.ajax({
			url: "requests/"+pmfile,
			cache: false,
			success: function(html){		
				$("#traderchat2").html(html);
						    
				if(loaded == false){
			    $("#pmchat2").submit(function(event){

				 	event.preventDefault();	
				 	var clientmsg = $("#userpm2").val();
					$.post("posttrader.php", {text: clientmsg,file:pmfile});
					$("#userpm2").val("");
					return false;
				});
				loaded = true;
				}
		  	},
		  	error:function (){

		  		clearInterval(pmInterval);
			 
			}
		});
	 $("#traderchat2").animate({ scrollTop: $('#traderchat2').prop("scrollHeight")}, 600);
}



function requestchange(){
	jQuery.ajax({
			url: "changedetails.php",
			data:{email:jQuery('.mail').val(),pass1:jQuery('.pass1').val(),pass2:jQuery('.pass2').val()},
			type: "POST",
			success:function(data){
			    alert(data);
			},
			error:function (){
				alert('fail');
			}
		});
}


function getchat(){
	jQuery.ajax({
			url: "createchat.php",
			data:{amount:jQuery('.tokens').val(),type:cashierselect,game:gameselect},
			type: "POST",
			success:function(data){
			    showChat(data);
			},
			error:function (){
				alert('fail');
			}
		});
}

var tradeloginterval;
function showChat(data){
	$('#requestchat').html(data);
	tradeloginterval = setInterval (loadTradeLog, 600);
}

var loaded = false;

var oldtradelog;

function loadTradeLog(){
	var username = $(".username").html();
		$.ajax({
			url: "requests/"+username+gameselect+cashierselect+amount,
			cache: false,
			success: function(html){

				if(oldtradelog != html){
					$("#traderchat").animate({ scrollTop: $('#traderchat').prop("scrollHeight")}, 600);
				}
				oldtradelog = html;

				$("#traderchat").html(html);
				if(loaded == false){
			    $("#pmchat").submit(function(event){
				 	event.preventDefault();	
				 	var clientmsg = $("#userpm").val();
					$.post("posttrader.php", {text: clientmsg,type:cashierselect,game:gameselect,amount:amount});
					$("#userpm").val("");
					return false;
				});
				loaded = true;
				}

		  	},
		  	error:function (){
		  	 clearInterval(tradeloginterval);
			 alert('The chat with the trader has ended. refresh the page to make a new request.');
			}
		});
}


function requestRoll(){
	jQuery.ajax({
			url: "rngdice.php",
			data:{clientseed:jQuery('.clientseed').val(), serverseed:jQuery('.serverseed').val(),
			wager:jQuery('.wagerbox').val(),overtarget:over,target:$(".target").val()},
			type: "POST",
			success:function(data){
			    $(".rollresult").html(data);
				requestSeed("server");
				requestSeed("client");
			},
			error:function (){
			}
		});
}

function requestSeed(type){
	if(type =="server"){
		jQuery.ajax({
			url: "seed.php",
			data:'seedtype=server',
			type: "POST",
			success:function(data){
				$(".serverseed").val(data);
				
			},
			error:function (){}
		});
	}
	if(type =="client"){
		jQuery.ajax({
			url: "seed.php",
			data:'seedtype=client',
			type: "POST",
			success:function(data){
				$(".clientseed").val(data);
				
			},
			error:function (){}
		});
	}

}


var oldchat;

function loadLog(){
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){
				if(oldchat != html){
                  $("#chat").animate({ scrollTop: $('#chat').prop("scrollHeight")}, 900);
				}
				$("#chat").html(html);
				oldchat = html;	
		  	},
		});
   }
var registername;
function fillUsername(){
	registername =$(".signup").children(("[name='username']")).val();
	$("#registerform").children(("[name='username']")).val(registername);
}

var usernamestring;

function checkAvailability() {
var stringTest;
usernamestring=$("#registerform").children(("[name='username']")).val();
registername =$(".signup").children(("[name='username']")).val();

if(usernamestring != ''){
	stringTest = usernamestring;

}else{
	stringTest = registername;
}

jQuery.ajax({
url: "usernamechecker.php",
data:'username='+stringTest,
type: "POST",
success:function(data){
	$("#registerform").children(".namecheck").html(data);
	
},
error:function (){}
});
}


function registerValidation(){
	usernamestring=$("#registerform").children(("[name='username']")).val();
    var emailstring=$("#registerform").children(("[name='email']")).val();
    var passString=$("#registerform").children(("[name='password']")).val();
    var passVerifyString=$("#registerform").children(("[name='passwordverify']")).val();
	var length = usernamestring.length;

		if (!/[a-zA-Z]/.test(usernamestring)) {
	  		alert('Invalid characters in username');
	  		return false;
	    }
		if(length > 11){
			alert("Username is to long.");
			return false;
		}
		if(length == 0){
			alert("Did you forget filling in a username?");
			return false;
		}
		if(/^[a-zA-Z0-9- ]*$/.test(usernamestring) == false) {
			alert("Username has illegal characters.");
			return false;
		}

		if(emailstring.length == 0){
			alert("Did you forget filling in your email?");
			return false;
		}

		if(/^[a-zA-Z0-9-@._-]*$/.test(emailstring) == false) {
			alert("Email has illegal characters.");
			return false;
		}

		if (!emailstring.contains('@') || !emailstring.contains('.') || emailstring.contains(' ') || emailstring.length < 6)
		{
			alert("Silly you that's not an email.");
			return false;
		}
		if(passString.length == 0){
			alert("Did you forget filling a password?");
			return false;

		}
		if(passVerifyString != passString){
			alert("Passwords don't match.");
			return false;
		}
		return true;
}
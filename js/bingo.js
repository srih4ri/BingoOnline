
 $(document).ready(function(){

			getplayerinfo();
			drawboard();
			drawcolors();
			
			var refreshturn = setInterval("checkturn()", 4000);
			
			var refreshboard = setInterval("drawcolors()", 4000);
			
			
			
			
			});
function drawboard(){	
$.ajax({
			
			type: "GET",
			url: "bingo.php?a=2",
			beforeSend: function(){
			$("#message_box").append("Loading Board");
			},
			success: function(msg)
			{

				if(msg == "err")
				alert("Error Saving");
				else
				$("#bingo_box").html(msg);
			}
			});
	
	
	
	
	}
	
function getplayerinfo(){	
$.ajax({
			
			type: "GET",
			url: "bingo.php?a=1",
			beforeSend: function(){
			$("#message_box").append("Loading Player Name");
			},
			success: function(msg)
			{

				if(msg == "err")
				alert("Error Saving");
				else{
				info=msg.split("###");
				$("#pname").html(info[0]);
				$("#gameid").html("GAME ID:"+info[1]);
			}
			}
			});
	
	
	
	
	}

function checkvictory(){	
$.ajax({
			
			type: "GET",
			url: "bingo.php?a=0",
			beforeSend: function(){
			$("#message_box").html("Loading BINGO status");
			},
			success: function(msg)
			{

				if(msg == "err")
				alert("Error Saving");
				if(msg == "BINGO"){
				clearInterval(refreshturn);
				clearInterval(refreshboard);
				$("#bingo_stat").html(msg);
				
			}
				else
				$("#bingo_stat").html(msg);
			}
			});
	
	
	
	
	}
function drawcolors(){
	$.ajax({
			
			type: "GET",
			url: "bingo.php?a=3",
			beforeSend: function(){
			$("#message_box").html("Loading Colors");
			},
			success: function(msg)
			{

				if(msg == "err")
				alert("Error Loading Colors...Please Refresh the page");
				else
				//alert("recived from php :checked list:"+msg);
				var cliked_arr = msg.split(',');
				for(var i=0;i<cliked_arr.length-1;i++){
					//alert("adding colors for clicked things:now:"+cliked_arr[i]+"class:player"+(i%2));
					$("#"+cliked_arr[i]).removeClass("clik");
					$("#"+cliked_arr[i]).addClass("player"+(i%2));
				}
				var arr = msg.split(',');
				for(var i=1;i<26;i++){	
					if(arr.indexOf(i.toString())==-1){
						$("#"+i).addClass("clik");
						$("#"+i).click(function() {
								board_check(this.id);
							})
					}
				$("#message_box").html("");
					//else
					//alert("Not adding for"+i);
				}
			}
			});
			
			
			
	}
	
function updateboard(msg){
	//alert(msg);
	arr=msg.split(",");
	for(i=0;i<arr.length-1;i++){
		//alert("updating colors for clicked things:now:"+arr[i]+"class:player"+(i%2));
		$("#"+arr[i]).removeClass("clik");
		$("#"+arr[i]).addClass("player"+(i%2));
	}
	return(0);
	}


function board_check(num){
	$.ajax({
			
			type: "GET",
			url: "bingo.php?a=4&num="+num,
			beforeSend: function(){
			$("#"+num).unbind();
			$("#message_box").html("Checking"+num);
			},
			success: function(msg)
			{

				if(msg == "OtherP"){
				$("#message_box").html("It is other Players Turn! Please Wait");
				$("#"+num).click(function() {
								board_check(this.id);
				})
				
			}
				else{
				$("#message_box").html("Clicked "+num);	
				checkvictory();
				updateboard(msg);
				}
			}
			});
	
	
	}

function checkturn(){	
$.ajax({
			
			type: "GET",
			url: "bingo.php?a=5",
			beforeSend: function(){
			},
			success: function(msg)
			{
				if(msg == "ONE"){
				$("#turn_box").html("<b>You Are Alone in the game!Give the GAME ID to your Friend to Join</b>");
			
			}else{			
				$("#turn_box").html("It is "+msg+"'s turn");
			}
			}
			});
}

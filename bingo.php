<?php
/*
 *      bingo.php
 *      
 *      Copyright 2010 Srihari <srih4ri@gmail.com>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
session_start();
include 'dbconfig.php';
if(!isset($_SESSION['game_id'])||!isset($_SESSION['bingo'])){
	echo("<div class=\"err\">You Do Not have a Valid Game<a href=\"index.php\">Create/Join</a></div>");
	exit();
	}
$r=mysql_fetch_array(mysql_query("SELECT player_list,winner FROM bingo_game WHERE game_id = '".$_SESSION['game_id']."'"));
if($r['winner']!='-1'){
	//someone won
	$p=explode(",",$r['player_list']);
	echo "<div class=\"vict\">".$p[$r['winner']]." has Won!</div>";
	exit();
	}

else{

$a=$_GET['a'];
$bingo=$_SESSION['bingo'];
switch ($a) {
	case 0: 
	$r=mysql_fetch_array(mysql_query("SELECT checked_list FROM bingo_game WHERE game_id = '".$_SESSION['game_id']."'"));
	$checked_list=$r['checked_list'];
	$winstat=(checkwin($bingo,$checked_list,1));
	
	if($winstat=="BINGO"){
		$q="UPDATE bingo_game SET winner = '".$_SESSION['player']."' WHERE game_id = '".$_SESSION['game_id']."'";
		
		mysql_query($q);
		}
	echo $winstat;
	break;
	 
	 
	case  1:
	echo $_SESSION['username']."###".$_SESSION['game_id'];
	break;
	
	
	case 2:
	for ($i=0;$i<5;$i++){
		for($j=0;$j<5;$j++){
		$msg="<div id=\"".$bingo[$i][$j]."\" class=\"square\">".$bingo[$i][$j]."</div>";
		echo $msg;
		}
	}
	break;
	
	case 3:
	$r=mysql_fetch_array(mysql_query("SELECT checked_list FROM bingo_game WHERE game_id = '".$_SESSION['game_id']."'"));
	$checked_list=$r['checked_list'];
	echo $checked_list;
	break;
	
	
	
	
	
	case 4:
	
	$r=mysql_fetch_array(mysql_query("SELECT checked_list FROM bingo_game WHERE game_id = '".$_SESSION['game_id']."'"));
	$checked_list=$r['checked_list'];
	if((substr_count($checked_list,","))%2==$_SESSION['player']){
	$checked_list.=$_GET['num'].",";
	$q="UPDATE bingo_game SET checked_list='".$checked_list."' WHERE game_id='".$_SESSION['game_id']."'";
	mysql_query($q);
	echo $checked_list;
}else{
	echo "OtherP";}
	break;
	
	case 5:
	$r=mysql_fetch_array(mysql_query("SELECT player_list,checked_list FROM bingo_game WHERE game_id = '".$_SESSION['game_id']."'"));
	$checked_list=$r['checked_list'];
	$p=explode(",",$r['player_list']);
	if(count($p)==1){ echo "ONE";}
	else{ echo $p[(substr_count($checked_list,","))%2];}
	break;
}




}//end else of session check
function checkwin($board,$filled_list,$player){
	$filled_list="0,".$filled_list;
	$filled=explode(",",$filled_list);
	for ($i=0;$i<5;$i++){
		for($j=0;$j<5;$j++){
			if((array_search($board[$i][$j],$filled))){
				$checked_box[$i][$j]=1;
			}
			else{
				$checked_box[$i][$j]=0;
			}
		}
	}
for($i = 0;$i<5;$i++){
	//check the diagonal
	if($checked_box[$i][$i]==1){$diag_check++;}
	//check anti diagonal
	if($checked_box[$i][4-$i]==1){$adiag_check++;}
	for($j = 0;$j<5;$j++){
		if($checked_box[$i][$j]==1){
			$row_check[$i]++;
			$col_check[$j]++;
		}
	}
}

//check for full rows and cols
$dashed=0;
for($i = 0;$i<5;$i++){
	if($col_check[$i]>4){
		$dashed++;
		}
	}
	for($i = 0;$i<5;$i++){
	if($row_check[$i]>4){
		$dashed++;
	}
	}
	
if($diag_check>4){$dashed++;}
if($adiag_check>4){$dashed++;}		
return(substr("BINGO",0,$dashed));

		
}

?>
